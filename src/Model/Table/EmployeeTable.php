<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employee Model
 *
 * @method \App\Model\Entity\Employee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee findOrCreate($search, callable $callback = null, $options = [])
 */
class EmployeeTable extends Table
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

        $this->setTable('employee');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
        $this->belongsTo('PositionName',[
            'foreignKey'=>'position'
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
            ->integer('id')                                 //数字であること
            ->allowEmptyString('id', null, 'create');       //空を認めず、かつ文字列であること

        $validator
            ->scalar('name')                                //スカラ値であること
            ->maxLength('name', 30,'30字以内にしてください')  //スカラ値が指定した文字数以下であること
            ->requirePresence('name', 'create')             //フィールドに存在することを要求する。nullは許容する
            ->notEmptyString('name','氏名を入力してください') //空を認めず、かつ文字列であること
            ->add('name', 'custom', [
                'rule' => function ($value) {
                    if (preg_match("/[0-9a-zA-Z]/", $value)) {  //半角英数の入力を認めない
                        return '全角のみで入力してください';
                    }
                    elseif(mb_ereg("^(\s|　)+$", $value)){      //半角全角スペースのみの入力を認めない
                        return 'スペースのみの入力は不可です';   
                    }
                    else{return true;}
                }]);

        $validator
            ->integer('position')                           //数字であること
            ->allowEmptyString('position');                 //空を許容し、かつ文字列であること
        return $validator;
    }

   
}
