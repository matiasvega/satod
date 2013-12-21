<?php
// load vendor class
App::import('Vendor', 'PHPExcel/Classes/PHPExcel');

if (!class_exists('PHPExcel')) {
        throw new CakeException('Vendor class PHPExcel not found!');
}

$style['indicadorTitulo'] = array(
    'name' => 'Arial',
    'size' => '16',
    'bold' => true,
    'color' => array(
        'rgb' => 'FF0000'
    )
);

$style['indicador'] = array(
    'name' => 'Arial',
    'size' => '12',
    'bold' => true,
    'color' => array(
        'rgb' => '000000'
    ),        
);

$style['encabezadoTabla'] = array(
    'name' => 'Arial',
    'size' => '12',
    'bold' => true,
    'borders' => array(
        'allborders' => array(
               'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array(
                        'rgb' => '000000',
                                )
        ),
    ),
    'color' => array(
        'rgb' => '000000'
    ),
);

$style['pieTabla'] = array(
    'name' => 'Arial',
    'size' => '12',
    'bold' => true,
    'color' => array(
        'rgb' => '000000'
    ),
    'borders' => array(
        'allborders' => array(
               'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);

$style['contenidoTabla'] = array(
    'name' => 'Arial',
    'size' => '12',
    'bold' => false,
    'color' => array(
        'rgb' => '000000'
    ),
    'borders' => array(
        'allborders' => array(
               'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    ),
);


// Read the template file
$inputFileType = 'Excel5';
$inputFileName = WWW_ROOT . '/files/template.xls';

$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($inputFileName);


$objPHPExcel = $objReader->load($inputFileName);
// Add your new data to the template
//$objPHPExcel->getActiveSheet()->insertNewRowBefore(4,1);

// Muestro los datos de encabezado
$datosEncabezado = array(
                        'fecha' => sprintf('Fecha: %s', date("d-m-Y")),
                        'cliente' => sprintf('Empresa Cliente: %s', $datos['Cliente']['nombre']),
                        'cartera' => sprintf('Cartera: %s', $datos['Cartera']['nombre']),
                    );

$filaMax = 0;
$fila = 15;
foreach ($datosEncabezado as $dato) {
    $objPHPExcel->getActiveSheet()->setCellValue(sprintf('G%s', $fila), $dato);    
    $fila++;
}
$filaMax = $fila;


// Muestro los indicadores generales de recupero
$valoresPonderados = null;
if (!empty($datos['Indicadore'])) {
    foreach ($datos['Indicadore'] as $indicador) {
        if ($indicador['tipo'] == 'G') {
            foreach ($indicador['IndicadoresValore'] as $indicadoreValores) {
                if ($indicadoreValores['id'] == $indicador['CarterasIndicadore']['indicadores_valores_id']) {
                    $datosIndicadoresGenerales[] = sprintf('%s : %s', $indicador['etiqueta'], $indicadoreValores['valor']);
                    $valoresPonderados[] = $indicadoreValores['valor_ponderado'];                    
                }
            }
        }
    }
}

$fila++;
$objPHPExcel->getActiveSheet()->setCellValue(sprintf('B%s', $fila), 'Indicadores generales de recupero');
$objPHPExcel->getActiveSheet()
        ->getStyle(sprintf('B%s', $fila))
        ->getFont()
        ->applyFromArray($style['indicadorTitulo']);
$fila++;

//$fila = $filaMax = 21;
//dd($datosIndicadoresGenerales);
foreach ($datosIndicadoresGenerales as $dato) {
    $objPHPExcel->getActiveSheet()->setCellValue(sprintf('B%s', $fila), $dato);
    $objPHPExcel->getActiveSheet()
        ->getStyle(sprintf('B%s', $fila))
        ->getFont()
        ->applyFromArray($style['indicador']);
    $fila++;
}
$objPHPExcel->getActiveSheet()->setCellValue(sprintf('B%s', $fila), sprintf('%s : %s', 'Porcentaje estimado de recupero', array_sum($valoresPonderados) . '%.'));
$objPHPExcel->getActiveSheet()
        ->getStyle(sprintf('B%s', $fila))
        ->getFont()
        ->applyFromArray($style['indicador']);

$fila = $fila + 2;


$filaMax = $fila;

// Muestro los indicadores particulares de recupero
if (!empty($datos['Indicadore'])) {
    foreach ($datos['Indicadore'] as $indicador) {
        if ($indicador['tipo'] == 'P') {
            if ($indicador['calculo'] != 'group') {
                    $datosIndicadoresParticulares[] = sprintf('%s : %s', $indicador['etiqueta'], nro($indicador['IndicadoresValore'][0]['valor_ponderado']));
                }
        }
    }
}

$fila++;
$objPHPExcel->getActiveSheet()->setCellValue(sprintf('B%s', $fila), 'Indicadores particulares de recupero');
$objPHPExcel->getActiveSheet()
        ->getStyle(sprintf('B%s', $fila))
        ->getFont()
        ->applyFromArray($style['indicadorTitulo']);
$fila++;


//$fila = $filaMax = 26;
foreach ($datosIndicadoresParticulares as $dato) {
    $objPHPExcel->getActiveSheet()->setCellValue(sprintf('B%s', $fila), $dato);
    $objPHPExcel->getActiveSheet()
        ->getStyle(sprintf('B%s', $fila))
        ->getFont()
        ->applyFromArray($style['indicador']);
    $fila++;
}
$filaMax = $fila;        

// Muestro los indicadores particulares de recupero de GRUPO
if (!empty($datos['Indicadore'])) {
    $incidencia = $comision = null;
    foreach ($datos['Indicadore'] as $indicador) {        
        if ($indicador['tipo'] == 'P') {
            if ($indicador['calculo'] == 'group') {
                $totalDeuda = array_sum(Set::extract($indicador['IndicadoresValore'], '{n}.valor_ponderado'));           
                foreach ($indicador['IndicadoresValore'] as $valores) {
                    $datosIndicadoresParticularesGrupo[ucwords($indicador['etiqueta'])][] = array(
                        ucwords($indicador['etiqueta']) => $valores['valor'],
                        'DEUDA' => round($valores['valor_ponderado'], 2),
                        '% INCIDENCIA' => sprintf('%s', round((($valores['valor_ponderado'] / $totalDeuda) * 100), 2)),
                        'COMISION' => round((($valores['valor_ponderado'] * $datos['Cartera']['comision']) / 100), 2),
                    );
                                                
                    $incidencia[$indicador['etiqueta']][] = (($valores['valor_ponderado'] / $totalDeuda) * 100);
                    $comision[$indicador['etiqueta']][] = (($valores['valor_ponderado'] * $datos['Cartera']['comision']) / 100);
                }
            }
        }
    }
}
//d($incidencia);
//dd($comision);
//dd($datosIndicadoresParticularesGrupo);

$fila = $filaMax = 33;
//dd($datosIndicadoresParticularesGrupo);
foreach ($datosIndicadoresParticularesGrupo as $etiquetaIndicador => $datosIndicador) {
    $fila++;
    $objPHPExcel->getActiveSheet()->setCellValue(sprintf('B%s', $fila), $etiquetaIndicador);
    $objPHPExcel->getActiveSheet()
        ->getStyle(sprintf('B%s', $fila))
        ->getFont()
        ->applyFromArray($style['encabezadoTabla']);
    $filaTitulo = $fila;
    $fila++;
    
    foreach ($datosIndicador as $datoIndicador) {
        $columna = 1;
        foreach (array_keys($datoIndicador) as $etiquetaTitulo) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna, $filaTitulo, $etiquetaTitulo);
            $objPHPExcel->getActiveSheet()
                ->getStyleByColumnAndRow($columna, $filaTitulo)
                ->getFont()
                ->applyFromArray($style['encabezadoTabla']);
            $columna++;
        }
        
        $columna = 1;
        foreach ($datoIndicador as $dato) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna, $fila, $dato);
            $objPHPExcel->getActiveSheet()
                ->getStyleByColumnAndRow($columna, $fila)
                ->getFont()
                ->applyFromArray($style['contenidoTabla']);
            $columna++;
        }        
        $fila++;
        
        $totales = array(
                    'TOTAL', 
                    round(array_sum(Set::extract(sprintf('%s.{n}.DEUDA', $etiquetaIndicador), $datosIndicadoresParticularesGrupo)), 2), 
                    round(array_sum($incidencia[$etiquetaIndicador]), 2), 
                    round(array_sum($comision[$etiquetaIndicador]), 2), 
                );

        $columna = 1;
        foreach ($totales as $total) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna, $fila, $total);
            $objPHPExcel->getActiveSheet()
                ->getStyleByColumnAndRow($columna, $fila)
                ->getFont()
                ->applyFromArray($style['pieTabla']);
            $columna++;
        }
    }
    $fila++;
}

 
// Write out as the new file
$outputFileType = 'Excel5';
$outputFileName = (sprintf('Cartera_%s_%s.xls', str_replace(' ', '_', $datos['Cartera']['nombre']), str_replace(' ', '_', $datos['Cliente']['nombre'])));

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$outputFileName.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $outputFileType);
$objWriter->setTempDir(TMP); 
$objWriter->save('php://output');
?>