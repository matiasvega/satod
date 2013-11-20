<div class="estrategias view">
<h2><?php echo __('Estrategia'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($estrategia['Estrategia']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($estrategia['Estrategia']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($estrategia['Estrategia']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($estrategia['Estrategia']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($estrategia['Estrategia']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Estrategia'), array('action' => 'edit', $estrategia['Estrategia']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Estrategia'), array('action' => 'delete', $estrategia['Estrategia']['id']), null, __('Are you sure you want to delete # %s?', $estrategia['Estrategia']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Estrategias'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estrategia'), array('action' => 'add')); ?> </li>
	</ul>
</div>
