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
            <?= $this->Html->link(__('List Tradecoins'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tradecoins form content">
            <?= $this->Form->create($tradecoin) ?>
            <fieldset>
                <legend><?= __('Add Tradecoin') ?></legend>
                <?php
                    echo $this->Form->control('coin');
                    echo $this->Form->control('symbol');
                    echo $this->Form->control('geckoname');
                    echo $this->Form->control('valorusd');
                    echo $this->Form->control('balance');
                    echo $this->Form->control('acumusd');
                    echo $this->Form->control('inc1h');
                    echo $this->Form->control('inc24h');
                    echo $this->Form->control('inc7d');
                    echo $this->Form->control('inc14d');
                    echo $this->Form->control('inc30d');
                    echo $this->Form->control('inc60d');
                    echo $this->Form->control('max_supply');
                    echo $this->Form->control('total_supply');
                    echo $this->Form->control('circulating_supply');
                    echo $this->Form->control('small_image');
                    echo $this->Form->control('getticker');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
