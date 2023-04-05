<?php
namespace TEC\Common\Forms\Inputs\Components;

/**
 * Select input class.
 */
class Option {
	/**
	 * Returns the HTML string of a select option for rendering.
	 *
	 * @since TBD
	 *
	 * @return string
	 */
	public static function get_html( $args ): string {
		ob_start();
		?>
			<option value="<?php echo esc_attr( $args['value'] ); ?>" <?php selected( $args['value'], $args['parent']::get_value() ); ?>>
				<?php echo esc_html( $args['label'] ); ?>
			</option>
		<?php
		return ob_get_clean();
	}
}
