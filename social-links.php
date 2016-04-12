<?php
/*
 * Plugin Name: TS Social Links Widget
 * Plugin URI: http://tecsmith.com.au
 * Description: List your social links
 * Author: Vino Rodrigues
 * Version: 1.1.1
 * Author URI: http://vinorodrigues.com
 *
 * @author Vino Rodrigues
 * @package TS-Social-Links
 * @since TS-Social-Links 0.9
**/


if (!defined('SOCIAL_LINKS_URL'))
	define( 'SOCIAL_LINKS_URL', str_replace( ' ', '%20', plugins_url( '', __FILE__ ) ) );

/**
 * Adds Social_Widget widget
 */
class TS_Social_Links_Widget extends WP_Widget {

	/** Register widget with WordPress. */
	public function __construct() {
		parent::__construct(
			'ts_social_links', // Base ID
			'TS Social Links', // Name
			array( 'description' => __( 'List your social links', 'ts_social_links' ), ) // Args
		);
	}

	public static function i($what, $size = 16, $shape = '') {
		$o = '<img src="' . SOCIAL_LINKS_URL . '/img/' . ($size * 2) .
			'/' . $what . '.png" class="sl-' . $what;
		$o .= ' sl-' . (($shape == '') ? 'square' : $shape);
		$o .= ' sl-' . $size;
		$o .= '">';
		return $o;
	}

	public static function f($what, $size = 16, $shape = '') {
		if ($what == 'email') $what = 'envelope-o';
		$o = '<i class="fa fa-' . $what;
		// if ($what != 'instagram') $o .= '-square';
		$o .= '"></i>';
		return $o;
	}

