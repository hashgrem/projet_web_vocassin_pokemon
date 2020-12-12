<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pokemons Model
 *
 * @property \App\Model\Table\PokemonStatsTable&\Cake\ORM\Association\HasMany $PokemonStats
 * @property \App\Model\Table\PokemonTypesTable&\Cake\ORM\Association\HasMany $PokemonTypes
 *
 * @method \App\Model\Entity\Pokemon newEmptyEntity()
 * @method \App\Model\Entity\Pokemon newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Pokemon[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pokemon get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pokemon findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Pokemon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pokemon[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pokemon|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pokemon saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pokemon[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pokemon[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pokemon[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pokemon[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PokemonsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('pokemons');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('PokemonStats', [
            'foreignKey' => 'pokemon_id',
            'saveStrategy' => 'replace',
        ]);
        $this->hasMany('PokemonTypes', [
            'foreignKey' => 'pokemon_id',
            'saveStrategy' => 'replace',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('height')
            ->requirePresence('height', 'create')
            ->notEmptyString('height');

        $validator
            ->integer('weight')
            ->requirePresence('weight', 'create')
            ->notEmptyString('weight');

        $validator
            ->scalar('default_front_sprite_url')
            ->maxLength('default_front_sprite_url', 255)
            ->requirePresence('default_front_sprite_url', 'create')
            ->notEmptyString('default_front_sprite_url');

        return $validator;
    }

    /**
     * Format Data for save
     *
     * @param array $pokeApiData Data from Poke Api
     * @return array
     */
    public function formatDataForSave($pokeApiData)
    {
        $pokemonStats = $this->PokemonStats->formatDataForSave($pokeApiData['stats']);
        $pokemonTypes = $this->PokemonTypes->formatDataForSave($pokeApiData['types']);

        return [
            'pokedex_number' => $pokeApiData['id'],
            'name' => $pokeApiData['name'],
            'default_front_sprite_url' => $pokeApiData['sprites']['front_default'],
            'height' => $pokeApiData['height'],
            'weight' => $pokeApiData['weight'],
            'pokemon_stats' => $pokemonStats,
            'pokemon_types' => $pokemonTypes,
        ];
    }
}
