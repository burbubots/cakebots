<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradedelegate $tradedelegate
 * @var \Cake\Collection\CollectionInterface|string[] $tradeaccounts
 * @var \Cake\Collection\CollectionInterface|string[] $tradeasociados
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tradedelegates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tradedelegates form content">
            <?= $this->Form->create($tradedelegate) ?>
            <fieldset>
                <legend><?= __('Add Tradedelegate') ?></legend>
                <?php
                    echo $this->Form->control('delegate');
                    echo $this->Form->control('tradeaccount_id', ['options' => $tradeaccounts]);
                    echo $this->Form->control('tradeasociado_id', ['options' => $tradeasociados]);
                    echo $this->Form->control('cantidad');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
