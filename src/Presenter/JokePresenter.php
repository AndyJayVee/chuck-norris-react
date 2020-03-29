<?php


namespace App\Presenter;


class JokePresenter
{
    /**
     * @param $object
     * @return array
     */
    public function single($object): array
    {
        return [
            'id' => $object->getId(),
            'joke_id' => $object->getJokeId(),
            'joke' => $object->getJoke(),
        ];
    }
}