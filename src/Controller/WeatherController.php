<?php

namespace App\Controller;

use App\Entity\Mesure;
use App\Entity\Piscine;
use App\Entity\Weather;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherController extends AbstractController
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/weather", name="weather")
     */
    public function index(): Response
    {
        return $this->render('weather/index.html.twig', [
            'controller_name' => 'WeatherController',
        ]);
    }

    public function weatherUpdate(Piscine $piscine)
    {
        return $this->update($piscine, null);
    }

    /**
     * @Route("/weather/update/{id}", name="weather_update")
     * @param Piscine $piscine
     * @param Mesure|null $mesure
     * @return Response
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function weatherUpdateAction(Piscine $piscine, Mesure $mesure = null)
    {
        $this->update($piscine, $mesure);

        return new Response('ok', 201);
    }

    /**
     * @param Piscine $piscine
     * @param Mesure|null $mesure
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    private function update(Piscine $piscine, ?Mesure $mesure): ?Weather
    {
        $actionURL = 'http://api.openweathermap.org/data/2.5/weather';
        $response = $this->client->request(
            'GET',
            $actionURL,
            [
                'query' => [
                    'appid' => $piscine->getWeatherAPIKey(),
                    'units' => 'metric',
                    'q' => $piscine->getVille()
                ],
                'verify_peer' => false
            ]
        );

        $content = $response->toArray();
        if (key_exists('weather', $content)) {
            $weather = new Weather();
            $weather->setTemperature($content["main"]["temp"]);
            $weather->setFeelTemperature($content["main"]["feels_like"]);
            $weather->setTemperatureMin($content["main"]["temp_min"]);
            $weather->setTemperatureMax($content["main"]["temp_max"]);
            $weather->setPression($content["main"]["pressure"]);
            $weather->setHumidity($content["main"]["humidity"]);
            $weather->setWindSpeed($content["wind"]["speed"]);
            $weather->setWindDirection($content["wind"]["deg"]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($weather);
            if ($mesure) {
                $mesure->setWeatherCondition($weather);
                $em->persist($mesure);
            }
            $em->flush();

            return $weather;
        }

        return null;
    }
}
