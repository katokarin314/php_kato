<?php
echo $this->Html->css('employee');
?>
<div class="members index large-9 medium-8 columns content">

    <h4>　No.<?php echo $Result[0]['id'];?> 
        　<?php echo $Result[0]['name'];?>
        　<?php echo $Result[0]['total'];?>
        　<?php echo $Result[0]['age'];?>
        </h4>
   
    <h5></h5>
    <h4>年齢　　：<?php echo $Result[0]['age'];?>歳 </h4>
    <h4>  生年月日：<?php echo $Result[0]['birthday'];?></h4>
    <h4>  住所　　：<?php echo $Result[0]['address'];?></h4>
    <h4>  入会日　：<?php echo $Result[0]['admission'];?></h4>
    <h4>  退会日　：<?php echo $Result[0]['exit'];?></h4> 
    <h5></h5>
    <h4>  購入履歴</h4> 
    <table cellpadding="0" cellspacing="0">
        <thead>
            
            <tr>
                
                <th>商品名</th>
                <th>値段</th>
                <th>個数</th>
                <th>購入日</th>
               
    
            </tr>
        </thead>
        <tbody>
        <?php foreach ($List as $list): 
         ?>
            
            <tr>
                <td><?= $list->item->name ?></td>
                <td><?= $list->item->price ?></td>
                <td><?= $list->quantity ?></td>
                <td><?= $list->purchase_date ?></td>
             
        <?php endforeach; ?>
             
       
        </tbody>
    </table>

</div>
