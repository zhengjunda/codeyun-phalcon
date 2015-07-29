(function($){
//---------------------------
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
$.fn.setDialog=function(data){
	//===================================defined conf-css-style and elements--------start======990D1A AD504E 550000 DX4A2C DD6413
	this.initConf=function(conf_data){
		var js_dir=this.getJsdir();
		var conf={bground:js_dir+'../imgs/dialog/bg.jpg',back_color:'#75a6da',start_color:'#2673c4',end_color:'#75a6da',init_close:'#97c8f2',hover_close:'#c03b20',submit_value:'确定',cancel_value:'取消'};
		var data={};
		data['style']=""
		+"#show_shadow{background:url("+conf.bground+") repeat;background-color:#000;top:0px;left:0px;width:100%;height:100%;z-index:6;position:absolute;filter:alpha(opacity=50);-moz-opacity:0.50;opacity:0.50;}"
		+"#show_dialog{position:absolute;z-index:10;background:url();top:0px;left:0px;position:fixed;}"
		+"#show_dialog .gradient{text-shadow:0 1px 0 rgba(18, 91, 167, .7);background-color:"+conf.back_color+";filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='"+conf.start_color+"',endColorstr='"+conf.end_color+"');background:linear-gradient(top,"+conf.start_color+","+conf.end_color+");background: -moz-linear-gradient(top,"+conf.start_color+","+conf.end_color+");background:-webkit-gradient(linear, 0% 0%, 0% 100%, from("+conf.start_color+"),to("+conf.end_color+"));}"
		+"#show_dialog #dialog_000{border-radius:5px;position:absolute;z-index:10;background-color:#000;width:100%;height:100%;filter:alpha(opacity=70);-moz-opacity:0.70;opacity:0.70;}"
		+"#show_dialog #dialog_fff{border-radius:5px;position:absolute;z-index:16;background-color:#fff;margin-left:1px;margin-top:1px;filter:alpha(opacity=70);-moz-opacity:0.70;opacity:0.70;}"
		+"#show_dialog #dialog_dim{border-radius:5px;position:absolute;z-index:18;background-color:#000;margin-left:2px;margin-top:2px;filter:alpha(opacity=50);-moz-opacity:0.50;opacity:0.50;}"
		+"#show_dialog #dialog_txt{border-radius:5px;position:absolute;z-index:20;margin-top:7px;margin-left:7px;}"
		+"#show_dialog #dialog_txt #dialog_move{width:100%;height:24px;border-bottom:1px solid #699bd1;color:#95a7ae;font-family:Tahoma,Arial/9!important;}"
		+"#show_dialog #dialog_txt #dialog_move #dialog_title{float:left;line-height:24px;color:#eee;height:24px;text-indent:10px;font-weight:bold;}"
		+"#show_dialog #dialog_txt #dialog_move #dialog_close{float:right;width:40px;line-height:16px;height:16px;margin-right:5px;text-align:center;cursor:pointer;background-color:"+conf.init_close+";color:#536e85;font-size:18px;}"
		+"#show_dialog #dialog_txt #dialog_move #dialog_close:hover{background-color:"+conf.hover_close+";color:#fff;}"
		+"#show_dialog #dialog_txt #dialog_cont{width:100%;background-color:#fff;overflow-y:auto;overflow-x:hidden;}"
		+"#show_dialog #dialog_over{;width:100%;background-color:#fff;display:none;position:absolute;z-index:166;filter:alpha(opacity=1);-moz-opacity:0.01;opacity:0.01;top:30px;left:0px;}"
		+"#show_dialog #dialog_boot{width:100%;height:36px;text-align:right;padding-right:10px;background-color:#ddd;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#DDDDDD',endColorstr='#FFFFFF');background:linear-gradient(top,#DDD,#FFF);background:-moz-linear-gradient(top,#DDD,#FFF);background:-webkit-gradient(linear,0% 0%, 0% 100%,from(#DDD),to(#FFF));}"
		+"#show_dialog #dialog_boot input{margin-top:3px;margin-right:15px;cursor:pointer;display:inline-block;text-align:center;line-height:1;padding:4px 10px; *padding:4px 10px; *height:2em;letter-spacing:2px;font-family:Tahoma, Arial/9!important; width:auto; overflow:visible; *width:1;border-radius: 5px;box-shadow:0 1px 0 rgba(255, 255, 255, .7), 0 -1px 0 rgba(0, 0, 0, .09);}"
		+"#show_dialog #dialog_boot input:focus{outline:none 0;border-color:#426DC9;box-shadow:0 0 8px rgba(66, 109, 201, .9);}"
		+"#dialog_boot .cancel{color:#333;border:solid 1px #999;background:#DDD;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFF',endColorstr='#DDDDDD');background:linear-gradient(top, #FFF, #DDD);background: -moz-linear-gradient(top, #FFF, #DDD);background:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#FFF), to(#DDD));text-shadow:0px 1px 1px rgba(255, 255, 255, 1);}"
		+"#dialog_boot .cancel:hover{color:#000;border-color:#666;}"
		+"#dialog_boot .submit{color:#FFF;border:solid 1px #39d;background:#28c;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bbee',endColorstr='#2288cc');background:linear-gradient(top, #3be, #28c);background: -moz-linear-gradient(top, #3be, #28c);background:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#3be), to(#28c));text-shadow:-1px -1px 1px #1c6a9e; }"
		+"#dialog_boot .submit:hover{color:#FFF; border-color:#1c6a9e;}";
		data['elems']=[
			{id:'show_shadow',html:'&nbsp;'},
			{id:'show_dialog',html:[
				{id:'dialog_000'},{id:'dialog_fff'},{id:'dialog_dim'},
				{id:'dialog_txt',html:[
					{id:'dialog_move',class:'gradient',html:[{id:'dialog_title',html:'dialog_title'},{id:'dialog_close',html:'×'}]},
					{id:'dialog_cont'}
				]},
				{id:'dialog_over',html:'&nbsp;'}
			]}
		];
		$(this).loadInit(data);
		var dialog_type=(!!conf_data['type']?conf_data['type']:'iframe');
		var dialog_href=(!!conf_data['url']?conf_data['url']:'about:blank');
		$('#dialog_move').loadDownmove($('#show_dialog'),$(window).initOver);
		$('#dialog_close').click(function(){$('#show_shadow,#show_dialog').loadDisplay();});
		if(!conf_data['submit_click']){return;}
		if(conf_data['submit_value']){conf.submit_value=conf_data['submit_value'];}
		if(conf_data['cancel_value']){conf.cancel_value=conf_data['cancel_value'];}
		var boot=[
			{id:'dialog_boot',html:[
				{label:'input',type:'button',value:conf.submit_value,class:'submit button'},
				{label:'input',type:'button',value:conf.cancel_value,class:'cancel button'}
			]}
		];
		$('#dialog_txt').loadElems(boot);
	};
	//===================================defined conf-css-style and elements--------end======
	$.fn.loadAjaxhtml=function(href){
		if(!href){return;}
		var obj=this;
		$.ajax({		
			type:'get',
			url: href,
			dataType: 'json',
			success: function(data){obj.html('');
				if(!!data['link']){obj.loadLink(data['link']);}
				if(!!data['style']){obj.loadStyle(data['style']);}
				if(!!data['elems']){obj.loadElems(data['elems']);}
				if(!!data['html']){obj.loadElems([{html:data['html']}]);}
			}
		});
	};
	$.fn.loadIframe=function(iframe_src){
		if(!$.dialog_iframe_id){$.dialog_iframe_id='dialog_iframe_object';}
		this.html("<iframe id='"+$.dialog_iframe_id+"' name='"+$.dialog_iframe_id+"' src='"+iframe_src+"' style='width:100%;height:100%;overflow:hidden;border:0px;' frameborder='no'>");
	};
	$.fn.initOver=function(){
		if($.__downmove__){$('#dialog_over').show();}else{$('#dialog_over').hide();}
	}
	$.fn.getJsdir=function(name){
		if(!name){name='/';}else{name='/'+name;}
		var path='';var js=document.scripts;
		for(var i=js.length;i>0;i--){
			path=js[i-1].src;
			if(path.indexOf(name)>0){path=path.substring(0,path.lastIndexOf('/')+1);break;}
		}
		return path;
	};
	$.fn.loadInit=function(data){
		if(data['link']){$(this).loadLink(data['link']);}
		if(data['style']){$(this).loadStyle(data['style']);}
		if(data['elems']){$('body').loadElems(data['elems']);}
		$(window).setEvent();
	};
	$.fn.loadLink=function(linkUrl){
		if(!linkUrl){return;}
		var link_elem=document.createElement('link');
		$(link_elem).attr('type','text/css');
		$(link_elem).attr('rel' ,'stylesheet');
		$(link_elem).attr('href',linkUrl);
		$('head').append(link_elem);
	};
	$.fn.loadStyle=function(styleCss){
		if(!styleCss){return;}
		var style_elem=document.createElement('style');
		style_elem.type='text/css';
		if(style_elem.styleSheet){style_elem.styleSheet.cssText=styleCss;}else{style_elem.innerHTML=styleCss;} 
		$('head').append(style_elem);
	};
	$.fn.loadDisplay=function(is){
		if(!is){return this.hide();}
		this.show();
	};
	this.loadResize=function(data){
		var dialog_obj=$('#show_dialog');
		if(dialog_obj.length==0){return;}
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		var dialog_width=(!!data['width']?data['width']:560);
		var dialog_height=(!!data['height']?data['height']:260);
		var dialog_title=(!!data['title']?data['title']:'Dialog Title');
		$('#dialog_title').html(dialog_title);
		with($('#show_dialog')){width(dialog_width);height(dialog_height);}
		with($('#dialog_000')){width(dialog_width-2);height(dialog_height-2);}
		with($('#dialog_fff')){width(dialog_width-4);height(dialog_height-4);}
		with($('#dialog_dim')){width(dialog_width-6);height(dialog_height-6);}
		with($('#dialog_txt')){width(dialog_width-16);height(dialog_height-16);}
		if(data['submit_click']){
			dialog_height=dialog_height-36;
		}
		$('#dialog_cont').height(dialog_height-36);
		$('#dialog_over').height(dialog_height-36);
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		var dialog_type=(!!data['type']?data['type']:'iframe');
		var dialog_href=(!!data['url']?data['url']:'about:blank');
		if(dialog_type=='ajax'){
			$('#dialog_cont').loadAjaxhtml(dialog_href);
		}else{
			if(!$.dialog__iframe__id){
				$('#dialog_cont').loadIframe(dialog_href)
			}else{
				$($.dialog__iframe__id).src=dialog_href;
			}
		}
		//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
		var wNum=$(window).width();
		var hNum=$(window).height();
		dialog_obj.offset({
			left:(wNum-dialog_obj.width())/2,
			top :(hNum-dialog_obj.height())/2,
		});
	};
	if($('#show_shadow').length==0){
		if(!data){return;}
		this.initConf(data);
		this.loadResize(data);
	}else{
		$('#show_shadow,#show_dialog').loadDisplay(true);
		this.loadResize(data);
	}
};
$.fn.loadDownmove=function(obj,_fun){
	$(document).mouseup(function(){$.__downmove__=false;if(!!_fun){_fun();}});
	var un_select='getSelection' in window?function(){window.getSelection().removeAllRanges();}:function(){try{document.selection.empty();}catch(e){};};
	this.mousedown(function(){
		$.__downmove__=true;
		if(!!_fun){_fun();}
		var wNum=obj.width();
		var hNum=obj.height();
		var lNum=obj.offset().left;
		var tNum=obj.offset().top;
		var xNum=event.clientX;
		var yNum=event.clientY;
		var width=$(window).width();
		var height=$(window).height();
		var e_w=0,e_h=0,s_w=0,s_h=0;
		$(document).mousemove(function(){
			if(!$.__downmove__){return false;}
			e_w=event.clientX-xNum;e_h=event.clientY-yNum;
			if((width-e_w-lNum-wNum)<0){s_w=width-wNum;}else{s_w=lNum+e_w;}
			if((height-e_h-tNum-hNum)<0){s_h=height-hNum;}else{s_h=tNum+e_h;}
			if(s_w<0){s_w=0;}if(s_h<0){s_h=0;}
			un_select();obj.offset({left:s_w,top:s_h});
		});
	});
};
$.fn.loadElems=function(data,This){
	for(elem in data){this.loadElem(data[elem]);}
};
$.fn.loadElem=function(data){
	if(!data['label']){data['label']='div';}
	var obj=document.createElement(data['label']);
	for(elem in data){
		var item=elem.toString().toLowerCase();
		if(item=='label'){continue;}
		if(item=='html'){
			if(typeof data[elem]=='object'){$(obj).loadElems(data[elem],true);continue;}
			$(obj).html(data[elem]);
			continue;
		}
		if(item=='onmouseover'){
			obj.onmouseover=new Function(data[elem]);
			continue;
		};
		$(obj).attr(elem,data[elem]);
	}
	this.append(obj);
};
//---------------------------
})(jQuery);