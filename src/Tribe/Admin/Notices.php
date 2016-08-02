<?php
// Don't load directly
defined( 'WPINC' ) or die;

/**
 * @since  4.3
 */
class Tribe__Admin__Notices {
	/**
	 * Static singleton variable
	 *
	 * @var self
	 */
	private static $instance;

	/**
	 * Static Singleton Factory Method
	 *
	 * @return self
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * User Meta Key that stores which notices have been dimissed
	 *
	 * @var string
	 */
	public static $meta_key = 'tribe-dismiss-notice';

	/**
	 * Stores all the Notices and it's configurations
	 *
	 * @var array
	 */
	private $notices = array();

	/**
	 * Register the Methods in the correct places
	 */
	private function __construct() {
		// Not in the admin we don't even care
		if ( ! is_admin() ) {
			return;
		}

		// Before we bail on the
		add_action( 'wp_ajax_tribe_notice_dismiss', array( $this, 'maybe_dismiss' ) );

		// Doing AJAX? bail.
		if ( Tribe__Main::instance()->doing_ajax() ) {
			return;
		}

		// Hook the actual rendering of notices
		add_action( 'current_screen', array( $this, 'hook' ), 20 );
	}

	/**
	 * This will happen on the `current_screen` and will hook to the correct actions and display the notices
	 *
	 * @return void
	 */
	public function hook() {
		foreach ( $this->notices as $notice ) {
			if ( $notice->dismiss && $this->has_user_dimissed( $notice->slug ) ) {
				continue;
			}

			add_action( $notice->action, $notice->callback, $notice->priority );
		}
	}

	/**
	 * This will allow the user to Dimiss the Notice using JS
	 *
	 * @return void
	 */
	public function maybe_dismiss() {
		if ( empty( $_GET[ self::$meta_key ] ) ) {
			wp_send_json( false );
		}

		$slug = sanitize_title_with_dashes( $_GET[ self::$meta_key ] );

		// We also don't care about it when it's not registred
		if ( ! $this->exists( $slug ) ) {
			wp_send_json( false );
		}

		// Send a JSON answer with the status of dimissal
		wp_send_json( $this->dismiss( $slug ) );
	}

	/**
	 * This is a helper to actually print the Message
	 *
	 * @param  string  $slug    The Name of the Notice
	 * @param  string  $content The content of the notice
	 * @param  boolean $return  Echo or return the content
	 *
	 * @return boolean|string
	 */
	public function render( $slug, $content = null, $return = false ) {
		if ( ! $this->exists( $slug ) ) {
			return false;
		}

		$notice = $this->get( $slug );

		$classes = array( 'tribe-dismiss-notice', 'notice' );
		$classes[] = sanitize_html_class( 'notice-' . $notice->type );
		$classes[] = sanitize_html_class( 'tribe-notice-' . $notice->slug );

		if ( $notice->dismiss ) {
			$classes[] = 'is-dismissible';
		}

		$html = sprintf( '<div class="%s" data-ref="%s">%s</div>', implode( ' ', $classes ), $notice->slug, $content );

		if ( ! $return ) {
			echo $html;
		}

		return $html;
	}

	/**
	 * Checks if a given user has dimissed a given notice.
	 *
	 * @param  string    $slug    The Name of the Notice
	 * @param  int|null  $user_id The user ID
	 *
	 * @return boolean
	 */
	public function has_user_dimissed( $slug, $user_id = null ) {
		if ( ! $this->exists( $slug ) ) {
			return false;
		}

		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$dismissed_notices = get_user_meta( $user_id, self::$meta_key );

		if ( ! is_array( $dismissed_notices ) ) {
			return false;
		}

		if ( ! in_array( $slug, $dismissed_notices ) ) {
			return false;
		}

		return true;
	}

	/**
	 * A Method to actually add the Meta value telling that this notice has been dismissed
	 *
	 * @param  string    $slug    The Name of the Notice
	 * @param  int|null  $user_id The user ID
	 *
	 * @return boolean
	 */
	public function dismiss( $slug, $user_id = null ) {
		if ( ! $this->exists( $slug ) ) {
			return false;
		}

		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		// If this user has dimissed we don't care either
		if ( $this->has_user_dimissed( $slug, $user_id ) ) {
			return true;
		}

		return add_user_meta( $user_id, self::$meta_key, $slug, false );
	}

	/**
	 * Removes the User meta holding if a notice was dimissed
	 *
	 * @param  string    $slug    The Name of the Notice
	 * @param  int|null  $user_id The user ID
	 *
	 * @return boolean
	 */
	public function undismiss( $slug, $user_id = null ) {
		if ( ! $this->exists( $slug ) ) {
			return false;
		}

		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		// If this user has dimissed we don't care either
		if ( ! $this->has_user_dimissed( $slug, $user_id ) ) {
			return false;
		}

		return delete_user_meta( $user_id, self::$meta_key, $slug );
	}

	/**
	 * Register a Notice and attach a callback to the required action to display it correctly
	 *
	 * @param  string   $slug      Slug to save the notice
	 * @param  callable $callback  A callable Method/Fuction to actually display the notice
	 * @param  array    $arguments Arguments to Setup a notice
	 *
	 * @return string
	 */
	public function register( $slug, $callback, $arguments = array() ) {
		// Prevent weird stuff here
		$slug = sanitize_title_with_dashes( $slug );

		$defaults = array(
			'callback' => $callback,
			'action'   => 'admin_notices',
			'priority' => 10,
			'expire'   => false,
			'dismiss'  => false,
			'type'     => 'error',
		);

		// Merge Arguments
		$notice = (object) wp_parse_args( $arguments, $defaults );

		// Enforce this one
		$notice->slug = $slug;

		// Clean these
		$notice->priority = absint( $notice->priority );
		$notice->expire = (bool) $notice->expire;
		$notice->dismiss = (bool) $notice->dismiss;

		// Set the Notice on the array of notices
		$this->notices[ $slug ] = $notice;

		// Return the Slug because it might be modified
		return $slug;
	}

	public function remove( $slug ) {
		if ( ! $this->exists( $slug ) ) {
			return false;
		}

		unset( $this->notices[ $slug ] );
		return true;
	}

	public function get( $slug = null ) {
		// Prevent weird stuff here
		$slug = sanitize_title_with_dashes( $slug );

		if ( is_null( $slug ) ) {
			return $this->notices;
		}

		if ( ! empty( $this->notices[ $slug ] ) ) {
			return $this->notices[ $slug ];
		}

		return null;
	}

	public function exists( $slug ) {
		return is_object( $this->get( $slug ) ) ? true : false;
	}
}
