<?php
namespace TEC\Common\Forms\Inputs;

/**
 * ABstract input class.
 */
abstract class Abstract_Input {
    protected $type;
	protected $name;
    protected $value;
	protected $label;
    protected $attributes = [];
	protected $allowed_attributes = [
		'accept',
		'alt',
		'autocomplete',
		'autofocus',
		'checked',
		'disabled',
		'form',
		'formaction',
		'formenctype',
		'formmethod',
		'formnovalidate',
		'formtarget',
		'height',
		'id',
		'list',
		'max',
		'maxlength',
		'min',
		'multiple',
		'name',
		'pattern',
		'placeholder',
		'readonly',
		'required',
		'size',
		'src',
		'step',
		'type',
		'value',
		'width',
	];

	/**
	 * Constructor
	 *
	 * @since TBD
	 *
	 * @param string     $type                      The string representation of input type.
	 * @param string     $name                      The string name of the input.
	 *                                                  Will also be used as ID if not set in $attributes.
	 * @param mixed      $value                     The input value.
	 * @param array<string,string>|null $attributes The input attributes in the format [ (lowercase) 'attribute' => 'value' ].
	 *
	 */
    public function __construct( string $name, $value = null, ?array $attributes = [] ) {
		if ( isset( $attributes['label'] ) ) {
			$this->label = $attributes['label'];
			unset( $attributes['label'] );
		}

        $this->attributes = $attributes;
        $this->name       = $name;
        $this->value      = $value;
    }

	/**
	 * Returns the input type attribute.
	 *
	 * @since TBD
	 *
	 * @return string
	 */
    public static function get_type(): string {
        return static::$type;
    }

	/**
	 * Returns the input id attribute.
	 *
	 * @since TBD
	 *
	 * @return string
	 */
    public static function get_id(): string {
		if ( isset( static::$attributes['id'] ) ) {
			return static::$attributes['id'];
		}
        return static::$attributes['name'];
    }

	/**
	 * Returns the input name attribute.
	 *
	 * @since TBD
	 *
	 * @return string
	 */
    public static function get_name(): string {
        return static::$name;
    }

	/**
	 * Returns the input;s value.
	 *
	 * @since TBD
	 *
	 * @return void
	 */
    public static function get_value() {
        return static::$value;
    }

	/**
	 * Sets the input's value.
	 *
	 * @since TBD
	 *
	 * @param mixed $value The desired value.
	 *
	 * @return void
	 */
    public function set_value( $value ): void {
        $this->value = $value;
    }

	/**
	 * Sets a specific attribute before compiling attributes to a string.
	 *
	 * @since TBD
	 *
	 * @param string $name
	 * @param string $value
	 *
	 * @return void
	 */
    public function set_attribute( string $name, string $value ): void {
		if ( ! in_array( $name, $this->allowed_attributes ) ) {
			return;
		}

        $this->attributes[$name] = $value;
    }

	/**
	 * Gets the value of a specific attribute by name.
	 *
	 * @since TBD
	 *
	 * @param string $name
	 *
	 * @return string
	 */
    public static function get_attribute( $name ): ?string {
        return isset( static::$attributes[ $name ] ) ? static::$attributes[ $name ] : null;
    }

	/**
	 * Gets the string of attributes for an input for rendering purposes.
	 *
	 * @since TBD
	 *
	 * @param array<string,string> $attributes
	 * @return string
	 */
	public static function get_attributes_string( ): string {
		static::$attributes[ 'id' ] = static::get_id();

		// Remove invalid attributes.
		array_filter(
			static::$attributes,
			function( $v, $k ) {
				return in_array( $k, $this->allowed_attributes );
			},
			ARRAY_FILTER_USE_BOTH
		);

		// Generate and return string containing all valid attributes.
		return implode(
			' ',
			array_map(
				function ( $k, $v ) {
					return sprintf(
						'%s="%s"',
						esc_attr( $k ),
						esc_attr( $v )
					);
				},
				array_keys( static::$attributes ),
				array_values( static::$attributes )
			)
		);
	}

	/**
	 * Returns the HTML string of the input for rendering.
	 *
	 * @since TBD
	 *
	 * @return string
	 */
	abstract static public function get_html(): string;

	/**
	 * Renders the input element.
	 *
	 * @since TBD
	 */
    static public function render() {
		echo static::get_html();
	}
}
