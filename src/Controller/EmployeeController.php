<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Employee Controller
 *
 * @property \App\Model\Table\EmployeeTable $Employee
 *
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeController extends AppController
{

    public $paginate = [
		'limit' => 20                                       //1ページに表示するデータ件数
	];
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('employee');        //レイアウト読み込み
        $errors = null;                                     //変数の初期化
        $number = null;                                     //変数の初期化
        $employee = $this->Employee                         //変数$employeeに代入
            ->find('all')                                   //従業員情報全件取得
            ->contain('PositionName');                      //関連テーブルとつなげる
        $all = $employee->count();                          //全従業員数カウント
        if($this->request->is('post')){                     //リクエストがきた場合
            $name = $this->request->data['name'];           //変数$nameにフォームに入力された文字を代入
            if(empty($name)){                               //フォームに何も入力されないまま検索ボタンを押した場合
                $errors = "入力してください";               //変数$errorsにコメントを入れる
            }
            else{$employee = $this->Employee               //フォームに何か入力されていた場合
                ->find()
                ->where(["name like"=> '%' . $name . '%']) //検索条件(部分一致)
                ->contain('PositionName');                 //関連テーブル とつなげる 
                $number = $employee->count();              //検索結果の件数をカウント
            }                      
            if($employee->isEmpty()){                      //検索した結果がNULL(該当者なし)の場合
                $errors = "該当者はいません";               //変数$errorsにコメントを入れる
            }
        }
        $this->set('Employee', $this->paginate($employee));   
        $this->set('Number', $number);
        $this->set('All', $all);
        $this->set('Error',$errors); 
    }

    public function add()
    {
        $this->viewBuilder()->setLayout('employee');                                //レイアウト読み込み
        $errors = null;                                                             //変数の初期化
        $entity = null;                                                             //変数の初期化
        $table = $this->loadModel('PositionName');                                  //役職名テーブルの読み込み
        $posi_list = $table->find('list' , ['valueField' => 'position_name']);      //役職名リストを作成
        $this->set('list', $posi_list);
            if ($this->request->is('post')){                                        //リクエストがきた場合
                $new_data = $this->request->getData('Employee');                    //変数$new_dataにフォームに入力されたリクエストを取得
                $entity = $this->Employee->newEntity($new_data);                    //従業員テーブルに新規登録
                $this->Employee->save($entity);
                $this->set(compact('entity'));
                if(!$entity->errors()) {
                    return $this->redirect(['action'=>'success']);
                }                                    
            }  
            $this->set(compact('entity'));
    }
    public function success()
    {
        $this->viewBuilder()->setLayout('employee');    
    }
}
