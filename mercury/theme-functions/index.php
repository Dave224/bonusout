<?php

function mercury_admin_style() {
  wp_register_style( "mercury_admin_style", get_theme_file_uri("theme-functions/admin_style.css"), 10);
	wp_enqueue_style( "mercury_admin_style" );
}
add_action( 'admin_print_styles', 'mercury_admin_style' );

/* Add Mercury Welcome Page - Start */

function mercury_welcome_options(){
  add_menu_page( 
      esc_html__('Mercury Theme', 'mercury'),
      esc_html__('Mercury Theme', 'mercury'),
      'manage_options',
      'mercury_theme_page',
      'mercury_welcome_page',
      'dashicons-awards',
      64
  );
}
add_action( 'admin_menu', 'mercury_welcome_options' );

function mercury_welcome_page() {
        ?>  

        <div class="wrap">
            <h1>
              <?php
              printf(
                __( 'Mercury Theme %s.', 'mercury' ),
                $GLOBALS['mercury_version']
              );
              ?>
            </h1>
            <div class="card">
              <p>
                <strong><?php esc_html_e('Thank you for using the Mercury theme!', 'mercury'); ?></strong><br>
                <?php esc_html_e('Please, don&#8217;t forget to rate 5 stars ★★★★★ for the theme. It helps a lot.', 'mercury'); ?><br>
                <a href="<?php echo esc_url( __( 'https://themeforest.net/downloads', 'mercury' ) ); ?>" target="_blank" title="<?php esc_attr( 'themeforest.net/downloads', 'mercury' ); ?>"><?php esc_html_e( 'themeforest.net/downloads', 'mercury' ); ?></a>
              </p>
            </div>
            <div class="card">
              <p>
                <strong><?php esc_html_e('All Mercury theme settings are in', 'mercury'); ?> <a href="<?php echo esc_url( home_url( '/wp-admin/customize.php' ) ); ?>" target="_blank" title="<?php esc_attr( 'Customize', 'mercury' ); ?>"><?php esc_html_e( 'Customize', 'mercury' ); ?></a>.</strong><br><br>
                <a href="<?php echo esc_url( __( 'https://mercurytheme.com/documentation/', 'mercury' ) ); ?>" target="_blank" title="<?php esc_attr( 'Online Documentation', 'mercury' ); ?>"><?php esc_html_e( 'Online Documentation', 'mercury' ); ?></a><br>
                <a href="<?php echo esc_url( __( 'https://spacethemes.ticksy.com/', 'mercury' ) ); ?>" target="_blank" title="<?php esc_attr( 'Need support?', 'mercury' ); ?>"><?php esc_html_e( 'Need support?', 'mercury' ); ?></a>
              </p>
            </div>

        </div>
        <?php
}

add_action( 'tgmpa_register', 'mercury_register_required_plugins' );

/* Add Mercury Welcome Page - End */

