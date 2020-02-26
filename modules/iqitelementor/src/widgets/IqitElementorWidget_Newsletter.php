<?php
/**
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2015 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Class ElementorWidget_RevolutionSlider
 */
class IqitElementorWidget_Newsletter
{
    /**
     * @var int
     */
    public $id_base;

    /**
     * @var string widget name
     */
    public $name;
    /**
     * @var string widget icon
     */
    public $icon;

    public $status = 1;

    public function __construct()
    {
        if(!Module::isEnabled('ps_emailsubscription'))
        {
            $this->status = 0;
        }

        $this->name = IqitElementorWpHelper::__('Newsletter', 'elementor');
        $this->id_base = 'Newsletter';
        $this->icon = 'email-field';
        $this->context = Context::getContext();
    }

    public function getForm()
    {


        return [
            'section_pswidget_options' => [
                'label' => IqitElementorWpHelper::__('Widget settings', 'elementor'),
                'type' => 'section',
            ],
            'width' => [
                'label' => IqitElementorWpHelper::__( 'Max width', 'elementor' ),
                'type' => 'slider',
                'default' => [
                    'size' => 300,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 250,
                        'max' => 1400,
                    ],
                ],
                'section' => 'section_pswidget_options',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-form' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ],
            'height' => [
                'label' => IqitElementorWpHelper::__( 'Input height', 'elementor' ),
                'type' => 'slider',
                'default' => [
                    'size' => 45,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 25,
                        'max' => 80,
                    ],
                ],
                'section' => 'section_pswidget_options',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-input' => 'min-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-newsletter-btn' => 'min-height: {{SIZE}}{{UNIT}};',

                ],
            ],
            'align' => [
                'label' => IqitElementorWpHelper::__( 'Alignment', 'elementor' ),
                'type' => 'choose',
                'options' => [
                    'left' => [
                        'title' => IqitElementorWpHelper::__( 'Left', 'elementor' ),
                        'icon' => 'align-left',
                    ],
                    'center' => [
                        'title' => IqitElementorWpHelper::__( 'Center', 'elementor' ),
                        'icon' => 'align-center',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .elementor-newsletter-input' => 'text-align: {{VALUE}};',
                ],
                'section' => 'section_pswidget_options',
            ],
            'section_style_input' => [
                'label' => IqitElementorWpHelper::__('Input', 'elementor'),
                'type' => 'section',
                'tab' => 'style',
            ],
            'input_bg' => [
                'label' => IqitElementorWpHelper::__('Background', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_input',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-input' => 'background: {{VALUE}};',
                ],
            ],
            'input_color' => [
                'label' => IqitElementorWpHelper::__('Text color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_input',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-newsletter-input::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-newsletter-input:-ms-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-newsletter-input::placeholder' => 'color: {{VALUE}};',
                ],
            ],
            'input_border' => [
                'group_type_control' => 'border',
                'name' => 'border',
                'label' => IqitElementorWpHelper::__('Border', 'elementor'),
                'tab' => 'style',
                'placeholder' => '1px',
                'default' => '1px',
                'section' => 'section_style_input',
                'selector' => '{{WRAPPER}} .elementor-newsletter-input',
            ],
            'input_bg_hover' => [
                'label' => IqitElementorWpHelper::__('Focus - background', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_input',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-input:focus' => 'background: {{VALUE}};',
                ],
            ],
            'input_color_hover' => [
                'label' => IqitElementorWpHelper::__('Focus - color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_input',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-input:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-newsletter-input:focus::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-newsletter-input:focus:-ms-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-newsletter-input:focus::placeholder' => 'color: {{VALUE}};',
                ],
            ],
            'input_border_h' => [
                'label' => IqitElementorWpHelper::__('Focus - border color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_input',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-input:focus' => 'border-color: {{VALUE}};',
                ],
            ],
            'section_style_btn' => [
                'label' => IqitElementorWpHelper::__('Button', 'elementor'),
                'type' => 'section',
                'tab' => 'style',
            ],
            'btn_bg' => [
                'label' => IqitElementorWpHelper::__('Background', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_btn',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-btn' => 'background: {{VALUE}};',
                ],
            ],
            'btn_color' => [
                'label' => IqitElementorWpHelper::__('Text', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_btn',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-btn' => 'color: {{VALUE}};',
                ],
            ],
            'btn_bg_hover' => [
                'label' => IqitElementorWpHelper::__('Hover - background', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_btn',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-btn:hover' => 'background: {{VALUE}};',
                ],
            ],
            'btn_color_hover' => [
                'label' => IqitElementorWpHelper::__('Hover - text', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_btn',
                'selectors' => [
                    '{{WRAPPER}} .elementor-newsletter-btn:hover' => 'color: {{VALUE}};',
                ],
            ],
        ];
    }

    public function parseOptions($optionsSource, $preview = false){
        $options = array();

        $options['id_module'] = Module::getModuleIdByName('iqitelementor');

        return $options;
    }
}
