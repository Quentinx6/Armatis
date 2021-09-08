<?php
namespace BBElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class BB_Gallery extends Widget_Base {

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
		return 'bb-gallery';
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
		return __( 'Gallery', 'buddyboss-theme' );
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
		return 'eicon-gallery-group';
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
			'section_content_slides',
			[
				'label'     => esc_html__( 'Slides', 'buddyboss-theme' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'buddyboss-theme' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => 'true',
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'item_excerpt',
			[
				'label' => __( 'Excerpt', 'buddyboss-theme' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( '', 'buddyboss-theme' ),
				'placeholder' => __( 'Type your description here', 'buddyboss-theme' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'buddyboss-theme' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'media_list',
			[
				'label' => __( 'Items', 'buddyboss-theme' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Title #1', 'buddyboss-theme' ),
						'item_excerpt' => __( 'Sed augue ipsum, egestas nec, vestibulum et, malesuada adipiscing, dui. Vestibulum dapibus nunc ac augue. Aenean tellus metus, bibendum sed, posuere ac, mattis non, nunc. Aenean imperdiet. Aenean imperdiet.', 'buddyboss-theme' ),
					],
					[
						'title' => __( 'Title #2', 'buddyboss-theme' ),
						'item_excerpt' => __( 'Nunc egestas, augue at pellentesque laoreet, felis eros vehicula leo, at malesuada velit leo quis pede. Proin viverra, ligula sit amet ultrices semper, ligula arcu tristique sapien, a accumsan nisi mauris ac eros. Sed aliquam ultrices mauris. Morbi nec metus. Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi.', 'buddyboss-theme' ),
					],
					[
						'title' => __( 'Title #3', 'buddyboss-theme' ),
						'item_excerpt' => __( 'Morbi mattis ullamcorper velit. Sed hendrerit. Suspendisse enim turpis, dictum sed, iaculis a, condimentum nec, nisi. Vestibulum facilisis, purus nec pulvinar iaculis, ligula mi congue nunc, vitae euismod ligula urna in dolor. Cras dapibus.', 'buddyboss-theme' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_options',
			[
				'label'     => esc_html__( 'Slider Options', 'buddyboss-theme' ),
			]
		);

		$this->add_control(
			'switch_info',
			[
				'label'   => esc_html__( 'Show Description', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_title',
			[
				'label'   => esc_html__( 'Show Title', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => false,
				'condition' => [
					'switch_info' => 'yes',
				],
			]
		);

		$this->add_control(
			'switch_excerpt',
			[
				'label'   => esc_html__( 'Show Excerpt', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'condition' => [
					'switch_info' => 'yes',
				],
			]
		);

		$this->add_control(
			'switch_arrows',
			[
				'label'   => esc_html__( 'Show Navigation Arrows', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_dots',
			[
				'label'   => esc_html__( 'Show Navigation Dots', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_infinite',
			[
				'label'   => esc_html__( 'Infinite Loop', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_slider',
			[
				'label'     => esc_html__( 'Slider', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slider_height',
			array(
				'label'      => __( 'Slider Height', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 50,
						'max'  => 1000,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 500,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-gallery .slick-slide' => 'height: {{SIZE}}{{UNIT}} !important;',
				),
			)
		);

		$this->add_control(
			'slider_gap',
			array(
				'label'      => __( 'Slides Spacing', 'buddyboss-theme' ),
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
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-gallery .slick-slide' => 'margin: 0 {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'center_padding',
			array(
				'label'      => __( 'Center Padding', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 350,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 100,
				),
			)
		);

		$this->add_control(
			'media_size',
			array(
				'label'   => __( 'Media Size', 'buddyboss-theme' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => array(
					'cover' => __( 'Cover', 'buddyboss-theme' ),
					'contain' => __( 'Contain', 'buddyboss-theme' ),
					'auto' => __( 'Auto', 'buddyboss-theme' ),
				),
			)
		);

		$this->add_control(
			'media_bgr_color',
			array(
				'label'     => __( 'Background Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'	=> '#607387',
				'selectors' => array(
					'{{WRAPPER}} .bb-gallery__image' => 'background-color: {{VALUE}}',
				),
				'condition' => [
					'media_size' => 'contain',
				],
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[
				'label'     => esc_html__( 'Content', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_align',
			array(
				'label'   => __( 'Alignment', 'buddyboss-theme' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => __( 'Left', 'buddyboss-theme' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'buddyboss-theme' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'buddyboss-theme' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'default' => 'center',
				'toggle'  => true,
			)
		);

		$this->add_responsive_control(
			'content_v_position',
			[
				'label' => __( 'Vertical Position', 'buddyboss-theme' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'buddyboss-theme' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'buddyboss-theme' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'buddyboss-theme' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'bottom',
				'prefix_class' => 'elementor-cta-%s-content-v-align-',
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label'      => __( 'Content Padding', 'buddyboss-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
				],
				'selectors'  => [
					'{{WRAPPER}} .bb-gallery__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'content_bgr_color',
				'label' => __( 'Background', 'buddyboss-theme' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bb-gallery__body',
			]
		);

		$this->add_control(
			'separator_title',
			array(
				'label'     => __( 'Title', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_title',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-gallery__title h3',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-gallery__title h3' => 'color: {{VALUE}}',
				),
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography_excerpt',
				'label'    => __( 'Typography', 'buddyboss-theme' ),
				'selector' => '{{WRAPPER}} .bb-gallery__excerpt',
			)
		);

		$this->add_control(
			'excerpt_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-gallery__excerpt' => 'color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_nav',
			[
				'label'     => esc_html__( 'Navigation', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'separator_arrows',
			array(
				'label'     => __( 'Arrows', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs(
			'color_arrow_tabs'
		);

		$this->start_controls_tab(
			'color_arrow_normal_tab',
			array(
				'label' => __( 'Normal', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'arrow_item_color',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-arrow i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'arrow_item_bgr',
			array(
				'label'     => __( 'Background', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-arrow' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'color_arrow_hover_tab',
			array(
				'label' => __( 'Hover', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'arrow_item_color_hover',
			array(
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-arrow:hover i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'arrow_item_bgr_hover',
			array(
				'label'     => __( 'Background', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .slick-arrow:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'arrows_position',
			array(
				'label'      => __( 'Position', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => -100,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .slick-arrow.bb-slide-prev' => 'left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .slick-arrow.bb-slide-next' => 'right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'arrows_border_radius',
			[
				'label'      => __( 'Border Radius', 'buddyboss-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '100',
					'right' => '100',
					'bottom' => '100',
					'left' => '100',
				],
				'selectors'  => [
					'{{WRAPPER}} .slick-arrow' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator_dots',
			array(
				'label'     => __( 'Dots', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs(
			'color_dots_tabs'
		);

		$this->start_controls_tab(
			'color_dots_normal_tab',
			array(
				'label' => __( 'Normal', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'dots_item_bgr',
			array(
				'label'     => __( 'Background', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-gallery ul.slick-dots li:not(.slick-active) button' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'color_dots_active_tab',
			array(
				'label' => __( 'Active', 'buddyboss-theme' ),
			)
		);

		$this->add_control(
			'dots_item_bgr_hover',
			array(
				'label'     => __( 'Background', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .bb-gallery ul.slick-dots li.slick-active button' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dots_position',
			array(
				'label'      => __( 'Position', 'buddyboss-theme' ),
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
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .bb-gallery ul.slick-dots' => 'bottom: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .gallery-wrapper' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				),
			)
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

		$settings = $this->get_settings_for_display();
		$settings_center_padding = $settings['center_padding']['size'];
		$settings_media_size = $settings['media_size'];
		$settings_align = $settings['content_align'];

		?>

		<div class="bb-gallery">
			
			<div dir="ltr" class="gallery-wrapper">

				<div class="bb-gallery__run" data-margin="<?php echo $settings_center_padding; ?>px" data-nav="<?php echo ( $settings['switch_arrows'] ) ? 'true' : 'false'; ?>" data-dots="<?php echo ( $settings['switch_dots'] ) ? 'true' : 'false'; ?>" data-loop="<?php echo ( $settings['switch_infinite'] ) ? 'true' : 'false'; ?>">
					<?php foreach ( $settings['media_list'] as $item ) : ?>
						<?php if ( ! empty( $item['title'] ) ) : ?>

							<div class="bb-gallery__slide">
								<div class="bb-gallery__block">
									
									<?php if ( $settings['switch_info'] ) : ?>
										<div class="bb-gallery__body gallery-<?php echo $settings_align; ?>">
											<?php if ( $settings['switch_title'] ) : ?><div class="bb-gallery__title"><h3><?php echo $item['title']; ?></h3></div><?php endif; ?>
											<?php if ( $settings['switch_excerpt'] ) : ?><div class="bb-gallery__excerpt"><?php echo $item['item_excerpt']; ?></div><?php endif; ?>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $item['image']['url'] ) ) : ?>
										<div class="bb-gallery__image">
											<div class="media-container media-container--<?php echo $settings_media_size; ?>" style="background-image: url('<?php echo $item['image']['url']; ?>');"></div>
										</div>
									<?php endif; ?>

								</div>
							</div>

						<?php endif; ?>
					<?php endforeach; ?>
				</div>

			</div>

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
