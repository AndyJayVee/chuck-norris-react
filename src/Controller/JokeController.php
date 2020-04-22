<?php


namespace App\Controller;

use App\Entity\FavoriteJoke;
use App\Entity\User;
use App\HttpClient\JokeHttpClient;
use App\Repository\FavoriteJokeRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
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
     * @param UserInterface $user
     * @return JsonResponse
     * @throws ClientExceptionInterface
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function saveJokeToFavorites(int $joke_id, UserInterface $user)
    {
        $criteria = ['joke_id' => '', 'user' => $user];
        $amountFavoriteJokes = $this->repository->favoriteJokesAmount($criteria);
        $statusCode = 200;

        if ($this->repository->findOneBy(['joke_id' => $joke_id, 'user' => $user])) {
            $result = ['value' => 'joke is already favorite'];
            $statusCode = 409;
        } else if ($amountFavoriteJokes == FavoriteJoke::MAXIMUM_AMOUNT_FAVORITES) {
            $result = ['value' => 'maximum amount of favorite jokes reached'];
            $statusCode = 422;
        } else {
            $favoriteJoke = new FavoriteJoke();
            $joke = $this->httpClient->getSingleJoke($joke_id);
            $favoriteJoke->setJokeId($joke['id']);
            $favoriteJoke->setJoke($joke['joke']);
            $favoriteJoke->setUser($user);
            $this->repository->save($favoriteJoke);
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
     * @param UserInterface $user
     * @return Response
     */
    public function removeJokeFromFavorites(int $joke_id, UserInterface $user)
    {
        $statusCode = "200";
        $joke = $this->repository->findOneBy(['joke_id' => $joke_id, 'user' => $user]);
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
     * @param UserInterface $user
     * @return JsonResponse
     */
    public function listFavorites(UserInterface $user)
    {
//        $user = $user->getSelf();
        $jokes = $this->repository->findBy(['user' => $user]);
        $favoriteJokes = array();
        foreach ($jokes as $joke) {
            $favoriteJoke = [
                'joke_id' => $joke->getJokeId(),
                'joke' => $joke->getJoke()
                ]
            ;
            $favoriteJokes[] = $favoriteJoke;
        }
        $response = new Response;
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->setContent(json_encode($favoriteJokes));

        return $response;
    }
}