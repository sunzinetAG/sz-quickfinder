# Change Log

Die aktuelle Version ist: [**4.0.0**](https://github.com/sunzinetAG/sz_quickfinder/tree/4.0.0) 

Nachfolgend eine Auflistung aller sz_quicksearch Versionen und eine grobe Beschreibung der Änderungen. Die letzte Version steht hierbei immer ganz oben.

## [**4.0.0**](https://github.com/sunzinetAG/sz_quickfinder/tree/4.0.0) - 2017-06-12

* Rename sz_indexed_search to sz_quickfinder
* Move from internel Repository to github
* Qodestyle
* Several code improvements
* New possibility to write own quicksearch provider

## [**3.1.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F3.1.0) - 2017-03-07

* Add the possibility to set the allowedFields by the typoscript-setup

## [**3.0.1**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F3.0.1) - 2016-07-26

* Eigene Scripts werden nun wieder unterstützt
* Überflüssigen Code entfernt
* Ajax URL war in manchen Umgebungen falsch angegeben

## [**3.0.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F3.0.0) - 2016-03-07

* Umstellung auf Namespaces

## [**2.2.2**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.2.2) - 2015-09-18

* Tests

## [**2.2.1**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.2.1) - 2015-04-22

* Nicht im Menü angezeigte Seiten können nun optional gefunden werden

## [**2.2.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.2.0) - 2015-04-22

* Ab sofort werden News standardmäßig durchsucht
* Verbesserung der CustomSearch implementation

## [**2.1.5**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.5) - 2015-02-24

* Das Suchwort wird nun auch an die Views übergeben, z.B. für Trackingzwecke

## [**2.1.4**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.4) - 2014-11-28

* Optional Möglich: Maximale Ergebnisanzahl pro Bereichssuche
* Übersetzungen wurden hinzugefügt

## [**2.1.3**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.3)- 2014-11-18

* Fixt einen Bug, durch den eine Condition fälschlicherweise Negiert wurde

## [**2.1.2**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.2)- 2014-10-07

* Fixt einen Bug, durch den der Breadcrumbseperator angezeigt wurde, obwohl die Seite versteckt war
* Datensätze sollen nur dann gefunden werden, wenn sie auf sich auf Seiten befinden, die nicht versteckt sind

## [**2.1.1**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.1)- 2014-09-11

* Partials im Typoscript setup können nun klein geschrieben werden
* Funktionen wurden ersetzt
* Coding standards
* Fixt einen Bug, durch den die storagePid's ignoriert wurden

## [**2.1.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.0)- 2014-08-07

* Mediatypen aus der sys_file_reference können nun definiert werden
* FilterViewHelper: Es wird nur das Wort zurückgegeben, das den angegebenen Suchstring beinhaltet
* Versionskompatiblität nach untern erweitert (TYPO3 4.7)
* Es ist nun möglich, eigene Scripte für die Suche zu schreiben

## [**2.0.3**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.0.3) - 2014-06-24

* Rückgängig: TypoScript Settings für die Views umstrukturiert


## [**2.0.2**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.0.2) - 2014-06-16

* Bugfix: logicalAnd und logicalOr müssen geleert werden
* Breadcrumbs nur in ausgewählten Suchergebnissen anzeigen

## [**2.0.1**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.0.1) - 2014-06-13

* TypoScript Settings für die Views umstrukturiert

## [**2.0.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.0.0) - 2014-06-12

* Aus dem TypoScript wurden folgende Einstellungen entfernt:
    * enable_documents
    * show_breadcrumbs_to_documents
    * highlight_search_results
    * additional_button

Die entfernten Einstellungen können nun in den Templates angepasst werden

* Folgende Einstellungen wurden hinzugefügt
    * searchPid
    * breadcrumb_seperator

## [**1.1.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F1.1.0) - 2014-02-28

* Folgende Einstellungsmöglichkeiten wurden hinzugefügt:
    * homePageUid
    * enable_documents
    * show_breadcrumbs_to_documents
    * reg_search_exp
    * max_results
    * highlight_search_results
    * additional_button
    * customSearch