<?php
/**
* The template for displaying all single posts and attachments
*
* @package twenty-fifteen-qm
* @since twenty-fifteen-qm 1.0
*/

/**
 * QuizMeister. Developed by Chris Dennett (dessimat0r@gmail.com)
 * Donate by PayPal to dessimat0r@gmail.com.
 * Bitcoin: 1JrHT9F96GjHYHHNFmBN2oRt79DDk5kzHq
 */
assert("class_exists('QMData')", "quizmeister plugin not loaded (qm_do_quiz(...) missing)");
assert("is_single()", "not single post");

// this needs to be moved into functions.php if defining as theme -- start
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', plugins_url('style.css', __FILE__) );
}
// end

$tw_data_rel = get_option('qm_twitter_data_rel', null);
$fb_app_id = get_option('qm_facebook_app_id', null);
if (isset($fb_app_id)) $fb_app_id = intval($fb_app_id);

$qmdata = new QMData(wp_get_current_user(), get_the_ID());

if (!have_posts()) return;
the_post();

function add_open_graph_meta() {
	echo '<meta property="og:url" content="'.get_permalink(get_the_ID()).'" />';
	echo '<meta property="og:type" content="article" />';
	echo '<meta property="og:title" content="'.htmlentities(get_the_title(), ENT_HTML5).'" />';
	//echo '<meta property="og:description" content="'.htmlentities(wp_strip_all_tags(get_the_content()), ENT_HTML5).'" />';
	if (has_post_thumbnail()) {
		$post_thumbnail_id  = get_post_thumbnail_id(get_the_ID());
		$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
		echo '<meta property="og:image" content="'.esc_url($post_thumbnail_url).'" />';
	}
	echo '<meta property="og:description" content="'.htmlentities(get_the_excerpt(), ENT_HTML5).'" />';
}

