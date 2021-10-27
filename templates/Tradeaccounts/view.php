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
            <h3><?= h($tradeaccount->account) ?></h3>
            <table>
                <tr>
                    <th><?= __('Account') ?></th>
                    <td><?= h($tradeaccount->account) ?></td>
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
                            <th><?= __('Tradeaccount Id') ?></th>
                            <th><?= __('AssociatedAccount') ?></th>
                            <th><?= __('Tradecoin Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tradeaccount->tradeasociados as $tradeasociados) : ?>
                        <tr>
                            <td><?= h($tradeasociados->id) ?></td>
                            <td><?= h($tradeasociados->tradeaccount_id) ?></td>
                            <td><?= h($tradeasociados->associatedAccount) ?></td>
                            <td><?= h($tradeasociados->tradecoin_id) ?></td>
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
            <div class="related">
                <h4><?= __('Related Tradetransactions') ?></h4>
                <?php if (!empty($tradeaccount->tradetransactions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Tradeaccount Id') ?></th>
                            <th><?= __('Hash') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($tradeaccount->tradetransactions as $tradetransactions) : ?>
                        <tr>
                            <td><?= h($tradetransactions->id) ?></td>
                            <td><?= h($tradetransactions->tradeaccount_id) ?></td>
                            <td><?= h($tradetransactions->hash) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tradetransactions', 'action' => 'view', $tradetransactions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tradetransactions', 'action' => 'edit', $tradetransactions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tradetransactions', 'action' => 'delete', $tradetransactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tradetransactions->id)]) ?>
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
