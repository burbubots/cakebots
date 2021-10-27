<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradecoin[]|\Cake\Collection\CollectionInterface $tradecoins
 */
?>
<style>
	img.icono{
		max-width: 45px;
		max-heigth: 45px;
	}
</style>
<div class="tradecoins index content">
    <?= $this->Html->link(__('New Tradecoin'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Coins & Balance') ?></h3>
    <?= $this->Html->link(__('Movimientos'), ['controller'=>'Trademueves', 'action' => 'index']) ?>
    <?= $this->Html->link(__('Trades'), ['controller'=>'Tradeops', 'action' => 'index']) ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Coin <br />Symbol<br />Cap.($)</th>
                    <th>Gecko Name<br />USD</th>
                    <th><?= $this->Paginator->sort('balance') ?></th>
                    <th><?= $this->Paginator->sort('acumusd', ['label' => 'Acum.']) ?></th>
                    <th>Inc.1h<br />Inc.24h<br />Inc.7d</th>
                    <th>Inc.14d<br />Inc.30d<br />Inc.60d</th>
                    <th style='text-align: center'>Max Supply<br />Total Supply<br />Circ. Supply</th>
                    <th><?= $this->Paginator->sort('getticker') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tradecoins as $tradecoin): ?>
                <tr>
                    <td><?= $tradecoin->has('small_image') ? "<img class='icono' src='".$tradecoin->small_image."'>"  : ''?></td>
                    <td>
                        <?= h($tradecoin->coin) ?><br />
                        <?= h($tradecoin->symbol) ?><br />
                        <?= h($this->Number->precision($tradecoin->capitalizacion,2)." M $") ?>
                    </td>
                    <td>
                        <?= h($tradecoin->geckoname) ?> <br />
                        <?= $this->Number->format($tradecoin->valorusd)." $" ?>
                    </td>
                    <td>
                        <?= $this->Number->precision($tradecoin->balance,4)."<br />".$tradecoin->symbol ?>
                    </td>
                    <td><?= $this->Number->format($tradecoin->acumusd) ?></td>
                    <td style='text-align: right'>
                        <?= $this->Number->format($tradecoin->inc1h) ?><br />
                        <?= $this->Number->format($tradecoin->inc24h) ?><br />
                        <?= $this->Number->format($tradecoin->inc7d) ?>
                    </td>
                    <td style='text-align: right'>
                        <?= $this->Number->format($tradecoin->inc14d) ?> <br />
                        <?= $this->Number->format($tradecoin->inc30d) ?> <br />
                        <?= $this->Number->format($tradecoin->inc60d) ?>
                    </td>
                    <td style='text-align: right'>
                        <?= $this->Number->precision($tradecoin->max_supply,2)."M" ?><br />
                        <?= $this->Number->precision($tradecoin->total_supply,2)."M" ?><br />
                        <?= $this->Number->precision($tradecoin->circulating_supply,2)."M" ?>
                    </td>
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
