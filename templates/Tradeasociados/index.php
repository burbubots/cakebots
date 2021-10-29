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

    <h3><?='Coins & Balance para address: '.$this->Html->link($cuenta->cuenta, ['controller'=>'Tradeaccounts','action' => 'view', $cuenta->id]) ?></h3>
    <?= $this->Html->link('Cuentas', ['controller'=>'Tradeaccounts', 'action' => 'index']) ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Icon</th>
                    <th>Coin <br />Symbol<br />Cap.($)</th>
                    <th>gecko<br />USD</th>
                    <th><?= $this->Paginator->sort('balance',['label' => 'Cant.']).'<br/>[deleg.]' ?></th>
                    <th><?= $this->Paginator->sort('acumusd', ['label' => 'Acum.']) ?></th>
                    <th>Inc.1h<br />Inc.24h<br />Inc.7d</th>
                    <th>Inc.14d<br />Inc.30d<br />Inc.60d</th>
                    <th style='text-align: center'>Max Supply<br />Total Supply<br />Circ. Supply</th>
                    <th><?= $this->Paginator->sort('getticker', ['label'=>'Ticker?']) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tradeasociados as $assoc): ?>
                
                <tr>
                    <td><?= $assoc->tradecoin->has('small_image') ? "<img class='icono' src='".$assoc->tradecoin->small_image."'>"  : ''?></td>
                    <td>
                        <?= $this->Html->link($assoc->tradecoin->coin, ['action' => 'view', $assoc->id]) ?><br />
                        <?= h($assoc->tradecoin->symbol) ?><br />
                        <?= h($this->Number->precision($assoc->tradecoin->capitalizacion,2)." M $") ?>
                    </td>
                    <td>
                        <?= h($assoc->tradecoin->geckoname) ?> <br />
                        <?= $this->Number->format($assoc->tradecoin->valorusd)." $" ?>
                    </td>
                    <td>
                        <?= $this->Number->precision($assoc->balance,4) ?>
                        <?php
							$existe = false; $txt ='';
							foreach($assoc->tradedelegates as $delegate){
								if(!$existe){
									$existe = true;
									$txt .= '<br />[';
								}else{
									$txt.=', ';
								}
								$txt .= $this->Html->link($delegate->cantidad, ['controller'=>'Tradedelegates', 'action' => 'view', $delegate->id]);
							}
							if($existe){
								$txt .= ']';
								echo $txt;
							}
                        ?>
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
