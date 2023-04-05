<?php

namespace TEC\Common\Forms;

use TEC\Common\Forms\Input_Factory;
use TEC\Common\Forms\Inputs\Abstract_Input;
use TEC\Common\Forms\Inputs\Text;

/**
 * Test class Input_Factory
 *
 * @since   TBD
 *
 * @package TEC\Common\Storage
 */
class Input_FactoryTest extends \Codeception\TestCase\WPTestCase {
    public function testCreateInput(): void {
        // Test creating a valid input.
        $input = Input_Factory::createInput( 'text', 'my_input', 'default_value', ['class' => 'form-control'] );
		// We're using the text input here because it's simple and familiar.
        $this->assertInstanceOf( Text::class, $input );
		$this->assertInstanceOf( Abstract_Input::class, $input );
        $this->assertEquals( 'my_input', $input->get_name() );
        $this->assertEquals( 'default_value', $input->get_value() );
        $this->assertArrayHasKey( 'class', $input->get_attributes() );
        $this->assertEquals( 'form-control', $input->get_attribute( 'class' ) );

        // Test creating an invalid input.
        $this->expectException( \InvalidArgumentException::class);
        Input_Factory::createInput( 'invalid_type', 'my_input', 'default_value');
    }

    public function testFromArray(): void {
        // Test creating an input from a valid array.
        $input_array = [
            'type' => 'text',
            'name' => 'my_input',
            'value' => 'default_value',
            'attributes' => ['class' => 'form-control'],
        ];
        $input = Input_Factory::from_array($input_array);
		// We're using the text input here because it's simple and familiar.
        $this->assertInstanceOf( Text::class, $input );
		$this->assertInstanceOf( Abstract_Input::class, $input );
        $this->assertEquals( 'my_input', $input->get_name() );
        $this->assertEquals( 'default_value', $input->get_value() );
        $this->assertArrayHasKey( 'class', $input->get_attributes() );
        $this->assertEquals( 'form-control', $input->get_attribute( 'class' ) );

        // Test creating an input from an array without required keys.
        $this->expectException(\InvalidArgumentException::class);
        Input_Factory::from_array(['name' => 'my_input']);
    }

    public function testFromJson(): void {
        // Test creating an input from valid JSON.
        $input_json = '{"type":"text","name":"my_input","value":"default_value","attributes":{"class":"form-control"}}';
        $input = Input_Factory::from_json($input_json);
		// We're using the text input here because it's simple and familiar.
        $this->assertInstanceOf( Text::class, $input );
		$this->assertInstanceOf( Abstract_Input::class, $input );
        $this->assertEquals( 'my_input', $input->get_name() );
        $this->assertEquals( 'default_value', $input->get_value() );
        $this->assertArrayHasKey( 'class', $input->get_attributes() );
        $this->assertEquals( 'form-control', $input->get_attribute( 'class' ) );

        // Test creating an input from invalid JSON.
		/* This throws a TypeError, rather than InvalidArgumentException
		because we're supposed to pass an array down the line - not a string. */
        $this->expectException( \TypeError::class );
        Input_Factory::from_json( 'invalid_json' );

		// Test creating an input from invalid JSON. This will throw InvalidArgumentException
		$this->expectException( \InvalidArgumentException::class );
        Input_Factory::from_json( '' );
    }
}
