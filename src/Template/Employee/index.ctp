<?php
echo $this->Html->css('employee');
?>
<div class="employee index large-9 medium-8 columns content">
    <h3>従業員検索</h3>
    <?php
    echo $this->element('form');
    ?>
    <h4><span><?php echo $Error; ?></h4></span>
    <h5><div align="right"><?php echo $Number ; ?>/<?php echo $All ; ?>　</div></h5>
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
    <div align="center">
        <ul class="pagination">
            <li><?= $this->Paginator->prev('<') ?></li>
            <li><?= $this->Paginator->numbers() ?></li>
            <li><?= $this->Paginator->next('>') ?></li>
        </ul>
    </div>
</div>
