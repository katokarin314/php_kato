<?php
echo $this->Html->css('employee');
?>
<div class="members index large-9 medium-8 columns content">

    <h5><?= var_dump($Purchas);?></h5>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
            <tr>
                <th width="60">No.</th>
                <th>氏名</th>
                <th>年齢</th>
                <th>最終購入日</th>
                <th>会員レベル</th>
                <th width="60">         </th>
    
            </tr>
        </thead>
        <tbody>
        <?php foreach ($Result as $result): 
            $cnt = count($result->purchases)-1;
            $purchase_date = $result->purchases[$cnt]->purchase_date;
            $total = $result->total;
            if ($total >= 100000)
            {$level = 'ゴールド';} 
            elseif ($total >= 50000)
            {$level = 'シルバー';}  
            else{$level = 'ブロンズ';}
         ?>
            
            <tr>
                <td><?= $result->id ?></td>
                <td><?= $result->name ?></td>
                <td><?= $result->age ?>歳</td>
                <td><?= $purchase_date ->format('Y-m-d'); ?></td>
                <td><?= $level ?></td>
             
        <?php endforeach; ?>
             
       
        </tbody>
    </table>

</div>
