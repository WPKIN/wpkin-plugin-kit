<?php

/**
 * Method wpkin_plugins_allowedtags.
 * Allow html tag.
 *
 * @since 1.0.6
 * @access public
 */
function wpkin_plugins_allowedtags() {
	return [
		'a'      => [
			'href'   => [],
			'title'  => [],
			'target' => [],
			'class'  => [],
			'id'     => [],
		],
		'nav'    => [
			'class' => [],
			'id'    => [],
		],
		'unit'   => [],
		'style'  => [],
		'code'   => [],
		'em'     => [],
		'strong' => [],
		'div'    => [
			'class' => [],
			'id'    => [],
		],
		'span'   => [
			'class' => [],
			'id'    => [],
		],
		'p'      => [
			'class' => [],
			'id'    => [],
		],
		'ul'     => [
			'class' => [],
			'id'    => [],
		],
		'li'     => [
			'class' => [],
			'id'    => [],
		],
		'i'      => [ 'class' => [] ],
		'h1'     => [],
		'h2'     => [],
		'h3'     => [],
		'h4'     => [],
		'h5'     => [],
		'img'    => [
			'src'   => [],
			'class' => [],
			'alt'   => [],
		],
	];
}