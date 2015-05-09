<?php

namespace App\Marvel;

use Rumpel\MarvelUniverse\SuperheroApi;

class Characters
{

    /**
     * @var SuperheroApi
     */
    private $superheroApi;

    /**
     */
    public function __construct()
    {
        $publicKey = env('MARVEL_PUBLIC_KEY');
        $privateKey = env('MARVEL_PRIVATE_KEY');
        $this->superheroApi = new SuperheroApi($publicKey, $privateKey);
    }

    public function findById($id, array $characters)
    {
        $characters = collect($characters);
        return $characters->filter(function($character) use ($id) {
            if($character['id'] == $id)
                return true;
        })->first();

    }

    public function all($filters)
    {
        return $this->superheroApi->getAllCharacters($filters);
    }

    public function random($count, array $characters)
    {
        $charactersCollection = collect($characters);

        return $charactersCollection->random($count);
    }

    /**
     * Get random opponents from array
     * @param $charactersInGame
     * @return mixed
     */
    public function getOpponents(array $charactersInGame)
    {
        $characterCollection = collect($charactersInGame);

        return $characterCollection->random(2);
    }

    /**
     * Remove character with specific id from array
     * @param array $charactersInGame
     * @param array $idsToDelete
     * @return static
     */
    public function removeIds(array $charactersInGame, array $idsToDelete)
    {
        $characterCollection = collect($charactersInGame);

        $characterCollection->lists('id');

        return $characterCollection->filter(function ($character) use ($idsToDelete) {
            if (!in_array($character['id'], $idsToDelete)) {
                return true;
            }

        })->toArray();

    }

    /**
     * Remove characters where is no image
     * @param $charactersInGame
     * @return array
     */
    public function removeCharactersWithoutImage(array $charactersInGame)
    {
        $characters = collect($charactersInGame);

        $characters = $characters->filter(function ($character) {

            if ($character['thumbnail']['path'] != 'http://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available') {
                return true;
            }
        });

        return $characters->toArray();
    }
}