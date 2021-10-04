# Documentation - sz_quickfinder

## Installation

1. Run
```sh
composer require sunzinet/sz-quickfinder
```
2. Activate sz-quickfinder in the Extensionmanager
3. Include TypoScript
4. Include sz-quickfinder in your template. Example:

```PHP
example.ts:
lib.contents {
  pageSearch =< lib.tx_szquickfinder
}
```

## Settings:

|                                       | Type                                  | Default                               |
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
| blacklistPid                          | string                                |                                       |
All settings can be overriden in 'customSearch' section.

## Important notes:

It's required to give a data-attrubute to the body-tag called "data-languid" with the current sys_language_uid to make multilingualism work. Example: 

```PHP
page {
  bodyTagCObject = COA
  bodyTagCObject {
    10 = TEXT
    10.value = default
    10.stdWrap.noTrimWrap = |language-| |
    
    stdWrap.trim = 1
    stdWrap.dataWrap = <body class="|" data-languid="{sitelanguage:languageId}">
  }
}
```

## Changelog

[CHANGELOG](CHANGELOG.md)

## Bekannte Probleme:

* Autocomplete does not work korrect on detailpages (e.g. tx_news). Workaround: Set $GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError'] = 0 in your LocalConfiguration.php

* Bei eingeschaltetem pageNotFoundOnCHashError wird auf keiner Seite die Suche ausgeführt. Hier hilft das setzen von $GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'] 

## PHPUnit Tests:
```
composer install
./vendor/bin/phpunit -c Tests/phpunit.xml
```
