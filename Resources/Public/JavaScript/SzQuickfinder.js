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
                    $.ajax({
                        url: window.location.origin + window.location.pathname + '?type=' + pageType + '&ts=' + Date.now() + '&L=' + L + '&tx_szquickfinder_autocomplete[searchString]=' + encodeURIComponent($this.val()) + '&no_cache=1',
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
