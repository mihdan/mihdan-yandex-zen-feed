<?php
/**
 * Фид для сервиса Яндекс.Дзен
 *
 * @author mikhail@kobzarev.com
 * @link https://yandex.ru/support/zen/publishers/rss.html
 */
/** @var Mihdan_Yandex_Zen_Feed $this  */
header( 'Content-Type: ' . feed_content_type( 'rss-http' ) . '; charset=' . get_option( 'blog_charset' ), true );
echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?' . '>';
?>
<rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:georss="http://www.georss.org/georss">
	<channel>
		<title><?php bloginfo_rss( 'name' ); ?></title>
		<link><?php bloginfo_rss( 'url' ); ?></link>
		<description><?php bloginfo_rss( 'description' ); ?></description>
		<language><?php echo substr( get_bloginfo_rss( 'language' ), 0, strpos( get_bloginfo_rss( 'language' ), '-' ) );?></language>
		<?php do_action( 'rss2_head' ); ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<item>
				<title><?php the_title_rss(); ?></title>
				<link><?php the_permalink_rss(); ?></link>
				<guid><?php echo apply_filters('mihdan_yandex_zen_feed_item_guid',get_the_guid(get_the_ID()), get_the_ID());?></guid>
				<pubDate><?php echo get_post_time( 'r', true ); ?></pubDate>
				<author><?php the_author(); ?></author>
				<description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
				<content:encoded>
					<![CDATA[<?php the_content_feed(); ?>]]>
				</content:encoded>
				<?php do_action( 'mihdan_yandex_zen_feed_item', get_the_ID() ); ?>
			</item>
		<?php endwhile; ?>
	</channel>
</rss>
