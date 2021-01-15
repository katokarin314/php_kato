<?php
echo $this->Html->css('member');
?>
<div class="members index large-9 medium-8 columns content">
    <h5><?=  $Error ?></h5>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th width="60">ID</th>
                <th>商品名</th>
                <th>値段</th>
                <th>在庫数</th>
                <th>注文数</th>
            </tr>
        </thead>
        <tbody>
      
        <?= $this->Form->create($data) ?>
        <?php foreach ($Item as $key=>$item):?>
            
            <tr>
                
                <td><?=  $this->Form->input('Items'.$key.'id',['style' => 'width:30px','label'=>false,'default' => $item->id]);  ?></td>
                <td><?=  $this->Form->input('Items'.$key.'name',['style' => 'width:100px','label'=>false,'default' => $item->name]); ?></td>
                <td><?=  $this->Form->input('Items'.$key.'price',['style' => 'width:60px','label'=>false,'default' => $item->price]);  ?></td>
                <td><?=  $this->Form->input('Items'.$key.'stock',['style' => 'width:60px','label'=>false,'default' => $item->stock]); ?></td>
                <td><?=  $this->Form->input('Items'.$key.'sales',['style' => 'width:60px','label'=>false,'default' => $item->sales]); ?></td>
            </tr>       
        <?php endforeach; ?>
        
        </tbody>
        
    </table>
    <?=  $this->Form->button('更新',['type'=>"submit",'name'=>"add"]); ?>
    <?= $this->Form->end() ?>
</div>
