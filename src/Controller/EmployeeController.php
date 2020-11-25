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
		'limit' => 20                               // 1ページに表示するデータ件数
	];
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Employee');               //Employeeテーブルの読み込み
        $this->loadModel('PositionName');           //PositionNameテーブルの読み込み
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->viewBuilder()->setLayout('employee');    //レイアウト読み込み
        $errors = null;                                 //変数の初期化
        $number = "  ";                                 //変数の初期化
        $employee = $this->Employee                     //従業員情報全件取得
            ->find('all')
            ->contain('PositionName');                  //関連テーブル
        $all = $employee->count();                      //全従業員数
        if($this->request->is('post')){                 //リクエストがきた場合
            $name = $this->request->data['name'];       //変数$nameに入れる
            if(empty($name)){                           //フォームに何も入力されないまま検索ボタンを押した場合
                $errors = "入力してください";            //変数$errorsにコメントを入れる
            }
            else{$employee = $this->Employee
                ->find()
                ->where(["name like"=> '%' . $name . '%']) //検索条件
                ->contain('PositionName');                 //関連テーブル  
                $number = $employee->count();              //変数$numberに検索結果の件数を入れる
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
}
