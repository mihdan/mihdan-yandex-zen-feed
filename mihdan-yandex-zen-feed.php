<?php
/**
 * Mihdan: Yandex Zen Feed
 *
 * @package   mihdan-yandex-zen-feed
 * @author    Mikhail Kobzarev
 * @link      https://github.com/mihdan/mihdan-yandex-zen-feed/
 * @copyright Copyright (c) 2017
 * @license   GPL-2.0+
 * @wordpress-plugin
 */

/**
 * Plugin Name: Mihdan: Yandex Zen Feed
 * Plugin URI: https://www.kobzarev.com/projects/yandex-zen-feed/
 * Description: Плагин генерирует фид для сервиса Яндекс.Дзен
 * Version: 1.2.1
 * Author: Mikhail Kobzarev
 * Author URI: https://www.kobzarev.com/
 * License: GNU General Public License v2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: mihdan-yandex-zen-feed
 * GitHub Plugin URI: https://github.com/mihdan/mihdan-yandex-zen-feed/
 * GitHub Branch:     master
 * Requires WP:       4.6
 * Requires PHP:      5.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Mihdan_Yandex_Zen_Feed' ) ) {

	/**
	 * Class Mihdan_Yandex_Zen_Feed
	 *
	 * @link https://github.com/justintadlock/butterbean
	 */
	final class Mihdan_Yandex_Zen_Feed {

		private $slug = 'mihdan_yandex_zen_feed';

		/**
		 * Путь к плагину
		 *
		 * @var string
		 */
		public static $dir_path;

		/**
		 * URL до плагина
		 *
		 * @var string
		 */
		public static $dir_uri;

		/**
		 * Хранит экземпляр класса
		 *
		 * @var $instance
		 */
		private static $instance;

		/**
		 * Соотношение категорий.
		 *
		 * @var
		 */
		private $categories;

		/**
		 * Таксономия для соотношений.
		 *
		 * @var string
		 */
		private $taxonomy = 'category';

		/**
		 * Вернуть единственный экземпляр класса
		 *
		 * @return Mihdan_Yandex_Zen_Feed
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Инициализируем нужные методы
		 *
		 * Mihdan_FAQ constructor.
		 */
		private function __construct() {
			$this->setup();
			$this->includes();
			$this->hooks();
		}

		/**
		 * Установка основных переменных плагина
		 */
		private function setup() {
			self::$dir_path = apply_filters( 'mihdan_yandex_zen_feed_dir_path', trailingslashit( plugin_dir_path( __FILE__ ) ) );
			self::$dir_uri   = apply_filters( 'mihdan_yandex_zen_feed_dir_uri', trailingslashit( plugin_dir_url( __FILE__ ) ) );

			$this->categories = apply_filters( 'mihdan_yandex_zen_feed_categories', array() );
			$this->taxonomy = apply_filters( 'mihdan_yandex_zen_feed_taxonomy', $this->taxonomy );
		}

		/**
		 * Подключаем зависимости
		 */
		private function includes() {}

		/**
		 * Хукаем.
		 */
		private function hooks() {
			add_feed( apply_filters( 'mihdan_yandex_zen_feed_feedname', $this->slug ), array( $this, 'add_feed' ) );
			add_action( 'pre_get_posts', array( $this, 'alter_query' ) );
		}

		/**
		 * Подправляем основной луп фида
		 *
		 * @param WP_Query $wp_query объект запроса
		 */
		public function alter_query( WP_Query $wp_query ) {
			if ( $wp_query->is_main_query() && $wp_query->is_feed() && $this->slug === $wp_query->get( 'feed' ) ) {

				// Ограничить посты 50-ю
				$wp_query->set( 'posts_per_rss', 50 );
			}
		}

		public function add_feed() {
			require self::$dir_path . 'templates/feed.php';
		}

		/**
		 * Чистит контент фида от грязи наших плагинов.
		 *
		 * @param string $str строка для очистки
		 * @author mikhail@kobzarev.com
		 * @return string
		 */
		public function clear_xml( $str ) {
			$str = preg_replace( '#<script(.*?)>(.*?)</script>#is', '', $str );
			$str = strip_tags( $str, '<br><br/><p><h2><h3><h4><h5><h6><ul><ol><li><img><a>' );

			$str = str_replace( '&hellip;', '...', $str );
			$str = str_replace( '&nbsp;', ' ', $str );

			$str = preg_replace( '|(<img.*?src=".*?ajax\-loader.*?".*?>)|si', '', $str );
			$str = preg_replace( '|<img.*?src=".*?gear_icon\.png".*?>|si', '', $str );
			$str = preg_replace( '|<img([^>]+)>|si', '<img$1>', $str );
			$str = str_replace( 'data-src="', 'src="', $str );
			$str = preg_replace( '/[\r\n]+/', "\n", $str );
			$str = preg_replace( '/[ \t]+/', ' ', $str );

			$str = preg_replace( '/(<img.*?>)/', '<figure>$1</figure>', $str );
			$str = preg_replace( '/ style="[^"]+"/', '', $str );
			$str = preg_replace( '/ srcset="[^"]+"/', '', $str );
			$str = preg_replace( '/ sizes="[^"]+"/', '', $str );

			$str = str_replace( PHP_EOL, ' ', $str );
			$str = str_replace( '  ', ' ', $str );

			return trim( $str );
		}

		/**
		 * Найти название категории, исходя из соотношений в теме сайта.
		 *
		 * @param integer $category_id идентификатор категории.
		 *
		 * @return bool|int|string
		 */
		public function get_category( $category_id ) {

			return $this->array_search( $category_id, $this->categories );
		}

		/**
		 * Получить название такосномии для соотношений.
		 * По-умолчанию, это category.
		 *
		 * @return string
		 */
		public function get_taxonomy() {
			return $this->taxonomy;
		}

		/**
		 * Рекурсивный поиск в массиве.
		 * Возвращает ключ первого найденного вхождения.
		 *
		 * @param string $needle строка поиска.
		 * @param array $haystack массив, в котором искать.
		 *
		 * @return bool|int|string
		 */
		public function array_search( $needle, $haystack ) {

			foreach ( $haystack as $key => $value ) {
				$current_key = $key;
				if ( $needle === $value or ( is_array( $value ) && $this->array_search( $needle, $value ) !== false ) ) {
					return $current_key;
				}
			}

			return false;
		}

		/**
		 * Сбросить реврайты при активации/деактивации плагина.
		 */
		public static function flush_rewrite() {
			flush_rewrite_rules();
		}
	}

	function mihdan_yandex_zen_feed() {
		return Mihdan_Yandex_Zen_Feed::get_instance();
	}

	add_action( 'after_setup_theme', 'mihdan_yandex_zen_feed' );
	register_activation_hook( __FILE__, array( 'Mihdan_Yandex_Zen_Feed', 'flush_rewrite' ) );
	register_deactivation_hook( __FILE__, array( 'Mihdan_Yandex_Zen_Feed', 'flush_rewrite' ) );
}