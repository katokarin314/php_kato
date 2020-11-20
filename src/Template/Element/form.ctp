<?= $this->Form->create('Employee',['url'=>['action'=>'index','type'=>'post']]) ?>
        <?= $this->Form->input('name',['label'=>'']); ?>
        <?= $this->Form->button('検索') ?>
        <?= $this->Form->end() ?>