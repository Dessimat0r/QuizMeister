<?php
/**
 * QuizMeister. Developed by Chris Dennett (dessimat0r@gmail.com)
 * Donate by PayPal to dessimat0r@gmail.com.
 * Bitcoin: 1JrHT9F96GjHYHHNFmBN2oRt79DDk5kzHq
 */
class QM_New_Quiz {
	// statics
	public static $min_q    = 1;  // min questions, int
	public static $min_a_pq = 2;  // min answers per question, int
	public static $max_q    = 10; // max questions, int
	public static $max_a_pq = 5; // max answers per question, int
	public static $q_text_maxtextlen = 50; // max question text length, int
	public static $q_sub_maxtextlen  = 200; // max question sub-text length, int
	public static $q_explan_maxtextlen  = 200; // max question explan length, int
	public static $q_embed_maxtextlen  = 200; // max question embed length, int
	public static $q_a_text_maxtextlen = 50; // max answer text length, int

	public static $allowed_desc_tags = array (
		'address' => array ( 'title' => true, ),
		'a' => array ( 'href' => true, 'rel' => true, 'rev' => true, 'name' => true, 'target' => true, 'title' => true, ),
		'abbr' => array ( 'title' => true, ),
		'acronym' => array ( 'title' => true, ),
		'b' => array ( 'title' => true, ),
		'bdo' => array ( 'dir' => true, 'title' => true, ),
		'big' => array ( 'title' => true, ),
		'blockquote' => array ( 'cite' => true, 'title' => true, ),
		'br' => array ( 'title' => true, ),
		'cite' => array ( 'dir' => true, 'title' => true, ),
		'code' => array ( 'title' => true, ),
		'col' => array ( 'align' => true, 'char' => true, 'charoff' => true, 'span' => true, 'dir' => true, 'valign' => true, 'width' => true, 'title' => true, ),
		'colgroup' => array ( 'align' => true, 'char' => true, 'charoff' => true, 'span' => true, 'valign' => true, 'width' => true, 'title' => true, ),
		'del' => array ( 'datetime' => true, 'title' => true, ),
		'dd' => array ( 'title' => true, ),
		'dfn' => array ( 'title' => true, ),
		'details' => array ( 'align' => true, 'dir' => true, 'open' => true, 'title' => true, ),
		'div' => array ( 'align' => true, 'dir' => true, 'title' => true, ),
		'dl' => array ( 'title' => true, ),
		'dt' => array ( 'title' => true, ),
		'em' => array ( 'title' => true, ),
		'h1' => array ( 'align' => true, 'title' => true, ),
		'h2' => array ( 'align' => true, 'title' => true, ),
		'h3' => array ( 'align' => true, 'title' => true, ),
		'h4' => array ( 'align' => true, 'title' => true, ),
		'h5' => array ( 'align' => true, 'title' => true, ),
		'h6' => array ( 'align' => true, 'title' => true, ),
		'header' => array ( 'align' => true, 'dir' => true, 'title' => true, ),
		'hgroup' => array ( 'align' => true, 'dir' => true, 'title' => true, ),
		'hr' => array ( 'align' => true, 'noshade' => true, 'size' => true, 'width' => true, 'title' => true, ),
		'i' => array ( 'title' => true, ),
		'ins' => array ( 'datetime' => true, 'cite' => true, 'title' => true, ),
		'kbd' => array ( 'title' => true, ),
		'label' => array ( 'for' => true, 'title' => true, ),
		'legend' => array ( 'align' => true, 'title' => true, ),
		'li' => array ( 'align' => true, 'value' => true, 'title' => true, ),
		'mark' => array ( 'title' => true, ),
		'p' => array ( 'align' => true, 'dir' => true, 'title' => true, ),
		'pre' => array ( 'width' => true, 'title' => true, ),
		'q' => array ( 'cite' => true, 'title' => true, ),
		's' => array ( 'title' => true, ),
		'samp' => array ( 'title' => true, ),
		'span' => array ( 'dir' => true, 'align' => true, 'title' => true, ),
		'section' => array ( 'align' => true, 'dir' => true, 'title' => true, ),
		'small' => array ( 'title' => true, ),
		'strike' => array ( 'title' => true, ),
		'strong' => array ( 'title' => true, ),
		'sub' => array ( 'title' => true, ),
		'summary' => array ( 'align' => true, 'dir' => true, 'title' => true, ),
		'sup' => array ( 'title' => true, ),
		'table' => array ( 'align' => true, 'bgcolor' => true, 'border' => true, 'cellpadding' => true, 'cellspacing' => true, 'dir' => true, 'rules' => true, 'summary' => true, 'width' => true, 'title' => true, ),
		'tbody' => array ( 'align' => true, 'char' => true, 'charoff' => true, 'valign' => true, 'title' => true, ),
		'td' => array ( 'abbr' => true, 'align' => true, 'axis' => true, 'bgcolor' => true, 'char' => true, 'charoff' => true, 'colspan' => true, 'dir' => true, 'headers' => true, 'height' => true, 'rowspan' => true, 'scope' => true, 'valign' => true, 'width' => true, 'title' => true, ),
		'tfoot' => array ( 'align' => true, 'char' => true, 'charoff' => true, 'valign' => true, 'title' => true, ),
		'th' => array ( 'abbr' => true, 'align' => true, 'axis' => true, 'bgcolor' => true, 'char' => true, 'charoff' => true, 'colspan' => true, 'headers' => true, 'height' => true, 'rowspan' => true, 'scope' => true, 'valign' => true, 'width' => true, 'title' => true, ),
		'thead' => array ( 'align' => true, 'char' => true, 'charoff' => true, 'valign' => true, 'title' => true, ),
		'title' => array ( 'title' => true, ),
		'tr' => array ( 'align' => true, 'bgcolor' => true, 'char' => true, 'charoff' => true, 'valign' => true, 'title' => true, ),
		'track' => array ( 'default' => true, 'kind' => true, 'label' => true, 'src' => true, 'srclang' => true, 'title' => true, ),
		'tt' => array ( 'title' => true, ),
		'u' => array ( 'title' => true, ),
		'ul' => array ( 'type' => true, 'title' => true, ),
		'ol' => array ( 'start' => true, 'type' => true, 'reversed' => true, 'title' => true, ),
		'var' => array ( 'title' => true, ),
		'img' => array ( 'alt' => true, 'align' => true, 'border' => true, 'height' => true, 'hspace' => true, 'longdesc' => true, 'vspace' => true, 'src' => true, 'width' => true, 'title' => true, )
	);

