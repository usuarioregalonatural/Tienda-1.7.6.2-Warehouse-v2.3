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
 * @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 * @copyright 2017 IQIT-COMMERCE.COM
 * @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

use Leafo\ScssPhp\Compiler;

class IqitThemeEditor extends Module
{
    public $defaults;
    public $systemFonts;

    public function __construct()
    {
        $this->name = 'iqitthemeeditor';
        $this->tab = 'front_office_features';
        $this->version = '4.3.2';
        $this->author = 'IQIT-COMMERCE.COM';
        $this->bootstrap = true;
        $this->cfgName = 'iqitthemeed_';
        $this->controllers = array('preview');

        parent::__construct();


        $this->defaults = array(
            //general
            'g_layout' => array('type' => 'default', 'value' => 'wide', 'cached' => true),
            'g_max_width' => array('type' => 'default', 'value' => '1240px'),
            'g_sidebars_width' => array('type' => 'default', 'value' => '', 'cached' => true),
            'g_margin_tb' => array('type' => 'default', 'value' => ''),
            'g_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'g_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'g_bg_color' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'g_bg_image' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'g_bg_attachment' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'g_bg_repeat' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'g_bg_position' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'g_bg_size' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),

            //responsive-mobile
            'rm_logo' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'rm_icon_apple' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'rm_icon_android' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'rm_padding' => array('type' => 'default', 'value' => ''),
            'rm_breakpoint' => array('type' => 'default', 'value' => '', 'cached' => true),
            'rm_pinch_zoom' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'rm_address_bg' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'rm_header' => array('type' => 'default', 'value' => '', 'cached' => true),
            'rm_sticky' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'rm_bg_color' => array('type' => 'default', 'value' => ''),
            'rm_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'rm_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'rm_link_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'rm_link_label' => array('type' => 'default', 'value' => ''),
            'rm_link_padding' => array('type' => 'default', 'value' => ''),
            'rm_link_bg' => array('type' => 'default', 'value' => ''),
            'rm_link_color' => array('type' => 'default', 'value' => ''),
            'rm_link_h_bg' => array('type' => 'default', 'value' => ''),
            'rm_link_h_color' => array('type' => 'default', 'value' => ''),
            'rm_footer_collapse' => array('type' => 'default', 'value' => ''),

            //options-ui
            'op_preloader' => array('type' => 'default', 'value' => '', 'cached' => true),
            'op_preloader_icon_pre' => array('type' => 'default', 'value' => '', 'cached' => true),
            'op_preloader_bg' => array('type' => 'default', 'value' => ''),
            'op_preloader_size' => array('type' => 'default', 'value' => ''),
            'op_preloader_icon_color' => array('type' => 'default', 'value' => ''),
            'op_to_top_style' => array('type' => 'default', 'value' => ''),
            'op_to_top_bg_color' => array('type' => 'default', 'value' => ''),
            'op_to_top_link_color' => array('type' => 'default', 'value' => ''),
            'op_to_top_bg_h_color' => array('type' => 'default', 'value' => ''),
            'op_to_top_link_h_color' => array('type' => 'default', 'value' => ''),
            'op_scrollbar' => array('type' => 'default', 'value' => ''),
            'op_scrollbar_color' => array('type' => 'default', 'value' => ''),
            'op_scrollbar_color_bg' => array('type' => 'default', 'value' => ''),


            //typography
            'typo_font_include' => array('type' => 'default', 'value' => '', 'scssType' => 'ignore'),
            'typo_material' => array('type' => 'default', 'value' => ''),
            'typo_bfont_t' => array('type' => 'default', 'value' => '', 'cached' => true),
            'typo_bfont_g_url' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'typo_bfont_g_name' => array('type' => 'default', 'value' => ''),
            'typo_bfont_s_name' => array('type' => 'default', 'value' => ''),
            'typo_bfont_c_name' => array('type' => 'default', 'value' => ''),
            'typo_bfont_size' => array('type' => 'default', 'value' => ''),
            'typo_bfont_lineheight' => array('type' => 'default', 'value' => ''),
            'typo_bfont_size_m' => array('type' => 'default', 'value' => ''),

            'typo_hfont_t' => array('type' => 'default', 'value' => '', 'cached' => true),
            'typo_hfont_g_url' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'typo_hfont_g_name' => array('type' => 'default', 'value' => ''),
            'typo_hfont_s_name' => array('type' => 'default', 'value' => ''),
            'typo_hfont_c_name' => array('type' => 'default', 'value' => ''),


            //cart
            'cart_style' => array('type' => 'default', 'value' => '', 'cached' => true),
            'cart_confirmation' => array('type' => 'default', 'value' => '', 'cached' => true),
            'cart_bg' => array('type' => 'default', 'value' => ''),
            'cart_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'cart_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'cart_inner_border' => array('type' => 'default', 'value' => ''),
            'cart_inner_text' => array('type' => 'default', 'value' => ''),

            //buttons
            'btn_default_bg' => array('type' => 'default', 'value' => ''),
            'btn_default_txt' => array('type' => 'default', 'value' => ''),
            'btn_default_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'btn_default_bg_h' => array('type' => 'default', 'value' => ''),
            'btn_default_txt_h' => array('type' => 'default', 'value' => ''),
            'btn_default_border_h' => array('type' => 'default', 'value' => ''),

            'btn_action_bg' => array('type' => 'default', 'value' => ''),
            'btn_action_txt' => array('type' => 'default', 'value' => ''),
            'btn_action_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'btn_action_bg_h' => array('type' => 'default', 'value' => ''),
            'btn_action_txt_h' => array('type' => 'default', 'value' => ''),
            'btn_action_border_h' => array('type' => 'default', 'value' => ''),


            //breadcrumb
            'bread_status' => array('type' => 'default', 'value' => 'wide'),
            'bread_width' => array('type' => 'default', 'value' => 'wide', 'cached' => true),
            'bread_layout' => array('type' => 'default', 'value' => 'wide'),
            'bread_padding_tb' => array('type' => 'default', 'value' => ''),
            'bread_padding_lr' => array('type' => 'default', 'value' => ''),
            'bread_txt' => array('type' => 'default', 'value' => ''),
            'bread_font' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'bread_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'bread_bg_color' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'bread_bg_image' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'bread_bg_attachment' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'bread_bg_repeat' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'bread_bg_position' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'bread_bg_size' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'bread_bg_category' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),



            //forms
            'form_input_bg' => array('type' => 'default', 'value' => ''),
            'form_input_txt' => array('type' => 'default', 'value' => ''),
            'form_input_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'form_input_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'form_input_bg_h' => array('type' => 'default', 'value' => ''),
            'form_input_boxshadow_h' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'form_input_border_c_h' => array('type' => 'default', 'value' => ''),
            'form_radio_checked' => array('type' => 'default', 'value' => ''),
            'form_radio_bg' => array('type' => 'default', 'value' => ''),
            'form_radio_border' => array('type' => 'default', 'value' => ''),

            'form_dropdown_txt' => array('type' => 'default', 'value' => ''),
            'form_dropdown_bg' => array('type' => 'default', 'value' => ''),
            'form_dropdown_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'form_dropdown_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'form_tooltip_txt' => array('type' => 'default', 'value' => ''),
            'form_tooltip_bg' => array('type' => 'default', 'value' => ''),

            //modals
            'modals_overlay' => array('type' => 'default', 'value' => ''),
            'modals_bg' => array('type' => 'default', 'value' => ''),
            'modals_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'modals_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            //notifications
            'modals_n_txt' => array('type' => 'default', 'value' => ''),
            'modals_n_bg' => array('type' => 'default', 'value' => ''),
            'modals_n_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'modals_n_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),

