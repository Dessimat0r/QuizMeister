<?php
/**
 * QuizMeister. Developed by Chris Dennett (dessimat0r@gmail.com)
 * Donate by PayPal to dessimat0r@gmail.com.
 * Bitcoin: 1JrHT9F96GjHYHHNFmBN2oRt79DDk5kzHq
 */

require_once "qm-min-functions.php";

class QM_Ajax {
	function __construct() {
		add_action( 'wp_ajax_nopriv_qm_get_ajax_quiz_child_cats', array($this, 'get_ajax_quiz_child_cats') );
		add_action( 'wp_ajax_qm_get_ajax_quiz_child_cats', array($this, 'get_ajax_quiz_child_cats') );

		add_action( 'wp_ajax_qm_feat_img_del', array($this, 'featured_img_delete') );
		add_action( 'wp_ajax_qm_featured_img', array($this, 'featured_img_upload') );
	}

	function get_ajax_quiz_child_cats() {
		$parent_cat = $_POST['catID'];
		if (!is_numeric($parent_cat) || ($parent_cat = intval($parent_cat)) <= 0) die();
		die(get_quiz_child_cats($parent_cat));
	}

	function featured_img_delete() {
		check_ajax_referer( 'qm_nonce', 'nonce' );

		$attach_id = isset($_POST['attach_id']) ? intval($_POST['attach_id']) : 0;
		$attachment = get_post($attach_id);

		//post author or editor role
		if (current_user_can('delete_private_pages') || get_current_user_id() === $attachment->post_author) {
			wp_delete_attachment( $attach_id, true );
			echo 'success';
		}

		exit;
	}

	function featured_img_upload() {
		check_ajax_referer( 'qm_featured_img', 'nonce' );

		$upl_data = array(
			'name' => $_FILES['qm_featured_img']['name'],
			'tmp_name' => $_FILES['qm_featured_img']['tmp_name'],
			'type' => $_FILES['qm_featured_img']['type'],
			'size' => $_FILES['qm_featured_img']['size'],
			'error' => $_FILES['qm_featured_img']['error']
		);

		$attach_id = qm_upload_file( $upl_data );

		if ( $attach_id ) {
			$html = qm_feat_img_html( $attach_id );

			$response = array(
				'success' => true,
				'html' => $html,
			);

			echo json_encode( $response );
			exit;
		}

		$response = array('success' => false);
		echo json_encode( $response );
		exit;
	}
}

$qm_ajax = new QM_Ajax();
