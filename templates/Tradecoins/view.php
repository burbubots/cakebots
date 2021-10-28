<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradecoin $tradecoin
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tradecoin'), ['action' => 'edit', $tradecoin->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tradecoin'), ['action' => 'delete', $tradecoin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tradecoin->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tradecoins'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tradecoin'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tradecoins view content">
            <h3><?= h($tradecoin->coin) ?></h3>
            <table>
                <tr>
                    <th><?= __('Coin') ?></th>
                    <td><?= h($tradecoin->coin) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($tradecoin->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Symbol') ?></th>
                    <td><?= h($tradecoin->symbol) ?></td>
                    <th><?= __('Geckoname') ?></th>
                    <td><?= h($tradecoin->geckoname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Small Image') ?></th>
                    <td><?= h($tradecoin->small_image) ?></td>
                </tr>
                <tr>
                    <th> Valor Actual en USD </th>
                    <td><?= $this->Number->format($tradecoin->valorusd) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inc1h') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc1h) ?></td>
                    <th><?= __('Inc24h') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc24h) ?></td>
                    <th><?= __('Inc7d') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc7d) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inc14d') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc14d) ?></td>
                    <th><?= __('Inc30d') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc30d) ?></td>
                    <th><?= __('Inc60d') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc60d) ?></td>
                </tr>
                <tr>
                    <th><?= __('Max Supply') ?></th>
                    <td><?= $this->Number->format($tradecoin->max_supply) ?></td>
                    <th><?= __('Total Supply') ?></th>
                    <td><?= $this->Number->format($tradecoin->total_supply) ?></td>
                    <th><?= __('Circulating Supply') ?></th>
                    <td><?= $this->Number->format($tradecoin->circulating_supply) ?></td>
                </tr>
                <tr>
                    <th><?= __('Market Cap') ?></th>
                    <td><?= $this->Number->format($tradecoin->market_cap) ?></td>
                </tr>
                <tr>
                    <th><?= __('Getticker') ?></th>
                    <td><?= $this->Number->format($tradecoin->getticker) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Tradeasociados') ?></h4>
                <?php if (!empty($tradecoin->tradeasociados)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Tradeaccount Id') ?></th>
                            <th><?= __('AssociatedAccount') ?></th>
                            <th><?= __('Balance') ?></th>
                            <th><?= __('Acumusd') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tradecoin->tradeasociados as $tradeasociados) : ?>
                        <tr>
                            <td><?= $this->Html->link($tradeasociados->tradeaccount->cuenta, 
									['controller' => 'Tradeaccounts', 'action' => 'view', $tradeasociados->tradeaccount_id]) ?></td>
                            <td><?= substr($tradeasociados->associatedAccount,0,9).'...' ?></td>
                            <td><?= h($tradeasociados->balance) ?></td>
                            <td><?= h($tradeasociados->acumusd) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tradeasociados', 'action' => 'view', $tradeasociados->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tradeasociados', 'action' => 'edit', $tradeasociados->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tradeasociados', 'action' => 'delete', $tradeasociados->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tradeasociados->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
