<?php
posts_nav_link();
paginate_comments_links();
$args = array(
	'walker'            => null,
	'max_depth'         => '',
	'style'             => 'ul',
	'callback'          => null,
	'end-callback'      => null,
	'type'              => 'all',
	'reply_text'        => 'Reply',
	'page'              => '',
	'per_page'          => '',
	'avatar_size'       => 32,
	'reverse_top_level' => null,
	'reverse_children'  => '',
	'format'            => 'html5', //or xhtml if no HTML5 theme support
	'short_ping'        => false // @since 3.6,

);
wp_list_comments( $args );