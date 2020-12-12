<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PokemonStats Model
 *
 * @property \App\Model\Table\PokemonTable&\Cake\ORM\Association\BelongsTo $Pokemons
 * @property \App\Model\Table\StatsTable&\Cake\ORM\Association\BelongsTo $Stats
 *
 * @method \App\Model\Entity\PokemonStat newEmptyEntity()
 * @method \App\Model\Entity\PokemonStat newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PokemonStat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PokemonStat get($primaryKey, $options = [])
 * @method \App\Model\Entity\PokemonStat findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PokemonStat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PokemonStat[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PokemonStat|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PokemonStat saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PokemonStat[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PokemonStat[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PokemonStat[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PokemonStat[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PokemonStatsTable extends Table
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

        $this->setTable('pokemon_stats');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Pokemons', [
            'foreignKey' => 'pokemon_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Stats', [
            'foreignKey' => 'stat_id',
            'joinType' => 'INNER',
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
            ->integer('value')
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['pokemon_id'], 'Pokemons'), ['errorField' => 'pokemon_id']);
        $rules->add($rules->existsIn(['stat_id'], 'Stats'), ['errorField' => 'stat_id']);

        return $rules;
    }

    /**
     * Format Data for save
     *
     * @param array $pokeApiData Data from Poke Api
     * @return array
     */
    public function formatDataForSave($pokeApiData)
    {
        return collection($pokeApiData)
            ->map(function ($stat) {
                $statEntity = $this->Stats->formatDataForSave($stat['stat']);

                return [
                    'value' => $stat['base_stat'],
                    'stat_id' => $statEntity->id,
                    'stat' => $statEntity,
                ];
            })
            ->toArray();
    }
}
