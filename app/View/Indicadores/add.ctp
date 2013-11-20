<script type="text/javascript">
    $(document).ready(function() {       
        $('form').h5Validate();
        
        var i=1;        
        $('#agregar_valor').bind('click', function() {
            var x = '<div class="valores">\n\
                        <div class="input text">\n\
                            <label for="valor_'+i+'"> Valor </label>\n\
                            <input name="valor_'+i+'" id="valor_'+i+'" type="text" required="required" placeholder="Ingresa un nombre descriptivo que identifique el valor del indicador." title="Campo requerido" />\n\
                        </div>\n\
                        <div class="input text">\n\
                            <label for="valorPonderado_'+i+'"> Valor Ponderado </label>\n\
                            <input name="valorPonderado_'+i+'" id="valorPonderado_'+i+'" required="required" placeholder="Ingresa un valor numerico que cuantifique el valor del indicador." title="Campo requerido" type="number" />\n\
                        </div>\n\
                     </div>';
            $(x).appendTo('#clon-valores');
            $(window).scrollTop($('#valor_'+i).offset().top);
            $('#i').val(i);
            i++;
            
        });                
    });
    
</script>


<div class="indicadores form">
<?php echo $this->Form->create('Indicadore'); ?>
	<fieldset class="addIndicadore">
		<legend><?php echo __('Registrar Indicador de Recupero'); ?></legend>
	<?php
		echo $this->Form->input('etiqueta', array(
                                            'required' => true,
                                            'placeholder' => 'Ingresa un nombre descriptivo que identifique el indicador.',
                                            'title' => 'Campo requerido',
                                                        )
                                        );
                                                              
                $valores[] = $this->Form->input('valor', array(
                                            'label' => 'Valor', 
                                            'id' => 'valor_0', 
                                            'name' => 'valor_0',
                                            'required' => true,
                                            'placeholder' => 'Ingresa un nombre descriptivo que identifique el valor del indicador.',
                                            'title' => 'Campo requerido',
                                                                )
                                                );
                
                $valores[] = $this->Form->input('valorPonderado', array(
                                            'label' => 'Valor Ponderado', 
                                            'id' => 'valorPonderado_0', 
                                            'name' => 'valorPonderado_0',
                                            'required' => true,
                                            'placeholder' => 'Ingresa un valor numerico que cuantifique el valor del indicador.',
                                            'title' => 'Campo requerido',
                                            'type' => 'number',
                                                                        )
                                                );
                

                $ContenedorValores[] = $this->Html->tag('div', implode("\n", $valores), array(
                                                                                'class' => 'valores',
                                                                            )
                                    );
                
                $ContenedorValores[] = $this->Html->tag('div', '', array(
                                                        'id' => 'clon-valores',
                                                      )
                                    );
                
                $fieldset[] = $this->Html->tag('fieldset', sprintf(' %s %s', 
                                                                        $this->Html->tag('legend', 'Valores del indicador'),
                                                                        implode("\n", $ContenedorValores)
                                                                    )
                                                );
                
                echo $this->Html->tag('div', implode("\n", $fieldset), array(
                                                                                'class' => 'contenedor_valores',
                                                                            )
                                    );
                
                echo $this->Form->input('i', array('type' => 'hidden', 'id' => 'i', 'value' => 0));
                
	?>
                                                                               
	</fieldset>
           
<?php 
    $botones[] = $this->Form->button('Agregar valor', array(
                                                            'id' => 'agregar_valor', 
                                                            'type' => 'button',
                                                            'class' => 'btnVn',
                                                            'title' => 'Agregar nuevo valor'
                                                            )
                                    );
    $botones[] = $this->Form->end(__('Guardar')); 
    echo $this->Html->tag('div', implode("\n", $botones));
?>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Html->link(__('List Indicadores'), array('action' => 'index')); ?></li>
		<li><?php // echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Cartera'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