            //label-prices
            'lp_price' => array('type' => 'default', 'value' => ''),
            'lp_ratings' => array('type' => 'default', 'value' => ''),
            'lp_label_style' => array('type' => 'default', 'value' => ''),
            'lp_label_font' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'lp_new_l_bg' => array('type' => 'default', 'value' => ''),
            'lp_new_l_txt' => array('type' => 'default', 'value' => ''),
            'lp_sale_l_bg' => array('type' => 'default', 'value' => ''),
            'lp_sale_l_txt' => array('type' => 'default', 'value' => ''),
            'lp_online_l_bg' => array('type' => 'default', 'value' => ''),
            'lp_online_l_txt' => array('type' => 'default', 'value' => ''),
            'lp_intstock_l_bg' => array('type' => 'default', 'value' => ''),
            'lp_intstock_l_txt' => array('type' => 'default', 'value' => ''),
            'lp_outstock_l_bg' => array('type' => 'default', 'value' => ''),
            'lp_outstock_l_txt' => array('type' => 'default', 'value' => ''),
            'lp_alert_s_bg' => array('type' => 'default', 'value' => ''),
            'lp_alert_s_txt' => array('type' => 'default', 'value' => ''),
            'lp_alert_i_bg' => array('type' => 'default', 'value' => ''),
            'lp_alert_i_txt' => array('type' => 'default', 'value' => ''),
            'lp_alert_w_bg' => array('type' => 'default', 'value' => ''),
            'lp_alert_w_txt' => array('type' => 'default', 'value' => ''),
            'lp_alert_d_bg' => array('type' => 'default', 'value' => ''),
            'lp_alert_d_txt' => array('type' => 'default', 'value' => ''),


