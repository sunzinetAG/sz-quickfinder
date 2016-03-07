# Dokumentation - sz_indexed_search

## Installation

1. Extension installieren und Datenbank updaten
2. Typoscript einbinden
3. Extension einem Marker zuweisen und im Template einbinden. Beispiel:

```PHP
//typo3conf/ext/typo3sz_assets/Configuration/TypoScript/Default/Setup/contents/elements.ts
lib.contents {
  pageSearch =< lib.tx_szindexedsearch
}
```

## Einschränkungen

### Abhängigkeiten:

Folgende Extensions müssen installiert sein, damit sz_indexed_search fehlerfrei funktioniert:

* extbase v1.3
* fluid v1.3
* typo3 v6.2

### Konflikte:

* Keine Konflikte bekannt

### Empfohlen:

* Keine besonderen Voraussetzungen

## Einstellungen:

|                                       | Typ                                   | Default                               |
| ------------------------------------- | ------------------------------------- | ------------------------------------- | 
| homePageUid                           | integer                               | 2                                     |
| searchPid                             | integer                               | 140                                   |
| newsPid                               | integer                               | 28                                    |
| regEx                                 | string                                | %\|%                                  |
| maxResults                            | integer                               | 3                                     |
| includeNavHiddenPages                 | bool                                  | false                                 |
| orderBy                               | string                                | uid                                   |
| ascending                             | bool                                  | true                                  |
| **customSearch**                      |                                       |                                       |
| class                                 | string                                |                                       |
| searchFields                          | searchFields                          |                                       |
Alle Einstellungen können pro 'customSearch' überschrieben werden.

## Wichtiger Hinweis:

Damit die Mehrsprachigkeit funktioniert, muss im TypoScript dem Body-Tag ein data-Attribut "data-languid" hinzugefügt werden, das die sys_language_uid beinhaltet: Beispiel aus typo3sz:

```PHP
page {
  bodyTagCObject = COA
  bodyTagCObject {
    10 = TEXT
    10.value = default
    10.stdWrap.noTrimWrap = |language-| |
    
    stdWrap.trim = 1
    stdWrap.dataWrap = <body class="|" data-languid="{tsfe : sys_language_uid}">
  }
}
```

## Changelog

Die aktuelle Version ist: [**3.0.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F3.0.0) 

Nachfolgend eine Auflistung aller sz_indexed_search Versionen und eine grobe Beschreibung der Änderungen. Die letzte Version steht hierbei immer ganz oben.

#### [**3.0.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F3.0.0)

* Umstellung auf Namespaces

#### [**2.2.2**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.2.2)

* 

#### [**2.2.1**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.2.1)

* Nicht im Menü angezeigte Seiten können nun optional gefunden werden

#### [**2.2.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.2.0)

* Ab sofort werden News standardmäßig durchsucht
* Verbesserung der CustomSearch implementation

#### [**2.1.5**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.5)

* Das Suchwort wird nun auch an die Views übergeben, z.B. für Trackingzwecke

#### [**2.1.4**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.4)

* Optional Möglich: Maximale Ergebnisanzahl pro Bereichssuche
* Übersetzungen wurden hinzugefügt

#### [**2.1.3**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.3)

* Fixt einen Bug, durch den eine Condition fälschlicherweise Negiert wurde

#### [**2.1.2**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.2)

* Fixt einen Bug, durch den der Breadcrumbseperator angezeigt wurde, obwohl die Seite versteckt war
* Datensätze sollen nur dann gefunden werden, wenn sie auf sich auf Seiten befinden, die nicht versteckt sind

#### [**2.1.1**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.1)

* Partials im Typoscript setup können nun klein geschrieben werden
* Funktionen wurden ersetzt
* Coding standards
* Fixt einen Bug, durch den die storagePid's ignoriert wurden

#### [**2.1.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.1.0)

* Mediatypen aus der sys_file_reference können nun definiert werden
* FilterViewHelper: Es wird nur das Wort zurückgegeben, das den angegebenen Suchstring beinhaltet
* Versionskompatiblität nach untern erweitert (TYPO3 4.7)
* Es ist nun möglich, eigene Scripte für die Suche zu schreiben

#### [**2.0.3**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.0.3)

* Rückgängig: TypoScript Settings für die Views umstrukturiert

#### [**2.0.1**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.0.1)

* TypoScript Settings für die Views umstrukturiert

#### [**2.0.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F2.0.0)

* Aus dem TypoScript wurden folgende Einstellungen entfernt:
	* enable_documents
	* show_breadcrumbs_to_documents
	* highlight_search_results
	* additional_button

Die entfernten Einstellungen können nun in den Templates angepasst werden

* Folgende Einstellungen wurden hinzugefügt
	* searchPid
	* breadcrumb_seperator

#### [**1.1.0**](http://stash.sunzinet.com:7990/projects/SZT3/repos/sz_indexed_search/browse?at=refs%2Ftags%2F1.1.0)

* Folgende Einstellungsmöglichkeiten wurden hinzugefügt:
	* homePageUid
	* enable_documents
	* show_breadcrumbs_to_documents
	* reg_search_exp
	* max_results
	* highlight_search_results
	* additional_button
	* customSearch

## Bekannte Probleme:

* Keine Probleme bekannt