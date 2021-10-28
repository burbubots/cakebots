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

    <h3><?= __('Coins & Balance') ?></h3>
    <?= $this->Html->link('Cuentas', ['controller'=>'Tradeaccounts', 'action' => 'index']) ?>
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
                <?php foreach ($tradeasociados as $assoc): ?>
                
                <tr>
                    <td><?= $assoc->tradecoin->has('small_image') ? "<img class='icono' src='".$assoc->tradecoin->small_image."'>"  : ''?></td>
                    <td>
                        <?= h($assoc->tradecoin->coin) ?><br />
                        <?= h($assoc->tradecoin->symbol) ?><br />
                        <?= h($this->Number->precision($assoc->tradecoin->capitalizacion,2)." M $") ?>
                    </td>
                    <td>
                        <?= h($assoc->tradecoin->geckoname) ?> <br />
                        <?= $this->Number->format($assoc->tradecoin->valorusd)." $" ?>
                    </td>
                    <td>
                        <?= $this->Number->precision($assoc->balance,4)."<br />".$assoc->tradecoin->symbol ?>
                    </td>
                    <td><?= $this->Number->format($assoc->acumusd) ?></td>
                    <td style='text-align: right'>
                        <?= $this->Number->format($assoc->tradecoin->inc1h) ?><br />
                        <?= $this->Number->format($assoc->tradecoin->inc24h) ?><br />
                        <?= $this->Number->format($assoc->tradecoin->inc7d) ?>
                    </td>
                    <td style='text-align: right'>
                        <?= $this->Number->format($assoc->tradecoin->inc14d) ?> <br />
                        <?= $this->Number->format($assoc->tradecoin->inc30d) ?> <br />
                        <?= $this->Number->format($assoc->tradecoin->inc60d) ?>
                    </td>
                    <td style='text-align: right'>
                        <?= $this->Number->precision($assoc->tradecoin->max_supply,2)."M" ?><br />
                        <?= $this->Number->precision($assoc->tradecoin->total_supply,2)."M" ?><br />
                        <?= $this->Number->precision($assoc->tradecoin->circulating_supply,2)."M" ?>
                    </td>
                    <td><?= $this->Number->format($assoc->tradecoin->getticker) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $assoc->tradecoin->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assoc->tradecoin->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assoc->tradecoin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assoc->tradecoin->id)]) ?>
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
