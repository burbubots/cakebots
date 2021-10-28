<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradeasociado $tradeasociado
 * @var \Cake\Collection\CollectionInterface|string[] $tradecoins
 * @var \Cake\Collection\CollectionInterface|string[] $tradeaccounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Tradeasociados'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tradeasociados form content">
            <?= $this->Form->create($tradeasociado) ?>
            <fieldset>
                <legend><?= __('Add Tradeasociado') ?></legend>
                <?php
                    echo $this->Form->control('tradecoin_id', ['options' => $tradecoins]);
                    echo $this->Form->control('tradeaccount_id', ['options' => $tradeaccounts]);
                    echo $this->Form->control('associatedAccount');
                    echo $this->Form->control('balance');
                    echo $this->Form->control('acumusd');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
