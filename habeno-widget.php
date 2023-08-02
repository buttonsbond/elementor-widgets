<?php
/**
 * Plugin Name: Elementor Habeno Mortgage Calculator widget by All Tech Plus, Rojales
 * Description: To easily integrate the Habeno Mortgage Calculator widget into a Wordpress site with Elementor
 * Version: 1.0.5
 * Author: All Tech Plus 2023 - Mark van Bellen - https://all-tech-plus.com
 */
namespace Elementor;
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;


class Habeno_Mortgage_Widget extends Widget_Base {

	public function get_name() {
		return 'habeno-mortgage';
	}

	public function get_title() {
		return __( 'Habeno Mortgage', 'text-domain' );
	}

	public function get_icon() {
		return 'fa fa-calculator';
	}

	public function get_categories() {
		return [ 'ATP' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'text-domain' ),
			]
		);

		$this->add_control(
			'partner_id',
			[
				'label' => __( 'Partner ID', 'text-domain' ),
				'type' => Controls_Manager::TEXT,
				'default' => '4f3165c0-4a3d-4a1a-32ae-08db459bccc4',
			]
		);

		$this->add_control(
			'preferred_theme',
			[
				'label' => __( 'Preferred Theme', 'text-domain' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
                    'active' => true,
                ],
				'default' => 'YOUR_PREFERRED_THEME',
			]
		);

 $this->add_control(
    'property_price',
    [
        'label' => __( 'Property Price', 'elementor-habeno-mortgage' ),
        'type' => Controls_Manager::TEXT,
        'dynamic' => [
            'active' => true,
        ],
    ]
);


		
		$this->add_control(
			'min_property_price',
			[
				'label' => __( 'Min Price', 'text-domain' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
                    'active' => true,
                ],
				'default' => '100000',
			]
		);
		
		$this->add_control(
			'max_property_price',
			[
				'label' => __( 'Max Price', 'text-domain' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
                    'active' => true,
                ],
				'default' => '150000',
			]
		);
		

		$this->end_controls_section();
		
	$this->start_controls_section(
		'section_advanced',
		[
			'label' => __( 'Advanced', 'text-domain' ),
			'tab' => \Elementor\Controls_Manager::TAB_STYLE,
		]
	);

	$this->add_responsive_control(
		'widget_width',
		[
			'label' => __( 'Width', 'text-domain' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%', 'em' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 2000,
					'step' => 1,
				],
				'%' => [
					'min' => 0,
					'max' => 100,
					'step' => 1,
				],
				'em' => [
					'min' => 0,
					'max' => 100,
					'step' => 0.1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} iframe' => 'width: {{SIZE}}{{UNIT}};',
			],
		]
	);

	$this->add_responsive_control(
		'widget_margin',
		[
			'label' => __( 'Margin', 'text-domain' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}} iframe' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_responsive_control(
		'widget_padding',
		[
			'label' => __( 'Padding', 'text-domain' ),
			'type' => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%', 'em' ],
			'selectors' => [
				'{{WRAPPER}} iframe' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

//	$this->add_border_radius();

//	$this->add_border();

//	$this->add_box_shadow();

	$this->end_controls_section();


	}

	protected function render() {
	$settings = $this->get_settings_for_display();
    $partner_id = $settings['partner_id'];
    $preferred_theme = $settings['preferred_theme'];
    $property_price = $settings['property_price'];
    $min_property_price = $settings['min_property_price'];
    $max_property_price = $settings['max_property_price'];
    $url = 'https://widget.v1.habeno.com/mortgage-calculator?partnerId=' . $partner_id . '&type=' . $preferred_theme;

    if ( !empty( $property_price ) ) {
        $url .= '&propertyPrice=' . $property_price;
    } else {
        if ( !empty( $min_property_price ) ) {
            $url .= '&minPropertyPrice=' . $min_property_price;
        }
        if ( !empty( $max_property_price ) ) {
            $url .= '&maxPropertyPrice=' . $max_property_price;
        }
    }
	?>
	<div id="habeno-mortgage-calculator-container">
	    <script type="text/javascript" src="https://widget.v1.habeno.com/mortgage-calculator/script.js" defer></script>
		<iframe id="habeno-mortgage-calculator"
			src="<?php echo $url; ?>"
			aria-label="Habeno calculator widget"
			sandbox="allow-scripts allow-same-origin allow-popups allow-forms allow-popups-to-escape-sandbox allow-top-navigation"
			></iframe>
		<div>POWERED BY <a href="https://habeno.com"> HABENO </a> </div>
	</div>
	<?php
}
}

?>