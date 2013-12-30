<?php 

$data = $this->Js->get('#CarteraPresupuestarForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#CarteraPresupuestarForm')->event(
      'submit', sprintf("$(function(){
                                    var errorCliente = false;
                                    var errorCartera = false;
                                    var errorEstrategia = false;
                                    
                                    var opts = {
                                                    cornerclass: \"\",
                                                    width: \"30%%\",
                                                    styling: 'jqueryui',
                                                    animation: 'show',
                                                    title: \" ERROR \",
                                                    type: \"error\",
                                                    history: false,
                                                    sticker: false,
                                                    delay: 2000,
                                                };
                                    
                                    if ($('#comboClientes').val() == '') {
                                        $(\"label[for='\"+$('#comboClientes').attr('id')+\"']\").css('color', 'red');
                                        errorCliente = true;                                        
                                    } else {
                                        $(\"label[for='\"+$('#comboClientes').attr('id')+\"']\").css('color', '#000000');
                                    }
                                    
                                    if ($('#comboCarteras').val() == '') {
                                        $(\"label[for='\"+$('#comboCarteras').attr('id')+\"']\").css('color', 'red');
                                        errorCartera = true;
                                    } else {
                                        $(\"label[for='\"+$('#comboCarteras').attr('id')+\"']\").css('color', '#000000');
                                    }
                                    
                                    if ($('#estrategias_id').val() == null) {
                                        $(\"label[for='\"+$('#estrategias_id').attr('id')+\"']\").css('color', 'red');
                                        errorEstrategia = true;
                                    } else {
                                        $(\"label[for='\"+$('#estrategias_id').attr('id')+\"']\").css('color', '#000000');
                                    }                                 

                                    if (errorCliente || errorCartera || errorEstrategia) {
                                        opts.text = 'Debes seleccionar valores para los campos marcados como requeridos.';
                                        $.pnotify(opts);                                          
                                    } else {
                                            $.ajax({
                                                type: 'POST',
                                                data: %s,
                                                async:true,
                                                url: 'presupuestar',
                                                cache:false,
                                                beforeSend: function() {
                                                    $('#preload').html('%s');
                                                }
                                              })
                                                .done(function(data) {
                                                    $('.preload').remove();
                                                    $('#presupuesto').html(data);                                                    
                                                    $('#presupuesto').dialog({
                                                        modal: true,
                                                        width: 1150,
                                                        height: 650,
                                                        draggable: true,
                                                        resizable: true,
                                                        title: 'Presupuesto de Gestión',
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
                                                                $(location).attr('href', 'presupuestar/' + $(\"#estrategias_id\").val() + '/' + $(\"#cartera_seleccionada\").val() + '.pdf');
                                                            },
                                                            Cerrar: function() {
                                                                $(this).dialog(\"close\");
                                                            },
                                                        }
                                                    });
                                            });
                                    }
                                    
                                });
                    ", 
                    $data,
                    '<img src="../img/load.gif" />')
      
    );

$this->Js->get('#comboCarteras')->event(
      'change', '$("#cartera_seleccionada").val($("#comboCarteras").val());'
    );

$this->Js->get('#comboClientes')->event(
      'change', sprintf("            
            
            $.ajax({
                dataType: 'json',
                async:true,
                url: 'getCarteras/' + $(this).val(),
                cache:false,
                beforeSend: function() {
                                $(\"label[for='\"+$('#comboCarteras').attr('id')+\"']\").append('%s');
                            }
              })
            .done(function(options) {
                $('.cargando').remove();
                
                // Limpio el combo de carteras y agrego los valores que le corresponden
                $('#comboCarteras').children().remove();

                if (options != null) {
                    $(\"label[for='\"+$('#comboCarteras').attr('id')+\"']\").css('color', '#000000');
                    $.each(options, function(index, value) { 
                       $('#comboCarteras').append( new Option(value.nombre,value.id) );
                    });	                    
                } else {
                    $('#comboCarteras').append( new Option('Elegi la Cartera','') );
                }
                $('#comboCarteras').trigger('chosen:updated');


            });
        ", 
              '<img class="cargando" src="../img/cargandoinputs.gif" />'
              )
    );



?>

<div spellcheck="<none>" class="carteras form">
    <?php echo $this->Form->create('Cartera', array('action' => 'presupuestar', 'default' => false)); ?>
    <fieldset spellcheck="true" >
        <legend><?php echo 'Generar Presupuesto de Gestion'; ?></legend>
        <?php
        echo $this->Form->input('clientes_id', array(
                                                        'id' => 'comboClientes',
                                                        'empty' => 'Elegi el cliente',
                                                        'label' => 'Cliente',
                                                        'div' => 'required',
                                                    )
                                );
        echo $this->Form->input('carteras_id', array(
                                                        'id' => 'comboCarteras',
                                                        'empty' => 'Elegi la Cartera',
                                                        'label' => 'Cartera',
                                                        'div' => 'required',
                                                        'options' => array(),
                                                    )
                                );

        echo $this->Form->input('Estrategia.estrategias_id', array(
                                                                    'multiple' => true,
                                                                    'id' => 'estrategias_id',
                                                                    'data-placeholder' => 'Elegi las estrategias que desees aplicar',
                                                                    'label' => 'Estrategias',
                                                                    'div' => 'required',
                                                                )
                                );
                        
        echo $this->Form->input('cartera_seleccionada', array(  
                                                                'type' => 'hidden', 
                                                                'id' => 'cartera_seleccionada', 
                                                                'label' => false,
                                                                )
                                );
        
        echo $this->Html->div('presupuesto', false, array('id' => 'presupuesto'));
        
        ?>
    </fieldset>
    <?php 
        echo $this->Form->end(__('Generar Presupuesto')); 
        echo $this->Html->div('preload', false, array('id' => 'preload'));
        echo $this->Js->writeBuffer();
    ?>
</div>
<!--
<div class="actions">
    <h3><?php //echo __('Actions'); ?></h3>
    <ul>

        <li><?php //echo $this->Html->link(__('List Carteras'), array('action' => 'index')); ?></li>
        <li><?php //echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
        <li><?php //echo $this->Html->link(__('New Clientes'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
        <li><?php //echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
        <li><?php //echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
    </ul>
</div>
-->

