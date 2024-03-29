=== Mihdan: Yandex Zen Feed ===
Contributors: mihdan
Tags: mihdan, yandex, zen, feed
Donate link: https://www.kobzarev.com/donate/
Requires at least: 5.2
Tested up to: 6.2
Requires PHP: 5.6.20
Stable tag: 1.5.2.3
License: GPL2

Плагин генерирует фид для сервиса Яндекс.Дзен

== Installation ==
- Скопируйте папку плагина `mihdan-yandex-zen-feed` в `/wp-content/plugins/`.
- Активируйте плагин через меню Плагины.

== Frequently Asked Questions ==
= Где находится лента? =
После установки фид станет доступным по адресу `http://example.com/feed/mihdan-yandex-zen-feed/`

== Changelog ==

= 1.5.2 (08.05.2023) =
* Добавлена поддержка WordPress 6.2+
* Добавлена поддержка PHP 8.2+

= 1.5.1 (25.12.2018) =
* Исправлены ошибки парсинга, доработаны регулярки
* Добавлены хуки `mihdan_yandex_zen_feed_normalize_html` и `mihdan_yandex_zen_feed_clear_xml`

= 1.5 (20.12.2018) =
* Добавлен метабокс в запись с галочкой для исключения поста из ленты
* Усечён список разрешённых тегов согласно спеке
* Убрать футер записи, который добавляет Yoast SEO
* Нормализация HTML перед парсингом, очистка HTML при помощи `wp_kses()`
* Немного WPCS
* Обновил DiDom
* Вставка обложки поста в начало контента записи

= 1.4.11 =
* Не работал `pre_get_posts` из за неправильного использования feedname

= 1.4.10 =
* Исправлена опечатка в названии методов `on_activate` и `on_deactivate`

= 1.4.9 =
* Добавил фильтр `mihdan_yandex_zen_feed_post_type` для возможности включения в ленту кастомных типов поста

= 1.4.8 =
* Не выводить тег категории, если для нее не найдены соотношения

= 1.4.7 =
* Возможность указать несколько таксономий в виде массива для списка соотношения категорий, которые фильтруются через `mihdan_yandex_zen_feed_taxonomy`

= 1.4.6 =
* Убрал лишнее указание на форматирование вывода ленты

= 1.4.5 =
* Убрал фатальную ошибку при активации плагина на старых версиях РНР

= 1.4.4 =
* Убрал из шаблона все лишнее, оставил только то, что требует спека
* Пофиксил ошибки
* Перенес генерацию тега  в код плагина, чтобы очистить шаблон
* Добавил валидацию, эскейпинг и много мелочевки

= 1.4.3 =
* Добавил фильтр `mihdan_yandex_zen_feed_posts_per_rss`

= 1.4.2 =
* Добавил атрибуты `width` и `height` для `img`

= 1.4.1 =
* Добавил обработку `div > img`

= 1.4.0 =
* Добавлен фильтр `mihdan_yandex_zen_feed_copyright`
* Проверка на HTML5 `` через `current_theme_supports()`
* Обработка простых тегов ` -> 
`
* Обработка простых тегов ` -> 
`
* Feedname задается ТОЛЬКО через дефисы, подчеркивания запрещены для совмещения со старыми веб-серверами

= 1.3.0 =
* Добавлен фильтр `mihdan_yandex_zen_feed_allowable_tags`
* Добавлен фильтр `mihdan_yandex_zen_feed_categories`
* Добавлен фильтр `mihdan_yandex_zen_feed_taxonomy`
* Использован парсер HTML - DiDom
* Обработка простых тегов ` -> 
`

= 1.2.3 =
* Повесил инициализацию добавления фида на событие `init`

= 1.2.2 =
* Привёл впорядок README.md

= 1.2.1 =
* Добавлен фильтр `mihdan_yandex_zen_feed_feedname` для изменения слюга фида
* Количество выводимых постов ограничено пятидесятью
* Добавлен парсер HTML-контента поста DiDom для разбора кривого кода и создания из него чистого DOM дерева
