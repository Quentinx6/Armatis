<?php

namespace BBElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Ld_Activity extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 */
	public function get_name() {
		return 'ld-activity';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'LearnDash Activity', 'buddyboss-theme' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eicon-checkbox';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @return array Widget categories.
	 * @since 1.1.0
	 *
	 * @access public
	 *
	 */
	public function get_categories() {
		return [ 'buddyboss-elements' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function get_script_depends() {
		return array( 'elementor-bb-frontend' );
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
			'no_of_course',
			[
				'label'       => __( 'Number of courses', 'buddyboss-theme' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 10,
				'default'     => '1',
				'description' => __( 'Minimum number of courses: 1', 'buddyboss-theme' ),
			]
		);

		$this->add_control(
			'switch_media',
			[
				'label'   => esc_html__( 'Show Media', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_progress',
			[
				'label'   => esc_html__( 'Show Progress Bar', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'switch_media' => 'yes',
				],
			]
		);

		$this->add_control(
			'switch_course',
			[
				'label'   => esc_html__( 'Show Course Title', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
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
			'switch_dots',
			[
				'label'   => esc_html__( 'Show Dots', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'no_of_course' => [2,3,4,5,6,7,8,9,10]
				],
			]
		);

		$this->add_control(
			'switch_link',
			[
				'label'   => esc_html__( 'Show Link', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'buddyboss-theme' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'Continue', 'buddyboss-theme' ),
				'placeholder' => __( 'Enter button text', 'buddyboss-theme' ),
				'label_block' => true,
				'condition' => [
					'switch_link' => 'yes',
				],
			]
		);

		$this->add_control(
			'switch_my_courses',
			[
				'label'   => esc_html__( 'My Courses Button', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'my_courses_button_text',
			[
				'label' => __( 'Button Text', 'buddyboss-theme' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => __( 'View My Courses', 'buddyboss-theme' ),
				'placeholder' => __( 'Enter button text', 'buddyboss-theme' ),
				'label_block' => true,
				'condition' => [
					'switch_my_courses' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_box',
			[
				'label'     => esc_html__( 'Box', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'box_border',
				'label'       => __( 'Border', 'buddyboss-theme' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bb-la-block',
				'separator'   => 'before',
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
					'{{WRAPPER}} .bb-la-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bb-ldactivity .thumbnail-container img' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bb-ldactivity .thumbnail-container' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bb-la-composer.bb-la--isslick:after' => 'border-radius: 0 {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} 0;',
					'{{WRAPPER}} .bb-ldactivity .bb-la__media:after' => 'border-radius: {{TOP}}{{UNIT}} 0 0 {{LEFT}}{{UNIT}};',
					'@media( max-width: 544px ) { {{WRAPPER}} .bb-ldactivity .thumbnail-container img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0 };',
					'@media( max-width: 544px ) { {{WRAPPER}} .bb-ldactivity .thumbnail-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0 };',
					'@media( max-width: 544px ) { {{WRAPPER}} .bb-ldactivity .bb-la__media:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0 };',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background_color',
				'label' => __( 'Background', 'buddyboss-theme' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bb-la-block',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label'     => __( 'Content', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_padding',
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
					'{{WRAPPER}} .bb-ldactivity .bb-la__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_course_media',
			[
				'label'     => __( 'Media Overlay', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'media_overlay',
				'label' => __( 'Overlay', 'buddyboss-theme' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bb-ldactivity .bb-la__media:after',
			]
		);

		$this->add_control(
			'separator_course_title',
			[
				'label'     => __( 'Course Title', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'course_title_color',
			[
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-la__parent' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'course_title_typography',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-la__parent',
			)
		);

		$this->add_control(
			'course_title_spacing',
			[
				'label'   => __( 'Spacing', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bb-la__parent' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'separator_title',
			[
				'label'     => __( 'Title', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-la__title h2' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-la__title h2',
			)
		);

		$this->add_control(
			'title_spacing',
			[
				'label'   => __( 'Spacing', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bb-la__title h2' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'separator_excerpt',
			[
				'label'     => __( 'Excerpt', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-la__excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'excerpt_typography',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-la__excerpt',
			)
		);

		$this->add_control(
			'excerpt_spacing',
			[
				'label'   => __( 'Spacing', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bb-la__excerpt' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[
				'label'     => __( 'Button', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'switch_link' => 'yes',
				],
			]
		);

		$this->start_controls_tabs(
			'button_tabs'
		);

		$this->start_controls_tab(
			'button_normal_tab',
			array(
				'label' => __( 'Normal', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la__link a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_bgr_color',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la__link a' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'la_button_border_color',
			array(
				'label'     => __( 'Border Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la__link a' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover_tab',
			array(
				'label' => __( 'Hover', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'button_color_hover',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la__link a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_bgr_color_hover',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la__link a:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'la_button_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la__link a:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-la__link a',
			)
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Button Alignment', 'buddyboss-theme' ),
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
				'default' => 'left',
				'prefix_class' => 'elementor-cta-%s-falign-',
			]
		);

		$this->add_control(
			'button_padding',
			[
				'label'      => __( 'Button Padding', 'buddyboss-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '4',
					'right' => '20',
					'bottom' => '4',
					'left' => '20',
				],
				'selectors'  => [
					'{{WRAPPER}} .bb-la__link a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border',
				'label'       => __( 'Button Border', 'buddyboss-theme' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bb-la__link a',
				'separator'   => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_nav',
			[
				'label'     => __( 'Navigation', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'switch_overlap',
			[
				'label'   => esc_html__( 'Course Overlap', 'buddyboss-theme' ),
				'description'   => esc_html__( 'Show courses/lessons overlapped.', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'separator_nav_arrows',
			[
				'label'     => __( 'Arrows', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'arrows_position',
			array(
				'label'      => __( 'Position', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => -50,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => -21,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-la .slick-arrow.bb-slide-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bb-la .slick-arrow.bb-slide-next' => 'right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'arrows_size',
			array(
				'label'      => __( 'Size', 'buddyboss-theme' ),
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
					'size' => 42,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-la .slick-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .slick-arrow i' => 'line-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'arrows_nav'
		);

		$this->start_controls_tab(
			'arrows_normal_nav',
			array(
				'label' => __( 'Normal', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'arrow_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la .slick-arrow i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'arrow_bgr_color',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la .slick-arrow' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrow_hover_nav',
			array(
				'label' => __( 'Hover', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'arrow_color_hover',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la .slick-arrow:hover i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'arrow_bgr_color_hover',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la .slick-arrow:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'arrows_shadow',
				'label'    => __( 'Shadow', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-la .slick-arrow',
			)
		);

		$this->add_control(
			'separator_nav_dots',
			[
				'label'     => __( 'Dots', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'switch_dots' => 'yes',
					'no_of_course' => [2,3,4,5,6,7,8,9,10]
				],
			]
		);

		$this->add_control(
			'dots_active_color',
			[
				'label'     => __( 'Active Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-ldactivity ul.slick-dots li.slick-active button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'switch_dots' => 'yes',
					'no_of_course' => [2,3,4,5,6,7,8,9,10]
				],
			]
		);

		$this->add_control(
			'dots_inactive_color',
			[
				'label'     => __( 'Inactive Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-ldactivity ul.slick-dots li:not(.slick-active) button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'switch_dots' => 'yes',
					'no_of_course' => [2,3,4,5,6,7,8,9,10]
				],
			]
		);

		$this->add_control(
			'dot_size',
			array(
				'label'      => __( 'Size', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 5,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 30,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-ldactivity ul.slick-dots button' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => [
					'switch_dots' => 'yes',
					'no_of_course' => [2,3,4,5,6,7,8,9,10]
				],
			)
		);

		$this->add_responsive_control(
			'dots_alignment',
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
				'default' => 'left',
				'prefix_class' => 'dots-%s-align-',
				'condition' => [
					'switch_dots' => 'yes',
					'no_of_course' => [2,3,4,5,6,7,8,9,10]
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_progress',
			[
				'label'     => __( 'Progress Bar', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'switch_media' => 'yes',
					'switch_progress' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'progress_alignment',
			[
				'label' => __( 'Alignment', 'buddyboss-theme' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'buddyboss-theme' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'buddyboss-theme' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'prefix_class' => 'elementor-cta-%s-ldprogress-',
			]
		);

		$this->add_control(
			'switch_value',
			[
				'label'   => esc_html__( 'Show Progress Value', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_tooltip',
			[
				'label'   => esc_html__( 'Show Tooltip', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'progress_color',
			[
				'label'     => __( 'Active Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-progress .bb-progress-circle' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => __( 'Border Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-lms-progress-wrap--ld-activity .bb-progress:after' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'value_color',
			[
				'label'     => __( 'Progress Value Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-lms-progress-wrap--ld-activity .bb-progress__value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_progress_value',
				'label'    => __( 'Typography Progress Value', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-lms-progress-wrap--ld-activity .bb-progress__value',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_my_courses',
			[
				'label'     => esc_html__( 'My Courses Button', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'switch_my_courses' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'my_alignment',
			[
				'label' => __( 'Button Alignment', 'buddyboss-theme' ),
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
				'prefix_class' => 'elementor-cta-%s-la-my-align-',
			]
		);

		$this->start_controls_tabs(
			'button_my_tabs'
		);

		$this->start_controls_tab(
			'button_my_normal_tab',
			array(
				'label' => __( 'Normal', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'button_my_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la-activity-btn a.bb-la-activity-btn__link' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_my_bgr_color',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la-activity-btn a.bb-la-activity-btn__link' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_ld_border_color',
			array(
				'label'     => __( 'Border Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la-activity-btn a.bb-la-activity-btn__link' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_my_hover_tab',
			array(
				'label' => __( 'Hover', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'button_my_color_hover',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la-activity-btn a.bb-la-activity-btn__link:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_my_bgr_color_hover',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la-activity-btn a.bb-la-activity-btn__link:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_ld_border_color_hover',
			array(
				'label'     => __( 'Border Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-la-activity-btn a.bb-la-activity-btn__link:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_my_typography',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-la-activity-btn a.bb-la-activity-btn__link',
			)
		);

		$this->add_control(
			'button_my_padding',
			[
				'label'      => __( 'Button Padding', 'buddyboss-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '2',
					'right' => '15',
					'bottom' => '2',
					'left' => '15',
				],
				'selectors'  => [
					'{{WRAPPER}} .bb-la-activity-btn a.bb-la-activity-btn__link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_my_border',
				'label'       => __( 'Button Border', 'buddyboss-theme' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bb-la-activity-btn a.bb-la-activity-btn__link',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_my_spacing',
			[
				'label'   => __( 'Spacing', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min'  => 30,
						'max'  => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bb-la-activity-btn' => 'top: -{{SIZE}}px;',
				],
			]
		);

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

		$settings = $this->get_settings();

		global $wpdb; ?>

		<div dir="ltr" class="bb-ldactivity <?php echo ( $settings['switch_my_courses'] ) ? 'bb-ldactivity--ismy' : ''; ?>">

		<?php
		if( is_plugin_active( 'sfwd-lms/sfwd_lms.php' ) ) {
			$no_of_course         = ( isset( $settings ) && isset( $settings['no_of_course'] ) && is_numeric( $settings['no_of_course'] ) ) ? (int) $settings['no_of_course'] : 10;
			$activity_table       = \LDLMS_DB::get_table_name( 'user_activity' );
			$get_courses_activity = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$activity_table} WHERE user_id = %d AND activity_type = %s AND activity_completed = %d ORDER BY activity_updated DESC LIMIT %d", get_current_user_id(), 'course', 0, $no_of_course ) );
			$get_courses_activity_num = count( $get_courses_activity );

			?>

			<?php if ( $no_of_course && is_user_logged_in() ) { ?>

				<?php if ( $settings['switch_my_courses'] ) { ?>
					<div class="bb-la-activity-btn <?php echo ( $no_of_course > 1 ) ? 'bb-la-activity-btn--isslick' : ''; ?>">
						<?php $base_url = get_post_type_archive_link( 'sfwd-courses' ); ?>
						<a class="bb-la-activity-btn__link" href="<?php echo $base_url; ?>?current_page=1&search=&type=my-courses"><?php echo $settings['my_courses_button_text']; ?><i class="bb-icon-angle-right"></i></a>
					</div>
				<?php } ?>

			<?php } ?>

            
			<?php
			if ( $no_of_course && is_user_logged_in() && $get_courses_activity ) { ?>

				<div class="bb-la bb-la-composer <?php echo ( $settings['switch_overlap'] && ( $get_courses_activity_num > 1 ) ) ? 'bb-la__overlap' : 'bb-la__plain'; ?> <?php echo ( $no_of_course > 1 ) ? 'bb-la--isslick' : ''; ?>" data-dots="<?php echo ( $settings['switch_dots'] ) ? 'true' : 'false'; ?>">

				<?php foreach ( $get_courses_activity as $course ) {

					$progress = learndash_course_progress(
						array(
							'user_id'   => $course->user_id,
							'course_id' => $course->course_id,
							'array'     => true,
						)
					);

					$percentage_completed   = $progress['percentage'];
					$course_title           = get_the_title( $course->course_id );
					$course_image           = get_the_post_thumbnail_url( $course->course_id );
					$get_last_activity      = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$activity_table} WHERE user_id = %d AND course_id = %d AND activity_type != %s AND activity_status = %d ORDER BY activity_updated DESC LIMIT %d", get_current_user_id(), $course->course_id, 'course', 0, 1 ) );
					if ( $get_last_activity ) {
						$last_activity_title   = get_the_title( $get_last_activity );
						$excerpt               = get_the_excerpt( $get_last_activity );
						$last_activity_excerpt = '';
						if ( empty( $excerpt ) ) {
							$content_post = get_post( $get_last_activity );
							$content      = $content_post->post_content;
							$content      = apply_filters( 'the_content', $content );
							$excerpt      = str_replace( ']]>', ']]&gt;', $content );
						}
						if ( ! empty( $excerpt ) ) {
							$last_activity_excerpt = wp_trim_excerpt( $excerpt, $get_last_activity );
						}
						$last_activity_continue = get_the_permalink( $get_last_activity );
					} else {
						$get_last_activity = $course->course_id;
						$last_activity_title   = get_the_title( $get_last_activity );
						$excerpt               = get_the_excerpt( $get_last_activity );
						$last_activity_excerpt = '';
						if ( empty( $excerpt ) ) {
							$content_post = get_post( $get_last_activity );
							$content      = $content_post->post_content;
							$content      = apply_filters( 'the_content', $content );
							$excerpt      = str_replace( ']]>', ']]&gt;', $content );
						}
						if ( ! empty( $excerpt ) ) {
							$last_activity_excerpt = wp_trim_excerpt( $excerpt, $get_last_activity );
						}
						$last_activity_continue = get_the_permalink( $get_last_activity );
					}
					?>

					<div class="bb-la-slide">
						<div class="bb-la-block flex">

							<?php if ($settings['switch_media']) : ?>	
								<?php if ($settings['switch_progress']) : ?>
									<div class="bb-la__progress <?php echo ($settings['switch_tooltip']) ? 'bb-la__tooltip' : 'bb-la__notooltip'; ?>">
										<div class="bb-lms-progress-wrap bb-lms-progress-wrap--ld-activity" data-balloon-pos="right" data-balloon="<?php echo $percentage_completed; ?><?php _e( '% Completed', 'buddyboss-theme' ); ?>">
											<div class="bb-progress bb-not-completed" data-percentage="<?php echo $percentage_completed; ?>">
												<span class="bb-progress-left"><span class="bb-progress-circle"></span></span>
												<span class="bb-progress-right"><span class="bb-progress-circle"></span></span>
											</div>
											<?php if ($settings['switch_value']) : ?>
												<span class="bb-progress__value"><?php echo $percentage_completed; ?><?php _e( '%', 'buddyboss-theme' ); ?></span>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
								<div class="bb-la__media">
									<div class="bb-la__thumb">
										<div class="thumbnail-container"><img src="<?php echo $course_image; ?>" /></div>
									</div>
								</div>
							<?php endif; ?>
							<div class="bb-la__body">
								<?php if ($settings['switch_course']) : ?>
									<div class="bb-la__parent"><?php echo $course_title; ?></div>
								<?php endif; ?>
								<div class="bb-la__title"><h2><?php echo $last_activity_title; ?></h2></div>
								<?php if ($settings['switch_excerpt']) : ?>
									<div class="bb-la__excerpt"><?php echo $last_activity_excerpt; ?></div>
								<?php endif; ?>
								<?php if ($settings['switch_link']) : ?>
								<div class="bb-la__link"><a href="<?php echo $last_activity_continue; ?>"><?php echo $settings['button_text']; ?></a></div>
								<?php endif; ?>
							</div>

						</div>
					</div>

					<?php unset( $course ); ?>
				<?php } ?>

				</div>

			<?php } else { ?>

				<div class="bb-ldactivity__blank">
					<div class="bb-no-data bb-no-data--ld-activity">
						<img class="bb-no-data__image" src="<?php echo get_template_directory_uri(); ?>/assets/images/svg/dfy-no-data-icon04.svg" alt="Learndash Activity" />
						<?php if ( is_user_logged_in() ) { ?>
							<div class="bb-no-data__msg"><?php _e( 'You don\'t have any ongoing courses.', 'buddyboss-theme' ); ?></div>
						<?php } else { ?>
							<div class="bb-no-data__msg"><?php _e( 'You are not logged in.', 'buddyboss-theme' ); ?></div>
						<?php } ?>
						<a href="<?php echo esc_url( get_post_type_archive_link('sfwd-courses' ) ); ?>" class="bb-no-data__link"><?php _e( 'Explore Courses', 'buddyboss-theme' ); ?></a>
					</div>
				</div>

			<?php } ?>

			<?php
		} ?>

		</div>

		<?php
	}
}
