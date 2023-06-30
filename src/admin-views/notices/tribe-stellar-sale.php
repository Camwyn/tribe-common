<?php
/**
 * The Stellar Sale admin notice.
 *
 * @since 4.14.2
 *
 * @var string $icon_url The local URL for the notice's image.
 * @var string $cta_url The short URL for the Stellar Sale.
 */

$has_tec_only = true; // todo: update this to check if the user has Pro plugins installed.
$label        = $has_tec_only ? 'yours' : 'stellar';
$brand        = $has_tec_only ? 'Events Calendar' : 'StellarWP';
?>
<div class="tribe-marketing-notice">
	<div class="tribe-marketing-notice__content-wrapper">
		<div class="tribe-marketing-notice__col--md">
			<h3>
				<?php echo sprintf( __( 'Make it %s.', 'tribe-common' ), $label ); ?>
			</h3>
			<h4>
				<?php echo sprintf( __( 'Save 30%% on all %s products.', 'tribe-common' ), $brand ); ?>
			</h4>
			<p>
				<span class="tribe-marketing-notice__cta-shop-now tribe-marketing-notice__cta-shop-now--desktop">
					<a target="_blank" href="<?php echo esc_url( $cta_url ); ?>">
						<?php echo esc_html_x( 'Shop now', 'Shop now link text', 'tribe-common' ) ?>
					</a>
				</span>
			</p>
		</div>
		
		<div class="tribe-marketing-notice__col--lg">
			<p class="tribe-marketing-notice__info">
				<?php echo __( 'Purchase any StellarWP product during the sale and get <b>100%</b> off WP Business Reviews and take <b>40%</b> off all other brands.', 'tribe-common' ); ?>
			</p>
			<div class="tribe-marketing-notice__col--inner">
				<p>
					<span class="tribe-marketing-notice__cta-shop-now tribe-marketing-notice__cta-shop-now--mobile">
						<a target="_blank" href="<?php echo esc_url( $cta_url ); ?>">
							<?php echo esc_html_x( 'Shop now', 'Shop now link text', 'tribe-common' ) ?>
						</a>
					</span>
				</p>

				<p>
					<span class="tribe-marketing-notice__cta-stellar-deals">
						<a target="_blank" href="<?php echo esc_url( $stellar_url ); ?>">
							<?php echo esc_html_x( 'View all StellarWP Deals', 'View all StellarWP Deals link text', 'tribe-common' ); ?>
						</a>
					</span>
				</p>
			</div>
		</div>

		<div class="tribe-marketing-notice__col--sm">
			<img
				class="tribe-marketing-notice__col--sm-bg"
				src="<?php echo esc_url( tribe_resource_url( 'images/marketing/stellar-sale-banner-bg.svg', false, null, Tribe__Main::instance() ) ); ?>"
			/>
		</div>
	</div>
</div>
