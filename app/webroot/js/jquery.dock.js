/*
 * iconDock jQuery plugin 
 * http://icon.cat/software/iconDock
 *
 * Version: 0.8 beta
 * Date: 2/05/2007
 *
 * Copyright (c) 2007 Isaac Roca & icon.cat (iroca@icon.cat)
 * Dual licensed under the MIT-LICENSE.txt and GPL-LICENSE.txt
 *
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 * 
 */


jQuery.mouseX = 0;
jQuery.mouseY = 0;

jQuery(document).mousemove(function(e){ 
		  var tempX = 0;
		  var tempY = 0;
		
		  if (jQuery.browser.msie) {
			tempX = event.clientX + document.body.scrollLeft;
			tempY = event.clientY + document.body.scrollTop;
		  } else {  
			tempX = e.pageX;
			tempY = e.pageY;
		  }  
		  if (tempX < 0){tempX = 0}
		  if (tempY < 0){tempY = 0}  

		  jQuery.mouseX = tempX;
		  jQuery.mouseY = tempY;
		  return true;
});

jQuery.getPosY = function(obj) {
		var curtop = 0; 
		if (obj.offsetParent)
		{
			while (obj.offsetParent)
			{
				 curtop += obj.offsetTop;
				 obj = obj.offsetParent;
			}
		}
		else if (obj.y) curtop += obj.y;
		
		return curtop;
};

jQuery.getPosX = function(obj) {
		var curleft = 0;
		if (obj.offsetParent)
		{
			while (obj.offsetParent)
				{
					 curleft += obj.offsetLeft;
					 obj = obj.offsetParent;
				}
			}
		else if (obj.x) curleft += obj.x;
		
		return curleft;
};

var defaultConf = {iconMinSide : 35, iconMaxSide : 70, distAttDock : 100, coefAttDock : 2, veloOutDock : 1000, valign: 'middle' };

var docks=new Array();
var preloadImgs=new Array();
	
var dock = function (conf) {
	this.e = new Array();
	this.divDock = null;
	this.pareDock = null;
	this.isMoving = false;
	if (conf==undefined) {
		this.conf = defaultConf;
	} else {
		this.conf = conf;
	}
};

var dockElement = function () {
	this.imgDock = null;
	this.srcSmall = '';
	this.srcBig = '';
	this.titol = '';
	this.descripcio = '';
	this.href = '#';
	this.costatActual = 0;
	this.costatFinal = 0;
};

var resetDock = function(id) {
	var strHTML,resta,ptop,pbottom,divWidth,lastover;
	
	docks[id].dockPare.attr("align","center");
			
	strHTML="";
	divWidth=0;
	
	jQuery(docks[id].e).each(function(i) { 
		resta=docks[id].conf.iconMaxSide-this.costatActual;
		switch (docks[id].conf.valign) {
			case 'bottom': ptop=resta; pbottom=0; break;
			case 'middle': ptop=resta/2; pbottom=resta/2; break;
			case 'top': ptop=0; pbottom=resta; break;							
		}	
		
		strHTML+='<a style="margin: 0; border:0;" href="'+this.href+'" title="'+this.descripcio+'"><img alt="'+this.titol+'" style="padding: '+ptop+'px 0 '+pbottom+'px 0; margin:0; border:0;" width="'+this.costatActual+'" height="'+this.costatActual+'" src="'+((this.costatActual>docks[id].conf.iconMinSide)? this.srcBig  : this.srcSmall)+'" /></a>';	
		
		divWidth+=this.costatActual;
	});
	
	strHTML="<div class=\"docking\" style=\"margin:0; padding:0; border:0; width: "+divWidth+"px; height:"+docks[id].conf.iconMaxSide+"px; \">"+strHTML+"</div>";
	
	
	docks[id].dockPare.html(strHTML);
	
	bigimg=new Array();

	bigimg.push(new Image());
	bigimg[bigimg.length-1].src=this.srcBig;
	
	
	
	docks[id].divDock = jQuery("div.docking",docks[id].dockPare);
	
	jQuery("img",docks[id].divDock).each(
		function(i) { 			
			docks[id].e[i].imgDock=this;
		}
	);
	

	docks[id].divDock.mousemove(
		function() { 
			inDock(id); 
			if (docks[id].isMoving) moveDock(id,lastOver); 
		}
	);
	
	docks[id].divDock.hover(
		function() {
			a=new Date();
			lastOver=a.getTime();
			inDock(id); 
			overDock(id,lastOver);
		},
		function() { 
			jQuery(docks[id].e).each(function(i) {
				this.costatFinal = docks[id].conf.iconMinSide;
			});
			outDock(id);
			docks[id].isMoving=false;
		}
	);	
};

var startDock = function(id) {
	jQuery(docks[id].e).each(function(i) { 			
			this.costatActual = docks[id].conf.iconMinSide;
			this.costatFinal = docks[id].conf.iconMinSide;			
	});
	resetDock(id);
};


