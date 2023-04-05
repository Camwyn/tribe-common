<?php
namespace TEC\Common\Forms\Inputs;

/**
 * ABstract input class.
 */
abstract class Text extends Abstract_Input {
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
			type="text"
			id="<?php echo esc_attr( self::get_id() ); ?>"
			name="<?php echo esc_attr( self::get_name() ); ?>"
			value="<?php echo esc_attr( self::get_value() ); ?>"
			<?php echo esc_attr( self::get_id() ); ?>
			<?php /*  attributes are escaped in the get_attributes_string function */ ?>
			<?php echo self::get_attributes_string(); ?>
		>
		<?php
		return ob_get_clean();
	}
}
