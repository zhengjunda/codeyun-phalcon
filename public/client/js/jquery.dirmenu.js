(function($){
//~~~~~~~~~~~~~~~~~~~~~~~~
$.fn.setEvent=function(){
	if(!!document.all){return;}
	if(window.addEventListener){
		window.constructor.prototype.__defineGetter__('event',_Event=function(){
			var _caller=_Event.caller;
			while(_caller!=null){var _argument=_caller.arguments[0];if(_argument){if(_argument.constructor.toString().indexOf('Event')!=-1){return _argument;}}_caller =_caller.caller;}
			return null;
		});
	}
};
$.fn.setMenu=function(data,element_id){
	this.mouseover(function(obj){
		this.oncontextmenu=function(){
			if(!!document.all){event.returnValue=false;event.cancelBubble=true;}else{event.preventDefault();event.stopPropagation();}
			if(!data){return;}
			$(window).unContext();
			$('body').setContext(data,element_id);
			$('#'+element_id).setPoint();
			$(this).loadClickCss();
			$('.cont_show,.cont_none').mouseover(function(){
				var data=$(this).attr('id');
				if(!data){
					if($.base && !$(this).attr('type')){$('#'+$.base).hide();}
					return ;
				}
				var base=data.replace('dash','elem');
				if($.base && $.base!=base && !$(this).attr('type')){$('#'+$.base).hide();}
				$.base=base;
				$('#'+$.base).show();
				$('#'+$.base).setPoint(true)
			});
		}
	});
	this.setClickCss();
	this.click(function(){$(window).unContext();});
};
$.fn.unContext=function(){return $('.css_html_menu').hide();};
$.fn.setContext=function(data,id){
	if(!id){return;}
	if($('#'+id).length==1){return $('#'+id).show();}
	var obj=document.createElement('div');
	$(obj).attr('class','css_html_menu');
	$(obj).attr('id',id);
	if(id!=id.replace('__element__','')){$(obj).hide();}
	if(!$.__zindex){$.__zindex=88;}else{$.__zindex++;}
	$(obj).css('z-index',$.__zindex);
	$(obj).setElements(data);
	return this.append(obj);
};
$.fn.setElements=function(data,create){
	for(elem in data){
		if(!!create){this.setElement(data[elem]);continue;}
		var id=this.attr('id');
		if(id!=id.replace('__element__','')){data[elem]['type']='__element__';}
		var conf=this.resetData(data[elem]);
		this.setElement(conf);
	}
};
$.fn.setElement=function(data,dash){
	var obj=document.createElement('div');
	for(elem in data){
		if(elem=='html'){
			if(typeof data[elem]=='object'){$(obj).setElements(data[elem],true);continue;}
			$(obj).html(data[elem]);
			continue;
		}
		if(elem=='dash'){
			var dataNum=Math.random();
			dataNum='__element__'+dataNum.toString().replace('.','');
			$(obj).attr('id','dash'+dataNum);
			$('body').setContext(data['dash'],'elem'+dataNum);
			continue;
		};
		$(obj).attr(elem,data[elem]);
	}
	this.append(obj);
};
$.fn.setPoint=function(is){
	var wNum=this.width();
	var hNum=this.height();
	if(!!is){
		var id=this.attr('id').replace('elem','dash');
		var xNum=$('#'+id).offset().left+$('#'+id).width();
		var yNum=$('#'+id).offset().top;
		if((wNum+xNum)>$(window).width()){xNum=xNum-wNum*2;}
	}else{
		var xNum=event.clientX;
		var yNum=event.clientY;
		if((wNum+xNum)>$(window).width()){xNum=xNum-wNum;}
	}
	if((hNum+yNum)>$(window).height()){yNum=yNum-hNum;}
	this.offset({top:yNum,left:xNum});
};
$.fn.resetData=function(data){
	var conf={'class':'html_menu','html':[]};
	if(!data['class']){data['class']='menu_show';}
	if(!!data['dash']){
		conf['html'][0]={'class':'menu_dash','html':'&nbsp;'};
	}
	if(data['class']=='cont_line'){
		conf['html'][1]={'class':'menu_line06','html':'&nbsp;'};
	}else{
		conf['html'][1]={'class':'menu_line26','html':'&nbsp;'};
	}
	conf['html'][2]={'class':'menu_cont','html':[data]};
	return conf;
};
$.fn.setClickCss=function(){
	this.click(function(){$(this).loadClickCss();});
};
$.fn.loadClickCss=function(){
	var names=['item_over','item_click'];
	if(!$.init){
		if(!event.ctrlKey){$('.body_item').removeClass(names[1]).addClass(names[0]);}
		$.init=true;
	}else{return $.init=false;}
	if(this.attr('id') || !$.init){$.init=false;return;}
	this.removeClass(names[0]).addClass(names[1]);
	setTimeout(this.loadClickCss,100);
};
//~~~~~~~~~~~~~~~~~~~~~~~~
})(jQuery);