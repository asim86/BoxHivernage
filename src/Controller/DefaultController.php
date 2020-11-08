<?php

namespace App\Controller;

use App\Entity\Piscine;
use App\Entity\ProgramSelection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

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
     * @Route("/piscine/{id}")
     * @param Piscine $piscine
     * @return Response
     */
    public function piscineAction(Piscine $piscine)
    {
        $poolTemperature = $this->getMesure($piscine);

        return $this->render("default/index.html.twig", [
            'piscine' => $piscine,
            'poolTemperature' => $poolTemperature
        ]);
    }

    public function piscinePumpStart(Piscine $piscine)
    {

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

            $difference = $programSelector->getSelectionDate()->diff(new \DateTime());
            if ($difference->h > 24 or $difference->d > 0) {
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
                return $this->json(['result' => 'OK', 'ignore' => 'false', 'program' => $programSelector->getProgram()->getName()]);
            }

            return $this->json(['result' => 'OK', 'ignore' => 'true']);

        }
        else {
            $programSelector = new ProgramSelection();
            $programSelector->setPiscine($piscine);
            $programSelector->setSelectionDate(new \DateTime());
            $programSelector->setForced(false);
            $em->persist($programSelector);
            $em->flush();
            $this->defineProgramAction($piscine);
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
            'piscine' => $piscine
        ), array('date' => 'DESC')
        );
        return $poolTemperature;
    }
}
