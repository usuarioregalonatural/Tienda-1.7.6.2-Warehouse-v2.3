<?php
/**
* 2016 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2016 SmatDataSoft
*  @license   private
*  @version   5.1.3
*  International Registered Trademark & Property of SmatDataSoft
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class AdminRevsliderController extends ModuleAdminController
{

    public static $_revSliderJSON;

    public function __construct()
    {
        $this->bootstrap = false;

        $this->lang = false;
        parent::__construct();
         self::$_revSliderJSON = array(
            'rev_lang' => array(
                'wrong_alias' => $this->l('-- wrong alias -- '),
                'nav_bullet_arrows_to_none' => $this->l('Navigation Bullets and Arrows are now set to none.'),
                'create_template' => $this->l('Create Template'),
                'really_want_to_delete' => $this->l('Do you really want to delete'),
                'sure_to_replace_urls' => $this->l('Are you sure to replace the urls?'),
                'set_settings_on_all_slider' => $this->l('Set selected settings on all Slides of this Slider? (This will be saved immediately)'),
                'select_slide_img' => $this->l('Select Slide Image'),
                'select_slide_video' => $this->l('Select Slide Video'),
                'show_slide_opt' => $this->l('Show Slide Options'),
                'hide_slide_opt' => $this->l('Hide Slide Options'),
                'close' => $this->l('Close'),
                'really_update_global_styles' => $this->l('Really update global styles?'),
                'global_styles_editor' => $this->l('Global Styles Editor'),
                'select_image' => $this->l('Select Image'),
                'video_not_found' => $this->l('No Thumbnail Image Set on Video / Video Not Found / No Valid Video ID'),
                'handle_at_least_three_chars' => $this->l('Handle has to be at least three character long'),
                'really_change_font_sett' => $this->l('Really change font settings?'),
                'really_delete_font' => $this->l('Really delete font?'),
                'class_exist_overwrite' => $this->l('Class already exists, overwrite?'),
                'class_must_be_valid' => $this->l('Class must be a valid CSS class name'),
                'really_overwrite_class' => $this->l('Really overwrite Class?'),
                'relly_delete_class' => $this->l('Really delete Class'),
                'class_this_cant_be_undone' => $this->l('? This can\'t be undone!'),
                'this_class_does_not_exist' => $this->l('This class does not exist.'),
                'making_changes_will_probably_overwrite_advanced' => $this->l('Making changes to these settings will probably overwrite advanced settings. Continue?'),
                'select_static_layer_image' => $this->l('Select Static Layer Image'),
                'select_layer_image' => $this->l('Select Layer Image'),
                'really_want_to_delete_all_layer' => $this->l('Do you really want to delete all the layers?'),
                'layer_animation_editor' => $this->l('Layer Animation Editor'),
                'animation_exists_overwrite' => $this->l('Animation already exists, overwrite?'),
                'really_overwrite_animation' => $this->l('Really overwrite animation?'),
                'default_animations_cant_delete' => $this->l('Default animations can\'t be deleted'),
                'must_be_greater_than_start_time' => $this->l('Must be greater than start time'),
                'sel_layer_not_set' => $this->l('Selected layer not set'),
                'edit_layer_start' => $this->l('Edit Layer Start'),
                'edit_layer_end' => $this->l('Edit Layer End'),
                'default_animations_cant_rename' => $this->l('Default Animations can\'t be renamed'),
                'anim_name_already_exists' => $this->l('Animationname already existing'),
                'css_name_already_exists' => $this->l('CSS classname already existing'),
                'css_orig_name_does_not_exists' => $this->l('Original CSS classname not found'),
                'enter_correct_class_name' => $this->l('Enter a correct class name'),
                'class_not_found' => $this->l('Class not found in database'),
                'css_name_does_not_exists' => $this->l('CSS classname not found'),
                'delete_this_caption' => $this->l('Delete this caption? This may affect other Slider'),
                'this_will_change_the_class' => $this->l('This will update the Class with the current set Style settings, this may affect other Sliders. Proceed?'),
                'unsaved_changes_will_not_be_added' => $this->l('Template will have the state of the last save, proceed?'),
                'please_enter_a_slide_title' => $this->l('Please enter a Slide title'),
                'please_wait_a_moment' => $this->l('Please Wait a Moment'),
                'copy_move' => $this->l('Copy / Move'),
                'preset_loaded' => $this->l('Preset Loaded'),
                'add_bulk_slides' => $this->l('Add Bulk Slides'),
                'select_image' => $this->l('Select Image'),
                'arrows' => $this->l('Arrows'),
                'bullets' => $this->l('Bullets'),
                'thumbnails' => $this->l('Thumbnails'),
                'tabs' => $this->l('Tabs'),
                'delete_navigation' => $this->l('Delete this Navigation?'),
                'could_not_update_nav_name' => $this->l('Navigation name could not be updated'),
                'name_too_short_sanitize_3' => $this->l('Name too short, at least 3 letters between a-zA-z needed'),
                'nav_name_already_exists' => $this->l('Navigation name already exists, please choose a different name'),
                'remove_nav_element' => $this->l('Remove current element from Navigation?'),
                'create_this_nav_element' => $this->l('This navigation element does not exist, create one?'),
                'overwrite_animation' => $this->l('Overwrite current animation?'),
                'cant_modify_default_anims' => $this->l('Default animations can\'t be changed'),
                'anim_with_handle_exists' => $this->l('Animation already existing with given handle, please choose a different name.'),
                'really_delete_anim' => $this->l('Really delete animation:'),
                'this_will_reset_navigation' => $this->l('This will reset the navigation, continue?'),
                'preset_name_already_exists' => $this->l('Preset name already exists, please choose a different name'),
                'delete_preset' => $this->l('Really delete this preset?'),
                'update_preset' => $this->l('This will update the preset with the current settings. Proceed?'),
                'maybe_wrong_yt_id' => $this->l('No Thumbnail Image Set on Video / Video Not Found / No Valid Video ID'),
                'preset_not_found' => $this->l('Preset not found'),
                'cover_image_needs_to_be_set' => $this->l('Cover Image need to be set for videos'),
                'remove_this_action' => $this->l('Really remove this action?'),
                'layer_action_by' => $this->l('Layer is triggered by '),
                'due_to_action' => $this->l(' due to action: '),
                'layer' => $this->l('layer:'),
                'start_layer_in' => $this->l('Start Layer "in" animation'),
                'start_layer_out' => $this->l('Start Layer "out" animation'),
                'start_video' => $this->l('Start Video'),
                'stop_video' => $this->l('Stop Video'),
                'toggle_layer_anim' => $this->l('Toggle Layer Animation'),
                'toggle_video' => $this->l('Toggle Video'),
                'last_slide' => $this->l('Last Slide'),
                'simulate_click' => $this->l('Simulate Click'),
                'togglefullscreen' => $this->l('Toggle FullScreen'),
                'gofullscreen' => $this->l('Go FullScreen'),
                'exitfullscreen' => $this->l('Exit FullScreen'),
                'toggle_class' => $this->l('Toogle Class'),
                'copy_styles_to_hover_from_idle' => $this->l('Copy hover styles to idle?'),
                'copy_styles_to_idle_from_hover' => $this->l('Copy idle styles to hover?'),
                'select_at_least_one_device_type' => $this->l('Please select at least one device type'),
                'please_select_first_an_existing_style' => $this->l('Please select an existing Style Template'),
                'cant_remove_last_transition' => $this->l('Can not remove last transition!'),
                'name_is_default_animations_cant_be_changed' => $this->l('Given animation name is a default animation. These can not be changed.'),
                'override_animation' => $this->l('Animation exists, override existing animation?'),
                'this_feature_only_if_activated' => $this->l('This feature is only available if you activate Slider Revolution for this installation'),
                'unsaved_data_will_be_lost_proceed' => $this->l('Unsaved data will be lost, proceed?'),
                'is_loading' => $this->l('is Loading...'),
                'google_fonts_loaded' => $this->l('Google Fonts Loaded'),
                'delete_layer' => $this->l('Delete Layer?'),
                'this_template_requires_version' => $this->l('This template requires at least version'),
                'of_slider_revolution' => $this->l('of Slider Revolution to work.'),
                'slider_revolution_shortcode_creator' => $this->l('Slider Revolution Shortcode Creator'),
                'slider_informations_are_missing' => $this->l('Slider informations are missing!'),
                'shortcode_generator' => $this->l('Shortcode Generator'),
                'please_add_at_least_one_layer' => $this->l('Please add at least one Layer.'),
                'choose_image' => $this->l('Choose Image'),
                'shortcode_parsing_successfull' => $this->l('Shortcode parsing successfull. Items can be found in step 3'),
                'shortcode_could_not_be_correctly_parsed' => $this->l('Shortcode could not be parsed.')
            )
        );

    }

     public function setMedia($isNewTheme = false)
    {
        parent::setMedia();
        
         $this->context->controller->addJqueryUI(array('ui.core'));
         $this->context->controller->addJqueryPlugin('autocomplete');
        $path_css = _MODULE_DIR_ . $this->module->name.'/admin/assets/css/';
        $path_js = _MODULE_DIR_ . $this->module->name.'/admin/assets/js/';
        $this->addCSS($path_css . 'admin.css'); 
        $this->addCSS($path_css . 'tipsy.css'); 
        $this->addCSS($path_css . 'colors.min.css'); 
        $this->addCSS($path_css . 'edit_layers.css'); 
        $this->addCSS($path_css . 'global.css'); 
        $this->addCSS(_MODULE_DIR_ . $this->module->name  . '/public/assets/css/settings.css');  
        
        Media::addJsDef(self::$_revSliderJSON);
        $this->addCSS("//fonts.googleapis.com/css?family=Open+Sans:400,300,700,600,800");
        $this->addCSS($path_css . 'thickbox.css'); 
        $this->context->controller->addJqueryUI(array('ui.dialog'));
        $this->addCSS($path_js . 'codemirror/codemirror.css'); 
        $this->addCSS($path_css . 'color-picker.css'); 
        $this->addCSS($path_css . 'tp-color-picker.css'); 
        $this->addCSS(_MODULE_DIR_ . $this->module->name . '/public/assets/fonts/font-awesome/css/font-awesome.css'); 
        $this->addCSS(_MODULE_DIR_ . $this->module->name . '/public/assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css'); 
        $this->addCSS($path_css . 'demo.css'); 
        
        $this->addJS($path_js . 'jquery/core.min.js');
        $this->addJS($path_js . 'underscore.min.js'); 
        $this->context->controller->addJqueryUI(array('ui.widget'));
        $this->context->controller->addJqueryUI(array('ui.mouse'));
        $this->context->controller->addJqueryUI(array('ui.accordion'));
        $this->context->controller->addJqueryUI(array('ui.datepicker'));
        $this->context->controller->addJqueryUI(array('ui.slider'));
        $this->context->controller->addJqueryUI(array('ui.menu'));
         $this->context->controller->addJqueryUI(array('ui.autocomplete'));
        $this->context->controller->addJqueryUI(array('ui.sortable'));
        $this->context->controller->addJqueryUI(array('ui.droppable'));
        $this->context->controller->addJqueryUI(array('ui.tabs'));
        $this->addJS($path_js . 'color-picker.js');
        $this->context->controller->addJqueryUI(array('ui.resizable'));
        $this->context->controller->addJqueryUI(array('ui.draggable'));
        $this->addJS($path_js . 'settings.js');
        $this->addJS($path_js . 'admin.js');
        $this->addJS($path_js . 'thickbox.js');
        $this->addJS($path_js . 'jquery.tipsy.js');
        $this->addJS($path_js . 'codemirror/codemirror.js'); 
        $this->addJS($path_js . 'codemirror/util/match-highlighter.js');
        $this->addJS($path_js . 'codemirror/util/searchcursor.js');
        $this->addJS($path_js . 'codemirror/css.js');
        $this->addJS($path_js . 'codemirror/xml.js');
        $this->addJS($path_js . 'edit_layers_timeline.js');
        $this->addJS($path_js . 'context_menu.js');
        $this->addJS($path_js . 'edit_layers.js');
        $this->addJS($path_js . 'css_editor.js');
        $this->addJS($path_js . 'rev_admin.js');
        $this->context->controller->addJqueryUI(array('ui.position'));
        $this->addJS(_MODULE_DIR_ . $this->module->name  . '/public/assets/js/jquery.themepunch.tools.min.js');
        $this->addJS(_MODULE_DIR_ . $this->module->name  . '/public/assets/js/tp-color-picker.min.js');
        $this->addJS($path_js . 'iris.min.js'); 
        
        if(Tools::getValue("page")=='rev_addon'){
            $this->addCSS(_MODULE_DIR_ . $this->module->name  . '/admin/assets/css/rev_addon-admin.css');
        $this->addJS(_MODULE_DIR_ . $this->module->name  . '/admin/assets/js/rev_addon-admin.js');
        }
//         
    }
    public function initContent(){
      
        $this->content = $this->displayHeader();
        $this->content .=  $this->overview();
        $this->content .=   $this->displayfooter();
      
        parent::initContent();
    }
    public function overview() {
        
                ob_start(); 
                $productAdmin = new RevSliderAdmin();
                $output = ob_get_contents();
                ob_end_clean();
             //   die($output);
                return $output;
    }
 
}