            //social-media
            'sm_facebook' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'sm_twitter' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'sm_youtube' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'sm_google' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'sm_instagram' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'sm_pinterest' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'sm_vimeo' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'sm_linkedin' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'sm_og_logo' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),

            //header-wrapper
            'hw_padding_tb' => array('type' => 'default', 'value' => ''),
            'hw_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'hw_border_t' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'hw_border_b' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'hw_border_r' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'hw_bg_color' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hw_bg_image' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hw_bg_attachment' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hw_bg_repeat' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hw_bg_position' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hw_bg_size' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hw_width' => array('type' => 'default', 'value' => '', 'cached' => true),

            //header
            'h_layout' => array('type' => 'default', 'value' => '', 'cached' => true),
            'h_absolute' => array('type' => 'default', 'value' => '', 'cached' => true),
            'h_absolute_wrapper_bg' => array('type' => 'default', 'value' => ''),
            //'h_absolute_bg' => array('type' => 'default', 'value' => ''),
            'h_sticky' => array('type' => 'default', 'value' => '', 'cached' => true),
            'h_sticky_bg' => array('type' => 'default', 'value' => ''),
            'h_sticky_padding' => array('type' => 'default', 'value' => ''),
            'h_logo_position' => array('type' => 'default', 'value' => '', 'cached' => true),
            'h_padding' => array('type' => 'default', 'value' => ''),
            /*
            'h_bg_color' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'h_bg_image' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'h_bg_attachment' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'h_bg_repeat' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'h_bg_position' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'h_bg_size' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            */
            'h_text_color' => array('type' => 'default', 'value' => ''),
            'h_link_color' => array('type' => 'default', 'value' => ''),
            'h_link_h_color' => array('type' => 'default', 'value' => ''),
            'h_txt' => array('type' => 'txt', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),

            //header-cart-icons-type
            'h_icons_size' => array('type' => 'default', 'value' => ''),
            'h_icons_label' => array('type' => 'default', 'value' => ''),

            //header-search
            'h_search_type' => array('type' => 'default', 'value' => '', 'cached' => true),
            'h_search_input_bg' => array('type' => 'default', 'value' => ''),
            'h_search_input_txt' => array('type' => 'default', 'value' => ''),
            'h_search_input_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'h_search_width' => array('type' => 'default', 'value' => ''),

            //header-cart-trigger
            'h_cart_type' => array('type' => 'default', 'value' => ''),
            'h_cart_trigger_bg' => array('type' => 'default', 'value' => ''),
            'h_cart_trigger_txt' => array('type' => 'default', 'value' => ''),
            'h_cart_trigger_padding' => array('type' => 'default', 'value' => ''),
            'h_cart_trigger_qty_bg' => array('type' => 'default', 'value' => ''),
            'h_cart_trigger_qty_txt' => array('type' => 'default', 'value' => ''),

            //Top bar
            'tb_status' => array('type' => 'default', 'value' => '', 'cached' => true),
            'tb_width' => array('type' => 'default', 'value' => '', 'cached' => true),
            'tb_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'tb_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'tb_bg_color' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'tb_bg_image' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'tb_bg_attachment' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'tb_bg_repeat' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'tb_bg_position' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'tb_bg_size' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'tb_padding' => array('type' => 'default', 'value' => ''),
            'tb_font_size' => array('type' => 'default', 'value' => ''),
            'tb_text_color' => array('type' => 'default', 'value' => ''),
            'tb_link_color' => array('type' => 'default', 'value' => ''),
            'tb_link_h_color' => array('type' => 'default', 'value' => ''),
            'tb_social' => array('type' => 'default', 'value' => '', 'cached' => true),
            'tb_social_c_t' => array('type' => 'default', 'value' => ''),
            'tb_social_c_t_h' => array('type' => 'default', 'value' => ''),
            'tb_social_txt' => array('type' => 'default', 'value' => ''),
            'tb_social_txt_h' => array('type' => 'default', 'value' => ''),
            'tb_social_size' => array('type' => 'default', 'value' => ''),

            //horizontal-menu
            'hm_width' => array('type' => 'default', 'value' => ''),
            'hm_animation' => array('type' => 'default', 'value' => ''),
            'hm_submenu_width' => array('type' => 'default', 'value' => ''),
            'hm_border_t' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'hm_border_r' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'hm_border_b' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'hm_border_l' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'hm_border_i' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'hm_bg_color' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hm_bg_image' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hm_bg_attachment' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hm_bg_repeat' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hm_bg_position' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'hm_bg_size' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),

            'hm_height' => array('type' => 'default', 'value' => ''),
            'hm_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'hm_padding' => array('type' => 'default', 'value' => ''),
            'hm_small_font' => array('type' => 'default', 'value' => ''),
            'hm_small_padding' => array('type' => 'default', 'value' => ''),
            'hm_max_width' => array('type' => 'default', 'value' => ''),
            'hm_btn_position' => array('type' => 'default', 'value' => ''),
            'hm_btn_arrow' => array('type' => 'default', 'value' => ''),
            'hm_btn_color' => array('type' => 'default', 'value' => ''),
            'hm_btn_color_h' => array('type' => 'default', 'value' => ''),
            'hm_btn_bg_color_h' => array('type' => 'default', 'value' => ''),
            'hm_btn_icon' => array('type' => 'default', 'value' => ''),
            'hm_btn_icon_size' => array('type' => 'default', 'value' => ''),
            'hm_legend_color' => array('type' => 'default', 'value' => ''),
            'hm_legend_bg_color' => array('type' => 'default', 'value' => ''),


            //vertical-menu
            'vm_position' => array('type' => 'default', 'value' => '', 'cached' => true),
            'vm_animation' => array('type' => 'default', 'value' => ''),
            'vm_submenu_style' => array('type' => 'default', 'value' => ''),
            'vm_title_text' => array('type' => 'default', 'value' => ''),
            'vm_title_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'vm_title_color' => array('type' => 'default', 'value' => ''),
            'vm_title_bg' => array('type' => 'default', 'value' => ''),
            'vm_title_color_h' => array('type' => 'default', 'value' => ''),
            'vm_title_bg_h' => array('type' => 'default', 'value' => ''),
            'vm_title_height' => array('type' => 'default', 'value' => ''),
            'vm_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'vm_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'vm_border_i' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'vm_bgcolor' => array('type' => 'default', 'value' => ''),
            'vm_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'vm_padding' => array('type' => 'default', 'value' => ''),
            'vm_btn_arrow' => array('type' => 'default', 'value' => ''),
            'vm_btn_color' => array('type' => 'default', 'value' => ''),
            'vm_btn_color_h' => array('type' => 'default', 'value' => ''),
            'vm_btn_bg_color_h' => array('type' => 'default', 'value' => ''),
            'vm_btn_icon_size' => array('type' => 'default', 'value' => ''),
            'vm_legend_color' => array('type' => 'default', 'value' => ''),
            'vm_legend_bg_color' => array('type' => 'default', 'value' => ''),


            //submenu-menu
            'msm_bg' => array('type' => 'default', 'value' => ''),
            'msm_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'msm_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'msm_border_inner' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'msm_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'msm_title_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'msm_title_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'msm_title_color' => array('type' => 'default', 'value' => ''),
            'msm_title_color_h' => array('type' => 'default', 'value' => ''),
            'msm_tabs_color' => array('type' => 'default', 'value' => ''),
            'msm_tabs_color_h' => array('type' => 'default', 'value' => ''),
            'msm_tabs_bg' => array('type' => 'default', 'value' => ''),
            'msm_tabs_bg_h' => array('type' => 'default', 'value' => ''),
            'msm_color' => array('type' => 'default', 'value' => ''),
            'msm_color_h' => array('type' => 'default', 'value' => ''),
            'msm_arrows' => array('type' => 'default', 'value' => ''),


            //mobile-menu
            'mm_type' => array('type' => 'default', 'value' => '', 'cached' => true),
            'mm_background' => array('type' => 'default', 'value' => ''),
            'mm_background_l2' => array('type' => 'default', 'value' => ''),
            'mm_background_l3' => array('type' => 'default', 'value' => ''),
            'mm_text' => array('type' => 'default', 'value' => ''),
            'mm_inner_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'mm_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'mm_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),


            //content-wrapper
            'cw_padding_tb' => array('type' => 'default', 'value' => ''),
            'cw_index_padding_tb' => array('type' => 'default', 'value' => ''),
            'cw_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'cw_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'cw_bg_color' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'cw_bg_image' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'cw_bg_attachment' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'cw_bg_repeat' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'cw_bg_position' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'cw_bg_size' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),

            //content
            'c_txt_color' => array('type' => 'default', 'value' => ''),
            'c_link_color' => array('type' => 'default', 'value' => ''),
            'c_link_hover' => array('type' => 'default', 'value' => ''),


            'c_page_title_layout' => array('type' => 'default', 'value' => ''),
            'c_page_title_position' => array('type' => 'default', 'value' => ''),
            'c_page_title_color' => array('type' => 'default', 'value' => ''),
            'c_page_title_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'c_page_title_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),

            'c_block_title_layout' => array('type' => 'default', 'value' => ''),
            'c_block_title_position' => array('type' => 'default', 'value' => ''),
            'c_block_title_color' => array('type' => 'default', 'value' => ''),
            'c_block_title_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'c_block_title_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),

            'c_tabs_txt' => array('type' => 'default', 'value' => ''),
            'c_tabs_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'c_tabs_border_b' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),

            //sidebar
            'sb_block_padding' => array('type' => 'default', 'value' => ''),
            'sb_block_bg' => array('type' => 'default', 'value' => ''),
            'sb_block_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'sb_block_title_layout' => array('type' => 'default', 'value' => ''),
            'sb_block_title_position' => array('type' => 'default', 'value' => ''),
            'sb_block_title_color' => array('type' => 'default', 'value' => ''),
            'sb_block_title_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'sb_block_title_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),

            //product-lists
            'pl_default_view' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pl_lazyload' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pl_rollover' => array('type' => 'default', 'value' => '', 'cached' => true),
            'pl_top_pagination' => array('type' => 'default', 'value' => '', 'cached' => true),
            'pl_faceted_position' => array('type' => 'default', 'value' => '', 'cached' => true),
            'pl_faceted_slider_color' => array('type' => 'default', 'value' => ''),
            'pl_infinity' => array('type' => 'default', 'value' => '', 'cached' => true),
            'pl_grid_ld' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pl_grid_d' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pl_grid_t' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pl_grid_p' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pl_grid_layout' => array('type' => 'default', 'value' => '', 'cached' => true),
            'pl_grid_margin' => array('type' => 'default', 'value' => ''),
            'pl_grid_padding' => array('type' => 'default', 'value' => ''),
            'pl_grid_text_padding' => array('type' => 'default', 'value' => ''),
            'pl_grid_overlay_bg' => array('type' => 'default', 'value' => ''),
            'pl_grid_name_font' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'pl_grid_price_font' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'pl_grid_name_line' => array('type' => 'default', 'value' => 0),
            'pl_grid_align' => array('type' => 'default', 'value' => ''),
            'pl_grid_category_name' => array('type' => 'default', 'value' => ''),
            'pl_grid_brand' => array('type' => 'default', 'value' => ''),
            'pl_grid_reference' => array('type' => 'default', 'value' => ''),
            'pl_grid_btn' => array('type' => 'default', 'value' => ''),
            'pl_grid_colors' => array('type' => 'default', 'value' => ''),
            'pl_grid_desc' => array('type' => 'default', 'value' => ''),
            'pl_grid_discount_value' => array('type' => 'default', 'value' => ''),
            'pl_grid_func_btn' => array('type' => 'default', 'value' => ''),
            'pl_grid_qty' => array('type' => 'default', 'value' => ''),
            'pl_grid_functional_bg' => array('type' => 'default', 'value' => ''),
            'pl_grid_functional_txt' => array('type' => 'default', 'value' => ''),
            'pl_grid_btn_align' => array('type' => 'default', 'value' => ''),


            'pl_grid_btn_padding' => array('type' => 'default', 'value' => ''),
            'pl_grid_btn_bg' => array('type' => 'default', 'value' => ''),
            'pl_grid_btn_color' => array('type' => 'default', 'value' => ''),
            'pl_grid_btn_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'pl_grid_btn_bg_h' => array('type' => 'default', 'value' => ''),
            'pl_grid_btn_color_h' => array('type' => 'default', 'value' => ''),
            'pl_grid_btn_border_h' => array('type' => 'default', 'value' => ''),

            'pl_grid_b_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'pl_grid_b_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'pl_grid_b_colors' => array('type' => 'default', 'value' => ''),
            'pl_grid_b_bg' => array('type' => 'default', 'value' => ''),
            'pl_grid_b_text' => array('type' => 'default', 'value' => ''),
            'pl_grid_b_price' => array('type' => 'default', 'value' => ''),
            'pl_grid_b_rating' => array('type' => 'default', 'value' => ''),
            'pl_grid_bh_boxshadow' => array('type' => 'json', 'value' => '', 'scssType' => 'box-shadow'),
            'pl_grid_bh_border_c' => array('type' => 'default', 'value' => ''),
            'pl_grid_bh_outline' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'pl_grid_bh_colors' => array('type' => 'default', 'value' => ''),
            'pl_grid_bh_bg' => array('type' => 'default', 'value' => ''),
            'pl_grid_bh_text' => array('type' => 'default', 'value' => ''),
            'pl_grid_bh_price' => array('type' => 'default', 'value' => ''),
            'pl_grid_bh_rating' => array('type' => 'default', 'value' => ''),
            'pl_crsl_style' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pl_crsl_autoplay' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pl_crsl_bg' => array('type' => 'default', 'value' => ''),
            'pl_crsl_bg_h' => array('type' => 'default', 'value' => ''),
            'pl_crsl_txt' => array('type' => 'default', 'value' => ''),
            'pl_crsl_txt_h' => array('type' => 'default', 'value' => ''),
            'pl_crsl_dot' => array('type' => 'default', 'value' => ''),
            'pl_crsl_dot_bg' => array('type' => 'default', 'value' => ''),

            //category-page
            'cat_image' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'cat_desc' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'cat_sub_thumbs' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'cat_sub_thumbs_d' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'cat_sub_thumbs_t' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'cat_sub_thumbs_p' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'cat_hide_mobile' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),

            //product-page
            'pp_thumbs' => array('type' => 'default', 'value' => '', 'cached' => true),
            'pp_img_width' => array('type' => 'default', 'value' => '', 'cached' => true),
            'pp_zoom' => array('type' => 'default', 'value' => '', 'cached' => true),
            'pp_zoom_ui_txt' => array('type' => 'default', 'value' => ''),
            'pp_zoom_ui_bg' => array('type' => 'default', 'value' => ''),
            'pp_img_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'pp_centered_info' => array('type' => 'default', 'value' => ''),
            'pp_sidebar' => array('type' => 'default', 'value' => '', 'cached' => true),
            'pp_attributes' => array('type' => 'default', 'value' => ''),
            'pp_price_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),
            'pp_accesories' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pp_tabs' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'pp_tabs_position' => array('type' => 'default', 'value' => ''),
            'pp_reference' => array('type' => 'default', 'value' => 'tab', 'cached' => true, 'scssType' => 'ignore'),
            'pp_man_logo' => array('type' => 'default', 'value' => 'tab', 'cached' => true, 'scssType' => 'ignore'),
            'pp_man_desc' => array('type' => 'default', 'value' => 'tab', 'cached' => true, 'scssType' => 'ignore'),
            'pp_preloader' => array('type' => 'default', 'value' => 'tab'),
            'pp_price_position' => array('type' => 'default', 'value' => 'tab', 'cached' => true, 'scssType' => 'ignore'),



            //brands-page
            'brands_layout' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),

            //footer-wrapper
            'fw_padding_tb' => array('type' => 'default', 'value' => ''),
            'fw_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'fw_bg_color' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'fw_bg_image' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'fw_bg_attachment' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'fw_bg_repeat' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'fw_bg_position' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'fw_bg_size' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'fw_text' => array('type' => 'default', 'value' => ''),
            'fw_link' => array('type' => 'default', 'value' => ''),
            'fw_link_h' => array('type' => 'default', 'value' => ''),

            'fw_block_title_status' => array('type' => 'default', 'value' => ''),
            'fw_block_title_layout' => array('type' => 'default', 'value' => ''),
            'fw_block_title_position' => array('type' => 'default', 'value' => ''),
            'fw_block_title_color' => array('type' => 'default', 'value' => ''),
            'fw_block_title_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'fw_block_title_typo' => array('type' => 'json', 'value' => '', 'scssType' => 'font'),


            //footer-layout
            'f_layout' => array('type' => 'default', 'value' => '', 'cached' => true),
            'f_fixed' => array('type' => 'default', 'value' => '', 'cached' => true),

            //newsletter_input/social
            'f_top_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'f_top_padding' => array('type' => 'default', 'value' => ''),
            'f_top_bg' => array('type' => 'default', 'value' => ''),
            'f_top_txt' => array('type' => 'default', 'value' => ''),
            'f_input_bg' => array('type' => 'default', 'value' => ''),
            'f_input_txt' => array('type' => 'default', 'value' => ''),
            'f_input_btn' => array('type' => 'default', 'value' => ''),
            'f_input_btn_h' => array('type' => 'default', 'value' => ''),
            'f_input_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'f_newsletter_status' => array('type' => 'default', 'value' => '', 'cached' => true),
            'f_social_status' => array('type' => 'default', 'value' => '', 'cached' => true),
            'f_social_c_t' => array('type' => 'default', 'value' => ''),
            'f_social_c_t_h' => array('type' => 'default', 'value' => ''),
            'f_social_txt' => array('type' => 'default', 'value' => ''),
            'f_social_txt_h' => array('type' => 'default', 'value' => ''),
            'f_social_size' => array('type' => 'default', 'value' => ''),


            //footer-copyrights
            'fc_status' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'fc_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'fc_padding' => array('type' => 'default', 'value' => ''),
            'fc_bg_color' => array('type' => 'default', 'value' => ''),
            'fc_img' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'fc_txt' => array('type' => 'txt', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),

            //maintance
            'mcs_layout' => array('type' => 'default', 'value' => '', 'cached' => true),
            'mcs_logo' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'mcs_bg_color' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'mcs_bg_image' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'mcs_bg_attachment' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'mcs_bg_repeat' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'mcs_bg_position' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'mcs_bg_size' => array('type' => 'default', 'value' => '', 'scssType' => 'background'),
            'mcs_text_color' => array('type' => 'default', 'value' => ''),
            'mcs_countdown' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'mcs_date' => array('type' => 'default', 'value' => '', 'cached' => true, 'scssType' => 'ignore'),
            'mcs_social' => array('type' => 'default', 'cached' => true, 'value' => '', 'scssType' => 'ignore'),
            'mcs_newsletter' => array('type' => 'default', 'value' => '', 'cached' => true),
            'mcs_form_border' => array('type' => 'json', 'value' => '', 'scssType' => 'border'),
            'mcs_form_bg' => array('type' => 'default', 'value' => ''),
            'mcs_form_txt' => array('type' => 'default', 'value' => ''),
            'mcs_button_bg' => array('type' => 'default', 'value' => ''),
            'mcs_button_txt' => array('type' => 'default', 'value' => ''),
            'mcs_button_bg_h' => array('type' => 'default', 'value' => ''),
            'mcs_button_txt_h' => array('type' => 'default', 'value' => ''),
            'mcs_header_bg' => array('type' => 'default', 'value' => ''),
            'mcs_header_txt' => array('type' => 'default', 'value' => ''),


            //codes
            'codes_css' => array('type' => 'raw', 'value' => ''),
            'codes_js' => array('type' => 'raw', 'value' => '', 'scssType' => 'ignore'),
            'codes_body' => array('type' => 'html', 'value' => '', 'scssType' => 'ignore'),
            'codes_head' => array('type' => 'html', 'value' => '', 'scssType' => 'ignore'),
        );

        $this->systemFonts = array(
            array(
                'id_option' => 'Arial, Helvetica, sans-serif',
                'name' => 'Arial, Helvetica, sans-serif'
            ),
            array(
                'id_option' => 'Georgia, serif',
                'name' => 'Georgia, serif'
            ),
            array(
                'id_option' => 'Tahoma, Geneva, sans-serif',
                'name' => 'Tahoma, Geneva, sans-serif'
            ),
            array(
                'id_option' => '"Times New Roman", Times, serif',
                'name' => '"Times New Roman", Times, serif'
            ),
            array(
                'id_option' => 'Verdana, Geneva, sans-serif',
                'name' => 'Verdana, Geneva, sans-serif'
            )
        );

        $this->displayName = $this->l('IQITTHEMEEDITOR - Customize your theme');
        $this->description = $this->l('Change design of your shop');
    }

    public function install()
    {
        $var = (parent::install()
            && $this->installTab()
            && $this->registerHook('header')
            && $this->registerHook('displayMaintenance')
            && $this->registerHook('ProductSearchProvider')
            && $this->registerHook('actionProductSearchAfter')
            && $this->registerHook('actionBeforeElementorWidgetRender')
            && $this->registerHook('actionProductSearchComplete')
        );


        
          $subscritionModule = Module::getInstanceByName('ps_emailsubscription');
            if ($subscritionModule instanceof Module) {
            $subscritionModule->unregisterHook('displayFooterBefore');
            }

        $this->registerCustomHooks();
        $this->setDefaults();
        $this->generateCssAndJs(true);
        return $var;
    }

    public function registerCustomHooks(){
        $hook_name = 'displayHeaderButtons';
        $id_hook = Hook::getIdByName($hook_name);
        // If hook does not exist, we create it
        if (!$id_hook) {
            $new_hook = new Hook();
            $new_hook->name = pSQL($hook_name);
            $new_hook->title = pSQL($hook_name);
            $new_hook->position = 1;
            $new_hook->add();
        }

        $hook_name = 'displayMyAccountDashboard';

        $id_hook = Hook::getIdByName($hook_name);
        // If hook does not exist, we create it
        if (!$id_hook) {
            $new_hook = new Hook();
            $new_hook->name = pSQL($hook_name);
            $new_hook->title = pSQL($hook_name);
            $new_hook->position = 1;
            $new_hook->add();
        }

        $hook_name = 'displayWrapperBottomInContainer';

        $id_hook = Hook::getIdByName($hook_name);
        // If hook does not exist, we create it
        if (!$id_hook) {
            $new_hook = new Hook();
            $new_hook->name = pSQL($hook_name);
            $new_hook->title = pSQL($hook_name);
            $new_hook->position = 1;
            $new_hook->add();
        }

        $hook_name = 'displayWrapperTopInContainer';

        $id_hook = Hook::getIdByName($hook_name);
        // If hook does not exist, we create it
        if (!$id_hook) {
            $new_hook = new Hook();
            $new_hook->name = pSQL($hook_name);
            $new_hook->title = pSQL($hook_name);
            $new_hook->position = 1;
            $new_hook->add();
        }


        $hook_name = 'displayNavCenter';

        $id_hook = Hook::getIdByName($hook_name);
        // If hook does not exist, we create it
        if (!$id_hook) {
            $new_hook = new Hook();
            $new_hook->name = pSQL($hook_name);
            $new_hook->title = pSQL($hook_name);
            $new_hook->position = 1;
            $new_hook->add();
        }

        $hook_name = 'displayHeaderButtonsMobile';

        $id_hook = Hook::getIdByName($hook_name);
        // If hook does not exist, we create it
        if (!$id_hook) {
            $new_hook = new Hook();
            $new_hook->name = pSQL($hook_name);
            $new_hook->title = pSQL($hook_name);
            $new_hook->position = 1;
            $new_hook->add();
        }

    }

    public function getFrontEditorToken()
    {
        return Tools::getAdminToken($this->name . (int)Tab::getIdFromClassName($this->name)
            . (is_object(Context::getContext()->employee) ? (int)Context::getContext()->employee->id :
                Tools::getValue('id_employee')));
    }

    public function checkEnvironment()
    {
        $cookie = new Cookie('psAdmin', '', (int)Configuration::get('PS_COOKIE_LIFETIME_BO'));
        return isset($cookie->id_employee) && isset($cookie->passwd) && Employee::checkPassword($cookie->id_employee,
            $cookie->passwd);
    }

    public function uninstall()
    {
        foreach ($this->defaults as $key => $default) {
            Configuration::deleteByName($this->cfgName . $key);
        }
        Configuration::deleteByName($this->cfgName . 'options');
        return (parent::uninstall()
            && $this->uninstallTab());
    }

    public function setDefaults()
    {
        $str = file_get_contents(_PS_MODULE_DIR_ . 'iqitthemeeditor/default_config.json');
        $arr = json_decode($str, true);
        $var = array();

        foreach ($this->defaults as $key => $default) {
            if (isset($arr[$key])) {
                Configuration::updateValue($this->cfgName . $key, $arr[$key]);

                if (isset($default['cached'])) {
                    $var[$key] = $arr[$key];
                }
            } else{
                Configuration::updateValue($this->cfgName . $key, $default['value']);

                if (isset($default['cached'])) {
                    $var[$key] = $default['value'];
                }
            }
        }

        Configuration::updateValue($this->cfgName . 'options', json_encode($var));

        return true;
    }

    public function setCachedOptions()
    {
        $var = array();

        foreach ($this->defaults as $key => $default) {
            if (isset($default['cached'])) {
                $var[$key] = Configuration::get($this->cfgName . $key);
            }
        }
        Configuration::updateValue($this->cfgName . 'options', json_encode($var));
        return true;
    }

    public function installTab()
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = "IqitFrontThemeEditor";
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = "IqitThemeEditor - Live";
        }
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
        $tab->module = $this->name;
        $tab->add();

        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = "AdminIqitThemeEditor";
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = "IqitThemeEditor - Backoffice";
        }
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentThemes');
        $tab->module = $this->name;
        return $tab->add();
    }

    public function uninstallTab()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminIqitThemeEditor');
        $tab = new Tab($id_tab);
        $tab->delete();

        $id_tab = (int)Tab::getIdFromClassName('IqitFrontThemeEditor');
        $tab = new Tab($id_tab);
        return $tab->delete();
    }

    public function getContent()
    {
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminIqitThemeEditor')
        );
    }

    public function generateCssAndJs($allShops = false)
    {
        $result = $this->generateCssAndJsProcess($allShops);
        return $result['message'];
    }

    public function generateCssAndJsProcess($allShops = false)
    {
        include_once _PS_MODULE_DIR_ . 'iqitthemeeditor/src/scssphp/scss.inc.php';

        $css = '';
        $css .= Configuration::get($this->cfgName . 'typo_font_include') . ' .iqitfake{} ';

        $vars = '';
        $compiler = new Compiler();
        $compiler->setIgnoreErrors(true);
        $compiler->setImportPaths($this->local_path . 'views/scss/');

        foreach ($this->defaults as $key => $default) {
            if ($key == 'codes_css') {
                continue;
            }

            if (isset($default['scssType'])) {
                switch ($default['scssType']) {
                    case 'ignore':
                        continue;
                        break;
                    case 'border':
                        $vars .= ' ' . $this->configToScssVar($key, 'border') . PHP_EOL;
                        break;
                    case 'box-shadow':
                        $vars .= ' ' . $this->configToScssVar($key, 'box-shadow') . PHP_EOL;
                        break;
                    case 'background':
                        $vars .= ' ' . $this->configToScssVar(str_replace('bg_color', '', $key),
                                'background') . PHP_EOL;
                        break;
                    case 'font':
                        $vars .= ' ' . $this->configToScssVar($key, 'font') . PHP_EOL;
                        break;
                }
            } else {
                $vars .= ' ' . $this->configToScssVar($key) . PHP_EOL;
            }
        }
        try {
            $css .= $compiler->compile($vars . ' @import "iqitthemeeditor.scss";');
        } catch (Exception $e) {
            $message = '<div class="alert alert-danger">' . $this->l('There is error in SCSS to CSS compiler');
            $message .= '<ul><li>' . $e->getMessage() . ' </li></ul></div>';
            return ['success' => false, 'message' => $message];
        }

        $material = Configuration::get($this->cfgName . 'typo_material');

        if ($material){
            try {
                $css .= $compiler->compile($vars . ' @import "material.scss";');
            } catch (Exception $e) {
                $message = '<div class="alert alert-danger">' . $this->l('There is error in SCSS to CSS compiler');
                $message .= '<ul><li>' . $e->getMessage() . ' </li></ul></div>';
                return ['success' => false, 'message' => $message];
            }
        }


        $css .= Configuration::get($this->cfgName . 'codes_css');
        $css = trim(preg_replace('/\s+/', ' ', $css));

        if (Shop::getContext() == Shop::CONTEXT_SHOP) {
            $js = ' ';
            $js .= Configuration::get($this->cfgName . 'codes_js');
            $myFile = $this->local_path . "views/js/custom_s_" . (int)$this->context->shop->getContextShopID() . ".js";
            if (!file_put_contents($myFile, $js)) {
                $message = '<div class="alert alert-danger">' . $this->l('Problem with file permissions') . '</div>';
                return ['success' => false, 'message' => $message];
            }
        }

        if ($allShops) {
            $shops = Shop::getShopsCollection();
            foreach ($shops as $shop) {
                $myFile = $this->local_path . "views/css/custom_s_" . (int)$shop->id . ".css";
                file_put_contents($myFile, $css);
            }
            self::clearAssetsCache();
        } else {
            if (Shop::getContext() == Shop::CONTEXT_SHOP) {
                $myFile = $this->local_path . "views/css/custom_s_" . (int)$this->context->shop->getContextShopID() . ".css";
                if (file_put_contents($myFile, $css)) {
                    self::clearAssetsCache();
                    $message = '<div class="alert alert-success">' . $this->l('Seting saved. Refresh your frontoffice with CTRL + f5 to see results. ') . '</div>';
                    return ['success' => true, 'message' => $message];
                } else {
                    $message = '<div class="alert alert-danger">' . $this->l('Problem with file permissions') . '</div>';
                    return ['success' => false, 'message' => $message];
                }
            }
        }
    }

    public static function clearAssetsCache()
    {
        $files = glob(_PS_THEME_DIR_.'assets/cache/*');

        foreach ($files as $file) {
            if ('index.php' !== basename($file)) {
                Tools::deleteFile($file);
            }
        }

        $version = (int) Configuration::get('PS_CCCJS_VERSION');
        Configuration::updateValue('PS_CCCJS_VERSION', ++$version);
        $version = (int) Configuration::get('PS_CCCCSS_VERSION');
        Configuration::updateValue('PS_CCCCSS_VERSION', ++$version);
    }


    public function configToScssVar($name, $type = 'default', $options = '')
    {
        if ($type == 'default') {
            $val = Configuration::get($this->cfgName . $name);
            $var = '$' . $name . ': ' . (!empty($val) ? $val : 'null') . ';';
        } elseif ($type == 'box-shadow') {
            $boxshadow = json_decode(Configuration::get($this->cfgName . $name), true);
            if ($boxshadow['switch']) {
                $var = '$' . $name . ':  ' . (int)$boxshadow['horizontal'] . 'px ' . (int)$boxshadow['vertical'] . 'px ' . (int)$boxshadow['blur'] . 'px ' . (int)$boxshadow['spread'] . 'px ' . $boxshadow['color'] . ';';
            } else {
                $var = '$' . $name . ': none;';
            }
        } elseif ($type == 'border') {
            $border = json_decode(Configuration::get($this->cfgName . $name), true);
            $var = '$' . $name . ': ' . $border['type'] . ' ' . (int)$border['width'] . 'px ' . $border['color'] . ';';
            $var .= '$' . $name . '_width:' . ((int)$border['width']) . ';' . PHP_EOL;
            $var .= '$' . $name . '_type:' . (!empty($border['type']) ? $border['type'] : 'null') . ';' . PHP_EOL;
        } elseif ($type == 'background') {
            $bg_color = Configuration::get($this->cfgName . $name . 'bg_color');
            $bg_image = Configuration::get($this->cfgName . $name . 'bg_image');
            $bg_repeat = Configuration::get($this->cfgName . $name . 'bg_repeat');
            $bg_attachment = Configuration::get($this->cfgName . $name . 'bg_attachment');
            $bg_position = Configuration::get($this->cfgName . $name . 'bg_position');
            $bg_size = Configuration::get($this->cfgName . $name . 'bg_size');

            if ($bg_image != '') {
                $var = '$' . $name . 'background: ' . (!empty($bg_color) ? $bg_color : '') . ' url("' . $bg_image . '") ' . str_replace('-',
                        ' ', $bg_position) . ' / ' . $bg_size . ' ' . $bg_repeat . ' ' . $bg_attachment . ';';
            } else {
                $var = '$' . $name . 'background: ' . (!empty($bg_color) ? $bg_color : 'null') . ';';
            }
        } elseif ($type == 'font') {
            $font = json_decode(Configuration::get($this->cfgName . $name), true);
            $var = '$' . $name . '_size:' . (!empty($font['size']) ? $font['size'] : 'null') . ';' . PHP_EOL;;
            $var .= '$' . $name . '_spacing:' . (!empty($font['spacing']) ? $font['spacing'] : 'null') . ';' . PHP_EOL;;
            $var .= '$' . $name . '_style:' . (!empty($font['italic']) ? 'italic' : 'normal') . ';' . PHP_EOL;;
            $var .= '$' . $name . '_weight:' . (!empty($font['bold']) ? 'bold' : 'normal') . ';' . PHP_EOL;;
            $var .= '$' . $name . '_uppercase:' . (!empty($font['uppercase']) ? 'uppercase' : 'none') . ';';
        }

        return $var;
    }

    public function hookCalculateGrid($nb)
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

    public function getOptions($options, $full = true)
    {
        $idLang = (int)$this->context->language->id;
        $options = json_decode($options, true);

        $columns = 0;
        $layout = Context::getContext()->shop->theme->getLayoutNameForPage($this->context->controller->php_self);

        if ($layout == 'layout-left-column' || $layout == 'layout-right-column') {
            $columns = 1;
        }

        if ($layout == 'layout-both-columns') {
            $columns = 2;
        }

        //product page grid
        $options['pp_content_width'] = 12 - $options['pp_img_width'] - $options['pp_sidebar'];

        //product list view

        if (isset($this->context->cookie->product_list_view)) {
            $options['pl_default_view'] = $this->context->cookie->product_list_view;
        }

        //products per row - global
        $options['pl_slider_ld'] = $options['pl_grid_ld'] - $columns;
        $options['pl_slider_d'] = $options['pl_grid_d'] - $columns;
        $options['pl_slider_t'] = $options['pl_grid_t'];
        $options['pl_slider_p'] = $options['pl_grid_p'];

        $options['pl_grid_ld'] = $this->hookCalculateGrid($options['pl_grid_ld'] - $columns);
        $options['pl_grid_d'] = $this->hookCalculateGrid($options['pl_grid_d'] - $columns);
        $options['pl_grid_t'] = $this->hookCalculateGrid($options['pl_grid_t']);
        $options['pl_grid_p'] = $this->hookCalculateGrid($options['pl_grid_p']);

        $options['theme_assets'] = __PS_BASE_URI__.'themes/'.$this->context->shop->theme->getName().'/assets/';

        if ($full) {
            //google fonts
            if ($options['typo_bfont_t'] == 'google') {
                $options['google_font_b'] = $options['typo_bfont_g_url'];
            }

            if ($options['typo_hfont_t'] == 'google') {
                $options['google_font_h'] = $options['typo_hfont_g_url'];
            }

            $options['codes_body'] = htmlspecialchars_decode(Configuration::get($this->cfgName . 'codes_body'));
            $options['codes_head'] = htmlspecialchars_decode(Configuration::get($this->cfgName . 'codes_head'));
            $options['h_txt'] = Configuration::get($this->cfgName . 'h_txt', $idLang);
            $options['fc_txt'] = Configuration::get($this->cfgName . 'fc_txt', $idLang);

        }
        return $options;
    }

    public function addJsVars($options)
    {
        $f_fixed = 0;

        if ($options['g_layout'] != 'boxed'){
            $f_fixed = $options['f_fixed'];
        }


        Media::addJsDef(array(
            'iqitTheme' => [
                'rm_sticky' => $options['rm_sticky'],
                'rm_breakpoint' => (int)$options['rm_breakpoint'],
                'op_preloader' => $options['op_preloader'],
                'cart_style' => $options['cart_style'],
                'cart_confirmation' => $options['cart_confirmation'],
                'h_layout' => $options['h_layout'],
                'f_fixed' => $f_fixed,
                'f_layout' => $options['f_layout'],
                'h_absolute' => $options['h_absolute'],
                'h_sticky' => $options['h_sticky'],
                'hw_width' => $options['hw_width'],
                'h_search_type' => $options['h_search_type'],
                'pl_lazyload' => (bool)$options['pl_lazyload'],
                'pl_infinity' => (bool)$options['pl_infinity'],
                'pl_rollover' => (bool)$options['pl_rollover'],
                'pl_crsl_autoplay' => (bool)$options['pl_crsl_autoplay'],
                'pl_slider_ld' => (int)$options['pl_slider_ld'],
                'pl_slider_d' => (int)$options['pl_slider_d'],
                'pl_slider_t' => (int)$options['pl_slider_t'],
                'pl_slider_p' => (int)$options['pl_slider_p'],
                'pp_thumbs' => $options['pp_thumbs'],
                'pp_zoom' => $options['pp_zoom'],
                'pp_tabs' => $options['pp_tabs'],
            ]
        ));

    }

    public function hookHeader()
    {

        if (!Tools::getValue('iqit_fronteditor_token') || !(Tools::getValue('iqit_fronteditor_token') == $this->getFrontEditorToken()) || !Tools::getIsset('id_employee') || !$this->checkEnvironment()) {
            $optionsData = Configuration::get($this->cfgName . 'options');

            if (Shop::getContext() == Shop::CONTEXT_SHOP) {
                $this->context->controller->registerStylesheet('modules-' . $this->name . '-style-custom',
                    'modules/' . $this->name . '/views/css/custom_s_' . (int)$this->context->shop->getContextShopID() . '.css',
                    ['media' => 'all', 'priority' => 150]);
            }

        } else {
            $isEditor = Tools::getValue('isIqitThemeEditor');

            if ($isEditor) {
                $optionsData = Tools::getValue('iqitThemeEditorOptions');
                $optionsData = urldecode($optionsData);
            } else {
                $optionsData = Configuration::get($this->cfgName . 'options');
            }
        }



        //$this->context->controller->requireAssets(['font-awesome']);

        $options = $this->getOptions($optionsData);
        $this->addJsVars($options);

        $this->context->controller->registerJavascript('modules' . $this->name . '-script',
            'modules/' . $this->name . '/views/js/custom_s_' . (int)$this->context->shop->getContextShopID() . '.js',
            ['position' => 'bottom', 'priority' => 150]);
        $this->context->smarty->assign('iqitTheme', $options);

    }

    public function hookProductSearchProvider()
    {
        if (Tools::getIsset('from-xhr')) {

            if (Tools::getIsset('productListView')) {
                $view = Tools::getValue('productListView');
                if ($view == 'grid') {
                    $this->context->cookie->__set('product_list_view', 'grid');
                } elseif ($view == 'list') {
                    $this->context->cookie->__set('product_list_view', 'list');
                }
                $this->context->cookie->write();
            }

            $optionsData = Configuration::get($this->cfgName . 'options');
            $options = $this->getOptions($optionsData, false);
            $configuration['is_catalog'] = (bool) Configuration::isCatalogMode();
            $this->context->smarty->assign(array(
                    'iqitTheme' => $options,
                    'configuration' => $configuration,
                ));
        }
    }

    public function hookActionProductSearchAfter()
    {
        if (Tools::getIsset('ajax') || Tools::getIsset('ajaxMode')) {
            $optionsData = Configuration::get($this->cfgName . 'options');
            $options = $this->getOptions($optionsData, false);
            $configuration['is_catalog'] = (bool) Configuration::isCatalogMode();
            $this->context->smarty->assign(array(
                'iqitTheme' => $options,
                'configuration' => $configuration,
            ));
        }
    }


    public function hookActionProductSearchComplete($hook_args)
    {
        if (isset($hook_args['js_enabled']) && $hook_args['js_enabled']) {
            if (Tools::getIsset('productListView')) {
                $view = Tools::getValue('productListView');
                if ($view == 'grid') {
                    $this->context->cookie->__set('product_list_view', 'grid');
                } elseif ($view == 'list') {
                    $this->context->cookie->__set('product_list_view', 'list');
                }
                $this->context->cookie->write();
            }

            $optionsData = Configuration::get($this->cfgName . 'options');
            $options = $this->getOptions($optionsData, false);
            $this->context->smarty->assign('iqitTheme', $options);
        }
    }



    public function hookActionBeforeElementorWidgetRender()
    {
        $optionsData = Configuration::get($this->cfgName . 'options');
        return $options = $this->getOptions($optionsData, false);
    }

    public function hookDisplayMaintenance()
    {
        $this->hookHeader();
        $this->context->smarty->assign('iqitThemeMaintenanceJs', $this->_path . 'views/js/maintenance.js');
    }
}
