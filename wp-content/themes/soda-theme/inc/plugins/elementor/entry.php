<?php

namespace BBElementor;

use BBElementor\Widgets\Header_Bar;
use BBElementor\Widgets\Ld_Courses;
use BBElementor\Widgets\Ld_Activity;
use BBElementor\Widgets\BBP_Members;
use BBElementor\Widgets\BBP_Activity;
use BBElementor\Widgets\BBP_Forums;
use BBElementor\Widgets\BBP_Forums_Activity;
use BBElementor\Widgets\BBP_Profile_Completion;
use BBElementor\Widgets\BBP_Dashboard_Intro;
use BBElementor\Widgets\BBP_Dashboard_Grid;
use BBElementor\Widgets\BB_Tabs;
use BBElementor\Widgets\BB_Review;
use BBElementor\Widgets\BB_Gallery;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Main BB Elementor Widgets Class
 *
 * Register new elementor widget.
 *
 * @since 1.0.0
 */
class bbElementorWidgets {

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {
		$this->add_actions();
	}

	/**
	 * BB Categories
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function bb_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'buddyboss-elements',
			array(
				'title' => __( 'BuddyBoss', 'buddyboss-theme' ),
				'icon'  => 'eicon-parallax',
			)
		);

	}

	/**
	 * Add Actions
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function add_actions() {
		add_action( 'elementor/elements/categories_registered', array( $this, 'bb_elementor_widget_categories' ) );

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'bb_elementor_widgets_registered' ) );

		add_action(
			'elementor/frontend/after_register_scripts',
			function () {
				wp_register_script( 'elementor-bb-frontend', get_template_directory_uri() . '/inc/plugins/elementor/assets/js/frontend.js', array( 'jquery' ), false, true );
			}
		);

		add_action(
			'elementor/editor/after_enqueue_scripts',
			function () {
				wp_enqueue_script( 'elementor-bb-editor', get_template_directory_uri() . '/inc/plugins/elementor/assets/js/editor.js', array( 'jquery' ), false, true );
			}
		);
	}

	/**
	 * BB Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function bb_elementor_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		require __DIR__ . '/widgets/bb-header-bar.php';
		require __DIR__ . '/widgets/bb-dashboard-grid.php';
		require __DIR__ . '/widgets/bb-tabs.php';
		require __DIR__ . '/widgets/bb-review.php';
		require __DIR__ . '/widgets/bb-gallery.php';
		if ( class_exists( 'SFWD_LMS' ) ) {
			require __DIR__ . '/widgets/bb-ld-courses.php';
			require __DIR__ . '/widgets/bb-ld-activity.php';
		}
		if ( function_exists( 'bp_is_active' ) ) {
			require __DIR__ . '/widgets/bb-members.php';
			require __DIR__ . '/widgets/bb-profile-completion.php';
			require __DIR__ . '/widgets/bb-dashboard-intro.php';
		}
		if ( function_exists( 'bp_is_active' ) && bp_is_active( 'activity' ) ) {
			require __DIR__ . '/widgets/bb-activity.php';
		}
		if ( function_exists( 'bp_is_active' ) && bp_is_active( 'forums' ) ) {
			require __DIR__ . '/widgets/bb-forums.php';
			require __DIR__ . '/widgets/bb-forums-activity.php';
		}
	}

	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Header_Bar() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BBP_Dashboard_Grid() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BB_Tabs() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BB_Review() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BB_Gallery() );
		if ( class_exists( 'SFWD_LMS' ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Ld_Courses() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Ld_Activity() );
		}
		if ( function_exists( 'bp_is_active' ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BBP_Members() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BBP_Profile_Completion() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BBP_Dashboard_Intro() );
		}
		if ( function_exists( 'bp_is_active' ) && bp_is_active( 'activity' ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BBP_Activity() );
		}
		if ( function_exists( 'bp_is_active' ) && bp_is_active( 'forums' ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BBP_Forums() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new BBP_Forums_Activity() );
		}
	}
}

new bbElementorWidgets();
