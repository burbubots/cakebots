<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradedelegate[]|\Cake\Collection\CollectionInterface $tradedelegates
 */
?>
<div class="tradedelegates index content">
    <?= $this->Html->link(__('New Tradedelegate'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tradedelegates') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('delegate') ?></th>
                    <th><?= $this->Paginator->sort('tradeaccount_id') ?></th>
                    <th><?= $this->Paginator->sort('tradeasociado_id') ?></th>
                    <th><?= $this->Paginator->sort('cantidad') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tradedelegates as $tradedelegate): ?>
                <tr>
                    <td><?= $this->Number->format($tradedelegate->id) ?></td>
                    <td><?= h($tradedelegate->delegate) ?></td>
                    <td><?= $tradedelegate->has('tradeaccount') ? $this->Html->link($tradedelegate->tradeaccount->cuenta, ['controller' => 'Tradeaccounts', 'action' => 'view', $tradedelegate->tradeaccount->id]) : '' ?></td>
                    <td><?= $tradedelegate->has('tradeasociado') ? $this->Html->link($tradedelegate->tradeasociado->tradecoin_id, ['controller' => 'Tradeasociados', 'action' => 'view', $tradedelegate->tradeasociado->id]) : '' ?></td>
                    <td><?= $this->Number->format($tradedelegate->cantidad) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tradedelegate->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tradedelegate->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tradedelegate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tradedelegate->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
