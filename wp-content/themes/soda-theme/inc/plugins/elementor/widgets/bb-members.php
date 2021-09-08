<?php
namespace BBElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class BBP_Members extends Widget_Base {

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
		return 'bbp-members';
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
		return __( 'Members', 'buddyboss-theme' );
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
		return 'eicon-person';
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
			'section_content_layout',
			[
				'label'     => esc_html__( 'Layout', 'buddyboss-theme' ),
			]
		);

		$this->add_control(
			'members_order',
			[
				'label'   => esc_html__( 'Default Members Order', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'active',
				'options' => [
					'newest'  => esc_html__('Newest', 'buddyboss-theme'),
					'popular' => esc_html__('Popular', 'buddyboss-theme'),
					'active'  => esc_html__('Active', 'buddyboss-theme'),
				],
			]
		);

		$this->add_control(
			'members_count',
			[
				'label'   => esc_html__( 'Members Count', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
				],
				'range' => [
					'px' => [
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'row_space',
			[
				'label'   => esc_html__( 'Row Space', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bb-members-list__item' => 'margin-bottom: {{SIZE}}px',
				],
			]
		);

		$this->add_control(
			'alignment',
			[
				'label'   => __( 'Alignment', 'buddyboss-theme' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'buddyboss-theme' ),
						'icon'  => 'fas fa-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'buddyboss-theme' ),
						'icon'  => 'fas fa-align-right',
					],
				],
				'default' => 'left',
			]
		);

		$this->add_control(
			'switch_more',
			[
				'label'   => esc_html__( 'Show All Members Link', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_filter',
			[
				'label'   => esc_html__( 'Show Filter Types', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_avatar',
			[
				'label'   => esc_html__( 'Show Avatar', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_name',
			[
				'label'   => esc_html__( 'Show Name', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_status',
			[
				'label'   => esc_html__( 'Show Online Status', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'switch_tooltips',
			[
				'label'   => esc_html__( 'Show Last Activity Tooltips', 'buddyboss-theme' ),
				'description'   => esc_html__( 'Tooltips will be shown on member avatar.', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'switch_avatar' => 'yes',
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
				'selector'    => '{{WRAPPER}} .bb-members',
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
					'{{WRAPPER}} .bb-members' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background_color',
				'label' => __( 'Background', 'buddyboss-theme' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bb-members',
			]
		);

		$this->add_control(
			'separator_all',
			[
				'label'     => __( 'All Members Link', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'extra_color',
			[
				'label'     => __( 'All Members Link Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-block-header__extra a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_filter',
			[
				'label'     => __( 'Filter Types', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'filter_border_style',
			[
				'label'   => __( 'Border Type', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid'  => __( 'Solid', 'buddyboss-theme' ),
					'dashed' => __( 'Dashed', 'buddyboss-theme' ),
					'dotted' => __( 'Dotted', 'buddyboss-theme' ),
					'double' => __( 'Double', 'buddyboss-theme' ),
					'none'   => __( 'None', 'buddyboss-theme' ),
				],
			]
		);

		$this->add_control(
			'filter_border_color',
			[
				'label'     => __( 'Border Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .bb-members div.item-options' => 'border-bottom-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_avatar',
			[
				'label'     => esc_html__( 'Avatar', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'switch_avatar' => 'yes',
				],
			]
		);

		$this->add_control(
			'avatar_width',
			[
				'label'     => __( 'Size', 'buddyboss-theme' ),
				'type'      => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min'  => 20,
						'max'  => 100,
						'step' => 1,
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'avatar_border',
				'label'       => __( 'Border', 'buddyboss-theme' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bb-members-list__avatar img',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'avatar_border_radius',
			[
				'label'      => __( 'Border Radius', 'buddyboss-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .bb-members-list__avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);

		$this->add_control(
			'avatar_opacity',
			[
				'label'   => __( 'Opacity (%)', 'buddyboss-theme' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bb-members-list__avatar img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'avatar_spacing',
			[
				'label' => __( 'Spacing', 'buddyboss-theme' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .bb-members-list--align-left .bb-members-list__item .bb-members-list__avatar'  => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .bb-members-list--align-righ .bb-members-list__item .bb-members-list__avatar'  => 'margin-left: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'separator_online_status',
			[
				'label'     => __( 'Online Status', 'buddyboss-theme' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'online_status_color',
			[
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1CD991',
				'selectors' => [
					'{{WRAPPER}} .member-status.online' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'online_status_width',
			[
				'label'      => __( 'Size', 'buddyboss-theme' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 5,
						'max'  => 30,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 13,
				],
				'selectors'  => [
					'{{WRAPPER}} .member-status.online' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'online_status_border',
				'label'       => __( 'Online Status Border', 'buddyboss-theme' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .member-status.online',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'online_status_border_radius',
			[
				'label'      => __( 'Online Status Border Radius', 'buddyboss-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .member-status.online' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_name',
			[
				'label'     => __( 'Name', 'buddyboss-theme' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'switch_name' => 'yes',
				],
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'     => __( 'Color', 'buddyboss-theme' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#122B46',
				'selectors' => [
					'{{WRAPPER}} .bb-members-list__name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .bb-members-list__name a',
				'scheme'   => Schemes\Typography::TYPOGRAPHY_4,
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

		$settings = $this->get_settings_for_display();
		$type     = $settings['members_order'];

		$avatar = array(
			'type'   => 'full',
			'width'  => esc_attr($settings['avatar_width']['size']),
			'class'  => 'avatar',
		);

		global $members_template; ?>

		<div class="bb-members">

			<div class="bb-block-header flex align-items-center">
				<div class="bb-block-header__title"><h3><?php _e( 'Members', 'buddyboss-theme' ); ?></h3></div>
				<?php if ($settings['switch_more']) : ?>
					<div class="bb-block-header__extra push-right">
						<a href="<?php bp_members_directory_permalink(); ?>" class="count-more"><?php _e( 'All members', 'buddyboss-theme' ); ?><i class="bb-icon-chevron-right"></i></a>
					</div>
				<?php endif; ?>	
			</div>

			<?php $members_type = [
				'active',
				'popular',
				'newest',
			]; ?>

			<?php if ($settings['switch_filter']) : ?>
				<div class="item-options border-<?php echo $settings['filter_border_style']; ?>">
					<?php foreach ( $members_type as $mtype ) { ?>
						<a href="#" id="bb-<?php echo $mtype; ?>-members" class="bb-members__tab <?php echo $mtype == $type ? 'selected' : ''; ?>" data-type="<?php echo $mtype; ?>"><?php echo $mtype; ?></a>
					<?php } ?>
				</div>
			<?php endif; ?>
			
			<div class="bbel-list-flow">
				<?php foreach ( $members_type as $mtype ) {

					// Query members args
					$members_args = array(
						'user_id'         => 0,
						'type'            => esc_attr($mtype),
						'per_page'        => esc_attr($settings['members_count']['size']),
						'max'             => esc_attr($settings['members_count']['size']),
						'populate_extras' => true,
						'search_terms'    => false,
					);

					// Query members
					if ( bp_has_members( $members_args ) ) : ?>

						<div class="bb-members-list bb-members-list--<?php echo $mtype; ?> bb-members-list--align-<?php echo esc_attr($settings['alignment']); ?> <?php echo $mtype == $type ? 'active' : ''; ?>">

							<?php $this->add_render_attribute('bb-member', 'class', 'bb-members-list__item'); ?>

							<?php while ( bp_members() ) : bp_the_member(); ?>

								<div <?php echo $this->get_render_attribute_string('bb-member'); ?>>
									<?php if ($settings['switch_avatar']) : ?>
										<div class="bb-members-list__avatar" <?php if ( $settings['switch_tooltips'] == 'yes' ) { ?>data-balloon-pos="<?php echo ( $settings['alignment'] == 'left' ) ? 'right' : 'left'; ?>" data-balloon="<?php echo bp_get_member_last_active(); ?>"<?php } ?>>
											<a href="<?php bp_member_permalink(); ?>">
												<?php bp_member_avatar($avatar); ?>
											</a>
										</div>
									<?php endif; ?>

									<?php if ($settings['switch_name']) : ?>
										<div class="bb-members-list__name fn"><a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a></div>
									<?php endif; ?>	
									<?php
									$current_time = current_time( 'mysql', 1 );
									$diff         = strtotime( $current_time ) - strtotime( $members_template->member->last_activity );
									if ( $diff < 300 && $settings['switch_status'] ) { // 5 minutes  =  5 * 60
										?>
										<span class="member-status online"></span>
									<?php } ?>
								</div>

							<?php endwhile; ?>
						</div>

					<?php endif; ?>

				<?php } ?>
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
