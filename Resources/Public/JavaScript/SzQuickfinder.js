var quickfinder = {
  quickfinderEl: [],
  listView: [],
  resultsPerPage: 10,
  results: [],
  currentPage: 1,
  paginator: [],
  init: function () {
    this.quickfinderEl = $('.tx-sz-quickfinder')

    if(this.quickfinderEl.length) {
      this.listView = this.quickfinderEl.find('.quickfinder-listview')
    }
    if(this.listView.length) {
      this.initQuickfinderList()
    }
  },
  initQuickfinderList: function () {
    this.findAllResults()
    this.paginator = $('#szquickfinder-paginator')
    this.pages = this.paginator.find('.pages')

    $('.tx-sz-quickfinder #section-bar a[data-display]').on('click', this.onSectionClick)

    this.resetPaginator(this.results.length)
    this.paginator.on('click', '> a', this.onClickNavigation) // back and forward
  },
  findAllResults: function() {
    this.results = this.listView.find('.results-list > a')
  },
  navigatePage: function (page) {
    if(page === '-1') {
      page = parseInt(quickfinder.currentPage) - 1
    } else if(page === '+1') {
      page = parseInt(quickfinder.currentPage) + 1
    }

    var start = page*quickfinder.resultsPerPage-quickfinder.resultsPerPage
    quickfinder.results.addClass('hidden')
    quickfinder.results.slice(start, start+quickfinder.resultsPerPage).removeClass('hidden')

    switch (true) {
      case page <= 1:
        quickfinder.paginator.find('.prev').addClass('hidden')
        if(quickfinder.pageAmount > 1) {
          quickfinder.paginator.find('.next').removeClass('hidden')
        }
        break
      case page >= quickfinder.pageAmount:
        quickfinder.paginator.find('.next').addClass('hidden')
        if(quickfinder.pageAmount > 1) {
          quickfinder.paginator.find('.prev').removeClass('hidden')
        }
        break
      default:
        quickfinder.paginator.find('.prev,.next').removeClass('hidden')
    }

    quickfinder.pages.find('.active').removeClass('active')
    quickfinder.paginator.find('a[data-page="' + page + '"]').addClass('active')

    quickfinder.currentPage = page
  },
  resetPaginator: function (resultCount) {
    this.currentPage = 1
    var pageAmount = this.pageAmount = Math.ceil(resultCount / this.resultsPerPage)
    this.pages.empty()
    this.paginator.find('a').addClass('hidden')

    if (pageAmount > 1) {
      this.paginator.find('.next').removeClass('hidden')

      for(var i = 1; i <= pageAmount;i++) {
        this.pages.append($('<a href="#" data-page="'+i+'">'+i+'</a>'))
      }

      this.pages.on('click', 'a', this.onClickNavigation) // only numbered
    }

    this.navigatePage(1)
  },
  onClickNavigation: function (e) {
    quickfinder.navigatePage(e.target.dataset.page)

    e.preventDefault()
  },
  onSectionClick: function (e) {
    var el = e.target.tagName === "A" ? $(e.target) : $(e.target.parentNode),
        display = el.data('display'),
        sectionBar = $('#section-bar')

    e.preventDefault()

    sectionBar.parent().find('> .results').removeClass('hidden')
    if (display !== 'all') {
      sectionBar.parent().find('> .results:not(.'+display+'-results)').addClass('hidden')

      quickfinder.results = sectionBar.parent().find('> .'+display+'-results > .results-list > a')
    } else {
      // reset results
      quickfinder.findAllResults()
    }

    quickfinder.resetPaginator(quickfinder.results.length)

    sectionBar.find('.active').removeClass('active')
    el.addClass('active')
  }
}

/**
 * Created by roemmichde on 20.03.14.
 */
(function($) {
    'use strict';
    var pageType = 1402582595;
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
                        url: window.location.origin + '/?type=' + pageType + '&L=' + L + '&tx_szquickfinder_autocomplete[searchString]=' + encodeURIComponent($this.val()),
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

    $(document).ready(function() {
      quickfinder.init()
    });
})(jQuery);
