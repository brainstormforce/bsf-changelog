(function($) {
	$( '.see-more-text' ).click( function() {
		post_id = ( $(this).closest('.type-chnangelogs') ).attr('id');
		seeMore(post_id);
	});

	$(document).on('click', '.bsf-sub-versions-title', function() {
		let self = $(this);
		if ( self.closest('.bsf-sub-versions-wrapper').hasClass('show-list') ) {
			self.closest('.bsf-sub-versions-wrapper').removeClass('show-list');
			self.find('.ast-subver-title').text( bsf_pagination.show_subversion_text );
		} else {
			self.closest('.bsf-sub-versions-wrapper').addClass('show-list');
			self.find('.ast-subver-title').text( bsf_pagination.hide_subversion_text );
		}
	});

	function seeMore(post_id){
		$( '#' + post_id + ' .bsf-entry-content.content-open' ).css('height', 'auto').show();
		$( '#' + post_id + ' .bsf-entry-content.content-closed' ).hide();
		$( '#' + post_id + ' .see-more-text' ).hide();
		if ( $( '#' + post_id + ' .bsf-changelog-img' ).hasClass( 'bsf-featured-img-hide' ) ) {
			$( '#' + post_id + ' .bsf-changelog-img' ).hide();
		}
	}

	var pattern = new RegExp('^[\\w\\-]+$');
	var id = window.location.hash.substring(1);
	if ( pattern.test( id ) ) {
    	var targetElement = document.getElementById(id);
		var offsetValue = targetElement.offsetTop;
		if (targetElement.length) {
			$('html,body').animate({
				scrollTop: offsetValue
			}, 1000);
			return false;
		}
	}

	const anchorLinks = document.querySelectorAll('a[href^="#"]:not(.uagb-tabs-list)');

	anchorLinks.forEach(anchorLink => {
		anchorLink.addEventListener('click', event => {
    		event.preventDefault();

    		const targetId = anchorLink.getAttribute('href').slice(1);

			// Update the URL with the hash value and offset value
			window.location.hash = targetId;
  		});
	});

	var is_scroll = $('.bsf-infinite-scroll');
	if( 0 != is_scroll.length ) {
		var mainSelector = $('#main');
		var rect = mainSelector[0].getBoundingClientRect();
		var loadStatus = true;
		var total = parseInt( bsf_pagination.infinite_total ) || '';
		var count = parseInt( bsf_pagination.infinite_count ) || '';
		var bsfLoadMore	= $('.bsf-load-more');
		var offset = {
			top: rect.top + window.scrollY,
			left: rect.left + window.scrollX,
		};
		if( bsfLoadMore ){
			bsfLoadMore.removeClass('active');
		}
		if( mainSelector.find('.type-chnangelogs:last-child').length > 0 ) {
			var windowHeight50 = window.outerHeight / 1.25;
			$( window ).on('scroll', function() {
				if( (window.scrollY + windowHeight50 ) >= ( offset.top ) ) {
					if (count > total) {
						return false;
					} else {
						//	Pause for the moment ( execute if post loaded )
						if( loadStatus == true ) {
							NextloadPosts(count);
							count++;
							loadStatus = false;
						}
					}
				}
			});
		}
	}

	function NextloadPosts(pageNumber) {
		var loader = $('.bsf-pagination-infinite .bsf-loader');
		if( bsfLoadMore ){
			bsfLoadMore.removeClass('active');
		}
		var pageUrlSelector = $('a.next.page-numbers');
		var nextDestUrl = pageUrlSelector.attr('href');
		loader.css( 'display', 'block' );

		var request = new XMLHttpRequest();
			request.open('GET', nextDestUrl, true);
			request.send();
			request.onload = function() {
				var string = request.response;
				var data = new DOMParser().parseFromString(string, 'text/html');
				var boxes = data.querySelectorAll( 'div.type-chnangelogs' );

				//	Disable loader
				loader.css( 'display', 'none' );
				if( bsfLoadMore ){
					bsfLoadMore.addClass( 'active');
				}

				//	Append posts
				for (var boxCount = 0; boxCount < boxes.length; boxCount++) {
					$('#main').append(boxes[boxCount]);
				}

				//	Add grid classes
				var msg = 'No more Posts to show.';
				//	Show no more post message
				if( count > total ) {
					$('.bsf-pagination-infinite').innerHTML = '<span class="bsf-load-more no-more active" style="display: inline-block;">' + msg + "</span>";
				} else {
					var pageUrlSelector = document.querySelector('a.next.page-numbers');
					var newNextTargetUrl = nextDestUrl.replace(/\/page\/[0-9]+/, '/page/' + (pageNumber + 1));
					pageUrlSelector.setAttribute('href', newNextTargetUrl);
				}

				$( '.see-more-text' ).click( function() {
					post_id = ( $(this).closest('.type-chnangelogs') ).attr('id');
					seeMore(post_id);
				});

				//	Complete the process 'loadStatus'
				loadStatus = true;
			}
	}
})(jQuery);
