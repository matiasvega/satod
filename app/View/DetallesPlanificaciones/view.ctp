<div class="detallesPlanificaciones view">
<h2><?php echo __('Detalles Planificacione'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($detallesPlanificacione['DetallesPlanificacione']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Inicio'); ?></dt>
		<dd>
			<?php echo h($detallesPlanificacione['DetallesPlanificacione']['fecha_inicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Fin'); ?></dt>
		<dd>
			<?php echo h($detallesPlanificacione['DetallesPlanificacione']['fecha_fin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($detallesPlanificacione['DetallesPlanificacione']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($detallesPlanificacione['DetallesPlanificacione']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estrategias'); ?></dt>
		<dd>
			<?php echo $this->Html->link($detallesPlanificacione['Estrategias']['id'], array('controller' => 'estrategias', 'action' => 'view', $detallesPlanificacione['Estrategias']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Carteras Indicadores'); ?></dt>
		<dd>
			<?php echo $this->Html->link($detallesPlanificacione['CarterasIndicadores']['id'], array('controller' => 'carteras_indicadores', 'action' => 'view', $detallesPlanificacione['CarterasIndicadores']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Planificaciones'); ?></dt>
		<dd>
			<?php echo $this->Html->link($detallesPlanificacione['Planificaciones']['id'], array('controller' => 'planificaciones', 'action' => 'view', $detallesPlanificacione['Planificaciones']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Detalles Planificacione'), array('action' => 'edit', $detallesPlanificacione['DetallesPlanificacione']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Detalles Planificacione'), array('action' => 'delete', $detallesPlanificacione['DetallesPlanificacione']['id']), null, __('Are you sure you want to delete # %s?', $detallesPlanificacione['DetallesPlanificacione']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Detalles Planificaciones'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Detalles Planificacione'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estrategias'), array('controller' => 'estrategias', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estrategias'), array('controller' => 'estrategias', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carteras Indicadores'), array('controller' => 'carteras_indicadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Carteras Indicadores'), array('controller' => 'carteras_indicadores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Planificaciones'), array('controller' => 'planificaciones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Planificaciones'), array('controller' => 'planificaciones', 'action' => 'add')); ?> </li>
	</ul>
</div>
