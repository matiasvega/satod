<div class="costosEstrategias view">
<h2><?php echo __('Costos Estrategia'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($costosEstrategia['CostosEstrategia']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Costos'); ?></dt>
		<dd>
			<?php echo $this->Html->link($costosEstrategia['Costos']['id'], array('controller' => 'costos', 'action' => 'view', $costosEstrategia['Costos']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estrategias'); ?></dt>
		<dd>
			<?php echo $this->Html->link($costosEstrategia['Estrategias']['id'], array('controller' => 'estrategias', 'action' => 'view', $costosEstrategia['Estrategias']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Multiplicador'); ?></dt>
		<dd>
			<?php echo h($costosEstrategia['CostosEstrategia']['multiplicador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($costosEstrategia['CostosEstrategia']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($costosEstrategia['CostosEstrategia']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Costos Estrategia'), array('action' => 'edit', $costosEstrategia['CostosEstrategia']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Costos Estrategia'), array('action' => 'delete', $costosEstrategia['CostosEstrategia']['id']), null, __('Are you sure you want to delete # %s?', $costosEstrategia['CostosEstrategia']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Costos Estrategias'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Costos Estrategia'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Costos'), array('controller' => 'costos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Costos'), array('controller' => 'costos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estrategias'), array('controller' => 'estrategias', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estrategias'), array('controller' => 'estrategias', 'action' => 'add')); ?> </li>
	</ul>
</div>
