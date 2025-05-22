<?php
global $post;
$bonus_allowed_html = array(
	'a' => array(
		'href' => true,
		'title' => true,
		'target' => true,
		'rel' => true
	),
	'br' => array(),
	'em' => array(),
	'strong' => array(),
	'span' => array(
		'class' => true
	),
	'div' => array(
		'class' => true
	),
	'p' => array()
);

$bonus_external_link = esc_url( get_post_meta( get_the_ID(), 'bonus_external_link', true ) );

if ( get_option( 'aces_bonus_link_mask_slug') && $bonus_external_link ) {
	
	$bonus_mask_link_slug = esc_attr( get_post_meta( get_the_ID(), 'bonus_mask_link', true ) );

	if ( $bonus_mask_link_slug ) {

		if ( $_GET['m'] == $bonus_mask_link_slug ){
			$redirect_link = esc_url( $bonus_external_link );
			header('Location: ' . $redirect_link );
			die();
		}

		$bonus_external_link = esc_url( get_the_permalink().'?m='.$bonus_mask_link_slug );
		
	}
}

$bonus_button_title = esc_html( get_post_meta( get_the_ID(), 'bonus_button_title', true ) );
$bonus_button_notice = wp_kses( get_post_meta( get_the_ID(), 'bonus_button_notice', true ), $bonus_allowed_html );
$bonus_dark_style = esc_attr( get_post_meta( get_the_ID(), 'bonus_dark_style', true ) );

$offer_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'offer_detailed_tc', true ), $bonus_allowed_html );
$offer_popup_hide = esc_attr( get_post_meta( get_the_ID(), 'aces_offer_popup_hide', true ) );
$offer_popup_title = esc_html( get_post_meta( get_the_ID(), 'aces_offer_popup_title', true ) );

if ($bonus_button_title) {
	$button_title = $bonus_button_title;
} else {
	if ( get_option( 'bonuses_get_bonus_title') ) {
		$button_title = esc_html( get_option( 'bonuses_get_bonus_title') );
	} else {
		$button_title = esc_html__( 'Get Bonus', 'mercury' );
	}
}

if ($offer_popup_title) {
	$custom_popup_title = $offer_popup_title;
} else {
	$custom_popup_title = esc_html__( 'T&Cs Apply', 'mercury' );
}

if ($bonus_external_link) {
	$external_link_url = $bonus_external_link;
} else {
	$external_link_url = get_the_permalink();
}

$post_title_attr = the_title_attribute( 'echo=0' );
$terms = get_the_terms( $post->ID, 'bonus-category' );

$casino_ids = get_post_meta( get_the_ID(), 'bonus_parent_casino', true );
$casino_id = reset($casino_ids);

?>

<div class="space-offers-archive-item box-33 relative<?php if ($bonus_dark_style == true ) { ?> space-dark-style<?php } ?>">
	<div class="space-offers-archive-item-ins relative" style="flex-wrap: wrap; align-items: start;">
		<div class="space-offers-archive-item-top-elements box-100 relative">
			<div class="space-offers-archive-item-top-left-element box-40 relative">
				<?php
				if( $casino_ids ){
					$casino_logo = wp_get_attachment_image_src(get_post_thumbnail_id($casino_id), 'mercury-135-135');
					if ($casino_logo) { ?>
						<a href="<?php the_permalink($casino_id); ?>" title="<?php echo get_the_title($casino_id); ?>">
							<img src="<?php echo esc_url($casino_logo[0]); ?>" alt="<?php echo get_the_title($casino_id); ?>">
						</a>
					<?php }									
				} elseif ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-135-135', "", array( "alt" => $post_title_attr ) ); ?>
					</a>
				<?php }
				?>
			</div>
			<div class="space-offers-archive-item-top-right-element box-60 relative">
				<div class="space-offers-archive-item-wrap text-center relative" style="padding: 15px 15px 0;">

					<?php if ($casino_ids) { ?>
						<div class="space-offers-archive-item-cat relative">
						    <a href="<?php the_permalink($casino_id); ?>" title="<?php echo get_the_title($casino_id); ?>" style="font-size: 12px;"><?php echo get_the_title($casino_id); ?></a>
						</div>
					<?php } elseif ($terms) { ?>
						<div class="space-offers-archive-item-cat relative">
							<?php foreach ( $terms as $term ) { ?>
						        <a href="<?php echo esc_url (get_term_link( (int)$term->term_id, $term->taxonomy )); ?>" style="font-size: 12px;" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($term->name); ?></a>
						    <?php } ?>
						</div>
					<?php } ?>

					<div class="space-offers-archive-item-title relative" style="margin-bottom: 0;">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
					</div>

				</div>
			</div>
		</div>
		<div class="space-offers-archive-item-middle-elements text-center box-100 relative">
			<div class="space-offers-archive-item-middle-elements-ins relative">
				<div class="space-offers-archive-item-button relative" style="margin-top: 0;">
					<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><?php echo esc_html( $button_title ); ?></a>
				</div>

				<?php if ($offer_popup_hide == true ) { ?>
					<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
						<span class="tc-apply"><?php echo esc_html( $custom_popup_title ); ?></span>
						<div class="tc-desc">
							<?php
								if ($offer_detailed_tc) {
									echo wp_kses( $offer_detailed_tc, $bonus_allowed_html );
								}
							?>
						</div>
					</div>
				<?php } ?>

				<?php if ($bonus_button_notice) { ?>

				<div class="space-offers-archive-item-button-notice relative" style="margin-top: 5px;">
					<?php echo wp_kses( $bonus_button_notice, $bonus_allowed_html ); ?>
				</div>

				<?php } ?>
			</div>
		</div>

		<?php
		if ($offer_popup_hide == true ) {

		} else {
			if ($offer_detailed_tc) { ?>
			<div class="space-organizations-archive-item-detailed-tc box-100 relative">
				<div class="space-organizations-archive-item-detailed-tc-ins relative" style="padding: 0 15px 15px;">
					<?php echo wp_kses( $offer_detailed_tc, $bonus_allowed_html ); ?>
				</div>
			</div>
		<?php
			}
		}
		?>
	</div>
</div>