<?php
/**
 * QuizMeister. Developed by Chris Dennett (dessimat0r@gmail.com)
 * Donate by PayPal to dessimat0r@gmail.com.
 * Bitcoin: 1JrHT9F96GjHYHHNFmBN2oRt79DDk5kzHq
 */

class QM_Settings {
	private $sections = array();
	private $fields = array();

	public function __construct() {
		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
		add_action('admin_init', array($this, 'admin_init'));
		add_action('admin_menu', array($this, 'admin_menu'));
	}

	function admin_enqueue_scripts() {
		wp_enqueue_style('admin_style', plugins_url('/css/admin.css', __FILE__));
		wp_enqueue_script('jquery');
	}

	function plugin_page() {
		$plugin_data = get_plugin_data(dirname(dirname(__FILE__)).'/qm.php');
		$plugin_ver = $plugin_data['Version'];
		?>
		<div class="wrap">
			<h2 id="qm-admin-title">QuizMeister Settings</h2>
			<div id="qm-admin-support">
				<p><strong>QuizMeister <?=$plugin_ver;?></strong>, the number 1 solution to allow users to create their own quizzes on your Wordpress install without providing unsecure and unrestricted access and providing social network share support (Twitter, Facebook, etc.) with external media support (Imgur, Pintrest, YouTube, Vimeo, etc.) through oEmbed. For external/social login support (Google, Facebook, etc) we suggest installing the <a href="https://wordpress.org/plugins/wp-oauth/">WP-OAuth</a> plugin.</p><p>For support,
				e-mail <a href="mailto:dessimat0r@gmail.com">dessimat0r@gmail.com</a>.</p>
			</div>
			<div id="qm-donate">
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="padding-bottom: 50px; float: left;">
				<input type="hidden" name="cmd" value="_s-xclick" />
				<input type="hidden" name="hosted_button_id" value="KXNX6FPVJ7KGG" />
				<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate" />
				<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
				</form>
				Any donations are graciously recieved via the PayPal button to the left and go to the author, who has poured a lot of work into the development of this plugin and needs to stay alive ;) Thanks in advance :)<br />Bitcoin: 1JrHT9F96GjHYHHNFmBN2oRt79DDk5kzHq.
			</div>
			<?=settings_errors();?>
			<div class="clear"></div>
			<?=$this->output_page();?>
		</div>
		<?php
	}

	function admin_init() {
		$gallery_cleanup_next_run = wp_next_scheduled('qm_evt_cron_gallery_cleanup', array(true));
		$this->sections = apply_filters('qm_settings_sections', array(
			'qm_quiz' => array(
				'id' => 'qm_quiz',
				'title' => __('Quiz Display', 'qm'),
				'fields' => array(
					'qm_twitter_data_rel' => array(
						'name' => 'qm_twitter_data_rel',
						'label' => __('Twitter data-related' , 'qm'),
						'desc' => __('If specified, related Twitter accounts associated with share tweets (see Twitter API docs)', 'qm'),
						'type' => 'text',
						'default' => ''
					),
					'qm_facebook_app_id' => array(
						'name' => 'qm_facebook_app_id',
						'label' => __('Facebook App ID', 'qm'),
						'desc' => __('If specified, allows for sharing of quiz to Facebook. Get this from your Facebook app settings after setting up the API stuff', 'qm'),
						'type' => 'text',
						'default' => ''
					)
				)
			),
			'qm_posting' => array(
				'id' => 'qm_posting',
				'title' => __('Quiz Posting', 'qm'),
				'fields' => array(
					'qm_allow_cats' => array(
						'name' => 'qm_allow_cats',
						'label' => __('Allow category choice?', 'qm'),
						'desc' => __('If selected, users will be able to choose a category during quiz creation (otherwise the default category is used)', 'qm'),
						'type' => 'checkbox',
						'default' => 'yes'
					),
					'qm_exclude_cats' => array(
						'name' => 'qm_exclude_cats',
						'label' => __('Exclude category IDs', 'qm'),
						'desc' => __('Exclude certain categories from the dropdown (comma-delimited)', 'qm'),
						'type' => 'text'
					),
					'qm_default_cat' => array(
						'name' => 'qm_default_cat',
						'label' => __('Default post category', 'qm'),
						'desc' => __('If users are not allowed to choose a category, this category will be used instead. Also selects this category by default in the category selector', 'qm'),
						'type' => 'select',
						'default' => 1,
						'options' => qm_get_cats()
					),
					'qm_cat_type' => array(
						'name' => 'qm_cat_type',
						'label' => __('Category selector style', 'qm'),
						'type' => 'radio',
						'options' => array(
							'standard' => __('Standard', 'qm'),
							'dynamic' => __('Dynamic', 'qm')
						),
						'default' => 'dynamic'
					),
					'qm_enable_featured_image' => array(
						'name' => 'qm_enable_featured_image',
						'label' => __('Enable Featured Image upload?', 'qm'),
						'desc' => __('If selected, allows the user to upload a featured image during quiz creation', 'qm'),
						'type' => 'checkbox',
						'default' => 'yes'
					),
					'qm_editor_type' => array(
						'name' => 'qm_editor_type',
						'label' => __('Content editor type', 'qm'),
						'type' => 'select',
						'options' => array(
							'plain' => __('Plain', 'qm'),
							'rich' => __('Rich', 'qm'),
							'full' => __('Full', 'qm')
						),
						'default' => 'full'
					),
					/*
					array(
						'name' => 'allow_tags',
						'label' => __('Allow post tags?', 'qm'),
						'desc' => __('If selected, allows users to add tags during quiz creation', 'qm'),
						'type' => 'checkbox',
						'default' => 'yes'
					),
					*/
					'qm_use_theme_quiz_template' => array(
						'name' => 'qm_use_theme_quiz_template',
						'label' => __('Use theme quiz template?', 'qm'),
						'desc' => __('If selected, disables the built-in quiz template that is most compatible with TwentyFifteen so that you can define your own in a theme (hint: copy out the \'templates\' directory in the plugin directory into \'themes\' and correct the URL look-ups)', 'qm'),
						'type' => 'checkbox',
						'default' => 'no'
					)
				)
			),
			'qm_misc' => array(
				'id' => 'qm_misc',
				'title' => __('Miscellaneous', 'qm'),
				'desc' =>
					'<p><strong>Shortcodes to use on pages:</strong> <code>[qm_new_quiz]</code>: new quiz page shortcode.</p>'.
					'<p>Note that if you don\'t see a page in the listboxes after creating it and putting the shortcode on there, check on the Text tab of the input field of the page content editor for extraneous HTML tags that may be embedded inside the shortcode. Shortcode arguments are permitted but should be ignored during this lookup.</p>'.
					'<p><a href="'.plugins_url('gcronfix.php', __FILE__).'">Click here to run immediately and fix the gallery cleanup wp-cron job</a> (make sure to save the form first).</p>'
				,
				'fields' => array(
					'qm_post_notification' => array(
						'name' => 'qm_post_notification',
						'label' => __('New quiz notification?', 'qm'),
						'desc' => __('If selected, a mail will be sent to the admin when a new quiz is created', 'qm'),
						'type' => 'checkbox',
						'default' => 'yes'
					),
					'qm_new_quiz_page_id' => array(
						'name' => 'qm_new_quiz_page_id',
						'label' => __('\'New Quiz\' page', 'qm'),
						'desc' => __('Select the default page where <code>[qm_new_quiz]</code> is located', 'qm'),
						'type' => 'select',
						'options' => qm_get_pages('qm_new_quiz')
					),
					'qm_gallery_cleanup_mins' => array(
						'name' => 'qm_gallery_cleanup_mins',
						'label' => __('Gallery clean-up frequency', 'qm'),
						'desc' => __('How often (in minutes) to clean up orphaned gallery images from quiz posts in media uploads (set to 0 to disable). ', 'qm').get_option('qm_purged_gallery_orphans_count',0). ' orphan(s) cleaned so far. '.($gallery_cleanup_next_run !== false ? ('Running again in ' . intval(max(0, $gallery_cleanup_next_run - time())/60,10) . ' mins'):'Not currently scheduled.'),
						'type' => 'text',
						'default' => strval(30*60), // 30 minutes
						'sanitize_callback' => 'intval'
					)
				)
			)
		));
		// register sections
		foreach ($this->sections as $section) {
			add_settings_section(
				$section['id'], $section['title'],
				array($this, 'section_callback'), $section['id']
			);
			foreach ($section['fields'] as $field) {
				$type = isset($field['type']) ? $field['type'] : 'text';
				$args = array(
					'id' => $field['name'],
					'name' => $field['label'],
					'section' => $section['id'],
					'desc' => isset($field['desc']) ? $field['desc'] : '',
					'size' => isset($field['size']) ? $field['size'] : null,
					'options' => isset($field['options']) ? $field['options'] : '',
					'std' => isset($field['default']) ? $field['default'] : ''
				);
				add_settings_field($field['name'], $field['label'], array($this, 'setfield_' . $type), $section['id'], $section['id'], $args);
				$sanitize_callback = null;
				if (isset($field['sanitize_callback'])) $sanitize_callback = $field['sanitize_callback'];
				// TODO: chain this call?
				else if ($type === 'text' || $type === 'textfield') $sanitize_callback = 'sanitize_text_field';
				if (isset($sanitize_callback)) register_setting($section['id'], $field['name'], $sanitize_callback);
				else register_setting($section['id'], $field['name']);
			}
		}
	}

	function admin_menu() {
		add_menu_page(
			__('QuizMeister', 'qm'),
			__('QuizMeister', 'qm'),
			'activate_plugins', 'qm', array($this, 'plugin_page'), 'dashicons-editor-help'
		);
	}

	/**
	 * Displays text field for settings field
	 * @param array $args settings field args
	 */
	function setfield_text($args) {
		$value = esc_attr(get_option($args['id'], $args['std']));
		$size = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';

		$html = sprintf('<input type="text" class="%1$s-text" id="%2$s" name="%2$s" value="%3$s"/>', $size, $args['id'], $value);
		$html .= sprintf('<span class="description">%s</span>', $args['desc']);

		echo $html;
	}

	/**
	 * Displays checkbox for settings field
	 * @param array $args settings field args
	 */
	function setfield_checkbox($args) {
		$value = get_option($args['id'], $args['std']);

		$html = sprintf('<input type="hidden" name="%1$s" value="no" />', $args['id']);
		$html .= sprintf('<input type="checkbox" class="checkbox" id="%1$s" name="%1$s" value="yes"%2$s />', $args['id'], checked($value, 'yes', false));
		$html .= sprintf('<span class="description">%s</span>', $args['desc']);

		echo $html;
	}

	/**
	 * Displays multi-checkbox for settings field
	 * @param array $args settings field args
	 */
	function setfield_multicheck($args) {
		$value = get_option($args['id'], $args['std']);

		$html = '';
		foreach ($args['options'] as $key => $label) {
			$checked = isset($value[$key]) ? $value[$key] : '0';
			$html .= sprintf('<input type="checkbox" class="checkbox" id="%1$s[%2$s]" name="%1$s[%2$s]" value="%2$s"%3$s />', $args['id'], $key, checked($checked, $key, false));
			$html .= sprintf('<label for="%1$s[%3$s]">%2$s</label><br>', $args['section'], $args['id'], $label, $key);
		}
		$html .= sprintf('<span class="description">%s</span>', $args['desc']);

		echo $html;
	}

	/**
	 * Displays a multi-checkbox for settings field
	 * @param array $args settings field args
	 */
	function setfield_radio($args) {
		$value = get_option($args['id'], $args['std']);

		$html = '';
		foreach ($args['options'] as $key => $label) {
			$html .= sprintf('<input type="radio" class="radio" id="%1$s[%2$s]" name="%1$s" value="%2$s"%3$s />', $args['id'], $key, checked($value, $key, false));
			$html .= sprintf('<label for="%1$s[%3$s]">%2$s</label><br>', $args['id'], $label, $key);
		}
		$html .= sprintf('<span class="description">%s</span>', $args['desc']);

		echo $html;
	}

	/**
	 * Displays select dropdown for settings field
	 * @param array $args settings field args
	 */
	function setfield_select($args) {
		$value = esc_attr(get_option($args['id'], $args['std']));
		$size = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';

		$html = sprintf('<select class="%1$s" name="%2$s" id="%2$s">', $size, $args['id']);
		$found_sel = null;
		foreach ($args['options'] as $key => $label) {
			if ($value == $key) {
				$found_sel = $key;
				break;
			}
		}
		if (!$found_sel) $html .= '<option disabled selected value> -- select page -- </option>';
		foreach ($args['options'] as $key => $label) {
			$html .= sprintf('<option value="%1$s"%2$s>%3$s</option>', $key, isset($found_sel) ? selected($value, $key, false) : '', $label);
		}
		$html .= sprintf('</select>');
		$html .= sprintf('<span class="description">%s</span>', $args['desc']);

		echo $html;
	}

	/**
	 * Displays textarea for settings field
	 * @param array $args settings field args
	 */
	function setfield_textarea($args) {
		$value = esc_textarea(get_option($args['id'], $args['std']));
		$size = isset($args['size']) && !is_null($args['size']) ? $args['size'] : 'regular';

		$html = sprintf('<textarea rows="5" cols="55" class="%1$s-text" id="%2$s" name="%2$s">%3$s</textarea>', $size, $args['id'], $value);
		$html .= sprintf('<br><span class="description">%s</span>', $args['desc']);

		echo $html;
	}

	// outputs the page
	function output_page() {
		foreach ($this->sections as $section) {
			$this->output_section_form($section);
		}
		unset($section);
	}

	/**
	 * Outputs a section form
	 * @param string $section the section id
	 */
	function output_section_form($section) {
		?><div id="qm-setsec-<?php echo $section['id']; ?>" class="qm-setsec">
			<form method="POST" action="options.php"><?php
				settings_fields($section['id']);
				do_settings_sections($section['id']);
				submit_button();
			?></form>
		</div><?php
	}

	function section_callback($arg) {
		if (isset($this->sections[$arg['id']]['desc'])) {
			?><?=$this->sections[$arg['id']]['desc'];?><?php
		}
	}
}

$qm_settings = new QM_Settings();
