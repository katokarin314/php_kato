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
            echo $this->Form->input('Members.name',['label' => '氏名　　：']);
            echo $this->Form->input('Members.birthday',[
                'label' => '生年月日：',
                'type' => 'date',
                'dateFormat' => 'YMD',
                'monthNames' => false,
                'maxYear' => date('Y'),
                'minYear' => date('Y') - 100]);
            echo $this->Form->input('Members.address',['label' => '住所　　：']);
            echo $this->Form->input('Members.admission',[
                'label' => '入会日　：',
                'type' => 'date',
                'dateFormat' => 'YMD',
                'monthNames' => false,
                'maxYear' => date('Y'),
                'minYear' => date('Y') - 100]);
            echo $this->Form->input('Members.withdrawal', [
                'label' => '退会日　：',
                'empty' => true,
                'type' => 'date',
                'dateFormat' => 'YMD',
                'monthNames' => false,
                'maxYear' => date('Y'),
                'minYear' => date('Y') - 100,
                'empty' => '-'])
        ?>
    <br>
    <div style="text-align:right;">
    <h4><div><?=$this->Form->button('登録') ?></div></h4>
    <?= $this->Form->end() ?>
    </div>
</div>