	public static function l($url, $what, $size = 16, $shape = '', $use_fa = false, $type = false, $rel = false) {

		// TODO REMOVE RAND
		// if (rand(1,2) != 1) $use_fa = !$use_fa;

		$o = '<a href="'. $url . '" class="';
		if ($use_fa) {
			$o .= 'btn btn-social';
			$o .= ' btn-' . $what;
			$o .= ' sl-' . (($shape == '') ? 'square' : $shape);
			$o .= ' sl-' . $size;
		} else {
			$o .= 'sl-img ';
		}
		$o .= ' sl-' . $what . '"';

		if ($type) $o .= ' type="' . $type . '"';  // application/rss+xml
		if ($rel) $o .= ' rel="' . $rel . '"';  // nofollow
		$o .= '>';

		if ($use_fa) {
			$o .= self::f($what, $size, $shape);
		} else {
			$o .= self::i($what, $size, $shape);
		}
		$o .= '</a>';
		echo $o;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'use_fa' => false,
			'size' => 32,
			'shape' => '',
			'youtube' => '',
			'facebook' => '',
			'twitter' => '',
			'linkedin' => '',
			'linkedwhat' => 'in',
			'pinterest' => '',
			'google_plus' => '',
			'tumblr' => '',
			'instagram' => '',
			'github' => '',
			'email' => '',
			'rss' => true,
			) );

		$title = esc_attr($instance['title']);
		$use_fa = esc_attr($instance['use_fa']);
		$size = intval( esc_attr($instance['size']) );
		$shape = esc_attr($instance['shape']);
		$youtube = esc_attr($instance['youtube']);
		$facebook = esc_attr($instance['facebook']);
		$twitter = esc_attr($instance['twitter']);
		$linkedwhat = esc_attr($instance['linkedwhat']);
		$linkedin = esc_attr($instance['linkedin']);
		$pinterest = esc_attr($instance['pinterest']);
		$google_plus = esc_attr($instance['google_plus']);
		$tumblr = esc_attr($instance['tumblr']);
		$instagram = esc_attr($instance['instagram']);
		$github = esc_attr($instance['github']);
		$email = esc_attr($instance['email']);
		$rss = (bool) esc_attr($instance['rss']);
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'ts_social_links' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
		<input id="<?php echo $this->get_field_id( 'use_fa' ); ?>" name="<?php echo $this->get_field_name( 'use_fa' ); ?>" type="checkbox" value="1" <?php echo ($use_fa) ? 'checked="checked"' : ''; ?> />
		<label for="<?php echo $this->get_field_id( 'use_fa' ); ?>"><?php _e( 'Use Font-Awesome if available', 'ts_social_links' ); ?></label>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Icon Size', 'ts_social_links' ); ?>:</label>
		<select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
			<option <?php if ($size == 16) { echo 'selected="selected" '; } ?> value="16"><?php _e( '16x16', 'ts_social_links' ); ?></option>
			<option <?php if ($size == 24) { echo 'selected="selected" '; } ?> value="24"><?php _e( '24x24', 'ts_social_links' ); ?></option>
			<option <?php if ($size == 32) { echo 'selected="selected" '; } ?> value="32"><?php _e( '32x32', 'ts_social_links' ); ?></option>
			<option <?php if ($size == 48) { echo 'selected="selected" '; } ?> value="48"><?php _e( '48x48', 'ts_social_links' ); ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'shape' ); ?>"><?php _e( 'Icon shape', 'ts_social_links' ); ?>:</label>
		<select id="<?php echo $this->get_field_id( 'shape' ); ?>" name="<?php echo $this->get_field_name( 'shape' ); ?>">
			<option <?php if ($shape == '') { echo 'selected="selected" '; } ?> value=""><?php _e( 'Square', 'ts_social_links' ); ?></option>
			<option <?php if ($shape == 'rounded') { echo 'selected="selected" '; } ?> value="rounded"><?php _e( 'Rounded', 'ts_social_links' ); ?></option>
			<option <?php if ($shape == 'circle') { echo 'selected="selected" '; } ?> value="circle"><?php _e( 'Circle', 'ts_social_links' ); ?></option>
		</select>
		</p>

		<fieldset class="social-links">

		<p>
		<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?= $this->i('youtube', 16) ?> <?php _e( 'YouTube username', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo $youtube; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?= $this->i('facebook', 16) ?> <?php _e( 'Facebook page', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo $facebook; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?= $this->i('twitter', 16) ?> <?php _e( 'Twitter username', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo $twitter; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'linkedwhat' ); ?>"><?= $this->i('linkedin', 16) ?> <?php _e( 'LinkedIn', 'ts_social_links' ); ?></label>
		<select id="<?php echo $this->get_field_id( 'linkedwhat' ); ?>" name="<?php echo $this->get_field_name( 'linkedwhat' ); ?>">
			<option <?php if ($linkedwhat == 'in') { echo 'selected="selected" '; } ?> value="in"><?php _e( 'Profile', 'ts_social_links' ); ?></option>
			<option <?php if ($linkedwhat == 'company') { echo 'selected="selected" '; } ?> value="company"><?php _e( 'Company', 'ts_social_links' ); ?></option>
			<option <?php if ($linkedwhat == 'groups') { echo 'selected="selected" '; } ?> value="groups"><?php _e( 'Group', 'ts_social_links' ); ?></option>
		</select>
		<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>">:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" type="text" value="<?php echo $linkedin; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?= $this->i('pinterest', 16) ?> <?php _e( 'Pinterest account', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" type="text" value="<?php echo $pinterest; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'google_plus' ); ?>"><?= $this->i('google-plus', 16) ?> <?php _e( 'Google+ page', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'google_plus' ); ?>" name="<?php echo $this->get_field_name( 'google_plus' ); ?>" type="text" value="<?php echo $google_plus; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'tumblr' ); ?>"><?= $this->i('tumblr', 16) ?> <?php _e( 'Tumblr account', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" type="text" value="<?php echo $tumblr; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?= $this->i('instagram', 16) ?> <?php _e( 'Instagram account', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo $instagram; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'github' ); ?>"><?= $this->i('github', 16) ?> <?php _e( 'Github username', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" type="text" value="<?php echo $github; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?= $this->i('email', 16) ?> <?php _e( 'Email link', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" value="<?php echo $email; ?>" placeholder="mailto:user@domain.com" />
		<small><?php _e('Use a fully qualified URL here.  May be a "mailto:" link or a URL to an external form.', 'ts_social_links' ); ?></small>
		</p>

		<p>
		<input id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" type="checkbox" value="1" <?php echo ($rss) ? 'checked="checked"' : ''; ?> />
		<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php printf( __( 'Show %s RSS link', 'ts_social_links' ), $this->i('rss', 16) ); ?></label>
		</p>

		</fieldset>

		<?php
	}

	function update($new_instance, $old_instance) {
		$instance =  $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['use_fa'] = strip_tags( $new_instance['use_fa'] );
		$instance['size'] = strip_tags( $new_instance['size'] );
		$instance['shape'] = strip_tags( $new_instance['shape'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['linkedwhat'] = strip_tags( $new_instance['linkedwhat'] );
		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
		$instance['google_plus'] = strip_tags( $new_instance['google_plus'] );
		$instance['tumblr'] = strip_tags( $new_instance['tumblr'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );
		$instance['github'] = strip_tags( $new_instance['github'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['rss'] = strip_tags( $new_instance['rss'] );

		return $instance;
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo @$before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$use_fa = empty($instance['use_fa']) ? false : (bool) $instance['use_fa'];
		if ($use_fa)
			$use_fa = wp_style_is('font-awesome', 'registered');
		if ($use_fa && !wp_style_is('font-awesome', 'enqueued'))
			wp_enqueue_style('font-awesome');

		$size = empty($instance['size']) ? 16 : intval( $instance['size'] );
		$shape = empty($instance['shape']) ? '' : $instance['shape'];

		$youtube = empty($instance['youtube']) ? '' : $instance['youtube'];
		$facebook = empty($instance['facebook']) ? '' : $instance['facebook'];
		$twitter = empty($instance['twitter']) ? '' : $instance['twitter'];
		$linkedwhat = empty($instance['linkedin']) ? '' : $instance['linkedwhat'];
		$linkedin = empty($instance['linkedin']) ? '' : $instance['linkedin'];
		$pinterest = empty($instance['pinterest']) ? '' : $instance['pinterest'];
		$google_plus = empty($instance['google_plus']) ? '' : $instance['google_plus'];
		$tumblr = empty($instance['tumblr']) ? '' : $instance['tumblr'];
		$instagram = empty($instance['instagram']) ? '' : $instance['instagram'];
		$github = empty($instance['github']) ? '' : $instance['github'];
		$email = empty($instance['email']) ? '' : $instance['email'];
		$rss = empty($instance['rss']) ? false : (bool) $instance['rss'];

		if (!empty($title))
			echo @$before_title . $title . @$after_title;

		?><div class="social-links <?= 'sl-c-'.$size ?>"><?php

		if (!empty($youtube))
			self::l('http://youtube.com/user/' . $youtube, 'youtube', $size, $shape, $use_fa);

		if (!empty($facebook))
			self::l('http://facebook.com/' . $facebook, 'facebook', $size, $shape, $use_fa);

		if (!empty($twitter))
			self::l('http://twitter.com/#!/' . $twitter, 'twitter', $size, $shape, $use_fa);

		if (!empty($linkedin))
			self::l('http://linkedin.com/' . $linkedwhat . '/' . $linkedin, 'linkedin', $size, $shape, $use_fa);

		if (!empty($pinterest))
			self::l('http://pinterest.com/' . $pinterest, 'pinterest', $size, $shape, $use_fa);

		if (!empty($google_plus))
			self::l('http://plus.google.com/' . $google_plus , 'google-plus', $size, $shape, $use_fa);

		if (!empty($tumblr))
			self::l('http://' . $tumblr . '.tumblr.com/', 'tumblr', $size, $shape, $use_fa);

		if (!empty($instagram))
			self::l('http://instagram.com/' .  $instagram, 'instagram', $size, $shape, $use_fa);

		if (!empty($github))
			self::l('http://github.com/' . $github, 'github', $size, $shape, $use_fa);

		if (!empty($email))
			self::l($email, 'email', $size, $shape, $use_fa, false, 'nofollow');

		if ($rss)
			self::l(get_bloginfo('rss2_url'), 'rss', $size, $shape, $use_fa, 'application/rss+xml');

		?></div><?php

		echo @$after_widget;
	}

}  // class TS_Social_Links_Widget


/**
 *
 */
function ts_social_links_widgets_init() {
	load_plugin_textdomain( 'ts_social_links', false, plugin_dir_path( __FILE__ ) . 'lang/' );
	return register_widget( "TS_Social_Links_Widget" );
}
add_action( 'widgets_init', 'ts_social_links_widgets_init' );


/**
 *
 */
if ( ! function_exists('ts_social_links_wp_head') ) :
function ts_social_links_wp_head() {
	wp_enqueue_style( 'ts-social-links', SOCIAL_LINKS_URL . '/css/social-links.css' );
}
endif;
add_action( 'wp_enqueue_scripts', 'ts_social_links_wp_head' );
add_action( 'admin_enqueue_scripts', 'ts_social_links_wp_head' );
