<div class="planificaciones index">
	<h2><?php echo __('Planificaciones'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
                        <th><?php echo $this->Paginator->sort('cliente'); ?></th>
                        <th><?php echo $this->Paginator->sort('carteras_id', 'Cartera'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_inicio'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_fin'); ?></th>

			
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($planificaciones as $planificacione): ?>
	<tr>
		<td><?php echo h($planificacione['Planificacione']['id']); ?>&nbsp;</td>
                <td>
			<?php echo $this->Html->link(ucfirst($planificacione['Cartera']['Cliente']['nombre']), array('controller' => 'clientes', 'action' => 'view', $planificacione['Cartera']['Cliente']['id'])); ?>
		</td>
                <td>
			<?php echo $this->Html->link(ucfirst($planificacione['Cartera']['nombre']), array('controller' => 'carteras', 'action' => 'view', $planificacione['Cartera']['id'])); ?>
		</td>
		<td><?php echo fecha(h($planificacione['Planificacione']['fecha_inicio'])); ?>&nbsp;</td>
		<td><?php echo fecha(h($planificacione['Planificacione']['fecha_fin'])); ?>&nbsp;</td>
		
		<td class="actions">
                
                <?php echo $this->Html->link($this->Html->image('pdf.png', array('alt' => 'Exportar a PDF', 'title' => 'Exportar a PDF')), array('action' => 'generarGantt', sprintf('%s.pdf', $planificacione['Planificacione']['id'])), array('escape' => false)); ?>
                <?php echo $this->Js->link($this->Html->image('ver.png', array('alt' => 'Ver Planificacion', 'title' => 'Ver Planificacion')), array('action' => 'generarGantt', $planificacione['Planificacione']['id']), 
                                                            array(
                                                                'update' => '#informe',
                                                                'async' => true,
                                                                'dataExpression' => true,
                                                                'method' => 'GET',
                                                                'success' => sprintf("$('#informe').dialog({
                                                                            modal: true,
                                                                            width: 1150,
                                                                            height: 650,
                                                                            closeOnEscape: true,
                                                                            draggable: false,
                                                                            resizable: false,
                                                                            title: 'Planificacion de gestion de cartera de deudores',
                                                                            show: {
                                                                                    effect: \"blind\",
                                                                                    duration: 1000,
                                                                                  },
                                                                            hide: {
                                                                              effect: \"fade\",
                                                                              duration: 1000,
                                                                            },
                                                                            buttons: {
                                                                                        'Exportar PDF': function() {
                                                                                            $(location).attr('href', 'generarGantt/%s.pdf');                                                                                            
                                                                                        },
                                                                                        Cerrar: function() {
                                                                                            $(this).dialog(\"close\");
                                                                                        },
                                                                            }
                                                                });", $planificacione['Planificacione']['id']
                                                                        ),
                                                                'escape' => false,
                                                                )
                                            ); ?>
                    
                    
		<?php // echo $this->Html->link(__('EDITAR'), array('action' => 'edit', $planificacione['Planificacione']['id'])); ?>
		<?php // echo $this->Form->postLink(__('ELIMINAR'), array('action' => 'delete', $planificacione['Planificacione']['id']), null, __('Confirma que desea eliminar los datos de la planificacion de gestion %s?', $planificacione['Planificacione']['id'])); ?>
                <?php echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), array('action' => 'delete', $planificacione['Planificacione']['id']), array('escape' => false), __('Confirma que desea eliminar los datos de la planificacion de gestion %s?', $planificacione['Planificacione']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina {:page} de {:pages}, mostrando {:current} registros de un total de {:count}.')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<?php
    echo $this->Html->div('informe', false, array('id' => 'informe'));
    echo $this->Js->writeBuffer();
?>
<!--
<div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>
		<li><?php //echo $this->Html->link(__('New Planificacione'), array('action' => 'add')); ?></li>
		<li><?php //echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php //echo $this->Html->link(__('New Carteras'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>
-->