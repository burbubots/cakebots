<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradecoin[]|\Cake\Collection\CollectionInterface $tradecoins
 */
?>
<div class="tradecoins index content">
    <?= $this->Html->link(__('New Tradecoin'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Tradecoins') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('coin') ?></th>
                    <th><?= $this->Paginator->sort('address') ?></th>
                    <th><?= $this->Paginator->sort('symbol') ?></th>
                    <th><?= $this->Paginator->sort('geckoname') ?></th>
                    <th><?= $this->Paginator->sort('valorusd') ?></th>
                    <th><?= $this->Paginator->sort('inc1h') ?></th>
                    <th><?= $this->Paginator->sort('inc24h') ?></th>
                    <th><?= $this->Paginator->sort('inc7d') ?></th>
                    <th><?= $this->Paginator->sort('inc14d') ?></th>
                    <th><?= $this->Paginator->sort('inc30d') ?></th>
                    <th><?= $this->Paginator->sort('inc60d') ?></th>
                    <th><?= $this->Paginator->sort('max_supply') ?></th>
                    <th><?= $this->Paginator->sort('total_supply') ?></th>
                    <th><?= $this->Paginator->sort('circulating_supply') ?></th>
                    <th><?= $this->Paginator->sort('market_cap') ?></th>
                    <th><?= $this->Paginator->sort('small_image') ?></th>
                    <th><?= $this->Paginator->sort('getticker') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tradecoins as $tradecoin): ?>
                <tr>
                    <td><?= $this->Number->format($tradecoin->id) ?></td>
                    <td><?= h($tradecoin->coin) ?></td>
                    <td><?= h($tradecoin->address) ?></td>
                    <td><?= h($tradecoin->symbol) ?></td>
                    <td><?= h($tradecoin->geckoname) ?></td>
                    <td><?= $this->Number->format($tradecoin->valorusd) ?></td>
                    <td><?= $this->Number->format($tradecoin->inc1h) ?></td>
                    <td><?= $this->Number->format($tradecoin->inc24h) ?></td>
                    <td><?= $this->Number->format($tradecoin->inc7d) ?></td>
                    <td><?= $this->Number->format($tradecoin->inc14d) ?></td>
                    <td><?= $this->Number->format($tradecoin->inc30d) ?></td>
                    <td><?= $this->Number->format($tradecoin->inc60d) ?></td>
                    <td><?= $this->Number->format($tradecoin->max_supply) ?></td>
                    <td><?= $this->Number->format($tradecoin->total_supply) ?></td>
                    <td><?= $this->Number->format($tradecoin->circulating_supply) ?></td>
                    <td><?= $this->Number->format($tradecoin->market_cap) ?></td>
                    <td><?= h($tradecoin->small_image) ?></td>
                    <td><?= $this->Number->format($tradecoin->getticker) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $tradecoin->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tradecoin->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tradecoin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tradecoin->id)]) ?>
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
