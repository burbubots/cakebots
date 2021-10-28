<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradeasociado $tradeasociado
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tradeasociado'), ['action' => 'edit', $tradeasociado->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tradeasociado'), ['action' => 'delete', $tradeasociado->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tradeasociado->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tradeasociados'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tradeasociado'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tradeasociados view content">
            <h3><?= h($tradeasociado->tradecoin_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tradecoin') ?></th>
                    <td><?= $tradeasociado->has('tradecoin') ? $this->Html->link($tradeasociado->tradecoin->coin, ['controller' => 'Tradecoins', 'action' => 'view', $tradeasociado->tradecoin->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tradeaccount') ?></th>
                    <td><?= $tradeasociado->has('tradeaccount') ? $this->Html->link($tradeasociado->tradeaccount->cuenta, ['controller' => 'Tradeaccounts', 'action' => 'view', $tradeasociado->tradeaccount->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('AssociatedAccount') ?></th>
                    <td><?= h($tradeasociado->associatedAccount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tradeasociado->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Balance') ?></th>
                    <td><?= $this->Number->format($tradeasociado->balance) ?></td>
                </tr>
                <tr>
                    <th><?= __('Acumusd') ?></th>
                    <td><?= $this->Number->format($tradeasociado->acumusd) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
