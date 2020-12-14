<?php
namespace App\Controller;

use App\Controller\AppController;

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
        $this->viewBuilder()->setLayout('member');              //レイアウト読み込み
        $member = $this->Members                                //変数$memberに代入
        ->find('all')                                    
        ->contain('Purchases');                                 //関連テーブルとつなげる
        $result = $member->toArray();                           //配列にする
        $all = $member->count();                                //カウント
        $now = date('Ymd');                                     //今の時刻
        $this->loadModel('Purchases');                          //購入履歴モデル読み込み
        $purchas = $this->Purchases                             //変数$purchasに代入
        ->find('all')  
        ->contain('Items')                                      //関連テーブルとつなげる
        ->contain('Members');                                   //関連テーブルとつなげる
        $purchas->select([
            'sum' => $purchas->func()->sum('Items.price')       //会員IDごとの購入金額の合計
        ])
        ->group('Purchases.member_id');
        $data = $purchas->toArray();                            //配列にする
        $key = -1;                                              //配列を順番にとりだすために-1からスタート
        foreach ($result as $row):   
            $birthday=date('Ymd',  strtotime($row->birthday));  //一行ずつ生年月日を取り出して計算できるようフォーマット
            $birthday=floor(($now-$birthday)/10000) ;           //年齢計算。余りは切り捨て
            $key++;                                             //$keyに加算
            $result[$key]['age']=$birthday;                     //配列にキーとバリューを追加(年齢)
            $result[$key]['total'] = $data[$key]->sum;          //配列にキーとバリューを追加(購入金額合計)
            
        endforeach;
        $this->set('Result', $result); 
        $this->set('Member', $member);   
        $this->set('All', $all); 
    }
    /**
     * Data method
     */
    public function data()
    {   
        $this->viewBuilder()->setLayout('member');              //レイアウト読み込み
        if($this->request->is('post')){
            $id = $this->request->data('id');  
            $member = $this->Members                                //変数$memberに代入
            ->find('all') 
            ->where(["id "=> $id])                                   
            ->contain('Purchases');                                 //関連テーブルとつなげる
            $result = $member->toArray();                           //配列にする
            $this->loadModel('Purchases');                          //購入履歴モデル読み込み
            $purchas = $this->Purchases                             //変数$purchasに代入
            ->find('all')
            ->where(["member_id "=> $id])  
            ->contain('Items')                                      //関連テーブルとつなげる
            ->contain('Members');                                   //関連テーブルとつなげる
            $now = date('Ymd');                                     //今の時刻
            $purchas->select([
                'sum' => $purchas->func()->sum('Items.price')       //会員IDごとの購入金額の合計
            ])
            ->group('Purchases.member_id');
            $data = $purchas->toArray();                            //配列にする
            $key = -1;                                              //配列を順番にとりだすために-1からスタート
            foreach ($result as $row):   
                $birthday=date('Ymd',  strtotime($row->birthday));  //一行ずつ生年月日を取り出して計算できるようフォーマット
                $birthday=floor(($now-$birthday)/10000) ;           //年齢計算。余りは切り捨て
                $key++;                                             //$keyに加算
                $result[$key]['age']=$birthday;                     //配列にキーとバリューを追加(年齢)
                $total = $data[$key]->sum;
                if ($total >= 100000)
                {$level = 'ゴールド';} 
                elseif ($total >= 50000)
                {$level = 'シルバー';}  
                else{$level = 'ブロンズ';}
                $result[$key]['total'] = $level;          //配列にキーとバリューを追加(購入金額合計)    
            endforeach;
            $purchas_list = $this->Purchases                             //変数$purchasに代入
            ->find('all')
            ->where(["member_id "=> $id])  
            ->contain('Items');                                      //関連テーブルとつなげる
            $list = $purchas_list->toArray();
    }
        
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
        $member = $this->Member->newEntity();
        if ($this->request->is('post')) {
            $member = $this->Member->patchEntity($member, $this->request->getData());
            if ($this->Member->save($member)) {
                $this->Flash->success(__('The member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The member could not be saved. Please, try again.'));
        }
        $this->set(compact('member'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Member id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $member = $this->Member->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $member = $this->Member->patchEntity($member, $this->request->getData());
            if ($this->Member->save($member)) {
                $this->Flash->success(__('The member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The member could not be saved. Please, try again.'));
        }
        $this->set(compact('member'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Member id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $member = $this->Member->get($id);
        if ($this->Member->delete($member)) {
            $this->Flash->success(__('The member has been deleted.'));
        } else {
            $this->Flash->error(__('The member could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
