<?php
echo $this->Html->css('employee');
?>
<div class="employee index large-9 medium-8 columns content">
    <h3>従業員一覧</h3>
    
    <?= $this->Form->create('Employee',['url'=>['action'=>'index','type'=>'post']]) ?>
        <h4>従業員検索</h4>
        <?= $this->Form->input('name',['label'=>'']); ?>
        <?= $this->Form->button('検索') ?>
        <?= $this->Form->end() ?>
        <div align="right"><h5>検索結果<?php echo $Number; ?>件</h5></div>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th width="80">社員番号</th>
                <th>従業員名</th>
                <th>役職</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($Employee as $employee): 
                  if ($employee->position_name == null)
                  {$positionName = '-';}          
                  else
                  {$positionName =$employee->position_name->position_name ;}?>
            <tr>
                <td><?= $employee->id ?></td>
                <td><?= $employee->name ?></td>
                <td><?= $positionName ?></td>
            </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</div>
