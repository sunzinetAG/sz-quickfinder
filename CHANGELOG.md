# Change Log

## 6.1.0 - 2023-10-04

* 2023-06-15 [TASK] Allow PHP 8.2.* (Commit 697a82c by Christian Efthimoglou)
* 2023-06-15 [BUGFIX] Fix small inconsistencies in code (Commit 5dd2b92 by Christian Efthimoglou)

## [**6.0.0**](https://github.com/sunzinetAG/sz-quickfinder/tree/6.0.0) - 2021-10-04

* Marked setup.txt as deprecated. Use setup.typoscript instead

## [**5.2.2**](https://github.com/sunzinetAG/sz-quickfinder/tree/5.2.2) - 2021-10-13

* 2021-10-13 [FEATURE] Set version to 5.2.2 (Commit 0696672 by Christian Efthimoglou)
* 2021-10-13 [BUGFIX] Add extension-key property to composer.json (Commit 61daa61 by Christian Efthimoglou)
* 2021-10-13 [BUGFIX] Add missing Services.yaml (Commit 9df1f58 by Christian Efthimoglou)

## [**4.1.0**](https://github.com/sunzinetAG/sz-quickfinder/tree/4.1.0) - 2019-08-13

* Add functionality for blacklist pids to exclude them from whitelist pids

## [**4.0.1**](https://github.com/sunzinetAG/sz-quickfinder/tree/4.0.1) - 2017-08-07

* Add parameter "tx_szquickfinder_pi1[searchString]" to cacheHash exclude parameters

## [**4.0.0**](https://github.com/sunzinetAG/sz-quickfinder/tree/4.0.0) - 2017-06-12

* Rename sz_indexed_search to sz_quickfinder
* Move from internel Repository to github
* Qodestyle
* Several code improvements
* New possibility to write own quicksearch provider

## [**3.1.0**](https://github.com/sunzinetAG/sz-quickfinder/tree/3.1.0) - 2017-03-07

* Add the possibility to set the allowedFields by the typoscript-setup

## [**3.0.1**](https://github.com/sunzinetAG/sz-quickfinder/tree/3.0.1) - 2016-07-26

* Support own scripts again
* Remove unnecessary code
* Ajax URL was wrong in some environments

## [**3.0.0**](https://github.com/sunzinetAG/sz-quickfinder/tree/3.0.0) - 2016-03-07

* Switch to namespaces

## [**2.2.2**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.2.2) - 2015-09-18

* Tests

## [**2.2.1**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.2.1) - 2015-04-22

* Possibility to find pages which are hidden in menues

## [**2.2.0**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.2.0) - 2015-04-22

* Search in tx_news per default
* Improvements for CustomSearch implementation

## [**2.1.5**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.1.5) - 2015-02-24

* Pass the searchstring to the views, e.g. vor tracking purposes

## [**2.1.4**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.1.4) - 2014-11-28

* Optional possible: Maximum Searchresult for each search
* Added translations

## [**2.1.3**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.1.3)- 2014-11-18

* Fixes a bug which negated an condition

## [**2.1.2**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.1.2)- 2014-10-07

* Fixes a bug which displayed the breadcrumbseperator, even if the site was hidden
* Only find datasets which are locate on visible sites

## [**2.1.1**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.1.1)- 2014-09-11

* Partials can be named in lowercase
* Replace funcionts
* Coding standards
* Fixes a bug which overrides the storagePid's

## [**2.1.0**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.1.0)- 2014-08-07

* It's possible to define mediatypes from sys_file_reference
* FilterViewHelper: Only return the word which includes the giben searchstring
* Expand versioncompatibility (TYPO3 4.7)
* Possibility to write own scripts

## [**2.0.3**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.0.3) - 2014-06-24

* Undo: New structure for TypoScript settings

## [**2.0.2**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.0.2) - 2014-06-16

* Bugfix: logicalAnd and logicalOr got emptied now
* Show breadcrumbs only in selected searchresults

## [**2.0.1**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.0.1) - 2014-06-13

* New structure for TypoScript settings

## [**2.0.0**](https://github.com/sunzinetAG/sz-quickfinder/tree/2.0.0) - 2014-06-12

* Removed setting options:
    * enable_documents
    * show_breadcrumbs_to_documents
    * highlight_search_results
    * additional_button

These settings are not necessary anymore since you can handle them in fluid template directly.

* Added setting options:
    * searchPid
    * breadcrumb_seperator

## [**1.1.0**](https://github.com/sunzinetAG/sz-quickfinder/tree/1.1.0) - 2014-02-28

* Added setting options:
    * homePageUid
    * enable_documents
    * show_breadcrumbs_to_documents
    * reg_search_exp
    * max_results
    * highlight_search_results
    * additional_button
    * customSearch
