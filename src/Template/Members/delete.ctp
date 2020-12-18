<?php
echo $this->Html->css('member');
?>
<div 
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Member $member
 */
?>

<div class="members form large-9 medium-8 columns content">
<div style="text-align:center;">
<h4>　No.<?php echo $Result[0]['id'];?> 
        　<?php echo $Result[0]['name'];?>        
        </h4>
<h4>　本当に削除しますか？</h4>      
<?= $this->Form->create($delete) ?>
        <?php
            echo $this->Form->input('Members.id',['label' => 'ID　　：','default' => $Result[0]['id'],'type'=>'hidden']);
        ?>
    <br>
    
    <?=  $this->Form->button('はい',['type'=>"submit",'name'=>"delete"]); ?>
    <?= $this->Form->end(); ?><br>
    <?= $this->Form->create('キャンセル',['url'=>['action'=>'index','type'=>'post']]) ?>
    <?= $this->Form->button('キャンセル',['type' => 'submit']) ?>
    <?=$this->Form->end();?>
    
    </div></div>
</div>
