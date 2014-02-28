(function(jQuery) {
	'use strict';
	var base = $('base').attr('href');
	var initAutocomplete = function() {
		var $searchbox = jQuery('.tx-indexedsearch-searchbox-sword');
		$searchbox.szautocomplete({
			serviceUrl: base + 'index.php?eID=tx_szindexedsearch_autocomplete',
			paramName: 'tx_szindexedsearch_pi99[searchValue]'
		});
	};

	var removeElements = function() {
		//removes the first pagination, dirty, but it works...
		jQuery('.tx-indexedsearch .browsebox').first().remove()
	};

	jQuery(function() {
		initAutocomplete();
		removeElements();
	});
}) (jQuery);