<?php
declare(strict_types=1);

namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Http\Client;

/**
 * PokeApi shell command.
 */
class PokeApiShell extends Shell
{

    /**
     * initialize function
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadModel('Pokemons');
    }

    /**
     * main() method.
     *
     * @return void
     */
    public function main()
    {
        $this->verbose('Loading the 1st generation !');
        $this->_loadGeneration(1, 151);
        $this->verbose('Loading the 2nd generation !');
        $this->_loadGeneration(152, 251);
    }

    /**
     * _loadGeneration function
     *
     * @param [type] $from start pokemon number
     * @param [type] $to end pokemon number
     * @return void
     */
    protected function _loadGeneration($from, $to)
    {
        for ($pokedexNumber = $from; $pokedexNumber <= $to; $pokedexNumber++) {
            $pokeApiData = $this->_getPokemonById($pokedexNumber);
            if (!$this->Pokemons->exists(['pokedex_number' => $pokedexNumber])) {
                $this->_createPokemon($pokeApiData);
            } else {
                $this->verbose("The pokemon {$pokedexNumber} already exist in database");
                $this->_updatePokemon($pokedexNumber, $pokeApiData);
            }
        }
    }

    /**
     * _getPokemonById function
     *
     * @param [type] $number pokemon identifier
     * @return array
     */
    protected function _getPokemonById($number)
    {
        $http = new Client();

        $response = $http->get("https://pokeapi.co/api/v2/pokemon/$number");

        if ($response->isOk()) {
            $pokemon = $response->getJson();

            return $this->Pokemons->formatDataForSave($pokemon);
        } else {
            $this->verbose("Something wrong happen during Api call with Pokemon id : {$number}");
        }
    }

    /**
     * Undocumented function
     *
     * @param array $pokemonFormatedData formated data
     * @return void
     */
    protected function _createPokemon($pokemonFormatedData)
    {
        $pokemon = $this->Pokemons->newEntity($pokemonFormatedData);
        if (!$this->Pokemons->save($pokemon)) {
            $this->verbose('Something wrong happen');
            \Cake\Log\Log::write('error', json_encode($pokemon->getErrors()));
        }
    }

    /**
     * Undocumented function
     *
     * @param int $pokedexNumber pokedex number
     * @param array $pokemonFormatedData formated data
     * @return void
     */
    protected function _updatePokemon($pokedexNumber, $pokemonFormatedData)
    {
        $pokemon = $this->Pokemons->find()
                ->where(['pokedex_number' => $pokedexNumber])
                ->contain([
                    'PokemonStats.Stats',
                    'PokemonTypes.Types',
                ])
                ->first();

        $pokemon = $this->Pokemons->patchEntity($pokemon, $pokemonFormatedData);
        if (!$this->Pokemons->save($pokemon)) {
            $this->verbose('Something wrong happen');
            \Cake\Log\Log::write('error', json_encode($pokemon->getErrors()));
        }
    }
}
