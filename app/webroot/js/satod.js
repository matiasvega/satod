/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
  // Para el menu accordion 
//  $(function() {
//		var icons = {
//			header: "ui-icon-circle-arrow-e",
//			activeHeader: "ui-icon-circle-arrow-s"
//		};
//		$( "#accordion" ).accordion({
//			icons: icons
//		});
//		$( "#toggle" ).button().click(function() {
//			if ( $( "#accordion" ).accordion( "option", "icons" ) ) {
//				$( "#accordion" ).accordion( "option", "icons", null );
//			} else {
//				$( "#accordion" ).accordion( "option", "icons", icons );
//			}
//		});
//	});
    
//    $('.tablaInforme').dataTable();
    $('select').chosen({width: "100%"});
    
    // Para el arbol de costos
    var dockOptions = { 
        align: 'top', // horizontal menu, with expansion DOWN from a fixed TOP edge
        size: 48,
        sizeMax: 96,
        labels: true  // add labels (defaults to 'br')
    };
    
    $('#menu').jqDock(dockOptions);

    

    
    
});






