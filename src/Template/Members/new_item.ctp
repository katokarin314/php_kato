<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Member $member
 */
?>
<div class="members form large-9 medium-8 columns content">
<h4>登録するデータを入力してください</h4><br> 
<?= $this->Form->create($data) ?>
        <?php
            echo $this->Form->input('Items.name',['label' => '商品名　　：']);
            echo $this->Form->input('Items.price',['label' => '値段　　　：']);
            echo $this->Form->input('Items.stock',['label' => '在庫数　　：']);
        ?>
    <br>
    <div style="text-align:right;">
    <h4><div><?=$this->Form->button('登録') ?></div></h4>
    <?= $this->Form->end() ?>
    </div>
</div>
