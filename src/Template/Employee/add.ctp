<?php
echo $this->Html->css('employee');
?>
<div class="employee add large-9 medium-8 columns content">
    <h3>従業員登録</h3>
    <?= $this->Form->create('Employee',['url'=>['action'=>'add','type'=>'post']]) ?>
    <div><?=$this->Form->input('Employee.name', array('label' => '名前')) ?></div>
    <div><?=$this->Form->input('Employee.position', array('options' => $list, 'label' => '役職名',  'empty' => 'なし')); ?></div>
    <div><?=$this->Form->submit('登録') ?></div>
    <?=$this->Form->end() ?>
    <h4><?php echo $Error; ?></h4>    　
    
</div>
