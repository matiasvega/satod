<div class="carterasIndicadores view">
<h2><?php echo __('Carteras Indicadore'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($carterasIndicadore['CarterasIndicadore']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Indicadore'); ?></dt>
		<dd>
			<?php echo $this->Html->link($carterasIndicadore['Indicadore']['etiqueta'], array('controller' => 'indicadores', 'action' => 'view', $carterasIndicadore['Indicadore']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cartera'); ?></dt>
		<dd>
			<?php echo $this->Html->link($carterasIndicadore['Cartera']['nombre'], array('controller' => 'carteras', 'action' => 'view', $carterasIndicadore['Cartera']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($carterasIndicadore['CarterasIndicadore']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($carterasIndicadore['CarterasIndicadore']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Carteras Indicadore'), array('action' => 'edit', $carterasIndicadore['CarterasIndicadore']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Carteras Indicadore'), array('action' => 'delete', $carterasIndicadore['CarterasIndicadore']['id']), null, __('Are you sure you want to delete # %s?', $carterasIndicadore['CarterasIndicadore']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Carteras Indicadores'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Carteras Indicadore'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cartera'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>
