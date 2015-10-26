<?php

$generalTabFields = array(
	'info-start'                    => array(
		'type' => 'html',
		'html' => '<div id="modern-tribe-info"><img src="' . plugins_url( 'resources/images/modern-tribe@2x.png', dirname( __FILE__ ) ) . '" alt="Modern Tribe Inc." title="Modern Tribe Inc.">',
	),
	'upsell-info'                   => array(
		'type'        => 'html',
		'html'        => '<p>' . esc_html__( 'Looking for additional functionality including recurring events, custom meta, community events, ticket sales and more?', 'tribe-common' ) . ' <a href="' . Tribe__Main::$tec_url . 'products/?utm_source=generaltab&utm_medium=plugin-tec&utm_campaign=in-app">' . esc_html__( 'Check out the available add-ons', 'tribe-common' ) . '</a>.</p>',
		'conditional' => ( ! defined( 'TRIBE_HIDE_UPSELL' ) || ! TRIBE_HIDE_UPSELL ),
	),
	'donate-link-heading'           => array(
		'type'  => 'heading',
		'label' => esc_html__( 'We hope our plugin is helping you out.', 'tribe-common' ),
	),
	'donate-link-info'              => array(
		'type'        => 'html',
		'html'        => '<p>' . esc_html__( 'Are you thinking "Wow, this plugin is amazing! I should say thanks to Modern Tribe for all their hard work." The greatest thanks we could ask for is recognition. Add a small text-only link at the bottom of your calendar pointing to The Events Calendar project.', 'tribe-common' ) . '<br><a href="' . esc_url( plugins_url( 'resources/images/donate-link-screenshot.jpg', dirname( __FILE__ ) ) ) . '" class="thickbox">' . esc_html__( 'See an example of the link', 'tribe-common' ) . '</a>.</p>',
		'conditional' => ! class_exists( 'Tribe__Events__Pro__Main' ),
	),
	'donate-link-pro-info'          => array(
		'type'        => 'html',
		'html'        => '<p>' . esc_html__( 'Are you thinking "Wow, this plugin is amazing! I should say thanks to Modern Tribe for all their hard work." The greatest thanks we could ask for is recognition. Add a small text only link at the bottom of your calendar pointing to The Events Calendar project.', 'tribe-common' ) . '<br><a href="' . esc_url( plugins_url( 'resources/images/donate-link-pro-screenshot.jpg', dirname( __FILE__ ) ) ) . '" class="thickbox">' . esc_html__( 'See an example of the link', 'tribe-common' ) . '</a>.</p>',
		'conditional' => class_exists( 'Tribe__Events__Pro__Main' ),
	),
	'donate-link'                   => array(
		'type'            => 'checkbox_bool',
		'label'           => esc_html__( 'Show The Events Calendar link', 'tribe-common' ),
		'default'         => false,
		'validation_type' => 'boolean',
	),
	'info-end'                      => array(
		'type' => 'html',
		'html' => '</div>',
	),
	'tribe-form-content-start'      => array(
		'type' => 'html',
		'html' => '<div class="tribe-settings-form-wrap">',
	),
	'tribeEventsDisplayThemeTitle'  => array(
		'type' => 'html',
		'html' => '<h3>' . esc_html__( 'General Settings', 'tribe-common' ) . '</h3>',
	),
	'multiDayCutoff'                => array(
		'type'            => 'dropdown',
		'label'           => esc_html__( 'End of day cutoff', 'tribe-common' ),
		'validation_type' => 'options',
		'size'            => 'small',
		'default'         => '12:00',
		'options'         => array(
			'00:00' => '12:00 am',
			'01:00' => '01:00 am',
			'02:00' => '02:00 am',
			'03:00' => '03:00 am',
			'04:00' => '04:00 am',
			'05:00' => '05:00 am',
			'06:00' => '06:00 am',
			'07:00' => '07:00 am',
			'08:00' => '08:00 am',
			'09:00' => '09:00 am',
			'10:00' => '10:00 am',
			'11:00' => '11:00 am',
		),
	),
	'multiDayCutoffHelper'          => array(
		'type'        => 'html',
		'html'        => '<p class="tribe-field-indent tribe-field-description description">' . sprintf( esc_html__( "Have an event that runs past midnight? Select a time after that event's end to avoid showing the event on the next day's calendar.", 'tribe-common' ) ) . '</p>',
		'conditional' => ( '' != get_option( 'permalink_structure' ) ),
	),
	'defaultCurrencySymbol'         => array(
		'type'            => 'text',
		'label'           => esc_html__( 'Default currency symbol', 'tribe-common' ),
		'tooltip'         => esc_html__( 'Set the default currency symbol for event costs. Note that this only impacts future events, and changes made will not apply retroactively.', 'tribe-common' ),
		'validation_type' => 'textarea',
		'size'            => 'small',
		'default'         => '$',
	),
	'reverseCurrencyPosition'       => array(
		'type'            => 'checkbox_bool',
		'label'           => esc_html__( 'Currency symbol follows value', 'tribe-common' ),
		'tooltip'         => esc_html__( 'The currency symbol normally precedes the value. Enabling this option positions the symbol after the value.', 'tribe-common' ),
		'default'         => false,
		'validation_type' => 'boolean',
	),
	'tribeEventsMiscellaneousTitle' => array(
		'type' => 'html',
		'html' => '<h3>' . esc_html__( 'Miscellaneous Settings', 'tribe-common' ) . '</h3>',
	),
	'viewWelcomePage'          => array(
		'type'        => 'html',
		'html'        => '<fieldset class="tribe-field tribe-field-html"><legend>' . esc_html__( 'View Welcome Page', 'tribe-common' ) . '</legend><div class="tribe-field-wrap"><a href="' . Tribe__Settings::instance()->get_url( array( 'tec-welcome-message' => true ) ) . '" class="button">' . esc_html__( 'View Welcome Page', 'tribe-common' ) . '</a><p class="tribe-field-indent description">' . esc_html__( 'View the page that displayed when you initially installed the plugin.', 'tribe-common' ) . '</p></div></fieldset><div class="clear"></div>',

	),
	'viewUpdatePage'          => array(
		'type'        => 'html',
		'html'        => '<fieldset class="tribe-field tribe-field-html"><legend>' . esc_html__( 'View Update Page', 'tribe-common' ) . '</legend><div class="tribe-field-wrap"><a href="' . Tribe__Settings::instance()->get_url( array( 'tec-update-message' => true ) ) . '" class="button">' . esc_html__( 'View Update Page', 'tribe-common' ) . '</a><p class="tribe-field-indent description">' . esc_html__( 'View the page that displayed when you updated the plugin.', 'tribe-common' ) . '</p></div></fieldset><div class="clear"></div>',
	),
);

if ( is_super_admin() ) {
	$generalTabFields['debugEvents'] = array(
		'type'            => 'checkbox_bool',
		'label'           => esc_html__( 'Debug mode', 'tribe-common' ),
		'default'         => false,
		'validation_type' => 'boolean',
	);
	$generalTabFields['debugEventsHelper'] = array(
		'type'        => 'html',
		'html'        => '<p class="tribe-field-indent tribe-field-description description" style="max-width:400px;">' . sprintf( esc_html__( 'Enable this option to log debug information. By default this will log to your server PHP error log. If you\'d like to see the log messages in your browser, then we recommend that you install the %s and look for the "Tribe" tab in the debug output.', 'tribe-common' ), '<a href="http://wordpress.org/extend/plugins/debug-bar/" target="_blank">' . esc_html__( 'Debug Bar Plugin', 'tribe-common' ) . '</a>' ) . '</p>',
		'conditional' => ( '' != get_option( 'permalink_structure' ) ),
	);
}

// Closes form
$generalTabFields['tribe-form-content-end'] = array(
	'type' => 'html',
	'html' => '</div>',
);


$generalTab = array(
	'priority' => 10,
	'fields'   => apply_filters( 'tribe_general_settings_tab_fields', $generalTabFields ),
);

