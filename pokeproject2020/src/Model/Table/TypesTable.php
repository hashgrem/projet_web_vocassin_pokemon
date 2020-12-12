<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Types Model
 *
 * @property \App\Model\Table\PokemonTypesTable&\Cake\ORM\Association\HasMany $PokemonTypes
 *
 * @method \App\Model\Entity\Type newEmptyEntity()
 * @method \App\Model\Entity\Type newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Type[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Type get($primaryKey, $options = [])
 * @method \App\Model\Entity\Type findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Type patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Type[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Type|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Type saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Type[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Type[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Type[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Type[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TypesTable extends Table
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

        $this->setTable('types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('PokemonTypes', [
            'foreignKey' => 'type_id',
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

        return $validator;
    }

    /**
     * Format Data for save
     *
     * @param array $pokeApiData Data from Poke Api
     * @return \App\Model\Entity\Type
     */
    public function formatDataForSave($pokeApiData)
    {
        return $this->findOrCreate([
            'name' => $pokeApiData['name'],
        ]);
    }
}
