<?php
namespace TEC\Common\Forms;

use TEC\Common\Forms\Inputs\Abstract_Input;

class InputFactory {

	protected $allowed_types = [
		// buttons
		'button'   => true,
		'submit'   => true,
		'reset'    => true,
		// date
		'date'     => true,
		'time'     => true,
		// text
		'text'     => true,
		'textarea' => true,
		'email'    => true,
		'tel'      => true,
		'url'      => true,
		'password' => true,
		// multi
		'checkbox' => true,
		'radio'    => true,
		'select'   => true,
		// numeric
		'number'   => true,
		// special
		'search'   => true,
		'file'     => true,
	];

	public static function createInput( string $type, string $name, $value = null, ?array $attributes = [] ): Abstract_Input {
		if ( ! isset( self::$allowed_types[ $type ] ) ) {
			throw new \InvalidArgumentException( $type . ' is not an allowed input type.' );
		}

		$class = 'TEC\\Common\\Forms\\Input\\' . $type;
		return new $class($name, $value, $attributes);
	}

		/**
	 * Create a new input object from a multidimensional array.
	 *
	 * @since TBD
	 *
	 * @param array<string,mixed> $array An array in the format
	 * [
	 *     'type' => '',
	 *     'name' => '',
	 *     'value' => '',
	 *     'attributes' => [],
	 * ]
	 *
	 * @return Abstract_Input
	 */
	public static function from_array( array $array ): Abstract_Input {
		// Bail if no type set.
		if ( ! isset( $args['type'] ) ) {
			throw new \InvalidArgumentException( 'Type property is required.');
		}

		// Bail if no name set.
		if ( ! isset( $args['name'] ) ) {
			throw new \InvalidArgumentException( 'Name property is required.');
		}

		// Ensure optional properties are set for passing.
		$args = wp_parse_args(
			$array,
			[
				'attributes' => [],
				'value'      => '',
			]
		);

		return self::createInput( $args['type'], $args['name'], $args['value'], $args['attributes'] );
	}

	/**
	 * Create a new input object from a json string.
	 *
	 * @since TBD
	 *
	 * @param string $json
	 *
	 * @return Abstract_Input
	 */
	public static function from_json( string $json ): Abstract_Input {
		$args = json_decode( $json, true );

		return self::from_array( $args );
	}
}
