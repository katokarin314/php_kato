<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Purchase Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $member_id
 * @property int $quantity
 * @property \Cake\I18n\FrozenDate $purchase_date
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Member $member
 */
class Purchase extends Entity
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
        'item_id' => true,
        'member_id' => true,
        'quantity' => true,
        'purchase_date' => true,
        'item' => true,
        'member' => true,
    ];
}
