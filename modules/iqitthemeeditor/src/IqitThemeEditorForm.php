<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

if (!defined('_PS_VERSION_')) {
    exit;
}


class IqitThemeEditorForm
{
    public $module;
    public $cfgName;
    public $systemFonts;
    public $defaults;

    public function __construct()
    {
        $this->cfgName = 'iqitthemeed_';
        $this->module = Module::getInstanceByName('iqitthemeeditor');
        $this->systemFonts = $this->module->systemFonts;
        $this->defaults = $this->module->defaults;
    }

    public function getGeneralForm()
    {
        $globalFields = $this->globalFields('g_');
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->module->l('Layout/Body/Container', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-general'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Layout', 'IqitThemeEditorForm'),
                        'name' => 'g_layout',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'boxed',
                                    'name' => $this->module->l('Boxed', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'wide',
                                    'name' => $this->module->l('Wide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top and bottom margin', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Adds top and bottom margin to main container', 'IqitThemeEditorForm'),
                        'condition' => array(
                            'g_layout' => '==boxed'
                        ),
                        'name' => 'g_margin_tb',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Container box shadow', 'IqitThemeEditorForm'),
                        'name' => 'g_boxshadow',
                        'condition' => array(
                            'g_layout' => '==boxed'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Container border', 'IqitThemeEditorForm'),
                        'name' => 'g_border',
                        'size' => 30,
                        'condition' => array(
                            'g_layout' => '==boxed'
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Container max width', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Set maxium width of page. You must provide px or percent suffix (example 1240px or 100%)', 'IqitThemeEditorForm'),
                        'name' => 'g_max_width',
                        'class' => 'width-150',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Sidebars width', 'IqitThemeEditorForm'),
                        'name' => 'g_sidebars_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'narrow',
                                    'name' => $this->module->l('Narrow', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'wide',
                                    'name' => $this->module->l('Wide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Body background', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    $globalFields['bg_color'],
                    $globalFields['bg_image'],
                    $globalFields['wrapper_start'],
                    $globalFields['bg_repeat'],
                    $globalFields['bg_position'],
                    $globalFields['bg_size'],
                    $globalFields['bg_attachment'],
                    $globalFields['wrapper_end'],

                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }
    public function getHeaderTabForm()
    {
        return array(
            'form' => array(
                'childForms' => array(
                    'iqit-header-layout'  => $this->module->l('Layout', 'IqitThemeEditorForm'),
                    'iqit-header-wrapper'  => $this->module->l('Header wrapper', 'IqitThemeEditorForm'),
                    'iqit-top-bar'  => $this->module->l('Top bar', 'IqitThemeEditorForm'),
                    'iqit-header'  => $this->module->l('Header', 'IqitThemeEditorForm'),
                ),
                'legend' => array(
                    'title' => $this->module->l('Header', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-header-tab'
                ),
            ),
        );
    }
    public function getHeaderWrapperForm()
    {
        $globalFields = $this->globalFields('hw_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Header wrapper', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-header-wrapper'
                ),
                'input' => array(
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Bottom padding', 'IqitThemeEditorForm'),
                        'name' => 'hw_padding_tb',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Width', 'IqitThemeEditorForm'),
                        'name' => 'hw_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'fullwidth',
                                    'name' => $this->module->l('Force Full width', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'inherit',
                                    'name' => $this->module->l('Inherit', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    $globalFields['bg_color'],
                    $globalFields['bg_image'],
                    $globalFields['wrapper_start'],
                    $globalFields['bg_repeat'],
                    $globalFields['bg_position'],
                    $globalFields['bg_size'],
                    $globalFields['bg_attachment'],
                    $globalFields['wrapper_end'],
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border top', 'IqitThemeEditorForm'),
                        'name' => 'hw_border_t',
                        'condition' => array(
                            'h_layout' => '<=1,2,3,4,5'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border bottom', 'IqitThemeEditorForm'),
                        'name' => 'hw_border_b',
                        'condition' => array(
                            'h_layout' => '<=1,2,3,4,5'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border right', 'IqitThemeEditorForm'),
                        'name' => 'hw_border_r',
                        'condition' => array(
                            'h_layout' => '<=6,7'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                        'name' => 'hw_boxshadow',
                        'size' => 30,
                    ),

                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Slider under header (absolute header) - only on homepage', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'condition' => array(
                            'h_layout' => '<=1,2,3,4,5'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Status', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Header will have postion: absolute so it will be shown above content.', 'IqitThemeEditorForm'),
                        'name' => 'h_absolute',
                        'condition' => array(
                            'h_layout' => '<=1,2,3,4,5'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Enabled', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Disable', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Header wrapper bg', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Set some transparent background', 'IqitThemeEditorForm'),
                        'name' => 'h_absolute_wrapper_bg',
                        'size' => 30,
                        'condition' => array(
                            'h_layout' => '<=1,2,3,4,5',
                        ),
                    ),
                    /*
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Header bg', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Set some transparent background', 'IqitThemeEditorForm'),
                        'name' => 'h_absolute_bg',
                        'size' => 30,
                        'condition' => array(
                            'h_layout' => '<=1,2,3,4,5',
                        ),
                    ),
                    */
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getHeaderLayoutForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Layout', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-header-layout'
                ),
                'input' => array(
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Header style', 'IqitThemeEditorForm'),
                        'name' => 'h_layout',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'desktop-headers/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'desktop-headers/style2.png'
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Style 3', 'IqitThemeEditorForm'),
                                    'img' => 'desktop-headers/style3.png'
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => $this->module->l('Style 4', 'IqitThemeEditorForm'),
                                    'img' => 'desktop-headers/style4.png'
                                ),
                                /*
                                array(
                                    'id_option' => 5,
                                    'name' => $this->module->l('Style 5', 'IqitThemeEditorForm'),
                                    'img' => 'desktop-headers/style5.png'
                                ),
                                */
                                array(
                                    'id_option' => 6,
                                    'name' => $this->module->l('Style 6 (header as sidebar)', 'IqitThemeEditorForm'),
                                    'img' => 'desktop-headers/style6.png'
                                ),
                                array(
                                    'id_option' => 7,
                                    'name' => $this->module->l('Style 7 (header as sidebar)', 'IqitThemeEditorForm'),
                                    'img' => 'desktop-headers/style7.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getHeaderForm()
    {
        $globalFields = $this->globalFields('h_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Header', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-header'
                ),
                'input' => array(
                    /*
                    $globalFields['bg_color'],
                    $globalFields['bg_image'],
                    $globalFields['wrapper_start'],
                    $globalFields['bg_repeat'],
                    $globalFields['bg_position'],
                    $globalFields['bg_size'],
                    $globalFields['bg_attachment'],
                    $globalFields['wrapper_end'],
                    */
                    $globalFields['text_color'],
                    $globalFields['link_color'],
                    $globalFields['link_h_color'],
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Options', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top and bottom padding', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Adds top and bottom padding to main container', 'IqitThemeEditorForm'),
                        'name' => 'h_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Logo position', 'IqitThemeEditorForm'),
                        'name' => 'h_logo_position',
                        'condition' => array(
                            'h_layout' => '<=1,2,3,4,5'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'left',
                                    'name' => $this->module->l('Left', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'center',
                                    'name' => $this->module->l('Center', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Sticky header/menu', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Show sticky header during scroll. In 1,2 and 3 header layput only horizontal menu will be sticked', 'IqitThemeEditorForm'),
                        'name' => 'h_sticky',
                        'condition' => array(
                            'h_layout' => '<=1,2,3,4,5'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'menu',
                                    'name' => $this->module->l('Enabled - menu only', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'header',
                                    'name' => $this->module->l('Enabled - entire header', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => '0',
                                    'name' => $this->module->l('Disable', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Sticky element bg', 'IqitThemeEditorForm'),
                        'name' => 'h_sticky_bg',
                        'size' => 30,
                        'condition' => array(
                            'h_layout' => '<=1,2,3,4,5'
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Sticky top and bottom padding', 'IqitThemeEditorForm'),
                        'name' => 'h_sticky_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->module->l('Custom html', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Note: Custom html changes are visible after save.', 'IqitThemeEditorForm'),
                        'name' =>  'h_txt',
                        'lang' => true,
                        'autoload_rte' => true,
                        'cols' => 60,
                        'rows' => 30,
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Search, cart, login', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Icons size', 'IqitThemeEditorForm'),
                        'name' => 'h_icons_size',
                        'min' => 6,
                        'class' => 'width-150',
                        'size' => 30,
                        'suffix' => 'px',
                        'condition' => array(
                            'h_layout' => '<=2,3,4,6'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Icon label', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Show label below icon', 'IqitThemeEditorForm'),
                        'name' => 'h_icons_label',
                        'condition' => array(
                            'h_layout' => '<=2,3,4,6'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Search', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Search style', 'IqitThemeEditorForm'),
                        'name' => 'h_search_type',
                        'condition' => array(
                            'h_layout' => '<=3,4,6'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'full',
                                    'name' => $this->module->l('Fullscreen overlay', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'box',
                                    'name' => $this->module->l('Floating box', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Search width', 'IqitThemeEditorForm'),
                        'name' => 'h_search_width',
                        'size' => 30,
                        'min' => 20,
                        'max' => 100,
                        'class' => 'width-150',
                        'step' => 1,
                        'suffix' => '%',
                        'condition' => array(
                            'h_layout' => '<=1,2'
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Search input background', 'IqitThemeEditorForm'),
                        'name' => 'h_search_input_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Search input text color', 'IqitThemeEditorForm'),
                        'name' => 'h_search_input_txt',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Search input border', 'IqitThemeEditorForm'),
                        'name' => 'h_search_input_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Cart', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'info_text',
                        'desc' => $this->module->l('To configure cart content go to Iqitthemeeditor > options > cart', 'IqitThemeEditorForm'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Cart style', 'IqitThemeEditorForm'),
                        'name' => 'h_cart_type',
                        'condition' => array(
                            'h_layout' => '<=1,5,7'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'one',
                                    'name' => $this->module->l('One line', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'two',
                                    'name' => $this->module->l('Two line', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Cart trigger background', 'IqitThemeEditorForm'),
                        'name' => 'h_cart_trigger_bg',
                        'size' => 30,
                        'condition' => array(
                            'h_layout' => '<=1,5,7'
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Cart trigger text color', 'IqitThemeEditorForm'),
                        'name' => 'h_cart_trigger_txt',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Cart trigger qty bg', 'IqitThemeEditorForm'),
                        'name' => 'h_cart_trigger_qty_bg',
                        'size' => 30,
                        'condition' => array(
                            'h_layout' => '<=2,3,4,6'
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Cart trigger qty txt', 'IqitThemeEditorForm'),
                        'name' => 'h_cart_trigger_qty_txt',
                        'size' => 30,
                        'condition' => array(
                            'h_layout' => '<=2,3,4,6'
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Cart trigger padding', 'IqitThemeEditorForm'),
                        'name' => 'h_cart_trigger_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                        'condition' => array(
                            'h_layout' => '<=1,5,7'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getTopBarForm()
    {
        $globalFields = $this->globalFields('tb_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Top bar', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-top-bar'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Status', 'IqitThemeEditorForm'),
                        'name' => 'tb_status',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Enabled', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Disabled', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Width', 'IqitThemeEditorForm'),
                        'name' => 'tb_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'fullwidth',
                                    'name' => $this->module->l('Force Full width', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'inherit',
                                    'name' => $this->module->l('Inherit', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top and bottom padding', 'IqitThemeEditorForm'),
                        'name' => 'tb_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    $globalFields['bg_color'],
                    $globalFields['bg_image'],
                    $globalFields['wrapper_start'],
                    $globalFields['bg_repeat'],
                    $globalFields['bg_position'],
                    $globalFields['bg_size'],
                    $globalFields['bg_attachment'],
                    $globalFields['wrapper_end'],
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'tb_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                        'name' => 'tb_boxshadow',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Fonts size', 'IqitThemeEditorForm'),
                        'name' => 'tb_font_size',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'suffix' => 'px',
                        'step' => 1,
                    ),
                    $globalFields['text_color'],
                    $globalFields['link_color'],
                    $globalFields['link_h_color'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Social icons', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'info_text',
                        'desc' => $this->module->l('Links you can put in Iqitthemeeditor > options > social media', 'IqitThemeEditorForm'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Social icons', 'IqitThemeEditorForm'),
                        'name' => 'tb_social',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Color type', 'IqitThemeEditorForm'),
                        'name' => 'tb_social_c_t',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Default', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Custom', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Icon color', 'IqitThemeEditorForm'),
                        'name' => 'tb_social_txt',
                        'size' => 30,
                        'condition' => array(
                            'tb_social_c_t' => '<=1',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Color type hover', 'IqitThemeEditorForm'),
                        'name' => 'tb_social_c_t_h',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Default', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Custom', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Icon color hover', 'IqitThemeEditorForm'),
                        'name' => 'tb_social_txt_h',
                        'size' => 30,
                        'condition' => array(
                            'tb_social_c_t_h' => '<=1'
                        ),
                    ),
                    array(
                        'type' => 'range',
                        'label' => $this->module->l('Icon size', 'IqitThemeEditorForm'),
                        'name' => 'tb_social_size',
                        'size' => 30,
                        'min' => 6,
                        'max' => 120,
                        'step' => 1,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getMenuTabForm()
    {
        return array(
            'form' => array(
                'childForms' => array(
                    'iqit-menu-horizontal'  => $this->module->l('Horizontal menu', 'IqitThemeEditorForm'),
                    'iqit-menu-vertical'  => $this->module->l('Vertical menu', 'IqitThemeEditorForm'),
                    'iqit-menu-submenu'  => $this->module->l('Submenu', 'IqitThemeEditorForm'),
                    'iqit-menu-mobile'  => $this->module->l('Mobile menu', 'IqitThemeEditorForm'),
                ),
                'legend' => array(
                    'title' => $this->module->l('Menu', 'IqitThemeEditorForm'),
                    'icon' => 'icon-bars',
                    'id' => 'iqit-menu-tab'
                ),
            ),
        );
    }

    public function getMenuHorizontalForm()
    {

        $globalFields = $this->globalFields('hm_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Horizontal menu', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-menu-horizontal'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Background width', 'IqitThemeEditorForm'),
                        'name' => 'hm_width',
                        'condition' => array(
                            'h_layout' => '<=1,2,3'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'default',
                                    'name' => $this->module->l('Default', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'fullwidth',
                                    'name' => $this->module->l('Full width', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Submenu effect', 'IqitThemeEditorForm'),
                        'name' => 'hm_animation',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'fade',
                                    'name' => $this->module->l('Fade', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'fadebottom',
                                    'name' => $this->module->l('Fade with bottom slide-in', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'fadetop',
                                    'name' => $this->module->l('Fade with top slide-in', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'none',
                                    'name' => $this->module->l('None', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Submenu width', 'IqitThemeEditorForm'),
                        'name' => 'hm_submenu_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'default',
                                    'name' => $this->module->l('Default', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'fullwidth-background',
                                    'name' => $this->module->l('Full width - background only', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'fullwidth',
                                    'name' => $this->module->l('Full width', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    $globalFields['bg_color'],
                    $globalFields['bg_image'],
                    $globalFields['wrapper_start'],
                    $globalFields['bg_repeat'],
                    $globalFields['bg_position'],
                    $globalFields['bg_size'],
                    $globalFields['bg_attachment'],
                    $globalFields['wrapper_end'],
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border top', 'IqitThemeEditorForm'),
                        'name' => 'hm_border_t',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border right', 'IqitThemeEditorForm'),
                        'name' => 'hm_border_r',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border bottom', 'IqitThemeEditorForm'),
                        'name' => 'hm_border_b',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border left', 'IqitThemeEditorForm'),
                        'name' => 'hm_border_l',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Menu height', 'IqitThemeEditorForm'),
                        'name' => 'hm_height',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Tabs', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Align', 'IqitThemeEditorForm'),
                        'name' => 'hm_btn_position',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'left',
                                    'name' => $this->module->l('Left', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'center',
                                    'name' => $this->module->l('Center', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'right',
                                    'name' => $this->module->l('Right', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Arrow', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Show arrow if submenu exist for tab', 'IqitThemeEditorForm'),
                        'name' => 'hm_btn_arrow',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size and style', 'IqitThemeEditorForm'),
                        'name' => 'hm_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Left/right padding', 'IqitThemeEditorForm'),
                        'name' => 'hm_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Font size (below 1300px width)', 'IqitThemeEditorForm'),
                        'name' => 'hm_small_font',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Left/right padding (below 1300px width)', 'IqitThemeEditorForm'),
                        'name' => 'hm_small_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Max width', 'IqitThemeEditorForm'),
                        'name' => 'hm_max_width',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Icon position', 'IqitThemeEditorForm'),
                        'name' => 'hm_btn_icon',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'inline',
                                    'name' => $this->module->l('Inline', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'above',
                                    'name' => $this->module->l('Above', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Icon size', 'IqitThemeEditorForm'),
                        'name' => 'hm_btn_icon_size',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border inner', 'IqitThemeEditorForm'),
                        'name' => 'hm_border_i',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'hm_btn_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Hover text color', 'IqitThemeEditorForm'),
                        'name' => 'hm_btn_color_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Hover background', 'IqitThemeEditorForm'),
                        'name' => 'hm_btn_bg_color_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Legend background', 'IqitThemeEditorForm'),
                        'name' => 'hm_legend_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Legend color', 'IqitThemeEditorForm'),
                        'name' => 'hm_legend_bg_color',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getMenuVerticalForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Vertical menu', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-menu-vertical'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Position/Status', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('You need to save settings to see this option on preview. Hidden option is useful if you put menu in elementor builder on homepage. This settins do not take any effect if you have sidebar header layout enabled.', 'IqitThemeEditorForm'),
                        'name' => 'vm_position',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'leftColumn',
                                    'name' => $this->module->l('Left column (all pages)', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'horizontal',
                                    'name' => $this->module->l('On Horizontal menu (all pages)', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'hiddenHorizontal',
                                    'name' => $this->module->l('Hidden on homepage, visible on horizontal menu on other pages', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'hiddenLeft',
                                    'name' => $this->module->l('Hidden on homepage, visible on left column on other pages', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => '0',
                                    'name' => $this->module->l('Hidden', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Submenu effect', 'IqitThemeEditorForm'),
                        'name' => 'vm_animation',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'fade',
                                    'name' => $this->module->l('Fade', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'none',
                                    'name' => $this->module->l('None', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Submenu equal height', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('If enabled submenu always will start from top, and will have at least same height as tabs', 'IqitThemeEditorForm'),
                        'name' => 'vm_submenu_style',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background', 'IqitThemeEditorForm'),
                        'name' => 'vm_bgcolor',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'vm_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                        'name' => 'vm_boxshadow',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Title', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Title text', 'IqitThemeEditorForm'),
                        'name' => 'vm_title_text',
                        'condition' => array(
                            'vm_position' => '<=hiddenHorizontal,horizontal'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size and style', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Title text you can change in translations', 'IqitThemeEditorForm'),
                        'name' => 'vm_title_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Line height', 'IqitThemeEditorForm'),
                        'name' => 'vm_title_height',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Color', 'IqitThemeEditorForm'),
                        'name' => 'vm_title_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background', 'IqitThemeEditorForm'),
                        'name' => 'vm_title_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Color hover', 'IqitThemeEditorForm'),
                        'name' => 'vm_title_color_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background hover', 'IqitThemeEditorForm'),
                        'name' => 'vm_title_bg_h',
                        'size' => 30,
                    ),

                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Tabs', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Arrow', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Show arrow if submenu exist for tab', 'IqitThemeEditorForm'),
                        'name' => 'vm_btn_arrow',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size and style', 'IqitThemeEditorForm'),
                        'name' => 'vm_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top & bottom padding', 'IqitThemeEditorForm'),
                        'name' => 'vm_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Icon size', 'IqitThemeEditorForm'),
                        'name' => 'vm_btn_icon_size',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border inner', 'IqitThemeEditorForm'),
                        'name' => 'vm_border_i',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'vm_btn_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Hover text color', 'IqitThemeEditorForm'),
                        'name' => 'vm_btn_color_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Hover background', 'IqitThemeEditorForm'),
                        'name' => 'vm_btn_bg_color_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Legend background', 'IqitThemeEditorForm'),
                        'name' => 'vm_legend_bg_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Legend color', 'IqitThemeEditorForm'),
                        'name' => 'vm_legend_color',
                        'size' => 30,
                    ),

                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getMenuSubmenuForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Submenu', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-menu-submenu'
                ),
                'input' => array(
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background', 'IqitThemeEditorForm'),
                        'name' => 'msm_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'msm_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                        'name' => 'msm_boxshadow',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border inner', 'IqitThemeEditorForm'),
                        'name' => 'msm_border_inner',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size and style', 'IqitThemeEditorForm'),
                        'name' => 'msm_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'msm_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color hover', 'IqitThemeEditorForm'),
                        'name' => 'msm_color_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Listing arrows', 'IqitThemeEditorForm'),
                        'name' => 'msm_arrows',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Column titles', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size and style', 'IqitThemeEditorForm'),
                        'name' => 'msm_title_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Color', 'IqitThemeEditorForm'),
                        'name' => 'msm_title_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Color hover', 'IqitThemeEditorForm'),
                        'name' => 'msm_title_color_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'msm_title_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Predefined tabs', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Color', 'IqitThemeEditorForm'),
                        'name' => 'msm_tabs_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background', 'IqitThemeEditorForm'),
                        'name' => 'msm_tabs_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Color hover', 'IqitThemeEditorForm'),
                        'name' => 'msm_tabs_color_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background hover', 'IqitThemeEditorForm'),
                        'name' => 'msm_tabs_bg_h',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getMenuMobileForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Mobile menu', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-menu-mobile'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Type', 'IqitThemeEditorForm'),
                        'name' => 'mm_type',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'dropdown',
                                    'name' => $this->module->l('Dropdown', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'push',
                                    'name' => $this->module->l('Push', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('First level bg', 'IqitThemeEditorForm'),
                        'name' => 'mm_background',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Second level bg', 'IqitThemeEditorForm'),
                        'name' => 'mm_background_l2',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Third level bg', 'IqitThemeEditorForm'),
                        'name' => 'mm_background_l3',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'mm_text',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Inner border', 'IqitThemeEditorForm'),
                        'name' => 'mm_inner_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'mm_border',
                        'size' => 30,
                        'condition' => array(
                            'mm_type' => '==push'
                        ),
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                        'name' => 'mm_boxshadow',
                        'size' => 30,
                        'condition' => array(
                            'mm_type' => '==push'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getContentTabForm()
    {
        return array(
            'form' => array(
                'childForms' => array(
                    'iqit-content-wrapper'  => $this->module->l('Content  wrapper', 'IqitThemeEditorForm'),
                    'iqit-content'  => $this->module->l('Content', 'IqitThemeEditorForm'),
                    'iqit-sidebar'  => $this->module->l('Sidebar', 'IqitThemeEditorForm'),
                    'iqit-products-lists'  => $this->module->l('Products list/Carousels', 'IqitThemeEditorForm'),
                    'iqit-category-page'  => $this->module->l('Category page', 'IqitThemeEditorForm'),
                    'iqit-product-page'  => $this->module->l('Product page', 'IqitThemeEditorForm'),
                    'iqit-brands-page'  => $this->module->l('Brands/Suppliers page', 'IqitThemeEditorForm'),
                ),
                'legend' => array(
                    'title' => $this->module->l('Content/Pages', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-content-tab'
                ),
            ),
        );
    }

    public function getContentWrapperForm()
    {
        $globalFields = $this->globalFields('cw_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Content Wrapper', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-content-wrapper'
                ),
                'input' => array(
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top and bottom padding', 'IqitThemeEditorForm'),
                        'name' => 'cw_padding_tb',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top and bottom padding(on homepage)', 'IqitThemeEditorForm'),
                        'name' => 'cw_index_padding_tb',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    $globalFields['bg_color'],
                    $globalFields['bg_image'],
                    $globalFields['wrapper_start'],
                    $globalFields['bg_repeat'],
                    $globalFields['bg_position'],
                    $globalFields['bg_size'],
                    $globalFields['bg_attachment'],
                    $globalFields['wrapper_end'],
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'cw_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                        'name' => 'cw_boxshadow',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getContentForm()
    {
        $globalFields = $this->globalFields('c_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Content', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-content'
                ),
                'input' => array(
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'c_txt_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Link color', 'IqitThemeEditorForm'),
                        'name' => 'c_link_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Link color - hover', 'IqitThemeEditorForm'),
                        'name' => 'c_link_hover',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Page title', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Title design', 'IqitThemeEditorForm'),
                        'name' => 'c_page_title_layout',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style2.png'
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Style 3', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style3.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Text position', 'IqitThemeEditorForm'),
                        'name' => 'c_page_title_position',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'left',
                                    'name' => $this->module->l('Left', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'center',
                                    'name' => $this->module->l('Center', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Title color', 'IqitThemeEditorForm'),
                        'name' => 'c_page_title_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Title border', 'IqitThemeEditorForm'),
                        'name' => 'c_page_title_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size and style', 'IqitThemeEditorForm'),
                        'name' => 'c_page_title_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Section/widget title', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Title design', 'IqitThemeEditorForm'),
                        'name' => 'c_block_title_layout',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style2.png'
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Style 3', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style3.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Text position', 'IqitThemeEditorForm'),
                        'name' => 'c_block_title_position',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'left',
                                    'name' => $this->module->l('Left', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'center',
                                    'name' => $this->module->l('Center', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Title color', 'IqitThemeEditorForm'),
                        'name' => 'c_block_title_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Title border', 'IqitThemeEditorForm'),
                        'name' => 'c_block_title_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size and style', 'IqitThemeEditorForm'),
                        'name' => 'c_block_title_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Tabs', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Title color', 'IqitThemeEditorForm'),
                        'name' => 'c_tabs_txt',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Title font', 'IqitThemeEditorForm'),
                        'name' => 'c_tabs_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Title border', 'IqitThemeEditorForm'),
                        'name' => 'c_tabs_border_b',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getSidebarForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Sidebar', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-sidebar'
                ),
                'input' => array(
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Block/widget', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background color', 'IqitThemeEditorForm'),
                        'name' => 'sb_block_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'sb_block_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Padding', 'IqitThemeEditorForm'),
                        'name' => 'sb_block_padding',
                        'class' => 'width-150',
                        'min' => 0,
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Block/widget title', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Title design', 'IqitThemeEditorForm'),
                        'name' => 'sb_block_title_layout',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style2.png'
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Style 3', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style3.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Text position', 'IqitThemeEditorForm'),
                        'name' => 'sb_block_title_position',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'left',
                                    'name' => $this->module->l('Left', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'center',
                                    'name' => $this->module->l('Center', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Title color', 'IqitThemeEditorForm'),
                        'name' => 'sb_block_title_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Title border', 'IqitThemeEditorForm'),
                        'name' => 'sb_block_title_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size and style', 'IqitThemeEditorForm'),
                        'name' => 'sb_block_title_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),

                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getProductListForm()
    {
        $boxProduct = $this->productBoxColors('b');
        $boxProductHover = $this->productBoxColors('bh');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Product lists/Carousels', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-products-lists'
                ),
                'input' => array(
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('General Options', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Default view', 'IqitThemeEditorForm'),
                        'name' => 'pl_default_view',
                        'desc' => $this->module->l('On category or manufactuer pages', 'IqitThemeEditorForm'),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'grid',
                                    'name' => $this->module->l('Grid', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'list',
                                    'name' => $this->module->l('List', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Lazdy load', 'IqitThemeEditorForm'),
                        'desc' =>  $this->module->l('Load product images when needed. It will speed up your site', 'IqitThemeEditorForm'),
                        'name' => 'pl_lazyload',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Disabled', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Enabled', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Second image on hover', 'IqitThemeEditorForm'),
                        'name' => 'pl_rollover',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => '0',
                                    'name' => $this->module->l('Disabled', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'fade',
                                    'name' => $this->module->l('Enabled - fade', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'slide',
                                    'name' => $this->module->l('Enabled - slide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Infinity scroll', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Instead of default pagination, next pages will be added to content on scroll', 'IqitThemeEditorForm'),
                        'name' => 'pl_infinity',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Top pagination', 'IqitThemeEditorForm'),
                        'desc' =>  $this->module->l('Show pagination also above product lists', 'IqitThemeEditorForm'),
                        'name' => 'pl_top_pagination',
                        'condition' => array(
                            'pl_infinity' => '!=1'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Faceted search', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Faceted search on center column', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('If enabled Faceted search will be showed above product list. 
                                  It is great for one column layouts. If you enable this you should probably unhook ps_facetedsearch from displayLeftColumn hook
                                  or enable full width layout for category controller'),
                        'name' => 'pl_faceted_position',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Price/Weight slider color', 'IqitThemeEditorForm'),
                        'name' => 'pl_faceted_slider_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Carousels Options', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->module->l('Autoplay', 'IqitThemeEditorForm'),
                        'name' => 'pl_crsl_autoplay',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' =>$this->module->l('Enabled', 'IqitThemeEditorForm')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->module->l('Disabled', 'IqitThemeEditorForm')
                            )
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Arrows', 'IqitThemeEditorForm'),
                        'name' => 'pl_crsl_style',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'middle',
                                    'name' => $this->module->l('In middle of product list', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'hide',
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Arrow background', 'IqitThemeEditorForm'),
                        'name' => 'pl_crsl_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Arrow color', 'IqitThemeEditorForm'),
                        'name' => 'pl_crsl_txt',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->module->l('Dots', 'IqitThemeEditorForm'),
                        'name' => 'pl_crsl_dot',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' =>$this->module->l('Enabled', 'IqitThemeEditorForm')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->module->l('Disabled', 'IqitThemeEditorForm')
                            )
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Dots color', 'IqitThemeEditorForm'),
                        'name' => 'pl_crsl_dot_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Grid', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Products per line - large desktop', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Note: Each column enabled decrease this value by 1. After modifications of this values maybe needed change of home_default image size', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_ld',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 6,
                                    'name' => 6
                                ),
                                array(
                                    'id_option' => 5,
                                    'name' => 5
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => 4
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => 3
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => 2
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Products per line - desktop', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_d',
                        'desc' => $this->module->l('Note: Each column enabled decrease this value by 1. After modifications of this values maybe needed change of home_default image size', 'IqitThemeEditorForm'),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 6,
                                    'name' => 6
                                ),
                                array(
                                    'id_option' => 5,
                                    'name' => 5
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => 4
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => 3
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => 2
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Products per line - tablet', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_t',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 4,
                                    'name' => 4
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => 3
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => 2
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => 1
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Products per line - phone', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_p',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 2,
                                    'name' => 2
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => 1
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Grid layout', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_layout',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Default', 'IqitThemeEditorForm'),
                                    'img' => 'grid-layouts/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Aligned', 'IqitThemeEditorForm'),
                                    'img' => 'grid-layouts/style2.png'
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Just image (info on hover)', 'IqitThemeEditorForm'),
                                    'img' => 'grid-layouts/style3.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Product box margin', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Define gutter between product boxes', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_margin',
                        'size' => 30,
                        'min' => 0,
                        'step' => 1,
                        'suffix' => 'px',
                        'class' => 'width-150',
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Product box padding', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Helpfull when you want to add borders', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_padding',
                        'size' => 30,
                        'min' => 0,
                        'step' => 1,
                        'class' => 'width-150',
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Product text box padding', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Area below product image', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_text_padding',
                        'condition' => array(
                            'pl_grid_layout' => '!=3'
                        ),
                        'size' => 30,
                        'min' => 0,
                        'step' => 1,
                        'class' => 'width-150',
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Product box colors - default', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Overlay background', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_overlay_bg',
                        'size' => 30,
                    ),
                    $boxProduct['border'],
                    $boxProduct['boxshadow'],
                    $boxProduct['colors'],
                    $boxProduct['bg_color'],
                    $boxProduct['text'],
                    $boxProduct['price'],
                    $boxProduct['rating'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Product box colors - hover', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Border color', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_bh_border_c',
                        'desc' => $this->module->l('Border will be visible only if you set it also for normal state', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Outline', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Outline will be visible also if you do not set border for normal state. It is also helpfull in case you want wider border only on hover', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_bh_outline',
                        'size' => 30,
                    ),
                    $boxProductHover['boxshadow'],
                    $boxProductHover['colors'],
                    $boxProductHover['bg_color'],
                    $boxProductHover['text'],
                    $boxProductHover['price'],
                    $boxProductHover['rating'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Options', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Product name font size', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_name_font',
                        'size' => 30,
                        'min' => 0.1,
                        'class' => 'width-150',
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Title length', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_name_line',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Auto', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('One line', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Two line', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Three line', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Product price font size', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_price_font',
                        'size' => 30,
                        'min' => 0.1,
                        'class' => 'width-150',
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Text align', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_align',
                        'condition' => array(
                            'pl_grid_layout' => '==1'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'center',
                                    'name' => $this->module->l('Center', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'left',
                                    'name' => $this->module->l('Left', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Product category name', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Default category of product', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_category_name',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Product brand', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_brand',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Product reference', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_reference',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Buttons', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Add to cart/more info button', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_btn',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Quantity input', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_qty',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Short description', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_desc',
                        'condition' => array(
                            'pl_grid_layout' => '!=3'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Product color snippets', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Show product color attribute', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_colors',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => '0',
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'show',
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    /*
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Discount value', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Show discount value on reduced price label', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_discount_value',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    */
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Functional buttons', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Quick view, compare, wishlist', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_func_btn',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show only on hover', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Add/view buttons', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Button align', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_btn_align',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Default', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Align bottom - one line in all products', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Padding', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_btn_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_btn_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_btn_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_btn_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Hover - background', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_btn_bg_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Hover - text color', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_btn_color_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Hover - border color', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_btn_border_h',
                        'desc' => $this->module->l('Border will be visible only if you set it also for normal state. Tip if you want to have border only for hover in normal state set transparent color', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Functional buttons color', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_functional_bg',
                        'condition' => array(
                            'pl_grid_layout' => '!=3'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'pl_grid_functional_txt',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }
    public function getCategoryPageForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Category page', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-category-page'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Show category image', 'IqitThemeEditorForm'),
                        'name' => 'cat_image',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Category description', 'IqitThemeEditorForm'),
                        'name' => 'cat_desc',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'onimage',
                                    'name' => $this->module->l('Inside category image (if exist and enabled)', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'below',
                                    'name' => $this->module->l('Below product list', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'above',
                                    'name' => $this->module->l('Above product list', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => '0',
                                    'name' => $this->module->l('Hidden', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Subcategories thumbs', 'IqitThemeEditorForm'),
                        'name' => 'cat_sub_thumbs',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Subcategories per line - desktop', 'IqitThemeEditorForm'),
                        'name' => 'cat_sub_thumbs_d',
                        'condition' => array(
                            'cat_sub_thumbs' => '==1'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 2,
                                    'name' => 6
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => 4
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => 3
                                ),
                                array(
                                    'id_option' => 6,
                                    'name' => 2
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Subcategories per line - tablet', 'IqitThemeEditorForm'),
                        'name' => 'cat_sub_thumbs_t',
                        'condition' => array(
                            'cat_sub_thumbs' => '==1'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 2,
                                    'name' => 6
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => 4
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => 3
                                ),
                                array(
                                    'id_option' => 6,
                                    'name' => 2
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Subcategories per line - phone', 'IqitThemeEditorForm'),
                        'name' => 'cat_sub_thumbs_p',
                        'condition' => array(
                            'cat_sub_thumbs' => '==1'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 3,
                                    'name' => 4
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => 3
                                ),
                                array(
                                    'id_option' => 6,
                                    'name' => 2
                                ),
                                array(
                                    'id_option' => 12,
                                    'name' => 1
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Hide on mobile', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('If enabled, description, image and subcategories will be hidden on mobile', 'IqitThemeEditorForm'),
                        'name' => 'cat_hide_mobile',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                )
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }
    public function getProductPageForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Product page', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-product-page'
                ),
                'input' => array(
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Image area', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Width', 'IqitThemeEditorForm'),
                        'name' => 'pp_img_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 3,
                                    'name' => '3/12'
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => '4/12'
                                ),
                                array(
                                    'id_option' => 5,
                                    'name' => '5/12'
                                ),
                                array(
                                    'id_option' => 6,
                                    'name' => '6/12'
                                ),
                                array(
                                    'id_option' => 7,
                                    'name' => '7/12'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Image border', 'IqitThemeEditorForm'),
                        'name' => 'pp_img_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Thumbs position', 'IqitThemeEditorForm'),
                        'name' => 'pp_thumbs',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'left',
                                    'name' => $this->module->l('Left', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'bottom',
                                    'name' => $this->module->l('Bottom', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'leftd',
                                    'name' => $this->module->l('Left(desktop), below(mobile)', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Zoom type', 'IqitThemeEditorForm'),
                        'name' => 'pp_zoom',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'inner',
                                    'name' => $this->module->l('Inner zoom + modal with inner zoom', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'modalzoom',
                                    'name' => $this->module->l('Modal with inner zoom', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Arrows and enlarge text', 'IqitThemeEditorForm'),
                        'name' => 'pp_zoom_ui_txt',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Arrows and enlarge bg', 'IqitThemeEditorForm'),
                        'name' => 'pp_zoom_ui_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Content', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Align center', 'IqitThemeEditorForm'),
                        'name' => 'pp_centered_info',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => 'No'
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => 'Yes'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Price position', 'IqitThemeEditorForm'),
                        'name' => 'pp_price_position',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'below-title',
                                    'name' => $this->module->l('Below title', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'above-button',
                                    'name' => $this->module->l('Above add to cart button ', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Price font', 'IqitThemeEditorForm'),
                        'name' => 'pp_price_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Attributes display', 'IqitThemeEditorForm'),
                        'name' => 'pp_attributes',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'inline',
                                    'name' => $this->module->l('Inline', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'block',
                                    'name' => $this->module->l('Block', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Combination loading', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Show loading icon when combination is changed', 'IqitThemeEditorForm'),
                        'name' => 'pp_preloader',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Right sidebar', 'IqitThemeEditorForm'),
                        'name' => 'pp_sidebar',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hidden', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Normal', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Narrow', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Related products position', 'IqitThemeEditorForm'),
                        'name' => 'pp_accesories',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'tab',
                                    'name' => $this->module->l('Tab', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'footer',
                                    'name' => $this->module->l('Footer', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'sidebar',
                                    'name' => $this->module->l('Sidebar', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Reference position', 'IqitThemeEditorForm'),
                        'name' => 'pp_reference',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'title',
                                    'name' => $this->module->l('With price', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'details',
                                    'name' => $this->module->l('Details tab', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Mancufacturer logo/name position', 'IqitThemeEditorForm'),
                        'name' => 'pp_man_logo',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'tab',
                                    'name' => $this->module->l('In product details tab', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'title',
                                    'name' => $this->module->l('Below title', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'next-title',
                                    'name' => $this->module->l('Next to title(only logo)', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Mancufacturer description tab', 'IqitThemeEditorForm'),
                        'name' => 'pp_man_desc',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Details style', 'IqitThemeEditorForm'),
                        'name' => 'pp_tabs',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'tabh',
                                    'name' => $this->module->l('Tabs horizontal', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'tabha',
                                    'name' => $this->module->l('Tabs horizontal, accordion on phones', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'section',
                                    'name' => $this->module->l('Section', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Tabs title position', 'IqitThemeEditorForm'),
                        'name' => 'pp_tabs_position',
                        'condition' => array(
                            'pp_tabs' => '<=tabh,tabha'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'center',
                                    'name' => $this->module->l('Center', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'left',
                                    'name' => $this->module->l('Left', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'info_text',
                        'condition' => array(
                            'pp_tabs' => '<=tabh,tabha'
                        ),
                        'desc' => $this->module->l('Tabs design you set in Iqitthemeeditor > Content/pages > Content', 'IqitThemeEditorForm'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getBrandsPageForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Brands/Suppliers page', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-brands-page'
                ),
                'input' => array(
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Layout', 'IqitThemeEditorForm'),
                        'name' => 'brands_layout',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'brands/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'brands/style2.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getFooterTabForm()
    {
        return array(
            'form' => array(
                'childForms' => array(
                    'iqit-footer-layout'  => $this->module->l('Footer Layout', 'IqitThemeEditorForm'),
                    'iqit-footer-wrapper'  => $this->module->l('Footer design', 'IqitThemeEditorForm'),
                    'iqit-footer-copyrights'  => $this->module->l('Copyrights', 'IqitThemeEditorForm'),
                ),
                'legend' => array(
                    'title' => $this->module->l('Footer', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-footer-tab'
                ),
            ),
        );
    }

    public function getFooterDesignForm()
    {
        $globalFields = $this->globalFields('fw_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Footer colors', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-footer-wrapper'
                ),
                'input' => array(
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Footer wrapper', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Fixed footer', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('If enabled footer will be hidded behind content and it will show on scroll', 'IqitThemeEditorForm'),
                        'name' => 'f_fixed',
                        'condition' => array(
                            'g_layout' => '==wide'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => true,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => false,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    $globalFields['bg_color'],
                    $globalFields['bg_image'],
                    $globalFields['wrapper_start'],
                    $globalFields['bg_repeat'],
                    $globalFields['bg_position'],
                    $globalFields['bg_size'],
                    $globalFields['bg_attachment'],
                    $globalFields['wrapper_end'],
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Main footer', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border - top', 'IqitThemeEditorForm'),
                        'name' => 'fw_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top and bottom padding', 'IqitThemeEditorForm'),
                        'name' => 'fw_padding_tb',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'fw_text',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Link color', 'IqitThemeEditorForm'),
                        'name' => 'fw_link',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Link hover/active color', 'IqitThemeEditorForm'),
                        'name' => 'fw_link_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Block/widget title', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Visibility', 'IqitThemeEditorForm'),
                        'name' => 'fw_block_title_status',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                        'condition' => array(
                            'f_layout' => '<=4,5'
                        ),
                    ),
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Title design', 'IqitThemeEditorForm'),
                        'name' => 'fw_block_title_layout',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style2.png'
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Style 3', 'IqitThemeEditorForm'),
                                    'img' => 'block-title/style3.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Text position', 'IqitThemeEditorForm'),
                        'name' => 'fw_block_title_position',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'left',
                                    'name' => $this->module->l('Left', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'center',
                                    'name' => $this->module->l('Center', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Title color', 'IqitThemeEditorForm'),
                        'name' => 'fw_block_title_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Title border', 'IqitThemeEditorForm'),
                        'name' => 'fw_block_title_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size and style', 'IqitThemeEditorForm'),
                        'name' => 'fw_block_title_typo',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Newsletter / Social links', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Newsletter', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Newsletter visibility', 'IqitThemeEditorForm'),
                        'name' => 'f_newsletter_status',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border - top', 'IqitThemeEditorForm'),
                        'name' => 'f_top_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top and bottom padding', 'IqitThemeEditorForm'),
                        'name' => 'f_top_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                        'condition' => array(
                            'f_layout' => '<=2,3,4,5'
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Newsletter area bg', 'IqitThemeEditorForm'),
                        'name' => 'f_top_bg',
                        'size' => 30,
                        'condition' => array(
                            'f_layout' => '<=2,3,4,5'
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Newsletter area txt color', 'IqitThemeEditorForm'),
                        'name' => 'f_top_txt',
                        'size' => 30,
                        'condition' => array(
                            'f_layout' => '<=2,3,4,5'
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Input background', 'IqitThemeEditorForm'),
                        'name' => 'f_input_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Input text color', 'IqitThemeEditorForm'),
                        'name' => 'f_input_txt',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Button color', 'IqitThemeEditorForm'),
                        'name' => 'f_input_btn',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Button color hover', 'IqitThemeEditorForm'),
                        'name' => 'f_input_btn_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Input border', 'IqitThemeEditorForm'),
                        'name' => 'f_input_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Social icons', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'info_text',
                        'desc' => $this->module->l('Links you can put in Iqitthemeeditor > options > social media', 'IqitThemeEditorForm'),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Status', 'IqitThemeEditorForm'),
                        'name' => 'f_social_status',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Color type', 'IqitThemeEditorForm'),
                        'name' => 'f_social_c_t',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Default', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Custom', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Icon color', 'IqitThemeEditorForm'),
                        'name' => 'f_social_txt',
                        'size' => 30,
                        'condition' => array(
                            'f_social_c_t' => '<=1'
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Color type hover', 'IqitThemeEditorForm'),
                        'name' => 'f_social_c_t_h',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Default', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Custom', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Icon color hover', 'IqitThemeEditorForm'),
                        'name' => 'f_social_txt_h',
                        'size' => 30,
                        'condition' => array(
                            'f_social_c_t_h' => '<=1'
                        ),
                    ),
                    array(
                        'type' => 'range',
                        'label' => $this->module->l('Icon size', 'IqitThemeEditorForm'),
                        'name' => 'f_social_size',
                        'size' => 30,
                        'min' => 6,
                        'max' => 120,
                        'step' => 1,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getFooterLayoutForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Layout', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-footer-layout'
                ),
                'input' => array(
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Footer style', 'IqitThemeEditorForm'),
                        'name' => 'f_layout',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'footers/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'footers/style2.png'
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Style 3', 'IqitThemeEditorForm'),
                                    'img' => 'footers/style3.png'
                                ),
                                array(
                                    'id_option' => 4,
                                    'name' => $this->module->l('Style 4', 'IqitThemeEditorForm'),
                                    'img' => 'footers/style4.png'
                                ),
                                array(
                                    'id_option' => 5,
                                    'name' => $this->module->l('Style 5', 'IqitThemeEditorForm'),
                                    'img' => 'footers/style5.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getFooterCopyrightForm()
    {
        $globalFields = $this->globalFields('g_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Copyrights', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-footer-copyrights'
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->module->l('Show copyrights', 'IqitThemeEditorForm'),
                        'name' => 'fc_status',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' =>$this->module->l('Yes', 'IqitThemeEditorForm')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->module->l('No', 'IqitThemeEditorForm')
                            )
                        ),
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border top', 'IqitThemeEditorForm'),
                        'name' => 'fc_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top and bottom padding', 'IqitThemeEditorForm'),
                        'name' => 'fc_padding',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background', 'IqitThemeEditorForm'),
                        'name' => 'fc_bg_color',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->module->l('Custom html', 'IqitThemeEditorForm'),
                        'name' =>  'fc_txt',
                        'lang' => true,
                        'autoload_rte' => true,
                        'desc' => $this->module->l('Note: Custom html changes are visible after save.', 'IqitThemeEditorForm'),
                        'cols' => 60,
                        'rows' => 30,
                    ),
                    array(
                        'type' => 'filemanager',
                        'label' => $this->module->l('Image', 'IqitThemeEditorForm'),
                        'name' =>  'fc_img',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }



    public function getMobileForm()
    {
        $globalFields = $this->globalFields('rm_');

        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->module->l('Responsive/Mobile', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-mobile'
                ),
                'input' => array(
                    array(
                        'type' => 'filemanager',
                        'label' => $this->module->l('Retina logo', 'IqitThemeEditorForm'),
                        'desc' =>  $this->module->l('Retina ready logo should be twice bigger than logo uploaded in Preferences > themes', 'IqitThemeEditorForm'),
                        'name' =>  'rm_logo',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'filemanager',
                        'label' => $this->module->l('Apple touch icon', 'IqitThemeEditorForm'),
                        'desc' =>  $this->module->l('Size: 180×180px, .png format', 'IqitThemeEditorForm'),
                        'name' =>  'rm_icon_apple',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'filemanager',
                        'label' => $this->module->l('Android touch icon', 'IqitThemeEditorForm'),
                        'desc' =>  $this->module->l('Size: 192×192px, .png format', 'IqitThemeEditorForm'),
                        'name' =>  'rm_icon_android',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->module->l('Allow pinch to zoom', 'IqitThemeEditorForm'),
                        'desc' =>  $this->module->l('Zoom page with pinch gesture', 'IqitThemeEditorForm'),
                        'name' => 'rm_pinch_zoom',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' =>$this->module->l('Enabled', 'IqitThemeEditorForm')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->module->l('Disabled', 'IqitThemeEditorForm')
                            )
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Browser bar address/header background color', 'IqitThemeEditorForm'),
                        'name' => 'rm_address_bg',
                        'desc' => $this->module->l('You can set mobile browser header/address bar color. It works with Mobile Chrome, Firefox and Opera browsers. ', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Mobile header', 'IqitThemeEditorForm'),
                        'class' => 'title-separator',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Mobile header style', 'IqitThemeEditorForm'),
                        'name' => 'rm_header',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'mobile-headers/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'mobile-headers/style2.png'
                                ),
                                array(
                                    'id_option' => 3,
                                    'name' => $this->module->l('Style 3', 'IqitThemeEditorForm'),
                                    'img' => 'mobile-headers/style3.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Use also on desktops', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('If enable mobile header style replace default desktop header also on computers.', 'IqitThemeEditorForm'),
                        'name' => 'rm_breakpoint',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Fixed positioned header', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Show sticky header during scroll', 'IqitThemeEditorForm'),
                        'name' => 'rm_sticky',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'up',
                                    'name' => $this->module->l('Enable only with scroll up', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'down',
                                    'name' => $this->module->l('Enable', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => '0',
                                    'name' => $this->module->l('Disable', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Padding', 'IqitThemeEditorForm'),
                        'name' => 'rm_padding',
                        'class' => 'width-150',
                        'suffix' => 'px',
                        'size' => 30,
                        'min' => 0,
                        'step' => 1,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Mobile header colors', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $globalFields['bg_color'],
                    $globalFields['boxshadow'],
                    $globalFields['border'],

                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Buttons', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Show button label', 'IqitThemeEditorForm'),
                        'name' => 'rm_link_label',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Padding', 'IqitThemeEditorForm'),
                        'name' => 'rm_link_padding',
                        'class' => 'width-150',
                        'suffix' => 'px',
                        'size' => 30,
                        'min' => 0,
                        'step' => 1,
                        'condition' => array(
                            'rm_header' => '==3'
                        ),
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Buttons border', 'IqitThemeEditorForm'),
                        'name' => 'rm_link_border',
                        'size' => 30,
                        'condition' => array(
                            'rm_header' => '==3'
                        ),
                    ),
                    $globalFields['link_color'],
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Link background', 'IqitThemeEditorForm'),
                        'name' => 'rm_link_bg',
                        'size' => 30,
                        'condition' => array(
                            'rm_header' => '==3'
                        ),
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Buttons(hover)', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),

                    $globalFields['link_h_color'],
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Link hover background', 'IqitThemeEditorForm'),
                        'name' => 'rm_link_h_bg',
                        'size' => 30,
                        'condition' => array(
                            'rm_header' => '==3'
                        ),
                    ),

                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Mobile footer', 'IqitThemeEditorForm'),
                        'class' => 'title-separator',
                        'size' => 30,
                    ),

                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Footer collapse', 'IqitThemeEditorForm'),
                        'name' => 'rm_footer_collapse',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),




                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getOptionsTabForm()
    {
        return array(
            'form' => array(
                'childForms' => array(
                    'iqit-options'  => $this->module->l('Various options', 'IqitThemeEditorForm'),
                    'iqit-typography'  => $this->module->l('Typography', 'IqitThemeEditorForm'),
                    'iqit-cart'  => $this->module->l('Cart', 'IqitThemeEditorForm'),
                    'iqit-buttons'  => $this->module->l('Buttons', 'IqitThemeEditorForm'),
                    'iqit-breadcrumb'  => $this->module->l('Breadcrumb', 'IqitThemeEditorForm'),
                    'iqit-forms'  => $this->module->l('Forms/Drop downs/Tooltips', 'IqitThemeEditorForm'),
                    'iqit-modals'  => $this->module->l('Modals/Float Notifications', 'IqitThemeEditorForm'),
                    'iqit-labels'  => $this->module->l('Labels/Prices/Stars/Alerts', 'IqitThemeEditorForm'),
                    'iqit-social-media' => $this->module->l('Social media', 'IqitThemeEditorForm'),
                ),
                'legend' => array(
                    'title' => $this->module->l('Options/Typography/Global styles', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-options-tab'
                ),
            ),
        );
    }

    public function getModalsForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Modals', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-modals'
                ),
                'input' => array(
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Overlay background color', 'IqitThemeEditorForm'),
                        'name' => 'modals_overlay',
                        'desc' => $this->module->l('Tip: Set some semi transparent color', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Modal content background', 'IqitThemeEditorForm'),
                        'name' => 'modals_bg',
                        'desc' => $this->module->l('Should be same or very similar to your content background', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Modal content border', 'IqitThemeEditorForm'),
                        'name' => 'modals_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Modal content box shadow', 'IqitThemeEditorForm'),
                        'name' => 'modals_boxshadow',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Float notifications', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'info_text',
                        'desc' => $this->module->l('For example add to wishlist, compare', 'IqitThemeEditorForm'),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Notification text color', 'IqitThemeEditorForm'),
                        'name' => 'modals_n_txt',
                        'desc' => $this->module->l('Tip: Set some semi transparent color', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Notification background', 'IqitThemeEditorForm'),
                        'name' => 'modals_n_bg',
                        'desc' => $this->module->l('Should be same or very similar to your content background', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Notification border', 'IqitThemeEditorForm'),
                        'name' => 'modals_n_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Notification box-shadow', 'IqitThemeEditorForm'),
                        'name' => 'modals_n_boxshadow',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }


    public function getOptionsForm()
    {
        $backToTopFields = $this->globalFields('op_to_top_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Various options', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-options'
                ),
                'input' => array(
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Preloader', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Status', 'IqitThemeEditorForm'),
                        'desc' =>  $this->module->l('Show loading spinner before page is fully loaded', 'IqitThemeEditorForm'),
                        'name' => 'op_preloader',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => '0',
                                    'name' => $this->module->l('Disabled', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'pre',
                                    'name' => $this->module->l('Enabled', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Preloader background', 'IqitThemeEditorForm'),
                        'name' => 'op_preloader_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Icon size', 'IqitThemeEditorForm'),
                        'name' => 'op_preloader_size',
                        'class' => 'width-150',
                        'size' => 30,
                        'min' => 5,
                        'condition' => array(
                            'op_preloader' => '==pre'
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Preloader icon color', 'IqitThemeEditorForm'),
                        'name' => 'op_preloader_icon_color',
                        'condition' => array(
                            'op_preloader' => '==pre'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'preloader-select',
                        'label' => $this->module->l('Preloader', 'IqitThemeEditorForm'),
                        'name' => 'op_preloader_icon_pre',
                        'condition' => array(
                            'op_preloader' => '==pre'
                        ),
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'mobile-headers/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'mobile-headers/style2.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Back to top', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Style', 'IqitThemeEditorForm'),
                        'name' => 'op_to_top_style',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Enabled', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Disable', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),

                    $backToTopFields['bg_color'],
                    $backToTopFields['link_color'],
                    $backToTopFields['bg_h_color'],
                    $backToTopFields['link_h_color'],
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Custom scroll bar', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Status', 'IqitThemeEditorForm'),
                        'name' => 'op_scrollbar',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Enabled', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Disable', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Color', 'IqitThemeEditorForm'),
                        'name' => 'op_scrollbar_color',
                        'condition' => array(
                            'op_scrollbar' => '==1'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background color', 'IqitThemeEditorForm'),
                        'name' => 'op_scrollbar_color_bg',
                        'condition' => array(
                            'op_scrollbar' => '==1'
                        ),
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getSocialMediaForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Social media', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-social-media'
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Facebook url', 'IqitThemeEditorForm'),
                        'name' => 'sm_facebook',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Twitter url', 'IqitThemeEditorForm'),
                        'name' => 'sm_twitter',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Youtube url', 'IqitThemeEditorForm'),
                        'name' => 'sm_youtube',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Google url', 'IqitThemeEditorForm'),
                        'name' => 'sm_google',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Instagram url', 'IqitThemeEditorForm'),
                        'name' => 'sm_instagram',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Pinterest url', 'IqitThemeEditorForm'),
                        'name' => 'sm_pinterest',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Vimeo url', 'IqitThemeEditorForm'),
                        'name' => 'sm_vimeo',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Linkedin url', 'IqitThemeEditorForm'),
                        'name' => 'sm_linkedin',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Other', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'filemanager',
                        'label' => $this->module->l('Image(logo) for Facebook sharing', 'IqitThemeEditorForm'),
                        'name' => 'sm_og_logo',
                        'desc' =>  $this->module->l('Minimum size: 200px/200px', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getCartForm()
    {
        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Cart', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-cart'
                ),
                'input' => array(
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Options', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Style', 'IqitThemeEditorForm'),
                        'desc' =>  $this->module->l('Information show after add to cart', 'IqitThemeEditorForm'),
                        'name' => 'cart_style',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'floating',
                                    'name' => $this->module->l('Floating box', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'side',
                                    'name' => $this->module->l('Side cart', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('After add confirmation', 'IqitThemeEditorForm'),
                        'desc' =>  $this->module->l('Information show after add to cart', 'IqitThemeEditorForm'),
                        'name' => 'cart_confirmation',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'modal',
                                    'name' => $this->module->l('Modal window (require action from user)', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'notification',
                                    'name' => $this->module->l('Floating notification', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'open',
                                    'name' => $this->module->l('Open cart box', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Colors', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background color', 'IqitThemeEditorForm'),
                        'name' => 'cart_bg',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'cart_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'boxshadow',
                        'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                        'name' => 'cart_boxshadow',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Inner border color', 'IqitThemeEditorForm'),
                        'name' => 'cart_inner_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'cart_inner_text',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }
    public function getTypographyForm()
    {
        $customFontDesc = '<div class="alert alert-info">' . $this->module->l('You have to copy your custom fonts files by ftp to modules/iqitthemeeditor/views/fonts and then put similar code in field above. Please note that the path(url) must be ../fonts/fontname.eot', 'IqitThemeEditorForm') . '<pre>
        @font-face {
        font-family: \'MyWebFont\';
        src: url(\'../fonts/webfont.eot\');
        src: url(\'../fonts/webfont.eot?#iefix\') format(\'embedded-opentype\'),
        url(\'../fonts/webfont.woff2\') format(\'woff2\'),
        url(\'../fonts/webfont.woff\') format(\'woff\'),
        url(\'../fonts/webfont.ttf\')  format(\'truetype\'),
        url(\'../fonts/webfont.svg#svgFontName\') format(\'svg\');
        }
        </pre>
        </div>';

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Typography', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-typography'
                ),
                'input' => array(
                    array(
                        'type' => 'textarea2',
                        'label' => $this->module->l('Custom font face include', 'IqitThemeEditorForm'),
                        'desc' => $customFontDesc,
                        'name' => 'typo_font_include',
                        'descFront' => $this->module->l('If you want to use custom font you need to include it first in backoffice part of theme editor. On front editor field is just for preview.', 'IqitThemeEditorForm'),
                        'disableFront' => true,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Include Material Icons', 'IqitThemeEditorForm'),
                        'name' => 'typo_material',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Base font', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Base font type', 'IqitThemeEditorForm'),
                        'name' => 'typo_bfont_t',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'google',
                                    'name' => $this->module->l('Google font', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'system',
                                    'name' => $this->module->l('System font', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'custom',
                                    'name' => $this->module->l('Custom', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Google font url', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Example: //fonts.googleapis.com/css?family=Open+Sans:400,700 Add 400 and 700 font weigh if exist. If you need adds latin-ext or cyrilic too.'). '<a href="https://www.google.com/fonts" target="_blank">'.$this->module->l('Check google font database', 'IqitThemeEditorForm').'</a>',
                        'name' => 'typo_bfont_g_url',
                        'condition' => array(
                            'typo_bfont_t' => '==google'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Google font family', 'IqitThemeEditorForm'),
                        'desc' => $this->module->getTranslator()->trans('Example: \'Montserrat\', sans-serif', array(), 'Modules.IqitThemeEditor.Admin'),
                        'name' => 'typo_bfont_g_name',
                        'condition' => array(
                            'typo_bfont_t' => '==google'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Custom font tame', 'IqitThemeEditorForm'),
                        'desc' => $this->module->getTranslator()->trans('Example: \'Montserrat\', sans-serif', array(), 'Modules.IqitThemeEditor.Admin'),
                        'name' => 'typo_bfont_c_name',
                        'condition' => array(
                            'typo_bfont_t' => '==custom'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('System font', 'IqitThemeEditorForm'),
                        'name' => 'typo_bfont_s_name',
                        'min' => 6,
                        'condition' => array(
                            'typo_bfont_t' => '==system'
                        ),
                        'options' => array(
                            'query' => $this->systemFonts,
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Base font size', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Base font size is defined in px. It is default font size of template. Other elements of template are calculated to rem values. 1rem = your_definied_base_size.', 'IqitThemeEditorForm'),
                        'name' => 'typo_bfont_size',
                        'class' => 'width-150',
                        'min' => 6,
                        'size' => 30,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Line height', 'IqitThemeEditorForm'),
                        'name' => 'typo_bfont_lineheight',
                        'class' => 'width-150',
                        'min' => 0.5,
                        'step' => 0.1,
                        'size' => 30,
                        'suffix' => 'rem'
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Base font size mobile', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Font size for device with width less than 768px', 'IqitThemeEditorForm'),
                        'name' => 'typo_bfont_size_m',
                        'class' => 'width-150',
                        'size' => 30,
                        'min' => 6,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Headlines', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Headline font type', 'IqitThemeEditorForm'),
                        'name' => 'typo_hfont_t',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'same',
                                    'name' => $this->module->l('Same as base', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'google',
                                    'name' => $this->module->l('Google font', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'system',
                                    'name' => $this->module->l('System font', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'custom',
                                    'name' => $this->module->l('Custom', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Google font url', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Example: //fonts.googleapis.com/css?family=Open+Sans:400,700 Add 400 and 700 font weigh if exist. If you need adds latin-ext or cyrilic too.'). '<a href="https://www.google.com/fonts" target="_blank">'.$this->module->l('Check google font database', 'IqitThemeEditorForm').'</a>',
                        'name' => 'typo_hfont_g_url',
                        'condition' => array(
                            'typo_hfont_t' => '==google'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Google font family', 'IqitThemeEditorForm'),
                        'desc' => $this->module->getTranslator()->trans('Example: \'Montserrat\', sans-serif', array(), 'Modules.IqitThemeEditor.Admin'),
                        'name' => 'typo_hfont_g_name',
                        'condition' => array(
                            'typo_hfont_t' => '==google'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->module->l('Custom font tame', 'IqitThemeEditorForm'),
                        'desc' => $this->module->getTranslator()->trans('Example: \'Montserrat\', sans-serif', array(), 'Modules.IqitThemeEditor.Admin'),
                        'name' => 'typo_hfont_c_name',
                        'condition' => array(
                            'typo_hfont_t' => '==custom'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('System font', 'IqitThemeEditorForm'),
                        'name' => 'typo_hfont_s_name',
                        'condition' => array(
                            'typo_hfont_t' => '==system'
                        ),
                        'options' => array(
                            'query' => $this->systemFonts,
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'info_text',
                        'desc' => $this->module->l('It is font of main page title, section titles and block titles. 
                        Size and other properties you can set in content and footer sections'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }
    public function getButtonsForm()
    {
        $default = $this->basicColorsFields('btn', 'default');
        $action = $this->basicColorsFields('btn', 'action');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Buttons', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-buttons'
                ),
                'input' => array(
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Default button', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Normal', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    $default['bg'],
                    $default['txt'],
                    $default['border'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Hover', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $default['bg_h'],
                    $default['txt_h'],
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Border color', 'IqitThemeEditorForm'),
                        'name' => 'btn_default_border_h',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Action/confirmation button', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Normal', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $action['bg'],
                    $action['txt'],
                    $action['border'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Hover', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $action['bg_h'],
                    $action['txt_h'],
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Border color', 'IqitThemeEditorForm'),
                        'name' => 'btn_action_border_h',
                        'size' => 30,
                    ),

                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }
    public function getBreadcrumbForm()
    {
        $globalFields = $this->globalFields('bread_');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Breadcrumb', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-breadcrumb'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Status', 'IqitThemeEditorForm'),
                        'name' => 'bread_status',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Visible', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hidden', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Width', 'IqitThemeEditorForm'),
                        'name' => 'bread_width',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 'fullwidth-bg',
                                    'name' => $this->module->l('Full width background only', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'fullwidth',
                                    'name' => $this->module->l('Full width', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 'inherit',
                                    'name' => $this->module->l('Inherit', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Top and bottom padding', 'IqitThemeEditorForm'),
                        'name' => 'bread_padding_tb',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'number',
                        'label' => $this->module->l('Left and right padding', 'IqitThemeEditorForm'),
                        'name' => 'bread_padding_lr',
                        'size' => 30,
                        'min' => 0,
                        'class' => 'width-150',
                        'step' => 1,
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font', 'IqitThemeEditorForm'),
                        'name' => 'bread_font',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'name' => 'bread_txt',
                        'size' => 30,
                    ),
                    $globalFields['bg_color'],
                    $globalFields['bg_image'],
                    array(
                        'type' => 'switch',
                        'label' => $this->module->l('Replace background image with category image (if exist)', 'IqitThemeEditorForm'),
                        'name' => 'bread_bg_category',
                        'is_bool' => true,
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => 1,
                                'label' =>$this->module->l('Enabled', 'IqitThemeEditorForm')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => 0,
                                'label' => $this->module->l('Disabled', 'IqitThemeEditorForm')
                            )
                        ),
                    ),
                    $globalFields['wrapper_start'],
                    $globalFields['bg_repeat'],
                    $globalFields['bg_position'],
                    $globalFields['bg_size'],
                    $globalFields['bg_attachment'],
                    $globalFields['wrapper_end'],
                    $globalFields['boxshadow'],


                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }
    public function getFormsForm()
    {
        $input = $this->basicColorsFields('form', 'input');
        $radio = $this->basicColorsFields('form', 'radio');
        $dropDown = $this->basicColorsFields('form', 'dropdown');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Forms', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-forms'
                ),
                'input' => array(
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Text input/select boxes - normal', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $input['bg'],
                    $input['txt'],
                    $input['border'],
                    $input['boxshadow'],
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Text input/select boxes - focus', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $input['bg_h'],
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Border color', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Tip: if you want to have a border only on hover, in normal state select border different than none and give it transparent color', 'IqitThemeEditorForm'),
                        'name' => 'form_input_border_c_h',
                        'size' => 30,
                    ),
                    $input['boxshadow_h'],
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Checkboxs/radio buttons', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Tick mark color', 'IqitThemeEditorForm'),
                        'name' => 'form_radio_checked',
                        'size' => 30,
                    ),
                    $radio['bg'],
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                        'name' => 'form_radio_border',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Dropdowns', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'info_text',
                        'desc' => $this->module->l('For example language or currency drop down.', 'IqitThemeEditorForm'),
                    ),
                    $dropDown['bg'],
                    $dropDown['txt'],
                    $dropDown['border'],
                    $dropDown['boxshadow'],
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Tooltip', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Tooltip is a small label showed on hover, for example above colorpickers or some small buttons', 'IqitThemeEditorForm'),
                        'name' => 'form_tooltip_txt',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Background color', 'IqitThemeEditorForm'),
                        'name' => 'form_tooltip_bg',
                        'size' => 30,
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }
    public function getLabelsForm()
    {
        $new_l = $this->basicColorsFields('lp', 'new_l');
        $sale_l = $this->basicColorsFields('lp', 'sale_l');
        $online_l = $this->basicColorsFields('lp', 'online_l');
        $instock_l = $this->basicColorsFields('lp', 'intstock_l');
        $outstock_l = $this->basicColorsFields('lp', 'outstock_l');

        $alert_s = $this->basicColorsFields('lp', 'alert_s');
        $alert_i = $this->basicColorsFields('lp', 'alert_i');
        $alert_w = $this->basicColorsFields('lp', 'alert_w');
        $alert_d = $this->basicColorsFields('lp', 'alert_d');

        return array(
            'form' => array(
                'child' => true,
                'legend' => array(
                    'title' => $this->module->l('Labels/Alerts/Prices', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-labels'
                ),
                'input' => array(
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Price/stars', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Price color', 'IqitThemeEditorForm'),
                        'name' => 'lp_price',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Rating stars color', 'IqitThemeEditorForm'),
                        'name' => 'lp_ratings',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Product stickers', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'font',
                        'label' => $this->module->l('Font size', 'IqitThemeEditorForm'),
                        'name' => 'lp_label_font',
                        'size' => 30,
                        'class' => 'width-150',
                        'min' => 1,
                        'suffix' => 'px'
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('New Label', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $new_l['bg'],
                    $new_l['txt'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Sale Label', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $sale_l['bg'],
                    $sale_l['txt'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Online & pack label', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $online_l['bg'],
                    $online_l['txt'],
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Stock labels', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('In stock Label', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $instock_l['bg'],
                    $instock_l['txt'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Out of stock Label', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $outstock_l['bg'],
                    $outstock_l['txt'],
                    array(
                        'type' => 'title_separator',
                        'label' => $this->module->l('Alerts', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'border_top' => true
                    ),
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Success', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $alert_s['bg'],
                    $alert_s['txt'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Info', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $alert_i['bg'],
                    $alert_i['txt'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Warning', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $alert_w['bg'],
                    $alert_w['txt'],
                    array(
                        'type' => 'subtitle_separator',
                        'label' => $this->module->l('Danger', 'IqitThemeEditorForm'),
                        'size' => 30,
                    ),
                    $alert_d['bg'],
                    $alert_d['txt'],
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }
    public function getCodesForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->module->l('Custom Css/Js/Codes', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-codes'
                ),
                'input' => array(
                    array(
                        'type' => 'code_textarea',
                        'label' => $this->module->l('Custom Css code', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'name' =>  'codes_css',
                        'class' => 'iqit-code-editor',
                        'language' => 'css'
                    ),
                    array(
                        'type' => 'code_textarea',
                        'label' => $this->module->l('Custom Js code', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'name' =>  'codes_js',
                        'class' => 'iqit-code-editor',
                        'language' => 'javascript',
                        'descFront' => $this->module->l('Code will be executed only after you save changes and refresh page.', 'IqitThemeEditorForm'),
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->module->l('Code before </head> tag', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Note: Code is not visible in themeeditor mode', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'name' =>  'codes_head',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->module->l('Code before </body> tag', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Note: Code is not visible in themeeditor mode', 'IqitThemeEditorForm'),
                        'size' => 30,
                        'name' =>  'codes_body',
                    ),


                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }


    public function getMaintanceForm()
    {
        $globalFields = $this->globalFields('mcs_');

        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->module->l('Maintenance/Coming soon', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-maintenance'
                ),
                'description' => $this->module->l('In this panel you configure style of Prestashop Maintenance page. To turn your shop into Maintenance mode, go to Shop parametrs > General > Maintenance.
                 Titles and countdown can be translated by default Prestsahop translation tool. '),
                'input' => array(
                    array(
                        'type' => 'image-select',
                        'label' => $this->module->l('Layout', 'IqitThemeEditorForm'),
                        'name' => 'mcs_layout',
                        'direction' => 'vertical',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Style 1', 'IqitThemeEditorForm'),
                                    'img' => 'maintenance/style1.png'
                                ),
                                array(
                                    'id_option' => 2,
                                    'name' => $this->module->l('Style 2', 'IqitThemeEditorForm'),
                                    'img' => 'maintenance/style2.png'
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    $globalFields['bg_color'],
                    $globalFields['bg_image'],
                    $globalFields['wrapper_start'],
                    $globalFields['bg_repeat'],
                    $globalFields['bg_position'],
                    $globalFields['bg_size'],
                    $globalFields['bg_attachment'],
                    $globalFields['wrapper_end'],
                    $globalFields['text_color'],

                    array(
                        'type' => 'filemanager',
                        'label' => $this->module->l('Logo replacement', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Use this field to replace default logo.', 'IqitThemeEditorForm'),
                        'name' => 'mcs_logo',
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Header (logo section) bg', 'IqitThemeEditorForm'),
                        'name' => 'mcs_header_bg',
                        'condition' => array(
                            'mcs_layout' => '==2'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Header (logo section) txt color', 'IqitThemeEditorForm'),
                        'name' => 'mcs_header_txt',
                        'condition' => array(
                            'mcs_layout' => '==2'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Countdown', 'IqitThemeEditorForm'),
                        'name' => 'mcs_countdown',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Disabled', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Enabled', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'datetime',
                        'label' => $this->module->l('Date for countdown', 'IqitThemeEditorForm'),
                        'name' => 'mcs_date',
                        'condition' => array(
                            'mcs_countdown' => '==1'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Newsletter', 'IqitThemeEditorForm'),
                        'name' => 'mcs_newsletter',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Disabled', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Enabled', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Newsletter field bg', 'IqitThemeEditorForm'),
                        'name' => 'mcs_form_bg',
                        'condition' => array(
                            'mcs_newsletter' => '==1'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Newsletter field txt', 'IqitThemeEditorForm'),
                        'name' => 'mcs_form_txt',
                        'condition' => array(
                            'mcs_newsletter' => '==1'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'border',
                        'label' => $this->module->l('Newsletter field border', 'IqitThemeEditorForm'),
                        'name' => 'mcs_form_border',
                        'condition' => array(
                            'mcs_newsletter' => '==1'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Newsletter button bg', 'IqitThemeEditorForm'),
                        'name' => 'mcs_button_bg',
                        'condition' => array(
                            'mcs_newsletter' => '==1'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Newsletter button text', 'IqitThemeEditorForm'),
                        'name' => 'mcs_button_txt',
                        'condition' => array(
                            'mcs_newsletter' => '==1'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Newsletter button hover bg', 'IqitThemeEditorForm'),
                        'name' => 'mcs_button_bg_h',
                        'condition' => array(
                            'mcs_newsletter' => '==1'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'color2',
                        'label' => $this->module->l('Newsletter button hover text', 'IqitThemeEditorForm'),
                        'name' => 'mcs_button_txt_h',
                        'condition' => array(
                            'mcs_newsletter' => '==1'
                        ),
                        'size' => 30,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Social buttons', 'IqitThemeEditorForm'),
                        'desc' => $this->module->l('Links you can put in Iqitthemeeditor > options > social media', 'IqitThemeEditorForm'),
                        'name' => 'mcs_social',
                        'options' => array(
                            'query' => array(
                                array(
                                    'id_option' => 0,
                                    'name' => $this->module->l('Hide', 'IqitThemeEditorForm'),
                                ),
                                array(
                                    'id_option' => 1,
                                    'name' => $this->module->l('Show', 'IqitThemeEditorForm'),
                                ),
                            ),
                            'id' => 'id_option',
                            'name' => 'name',
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->module->l('Save', 'IqitThemeEditorForm'),
                ),
            ),
        );
    }

    public function getImportExportForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->module->l('Import/Export configuration', 'IqitThemeEditorForm'),
                    'icon' => 'icon-cogs',
                    'id' => 'iqit-import_export'
                ),
                'input' => array(
                    array(
                        'type' => 'import_export',
                        'label' => $this->module->l('Import Export', 'IqitThemeEditorForm'),
                        'name' =>  'import_export',
                    ),
                ),
            ),
        );
    }
    public function globalFields($prefix)
    {
        return[
            'bg_color' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Background color', 'IqitThemeEditorForm'),
                'name' => $prefix . 'bg_color',
                'size' => 30,
            ),
            'bg_h_color' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Hover Background color', 'IqitThemeEditorForm'),
                'name' => $prefix . 'bg_h_color',
                'size' => 30,
            ),

            'bg_image' =>  array(
                'type' => 'filemanager',
                'label' => $this->module->l('Background image', 'IqitThemeEditorForm'),
                'desc' => $this->module->l('There is absolute path used for images, make sure it is with https:// and there is no special characters in path or filename.', 'IqitThemeEditorForm'),
                'name' => $prefix . 'bg_image',
                'size' => 30,
            ),
            'wrapper_start' =>  array(
                'type' => 'wrapper_start',
                'size' => 30,
            ),
            'bg_repeat' =>  array(
                'type' => 'select',
                'label' => $this->module->l('Repeat', 'IqitThemeEditorForm'),
                'name' => $prefix . 'bg_repeat',
                'condition' => array(
                    $prefix . 'bg_image' => '!= '
                ),
                'options' => array(
                    'query' => array(
                        array(
                            'id_option' => 'repeat',
                            'name' => $this->module->l('repeat', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'repeat-x',
                            'name' => $this->module->l('repeat-x', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'repeat-y',
                            'name' => $this->module->l('repeat-y', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'no-repeat',
                            'name' => $this->module->l('no-repeat', 'IqitThemeEditorForm'),
                        ),
                    ),
                    'id' => 'id_option',
                    'name' => 'name',
                ),
            ),
            'bg_position' =>  array(
                'type' => 'select',
                'label' => $this->module->l('Position', 'IqitThemeEditorForm'),
                'name' => $prefix . 'bg_position',
                'condition' => array(
                    $prefix . 'bg_image' => '!= '
                ),
                'options' => array(
                    'query' => array(
                        array(
                            'id_option' => 'left-top',
                            'name' => $this->module->l('left top', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'left-center',
                            'name' => $this->module->l('left center', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'left-bottom',
                            'name' => $this->module->l('left bottom', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'right-top',
                            'name' => $this->module->l('right top', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'right-center',
                            'name' => $this->module->l('right center', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'right-bottom',
                            'name' => $this->module->l('right bottom', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'center-top',
                            'name' => $this->module->l('center top', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'center-center',
                            'name' => $this->module->l('center center', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'center-bottom',
                            'name' => $this->module->l('center bottom', 'IqitThemeEditorForm'),
                        ),
                    ),
                    'id' => 'id_option',
                    'name' => 'name',
                ),
            ),
            'bg_size' =>  array(
                'type' => 'select',
                'label' => $this->module->l('Size', 'IqitThemeEditorForm'),
                'name' => $prefix . 'bg_size',
                'condition' => array(
                    $prefix . 'bg_image' => '!= '
                ),
                'options' => array(
                    'query' => array(
                        array(
                            'id_option' => 'auto',
                            'name' => $this->module->l('auto', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'cover',
                            'name' => $this->module->l('cover', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'contain',
                            'name' => $this->module->l('contain', 'IqitThemeEditorForm'),
                        ),
                    ),
                    'id' => 'id_option',
                    'name' => 'name',
                ),
            ),
            'bg_attachment' =>  array(
                'type' => 'select',
                'label' => $this->module->l('Attachment', 'IqitThemeEditorForm'),
                'name' => $prefix . 'bg_attachment',
                'condition' => array(
                    $prefix . 'bg_image' => '!= '
                ),
                'options' => array(
                    'query' => array(
                        array(
                            'id_option' => 'fixed',
                            'name' => $this->module->l('Fixed', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 'scroll',
                            'name' => $this->module->l('Scroll', 'IqitThemeEditorForm'),
                        ),
                    ),
                    'id' => 'id_option',
                    'name' => 'name',
                ),
            ),
            'wrapper_end' =>  array(
                'type' => 'wrapper_end',
                'size' => 30,
            ),
            'border' =>  array(
                'type' => 'border',
                'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                'name' => $prefix . 'border',
                'size' => 30,
            ),
            'boxshadow' =>  array(
                'type' => 'boxshadow',
                'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                'name' => $prefix . 'boxshadow',
                'size' => 30,
            ),
            'text_color' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                'name' => $prefix . 'text_color',
                'size' => 30,
            ),
            'link_color' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Link color', 'IqitThemeEditorForm'),
                'name' => $prefix . 'link_color',
                'size' => 30,
            ),
            'link_h_color' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Link hover/active color', 'IqitThemeEditorForm'),
                'name' => $prefix . 'link_h_color',
                'size' => 30,
            ),
        ];
    }

    public function productBoxColors($prefix)
    {
        return[
            'border' =>  array(
                'type' => 'border',
                'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                'name' => 'pl_grid_' . $prefix . '_border',
                'size' => 30,
            ),
            'boxshadow' =>  array(
                'type' => 'boxshadow',
                'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                'name' => 'pl_grid_' . $prefix . '_boxshadow',
                'size' => 30,
            ),
            'colors' =>  array(
                'type' => 'select',
                'label' => $this->module->l('Custom colors', 'IqitThemeEditorForm'),
                'name' => 'pl_grid_' . $prefix . '_colors',
                'options' => array(
                    'query' => array(
                        array(
                            'id_option' => 0,
                            'name' => $this->module->l('No', 'IqitThemeEditorForm'),
                        ),
                        array(
                            'id_option' => 1,
                            'name' => $this->module->l('Yes', 'IqitThemeEditorForm'),
                        ),
                    ),
                    'id' => 'id_option',
                    'name' => 'name',
                ),
            ),
            'bg_color' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Background color', 'IqitThemeEditorForm'),
                'name' => 'pl_grid_' . $prefix . '_bg',
                'size' => 30,
                'condition' => array(
                    'pl_grid_' . $prefix . '_colors' => '==1'
                ),
            ),
            'text' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Text color', 'IqitThemeEditorForm'),
                'name' => 'pl_grid_' . $prefix . '_text',
                'size' => 30,
                'condition' => array(
                    'pl_grid_' . $prefix . '_colors' => '==1'
                ),
            ),
            'price' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Price color', 'IqitThemeEditorForm'),
                'name' => 'pl_grid_' . $prefix . '_price',
                'size' => 30,
                'condition' => array(
                    'pl_grid_' . $prefix . '_colors' => '==1'
                ),
            ),
            'rating' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Stars', 'IqitThemeEditorForm'),
                'name' => 'pl_grid_' . $prefix . '_rating',
                'size' => 30,
                'condition' => array(
                    'pl_grid_' . $prefix . '_colors' => '==1'
                ),
            ),

        ];
    }

    public function basicColorsFields($prefix, $elementPrefix)
    {
        return[
            'bg' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Background', 'IqitThemeEditorForm'),
                'name' => $prefix . '_' . $elementPrefix . '_bg',
                'size' => 30,
            ),
            'txt' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Text', 'IqitThemeEditorForm'),
                'name' => $prefix . '_' . $elementPrefix . '_txt',
                'size' => 30,
            ),
            'border' =>  array(
                'type' => 'border',
                'label' => $this->module->l('Border', 'IqitThemeEditorForm'),
                'name' => $prefix . '_' . $elementPrefix . '_border',
                'size' => 30,
            ),
            'boxshadow' =>  array(
                'type' => 'boxshadow',
                'label' => $this->module->l('Box shadow', 'IqitThemeEditorForm'),
                'name' => $prefix . '_' . $elementPrefix . '_boxshadow',
                'size' => 30,
            ),
            'bg_h' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Background - hover/focus', 'IqitThemeEditorForm'),
                'name' => $prefix . '_' . $elementPrefix . '_bg_h',
                'size' => 30,
            ),
            'txt_h' =>  array(
                'type' => 'color2',
                'label' => $this->module->l('Text - hover/focus', 'IqitThemeEditorForm'),
                'name' => $prefix . '_' . $elementPrefix . '_txt_h',
                'size' => 30,
            ),
            'border_h' =>  array(
                'type' => 'border',
                'label' => $this->module->l('Border - hover/focus', 'IqitThemeEditorForm'),
                'name' => $prefix . '_' . $elementPrefix . '_border_h',
                'size' => 30,
            ),
            'boxshadow_h' =>  array(
                'type' => 'boxshadow',
                'label' => $this->module->l('Box shadow - hover/focus', 'IqitThemeEditorForm'),
                'name' => $prefix . '_' . $elementPrefix . '_boxshadow_h',
                'size' => 30,
            ),
        ];
    }
}
