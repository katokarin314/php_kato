<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Member $member
 */
?>
<div class="members form large-9 medium-8 columns content">
<?= $this->Form->create($data) ?>
        <?php
            echo $this->Form->input('Members.id',['label' => 'ID　　：','default' => $Result[0]['id']]);
            echo $this->Form->input('Members.name',['label' => '氏名　　：','default' => $Result[0]['name']]);
            echo $this->Form->input('Members.birthday',[
                'label' => '生年月日：',
                'type' => 'date',
                'dateFormat' => 'YMD',
                'monthNames' => false,
                'maxYear' => date('Y'),
                'minYear' => date('Y') - 100,
                'default' => $Result[0]['birthday']]);
            echo $this->Form->input('Members.address',['label' => '住所　　：','default' => $Result[0]['address']]);
            echo $this->Form->input('Members.admission',[
                'label' => '入会日　：',
                'type' => 'date',
                'dateFormat' => 'YMD',
                'monthNames' => false,
                'maxYear' => date('Y'),
                'minYear' => date('Y') - 100,
                'default' => $Result[0]['admission']]);
            echo $this->Form->input('Members.exit', [
                'label' => '退会日　：',
                'empty' => true,
                'type' => 'date',
                'dateFormat' => 'YMD',
                'monthNames' => false,
                'maxYear' => date('Y'),
                'minYear' => date('Y') - 100,
                'default' => $Result[0]['exit']])
        ?>
    
    <br>
    <div style="text-align:right;">

    <?=  $this->Form->button('更新する',['type'=>"submit",'name'=>"add"]); ?>
    <?= $this->Form->end() ?>
    </div>
</div>
