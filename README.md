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

[CHANGELOG](CHANGELOG.md)

## Bekannte Probleme:

* Keine Probleme bekannt

## PHPUnit Tests:
```
composer install
./vendor/bin/phpunit -c Tests/phpunit.xml
```