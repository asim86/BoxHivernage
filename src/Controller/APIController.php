<?php

namespace App\Controller;

use App\Entity\Mesure;
use App\Repository\MesureRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @Route("/api", name="api_")
 */
class APIController extends AbstractController
{
    /**
     * @Route("/mesure/liste", name="liste", methods={"GET"})
     */
    public function liste(MesureRepository $mesureRepository)
    {
        $mesure = $mesureRepository->findAll();

        // On spécifie qu'on utilise l'encodeur JSON
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($mesure, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;
    }

    /**
     * @Route("/mesure/add", name="ajout", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function addMesure(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //Verification de la cle API
        $providedKey = $request->query->get('apiKey');
        if ($providedKey != null) {
            $piscine = $em->getRepository('App:Piscine')->findOneBy(array(
                'apiKey' => $providedKey
            ));

            if ($piscine != null) {

                $temperature = $request->query->get('temp');
                $pH = $request->query->get('pH');
                $valid = true;

                if ($temperature != null) {

                    if ($temperature < -50 or $temperature > 50) {
                        $valid = false;
                    }
                    $mesure = new Mesure();
                    $mesure->setDate(new DateTime());
                    $mesure->setPiscine($piscine);
                    $mesure->setTemperature($temperature);
                    $mesure->setValid($valid);
                    $em->persist($mesure);
                    $em->flush();

                    return $this->forward('App\Controller\WeatherController:weatherUpdateAction', [
                        'piscine' => $piscine,
                        'mesure' => $mesure
                    ]);

                  //  return new Response('ok', 201);
                }

                if ($pH != null) {
                    $mesure = new Mesure();
                    $mesure->setDate(new DateTime());
                    $mesure->setPiscine($piscine);
                    $mesure->setRawPH($pH);
                    $mesure->setValid($valid);
                    $a = 0.1101;
                    $b = -16.87;
                    $pH = $a * floatval(floatval(substr($pH, 2))) + $b;
                    $mesure->setPH($pH);
                    $em->persist($mesure);
                    $em->flush();
                    return new Response('ok', 201);
                }
                return new Response('Failed', 404);
            }
        }

        return new Response('Failed', 404);
    }
}
