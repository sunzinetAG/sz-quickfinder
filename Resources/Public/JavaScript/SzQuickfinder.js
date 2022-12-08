/**
 * Created by roemmichde on 20.03.14.
 */
(function($) {
    'use strict';
    var pageType = 1662617600;
    var timer = null;

    var initAutocomplete = function() {
        var $searchbox = $('.tx-quickfinder-searchbox-sword');
        $searchbox.attr('autocomplete', 'off');
        var container = $('.tx-quickfinder-searchbox-results');
        $searchbox.bind('click keyup', function(e) {
            var $this = jQuery(this);
            var L = $('body').attr('data-languid');
            if (timer) {
                clearTimeout(timer);
            }
            timer = setTimeout(function() {
                container.show();
                if (e.type != 'click') {
                    jQuery('.tx-quickfinder-searchbox-results').html('<div class="ajax-loader"></div>');
                }
                if ($this.val().length > 2) {
                    var url = new URL($this.data('typo3-ajax-url'));
                    var params = url.searchParams;
                    params.set('tx_szquickfinder_autocomplete[controller]', 'Search');
                    params.set('tx_szquickfinder_autocomplete[searchString]', encodeURIComponent($this.val()));
                    params.set('t', Date.now().toString());
                    url.search = params.toString();
                    $.ajax({
                        url: url.toString(),
                        success: function(response) {
                            container.html(response);
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                } else {
                    container.hide();
                    container.html('');
                }
            }, 300);
        });
        $(document).bind('click keyup', function(e) {
            if (!container.is(e.target) && container.has(e.target).length === 0 && !$(e.target).hasClass('tx-quickfinder-searchbox-sword')) {
                container.hide();
            }
        });

    };

    $(function() {
        initAutocomplete();
    });
})(jQuery);
