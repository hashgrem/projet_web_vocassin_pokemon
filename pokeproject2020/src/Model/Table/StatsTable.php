<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Stats Model
 *
 * @property \App\Model\Table\PokemonStatsTable&\Cake\ORM\Association\HasMany $PokemonStats
 *
 * @method \App\Model\Entity\Stat newEmptyEntity()
 * @method \App\Model\Entity\Stat newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Stat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Stat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Stat findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Stat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Stat[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Stat|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Stat saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Stat[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Stat[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Stat[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Stat[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatsTable extends Table
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

        $this->setTable('stats');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('PokemonStats', [
            'foreignKey' => 'stat_id',
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
     * @return \App\Model\Entity\Stat
     */
    public function formatDataForSave($pokeApiData)
    {
        return $this->findOrCreate([
            'name' => $pokeApiData['name'],
        ]);
    }
}