function mercury_register_required_plugins() {

	$plugins = array(

		array(
			'name'     				      => esc_html__('One Click Demo Import', 'mercury'),
			'slug'     				      => 'one-click-demo-import',
			'required' 				      => true,
			'version' 				      => '3.1.1',
			'force_activation' 		  => false,
			'force_deactivation' 	  => false,
			'external_url' 			    => '',
		),
		array(
			'name'                  => esc_html__('Mercury Addons', 'mercury'),
			'slug'                  => 'mercury-addons',
			'source'                => 'https://export.mercurytheme.com/files/plugins/3.9.8/mercury-addons-2.6.2.zip',
			'required'              => true,
			'version'               => '2.6.2',
			'force_activation'      => false,
			'force_deactivation'    => false,
			'external_url'          => '',
		),
		array(
			'name'                  => esc_html__('ACES', 'mercury'),
			'slug'                  => 'aces',
			'source'                => 'https://export.mercurytheme.com/files/plugins/3.9.10/aces-3.0.6.zip',
			'required'              => true,
			'version'               => '3.0.6',
			'force_activation'      => false,
			'force_deactivation'    => false,
			'external_url'          => '',
		),
    array(
      'name'                  => esc_html__('Slots Launch', 'mercury'),
      'slug'                  => 'slotslaunch-wp',
      'source'                => 'https://export.mercurytheme.com/files/plugins/3.9.9/slotslaunch-wp.zip',
      'required'              => false,
      'version'               => '1.3.2.5',
      'force_activation'      => false,
      'force_deactivation'    => false,
      'external_url'          => '',
    )

	);

	$config = array(
		'id'           => 'tgmpa',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'edit_theme_options',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}

function mercury_import_files() {

  return array(
    array(

      'import_file_name'             => esc_html__( 'Mercury Casino 1', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/001/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/001/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-01.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/001.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/001/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Casino 2', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/002/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/002/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-02.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/002.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/002/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Casino 3', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/003/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/003/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-03.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/003.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/003/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Betting 1', 'mercury' ),
      'categories'                   => array( 'Sports Betting' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/004/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/004/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-04.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/004.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/004/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Casino 4', 'mercury' ),
      'categories'                   => array( 'Casino' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/005/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/005/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-05.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/005.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/005/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Betting 2', 'mercury' ),
      'categories'                   => array( 'Sports Betting' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/006/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/006/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-06.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/006.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/006/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Slots 1', 'mercury' ),
      'categories'                   => array( 'Slots' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/007/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/007/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-07.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/007.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/007/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Poker 1', 'mercury' ),
      'categories'                   => array( 'Poker' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/008/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/008/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-08.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/008.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/008/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Betting 3', 'mercury' ),
      'categories'                   => array( 'eSports betting' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/009/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/009/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-09.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/009.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/009/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Magazine 1', 'mercury' ),
      'categories'                   => array( 'Magazine' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/010/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/010/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-10.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/010.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/010/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Crypto 1', 'mercury' ),
      'categories'                   => array( 'Crypto' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/011/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/011/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-11.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/011.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/011/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury VPN/Hosting 1', 'mercury' ),
      'categories'                   => array( 'VPN & Hosting' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/012/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/012/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-12.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/012.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/012/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Dating 1', 'mercury' ),
      'categories'                   => array( 'Dating' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/013/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/013/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-13.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/013.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/013/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Slots Launch Demo', 'mercury' ),
      'categories'                   => array( 'Slots' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/014/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/014/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-14.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/014.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/014/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Slots 2', 'mercury' ),
      'categories'                   => array( 'Slots' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/015/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/015/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-15.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/015.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/015/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Forex', 'mercury' ),
      'categories'                   => array( 'Forex' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/016/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/016/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-16.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/016.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/016/',
    ),
    array(

      'import_file_name'             => esc_html__( 'Mercury Crypto 2', 'mercury' ),
      'categories'                   => array( 'Crypto' ),
      'import_customizer_file_url'   => 'https://files.mercurytheme.com/demo/017/options.dat',
      'import_file_url'              => 'https://files.mercurytheme.com/demo/017/content.xml',
      'import_widget_file_url'       => 'https://files.mercurytheme.com/download-wies/download-wie-file-demo-17.php',
      'import_preview_image_url'     => 'https://files.mercurytheme.com/images/017.jpg',
      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'mercury' ),
      'preview_url'                  => 'https://project.mercurytheme.com/017/',
    ),
  );
}

add_filter( 'pt-ocdi/import_files', 'mercury_import_files' );

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

function mercury_after_import_setup() {

  $front_page_id = get_page_by_title( 'Home' );

  update_option( 'show_on_front', 'page' );
  update_option( 'page_on_front', $front_page_id->ID );

	$main_menu   = get_term_by( 'name', 'Main Menu', 'nav_menu' );
  $footer_menu   = get_term_by( 'name', 'Footer Menu', 'nav_menu' );
  $top_menu   = get_term_by( 'name', 'Top Bar Menu', 'nav_menu' );

  set_theme_mod( 'nav_menu_locations', array(
    'main-menu'   => $main_menu->term_id,
    'footer-menu'   => $footer_menu->term_id,
    'top-menu'   => $top_menu->term_id
  ));

}

add_action( 'pt-ocdi/after_import', 'mercury_after_import_setup' );