var overDock = function(id,lastOver) {
	var recrida=false;
	
	jQuery("a",docks[id].divDock).each(function(i) {
		if(docks[id].e[i].costatActual<docks[id].e[i].costatFinal) recrida=true;
	});
	
	if (recrida) {
		inDock(id); 
		moveDock(id,lastOver);
		setTimeout("overDock("+id+","+lastOver+");",60);
	} else {
		docks[id].isMoving=true;
	}
};

var actDock = function (id,i,costat) {
		var img=docks[id].e[i].imgDock;
		var resta,ptop,pbottom,ampladaFinal;
		costat=Math.round(costat);
		resta=docks[id].conf.iconMaxSide-costat;
		switch (docks[id].conf.valign) {
			case 'bottom': ptop=resta; pbottom=0; break;
			case 'middle': ptop=resta/2; pbottom=resta/2; break;
			case 'top': ptop=0; pbottom=resta; break;							
		}
		img.src=(costat>docks[id].conf.iconMinSide)? docks[id].e[i].srcBig  : docks[id].e[i].srcSmall; 
		ampladaFinal=parseInt(docks[id].divDock.css("width"))+costat-docks[id].e[i].costatActual;
		jQuery(img).css("padding", ptop+"px 0px "+pbottom+"px 0px" );
		docks[id].divDock.css("width" , ampladaFinal );
		img.width=costat;
		img.height=costat;
		docks[id].e[i].costatActual=costat;
	};
	
	
var outDock = function (id) {
	var tamanyPas=parseInt((docks[id].conf.iconMaxSide-docks[id].conf.iconMinSide)*100/docks[id].conf.veloOutDock);
	var recrida=false;
	
	jQuery(docks[id].e).each( function (i) {
			var costat;
				if ((this.costatActual-tamanyPas)>docks[id].conf.iconMinSide) { 
					recrida=true;
					costat=this.costatActual-tamanyPas;
				} else {
					costat=docks[id].conf.iconMinSide;
				}
				actDock(id,i,costat);
		});	
		if (recrida) {
			setTimeout("outDock("+id+")",100);
		} else {
			startDock(id);
		}
};

var inDock = function (id) {
	var diferencia,k;
	diferencia=docks[id].conf.iconMaxSide-docks[id].conf.iconMinSide;
	k=Math.pow(docks[id].conf.distAttDock,docks[id].conf.coefAttDock);

	jQuery("a",docks[id].divDock).each( function (i) {
			var distancia=Math.abs(jQuery.mouseX-jQuery.getPosX(this)-parseInt(docks[id].e[i].costatActual/2));
			var calc=-(diferencia*Math.pow(distancia, docks[id].conf.coefAttDock))/k;
			var costat = (calc<-diferencia)? docks[id].conf.iconMaxSide-diferencia : docks[id].conf.iconMaxSide+calc;
			docks[id].e[i].costatFinal=costat;
	});

};
	
var moveDock = function (id,lastOver) {
	var difOver,factorOv,a;
	
	a=new Date();
	difOver=a.getTime()-lastOver;
	factorOv=(difOver/docks[id].conf.veloOutDock<1)? difOver/docks[id].conf.veloOutDock : 1;

	jQuery(docks[id].e).each( function (i) {
		var factor,costat;
		if (factorOv<1) {
			costat=docks[id].conf.iconMinSide+(this.costatFinal-docks[id].conf.iconMinSide)*factorOv;
		} else {
			costat=this.costatFinal;
		}
		if(difOver>60) actDock(id,i,costat);
	});
};
	
	
jQuery.fn.extend({
   addDockEffect: function(conf) {
		var id=docks.length;
		docks.push(new dock(conf));
		
		docks[id].dockPare=this;
	
		jQuery("a",docks[id].dockPare).each(function (i) {	
			var imgInt,aInt,imgsrc,liopunt,liobarra,aname,imgalt,ptop,pbottom;
			docks[id].e.push(new dockElement());	
			imgInt=jQuery("img", this);
			aInt=jQuery(this);
				
			imgsrc=imgInt.attr("src"); 
			liopunt=imgsrc.lastIndexOf("."); 
			liobarra=imgsrc.lastIndexOf("_"); 
			
			docks[id].e[i].srcSmall=imgsrc;  
			docks[id].e[i].srcBig=imgsrc.substr(0,liobarra)+'_'+docks[id].conf.iconMaxSide+imgsrc.substr(liopunt,imgsrc.length-1);
			preloadImgs.push(new Image());
			preloadImgs[preloadImgs.length-1].src=docks[id].e[i].srcBig;
			
			
			docks[id].e[i].descripcio=aInt.attr("title");
			
			docks[id].e[i].href=aInt.attr("href");	
			
			aname=aInt.attr("name");	
			imgalt=imgInt.attr("alt");
			
			docks[id].e[i].titol=(aname)? aname : (imgalt)? imgalt : docks[id].e[i].descripcio.substr(6,16)+"..." ;
		});
		startDock(id);
		
     return this;
   }
});