<?php

namespace App\Controller;

use App\Entity\Piscine;
use App\Entity\Programme;
use App\Entity\ProgramSelection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $mesureRepo = $this->getDoctrine()->getManager()->getRepository('App:Piscine');
        $piscineList = $mesureRepo->findAll();

        //TODO We should build here a page where we see list of all pools (piscine)
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'piscineList' => $piscineList
        ]);
    }

    /**
     * @Route("/piscine/{id}/alertTest")
     */
    public function alertTestAction(ChatterInterface $chatter)
    {
        $message = (new ChatMessage('You got a new invoice for 15 EUR.'))
            // if not set explicitly, the message is send to the
            // default transport (the first one configured)
            ->transport('telegram');

        $sentMessage = $chatter->send($message);
    }

    /**
     * @Route("/piscine/{id}")
     * @param Piscine $piscine
     * @return Response
     */
    public function piscineAction(Piscine $piscine)
    {
        // Get latest pool temperature
        $poolTemperature = $this->getMesure($piscine);

        // Check if we should update pump program according to temperature
        $programSelection = $this->defineProgramAction($piscine);

        // Fetch the current pump status
        $currentPumpStatus = $this->getCurrentPumpStatus($piscine);

        // Figure out if pump should be on or off
        if ($programSelection) {
            $shouldbeOn = $this->shouldPumpBeOn($programSelection->getProgram(), $poolTemperature->getTemperature());
        }
        else {
            $shouldbeOn = false;
        }

        sleep(5);

        if ($currentPumpStatus != $shouldbeOn) {
            if ($currentPumpStatus) {
                $this->piscinePumpToState($piscine, 'off');
            }
            else {
                $this->piscinePumpToState($piscine, 'on');
            }
        }

        return $this->render("default/index.html.twig", [
            'piscine' => $piscine,
            'poolTemperature' => $poolTemperature,
            'programSelection' => $programSelection,
            'currentPumpStatus' => $currentPumpStatus,
            'shouldbeOn' => $shouldbeOn
        ]);
    }

    public function piscinePumpToState(Piscine $piscine, $targetStatus = 'off')
    {
        $actionSubURL = '/device/relay/control';

        $formFields = [
            'auth_key' => $piscine->getCloudKey(),
            'id' => $piscine->getDeviceId(),
            'turn' => $targetStatus,
            'channel' => '0'
        ];
        $formData = new FormDataPart($formFields);

        $response = $this->client->request(
            'POST',
            $piscine->getCloudServer().$actionSubURL,
            [
                'headers' => $formData->getPreparedHeaders()->toArray(),
                'body' => $formData->bodyToIterable(),
                'verify_peer' => false,
                'verify_host' => false
            ]
        );

        $content = $response->toArray();
        if (key_exists('isok', $content)) {
            if ($content['isok'] == false) {
                // TODO Handle Error
            }
        }
    }

    public function getCurrentPumpStatus(Piscine $piscine)
    {
        $actionSubURL = '/device/status';
        $response = $this->client->request(
            'GET',
            $piscine->getCloudServer().$actionSubURL,
            [
                'query' => [
                    'auth_key' => $piscine->getCloudKey(),
                    'id' => $piscine->getDeviceId()
                ],
                'verify_peer' => false
            ]
        );

        $status = 'unknown';
        $content = $response->toArray();
        if (key_exists('isok', $content)) {
            if ($content['isok'] == false) {
                // TODO Handle Error
            } else {
                $status = $content["data"]["device_status"]["relays"][0]["ison"];
            }
        }

        return $status;
    }

    /**
     * @param Piscine $piscine
     * @Route ("/piscine/defineProgram/{id}")
     */
    public function defineProgramAction(Piscine $piscine)
    {
        $temperature = $this->getMesure($piscine)->getTemperature();
        $em = $this->getDoctrine()->getManager();
        $programSelector = $em->getRepository('App:ProgramSelection')->findOneBy(array('piscine' => $piscine));
        $programList = $em->getRepository('App:Programme')->findAll();

        if ($programSelector) {
            /*if ($programSelector->getForced() and $programSelector->getForceUntil() > new \DateTime()) {

            }*/

            $difference = $programSelector->getSelectionDate()->diff(new \DateTime());
            if ($difference->h > 24 or $difference->d > 0 or $difference->m > 0) {
                if ($temperature < 10) {
                    $programSelector->setProgram($programList[1]);
                } elseif ($temperature < 12) {
                    $programSelector->setProgram($programList[2]);
                } elseif ($temperature < 16) {
                    $programSelector->setProgram($programList[3]);
                } elseif ($temperature < 24) {
                    $programSelector->setProgram($programList[4]);
                } elseif ($temperature < 27) {
                    $programSelector->setProgram($programList[5]);
                } elseif ($temperature < 30) {
                    $programSelector->setProgram($programList[6]);
                } else {
                    $programSelector->setProgram($programList[7]);
                }

                $programSelector->setSelectionDate(new \DateTime());
                $em->persist($programSelector);
                $em->flush();
                return $programSelector;
            }

            return $programSelector;

        }
        else {
            $programSelector = new ProgramSelection();
            $programSelector->setPiscine($piscine);
            $programSelector->setSelectionDate(new \DateTime());
            $programSelector->setForced(false);
            $em->persist($programSelector);
            $em->flush();
            $this->defineProgramAction($piscine);

            return $programSelector;
        }
    }

    /**
     * @param Piscine $piscine
     * @return \App\Entity\Mesure|object|null
     */
    protected function getMesure(Piscine $piscine)
    {
        // find Latest Mesure for a Pool
        $poolTemperature = $this->getDoctrine()->getManager()->getRepository('App:Mesure')->findOneBy(array(
            'piscine' => $piscine,
            'valid' => true
        ), array('date' => 'DESC')
        );
        return $poolTemperature;
    }

    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    private function shouldPumpBeOn(Programme $program, $poolTemperature)
    {
        if ($poolTemperature<= 1) {
            return true;
        }

        $currentTime = (new \DateTime('now'))->format('H:i');

        $start1 = $program->getStartTime1();
        if ($start1) {
            $start1 = $program->getStartTime1()->format('H:i');
        }

        $stop1 = $program->getStopTime1();
        if ($stop1) {
            $stop1 = $program->getStopTime1()->format('H:i');
        }

        $start2 = $program->getStartTime2();
        if ($start2) {
            $start2 = $program->getStartTime2()->format('H:i');
        }

        $stop2 = $program->getStopTime2();
        if ($stop2) {
            $stop2 = $program->getStopTime2()->format('H:i');
        }

        $start3 = $program->getStartTime3();
        if ($start3) {
            $start3 = $program->getStartTime3()->format('H:i');
        }

        $stop3 = $program->getStopTime3();
        if ($stop3) {
            $stop3 = $program->getStopTime3()->format('H:i');
        }

        $start4 = $program->getStartTime4();
        if ($start4) {
            $start4 = $program->getStartTime4()->format('H:i');
        }

        $stop4 = $program->getStopTime4();
        if ($stop4) {
            $stop4 = $program->getStopTime4()->format('H:i');
        }

        if (
            ($currentTime >= $start1 && $currentTime <= $stop1) or
            ($currentTime >= $start2 && $currentTime <= $stop2) or
            ($currentTime >= $start3 && $currentTime <= $stop3) or
            ($currentTime >= $start4 && $currentTime <= $stop4)
        ) {
            return true;
        }

        return false;
    }
}
