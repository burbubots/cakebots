<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradeasociado $tradeasociado
 */
use Cake\I18n\I18n;
use Cake\I18n\Time;
use Cake\I18n\Number;

I18n::setLocale('es-ES');
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
            <h3><?= h($tradeasociado->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Tradeaccount') ?></th>
                    <td><?= $tradeasociado->has('tradeaccount') ? $this->Html->link($tradeasociado->tradeaccount->cuenta, ['controller' => 'Tradeaccounts', 'action' => 'view', $tradeasociado->tradeaccount->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('AssociatedAccount') ?></th>
                    <td><?= h($tradeasociado->associatedAccount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tradecoin') ?></th>
                    <td><?= $tradeasociado->has('tradecoin') ? $this->Html->link($tradeasociado->tradecoin->coin, ['controller' => 'Tradecoins', 'action' => 'view', $tradeasociado->tradecoin->id]) : '' ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Tradeoperadores') ?></h4>
                <?php if (!empty($tradeasociado->tradeoperadores)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Ops-Date') ?></th>
                            <th><?= __('Trans.') ?></th>
                            <th><?= __('Coin') ?></th>
                            <th style='text-align:center'><?= __('Antes/Despues') ?></th>
                            <th style='text-align:center'><?= __('Dif./ USD') ?></th>
                            <th><?= __('Operacion') ?></th>
                        </tr>
                        <?php foreach ($tradeasociado->tradeoperadores as $tradeoperadores) : ?>
                        <tr>
                            <td><?= $this->Html->link($tradeoperadores->tradetransaction->date, ['controller' => 'Tradeoperadores', 'action' => 'view', $tradeoperadores->id]) ?></td>
                            <td><?= $this->Html->link(substr($tradeoperadores->tradetransaction->hash,0,6),
										['controller' => 'Tradetransactions', 'action' => 'view', $tradeoperadores->tradetransaction_id]) ?></td>
                            <td><?= h($tradeoperadores->coin) ?></td>
                            <td style='text-align:right'>
								<?= $this->Number->precision($tradeoperadores->saldo_antes,6)." ".$tradeasociado->tradecoin->symbol ?><br />
								<?= $this->Number->precision($tradeoperadores->saldo_despues,6)." ".$tradeasociado->tradecoin->symbol ?>
							</td>
                            <td style='text-align:right'>
								<?= $this->Number->precision($tradeoperadores->diferencia,6)." ".$tradeasociado->tradecoin->symbol ?><br />
								<?= $this->Number->precision($tradeoperadores->usdvalue,6).' $' ?>
                            </td>
                            <td><?= h($tradeoperadores->operacion) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
