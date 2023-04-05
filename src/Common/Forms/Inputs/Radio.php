<?php
namespace TEC\Common\Forms\Inputs;

/**
 * Radio input class.
 */
class Radio extends Abstract_Input {
	/**
	 * Returns the HTML string of the input for rendering.
	 *
	 * @since TBD
	 *
	 * @return string
	 */
	static public function get_html(): string {
		ob_start();
		?>
		<input
			type="radio"
			id="<?php echo esc_attr( self::get_id() ); ?>"
			name="<?php echo esc_attr( self::get_name() ); ?>"
			value="<?php echo esc_attr( self::get_value() ); ?>"
			<?php echo esc_attr( self::get_id() ); ?>
			<?php /*  attributes are escaped in the get_attributes_string function */ ?>
			<?php echo self::get_attributes_string(); ?>
			<?php echo self::is_checked() ? ' checked="checked"' : ''; ?>
		>
		<?php
		return ob_get_clean();
	}

	/**
	 * Checks if the radio input should be checked.
	 *
	 * @since TBD
	 *
	 * @return bool
	 */
	protected function is_checked(): bool {
		$value = self::get_value();
		$parent_value = self::get_parent_value();
		if ( is_array( $parent_value ) && in_array( $value, $parent_value ) ) {
			return true;
		}
		return $value == $parent_value;
	}
}
