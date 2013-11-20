<div class="indicadoresValores view">
<h2><?php echo __('Indicadores Valore'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($indicadoresValore['IndicadoresValore']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Valor'); ?></dt>
		<dd>
			<?php echo h($indicadoresValore['IndicadoresValore']['valor']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Valor Ponderado'); ?></dt>
		<dd>
			<?php echo h($indicadoresValore['IndicadoresValore']['valor_ponderado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Valor Calculo'); ?></dt>
		<dd>
			<?php echo h($indicadoresValore['IndicadoresValore']['valor_calculo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($indicadoresValore['IndicadoresValore']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($indicadoresValore['IndicadoresValore']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Indicadore'); ?></dt>
		<dd>
			<?php echo $this->Html->link($indicadoresValore['Indicadore']['etiqueta'], array('controller' => 'indicadores', 'action' => 'view', $indicadoresValore['Indicadore']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Indicadores Valore'), array('action' => 'edit', $indicadoresValore['IndicadoresValore']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Indicadores Valore'), array('action' => 'delete', $indicadoresValore['IndicadoresValore']['id']), null, __('Are you sure you want to delete # %s?', $indicadoresValore['IndicadoresValore']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Indicadores Valores'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Indicadores Valore'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
	</ul>
</div>
