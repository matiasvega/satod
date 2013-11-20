<?php 

$data = $this->Js->get('#CarteraAnalizarForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#CarteraAnalizarForm')->event(
      'submit', sprintf("$(function(){
                                    var errorCliente = false;
                                    var errorCartera = false;
                                    
                                    var opts = {
                                                    cornerclass: \"\",
                                                    width: \"30%%\",
                                                    styling: 'jqueryui',
                                                    animation: 'show',
                                                    title: \" ERROR \",
                                                    type: \"error\",
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

                                    if (errorCliente || errorCartera) {
                                        opts.text = 'Debes seleccionar valores para los campos marcados como requeridos.';
                                        $.pnotify(opts);
                                    } else {
                                            $.ajax({
                                                type: 'POST',
                                                data: %s,
                                                async:true,
                                                url: 'analizar',
                                                cache:false,
                                                beforeSend: function() {
                                                    $('#informe').html('%s');
                                                }
                                              })
                                                .done(function(data) {
                                                    $('#informe').html(data);                                                    
                                                    $('#informe').dialog({
                                                        modal: true,
                                                        width: 1150,
                                                        height: 650,
                                                        draggable: true,
                                                        resizable: true,
                                                        title: 'Análisis de cartera de deudores',
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
                                                                $(location).attr('href', 'analizar/' + $(\"#estrategias_id\").val() + '/' + $(\"#cartera_seleccionada\").val() + '.pdf');
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
                    '<img src="/devel/satod/img/load.gif" />')
    );

$this->Js->get('#comboCarteras')->event(
      'change', '$("#cartera_seleccionada").val($("#comboCarteras").val());'
    );

?>

<script>
    $(document).ready(function() {
//        $('form').h5Validate();                
    });
</script>

<div spellcheck="<none>" class="carteras form">
    <?php echo $this->Form->create('Cartera', array('action' => 'analizar', 'default' => false)); ?>
    <fieldset spellcheck="true" >
        <legend><?php echo 'Generar Analisis de Cartera de Deudores'; ?></legend>
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
                                                    )
                                );

        echo $this->Form->input('Estrategia.estrategias_id', array(
                                                                    'multiple' => true,
                                                                    'id' => 'estrategias_id',
                                                                    'data-placeholder' => 'Elegi las estrategias que desees aplicar',
                                                                    'label' => 'Estrategias',
//                                                                    'required' => true,
                                                                )
                                );
                        
        echo $this->Form->input('cartera_seleccionada', array(  
                                                                'type' => 'hidden', 
                                                                'id' => 'cartera_seleccionada', 
                                                                'label' => false,
                                                                )
                                );
        
        echo $this->Html->div('informe', false, array('id' => 'informe'));
        
        ?>
    </fieldset>
    <?php 
        echo $this->Form->end(__('Emitir Informe')); 
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

