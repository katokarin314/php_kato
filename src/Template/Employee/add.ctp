<?php
echo $this->Html->css('employee');
?>
<div class="employee index large-9 medium-8 columns content">
    <h3>従業員登録</h3>
    <?= $this->Form->create('Employee',['url'=>['action'=>'add','type'=>'post']]) ?>
    <h4><div><?=$this->Form->input('Employee.name', array('label' => '氏名 ')) ?></div></h4> 
    <h4><div><?=$this->Form->input('Employee.position', array('options' => $list, 'label' => '役職 ',  'empty' => 'なし')); ?></div></h4> 
    <h4><div><?=$this->Form->button('登録') ?></div><h4>
    <?=$this->Form->end() ?>
    <h5></h5>
    <h4><?php echo $Error; ?></h4>    　
    
</div>
