<script type="text/javascript">
    
    $(document).ready(function() {        
        $('form').h5Validate();
    });
        
</script>
<div class="groups form">
<?php echo $this->Form->create('Group'); ?>
	<fieldset>
		<legend><?php echo __('Editar Grupo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array(
                                                        'required' => true,
                                                        'label' => 'Nombre',
                                                        'placeholder' => 'Ingresa un nombre descriptivo que identifique al grupo',
                                                        'title' => 'Ingresa un nombre descriptivo que identifique al grupo',
                                                    )                       
                                        );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Group.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Group.id'))); ?></li>
		<li><?php // echo $this->Html->link(__('List Groups'), array('action' => 'index')); ?></li>
		<li><?php // echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
