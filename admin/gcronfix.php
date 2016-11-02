<?php
/**
 * QuizMeister. Developed by Chris Dennett (dessimat0r@gmail.com)
 * Donate by PayPal to dessimat0r@gmail.com.
 * Bitcoin: 1JrHT9F96GjHYHHNFmBN2oRt79DDk5kzHq
 */

require_once('../../../../wp-load.php');

if (isset($wp_did_header) || !current_user_can('manage_options')) {
	wp_die('Cheating...', 403);
}
$wp_did_header = true;
$orhans_cleaned = qm_cron_gallery_cleanup(true);
echo $orhans_cleaned + ' orphans cleaned (looking for quiz=quiz metadata only from quiz gallery uploads...)';
exit( wp_redirect( admin_url('admin.php?page=qm') ) );
?>
