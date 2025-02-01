<?php

/*
 * Plugin Name: Standard Post Format Archives
 * Description: Allow archive queries for the "Standard" post format
 * Text Domain: spfa
 * Version: 0.1
 * Author: Jay Sitter
 * Author URI: https://www.jaysitter.com/
 */

function spfa_standard_posts( $query ) {
	if ( 'post-format-standard' === $query->get( 'post_format' ) ) {
		$query->set( 'tax_query', array(
			array(
				'taxonomy' => 'post_format',
				'operator' => 'NOT EXISTS'
			)
		) );

		$query->set( 'post_format', NULL );
	}
}
add_action( 'pre_get_posts', 'spfa_standard_posts' );

function spfa_standard_posts_archive_title( $title ) {
	global $wp_query;

	if (
		is_tax() &&
		array_key_exists( 'post_format', $wp_query->query ) &&
		'post-format-standard' === $wp_query->query['post_format'] &&
		__( 'Archives', 'spfa' ) === $title
	) {
		return __( 'Standard Posts', 'spfa' );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'spfa_standard_posts_archive_title' );

function spfa_document_title( $title ) {
	global $wp_query;

	if (
		is_tax() &&
		array_key_exists( 'post_format', $wp_query->query ) &&
		'post-format-standard' === $wp_query->query['post_format'] &&
		empty( $title['title'] )
	) {
		$title['title'] = __( 'Standard Posts', 'spfa' );
	}

	return $title;
}
add_filter( 'document_title_parts', 'spfa_document_title' );
