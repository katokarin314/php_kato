<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Member Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\FrozenDate $birthday
 * @property string $address
 * @property \Cake\I18n\FrozenDate $admission
 * @property \Cake\I18n\FrozenDate|null $exit
 *
 * @property \App\Model\Entity\Purchase[] $purchases
 */
class Member extends Entity
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
        'id' => true,
        'name' => true,
        'birthday' => true,
        'address' => true,
        'admission' => true,
        'exit' => true,
        'purchases' => true,
    ];
}
