<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Pokemons Controller
 *
 * @property \App\Model\Table\PokemonsTable $Pokemons
 * @method \App\Model\Entity\Pokemon[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PokemonsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'limit' => 30,
        ];

        $pokemons = $this->Pokemons->find('all')->contain(['PokemonStats.Stats', 'PokemonTypes.Types']);
        $pokemons = $this->paginate($pokemons);

        $this->set(compact('pokemons'));
    }

    /**
     * View method
     *
     * @param string|null $id Pokemon id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pokemon = $this->Pokemons->get($id, [
            'contain' => ['PokemonStats.Stats', 'PokemonTypes.Types'],
        ]);

        $this->set(compact('pokemon'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pokemon id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pokemon = $this->Pokemons->get($id);
        if ($this->Pokemons->delete($pokemon)) {
            $this->Flash->success(__('The pokemon has been deleted.'));
        } else {
            $this->Flash->error(__('The pokemon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Statistiques method
     *
     * @return \Cake\Http\Response|null|void Renders Dashboard.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function tableauDeBord()
    {
// Doc: https://book.cakephp.org/3/fr/orm/query-builder.html

//  Poids moyen des pokemons de la 4ième génération:

        $moy_quatrieme_gene = $this->Pokemons->find(); //Chargement de la table pokemons
        $moy_quatrieme_gene  ->select(["avgWeight"=>"AVG(Weight)"]) // On récupère la moyenne du poids grace a la fonction sql AVG
                             ->where(function ($q2) {
                             return $q2->between('pokedex_number', 387, 493); //4ieme génération uniquement
                        });


// Affichage  Nombre de pokemons de type fée dans les générations 1, 3 et 7

        $nombre_de_fee = $this->Pokemons->find(); //Chargement de la table pokemons
        $nombre_de_fee  ->select(["countFairies"=>"COUNT(Pokemons.id)"]) // On fait la somme des id pour avoir le nombre.
                        ->matching('PokemonTypes.Types', function ($q3)
                         {
                           return $q3->where(['Types.name' => 'fairy']); // On récupère uniquement les pokemons possedant le type fée (fairy)
                         })
                                     ->where(function ($q3) {

                                            return $q3
                                                    ->or(function($or){ // or() va créer un nouvel objet Expression qui combine toutes les conditions qui lui sont ajoutées avec OR
                                                        return $or
                                                            ->between('pokedex_number', 1, 151) //premiere géné
                                                            ->between('pokedex_number', 252, 386) //troisieme géné
                                                            ->between('pokedex_number', 722, 809); // septième géné
                                                    });

                                        });

                                        
// Les 10 premiers pokemons qui possèdent la plus grande vitesse:

        $les_plus_rapides = $this->Pokemons->find();   //Chargement de la table pokemons
        $les_plus_rapides ->select(['name','PokemonStats.value']) // On récupère la valeur (value) de la vitesse (speed)
                          ->matching('PokemonStats.Stats', function ($q) { // 'matching' pour récupérer des données filtrées. + passage d'une fonction en param
                          return $q->where(['Stats.name' => 'speed']);
                 })
                 ->order(['PokemonStats.value' => 'DESC']) //Tri par ordre décroissant.
                 ->limit(10); // On limite a 10 car on veut les 10 premiers pokemons





        $query=array(
            "les_plus_rapides"=>$les_plus_rapides,
            "moy_quatrieme_gene"=>$moy_quatrieme_gene,
            "nombre_de_fee"=>$nombre_de_fee
        );



        $this->set(compact('query')); //compact crée un tableau à partir de variables et de leur valeur
    }

}
