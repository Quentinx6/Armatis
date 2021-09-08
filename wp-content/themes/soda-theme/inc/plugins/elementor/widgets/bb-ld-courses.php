<?php
namespace BBElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use BuddyBossTheme\LearndashHelper;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Ld_Courses extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld-courses';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'LearnDash Course Grid', 'buddyboss-theme' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'buddyboss-elements' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'buddyboss-theme' ),
			]
		);

		$this->add_control(
			'skin_style',
			array(
				'label'   => __( 'Skin', 'buddyboss-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'classic',
				'options' => array(
					'classic'  => __( 'Classic', 'buddyboss-theme' ),
					'cover' => __( 'Cover', 'buddyboss-theme' ),
				),
			)
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'buddyboss-theme' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 8,
			]
		);

		$this->add_control(
			'switch_featured_row',
			[
				'label'   => esc_html__( 'Show Featured Row', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'skin_style' => 'cover',
				],
			]
		);

		$this->add_control(
			'switch_pagination',
			[
				'label'   => esc_html__( 'Pagination', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'separator_filters',
			array(
				'label'     => __( 'Filters', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'orderby_filter',
			array(
				'label'        => __( 'Order by Filter', 'buddyboss-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'buddyboss-theme' ),
				'label_off'    => __( 'Hide', 'buddyboss-theme' ),
				'return_value' => 'on',
				'default'      => 'on',
			)
		);

		if ( '' !== trim( buddyboss_theme()->learndash_helper()->print_categories_options() ) ) {
			$this->add_control(
				'category_filter',
				array(
					'label'        => __( 'Category Filter', 'buddyboss-theme' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => __( 'Show', 'buddyboss-theme' ),
					'label_off'    => __( 'Hide', 'buddyboss-theme' ),
					'return_value' => 'on',
					'default'      => 'on',
				)
			);
		}

		$this->add_control(
			'instructors_filter',
			array(
				'label'        => __( 'Instructors Filter', 'buddyboss-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'buddyboss-theme' ),
				'label_off'    => __( 'Hide', 'buddyboss-theme' ),
				'return_value' => 'on',
				'default'      => 'on',
			)
		);

		$this->add_control(
			'grid_filter',
			array(
				'label'        => __( 'Grid Filter', 'buddyboss-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'buddyboss-theme' ),
				'label_off'    => __( 'Hide', 'buddyboss-theme' ),
				'return_value' => 'on',
				'default'      => 'on',
				'condition' => [
					'skin_style' => 'classic',
				],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_courses',
			array(
				'label' => __( 'Courses', 'buddyboss-theme' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'columns_num',
			array(
				'label'   => __( 'Columns', 'buddyboss-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'  => __( 'Default', 'buddyboss-theme' ),
					'1' => __( '1', 'buddyboss-theme' ),
					'2' => __( '2', 'buddyboss-theme' ),
					'3' => __( '3', 'buddyboss-theme' ),
					'4' => __( '4', 'buddyboss-theme' ),
				),
				'condition' => [
					'skin_style' => 'classic',
				],
			)
		);

		$this->add_control(
			'switch_media',
			[
				'label'   => esc_html__( 'Show Media', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'content_v_position',
			[
				'label' => __( 'Content Position', 'buddyboss-theme' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'buddyboss-theme' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'buddyboss-theme' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'bottom',
				'prefix_class' => 'elementor-cta-%s-content-v-align-',
				'condition' => [
					'skin_style' => 'cover',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_v_position',
			[
				'label' => __( 'Avatar Position', 'buddyboss-theme' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'buddyboss-theme' ),
						'icon' => 'eicon-v-align-top',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'buddyboss-theme' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'top',
				'prefix_class' => 'elementor-cta-%s-avatar-v-align-',
				'condition' => [
					'skin_style' => 'cover',
					'content_v_position' => 'top',
					'switch_author' => 'yes',
				],
			]
		);

		$this->add_control(
			'image_ratio',
			array(
				'label'      => __( 'Image Ratio', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min'  => 20,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 52,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-course-items .bb-cover-wrap' => 'padding-top: {{SIZE}}{{UNIT}};',
				),
				'condition' => [
					'skin_style' => 'classic',
				],
			)
		);

		$this->add_control(
			'switch_status',
			[
				'label'   => esc_html__( 'Show Status', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'switch_media' => 'yes',
					'skin_style' => 'classic',
				],
			]
		);

		$this->add_control(
			'separator_style_progress',
			array(
				'label'     => __( 'Progress', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'switch_progress',
			[
				'label'   => esc_html__( 'Show Progress', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'course_progress_bgr',
			array(
				'label'     => __( 'Background', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ld-progress-bar' => 'background-color: {{VALUE}}',
				),
				'condition' => [
					'switch_progress' => 'yes',
				],
			)
		);

		$this->add_control(
			'course_progress_color',
			array(
				'label'     => __( 'Active Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ld-progress-bar .ld-progress-bar-percentage' => 'background-color: {{VALUE}}',
				),
				'condition' => [
					'switch_progress' => 'yes',
				],
			)
		);

		$this->add_control(
			'course_progress_text_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-course-items .ld-progress-stats' => 'color: {{VALUE}}',
				),
				'condition' => [
					'switch_progress' => 'yes',
				],
			)
		);

		$this->add_control(
			'course_progress_size',
			array(
				'label'      => __( 'Height', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 4,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ld-progress-bar' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ld-progress-bar .ld-progress-bar-percentage' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => [
					'switch_progress' => 'yes',
				],
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_progress',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-course-items .ld-progress-stats',
				'condition' => [
					'switch_progress' => 'yes',
				],
			)
		);

		$this->add_control(
			'separator_style_title',
			array(
				'label'     => __( 'Title', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'course_title_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-course-title a' => 'color: {{VALUE}} !important',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_course_title',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-course-title a',
			)
		);

		$this->add_control(
			'course_title_space',
			array(
				'label'      => __( 'Spacing', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 8,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-course-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'#page {{WRAPPER}} .bb-course-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'separator_author',
			array(
				'label'     => __( 'Author', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'switch_author',
			[
				'label'   => esc_html__( 'Show Author', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'avatar_size',
			array(
				'label'      => __( 'Avatar Size', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 20,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 28,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-course-meta .item-avatar' => 'max-width: {{SIZE}}{{UNIT}};',
				),
				'condition' => [
					'switch_author' => 'yes',
				],
			)
		);

		$this->add_control(
			'avatar_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-course-meta strong a' => 'color: {{VALUE}}',
				),
				'condition' => [
					'switch_author' => 'yes',
				],
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_avatar',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-course-meta strong a',
				'condition' => [
					'switch_author' => 'yes',
				],
			)
		);

		$this->add_control(
			'separator_excerpt',
			array(
				'label'     => __( 'Excerpt', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'switch_excerpt',
			[
				'label'   => esc_html__( 'Show Excerpt', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-course-items .bb-course-excerpt' => 'color: {{VALUE}}',
				),
				'condition' => [
					'switch_excerpt' => 'yes',
				],
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_excerpt',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-course-items .bb-course-excerpt',
				'condition' => [
					'switch_excerpt' => 'yes',
				],
			)
		);

		$this->add_control(
			'separator_price',
			array(
				'label'     => __( 'Price', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'skin_style' => 'classic',
				],
			)
		);

		$this->add_control(
			'switch_price',
			[
				'label'   => esc_html__( 'Show Price', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'skin_style' => 'classic',
				],
			]
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-course-footer' => 'color: {{VALUE}}',
				),
				'condition' => [
					'skin_style' => 'classic',
					'switch_price' => 'yes',
				],
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_price',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-course-footer',
				'condition' => [
					'skin_style' => 'classic',
					'switch_price' => 'yes',
				],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_box',
			array(
				'label' => __( 'Box', 'buddyboss-theme' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'box_ratio',
			array(
				'label'      => __( 'Box Size', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 150,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 250,
				),
				'selectors'  => array(
					'{{WRAPPER}} .learndash-course-list--cover .bb-course-items.grid-view .bb-course-item-wrap' => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => [
					'skin_style' => 'cover',
				],
			)
		);

		$this->add_control(
			'box_padding',
			[
				'label'      => __( 'Padding', 'buddyboss-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
				],
				'selectors'  => [
					'{{WRAPPER}} .learndash-course-list--cover .bb-card-course-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'skin_style' => 'cover',
				],
			]
		);

		$this->add_control(
			'box_background',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-course-items .bb-cover-list-item' => 'background-color: {{VALUE}}',
				),
				'condition' => [
					'skin_style' => 'classic',
				],
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'box_media_background',
				'label' => __( 'Media Background', 'buddyboss-theme' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bb-cover-wrap',
			]
		);

		$this->add_control(
			'box_overlay_background',
			array(
				'label'     => __( 'Overlay Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .learndash-course-list--cover .bb-course-items .bb-cover-wrap:after' => 'background-color: {{VALUE}}',
				),
				'condition' => [
					'skin_style' => 'cover',
				],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'box_border',
				'label'       => __( 'Tabs Border', 'buddyboss-theme' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bb-course-items .bb-cover-list-item',
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label'      => __( 'Border Radius', 'buddyboss-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '4',
					'right' => '4',
					'bottom' => '4',
					'left' => '4',
				],
				'selectors'  => [
					'{{WRAPPER}} .bb-course-items .bb-cover-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_border_shadow',
				'label'    => __( 'Box Shadow', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-course-items .bb-cover-list-item',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pagination',
			[
				'label'     => __( 'Pagination', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'switch_pagination' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'buddyboss-theme' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'buddyboss-theme' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'buddyboss-theme' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'buddyboss-theme' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'right',
				'prefix_class' => 'pagination-cta-%s-align-',
			]
		);

		$this->add_control(
			'switch_pagination_arrows',
			[
				'label'   => esc_html__( 'Pagination Arrows', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_pagination',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-lms-pagination > *, {{WRAPPER}} .bb-lms-pagination a.next.page-numbers:before, {{WRAPPER}} .bb-lms-pagination a.prev.page-numbers:before',
			)
		);

		$this->add_control(
			'size',
			array(
				'label'      => __( 'Size', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 5,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 25,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-lms-pagination .page-numbers:not(.prev):not(.next)' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'space_between',
			array(
				'label'      => __( 'Space between', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-lms-pagination > *' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'separator_page_numbers',
			[
				'label'     => __( 'Page Numbers', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs(
			'pagination_tabs'
		);

		$this->start_controls_tab(
			'pagination_normal_tab',
			array(
				'label' => __( 'Normal', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'pagination_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-lms-pagination > a:not(.next):not(.prev)' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_bgr_color',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-lms-pagination > a:not(.next):not(.prev)' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_hover_tab',
			array(
				'label' => __( 'Hover', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'pagination_color_hover',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-lms-pagination > a:not(.next):not(.prev):hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_bgr_color_hover',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-lms-pagination > a:not(.next):not(.prev):hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'active_color',
			[
				'label'     => __( 'Current Page Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-lms-pagination > span.page-numbers' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'active_bgr',
			[
				'label'     => __( 'Current Page Background Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-lms-pagination > span.page-numbers' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'page_num_radius',
			array(
				'label'      => __( 'Border Radius', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-lms-pagination > .page-numbers:not(.prev):not(.next)' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'separator_page_arrows',
			[
				'label'     => __( 'Page Arrows', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs(
			'pagination_arrows'
		);

		$this->start_controls_tab(
			'pagination_arrows_normal_tab',
			array(
				'label' => __( 'Normal', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'pagination_arrows_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-lms-pagination > a.next' => 'color: {{VALUE}}',
					'{{WRAPPER}} .bb-lms-pagination > a.prev' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_arrows_hover_tab',
			array(
				'label' => __( 'Hover', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'pagination_arrows_color_hover',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-lms-pagination > a.next:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .bb-lms-pagination > a.prev:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function render() {
	    global $post;
		
		$current_page_url  = get_permalink( $post->ID );
		$settings          = $this->get_settings();
		$course_box_border = isset( $settings['box_border_style'] ) ? $settings['box_border_style'] : '';
		$settings_skin 	   = $settings['skin_style'];
		$course_cols       = $settings['columns_num'];
		$posts_per_page    = $this->get_settings( 'posts_per_page' );
		$current_page      = ! empty( $_GET['current_page'] ) ? absint( $_GET['current_page'] ) : 1;
		
		add_action( 'pre_get_posts', array( new LearndashHelper(), 'filter_query_ajax_get_courses' ), 999 );
		
		$query = new \WP_Query( [
			'post_type'      => 'sfwd-courses',
			'posts_per_page' => $posts_per_page,
			'paged'          => $current_page
		] );
		
		$view = get_option( 'bb_theme_learndash_grid_list', 'grid' );

		$this->add_render_attribute( 'ld-switch', 'class', 'learndash-course-list learndash-course-list--elementor' );

		$this->add_render_attribute( 'ld-switch', 'class', 'learndash-course-list--' . $settings_skin );

		if ( $settings['switch_featured_row'] ) {
			$this->add_render_attribute( 'ld-switch', 'class', 'learndash-course-list--featured' );
		}

		if ( ! $settings['switch_author'] ) {
			$this->add_render_attribute( 'ld-switch', 'class', 'noMeta' );
		}

		if ( ! $settings['switch_excerpt'] ) {
			$this->add_render_attribute( 'ld-switch', 'class', 'noExcerpt' );
		}

		if ( ! $settings['switch_price'] ) {
			$this->add_render_attribute( 'ld-switch', 'class', 'noPrice' );
		}

		if ( ! $settings['switch_progress'] ) {
			$this->add_render_attribute( 'ld-switch', 'class', 'noProgress' );
		}

		$this->add_render_attribute( 'ld-pagination-switch', 'class', 'bb-lms-pagination' );

		if ( ! $settings['switch_pagination_arrows'] ) {
			$this->add_render_attribute( 'ld-pagination-switch', 'class', 'noPrevNext' );
		}
		?>
		<div id="learndash-content" <?php echo $this->get_render_attribute_string('ld-switch'); ?>>
			<form data-current_page_url="<?php echo esc_url( $current_page_url ); ?>" id="bb-courses-directory-form" class="bb-elementor-widget bb-courses-directory" method="get" action="">

				<div class="ld-secondary-header <?php echo ( 'on' === $settings['orderby_filter'] || ( 'on' === $settings['category_filter'] && '' !== trim( buddyboss_theme()->learndash_helper()->print_categories_options() ) ) || 'on' === $settings['instructors_filter'] || 'on' === $settings['grid_filter'] ) ? 'active' : 'hide'; ?>">
					<div class="bb-secondary-list-tabs flex align-items-center" id="subnav" aria-label="Members directory secondary navigation" role="navigation">
						<input type="hidden" id="course-order" name="order" value="<?php echo ! empty( $_GET['order'] ) ? $_GET['order'] : 'desc'; ?>"/>
						<input type="hidden" id="post-per-page" name="posts_per_page" value="<?php echo $posts_per_page; ?>"/>
						<input type="hidden" id="current-page" name="current_page" value="<?php echo $current_page; ?>"/>
						<div class="sfwd-courses-filters flex push-right">
							<div class="select-wrap <?php echo 'on' === $settings['orderby_filter'] ? 'active' : 'hide'; ?>">
								<select id="sfwd_prs-order-by" name="orderby">
									<?php echo buddyboss_theme()->learndash_helper()->print_sorting_options(); ?>
								</select>
							</div>
							<div class="select-wrap <?php echo 'on' === $settings['category_filter'] ? 'active' : 'hide'; ?>">
								<?php if ( '' !== trim( buddyboss_theme()->learndash_helper()->print_categories_options() ) ) { ?>
									<select id="sfwd_cats-order-by" name="filter-categories">
										<?php echo buddyboss_theme()->learndash_helper()->print_categories_options(); ?>
									</select>
								<?php } ?>
							</div>
							<div class="select-wrap <?php echo 'on' === $settings['instructors_filter'] ? 'active' : 'hide'; ?>">
								<select id="sfwd_instructors-order-by" name="filter-instructors">
									<?php echo buddyboss_theme()->learndash_helper()->print_instructors_options(); ?>
								</select>
							</div>
						</div>

						<div class="grid-filters <?php echo 'on' === $settings['grid_filter'] ? 'active' : 'hide'; ?>" data-view="ld-course">
							<a href="#" class="layout-view layout-view-course layout-grid-view bp-tooltip <?php echo ( 'grid' === $view ) ? esc_attr( 'active' ) : ''; ?>" data-view="grid" data-bp-tooltip-pos="up" data-bp-tooltip="<?php _e( 'Grid View', 'buddyboss-theme' ); ?>">
								<i class="dashicons dashicons-screenoptions" aria-hidden="true"></i>
							</a>

							<a href="#" class="layout-view layout-view-course layout-list-view bp-tooltip <?php echo ( 'list' === $view ) ? esc_attr( 'active' ) : ''; ?>" data-view="list" data-bp-tooltip-pos="up" data-bp-tooltip="<?php _e( 'List View', 'buddyboss-theme' ); ?>">
								<i class="dashicons dashicons-menu" aria-hidden="true"></i>
							</a>
						</div>
					</div>
				</div>

				<div class="grid-view bb-grid grid-box-<?php echo $course_box_border ; ?>">

					<div id="course-dir-list" class="course-dir-list bs-dir-list <?php echo ( $settings['switch_media'] ) ? 'course-dir-list--media' : 'course-dir-list--hidemedia'; ?> <?php echo ( $settings['switch_status'] ) ? 'course-dir-list--status' : 'course-dir-list--hidestatus'; ?>">
						<?php
						if ( $query->have_posts() ) {
							?>
							<ul class="bb-card-list bb-course-items list-view bb-list <?php echo ( 'list' === $view ) ? '' : esc_attr( 'hide' ); ?>" aria-live="assertive" aria-relevant="all">
								<?php
								/* Start the Loop */
								while ( $query->have_posts() ) :
									$query->the_post();

									/*
									* Include the Post-Format-specific template for the content.
									* If you want to override this in a child theme, then include a file
									* called content-___.php (where ___ is the Post Format name) and that will be used instead.
									*/
									get_template_part( 'learndash/ld30/template-course-item' );

								endwhile;
								?>
							</ul>

							<ul class="bb-card-list bb-course-items grid-view bb-grid <?php echo ( 'grid' === $view || $settings_skin == 'cover' ) ? '' : esc_attr( 'hide' ); ?> columns-<?php echo $course_cols; ?>" aria-live="assertive" aria-relevant="all">
								<?php
								/* Start the Loop */
								while ( $query->have_posts() ) :
									$query->the_post();

									/*
									* Include the Post-Format-specific template for the content.
									* If you want to override this in a child theme, then include a file
									* called content-___.php (where ___ is the Post Format name) and that will be used instead.
									*/
									get_template_part( 'learndash/ld30/template-course-item' );

								endwhile;

								wp_reset_postdata();
								?>
							</ul>
							<?php if ($settings['switch_pagination']) : ?>
								<div <?php echo $this->get_render_attribute_string('ld-pagination-switch'); ?>>
									<?php
										$big        = 999999999; // need an unlikely integer
										$translated = __( 'Page', 'buddyboss-theme' ); // Supply translatable string

										echo paginate_links(
											array(
												'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
												'format'  => '?paged=%#%',
												'current' => max( 1, get_query_var( 'paged' ) ),
												'total'   => $query->max_num_pages,
												'before_page_number' => '<span class="screen-reader-text">' . $translated . ' </span>',
											)
										);
									?>
								</div>
							<?php endif; ?>
							<?php
						} else {
							?>
							<aside class="bp-feedback bp-template-notice ld-feedback info">
								<span class="bp-icon" aria-hidden="true"></span>
								<p><?php _e( 'Sorry, no courses were found.', 'buddyboss-theme' ); ?></p>
							</aside>
							<?php
						}
						?>
					</div>
				</div>
			</form>

		</div>

		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	/*protected function _content_template() {
		
	}*/
}