	// fields
	public $num_q = 4;     // initial no of questions / current no of questions, int
	public $num_a_pq = 4;  // initial answers per question, int

	function __construct() {
		add_shortcode('qm_new_quiz', array($this, 'shortcode')); // shortcode for the quiz
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts')); // has to be done *early*
	}

	// Handles the add quiz shortcode
	function shortcode( $atts ) {
		ob_start(); // should be in qm_buffer_start in init hook, but make sure
		$this->echo_quiz_form();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	// Removes upload mime types from wordpress
	function mod_upl_mimes($mimes) {
		$unset = array('exe', 'swf', 'tsv', 'wp|wpd', 'onetoc|onetoc2|onetmp|onepkg', 'class', 'htm|html', 'mdb', 'mpp');
		foreach ($unset as $val) {
			unset($mimes[$val]);
		}
		unset($val);
		return $mimes;
	}

	// Enqueue scripts (must be done early in init)
	function enqueue_scripts() {
		wp_register_script('quiz_form', plugins_url('js/qm-quiz-form.js', __FILE__ ));
		$tarr = array(
			'haspost'  => $_SERVER['REQUEST_METHOD'] === 'POST' ? 'true' : 'false',
			'minq'     => self::$min_q,
			'maxq'     => self::$max_q,
			'minapq'   => self::$min_a_pq,
			'maxapq'   => self::$max_a_pq,
			'f_numq'   => $this->num_q,
			'f_numapq' => $this->num_a_pq,
			'q_text_maxtextlen' => self::$q_text_maxtextlen,
			'q_sub_maxtextlen' => self::$q_sub_maxtextlen,
			'q_embed_maxtextlen' => self::$q_sub_maxtextlen,
			'q_a_text_maxtextlen' => self::$q_a_text_maxtextlen
		);
		wp_localize_script('quiz_form', 'qfdata', $tarr);
		wp_enqueue_script('jquery');
		wp_enqueue_script('quiz_form');
		$featured_image = get_option( 'qm_enable_featured_image', 'yes' );
		if ( $featured_image == 'yes' ) {
			if ( current_theme_supports( 'post-thumbnails' ) ) {
				wp_enqueue_script('plupload-all');
			}
		}
		remove_action( 'media_buttons', 'media_buttons' );
	}

	static private $lastunq = null;
	static public function getLabelUnqIDs() {
		$ret = null;
		if (!self::$lastunq) {
			self::$lastunq = uniqid();
			$ret = self::$lastunq;
		} else {
			$ret = self::$lastunq;
			self::$lastunq = null;
		}
		return $ret;
	}

	/**
	 * Add posting main form
	 */
	function echo_quiz_form() {
		if (!is_user_logged_in()) {
			printf( __( 'To create a quiz, you must be <a href="%s">logged in</a>. If you do not have a user account here, you can create one (or link an account through Facebook, Twitter, Google, etc. via the login page if the administrator has installed the relevant plugins.)', 'qm' ), wp_login_url( get_permalink() ) );			return;
		}
		$can_post = 'yes';
		$can_post_info = __('Unable to create quiz.','qm');
		add_filter('qm_can_post', $can_post);
		add_filter('qm_can_post_info', $can_post_info);
		if (!$can_post) {
			// forbidden from posting
			?><div class="info"><?=$can_post_info;?></div><?php
			return;
		}
		add_filter('upload_mimes', array($this, 'mod_upl_mimes'));

		$userdata = wp_get_current_user();
		$_POST = stripslashes_deep( $_POST );

		$featured_image = get_option( 'qm_enable_featured_image', 'yes' ) === 'yes';

		if ( isset( $_POST['qm_new_quiz_submit'] ) ) {
			$nonce = $_REQUEST['_wpnonce'];
			if ( !wp_verify_nonce( $nonce, 'qm-new-quiz' ) ) {
				wp_die( __( 'Cheating?' ) );
			}
			$this->submit_post();
		}
		$title = isset( $_POST['qm_quiz_title'] ) ? esc_attr( $_POST['qm_quiz_title'] ) : '';
		$description = isset( $_POST['qm_quiz_content'] ) ? $_POST['qm_quiz_content'] : '';

		if ( get_option( 'qm_allow_cats', 'yes' ) === 'yes' ) {
			if ( isset( $_POST['category'] ) ) {
				$maxcat = $this->max_cat('category');
				if ($maxcat >= 0) {
					$post_category = $maxcat;
				}
			}
		}
		?><div id="qm-quiz-area">
			<form id="qm-new-quiz-form" name="qm-new-quiz-form" action="" method="POST">
				<?php wp_nonce_field( 'qm-new-quiz' ) ?>
				<input type="hidden" id="qm-numq" name="qm-numq" value="<?=strval($this->num_q); ?>">
				<ul id="qm-quiz-form" class="qm-quiz-form">
					<?php do_action( 'qm_new_quiz_form_top' ); //plugin hook   ?>
					<li>
						<label for="new-quiz-title" title="Title for the quiz that describes it succinctly.">Quiz Title <span class="qm-req-indicator">*</span></label>
						<input class="required-field main-input" type="text" value="<?=$title; ?>" name="qm_quiz_title" id="new-quiz-title" minlength="2">
						<div class="clear"></div>
					</li>
					<?php if ( get_option( 'qm_allow_cats', 'yes' ) == 'yes' ) { ?>
						<li>
							<label for="category[]" title="Most relevant category for the quiz (depending on settings, it may be required to choose one other than 'Uncategorized').">Category <span class="qm-req-indicator">*</span></label>
							<?php qm_echo_cat_sels(isset($post_category) ? $post_category : null);?>
							<div class="clear"></div>
						</li>
					<?php } ?>
					<?php if ( $featured_image == 'yes' ) {
						?><li><?php
						if ( current_theme_supports( 'post-thumbnails' ) ) { ?>
							<label id="qm-ft-upload-label" for="qm-ft-upload-pickfiles" title="Descriptive image that appears before a user starts a quiz and is incorporated into social media share functionality."><?php _e( 'Featured Image', 'qm' ); ?></label>
							<span id="qm-ft-upload-container" class="main-input">
								<span id="qm-ft-upload-filelist">
									<?php
									$no_f_img = false;
									if (isset($_POST['qm_featured_img'])) {
										$feat_html = qm_feat_img_html($_POST['qm_featured_img']);
										if (isset($feat_html)) {
											echo $feat_html;
										} else {
											$no_f_img = true;
										}
									}
									?><input type="button" id="qm-ft-upload-pickfiles" class="qm-small-button" value="<?php _e( 'Upload Image', 'qm' ); ?>"<?=isset($_POST['qm_featured_img']) && !$no_f_img ?' style="display: none;"':''; ?> />
								</span>
							</span>
						<?php } else { ?>
							<span class="info"><?php _e( 'Your theme doesn\'t support featured image', 'qm' ) ?></span><div class="clear"></span>
						<?php } ?>
						<div class="clear"></div>
						</li>
					<?php } ?>

					<?php do_action( 'qm_new_quiz_form_description' ); ?>
					<li>
						<label for="new-quiz-desc" title="Text that appears before a user starts a quiz in order to explain it or provide background detail.">Quiz Text</label>
						<span class="main-input">
						<?php
						$editor = get_option( 'qm_editor_type', 'full' );
						if ( $editor == 'full' ) {
							?>
							<div class="qm-richtext">
								<?php wp_editor( $description, 'new-quiz-desc', array('textarea_name' => 'qm_quiz_content', 'editor_class' => 'new-quiz-desc richtext', 'teeny' => false, 'textarea_rows' => 8) ); ?>
							</div>
						<?php } else if ( $editor == 'rich' ) { ?>
							<div class="qm-richtext">
								<?php wp_editor( $description, 'new-quiz-desc', array('textarea_name' => 'qm_quiz_content', 'editor_class' => 'new-quiz-desc richtext', 'teeny' => true, 'media_buttons' => false, 'quicktags' => false, 'textarea_rows' => 8) ); ?>
							</div>
						<?php } else { ?>
							<textarea name="qm_quiz_content" class="qm_quiz_content" id="new-quiz-desc" cols="60" rows="8"><?=esc_textarea( $description ); ?></textarea>
						<?php } ?>
						</span>
						<div class="clear"></div>
					</li>
					<?php
					do_action( 'qm_new_quiz_form_after_description' );
					/*
					TODO: we don't support tags yet
					if ( get_option( 'qm_allow_tags', 'yes' ) === 'yes' ) {
						?>
						<li>
							<label for="new-quiz-tags" title="Space-delimited list of tags that apply to the quiz.">Tags</label>
							<input type="text" name="qm_quiz_tags" id="new-quiz-tags" class="new-quiz-tags main-input">
							<div class="clear"></div>
						</li>
						<?php
					}

					do_action( 'qm_new_quiz_form_tags');
					*/

					function outputAns($base, $aindex, $answer = null, $forcerightans = false) {
						$basea  = $base . '-a-' . $aindex;
						?><li class="qm-q-a-text-li" data-anum="<?=strval($aindex);?>">
							<label class="qm-q-a-text-lab" for="<?=QM_New_Quiz::getLabelUnqIDs();?>" title="The answer text.">
								Answer #<span class="qm-alab"><?=$aindex+1; ?></span> Text <span class="qm-req-indicator">*</span>
							</label>
							<input class="qm-q-a-formel main-input required-field" type="text" id="<?=QM_New_Quiz::getLabelUnqIDs();?>" data-fname="text" name="<?=$basea; ?>-text" maxlength="<?=strval(QM_New_Quiz::$q_a_text_maxtextlen);?>" value="<?=isset($answer) ? $answer['text'] : '';?>">&nbsp;<input type="radio" class="qm-q-formel required-field qm-q-rightans" data-fname="rightans" name="<?=$base;?>-rightans" value="<?=strval($aindex); ?>"<?php if ($forcerightans || (isset($answer) && $answer['rightans'])) echo ' checked'; ?>>
						</li><?php
					}

					// add quiz fields
					for ($i = 0; $i < $this->num_q; $i++) {
						//class should be qm-q-text
						$base  = 'qm-q-' . $i;
						$numa  = isset($_POST[$base.'-numa']) ? intval($_POST[$base.'-numa']) : $this->num_a_pq;
						$anuma = $numa;
						?>
						<li class="qm-q-li" data-qnum="<?=$i;?>">
							<h2 class="qm-q-head">Question #<span class="qm-qlab"><?=$i+1;?></span></h2>
							<div class="qm-q-ul-wrap">
								<ul class="qm-q-ul">
									<li class="qm-q-text-li">
										<label for="<?=self::getLabelUnqIDs();?>" title="The main text for this question.">
											Text <span class="qm-req-indicator">*</span>
										</label>
										<input id="<?=self::getLabelUnqIDs();?>" class="qm-q-formel required-field main-input" type="text" data-fname="text" name="<?=$base;?>-text" maxlength="<?=strval(self::$q_text_maxtextlen);?>" value="<?=isset($_POST[$base.'-text']) ? $_POST[$base.'-text'] : ''; ?>">
										<div class="clear"></div>
									</li>
									<li class="qm-q-sub-li">
										<label for="<?=self::getLabelUnqIDs();?>" title="The sub-text for this question that goes under the main text.">
											Sub-Text
										</label>
										<input type="text" id="<?=self::getLabelUnqIDs();?>" class="qm-q-formel main-input" data-fname="sub" name="<?=$base; ?>-sub" maxlength="<?=strval(self::$q_sub_maxtextlen);?>" value="<?=isset($_POST[$base.'-sub']) ? $_POST[$base.'-sub'] : ''; ?>">
										<div class="clear"></div>
									</li>
									<li class="qm-q-explan-li">
										<label for="<?=self::getLabelUnqIDs();?>" title="The explanation for the correct answer, displayed on the following page.">
											Explanation
										</label>
										<input type="text" id="<?=self::getLabelUnqIDs();?>" class="qm-q-formel main-input" data-fname="explan" name="<?=$base; ?>-explan" maxlength="<?=strval(self::$q_explan_maxtextlen);?>" value="<?=isset($_POST[$base.'-explan']) ? $_POST[$base.'-explan'] : ''; ?>">
										<div class="clear"></div>
									</li>
									<li class="qm-q-embed-li">
										<label for="<?=self::getLabelUnqIDs();?>" title="Any oEmbed-enabled link can go here. oEmbed-enabled sites include Imgur, YouTube, Tumblr, Twitter, Vine, Flickr and Vimeo, amongst others. Example: https://www.youtube.com/watch?v=FTQbiNvZqaY.">
											Embed
										</label>
										<input type="text" id="<?=self::getLabelUnqIDs();?>" class="qm-q-formel main-input" data-fname="embed" name="<?=$base; ?>-embed" maxlength="<?=strval(self::$q_embed_maxtextlen);?>" value="<?=isset($_POST[$base.'-embed']) ? $_POST[$base.'-embed'] : ''; ?>" placeholder="YouTube, Imgur, Vimeo URL, etc.">
										<div class="clear"></div>
									</li><?php
									?><li class="qm-q-a-li"><h3 class="qm-q-a-head">Answers</h3><div class="qm-q-a-ul-wrap"><ul class="qm-q-a-ul"><?php
										$answers = array();
										$rightans = null;
										$j = 0;
										for ($aindex = 0; $aindex < $numa; $aindex++) {
											$abasea = $base . '-a-' . $aindex;
											if (!isset($_POST[$abasea.'-text']) || empty(trim($_POST[$abasea.'-text']))) {
												continue;
											}
											$answer = &$answers[];
											$answer['index']    = $j++;
											$answer['aindex']   = $aindex;
											$answer['text']     = trim($_POST[$abasea.'-text']);
											$answer['rightans'] = isset($_POST[$base.'-rightans']) && $aindex === intval($_POST[$base.'-rightans']);
											if (!isset($rightans) && $answer['rightans']) $rightans = $answer;
										}
										$anuma = count($answers);
										if (!isset($rightans) && !empty($answers)) {
											$rightans = $answers[0];
											$rightans['rightans'] = true;
										}
										$rightansset = !empty($answers);
										for ($j = 0; $j < max(count($answers), $this->num_a_pq); $j++) {
											if ($j < count($answers)) {
												outputAns($base, $j, $answers[$j]);
												continue;
											}
											outputAns($base, $j, null, !$rightansset);
											$rightansset = true;
										}
										$anuma = $j;
									?></ul><!-- insert add answer button here.  --></div>
									</li>
								</ul>
							</div>
							<input type="hidden" class="qm-q-numa qm-q-formel" data-fname="numa" name="<?=$base; ?>-numa" value="<?=strval($anuma); ?>">
						</li><?php
					}
					?><!-- insert add question button here.  -->
					<li id="qm-submit-li">
						<input id="qm-submit" type="submit" name="qm_new_quiz_submit" value="Submit">
						<input type="hidden" name="qm_new_quiz_submit" value="yes" />
					</li>
					<?php do_action( 'qm_new_quiz_form_bottom' ); ?>
					</ul>
				</li>
			</form>
		</div><?php
	}

	// find the most child category, then work back from that. more reliable.
	function max_cat($postvar) {
		if (!isset($_POST[$postvar])) return array(1);
		if (!is_array($_POST[$postvar])) return array($_POST[$postvar]);
		if (empty($_POST[$postvar])) return array(1);
		for ($i = 0; $i < count($_POST[$postvar]); $i++) {
			if ($_POST[$postvar][$i] <= 0) {
				if ($i <= 0) return array(1);
				else         return array($_POST[$postvar][$i-1]);
			}
		}
		return array(intval(end($_POST[$postvar])));
	}

	/**
	 * Validate the post submit data
	 *
	 * @global type $userdata
	 */
	function submit_post() {
		$userdata = wp_get_current_user();
		$errors = array();

		// if there is a featured image, validate it (for security..)
		if ( isset($_FILES['qm_featured_img']) ) {
			$errors = qm_check_feat_img_upload();
		}

		$title = addslashes(trim(wp_strip_all_tags($_POST['qm_quiz_title'], true)));
		$content = addslashes(wp_kses($_POST['qm_quiz_content'], self::$allowed_desc_tags, array('http', 'https')));
		//$comments = $_POST['qm_comments_enabled'];

		/*
		$tags = '';
		if ( isset( $_POST['qm_quiz_tags'] ) ) {
			$tags = qm_clean_tags( $_POST['qm_quiz_tags'] );
		}
		*/

		//validate title
		if ( empty( $title ) ) $errors[] = __( 'Empty quiz title (required).', 'qm' );

		//validate cat
		if ( get_option( 'qm_allow_cats', 'yes' ) === 'yes' ) {
			if ( isset( $_POST['category'] ) ) {
				$maxcat = $this->max_cat('category');
				if ($maxcat >= 0) {
					$post_category = $maxcat;
				} else {
					$errors[] = __( 'No category selected (required).', 'qm' );
				}
			} else {
				$errors[] = __( 'No category selected (required).', 'qm' );
			}
		}

		if (!empty($content)) $content = trim($content);

		/*
		//process tags
		if ( !empty( $tags ) ) {
			$tags = explode( ',', $tags );
		}
		*/

		//post attachment
		$attach_id = isset( $_POST['qm_featured_img'] ) ? intval( $_POST['qm_featured_img'] ) : 0;

		$my_numq = $_POST['qm-numq'];
		if (!isset($my_numq) || !is_numeric($my_numq)) {
			wp_die(__('Fatal error: qm-numq hidden field not found or not number (stores number of questions added to form).', 'qm'));
			return;
		}
		$this->num_q = $my_numq;
		$questions = array();

		for ($i = 0; $i < $this->num_q; $i++) {
			$base = 'qm-q-'.$i;
			$qtext = isset($_POST[$base.'-text']) ? wp_strip_all_tags(trim($_POST[$base.'-text']), true) : null;
			//if (!isset($qtext) || empty($qtext)) continue;
			$questions[$i] = array();
			$questions[$i]['index']  = $i;
			$questions[$i]['text']   = $qtext;
			$questions[$i]['sub']    = isset($_POST[$base.'-sub'])    ? trim(wp_strip_all_tags($_POST[$base.'-sub'], true))    : null;
			$questions[$i]['explan'] = isset($_POST[$base.'-explan']) ? trim(wp_strip_all_tags($_POST[$base.'-explan'], true)) : null;
			$questions[$i]['embed']  = isset($_POST[$base.'-embed'])  ? trim(wp_strip_all_tags($_POST[$base.'-embed'], true))  : null;

			if (!isset($questions[$i]['text']) || strlen($questions[$i]['text']) < 0) {
				$errors[] = sprintf(__('Text for question %d is too short or does not exist.', 'qm'), $i+1);
			}
			if (isset($questions[$i]['text']) && strlen($questions[$i]['text']) > self::$q_text_maxtextlen) {
				$errors[] = sprintf(__('Text for question %d is too long. Ensure it has fewer than or equal to %d characters.', 'qm'), $i+1, $q_text_maxtextlen);
			}
			if (isset($questions[$i]['sub']) && strlen($questions[$i]['sub']) > self::$q_sub_maxtextlen) {
				$errors[] = sprintf(__('Sub-text for question %d is too long. Ensure it has fewer than or equal to %d characters.', 'qm'), $i+1, $q_sub_maxtextlen);
			}
			if (isset($questions[$i]['explan']) && strlen($questions[$i]['explan']) > self::$q_explan_maxtextlen) {
				$errors[] = sprintf(__('Explanation for question %d is too long. Ensure it has fewer than or equal to %d characters.', 'qm'), $i+1, $q_explan_maxtextlen);
			}
			if (isset($questions[$i]['embed']) && strlen($questions[$i]['embed']) > self::$q_embed_maxtextlen) {
				$errors[] = sprintf(__('Embed URL for question %d is too long. Ensure it has fewer than or equal to %d characters.', 'qm'), $i+1, $q_embed_maxtextlen);
			}
			// TODO: provide ajax tracking of oembed via ajax callback
			if (isset($questions[$i]['embed']) && !empty($questions[$i]['embed'])) {
				$embed_code = wp_oembed_get($questions[$i]['embed']);
				if (!$embed_code) {
					$errors[] = sprintf(__('Invalid embed URL for question %d.'), $i+1);
				}
			}
			//$questions[$currq]['sub'] = isset($_POST[$base.'-sub']) ? trim(strip_tags($_POST[$base.'-sub'])) : null;
			//echo '$_POST['.$base.'-rightans]: '.$_POST[$base.'-rightans'].'<br>';
			$rightans = isset($_POST[$base.'-rightans']) && is_numeric($_POST[$base.'-rightans']) ? intval($_POST[$base.'-rightans']) : null;
			$rightans = isset($rightans) && $rightans >= 0 && $rightans < 10 ? $rightans : null;
			$questions[$i]['rightans'] = $rightans;
			//echo '$questions['.$currq.'][rightans]: '.$questions[$currq]['rightans'].'<br>';
			if (!isset($questions[$i]['rightans'])) {
				$errors[] = sprintf(__( 'No correct answer selected for question %d (required).', 'qm' ), $i+1);
			}
			$numa = $_POST[$base.'-numa'];
			$numa = intval($numa);
			$aindex = 0;
			$questions[$i]['answers'] = array();
			for ($j = 0; $j < $numa; $j++) {
				$abase = $base.'-a-'.$j;
				$atext = isset($_POST[$abase.'-text']) ? wp_strip_all_tags(trim($_POST[$abase.'-text']), true) : null;
				if (!isset($atext) || empty($atext)) continue;
				$answer = &$questions[$i]['answers'][];
				$answer['index']  = $j;
				$answer['aindex'] = $aindex++;
				$answer['text']   = $atext;

				if (strlen($answer['text']) > self::$q_a_text_maxtextlen) {
					$errors[] = sprintf(__( 'Text for question %d, answer %d is too long. Ensure it has fewer than %d characters.', 'qm' ), $i+1, $j+1, self::$q_a_text_maxtextlen);
				}
				$answer['correct'] = isset($questions[$i]['rightans']) && $questions[$i]['rightans'] === $j;
				if ($answer['correct']) {
					$questions[$i]['rightans']  = $j; // set correct answer
					$questions[$i]['arightans'] = $aindex;
				}
			}
			//TODO: fill up to min amount if js hidden item detected in form submit
			if (!isset($questions[$i]['answers']) || count($questions[$i]['answers']) < self::$min_a_pq) {
				$errors[] = sprintf(__( 'Not enough answers for question %d (found %d). Questions must have at least %d answers (empty answers are removed autoatically). Answers filled back up to starting amount.', 'qm' ), $i+1, count($questions[$i]['answers']), self::$min_a_pq);
			} else if ($questions[$i]['answers'] && count($questions[$i]['answers']) > self::$max_a_pq) {
				$errors[] = sprintf(__( 'Too many answers for question %d (found %d). Questions must have less than or equal to %s answers.', 'qm' ), $i+1, count($questions[$i]['answers']), self::$max_a_pq);
			}
			if (isset($questions[$i]['rightans']) && (($questions[$i]['rightans'] < 0) || $questions[$i]['rightans'] >= count($questions[$i]['answers']))) {
				$errors[] = sprintf(__( 'Invalid answer selected for question %d: %d (may have blank text, will be removed automatically).', 'qm' ), $i+1, $questions[$i]['rightans']+1);
			}
		}
		if (!isset($questions) || count($questions) < self::$min_q) {
			$errors[] = sprintf(__( 'Too few questions in quiz (found %d). Quiz must have at least %d questions.', 'qm' ), count($questions), self::$min_q);
		} else if (isset($questions) && count($questions) > self::$max_q) {
			$errors[] = sprintf(__( 'Too many questions in quiz (found %d). Quiz must have less than or equal to %d questions.', 'qm' ), count($questions), self::$max_q);
		}
		$errors = apply_filters( 'qm_new_quiz_validation', $errors );

		// if errors, show them - otherwise continue to process the form
		if ($errors) {
			echo_qm_errors($errors);
			return;
		}
		$post_author = $userdata->ID;

		if (!isset($post_category)) {
			$post_category = get_option( 'qm_default_cat', 1);
		}

		$my_post = array(
			'post_title' => $title,
			'post_content' => $content,
			'post_status' => 'publish',
			'post_author' => $post_author,
			'post_category' => $post_category,
			'post_type' => 'quiz',
			//'tags_input' => $tags,
			'comment_status' => 'closed'
			//'comment_status' => $comments ? 'open' : 'closed'
		);

		// add filter to $my_post for extensibility
		$my_post = apply_filters( 'qm_new_quiz_args', $my_post );

		// insert the post
		$post_id = wp_insert_post( $my_post );

		if ( $post_id ) {
			//send mail notification
			if ( get_option( 'qm_post_notification', 'yes' ) === 'yes' ) {
				qm_notify_post_mail($post_id);
			}

			// delete old values
			$meta = get_post_custom_keys($post_id);
			foreach ($meta as $key) {
				if (substr($key, 0, strlen('_qm-q-')) === '_qm-q-') {
					delete_post_meta($post_id, $key);
				}
			}
			unset($key);
			$res = add_post_meta($post_id, "_qm-qnum", count($questions), true);
			for ($i = 0; $i < count($questions); $i++) {
				$base = '_qm-q-'.$i;
				$question = &$questions[$i];
				$res  = add_post_meta($post_id, $base.'-text', addslashes($question['text']), true);
				if (isset($question['sub']))    $res = add_post_meta($post_id, $base.'-sub',    addslashes($question['sub']),    true); // optional
				if (isset($question['explan'])) $res = add_post_meta($post_id, $base.'-explan', addslashes($question['explan']), true); // optional
				if (isset($question['embed']))  $res = add_post_meta($post_id, $base.'-embed',  addslashes($question['embed']),  true); // optional
				$res = add_post_meta($post_id, $base.'-anum',     count($question['answers']), true);
				$res = add_post_meta($post_id, $base.'-rightans', $question['rightans'],       true);

				for ($j = 0; $j < count($question['answers']); $j++) {
					$basea = $base.'-a-'.$j;
					$res = add_post_meta($post_id, $basea.'-text', addslashes($question['answers'][$j]['text']), true);
				}
			}

			//set post thumbnail if has any
			if ( $attach_id ) {
				set_post_thumbnail( $post_id, $attach_id );

				// update associatement
				wp_update_post(array(
					'ID' => $attach_id,
					'post_parent' => $post_id
				));
			}

			//plugin API to extend the functionality
			do_action( 'qm_new_quiz_after_insert', $post_id );

			//echo '<div class="success">' . __('Post published successfully', 'qm') . '</div>';
			if ( $post_id ) {
				$redirect = apply_filters( 'qm_after_post_redirect', get_permalink( $post_id ), $post_id );

				wp_redirect( $redirect );
				exit;
			}
		}
	}
}

$qm_new_quiz_form = new QM_New_Quiz();
