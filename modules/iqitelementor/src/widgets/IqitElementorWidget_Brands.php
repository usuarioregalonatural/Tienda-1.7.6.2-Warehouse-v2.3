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
 * Class ElementorWidget_Brands
 */
class IqitElementorWidget_Brands
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
    public $editMode = false;


    public function __construct()
    {
        $this->name = IqitElementorWpHelper::__('Brands logos', 'elementor');
        $this->id_base = 'Brands';
        $this->icon = 'carousel';

        $this->context = Context::getContext();

        if (isset($this->context->controller->controller_name) && $this->context->controller->controller_name == 'IqitElementorEditor'){
            $this->editMode = true;
        }
    }

    public function getForm()
    {
        $slidesToShow = range(1, 6);
        $slidesToShow = array_combine($slidesToShow, $slidesToShow);
        $slidesToShow[12] = 12;

        $slidesToShowSlider = range(1, 12);
        $slidesToShowSlider = array_combine($slidesToShowSlider, $slidesToShowSlider);

        $itemsPerColumn = range(1, 12);
        $itemsPerColumn = array_combine($itemsPerColumn, $itemsPerColumn);

        $brands = [];

        if ($this->editMode) {
            $brands = Manufacturer::getManufacturers();
        }

        $brandsOptions = array();
        $brandsSelect = array();
        $brandsOrder = array();

        $brandsSelect[0] = IqitElementorWpHelper::__('Show all', 'elementor');
        $brandsSelect[1] = IqitElementorWpHelper::__('Manual select', 'elementor');

        $brandsOrder[0] = IqitElementorWpHelper::__('Default', 'elementor');
        $brandsOrder[1] = IqitElementorWpHelper::__('Alphabetical', 'elementor');

        foreach ($brands as $brand) {
            $brandsOptions[$brand['id_manufacturer']] = $brand['name'];
        }

        return [
            'section_pswidget_options' => [
                'label' => IqitElementorWpHelper::__('Widget settings', 'elementor'),
                'type' => 'section',
            ],
            'brand_select' => [
                'label' => IqitElementorWpHelper::__('Selection', 'elementor'),
                'type' => 'select',
                'default' => '0',
                'label_block' => true,
                'section' => 'section_pswidget_options',
                'options' => $brandsSelect,
            ],
            'brand_list' => [
                'label' => IqitElementorWpHelper::__('Select brands', 'elementor'),
                'type' => 'select_sort',
                'default' => '0',
                'label_block' => true,
                'multiple' => true,
                'section' => 'section_pswidget_options',
                'options' => $brandsOptions,
                'condition' => [
                    'brand_select' => '1',
                ],
            ],
            'view' => [
                'label' => IqitElementorWpHelper::__('View', 'elementor'),
                'type' => 'select',
                'default' => 'grid',
                'condition' => [
                    'view!' => 'default',
                ],
                'section' => 'section_pswidget_options',
                'options' => [
                    'carousel' => IqitElementorWpHelper::__('Carousel', 'elementor'),
                    'grid' => IqitElementorWpHelper::__('Grid', 'elementor'),
                ],
            ],
            'slides_to_show' => [
                'responsive' => true,
                'label' => IqitElementorWpHelper::__('Show per line', 'elementor'),
                'type' => 'select',
                'default' => '6',
                'label_block' => true,
                'condition' => [
                    'view' => 'grid',
                ],
                'section' => 'section_pswidget_options',
                'options' => $slidesToShow,
            ],
            'slides_to_show_s' => [
                'responsive' => true,
                'label' => IqitElementorWpHelper::__('Show per line', 'elementor'),
                'type' => 'select',
                'default' => '6',
                'label_block' => true,
                'condition' => [
                    'view' => 'carousel',
                ],
                'section' => 'section_pswidget_options',
                'options' => $slidesToShowSlider,
            ],
            'items_per_column' => [
                'label' => IqitElementorWpHelper::__('Items per column', 'elementor'),
                'type' => 'select',
                'default' => '1',
                'condition' => [
                    'view' => 'carousel',
                ],
                'section' => 'section_pswidget_options',
                'options' => $itemsPerColumn,
            ],
            'navigation' => [
                'label' => IqitElementorWpHelper::__('Navigation', 'elementor'),
                'type' => 'select',
                'default' => 'both',
                'condition' => [
                    'view' => 'carousel',
                ],
                'section' => 'section_pswidget_options',
                'options' => [
                    'both' => IqitElementorWpHelper::__('Arrows and Dots', 'elementor'),
                    'arrows' => IqitElementorWpHelper::__('Arrows', 'elementor'),
                    'dots' => IqitElementorWpHelper::__('Dots', 'elementor'),
                    'none' => IqitElementorWpHelper::__('None', 'elementor'),
                ],
            ],
            'autoplay' => [
                'label' => IqitElementorWpHelper::__('Autoplay', 'elementor'),
                'type' => 'select',
                'default' => 'yes',
                'condition' => [
                    'view' => 'carousel',
                ],
                'section' => 'section_pswidget_options',
                'options' => [
                    'yes' => IqitElementorWpHelper::__('Yes', 'elementor'),
                    'no' => IqitElementorWpHelper::__('No', 'elementor'),
                ],
            ],
            'infinite' => [
                'label' => IqitElementorWpHelper::__('Infinite Loop', 'elementor'),
                'type' => 'select',
                'default' => 'yes',
                'condition' => [
                    'view' => 'carousel',
                ],
                'section' => 'section_pswidget_options',
                'options' => [
                    'yes' => IqitElementorWpHelper::__('Yes', 'elementor'),
                    'no' => IqitElementorWpHelper::__('No', 'elementor'),
                ],
            ],
            'section_style_navigation' => [
                'label' => IqitElementorWpHelper::__('Navigation', 'elementor'),
                'type' => 'section',
                'tab' => 'style',
            ],
            'arrows_position' => [
                'label' => IqitElementorWpHelper::__('Arrows position', 'elementor'),
                'type' => 'select',
                'default' => 'middle',
                'tab' => 'style',
                'condition' => [
                    'view' => [ 'carousel'],
                    'navigation' => [ 'both', 'arrows'],
                ],
                'section' => 'section_style_navigation',
                'options' => [
                    'middle' => IqitElementorWpHelper::__('Middle', 'elementor'),
                    'above' => IqitElementorWpHelper::__('Above', 'elementor'),
                ],
            ],
            'arrows_position_top' => [
                'label' => IqitElementorWpHelper::__('Position top', 'elementor'),
                'type' => 'number',
                'default' => '-20',
                'min' => '-100',
                'tab' => 'style',
                'condition' => [
                    'arrows_position' => ['above'],
                ],
                'section' => 'section_style_navigation',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'top: {{VALUE}}px;',
                ],
            ],
            'arrows_color' => [
                'label' => IqitElementorWpHelper::__('Arrows Color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_navigation',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'color: {{VALUE}};',
                ],
            ],
            'arrows_bg_color' => [
                'label' => IqitElementorWpHelper::__('Arrows background', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_navigation',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'background: {{VALUE}};',
                ],
            ],
            'dots_color' => [
                'label' => IqitElementorWpHelper::__('Dots color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_navigation',
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-brands-carousel .slick-dots li button:before' => 'color: {{VALUE}};',
                ],
            ],
        ];
    }

    public function parseOptions($optionsSource, $preview = false)
    {
        $selectedBrands = $optionsSource['brand_list'];
        $brandsType = $optionsSource['brand_select'];
        $brands = [];

        $widgetOptions = [];

        if ($brandsType == 0) {
            $allBrands = Manufacturer::getManufacturers();
             foreach ($allBrands as $brand) {
                $fileExist = file_exists(
                    _PS_MANU_IMG_DIR_ . $brand['id_manufacturer'] . '-' .
                    ImageType::getFormattedName('small') . '.jpg'
                );
                if ($fileExist) {
                    $brands[$brand['id_manufacturer']]['name'] = $brand['name'];
                    $brands[$brand['id_manufacturer']]['link'] = Context::getContext()->link->getManufacturerLink($brand['id_manufacturer'], $brand['link_rewrite']);
                    $brands[$brand['id_manufacturer']]['image'] = Context::getContext()->link->getManufacturerImageLink($brand['id_manufacturer'],
                        'small_default');
                }
            }
        } else {
            if ($selectedBrands){
            foreach ($selectedBrands as $brand) {
                $fileExist = file_exists(
                    _PS_MANU_IMG_DIR_ . $brand . '-' .
                    ImageType::getFormattedName('small') . '.jpg'
                );
                if ($fileExist) {
                    $manufacturer = new Manufacturer($brand, $this->context->language->id);
                    $brands[$brand]['name'] = $manufacturer->name;
                    $brands[$brand]['link'] = Context::getContext()->link->getManufacturerLink($manufacturer);
                    $brands[$brand]['image'] = Context::getContext()->link->getManufacturerImageLink($brand,
                        'small_default');
                }
            }
        }
        }

        $widgetOptions['brands'] = $brands;
        $widgetOptions['view'] = $optionsSource['view'];

        if ($optionsSource['view'] == 'grid') {

            $optionsSource['slides_to_show'] = $this->calculateGrid($optionsSource['slides_to_show']);
            $optionsSource['slides_to_show_tablet'] = $this->calculateGrid($optionsSource['slides_to_show_tablet']);
            $optionsSource['slides_to_show_mobile'] = $this->calculateGrid($optionsSource['slides_to_show_mobile']);

            $widgetOptions['slidesToShow'] = [
                'desktop' => $optionsSource['slides_to_show'],
                'tablet' => $optionsSource['slides_to_show_tablet'],
                'mobile' => $optionsSource['slides_to_show_mobile'],
            ];

        } else {
            $widgetOptions['arrows_position'] = $optionsSource['arrows_position'];

            $show_dots = ( in_array( $optionsSource['navigation'], [ 'dots', 'both' ] ) );
            $show_arrows = ( in_array( $optionsSource['navigation'], [ 'arrows', 'both' ] ) );

            $widgetOptions['options'] = [
                'slidesToShow' => IqitElementorWpHelper::absint( $optionsSource['slides_to_show_s'] ),
                'slidesToScroll' => IqitElementorWpHelper::absint( $optionsSource['slides_to_show_s'] ),
                'slidesToShowTablet' => IqitElementorWpHelper::absint( $optionsSource['slides_to_show_s_tablet'] ),
                'slidesToShowMobile' => IqitElementorWpHelper::absint( $optionsSource['slides_to_show_s_mobile']),
                'navigation' => $optionsSource['navigation'],
                'itemsPerColumn' => $optionsSource['items_per_column'],
                'autoplay' => ( 'yes' === $optionsSource['autoplay'] ),
                'infinite' =>( 'yes' ===  $optionsSource['infinite'] ),
                'arrows' => $show_arrows,
                'dots' => $show_dots,
            ];
        }

        return $widgetOptions;

    }


    public function calculateGrid($nb)
    {
        if ($nb == 0) {
            $nb = 1;
        }

        if ($nb == 5) {
            $nb = 15;
        } else {
            $nb = (12 / $nb);
        }

        return $nb;
    }

}
