<script type="text/javascript">
    $(document).ready(function() {
        $('.fecha').val(' ');
        
        $('.tituloIndicadores').bind('click', function(){
//            $(window).scrollTop($('#indicadores').offset().top);
            $('#indicador_'+$(this).attr('id')).toggle('blind', 100);            
        });
        
//        $('.selectEstrategia').chosen({width: "100%", disable_search_threshold: 10});

    });

</script>


<?php

if (!empty($indicadores)) {
    $htmlIndicadores = array();            

    $htmlIndicadores[] = $this->Html->tag('h1', 'Selecciona las fechas y estrategia de gestion para cada indicador de recupero que deseas gestionar');
    
    foreach ($indicadores as $k => $indicador) {                
        $htmlTablaIndicadores = null;
        $htmlTablaIndicadores[] = $this->Html->tableHeaders(
                array(
                    'Valor',
                    'Fecha inicio',
                    'Fecha fin',
                    'Estrategia'
                )
        );
        
        foreach ($indicador['IndicadoresValore'] as $k => $indicadoresValores) {
            $htmlTablaIndicadores[] = $this->Html->tableCells(
                    array(
                        array(
                            $indicadoresValores['valor'],
                            $this->Form->input(sprintf('DetallesPlanificacione.%s.fecha_inicio', $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor'])))), array(
                                'type' => 'text',
                                'label' => false,
                                'id' => sprintf('from_%s', $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor'])))),
                                'class' => 'fechaInicio',
                            )),
                            $this->Form->input(sprintf('DetallesPlanificacione.%s.fecha_fin', $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor'])))), array(
                                'type' => 'text',
                                'label' => false,
                                'id' => sprintf('to_%s', $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor'])))),
                                'class' => 'fechaFin',
                            )),
                            $this->Form->input(sprintf('DetallesPlanificacione.%s.estrategias_id', $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor'])))), array(
                                'options' => $estrategias,
                                'empty' => 'Seleccionar estrategia',
                                'label' => false,
                                'class' => 'selectEstrategia',
                            )),
                            $this->Form->input(sprintf('nationalDays_%s', $k), array(
                                'type' => 'hidden',
                                'label' => false,
                                'id' => sprintf('nationalDays_%s', $k),
                                'class' => 'nationalDays',
                            )),
                        )
                    )
            );

            $htmlTablaIndicadores[] = $this->Form->input(sprintf('DetallesPlanificacione.%s.carteras_indicadores_id', $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor'])))), 
                                                        array(  'type' => 'hidden', 
                                                                'value' => $indicadoresValores['id']
                                                                )
                                                    );
            $htmlTablaIndicadores[] = sprintf("<script>
                    $(document).ready(function() {
                    
                            function buscarFecha(desde, hasta, fechas) {
                                var adDesde = desde.split('-');
                                var dDesde = new Date(adDesde[2], adDesde[1]-1, adDesde[0], 0, 0, 0, 0);

                                var adHasta = hasta.split('-');
                                var dHasta = new Date(adHasta[2], adHasta[1]-1, adHasta[0], 0, 0, 0, 0);

                                var milisegundosDia = parseInt(1*24*60*60*1000);
                                var fecha = new Date();                                                
                                for (dia = dDesde.getTime(); dia <=dHasta.getTime(); dia = dia+milisegundosDia) {
                                    fecha.setTime(dia);
                                    var m = fecha.getMonth(), d = fecha.getDate(), y = fecha.getFullYear();
                                    if($.inArray(d + '-' + (m+1) + '-' + y, fechas) != -1) {
                                        return true;
                                    }
                                }
                                return false;
                            }

                            function selectedDays() {
                                var arrayNationalDays = jQuery.makeArray($('.nationalDays'));
                                var arrayPeriodos = new Array();
                                    
                                if (arrayNationalDays.length > 0) {                                    
                                    for (i=0;i<arrayNationalDays.length;i++) {
                                        if($(arrayNationalDays[i]).val() != '' ) {
                                            arrayPeriodos.push($(arrayNationalDays[i]).val());
                                        }                                                
                                    }
                                }

                                if (arrayPeriodos.length > 0) {
                                    var aDisabledDays = new Array();
                                    for (j=0;j<arrayPeriodos.length;j++){
                                        var disabledDays =  arrayPeriodos[j].split('/');

                                        var adDesde = disabledDays[0].split('-');
                                        var dDesde = new Date(adDesde[2], adDesde[1]-1, adDesde[0], 0, 0, 0, 0);

                                        var adHasta = disabledDays[1].split('-');
                                        var dHasta = new Date(adHasta[2], adHasta[1]-1, adHasta[0], 0, 0, 0, 0);

                                        var milisegundosDia = parseInt(1*24*60*60*1000);
                                        var fechaDisabled = new Date();                                                
                                        for (dia = dDesde.getTime(); dia <=dHasta.getTime(); dia = dia+milisegundosDia) {
                                            fechaDisabled.setTime(dia);                                                    
                                            var fechaAux = (fechaDisabled.getDate().toString() + '-' + (fechaDisabled.getMonth()+1) + '-' + fechaDisabled.getFullYear());                                                    
                                            aDisabledDays.push(fechaAux);
                                        }
                                        aDisabledDays.sort();
                                    }
                                }
                                return aDisabledDays;
                            }


                            function nationalDays(date) {                                                                        
                                    if ($('#nationalDays_%s').val() === undefined) {
                                        return [true];
                                    } else {
                                        aDisabledDays = selectedDays();
                                        if (aDisabledDays) {
                                            var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
    //                                        console.log('Checking (raw): ' + m + '-' + d + '-' + y);
                                            for (i = 0; i < aDisabledDays.length; i++) {
                                                    if($.inArray(d + '-' + (m+1) + '-' + y, aDisabledDays) != -1 || new Date() > date) {
        //                                                    console.log('bad:  ' + d + '-' + (m+1) + '-' + y + ' / ' + aDisabledDays[i]);
                                                            return [false];
                                                    }
                                            }
//                                    console.log('good:  ' + (m+1) + '-' + d + '-' + y);                                        
                                        }
                                        return [true];                                        
                                    }
                            }
                            

                            $('#from_%s').datepicker({
                                    defaultDate: '+1w',
                                    changeMonth: true,
                                    numberOfMonths: 2,
                                    showAnim: 'slide',
                                    dateFormat: 'dd-mm-yy',
                                    minDate: $('#from').val(),
                                    maxDate: $('#to').val(),
                                    beforeShowDay: nationalDays,
                                    onClose: function(selectedDate) {
                                            $('#to_%s').datepicker('option','minDate', selectedDate );
                                    }
                            });
                            $('#to_%s').datepicker({
                                    defaultDate: '+1w',
                                    changeMonth: true,
                                    numberOfMonths: 2,
                                    showAnim: 'slide',
                                    dateFormat: 'dd-mm-yy',
                                    minDate: $('#from').val(),
                                    maxDate: $('#to').val(),
                                    beforeShowDay: nationalDays,
                                    onClose: function(selectedDate) {
//                                        console.log(selectedDate);
//                                        console.log($('#from_%s').val());
                                        // Si el periodo seleccionado incluye dias que ya fueron 
                                        // seleccionados, no se debe permitir seleccionar.
                                        var selectedDates = selectedDays();
//                                        console.log(selectedDates); 
                                        
                                        // me tengo que fijar si alguno de los dias comprendidos en este nuevo periodo 
                                        // ya existe en el array que me devuelve la funcion
                                        if(buscarFecha($('#from_%s').val(), selectedDate, selectedDates)){
                                                                                    
                                            var opts = {
                                                    cornerclass: \"\",
                                                    width: \"30%%\",
                                                    styling: 'jqueryui',
                                                    animation: 'show',
                                                    title: \" ERROR \",
                                                    type: \"error\",
                                            };

                                            opts.text = 'No se pueden seleccionar periodos de tiempo que contengan dias ya abarcados por otro periodo seleccionado anteriormente.';
                                            $.pnotify(opts);


                                            $('#nationalDays_%s').val('/');
                                            $('#from_%s').val('');
                                            $('#to_%s').val('')
                                        } else {
                                            $('#nationalDays_%s').val($('#from_%s').val() + '/' + selectedDate);
                                        }                                        
                                    }
                            });

                    });
                </script>",                             
                            $k-1, 
                            $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor']))), 
                            $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor']))),
                            $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor']))),
                            $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor']))),
                            $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor']))),
                            $k,
                            $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor']))),
                            $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor']))),
                            $k,
                            $k.'_'.strtolower(trim(str_replace(' ', '_', $indicadoresValores['valor']))));
        }
        
        $htmlIndicadores[] = $this->Html->tag(
                                'h2', 
                                sprintf('Indicador de recupero %s', $indicador['Indicadore']['etiqueta']),
                                array(  'class' => 'tituloIndicadores ui-widget-header ui-corner-all ui-dialog-title',
                                        'id' => $k)
                            );
        $htmlIndicadores[] = $this->Html->tag(
                                'div', 
                                $this->Html->tag('table', implode("\n", $htmlTablaIndicadores)), 
                                array(  
                                        'id' => sprintf('indicador_%s', $k),
                                        'class' => 'ui-widget-content ui-corner-all'
                                    )
                            );
        
    }

    echo implode("\n", $htmlIndicadores);
} else {
    echo sprintf("
            <script type='text/javascript'>
                $(document).ready(function() {
                    $(location).attr('href', '%s/satod/planificaciones/add');
                })
            </script>
        ", FULL_BASE_URL);
}

?>
