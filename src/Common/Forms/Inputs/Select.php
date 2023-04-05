<?php
namespace TEC\Common\Forms\Inputs;

use TEC\Common\Forms\Inputs\Components\Option as Option;

/**
 * Select input class.
 */
class Select extends Abstract_Input {
	/**
	 * @var array $options An array of options for the select element. Each option should be an array with keys 'value' and 'label'.
	 */
	protected $options;

	/**
	 * Constructor.
	 *
	 * @param string $name The name of the input.
	 * @param mixed $value The value of the input.
	 * @param array $attributes An array of attributes for the input element.
	 */
	public function __construct( string $name, $value = null, ?array $attributes = [] ) {
		parent::__construct( $name, $value, $attributes );
		$this->options =$attributes['$options'];
	}

	/**
	 * Returns the HTML string of the input for rendering.
	 *
	 * @since TBD
	 *
	 * @return string
	 */
	public static function get_html(): string {
		ob_start();
		?>
		<select
			id="<?php echo esc_attr( static::get_id() ); ?>"
			name="<?php echo esc_attr( static::get_name() ); ?>"
			<?php echo static::get_attributes_string(); ?>
		>
			<?php
			foreach ( static::$options as $option ) {
				$args = [
					'value'        => $option['value'],
					'label'        => $option['label'],
					'parent_value' => static::get_value()
				];

				echo Option::get_html( $args );
			}
			?>
		</select>
		<?php
		return ob_get_clean();
	}
}
