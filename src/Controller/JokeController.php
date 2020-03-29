<?php


namespace App\Controller;

use App\Entity\FavoriteJoke;
use App\HttpClient\JokeHttpClient;
use App\Repository\FavoriteJokeRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * @Route("/api")
 */
class JokeController
{
    /**
     * @var FavoriteJokeRepository
     */
    private $repository;

    /**
     * @var JokeHttpClient
     */
    private $httpClient;

    /**
     * @param FavoriteJokeRepository $repository
     */
    public function __construct(
        FavoriteJokeRepository $repository
    ){
        $this->repository = $repository;
        $this->httpClient = new JokeHttpClient;
    }

    /**
     * @Route("/save/{joke_id}", methods={"GET"}) //TODO: change back to PUT, research client side
     * @param int $joke_id
     * @return JsonResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function saveJokeToFavorites(int $joke_id)
    {
        $criteria = ['joke_id' => ''];
        $amountFavoriteJokes = $this->repository->favoriteJokesAmount($criteria);
        $statusCode = 200;

        if ($this->repository->find($joke_id)) {
            $result = ['value' => 'joke is already favorite'];
            $statusCode = 409;
        } else if ($amountFavoriteJokes == FavoriteJoke::MAXIMUM_AMOUNT_FAVORITES) {
            $result = ['value' => 'maximum amount of favorite jokes reached'];
            $statusCode = 422;
        } else {
            $joke = new FavoriteJoke;
            $joke->setJokeId($joke_id);
            $joke->setJoke("test");
            $this->repository->save($joke);
            $result = ['value' => 'joke saved'];
        }
        $response = new Response;
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent(json_encode($result));
        $response->setStatusCode($statusCode);
        return $response;
    }

    /**
     * @Route("/remove/{joke_id}", methods={"GET"})//TODO: change back to DELETE, research client side
     * @param int $joke_id
     * @return Response
     */
    public function removeJokeFromFavorites(int $joke_id)
    {
        $statusCode = "200";
        $joke = $this->repository->find($joke_id);
        if (!$joke) {
            $result = ['value' => 'joke is not a favorite'];
            $statusCode = "404";
        } else {
            $this->repository->remove($joke);
            $result = ['value' => 'joke removed'];
        }
        $response = new Response;
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setStatusCode($statusCode);
        $response->setContent(json_encode($result));
        return $response;
    }

    /**
     * @Route("/favorites", methods={"GET"})
     * @return JsonResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function listFavorites()
    {
        $jokes = $this->repository->findAll();
        $favoriteJokes = array();
        foreach ($jokes as $joke) {
            $joke = $this->httpClient->getSingleJoke($joke->getJokeId());
            $favoriteJokes[] = $joke;
        }
        $response = new Response;
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent(json_encode($favoriteJokes));

        return $response;
    }
}