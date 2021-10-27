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
                    <th><?= __('Mint') ?></th>
                    <td><?= h($tradecoin->address) ?></td>
                </tr>
               <tr>
                    <th><?= __('Associated') ?></th>
                    <td><?= h($tradecoin->tradeasociado->associatedAccount) ?></td>
                </tr>                
                <tr>
                    <th><?= __('Symbol') ?></th>
                    <td><?= h($tradecoin->symbol) ?></td>
                </tr>
                <tr>
                    <th><?= __('Geckoname') ?></th>
                    <td><?= h($tradecoin->geckoname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Small Image') ?></th>
                    <td><?= h($tradecoin->small_image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tradecoin->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Valorusd') ?></th>
                    <td><?= $this->Number->format($tradecoin->valorusd) ?></td>
                </tr>
                <tr>
                    <th><?= __('Balance') ?></th>
                    <td><?= $this->Number->format($tradecoin->balance) ?></td>
                </tr>
                <tr>
                    <th><?= __('Acumusd') ?></th>
                    <td><?= $this->Number->format($tradecoin->acumusd) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inc1h') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc1h) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inc24h') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc24h) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inc7d') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc7d) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inc14d') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc14d) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inc30d') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc30d) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inc60d') ?></th>
                    <td><?= $this->Number->format($tradecoin->inc60d) ?></td>
                </tr>
                <tr>
                    <th><?= __('Max Supply') ?></th>
                    <td><?= $this->Number->format($tradecoin->max_supply) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Supply') ?></th>
                    <td><?= $this->Number->format($tradecoin->total_supply) ?></td>
                </tr>
                <tr>
                    <th><?= __('Circulating Supply') ?></th>
                    <td><?= $this->Number->format($tradecoin->circulating_supply) ?></td>
                </tr>
                <tr>
                    <th><?= __('Getticker') ?></th>
                    <td><?= $this->Number->format($tradecoin->getticker) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Trademueves') ?></h4>
                <?php if (!empty($tradecoin->trademueves)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Tradecoin Id') ?></th>
                            <th><?= __('Tradeop Id') ?></th>
                            <th><?= __('Cantidad') ?></th>
                            <th><?= __('Valorusd') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tradecoin->trademueves as $trademueves) : ?>
                        <tr>
                            <td><?= h($trademueves->id) ?></td>
                            <td><?= h($trademueves->tradecoin_id) ?></td>
                            <td><?= h($trademueves->tradeop_id) ?></td>
                            <td><?= h($trademueves->cantidad) ?></td>
                            <td><?= h($trademueves->valorusd) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Trademueves', 'action' => 'view', $trademueves->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Trademueves', 'action' => 'edit', $trademueves->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Trademueves', 'action' => 'delete', $trademueves->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trademueves->id)]) ?>
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
