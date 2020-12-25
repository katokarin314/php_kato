<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

/**
 * Member Controller
 *
 *
 * @method \App\Model\Entity\Member[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MembersController extends AppController
{
    public $paginate = [
		'limit' => 20                                           //1ページに表示するデータ件数
	];
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {   
        $this->viewBuilder()->setLayout('member');                      //レイアウト読み込み
        $member = $this->Members                                        //変数$memberに代入
        ->find('all')                                    
        ->contain('Purchases');                                         //関連テーブルとつなげる
        $result = $member->toArray();                                   //配列にする
        $now = date('Ymd');                                             //今の時刻
        $this->loadModel('Purchases');                                  //購入履歴モデル読み込み
        $purchas = $this->Purchases                                     //変数$purchasに代入
        ->find('all')  
        ->contain('Items')                                              //関連テーブルとつなげる
        ->contain('Members');                                           //関連テーブルとつなげる
        //商品金額と商品個数をかけたあと、SUMで加算して会員IDごとの購入金額の合計を算出
        $purchas->select([
            'sum' => $purchas->func()->sum('Items.price * Purchases.quantity')       
        ])
        ->group('Purchases.member_id');
        $data = $purchas->toArray();                                    //配列にする
        $key = -1;                                                      //配列を順番にとりだすために-1からスタート
        foreach ($result as $row):   
            $birthday=date('Ymd',  strtotime($row->birthday));          //一行ずつ生年月日を取り出して計算できるようフォーマット
            $birthday=floor(($now-$birthday)/10000) ;                   //年齢計算。余りは切り捨て
            $key++;                                                     //$keyに加算
            $result[$key]['age']=$birthday;                             //配列にキーとバリューを追加(年齢)
            if(empty($data[$key]->sum)){$result[$key]['total'] = 0;}    //購入したものが何もなかったら0
            else{$result[$key]['total'] = $data[$key]->sum;}            //あったら配列にキーとバリューを追加(購入金額合計)
            
        endforeach;
        $this->set('Result', $result); 
        $this->set('Member', $member);   
    }
    /**
     * Data method
     */
    public function data()
    {   
        $this->viewBuilder()->setLayout('member');                      //レイアウト読み込み
            $id = $this->request->data('id');                           //postで送られてきたデータからidだけを取り出す
            //会員情報取得  
            $member = $this->Members                                    //変数$memberに会員テーブル情報を代入
            ->find('all') 
            ->where(["id "=> $id])                                      //postで送られてきたidで絞り込む                                  
            ->contain('Purchases');                                     //関連テーブルとつなげる
            $result = $member->toArray();                               //配列にする
            //個人購入金額の合計を算出
            $this->loadModel('Purchases');                              //購入履歴テーブル読み込み
            $purchas = $this->Purchases                                 //変数$purchasに購入履歴テーブル情報を代入
            ->find('all')
            ->where(["member_id "=> $id])                               //postで送られてきたidで絞り込む
            ->contain('Items') ;                                        //関連テーブルとつなげる   
            //商品金額と商品個数をかけたあと、SUMで加算して購入金額の合計を算出                         
            $purchas->select([
                'sum' => $purchas->func()->sum('Items.price * Purchases.quantity')]);     
            $data = $purchas->toArray();                                //配列にする
            //年齢算出
            $now = date('Ymd');                                         //現在の年月日を計算できるよう数字にのみにフォーマット    
            $birthday=date('Ymd',  strtotime($result[0]->birthday));    //会員の誕生日を計算できるよう数字にのみにフォーマット
            $birthday=floor(($now-$birthday)/10000) ;                   //年齢計算。余りは切り捨て
            $result[0]['age']=$birthday;                                //配列にキーとバリューを追加(年齢)
            //会員レベルわけ
            if(empty($data[0]->sum)){$level = 'ブロンズ';}               //購入したものが何もなかったらブロンズ会員
            else{
                if ($data[0]->sum >= 100000)                            //購入合計金額が100000円以上ならゴールド会員
                    {$level = 'ゴールド';} 
                elseif ($data[0]->sum >= 50000)                         //購入合計金額が50000円以上ならシルバー会員
                    {$level = 'シルバー';}  
                else{$level = 'ブロンズ';}                               //購入合計金額が50000円未満ならブロンズ会員
            ;}
            $result[0]['level'] = $level;                               //配列にキーとバリューを追加(購入金額合計)
            //購入リストを作成    
            $purchas_list = $this->Purchases                            //変数$purchas_listに購入履歴テーブル情報を代入
            ->find('all')                                           
            ->where(["member_id "=> $id])                               //postで送られてきたidで絞り込む  
            ->contain('Items');                                         //関連テーブルとつなげる
            $list = $purchas_list->toArray();                           //配列にする
        $this->set('Result', $result); 
        $this->set('List', $list);      
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('member');              //レイアウト読み込み
        $id = $this->request->data('id');                       //postで送られてきたデータからidだけを取り出す
        $member = $this->Members                                //変数$memberに会員テーブル情報を代入
            ->find('all') 
            ->where(["id "=> $id]); 
        $data = NULL;                                           //postで送られてきたidで絞り込む      
        $result = $member->toArray();                           //配列にする  
        $new_data=NULL;
        if (isset($_POST["add"])) {                             //ボタンネーム「add」が押下されたら
            $new_data = $this->request->getData();              //フォームの内容を取得
            $id = $new_data['Members']['id'];                   //id取得
            $member = $this->Members                            //変数$memberに会員テーブル情報を代入
                    ->find('all') 
                    ->where(["id "=> $id]);                     //postで送られてきたidで絞り込む      
            $result = $member->toArray();                       //配列にする
            $data = NULL; 
            $this->set(compact('data'));
            $this->set('Result',$result);
            $data=$this->Members->get($id);                     //既存データを取得
            $data=$this->Members->patchEntity($data,$new_data); //エンティティをマージ
            $query = $this->Members->save($data) ;              //更新
            if(!$data->errors()){
                return $this->redirect(['action'=>'success']);  //更新完了画面へ遷移
            }
        }
        $this->set(compact('data'));
        $this->set('Result',$result);
    }
    public function success()
    {
        $this->viewBuilder()->setLayout('member');    
    }
    
    /**
     * Delete method
     *
     * @param string|null $id Member id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $this->viewBuilder()->setLayout('member');                  //レイアウト読み込み
        $id = $this->request->data('id');                           //postで送られてきたデータからidだけを取り出す
        $member = $this->Members                                    //変数$memberに会員テーブル情報を代入
            ->find('all') 
            ->where(["id "=> $id]);                                 //postで送られてきたidで絞り込む                                  
        $result = $member->toArray();                               //配列にする
        $errors = null;
        $delete_data=NULL;
        $delete=NULL;
        if (isset($_POST["delete"])) {                              //ボタンネーム「delete」が押下されたら
            $delete_data = $this->request->getData();               //フォームの内容を取得
            $id = $delete_data['Members']['id'];                    //id取得
            $delete=$this->Members->get($id);                       //既存データを取得
            $delete=$this->Members->delete($delete);                //削除
            return $this->redirect(['action'=>'success_delete']);   //削除完了画面へ遷移
        }
        $this->set(compact('delete'));
        $this->set('Result',$result);
    
    }
    public function successDelete()
    {
        $this->viewBuilder()->setLayout('member');    
    }
    public function new()
    {
        $this->viewBuilder()->setLayout('member');                   //レイアウト読み込み
        $errors = null;                                              //変数の初期化
        $data = null;                                                //変数の初期化
        if ($this->request->is('post')){                             //リクエストがきた場合
            $new_data = $this->request->getData();                   //変数$new_dataにフォームに入力されたリクエストを取得
            $data = $this->Members->newEntity($new_data);            //会員テーブルに新規登録
            $this->Members->save($data);
            $this->set(compact('data'));
            if(!$data->errors()) {
                return $this->redirect(['action'=>'success_new']);
            }                                    
        }  
        $this->set(compact('data'));
    }
    public function successNew()
    {
        $this->viewBuilder()->setLayout('member');    
    }
    public function itemList()
    {
        $this->viewBuilder()->setLayout('member');        //レイアウト読み込み
        $this->loadModel('Items');                        //商品テーブル読み込み
        $item = $this->Items                              //変数$itemに代入
        ->find('all') ;                                   //全件取得
        $this->set('Item',$item); 
    }
    public function newItem()
    {
        $this->viewBuilder()->setLayout('member');                   //レイアウト読み込み
        $this->loadModel('Items');                                   //商品テーブル読み込み
        $errors = null;                                              //変数の初期化
        $data = null;                                                //変数の初期化
        if ($this->request->is('post')){                             //リクエストがきた場合
            $new_item = $this->request->getData();                   //変数$new_itemにフォームに入力されたリクエストを取得
            $data = $this->Items->newEntity($new_item);                        //従業員テーブルに新規登録
            $this->Items->save($data);
            $this->set(compact('data'));
            if(!$data->errors()) {
                return $this->redirect(['action'=>'success_new']);
            }                                    
        }  
        $this->set(compact('data'));
    }
}
