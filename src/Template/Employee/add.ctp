<?php
echo $this->Html->css('employee');
?>
<div class="employee index large-9 medium-8 columns content">
    <h3>従業員登録</h3>
   
    <?= $this->Form->create($entity) ?>
    <div><?=$this->Form->input('Employee.name', array('label' => '氏名 ', 'error' => false)) ?></div> 
    <div><?=$this->Form->input('Employee.position', array('options' => $list, 'label' => '役職 ',  'empty' => 'なし')); ?></div>
    <h4><div><?=$this->Form->button('登録') ?></div></h4>
    <h4><span><div><?= $this->Form->error('Employee.name') ?></div></span></h4>
    <?=$this->Form->end() ?>
   
    <h5></h5>
    
</div>
