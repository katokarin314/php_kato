<?= $this->Form->create('Employee',['url'=>['action'=>'index','type'=>'post']]) ?>
        <h4><?= $this->Form->input('name',['label'=>'','placeholder'=>"氏名"]); ?>
        <?= $this->Form->button('検索') ?>
        <?= $this->Form->end() ?>