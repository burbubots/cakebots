<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tradeaccount $tradeaccount
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Tradeaccount'), ['action' => 'edit', $tradeaccount->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Tradeaccount'), ['action' => 'delete', $tradeaccount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tradeaccount->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tradeaccounts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Tradeaccount'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tradeaccounts view content">
            <h3><?= h($tradeaccount->cuenta) ?></h3>
            <table>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= h($tradeaccount->account) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cuenta') ?></th>
                    <td><?= h($tradeaccount->cuenta) ?></td>
                </tr>
                <tr>
                    <th><?= __('Net') ?></th>
                    <td><?= h($tradeaccount->net) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($tradeaccount->id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notas') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($tradeaccount->notas)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Tradeasociados') ?></h4>
                <?php if (!empty($tradeaccount->tradeasociados)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Tradecoin Id') ?></th>
                            <th><?= __('Tradeaccount Id') ?></th>
                            <th><?= __('AssociatedAccount') ?></th>
                            <th><?= __('Balance') ?></th>
                            <th><?= __('Acumusd') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tradeaccount->tradeasociados as $tradeasociados) : ?>
                        <tr>
                            <td><?= h($tradeasociados->id) ?></td>
                            <td><?= h($tradeasociados->tradecoin_id) ?></td>
                            <td><?= h($tradeasociados->tradeaccount_id) ?></td>
                            <td><?= h($tradeasociados->associatedAccount) ?></td>
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
