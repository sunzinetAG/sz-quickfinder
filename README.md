# sunzinet/sz-quickfinder

## Installation

1. Run
    ```shell
    composer req sunzinet/sz-quickfinder
    ```
2. Activate sz-quickfinder in the Extens**ionmanager
3. Include TypoScript
4. Include sz-quickfinder in your template. Example:

```typo3_typoscript
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

All settings can be overridden in 'customSearch' section.

## Important notes:

It's required to give a data-attribute to the body-tag called "data-languid" with the current sys_language_uid to make
multilingualism work.

```typo3_typoscript
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

## Known problems:

* Autocomplete doesn't work correctly on detail pages (e.g. tx_news).
  Workaround: Set `$GLOBALS['TYPO3_CONF_VARS']['FE']['pageNotFoundOnCHashError'] = false`
* Search won't be executed on any page if `pageNotFoundOnCHashError` activated.
  Use `$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters']`

## PHPUnit Tests:

```shell
composer install
./vendor/bin/phpunit -c Tests/phpunit.xml
```

## Todos:

* Redesign interfaces
  for example:
  * interface SearchResult
  * interface PageResult implements SearchResult
  * interface FileResult implements SearchResult
  * interface NewsResult implements SearchResult
