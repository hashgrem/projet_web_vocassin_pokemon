<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PokemonTypes Model
 *
 * @property \App\Model\Table\PokemonTable&\Cake\ORM\Association\BelongsTo $Pokemons
 * @property \App\Model\Table\TypesTable&\Cake\ORM\Association\BelongsTo $Types
 * @method \App\Model\Entity\PokemonType newEmptyEntity()
 * @method \App\Model\Entity\PokemonType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PokemonType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PokemonType get($primaryKey, $options = [])
 * @method \App\Model\Entity\PokemonType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PokemonType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PokemonType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PokemonType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PokemonType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PokemonType[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PokemonType[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PokemonType[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PokemonType[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PokemonTypesTable extends Table
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

        $this->setTable('pokemon_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pokemons', [
            'foreignKey' => 'pokemon_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Types', [
            'foreignKey' => 'type_id',
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
        $rules->add($rules->existsIn(['type_id'], 'Types'), ['errorField' => 'type_id']);

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
            ->map(function ($type) {
                $typeEntity = $this->Types->formatDataForSave($type['type']);

                return [
                    'type_id' => $typeEntity->id,
                    'type' => $typeEntity,
                ];
            })
            ->toArray();
    }
}
