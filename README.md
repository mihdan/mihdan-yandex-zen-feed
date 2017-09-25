# Mihdan: Yandex Zen Feed
Contributors: mihdan
Tags: WordPress, Yandex, Zen, Feed
Requires at least: 4.3
Tested up to: 4.8.2
Stable tag: 1.2.3

## Description ##
WordPress плагин, генерирующий фид для сервиса Яндекс.Дзен

## Как работает плагин
После установки фид станет доступным по адресу `http://example.com/feed/yandex-zen/`

## Installation ##
* Скопируйте папку плагина `mihdan-yandex-zen-feed` в `/wp-content/plugins/`.
* Активируйте плагин через меню Плагины.

## Changelog ##

### 1.2.3 ###
* Повесил инициализацию добавления фида на событие `init`

### 1.2.2 ###
* Привёл впорядок README.md

### 1.2.1 ###
* Добавлен фильтр `mihdan_yandex_zen_feed_feedname` для изменения слюга фида
* Количество выводимых постов ограничено пятидесятью
* Добавлен парсер HTML-контента поста `DiDom` для разбора кривого кода и создания из него чистого DOM дерева


