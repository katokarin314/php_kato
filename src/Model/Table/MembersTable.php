<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Members Model
 *
 * @property \App\Model\Table\PurchasesTable&\Cake\ORM\Association\HasMany $Purchases
 *
 * @method \App\Model\Entity\Member get($primaryKey, $options = [])
 * @method \App\Model\Entity\Member newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Member[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Member|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Member saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Member patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Member[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Member findOrCreate($search, callable $callback = null, $options = [])
 */
class MembersTable extends Table
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

        $this->setTable('members');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->hasMany('Purchases');
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
            ->maxLength('name', 100,'文字数が超過しています')      //100字以上の入力を認めない
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
            ->date('birthday')
            ->requirePresence('birthday', 'create')
            ->notEmptyDate('birthday');

        $validator
            ->scalar('address')
            ->maxLength('address', 255,'文字数が超過しています')    //255字以上の入力を認めない
            ->requirePresence('address', 'create')
            ->notEmptyString('address',[
                'message' => '住所を入力してください'])             //NULLを認めない 
            ->add('address', 'custom', [
                'rule' => function ($value) {
                    if (mb_ereg('^(\s|　)+$', $value)){           //半角全角スペースのみの入力を認めない
                        return '不正な値です';   
                    }
                    else{return true;}
                }]);

        $validator
            ->date('admission')
            ->requirePresence('admission', 'create')
            ->notEmptyDate('admission');

        $validator
            ->date('withdrawal')
            ->allowEmptyDate('withdrawal');

        return $validator;
    }
}
