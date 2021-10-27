<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradeaccount[]|\Cake\Collection\CollectionInterface $tradeaccounts
 */
?>
<div class="tradeaccounts index content">
    <?= $this->Html->link(__('New Tradeaccount'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tradeaccounts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('account') ?></th>
                    <th>Coins</th>
                    <th><?= $this->Paginator->sort('net') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tradeaccounts as $tradeaccount): ?>
                <tr>
                    <td><?= $this->Number->format($tradeaccount->id) ?></td>
                    <td><?= h($tradeaccount->account) ?></td>
                    <td> <?= $this->Html->link('Ver Coins', ['controller'=>'Tradecoins', 'action' => 'index', $tradeaccount->account]) ?></td>
                    <td><?= h($tradeaccount->net) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tradeaccount->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tradeaccount->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tradeaccount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tradeaccount->id)]) ?>
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
