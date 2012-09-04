/** jQuery movingGrid Plugin -- Version 2.9 *****
 *                                              *
 *  Updated: 2012/09/04                         *
 *                                              *
 *  Dependancies:                               *
 *    - jquery 1.4+                             *
 *    - jquery.scrollTo                         *
 *                                              *
 ************************************************/

(function($) {

	$.fn.movingGrid = function(settings) {

		var defaults = {
			ajax			: false,					// Loads "full" content via Ajax. Set it to false to use the classic "show/hide" method
			collapseHandler : 'collapse',				// Class name for the "collapse" handler
			collapseText 	: 'Fermer',					// Text for the "collapse" handler
			columns  		: 3,						// Number of columns for the grid
			excerptContent	: 'excerpt',				// Class name for the "excerpt" content
			expandHandler	: 'expand',					// Class name for the "expand" handler
			extendClick		: false,					// Set this to true to extend the "click" action to the whole item
			fullContent		: 'full',					// When ajax is set to "false", this class is used to know which content is to be shown as the "full" content
			item			: 'item',					// Class name for the item wrapper
			gutter			: 20,						// Gutter between items of the grid (in px)
			opacity			: 0.5,     	 				// When an item is expanded, the others will be set to this opacity
			scroll			: true,						// Scroll to the expanded item when its top is not visible (depends on "jquery.scrollTo")
			speed			: 500,						// Animation speed
			staticWidthTags	: [ 'h2' ],					// On init or zoom, the width of these elements should be adjusted (element fits perfectly to container, and avoids dynamic width while moving)
			xScale			: 2,       					// Horizontal zoom factor
			yScale			: 2							// Vertical zoom factor
		};

		var option 		= $.extend(defaults, settings);

		var parent      = this;

		var coordsX		= new Array();
		var coordsY		= new Array();
		var matrix		= new Array();

		var nbItems 	= parent.find('.' + option.item).size();
		var nbRows		= Math.ceil(nbItems / option.columns);

		var padding 	= 2*(parseInt($('.' + option.item).css('padding-left')));
		var itemWidth 	= parseInt(((parent.width() - (option.columns+1) * option.gutter) / option.columns) );
		var itemHeight 	= parseInt(parent.find('.' + option.item).css('height')) + padding;

		var clickAllowed	= true;

		for (var i = 0; i < option.columns; i++) 		coordsX[i] = (itemWidth + option.gutter) * i + option.gutter;
		for (var j = 0; j < nbRows+option.yScale; j++) 	coordsY[j] = (itemHeight + option.gutter) * j;

		function resetMatrix() {
			for(var i = 0; i < nbRows + option.yScale; i++) {
				matrix[i] = new Array();
				for (var j = 0; j < option.columns; j++) {
					matrix[i][j] = true;
				}
			}
		};

		function showContent(item) {
			var target = item.find('a.' + option.expandHandler).attr('href');
			item.removeClass('loading').addClass('expanded');
			if (option.ajax) item.append('<div class="' + option.fullContent + '"></div>').find('.' + option.fullContent).load(target).fadeIn(option.speed, function(){ clickAllowed = true; });
			else item.find('.' + option.fullContent).fadeIn();
		};

		function populateMarkup() {
			parent.find('.' + option.item).append('<a href="#" class="' + option.collapseHandler + '" style="display:none;">' + option.collapseText + '</a>');
		};

		function extendClick() {
			parent.find('.' + option.item)
				.css('cursor','pointer')
				.click(function(){
					$(this).find('a:visible').triggerHandler('click');
				});
			parent.find('.' + option.item + ' a.' + option.expandHandler + ', .' + option.item + ' a.' + option.collapseHandler).click(function(event){
				event.preventDefault();
			});
		};

		function setParentHeight(element, refHeight, scale) {
			scale = scale != null ? scale : 1;
			element.css('height', (nbRows + scale) * option.gutter + (nbRows + scale - 1) * refHeight);
		};

		function fixStaticWidthTags() {
			for ( id in option.staticWidthTags) {
				var obj = $('.item '+option.staticWidthTags[id]);
				if (obj.size() > 0 ) obj.each(function(){
					$(this).css('width', $(this).parents('.item').css('width'));
				});
			};
		}

		function initItems() {
			setParentHeight(parent, itemHeight);
			var indexItem = 0;
			parent.find('.' + option.item).removeClass('expanded').fadeTo("fast",1);
			parent.find('.' + option.excerptContent + ':hidden').delay(500).fadeIn();
			if (option.ajax) parent.find('.' + option.fullContent).remove();
			else parent.find('.' + option.fullContent).hide();
			parent.find('a.' + option.expandHandler).fadeIn();
			parent.find('a.' + option.collapseHandler).hide();
			for(var i = 0; i < nbRows; i++) {
				for (var j = 0; j < option.columns; j++) {
					if (!matrix[i][j]) continue;
					if (indexItem >= nbItems ) break;
					parent.find('.' + option.item + ':eq(' + indexItem + ')')
					.animate({
						'top'	: coordsY[i] + option.gutter + 'px',
						'left'	: coordsX[j] + 'px',
					}, option.speed, function() { clickAllowed = true; })
					.css({
						'width': itemWidth - padding + 'px',
						'height': itemHeight - padding + 'px'
					});
					indexItem++;

				}
			}
			fixStaticWidthTags();
		};

		function moveItems(index) {
			var indexItem = 0;
			for(var i = 0; i <= nbRows + option.yScale - 1; i++) {
				for (var j = 0; j < option.columns; j++) {
					if (!matrix[i][j]) continue;
					if (indexItem >= nbItems )  break;
					if (indexItem == index && index%option.columns  > option.columns - option.xScale) indexItem++;
						parent.find('.' + option.item + ':eq(' + indexItem + ')')
							.animate({
								'top'	: coordsY[i] + option.gutter + 'px',
								'left'	: coordsX[j] + 'px'
							}
						);

					if (indexItem!=index) parent.find('.' + option.item + ':eq(' + indexItem + ')').fadeTo(option.speed, option.opacity);
					indexItem++;
				}
			}
		};

		function zoom(index) {
			var item = parent.find('.' + option.item + ':eq(' + index + ')');
			item.addClass('loading');
			item.find('a.' + option.expandHandler).hide();
			item.find('a.' + option.collapseHandler).fadeIn();
			item.find('.' + option.excerptContent).hide();
			var offset = item.offset();
			if (index%option.columns  > option.columns - option.xScale) {
				var left = coordsX[index%option.columns - (index%option.columns - option.xScale)];
			}
			else {
				var left = coordsX[index%option.columns];
			}
			setParentHeight($('#contentWrapper'), itemHeight, option.yScale);
			item.animate({
					//'left'   : '-=' + left + 'px',
					'left'   : left + 'px',
					'width'  : option.xScale * itemWidth + (option.xScale-1) * option.gutter - padding + 'px',
					'height' : option.yScale * itemHeight + (option.yScale-1) * option.gutter  - padding  + 'px'
				}, option.speed, function () {
						showContent($(this));
						if (option.scroll) $.scrollTo(item, option.speed, { offset : -option.gutter - 70 });

				}

			);
			var x = index%option.columns;
			var y = parseInt((index / option.columns) % nbRows);
			if (index%option.columns  <= option.columns - option.xScale) {
				for (var i = 0; i < option.yScale; i++) {
					for (var j = 0; j < option.xScale; j++) {
						if (i==0 && j==0) continue;
						matrix[y + i][x + j] = false;
					}
				}
			}
			else {
				for (var i = 0; i < option.yScale; i++) {
					for (var j = 0; j < option.xScale; j++) {
						matrix[y + i][j + option.columns - option.xScale] = false;
					}
				}
			}
			moveItems(index);
			resetMatrix();
		};


		if (!jQuery().scrollTo && option.scroll) {
			alert('Terminating... jQuery.scrollTo is not loaded! Please check that it is correctly loaded before launching movingGrid Plugin...');
			return parent;
		}

		if (option.xScale > option.columns) {
			alert('Terminating... xScale(' + option.xScale + ') can\'t be superior to columns(' + option.columns + ').');
			return parent;
		}

		if (parent.css('position') != 'absolute' && parent.css('position') != 'relative') {
			parent.css('position', 'relative');
		}

		resetMatrix();

		populateMarkup();

		initItems();


		$('a.' + option.expandHandler).each(function(index) {
			$(this).click(function(event) {
				if (clickAllowed) {
					clickAllowed = false;
					initItems();
					zoom(index);
					event.preventDefault();
				}
			});
		});

		$('a.' + option.collapseHandler).click(function(event){
			if (clickAllowed) {
				clickAllowed = false;
				initItems();
				event.preventDefault();
			}
		});

		if (option.extendClick) extendClick();

		return parent;
	}

})(jQuery);