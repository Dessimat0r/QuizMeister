<?php
/*
Plugin Name: QuizMeister
Plugin URI: http://demio.us/quizmeister/
Description: QuizMeister is a quiz-creation plugin for Wordpress that allows users to create and share their own quizzes.
Author: Chris Dennett
Version: 1.0
Author URI: http://demio.us/
*/

/**
 * QuizMeister. Developed by Chris Dennett (dessimat0r@gmail.com)
 * Donate by PayPal to dessimat0r@gmail.com.
 * Bitcoin: 1JrHT9F96GjHYHHNFmBN2oRt79DDk5kzHq
 */
require_once 'qm-functions.php';

if (is_admin()) require_once 'admin/settings.php';
require_once 'qm-new-quiz.php';
require_once 'qm-ajax.php';
require_once 'qm-quiz.php';

class QM_Main {
	function __construct() {
		register_activation_hook( __FILE__, array($this, 'activate') );
		register_deactivation_hook( __FILE__, array($this, 'deactivate') );

		add_action( 'init', array($this, 'load_textdomain') );
		add_action( 'init', array($this, 'reg_post_type') );

		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts') );
		if (get_option('qm_use_theme_quiz_template', 'no') === 'no') {
			add_filter('single_template', array($this, 'change_post_type_template'));
		}
	}

	function change_post_type_template($single_template) {
		global $post;
		if ($post->post_type === 'quiz') {
			$single_template = plugin_dir_path( __FILE__ ) . 'templates/single-quiz.php';
		}
		return $single_template;
	}

	function activate() {
		//TODO: plugin setup?
		global $wpdb;
		flush_rewrite_rules( false );
	}

	function deactivate() {
		//TODO: plugin teardown?
		global $wpdb;
		flush_rewrite_rules( false );
	}

	function enqueue_scripts() {
		$path = plugins_url('', __FILE__ );

		// multi-site upload limit filter
		if (is_multisite()) require_once ABSPATH . '/wp-admin/includes/ms.php';
		require_once ABSPATH . '/wp-admin/includes/template.php';

		wp_enqueue_style( 'qm', $path . '/css/qm.css' );

		$params = array('plugin_base' => $path);
		wp_enqueue_script( 'qm', $path . '/js/qm.js', array('jquery') );

		$feat_img_enabled = (get_option( 'qm_enable_featured_image', 'yes' ) === 'yes') ? true : false;

		wp_localize_script( 'qm', 'qm', array(
			'plugin_base' => $path,
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'postingMsg' => __( 'Posting..', 'qm' ),
			'confirmMsg' => __( 'Are you sure?', 'qm' ),
			'nonce' => wp_create_nonce( 'qm_nonce' ),
			'featEnabled' => $feat_img_enabled,
			'plupload' => array(
				'runtimes' => 'html5,silverlight,flash,html4',
				'browse_button' => 'qm-ft-upload-pickfiles',
				'container' => 'qm-ft-upload-container',
				'file_data_name' => 'qm_featured_img',
				'max_file_size' => wp_max_upload_size() . 'b',
				'url' => admin_url( 'admin-ajax.php' ) . '?action=qm_featured_img&nonce=' . wp_create_nonce( 'qm_featured_img' ),
				'flash_swf_url' => includes_url( 'js/plupload/plupload.flash.swf' ),
				'silverlight_xap_url' => includes_url( 'js/plupload/plupload.silverlight.xap' ),
				'filters' => array(array('title' => __( 'Image files' ), 'extensions' => 'jpg,gif,png')),
				'multipart' => true,
				'urlstream_upload' => true
			)
		) );
	}

	function load_textdomain() {
		$locale = apply_filters( 'qm_locale', get_locale() );
		$mofile = dirname( __FILE__ ) . "/languages/qm-{$locale}.mo";

		if ( file_exists( $mofile ) ) {
			load_textdomain( 'qm', $mofile );
		}
	}

	function reg_post_type() {
		$labels = array(
			'name'              => __( 'Quizzes' ),
			'singular_name'     => __( 'Quiz' ),
			'search_items'      => __( 'Search Quizzes' ),
			'all_items'         => __( 'All Quizzes' ),
			'parent_item'       => __( 'Parent Quiz' ),
			'parent_item_colon' => __( 'Parent Quiz:' ),
			'edit_item'         => __( 'Edit Quiz' ),
			'update_item'       => __( 'Update Quiz' ),
			'add_new_item'      => __( 'Add New Quiz' ),
			'new_item_name'     => __( 'New Quiz Name' ),
			'menu_name'         => __( 'Quizzes' )
		);

		// create a new post type
		register_post_type(
			'quiz',
			array(
				'labels' => $labels,
				'public' => true,
				'has_archive' => false,
				'rewrite' => array('slug' => 'quizzes'),
				'query_var' => 'quizzes',
				'supports' => array('title', 'editor', 'author', 'thumbnail')
			)
		);
	}

	public static function log( $type = '', $msg = '' ) {
		if ( WP_DEBUG == true ) {
			$msg = sprintf( "[%s][%s] %s\n", date( 'd.m.Y h:i:s' ), $type, $msg );
			error_log( $msg, 3, dirname( __FILE__ ) . '/log.txt' );
		}
	}

}

$qm = new QM_Main();