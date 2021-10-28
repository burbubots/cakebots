<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradeaccount $tradeaccount
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tradeaccount->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tradeaccount->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tradeaccounts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tradeaccounts form content">
            <?= $this->Form->create($tradeaccount) ?>
            <fieldset>
                <legend><?= __('Edit Tradeaccount') ?></legend>
                <?php
                    echo $this->Form->control('account');
                    echo $this->Form->control('cuenta');
                    echo $this->Form->control('net');
                    echo $this->Form->control('notas');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
