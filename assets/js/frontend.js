(function($) {
	$( '.see-more-text' ).click( function() {
		post_id = ( $(this).parent().parent() ).attr('id');
		$( '#' + post_id + ' .bsf-entry-content.content-open' ).css( 'display', 'block');
		$( '#' + post_id + ' .bsf-entry-content.content-closed' ).css( 'display', 'none');
		$( '#' + post_id + ' .see-more-text' ).css( 'display', 'none');
	});

	const anchorLinks = document.querySelectorAll('a[href^="#"]');

	anchorLinks.forEach(anchorLink => {
		anchorLink.addEventListener('click', event => {
    		event.preventDefault();

    		const targetId = anchorLink.getAttribute('href').slice(1);
    		const targetElement = document.getElementById(targetId);
			const offsetValue = targetElement.offsetTop - 100;

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

				//	Complete the process 'loadStatus'
				loadStatus = true;
			}
	}
})(jQuery);
