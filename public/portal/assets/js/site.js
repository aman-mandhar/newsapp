$(function () {
// start the ticker(s) — initialize all tickers with class `.js-news`
	$('.js-news').each(function () {
		try {
			$(this).ticker();
		} catch (e) {
			// fail silently if ticker plugin isn't available for some pages
			console && console.warn && console.warn('Ticker init failed', e);
		}
	});
	
	// hide the release history when the page loads
	$('#release-wrapper').css('margin-top', '-' + ($('#release-wrapper').height() + 20) + 'px');

	// show/hide the release history on click
	$('a[href="#release-history"]').toggle(function () {	
		$('#release-wrapper').animate({
			marginTop: '0px'
		}, 600, 'linear');
	}, function () {
		$('#release-wrapper').animate({
			marginTop: '-' + ($('#release-wrapper').height() + 20) + 'px'
		}, 600, 'linear');
	});	
	
	$('#download a').mousedown(function () {
		_gaq.push(['_trackEvent', 'download-button', 'clicked'])		
	});
});




