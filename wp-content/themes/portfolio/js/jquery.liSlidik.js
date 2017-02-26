/*
 * jQuery liSlidik v 1.1
 *
 * Copyright 2012, Linnik Yura | LI MASS CODE | http://masscode.ru
 * http://masscode.ru
 * Free to use
 * 
 * October 2012
 */
(function($){
	$.fn.liSlidik = function(params){
		var p = $.extend({
			auto:3000,			//false - чтобы выключить слайд-шоу, или целое число (милисекунды) - чтобы включить и задать время между сменой слайдов
       		duration: 1000		//Число, определяющие, как долго будет протекать анимация смены слайда (в миллисекундах)
		}, params);
		return this.each(function(){
			var 
			slidik = $(this),
			sImg = $('img',slidik),
			sItem = $('li',slidik),
			sItemLength = sItem.length;
			var	sItemShow;
			if($('.show',slidik).length){
				sItemShow = $('.show',slidik);
			}else{
				sItemShow = sItem.eq(0).addClass('show');
			}
			var 
			sItemShowIndex = sItem.index($(sItemShow)),
			sDotted = $('.dotted[data-slidik='+slidik.attr('id')+']').css({visibility:'visible'}),
			sThumbs = $('.thumbs[data-slidik='+slidik.attr('id')+']').css({visibility:'visible'}),
			sCaptionEl = $('.caption[data-slidik='+slidik.attr('id')+']').css({visibility:'visible'}),
			f1 = true;
			var sNextEl = $('<div>').addClass('sNextEl').attr('data-slidik',slidik.attr('id')).appendTo('body').css({position:'fixed',left:'-99999px',top:'-99999px'});
			var sPrevEl = $('<div>').addClass('sPrevEl').attr('data-slidik',slidik.attr('id')).appendTo('body').css({position:'fixed',left:'-99999px',top:'-99999px'});;
			var autoId = function(){},
			sNext = $('.next[data-slidik='+slidik.attr('id')+']').css({visibility:'visible'}),
			sPrev = $('.prev[data-slidik='+slidik.attr('id')+']').css({visibility:'visible'}),
			sImgClone = sImg.eq(0).clone().removeAttr('class').removeAttr('width').removeAttr('height').css({left:'-99999px', top:'-99999px',position:'absolute'}).appendTo('body'),
			sImgW = sImgClone.width(),
			sImgH = sImgClone.height(),
			sImgK = sImgW / sImgH;
			sImgClone.remove();
			
			

			
			
			if(sDotted.length){
				for(i=0;i<sItemLength;i++){
					$('<span>').text(i).addClass('dottedItem').appendTo(sDotted);
				};
			}
			if(sThumbs.length){
				var sThumbsItemWidth = 100 / sItemLength;
				for(i=0;i<sItemLength;i++){
					$('<span>').css({width:sThumbsItemWidth+'%'}).html('<img src='+sImg.eq(i).attr("src")+'>').addClass('thumbItem').appendTo(sThumbs);
				};
			}
			$('.dottedItem',sDotted).on('click',function(){
				if(!$(this).is('.cur')){
					if(f1){
						f1 = false;
						var dotIndex = $('.dottedItem',sDotted).index($(this));
						$('.dottedItem',sDotted).removeClass('cur').eq(dotIndex).addClass('cur');
						$('.thumbItem',sThumbs).removeClass('cur').eq(dotIndex).addClass('cur');
						
						sItemShow = $('.show',slidik);
						sItemShow.removeClass('show').fadeOut(p.duration);
						showCaption(dotIndex);
						sItem.eq(dotIndex).addClass('show').fadeIn(p.duration,function(){
							f1 = true;		
						});
					}
				}
				return false;
			});
			$('.thumbItem',sThumbs).on('click',function(){
				if(!$(this).is('.cur')){
					if(f1){
						f1 = false;
						var thumbIndex = $('.thumbItem',sThumbs).index($(this));
						$('.thumbItem',sThumbs).removeClass('cur').eq(thumbIndex).addClass('cur');
						$('.dottedItem',sDotted).removeClass('cur').eq(thumbIndex).addClass('cur');
						sItemShow = $('.show',slidik);
						sItemShow.removeClass('show').fadeOut(p.duration);
						showCaption(thumbIndex);
						sItem.eq(thumbIndex).addClass('show').fadeIn(p.duration,function(){
							f1 = true;		
						});
					}
				}
				return false;
			});
			var showCaption = function(ind){
				var sCaption = sItem.eq(ind).find('img').attr('alt');
				
				if(sItem.eq(ind).find('img').is('[alt]')){
					if(sItem.eq(ind).find('img').is('[alt*=#]')){
						sCaption = $(sCaption).html();
					}
					sCaptionEl.fadeOut(200,function(){
						$(this).html(sCaption).fadeIn(500)	;
					})
				}else{
					sCaptionEl.fadeOut(200);
				}
			};
			showCaption(sItemShowIndex)
			var slidikSize = function(){
				slidik.css({height:slidik.width() / sImgK});
			};
			slidikSize();
			sItemShow.fadeIn(p.duration);
			$('.dottedItem',sDotted).removeClass('cur').eq(sItemShowIndex).addClass('cur');
			$('.thumbItem',sThumbs).removeClass('cur').eq(sItemShowIndex).addClass('cur');
			sNextEl.on('click',function(){
				if(f1){
					f1 = false;
					sItemShow = $('.show',slidik);
					sItemShowIndex = sItem.index($(sItemShow));
					sItemShow.removeClass('show').fadeOut(p.duration);
					
					if(sItemShowIndex < (sItemLength - 1)){
						showCaption(sItemShowIndex + 1);
						$('.dottedItem',sDotted).removeClass('cur').eq(sItemShowIndex + 1).addClass('cur');
						$('.thumbItem',sThumbs).removeClass('cur').eq(sItemShowIndex + 1).addClass('cur');
						sItem.eq(sItemShowIndex + 1).addClass('show').fadeIn(p.duration,function(){
								f1 = true;		
						});
					}else{
						showCaption(0);
						$('.dottedItem',sDotted).removeClass('cur').eq(0).addClass('cur');
						$('.thumbItem',sThumbs).removeClass('cur').eq(0).addClass('cur');
						sItem.eq(0).addClass('show').fadeIn(p.duration,function(){
							f1 = true;	
						});
					}
				}
				return false;
			});
			sNext.on('click',function(){
				sNextEl.trigger('click');
				return false;
			});
			sPrevEl.on('click',function(){
				if(f1){
					f1 = false;
					sItemShow = $('.show',slidik);
					sItemShowIndex = sItem.index($(sItemShow));
					sItemShow.removeClass('show').fadeOut(p.duration);
					if(sItemShowIndex > 0){
						showCaption(sItemShowIndex - 1);
						$('.dottedItem',sDotted).removeClass('cur').eq(sItemShowIndex - 1).addClass('cur');
						$('.thumbItem',sThumbs).removeClass('cur').eq(sItemShowIndex - 1).addClass('cur');
						sItem.eq(sItemShowIndex - 1).addClass('show').fadeIn(p.duration,function(){
								f1 = true;		
						});
					}else{
						showCaption(sItemLength - 1);
						$('.dottedItem',sDotted).removeClass('cur').eq(sItemLength - 1).addClass('cur');
						$('.thumbItem',sThumbs).removeClass('cur').eq(sItemLength - 1).addClass('cur');
						sItem.eq(sItemLength - 1).addClass('show').fadeIn(p.duration,function(){
							f1 = true;	
						});
					}
				}
				return false;
			});
			sPrev.on('click',function(){
				sPrevEl.trigger('click');
				return false;
			});
			var autoFunc = function(){
				if(p.auto){
					autoId = setInterval(function(){
						sNextEl.trigger('click');
					},p.auto)	
				}
			};
			autoFunc();
			slidik.add(sCaptionEl).add(sNext).add(sPrev).add(sDotted).add(sThumbs).on('mouseenter',function(){
				clearTimeout(autoId);	
			}).on('mouseleave',function(){
				clearTimeout(autoId)	;
				autoFunc();
			});
			slidikSize();
			$(window).on('resize',function(){
				slidikSize();
			});
			
		});
	};
})(jQuery);