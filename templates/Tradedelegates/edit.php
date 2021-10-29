<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradedelegate $tradedelegate
 * @var string[]|\Cake\Collection\CollectionInterface $tradeaccounts
 * @var string[]|\Cake\Collection\CollectionInterface $tradeasociados
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tradedelegate->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tradedelegate->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tradedelegates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tradedelegates form content">
            <?= $this->Form->create($tradedelegate) ?>
            <fieldset>
                <legend><?= __('Edit Tradedelegate') ?></legend>
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
