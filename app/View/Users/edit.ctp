<script>
    $(document).ready(function() {
        $('form').h5Validate();
    });
</script>
<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Editar Usuario'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username', array(
                                                    'label' => 'Usuario',
                                                    'required' => true,
                                                    'placeholder' => 'Ingresa el nombre de usuario',
                                                    'title' => 'Ingresa el nombre de usuario',
                                                    )
                                        );
		echo $this->Form->input('password', array(
                                                    'label' => 'Contraseña',
                                                    'required' => true,
                                                    'placeholder' => 'Ingresa la contraseña de usuario',
                                                    'title' => 'Ingresa la contraseña de usuario',
                                                    )
                                        );
		echo $this->Form->input('group_id', array(
                                                        'required' => true,
                                                        'label' => 'Grupo',
                                                        'options' => $grupos,
                                                        'required' => true,
                                                        'title' => 'Selecciona el grupo al que pertenece el usuario',
                                                        'div' => 'required',
                                                        )
                                        );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php // echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>-->
