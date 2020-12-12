<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pokemon Entity
 *
 * @property int $id
 * @property string $name
 * @property int $height
 * @property int $weight
 * @property string $default_front_sprite_url
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\PokemonStat[] $pokemon_stats
 * @property \App\Model\Entity\PokemonType[] $pokemon_types
 */
class Pokemon extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];


    /**
     * Undocumented function
     *
     * @return string
     */
    protected function _getMainSprite()
    {
        return $this->default_front_sprite_url ? $this->default_front_sprite_url : 'unknown.png';
    }

    /**
     * Return the first type for a pokemon
     *
     * @return string
     */
    protected function _getFirstType()
    {
        if (isset($this->pokemon_types) && !empty($this->pokemon_types)) {
            return collection($this->pokemon_types)
                ->extract('type.name')
                ->first();
        }

        return 'normal';
    }

    /**
     * Return the first type for a pokemon
     *
     * @return string
     */
    protected function _getSecondType()
    {
        if (isset($this->pokemon_types) && !empty($this->pokemon_types)) {
            return collection($this->pokemon_types)
                ->extract('type.name')
                ->skip(1)
                ->first();
        }

        return 'normal';
    }

    protected function _getHasSecondType()
    {
        if (isset($this->pokemon_types) && !empty($this->pokemon_types)) {
            return collection($this->pokemon_types)->count() > 1;
        }

        return false;
    }
}
