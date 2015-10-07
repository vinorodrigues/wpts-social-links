<?php
/*
 * Plugin Name: TS Social Links Widget
 * Plugin URI: http://tecsmith.com.au
 * Description: List your social links
 * Author: Vino Rodrigues
 * Version: 1.1.0
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

	public static function i($what, $size = 16, $style = '') {
		$o = '<img src="' . SOCIAL_LINKS_URL . '/img/' . ($size * 2) .
			'/' . $what . '.png" class="sl-' . $size;
		if ($style) $o .= ' ' . $style;
		$o .= ' sl-' . $what . '" />';
		return $o;
	}

	public static function l($url, $what, $size = 16, $style = '', $type = false) {
		$o = '<a href="'. $url . '" class="social-link sl-' . $what . '"';
		if ($type) $o .= ' type="' . $type . '"';
		$o .= '>' . self::i($what, $size, $style) . '</a>';
		echo $o;
	}

	function form($instance) {
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'size' => 32,
			'style' => '',
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
			'rss' => true,
			) );

		$title = esc_attr($instance['title']);
		$size = intval( esc_attr($instance['size']) );
		$style = esc_attr($instance['style']);
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
		$rss = (bool) esc_attr($instance['rss']);
		?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
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
		<label for="<?php echo $this->get_field_id( 'style' ); ?>"><?php _e( 'Icon Style', 'ts_social_links' ); ?>:</label>
		<select id="<?php echo $this->get_field_id( 'style' ); ?>" name="<?php echo $this->get_field_name( 'style' ); ?>">
			<option <?php if ($style == '') { echo 'selected="selected" '; } ?> value=""><?php _e( 'Square', 'ts_social_links' ); ?></option>
			<option <?php if ($style == 'sl-rounded') { echo 'selected="selected" '; } ?> value="sl-rounded"><?php _e( 'Rounded', 'ts_social_links' ); ?></option>
			<option <?php if ($style == 'sl-circle') { echo 'selected="selected" '; } ?> value="sl-circle"><?php _e( 'Circle', 'ts_social_links' ); ?></option>
		</select>
		</p>

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
		<label for="<?php echo $this->get_field_id( 'tumblr' ); ?>"><?= $this->i('tumblr', 16) ?> <?php _e( 'Tumblr xxxxx', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'tumblr' ); ?>" name="<?php echo $this->get_field_name( 'tumblr' ); ?>" type="text" value="<?php echo $tumblr; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?= $this->i('instagram', 16) ?> <?php _e( 'Instagram xxxxx', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo $instagram; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'github' ); ?>"><?= $this->i('github', 16) ?> <?php _e( 'Github xxxxx', 'ts_social_links' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" type="text" value="<?php echo $github; ?>" />
		</p>

		<p>
		<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?= $this->i('rss', 16) ?></label>
		<label for="<?php echo $this->get_field_id( 'rss' ); ?>"><?php _e( 'Show RSS link', 'ts_social_links' ); ?>:</label>
		<input id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" type="checkbox" value="1" <?php echo ($rss) ? 'checked="checked"' : ''; ?> />
		</p>

		<?php
	}

	function update($new_instance, $old_instance) {
		$instance =  $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['size'] = strip_tags( $new_instance['size'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
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
		$instance['rss'] = strip_tags( $new_instance['rss'] );

		return $instance;
	}

	function widget($args, $instance) {
		extract($args, EXTR_SKIP);

		echo @$before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$size = empty($instance['size']) ? 16 : intval( $instance['size'] );
		$style = empty($instance['style']) ? '' : $instance['style'];

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
		$rss = empty($instance['rss']) ? false : (bool) $instance['rss'];

		if (!empty($title))
			echo @$before_title . $title . @$after_title;

		?><div class="social-links"><?php

		if (!empty($youtube))
			self::l('http://youtube.com/user/' . $youtube, 'youtube', $size, $style);

		if (!empty($facebook))
			self::l('http://facebook.com/' . $facebook, 'facebook', $size, $style);

		if (!empty($twitter))
			self::l('http://twitter.com/#!/' . $twitter, 'twitter', $size, $style);

		if (!empty($linkedin))
			self::l('http://linkedin.com/' . $linkedwhat . '/' . $linkedin, 'linkedin', $size, $style);

		if (!empty($pinterest))
			self::l('http://pinterest.com/' . $pinterest, 'pinterest', $size, $style);

		if (!empty($google_plus))
			self::l('http://plus.google.com/' . $google_plus , 'google-plus', $size, $style);

		if (!empty($tumblr))
			self::l('http://' . $tumblr . '.tumblr.com/', 'tumblr', $size, $style);

		if (!empty($instagram))
			self::l('http://instagram.com/' .  $instagram, 'instagram', $size, $style);

		if (!empty($github))
			self::l('http://github.com/' . $github, 'github', $size, $style);

		if ($rss)
			self::l(get_bloginfo('rss2_url'), 'rss', $size, $style, 'application/rss+xml');

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
