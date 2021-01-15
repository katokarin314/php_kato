<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Items Model
 *
 * @property \App\Model\Table\PurchasesTable&\Cake\ORM\Association\HasMany $Purchases
 *
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Purchases', [
            'foreignKey' => 'item_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
        ->scalar('name')
        ->maxLength('name', 30,'文字数が超過しています')      //100字以上の入力を認めない
        ->requirePresence('name', 'create')
        ->notEmptyString('name',[
            'message' => '氏名を入力してください'])            //NULLを認めない
        ->add('name', 'custom', [
            'rule' => function ($value) {
                if (preg_match('/[0-9a-zA-Z]/', $value)) {   //半角英数の入力を認めない
                    return '不正な値です';
                }
                elseif(mb_ereg('^(\s|　)+$', $value)){       //半角全角スペースのみの入力を認めない
                    return '不正な値です';   
                }
                else{return true;}
            }]);

        $validator
            ->integer('price')
            ->requirePresence('price', 'create',[
                'message' => '数字で入力してください'])
            ->notEmptyString('price',[
                'message' => '数字で入力してください']);

        $validator
            ->integer('stock')
            ->requirePresence('stock', 'create')
            ->notEmptyString('stock');

        $validator
            ->integer('sales')
            ->requirePresence('sales', 'create')
            ->notEmptyString('sales');
   
        return $validator;
    }
}
