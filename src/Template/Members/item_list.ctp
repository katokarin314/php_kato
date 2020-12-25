<?php
echo $this->Html->css('member');
?>
<div class="members index large-9 medium-8 columns content">

    <h5></h5>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th width="60">ID</th>
                <th>商品名</th>
                <th>値段</th>
                <th>在庫数</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($Item as $item):?>
            
            <tr>
                <td><?= $item->id ?></td>
                <td><?= $item->name ?></td>
                <td><?= $item->price ?></td>
                <td><?= $item->stock ?></td>
            </tr>       
        <?php endforeach; ?>
        </tbody>
    </table>

</div>