add_action('wp_head','add_open_graph_meta',1);
get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		function theme_slug_post_classes( $classes, $class, $post_id ) {
			$classes[] = 'in-quiz';
			return $classes;
		}
		if ($qmdata->in_quiz) add_filter( 'post_class', 'theme_slug_post_classes', 10, 3 );

		?>

		<script>

		function fb_share_click() {
			<?php
			if (isset($fb_app_id)) {
				if ($qmdata->done_quiz) {
					$res_score_perc = round(($qmdata->res_score/$qmdata->res_numq)*100,1);
					if      ($res_score_perc >= 90) $share_exc = ' -- whoa!!!';
					else if ($res_score_perc >= 80) $share_exc = '! Wow!!';
					else if ($res_score_perc >= 70) $share_exc = '! Awesome!';
					else if ($res_score_perc >= 60) $share_exc = '. Great success!';
					else if ($res_score_perc >= 50) $share_exc = '. Not bad.';
					else if ($res_score_perc >= 40) $share_exc = '. Bleh.';
					else if ($res_score_perc >= 30) $share_exc = '. Meh.';
					else if ($res_score_perc >= 20) $share_exc = '. Ow..';
					else if ($res_score_perc >= 10) $share_exc = '. Sigh...';
					else                            $share_exc = '...';
					$share_ext = "I scored {$qmdata->res_score} out of {$qmdata->res_numq} ({$res_score_perc}%){$share_exc} How will you fare?";
				} else {
					$share_ext = "Put your knowledge to the test!";
				}
				/* name: 'Quiz: '+"<=esc_js( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) );>",*/
				$offset   = get_option('gmt_offset');
				$offset   = 'UTC'.($offset < 0 ? '-' : '+').$offset;
				?>
				FB.ui({
					method: 'feed',
					app_id: '<?=$fb_app_id;?>',
					name: "<?=esc_js( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) );?>: <?=$share_ext;?>",
					link: '<?=get_permalink(get_the_ID());?>',
					description: "<?=esc_js( html_entity_decode( get_the_excerpt(), ENT_COMPAT, 'UTF-8' ) );?>",
					caption: "Quiz created by <?=esc_js( html_entity_decode( get_the_author(), ENT_COMPAT, 'UTF-8' ) );?> on <?=get_the_time('F j, Y \a\t g:i a')?> (<?=$offset;?>)."
				});
			<?php } ?>
		}

		jQuery(function($) {
			function make_share() {
				var share_stuff = $('#qm-share-stuff');
				if (share_stuff.length) {
					window.console && window.console.log("found #qm-share-stuff, not remaking");
					return;
				}
				var create_quiz = $('#qm-create-quiz');
				if (!create_quiz.length) {
					window.console && window.console.log("not found #qm-create-quiz");
					return;
				}
				$('<div id="qm-share-stuff"><div style="clear: right;">Share this result:</div><a id="fb-share-ph" /><a id="tw-share-ph" /></div>').insertAfter(create_quiz);
				window.console && window.console.log("inserted #qm-share-stuff");
			};

			window.twttr = (function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0],
				t = window.twttr || {};
				if (d.getElementById(id)) return t;
				js = d.createElement(s);
				js.id = id;
				js.src = "https://platform.twitter.com/widgets.js";
				fjs.parentNode.insertBefore(js, fjs);

				t._e = [];
				t.ready = function(f) {
					t._e.push(f);
				};
				return t;
			}(document, "script", "twitter-wjs"));

			window.twttr.ready(function(t) {
				$(document).ready(function() {
					window.console && window.console.log("twitter ready");
					make_share();
					var twp = $('#tw-share-ph');
					if (!twp.length) {
						window.console && window.console.log("no #twp");
						return;
					}
					<?php
					if ($qmdata->done_quiz) {
						$res_score_perc = round(($qmdata->res_score/$qmdata->res_numq)*100,1);
						if      ($res_score_perc >= 90) $share_exc = ' -- whoa!!!';
						else if ($res_score_perc >= 80) $share_exc = '! Wow!!';
						else if ($res_score_perc >= 70) $share_exc = '! Awesome!';
						else if ($res_score_perc >= 60) $share_exc = '. Great success!';
						else if ($res_score_perc >= 50) $share_exc = '. Not bad.';
						else if ($res_score_perc >= 40) $share_exc = '. Bleh.';
						else if ($res_score_perc >= 30) $share_exc = '. Meh.';
						else if ($res_score_perc >= 20) $share_exc = '. Ow..';
						else if ($res_score_perc >= 10) $share_exc = '. Sigh...';
						else                            $share_exc = '...';
						$share_txt = htmlspecialchars("I scored {$qmdata->res_score} out of {$qmdata->res_numq} ({$res_score_perc}%) on the quiz '".esc_js( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) )."'{$share_exc}", ENT_QUOTES);
					} else {
						$share_txt = htmlspecialchars("Put your knowledge to the test on the quiz '".esc_js( html_entity_decode( get_the_title(), ENT_COMPAT, 'UTF-8' ) )."'! How will you fare?", ENT_QUOTES);
					}
					?>

					twp.replaceWith(
						'<span class="tw-share-button">'+
						'<a href="https://twitter.com/share" class="twitter-share-button" data-text="<?=$share_txt;?>" data-url="<?=get_permalink(get_the_ID());?>" data-size="large" data-related="<?=isset($tw_data_rel) ? $tw_data_rel.',' : null;?>QuizMeisterWP" data-hashtags="quiz">Tweet</a>'+
						'</span>'
					);
					window.twttr.widgets.load();
				});
			});

			<?php if (isset($fb_app_id)) { ?>
				window.fbAsyncInit = function() {
					FB.init({
						appId      : '<?=$fb_app_id;?>',
						xfbml      : true,
						version    : 'v2.5'
					});

					$(document).ready(function() {
						make_share();
						var fbp = $('#fb-share-ph');
						if (!fbp.length) {
							window.console && window.console.log("no #fb-share-ph");
							return;
						}
						fbp.replaceWith(
							'<span class="fb-share-btn"><a href="#"><img src="<?=plugins_url('images/fb.png', __FILE__ ); ?>"></a></span>'
						);
						$(".fb-share-btn > a").click(function(e) {
							e.preventDefault();
							fb_share_click();
						}).find("> img").hover(
							function(e) {
								$(this).attr('src', '<?=plugins_url('images/fb-over.png', __FILE__ ); ?>');
							}, function(e) {
								$(this).attr('src', '<?=plugins_url('images/fb.png', __FILE__ ); ?>');
							}
						);
					});
				};

				(function(d, s, id){
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) {return;}
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/en_US/sdk.js";
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			<?php } ?>
		});
		</script>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php
			// Post thumbnail.
			if (!$qmdata->in_quiz && !(post_password_required() || is_attachment() || ! has_post_thumbnail())) {
				?>
				<div class="post-thumbnail">
					<?php the_post_thumbnail('medium'); ?>
				</div><!-- .post-thumbnail -->
				<?php
			}
			?>
			<header class="entry-header">
				<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php
				if (isset($qmdata->last_a_right)) {
					echo '<div style="font-size:20px"><strong>'.($qmdata->last_a_right ? 'Correct!' : 'Incorrect!').'</strong> The correct answer to <em>\''.$qmdata->last_q_text.'\'</em> was <em>\''.$qmdata->last_q_rightans_text.'\'</em>.'.(isset($qmdata->last_q_explan) ? ' <em>'.$qmdata->last_q_explan.'</em>' : '').'<hr></div>';
				}
				if ($qmdata->in_quiz) {
					echo '<div style="font-size:20px"><strong>Question #'.($qmdata->q_index+1).' of '.($qmdata->num_q).':</strong> <em>'.$qmdata->q_text.'</em></div>';
					if (isset($qmdata->q_sub) && !empty($qmdata->q_sub))   echo '<div style="font-size:17px; padding-left:10px;">'.$qmdata->q_sub.'</div>';
					if (isset($qmdata->q_embed) && !empty($qmdata->q_embed)) {
						echo '<div style="font-size:15px; padding-top:20px;">';
						$oembed = wp_oembed_get($qmdata->q_embed);
						if ($oembed && ($ombed = trim($oembed)) !== '') {
							echo $oembed;
						} else {
							echo 'Couldn\'t access embedded media for this question from WordPress server - the media may have been removed. Contact the quiz author to have them correct the link. Alternatively, the media host may be down temporaily. Embed URL: <a href="' . $qmdata->q_embed . '" target="_blank">' . $qmdata->q_embed . '</a>.';
						}
						echo '</div>';
					}
					$qmdata->output_answer_form_head(); ?>
					<ol id="qm-answer-list"><?php
					for ($i = 0; $i < $qmdata->q_anum; $i++) {
						$a_text = $qmdata->a_text[$i];
						?><li><label><input id="qm-q-a-<?=$i; ?>-ans" name="qm-q-<?=$qmdata->q_index; ?>-a" type="radio" value="<?=$i; ?>" style="margin-right:5px"<?=$i===0 ? ' checked' : '' ?>> <?=$a_text; ?></label></li><?php
					}
					?></ol>
					<div style="padding-top:20px"><input type="submit" name="choose-answer" value="Choose Answer"><?=$qmdata->q_index > 0 ? ' <input type="submit" id="start-quiz" name="start-quiz" value="Start Over">' : '' ?></div>
					</form>
					<?php
				} else {
					if (!$qmdata->has_q_form) {
						the_content();
					}
					if ($qmdata->done_quiz) {
						$res_score_perc = round(($qmdata->res_score/$qmdata->res_numq)*100,1);
						if ($qmdata->has_q_form) echo "This quiz is now complete and you answered {$qmdata->res_score} out of {$qmdata->res_numq} questions correctly ($res_score_perc%).";
						else {
							$offset   = get_option('gmt_offset');
							$offset   = 'UTC'.($offset < 0 ? '-' : '+').$offset;
							$last_did = date('d M Y \a\t H:i', $qmdata->res_time);
							echo "When you last did this quiz on {$last_did} ({$offset}), you answered {$qmdata->res_score} out of {$qmdata->res_numq} questions correctly ($res_score_perc%).";
						}
						if ($res_score_perc >= 100) echo ' Well done!'; else if ($res_score_perc <= 0) echo ' Ouch!';
						if (!$qmdata->logged_in) { ?><p><a href="<?=wp_login_url(get_permalink($qmdata->post_id).'?upddb=true'); ?>">Log in</a> to save this result.</p><?php }?>
						<hr>
						<div id="qm-create-quiz">
							<p><a href="<?=get_site_url(null, '/index.php/new-quiz', null);?>">Create your own quiz?</a> (login via Facebook, Google, Wordpress account, etc.)</p>
						</div><?php
					} else {
						// quiz hasn't been done yet, no saved data
						?>This quiz is comprised of <?=$qmdata->num_q; ?> questions.<?php
						/* <?php wp_nonce_field('p'.$post_id.'_start_quiz', 'qm-nonce'); ?> */
					}
					?><form id="qm-quiz-form" name="qm-quiz-form" method="post" action="<?=get_permalink(get_the_ID());?>">
						<input type="submit" id="start-quiz" name="start-quiz" value="<?=!$qmdata->done_quiz ? 'Start Quiz!' : 'Re-do Quiz' ?>">
						<div id="qm-about">This quiz is powered by <a href="http://demio.us/quizmeister/">QuizMeister</a>, created by Chris Dennett. Consider donating! :)</div>
					</form><?php
				}
				?>
			</div><!-- .entry-content -->

			<?php
			/*
			if (!$in_quiz || $quiz_end) {
			// Author bio.
			if ( get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
			endif;

			//TODO: make a list of transferrable vars from $_POST to $_GET to put into the comments (also modify page to enable GET for comments link)
			// or bake results into database after quiz done for user and keep getting quiz end stuff (easier option?)

			//echo '<p>comments open: '.(comments_open() ? 'true' : 'false').'; comments number: '.get_comments_number().'</p>';

			// If comments are open or we have at least one comment, load up the comment template.
			//if ( comments_open() || get_comments_number() ) :
			//	comments_template();
			//endif;
			}
			*/
			?>

			<footer class="entry-footer">
				<?php
				/* twentyfifteen_entry_meta(); */

				$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

				if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
					$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
				}

				$time_string = sprintf(
					$time_string,
					esc_attr( get_the_date( 'c' ) ),
					get_the_date(),
					esc_attr( get_the_modified_date( 'c' ) ),
					get_the_modified_date()
				);

				printf(
					'<span class="posted-on"><span class="screen-reader-text">%1$s</span><a href="%2$s" rel="bookmark">%3$s</a></span>',
					_x( 'Posted on', 'Used before publish date.', 'twentyfifteen' ),
					get_permalink(),
					$time_string
				);

				printf(
					'<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s</span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
					_x( 'Author', 'Used before post author name.', 'twentyfifteen' ),
					get_author_posts_url( get_the_author_meta( 'ID' ) ),
					get_the_author()
				);

				$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfifteen' ) );
				if ( $categories_list && twentyfifteen_categorized_blog() ) {
					printf(
						'<span class="cat-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
						_x( 'Categories', 'Used before category names.', 'twentyfifteen' ),
						$categories_list
					);
				}

				$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'twentyfifteen' ) );
				if ( $tags_list ) {
					printf(
						'<span class="tags-links"><span class="screen-reader-text">%1$s</span>%2$s</span>',
						_x( 'Tags', 'Used before tag names.', 'twentyfifteen' ),
						$tags_list
					);
				}
				?>
				<?php /* edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); */ ?>
			</footer><!-- .entry-footer -->
		</article><!-- #post-## -->
	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
