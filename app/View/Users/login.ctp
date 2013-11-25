<script>
    $(document).ready(function() {
        $('form').h5Validate();
    });
</script>
<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Ingresa tu usuario y contraseña'); ?></legend>
        <?php 
        echo $this->Form->input('username', array(
                                                    'label' => 'Usuario',
                                                    'required' => true,
                                                    'placeholder' => 'Ingresa tu nombre de usuario',
                                                    'title' => 'Ingresa tu nombre de usuario',
                                                    )
                                );
        echo $this->Form->input('password', array(
                                                    'label' => 'Contraseña',
                                                    'required' => true,
                                                    'placeholder' => 'Ingresa tu contraseña',
                                                    'title' => 'Ingresa tu contraseña',            
                                                    )
                                );
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Ingresar')); ?>
</div>