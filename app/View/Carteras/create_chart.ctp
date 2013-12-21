
<html>
  <head>
    <script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/rgbcolor.js"></script> 
    <script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/canvg.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!--    <script type="text/javascript">
        $(document).ready(function() {
            $('#grafica').bind('ready', function() {
                saveAsImg(document.getElementById('grafica'));
                console.log('xxxx');                            
            });

        });

    </script>-->
    <script>
      function getImgData(chartContainer) {
        var chartArea = chartContainer.getElementsByTagName('svg')[0].parentNode;
        var svg = chartArea.innerHTML;
        var doc = chartContainer.ownerDocument;
        var canvas = doc.createElement('canvas');
        canvas.setAttribute('width', chartArea.offsetWidth);
        canvas.setAttribute('height', chartArea.offsetHeight);
        
        
        canvas.setAttribute(
            'style',
            'position: absolute; ' +
            'top: ' + (-chartArea.offsetHeight * 2) + 'px;' +
            'left: ' + (-chartArea.offsetWidth * 2) + 'px;');
        doc.body.appendChild(canvas);
        canvg(canvas, svg);
        var imgData = canvas.toDataURL("image/png");
        canvas.parentNode.removeChild(canvas);
        return imgData;
      }
      
      function saveAsImg(chartContainer) {
        var imgData = getImgData(chartContainer);
        
        // Replacing the mime-type will force the browser to trigger a download
        // rather than displaying the image in the browser window.
        window.location = imgData.replace("image/png", "image/octet-stream");
      }
      
      function toImg(chartContainer, imgContainer) { 
        var doc = chartContainer.ownerDocument;
        var img = doc.createElement('img');
        img.src = getImgData(chartContainer);
        
        while (imgContainer.firstChild) {
          imgContainer.removeChild(imgContainer.firstChild);
        }
        imgContainer.appendChild(img);
      }
      
//      toImg(document.getElementById('grafica'), document.getElementById('x'));
    
      
    </script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <?php 
    
    if (isset($datos)) {
        if (!empty($datos['Indicadore'])) {
            foreach ($datos['Indicadore'] as $indicador) {                        
                if ($indicador['tipo'] == 'P') {
                    if ($indicador['calculo'] == 'group') {                                       
                        // Muestro la grafica
                        $graficaIndicadorParticular = null;
                        $graficaIndicadorParticular['options']['title'] = $indicador['etiqueta'];
                        $graficaIndicadorParticular['options']['width'] = '1100';
                        $graficaIndicadorParticular['divContenedor'] = 'grafica';
                        $graficaIndicadorParticular['tipoGrafica'] = $indicador['grafica'];

                        if($indicador['grafica'] == 'ComboChart') {
                            $graficaIndicadorParticular['options']['hAxis']['title'] = $indicador['etiqueta'];
                            $graficaIndicadorParticular['options']['vAxis']['title'] = 'Deuda';
                        }

                        $graficaIndicadorParticular['items'][] = array(
                                                                        sprintf("'%s'", $indicador['etiqueta']), 
                                                                        "'Deuda'"
                                                                        );

                        foreach ($indicador['IndicadoresValore'] as $valores) {
                            $graficaIndicadorParticular['items'][] = array(
                                                                            sprintf("'%s'", $valores['valor']), 
                                                                            round($valores['valor_ponderado'], 2)
                                                                            );
                        }

                        $htmlIndicadoresParticularesGrupo[] = $this->Googlechart->paint($graficaIndicadorParticular);


//                        $htmlIndicadoresParticularesGrupo[] = $this->Html->div('grafica', '', array('id' => 'grafica'));

//                        $htmlIndicadoresParticularesGrupo[] = $this->Html->div('x', '', array('id' => 'x'));
                    }
                }
            }               
        }
            echo implode("\n", $htmlIndicadoresParticularesGrupo);
    }
    
    ?>

  </head>
  <body>
    <div id="img_div" style="position: fixed; top: 0; right: 0; z-index: 10; border: 1px solid #b9b9b9">
      Image will be placed here
    </div>

<!--    <button onclick="saveAsImg(document.getElementById('grafica'));">Save as PNG Image</button>
    <button onclick="toImg(document.getElementById('grafica'), document.getElementById('img_div'));">Convert to image</button>-->
    <div id="grafica"></div>
    
<!--    <div id="x" style="position: fixed; top: 0; right: 0; z-index: 10; border: 1px solid #b9b9b9"> xxx </div>-->




</body>
</html>