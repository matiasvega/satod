<script>
    $(document).ready(function() {
        $('form').h5Validate();
        $(function () {

            $('#fileupload').fileupload({                    
                url: 'cargar/1',
                dataType: 'json',
                add: function (e, data) {
                    data.submit();                        
                },
                done: function (e, data) {
                    console.log(data.result);
                    $.ajax({
                            type: "POST",
                            url: "importarCartera",
                            data: data.result
                          })
                            .done(function(html) {
                                $( "#columnas" ).empty();
                                $( "#columnas" ).append(html);
                                $(window).scrollTop($('#columnas').offset().top);
                                $('#archivo').val(1);
                          });
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                    );
                }
            });

        });
        
        $( "#comision" ).spinner({
            step: 0.01,
            numberFormat: "n"
        });
        
        $('.combo_estado_cartera').bind('click', function() {
            if ($(this).val() == 'A') {
                // Si el estado es efectivo, entonces habilito el campo de IdLogisis y lo controlo como requerido
                $('#idAsignacionLogisis').prop('disabled', false);
            } else {
                $('#idAsignacionLogisis').prop('disabled', true);
            }
        });
        
        
    });
</script>

<?php

$data = $this->Js->get('#CarteraAddForm')->serializeForm(array('isForm' => true, 'inline' => true));

$this->Js->get('#CarteraAddForm')->event(
        'submit', sprintf("
            $(function() {
            var errorImportarCartera = false;

            var opts = {
                            cornerclass: \"\",
                            width: \"30%%\",
                            styling: 'jqueryui',
                            animation: 'show',
                            title: \" ERROR \",
                            type: \"error\",
                        };
                        
            // Verifico que se hayan seleccionado los valores para definir los indicadores particulares de recupero.
            console.log($('.etiqueta').length);
            
            var errorEtiquetaIndicadores = false;            
            for (i=0;i<$('.etiqueta').length;i++) {
                if($('#CarteraEtiquetaColumna'+i).val() == '') {
                    errorEtiquetaIndicadores = true;
                }
            }
            
            var errorNoCalculoGrupo = true;
            console.log(errorNoCalculoGrupo);
            for (i=0;i<$('.calculo').length;i++) {
                console.log($('#CarteraCalculoColumna'+i).val());
                if($('#CarteraCalculoColumna'+i).val() == 'group') {
                    errorNoCalculoGrupo = false;
                }
            }
            console.log(errorNoCalculoGrupo);
            

            if ($('#archivo').val() == 0) {
                errorImportarCartera = true;                                        
            }

            if (errorImportarCartera) {
                opts.text = 'Debes seleccionar el archivo correspondiente a la cartera de deudores, para importar sus datos.';
                $.pnotify(opts); 
            } else if ($('#totalDeuda').val() == '') {
                opts.text = 'Debes seleccionar el campo que representa la deuda en $.';
                $.pnotify(opts); 
            } else if (errorEtiquetaIndicadores) {
                opts.text = 'Debes ingresar la/s etiqueta/s del indicador de recupero.';
                $.pnotify(opts); 
            } else if (errorNoCalculoGrupo) {
                opts.text = 'Debes definir al menos un indicador de recupero de tipo calculo \"GRUPO\" para poder gestionar la cartera de deudores.';
                $.pnotify(opts); 
            } else {
                $(form).submit();                
            }            

        }  )
        ", $data)
);

?>


<div class="carteras form">
    <?php echo $this->Form->create('Cartera', array(
                                                    'type' => 'file',
                                                    )
                                  ); ?>
    <fieldset>
        <legend><?php echo __('Registrar Cartera de Deudores'); ?></legend>
        <?php
        echo $this->Form->input('nombre', array(
                                            'required' => true,
                                            'placeholder' => 'Ingresa un nombre descriptivo que identifique la cartera.',
                                            'title' => 'Campo requerido',
                                                        )
                                        );
        echo $this->Form->input('clientes_id', array(
                                                        'id' => 'comboClientes',
                                                    )
                                );


        
        $estado = $this->Form->radio('estado', array(
                                                        'P' => 'Potencial', 
                                                        'A'=> 'Asignada',
                                                        ), 
                                                  array(
                                                            'value' => 'P',
                                                            'class' => 'combo_estado_cartera',
                                                            'legend' => 'Estado',
                                                      )
                                        );
                
        echo $this->Html->tag('div', $this->Html->tag('span', $estado), array(
                                                'id' => 'contenedorRadio'
                                                )
                        );  
                                
        echo $this->Form->input('idAsignacionLogisis', array(
                                                            'disabled' => true,
                                                            'required' => true,
                                                            'id' => 'idAsignacionLogisis',
                                                            'placeholder' => 'Ingresa el identificador de asignacion en Logisis',
                                                            )
                                        );
        
        
        
        
        echo $this->Form->input('Cartera.comision', array(
                                                                'value' => '15.00',
                                                                'id' => 'comision',
                                                                'label' => 'Comision %',
                                                                'required' => true,
                                                                'placeholder' => 'Ingresa el porcentaje de comision que se cobrara al cliente.',
                                                            )
                                );

        foreach ($indicadoresGenerales as $indicadores) {
            foreach ($indicadores as $etiqueta => $valores) {
                echo $this->Form->input(sprintf('Cartera.Indicadores.%s', $valores['id']), array('options' => $valores['valores'], 'empty' => sprintf('Seleccione %s', $etiqueta), 'label' => $etiqueta));
            }
        }
               
        $btnImportar = $this->Html->tag('span', 
                            sprintf('%s %s', 
                                $this->Html->tag('span', 'Importar Cartera...', array()),
                                $this->Form->input('fileupload', 
                                                            array(
                                                                    'type' => 'file',
                                                                    'name' => 'files[]',
                                                                    'id' => 'fileupload',
                                                                    'label' => false,
                                                                    'div' => false,
                                                                )
                                                            )
                            ),
                            array(
                                'class' => 'btn btn-success fileinput-button'
                                )
                            );
        
        $progressBar = $this->Html->div(  'progress', 
                                $this->Html->div('progress-bar progress-bar-success', '', array()),
                                array('id' => 'progress')
                            );
        
        echo $this->Html->div('controlesImportar', $this->Html->tag('div', $btnImportar) . $progressBar, array('id' => 'controlesImportar'));
      
        echo $this->Form->input('archivo', array(
                                                'value' => 0,
                                                'id' => 'archivo',
                                                'type' => 'hidden',
                                                )
                                        );
                
        echo $this->Html->div('columnas', '', array('id' => 'columnas'));

//        echo $this->Form->input('guardar', array('type' => 'hidden', 'value' => 0, 'id' => 'guardar'));

//        echo '<div class="submit">';
//        echo $this->Form->button('Guardar cartera', array('id' => 'btnSubmit'));
//        echo '</div>';
        ?>
    </fieldset>
    <?php echo $this->Form->end('Guardar cartera'); ?>
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