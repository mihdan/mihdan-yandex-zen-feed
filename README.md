# Mihdan: Yandex Zen Feed
Contributors: mihdan
Tags: WordPress, Yandex, Zen, Feed
Requires at least: 4.3
Tested up to: 4.8.2
Stable tag: 1.2.3

## Description ##
WordPress плагин, генерирующий фид для сервиса Яндекс.Дзен

## Как работает плагин
После установки фид станет доступным по адресу `http://example.com/feed/mihdan-yandex-zen-feed/`

## Installation ##
* Скопируйте папку плагина `mihdan-yandex-zen-feed` в `/wp-content/plugins/`.
* Активируйте плагин через меню Плагины.

## Changelog ##

## 1.4.1 ##
* Добавил обработку `div > img`

## 1.4.0 ##
* Добавлен фильтр `mihdan_yandex_zen_feed_copyright`
* Проверка на HTML5 `<caption>` через `current_theme_supports()`
* Обработка простых тегов `<div.wp-caption>` -> `<figure>` 
* Обработка простых тегов `<figure.wp-caption>` -> `<figure>`
* Feedname задается ТОЛЬКО через дефисы, подчеркивания запрещены для совмещения со старыми веб-серверами 

## 1.3.0 ##
* Добавлен фильтр `mihdan_yandex_zen_feed_allowable_tags`
* Добавлен фильтр `mihdan_yandex_zen_feed_categories`
* Добавлен фильтр `mihdan_yandex_zen_feed_taxonomy`
* Использован парсер HTML - DiDom
* Обработка простых тегов `<img>` -> `<figure>`

### 1.2.3 ###
* Повесил инициализацию добавления фида на событие `init`

### 1.2.2 ###
* Привёл впорядок README.md

### 1.2.1 ###
* Добавлен фильтр `mihdan_yandex_zen_feed_feedname` для изменения слюга фида
* Количество выводимых постов ограничено пятидесятью
* Добавлен парсер HTML-контента поста `DiDom` для разбора кривого кода и создания из него чистого DOM дерева


