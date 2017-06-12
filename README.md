# Documentation - sz_quickfinder

## Installation

1. Extension installieren
2. Typoscript einbinden
3. Extension einem Marker zuweisen und im Template einbinden. Beispiel:

```PHP
example.ts:
lib.contents {
  pageSearch =< lib.tx_szquickfinder
}
```

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

Damit die Mehrsprachigkeit funktioniert, muss im TypoScript dem Body-Tag ein data-Attribut "data-languid" hinzugefügt werden, das die sys_language_uid beinhaltet: Beispiel:

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

* Auf Detailseiten (z.B. news) wird das Autocomplete nicht korrekt ausgeführt. Workaround: In der LocalConfiguration.php $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError'] = 0 setzen

## PHPUnit Tests:
```
composer install
./vendor/bin/phpunit -c Tests/phpunit.xml
```
