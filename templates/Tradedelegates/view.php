<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradedelegate $tradedelegate
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tradedelegate'), ['action' => 'edit', $tradedelegate->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tradedelegate'), ['action' => 'delete', $tradedelegate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tradedelegate->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tradedelegates'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tradedelegate'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tradedelegates view content">
            <h3><?= h($tradedelegate->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Delegate') ?></th>
                    <td><?= h($tradedelegate->delegate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tradeaccount') ?></th>
                    <td><?= $tradedelegate->has('tradeaccount') ? $this->Html->link($tradedelegate->tradeaccount->cuenta, ['controller' => 'Tradeaccounts', 'action' => 'view', $tradedelegate->tradeaccount->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tradeasociado') ?></th>
                    <td><?= $tradedelegate->has('tradeasociado') ? $this->Html->link($tradedelegate->tradeasociado->tradecoin_id, ['controller' => 'Tradeasociados', 'action' => 'view', $tradedelegate->tradeasociado->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tradedelegate->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cantidad') ?></th>
                    <td><?= $this->Number->format($tradedelegate->cantidad) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
