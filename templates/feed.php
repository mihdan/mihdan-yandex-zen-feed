<?php
/**
 * Фид для сервиса Яндекс.Дзен
 *
 * @author mikhail@kobzarev.com
 * @link https://yandex.ru/support/zen/publishers/rss.html
 */

header( 'Content-Type: ' . feed_content_type( 'rss-http' ) . '; charset=' . get_option( 'blog_charset' ), true );
echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?' . '>';

$wpseo_titles = get_option( 'wpseo_titles' ); ?>

<rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:media="http://search.yahoo.com/mrss/"
     xmlns:atom="http://www.w3.org/2005/Atom"
     xmlns:georss="http://www.georss.org/georss">
	<channel>
		<title><?php bloginfo_rss( 'name' ); ?></title>
		<link><?php bloginfo_rss( 'url' ); ?></link>
		<description><?php echo esc_html( $wpseo_titles['metadesc-home-wpseo'] ); ?></description>
		<language>ru</language>
		<atom:link href="<?php echo esc_url( get_feed_link('yandex-zen') ); ?>" rel="self" type="application/rss+xml" />
		<?php do_action( 'rss2_head' ); ?>
		<?php while( have_posts()) : the_post(); ?>
			<item>
				<title><?php the_title_rss(); ?></title>
				<link><?php the_permalink_rss(); ?></link>
				<guid><?php the_permalink_rss(); ?></guid>
				<pubDate><?php echo mysql2date( 'r', get_the_time( 'Y-m-d H:i:s' ), false ); ?></pubDate>
				<author><?php the_author(); ?></author>
				<description><?php  ob_start(); the_excerpt();  $output = ob_get_contents();  ob_end_clean(); echo mihdan_yandex_zen_feed()->clear_xml( strip_tags( $output ) ); ?></description>

				<?php
				$category = '';
				$categories = get_the_terms( get_the_ID(), mihdan_yandex_zen_feed()->get_taxonomy() );

				if ( $categories ) {
					$category = mihdan_yandex_zen_feed()->get_category( $categories[0]->term_id );
				}

				if ( $category ) : ?>
					<category><?php echo esc_html( $category ); ?></category>
				<?php endif; ?>

				<?php
				// Все картинки для поста
				$images = get_attached_media( 'image', get_the_ID() );
				if ( $images ) : ?>
					<?php foreach ( $images as $image ) : ?>
						<enclosure length="<?php echo esc_attr( filesize( get_attached_file( $image->ID ) ) ); ?>" url="<?php echo esc_url( wp_get_attachment_image_url( $image->ID, 'large' ) ); ?>" type="<?php echo esc_attr( $image->post_mime_type ); ?>" />
					<?php endforeach; ?>
				<?php endif; ?>

				<content:encoded>
					<![CDATA[<?php echo mihdan_yandex_zen_feed()->clear_xml( get_the_content_feed() ); ?>]]>
				</content:encoded>
			</item>

		<?php endwhile; ?>

	</channel>

</rss>