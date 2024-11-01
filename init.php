<?php
/*
Plugin Name:	Theme Bakery
Description:	Create new themes, fast and easy!
Author:			Hassan Derakhshandeh
Version:		0.2
Author URI:		http://tween.ir/


		* 	Copyright (C) 2011  Hassan Derakhshandeh
		*	http://tween.ir/
		*	hassan.derakhshandeh@gmail.com

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 2 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Theme_Bakery {

	var $textdomain,
		$base_dir;

	function __construct() {
		$this->base_dir = trailingslashit( dirname( __FILE__ ) );
		add_action( 'admin_menu', array( &$this, 'admin_init' ) );
	}

	function admin_init() {
		$page = add_options_page (
			__( 'Theme Bakery', $this->textdomain ),
			__( 'Theme Bakery', $this->textdomain ),
			'edit_theme_options',
			'theme-bakery',
			array( &$this, 'options_page' )
		);
		add_action( "load-{$page}", array( &$this, 'actions' ) );
		add_action( "admin_print_styles-{$page}", array( &$this, 'queue' ) );
	}

	function queue() {
		wp_enqueue_script( 'theme-bakery', plugins_url( '/js/admin.js', __FILE__ ), array( 'jquery' ) );
	}

	function options_page() {
		require_once( $this->base_dir . 'views/admin.php' );
	}

	/**
	 * Copy all theme files and fix names
	 *
	 * @since 0.1
	 */
	function actions() {
		if( isset( $_POST['themeid'] ) ) {
			$files = array( '404.php', 'archive.php', 'comments.php', 'content.php', 'content-page.php', 'content-single.php', 'footer.php', 'functions.php', 'header.php', 'image.php', 'index.php', 'page.php', 'rtl.css', 'search.php', 'searchform.php', 'sidebar.php', 'single.php', 'style.css', 'inc/template-tags.php', 'inc/theme-options/theme-options.php' );
			$files2 = array( 'screenshot.png', 'js/html5.js', 'js/keyboard-image-navigation.js', 'js/small-menu.js', 'layouts/content-sidebar.css', 'layouts/content-sidebar-sidebar.css', 'layouts/sidebar-content.css', 'layouts/sidebar-content-sidebar.css', 'layouts/sidebar-sidebar-content.css' );

			$template = trailingslashit( $_POST['themeid'] );
			$theme_root = trailingslashit( get_theme_root() );

			if( $_POST['tweaks'] == 1 ) {
				$files[] = 'inc/tweaks.php';
			}
			if( $_POST['customheader'] == 1 ) {
				$files[] = 'inc/custom-header.php';
			}

			/* make template directory */
			mkdir( $theme_root . $template, "0700" );
			/* sub directories */
			foreach( array_merge( $files, $files2 ) as $dest ) {
				$parts = explode( "/", $theme_root . $template . $dest );
				$path = "";
				foreach( $parts as $part ) {
					if( $part == end($parts) ) break;
					$path .= $part . "/";
					@mkdir($path, "0700");
				}
			}

			foreach( $files as $file ) {
				$this->copy( $this->base_dir . '_s/' . $file, $theme_root . $template . $file );
			}

			foreach( $files2 as $file ) {
				copy( $this->base_dir . '_s/' . $file, $theme_root . $template . $file );
			}

			/* activate the generated theme */
			/* this does not seem to work */
			switch_theme( $template, $template );
			wp_redirect( admin_url('themes.php?activated=true') );
		}
	}

	function replace_variables( $contents ) {
		$searches = array(
			"/'_s'/",
			'/_s_/',
			'/ _s/',
			'/http\:\/\/automattic\.com\//',
			'/Automattic/',
		);
		$replaces = array(
			"'". $_POST['themeid'] . "'",
			$_POST['themeid'] . '_',
			' ' . $_POST['themename'],
			$_POST['themeauthoruri'],
			$_POST['themeauthor'],
		);
		$contents = preg_replace( $searches, $replaces, $contents );
		return $contents;
	}

	/**
	 * Copy file from $source to $dest while replacing the correct theme name on them
	 *
	 * @since 0.1
	 */
	function copy( $source, $dest ) {
		$contents = file_get_contents( $source );
		$handle = fopen( $dest, 'w+' );
		fwrite( $handle, $this->replace_variables( $contents ) );
		fclose( $handle );
	}
}
new Theme_Bakery;