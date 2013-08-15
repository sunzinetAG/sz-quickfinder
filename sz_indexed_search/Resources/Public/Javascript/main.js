(function($) {
	'use strict';

	var initAutocomplete = function() {
		var $searchbox = $('.tx-indexedsearch-searchbox-sword');
		$searchbox.autocomplete({
			serviceUrl: '/index.php?eID=tx_szindexedsearch_autocomplete',
			paramName: 'tx_szindexedsearch_pi99[searchValue]'
		});
	};

	var removeElements = function() {
		//removes the first pagination, dirty, but it works...
		$('.tx-indexedsearch .browsebox').first().remove()
	};

	$(function() {
		initAutocomplete();
		removeElements();
	});
}) (jQuery);