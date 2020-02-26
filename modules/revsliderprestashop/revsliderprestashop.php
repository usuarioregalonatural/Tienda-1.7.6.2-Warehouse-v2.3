<?php
/**
* 2017 Revolution Slider
*
*  @author    SmatDataSoft <support@smartdatasoft.com>
*  @copyright 2017 SmatDataSoft
*  @license   private
*  @version   5.4.7.5
*  International Registered Trademark & Property of SmatDataSoft
*/

if (!defined('_PS_VERSION_')) {
    exit;
}
if (!defined('_REV_VERSION_')) {
    define('_REV_VERSION_', '5.4.7.5');
}
if (!defined('__DIR__')) {
    define('__DIR__', dirname(__FILE__));
}
if (!defined('RS_DEMO')) {
    define( 'RS_DEMO', false );
}

$currentFolder = _PS_MODULE_DIR_ . 'revsliderprestashop';
require_once $currentFolder . '/revslider-loader.php';
if(Module::isInstalled('RevsliderPrestashop')){
  require_once $currentFolder . '/revslider-admin.class.php';
 
}

class RevsliderPrestashop extends Module
{

    public static $wpdb;
    public static $lang;
    public static $_url;
    public static $instance;
    public static $_revSliderJSON;

    public function __construct()
    {
        $this->name = 'revsliderprestashop';
        $this->tab = 'front_office_features';

        $this->author = 'smartdatasoft';
        $this->need_instance = 0;
        $this->secure_key = Tools::encrypt($this->name);
       // $this->addAsTrusted();
        $this->module_key = "c26f80de213c6794543753a95e53d2f6";
        

        $this->version = '5.4.7.5';
        parent::__construct();
        if (@RevsliderPrestashop::getIsset($this->context->controller->admin_webpath)) {
            self::$lang = $this->getLang();
        }
        self::$wpdb = rev_db_class::rev_db_instance();
        
        self::$_url = $this->_path;
        $this->displayName = $this->l('Revolution Slider.');
        $this->description = $this->l('Revolution Slider - Premium responsive Prestashop slider');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);

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

    public static function getInstance()
    {
        return Module::getInstanceByName('revsliderprestashop');
    }

    public static function GetByAlias($alias){
        $wpdb = rev_db_class::rev_db_instance();
            $where = $wpdb->prepare("alias = %s  AND `type` != 'template'", array($alias)); 
	    return $sliderData = $wpdb->fetchSingle(_DB_PREFIX_.RevSliderGlobals::TABLE_SLIDERS_NAME,$where);
        }
    public static function revSliderShortcode($args)
    {
        if (!class_exists('RevSliderFront')) {
            require_once dirname(__FILE__) . '/revslider-front.class.php';
            new RevSliderFront(ABSPATH);
        }
        $sliderAlias = UniteFunctionsRev::getVal($args, 0);
        $current_lang = RevSliderWpml::getCurrentLang(); 
        ob_start();
        $slider_array = self::GetByAlias($sliderAlias);
        if(_PS_VERSION_ < 1.7){
                                    RevSliderFront::rev_head_front(); 
                                }else{
                                    $slider_id =$slider_array['id'];
                                    $wpdb = rev_db_class::rev_db_instance();
                                    $sliderData = $wpdb->fetchSingle(_DB_PREFIX_.RevSliderGlobals::TABLE_SLIDERS_NAME, $wpdb->prepare("id = %s", array($slider_id)));
                                    $params = json_decode($sliderData['params'],true);
                                    self::loadAddonAssetsSpeicifically($params,$sliderData);
                                }
        $slider = RevSliderOutput::putSlider($slider_array['id'], '',array(),array(),array(),$current_lang);
        if(_PS_VERSION_ < 1.7){
                                   RevSliderFront::rev_foot_front();; 
                                }
        $content = ob_get_clean();
        if (!empty($slider)) {
            $outputType = $slider->getParam("output_type", "");
            switch ($outputType) {
                case "compress":
                    $content = str_replace("\n", "", $content);
                    $content = str_replace("\r", "", $content);
                    return($content);
                    break;
                case "echo":
                    echo $content;  //bypass the filters
                    break;
                default:
                    return($content);
                    break;
            }
        } else {
            return($content);
        }
    }

    public function install()
    {
        if (parent::install() && $this->registerHook('displayHeader') && $this->registerHook('displayBackOfficeHeader') && $this->registerHook('displayRevSlider') && $this->moduleControllerRegistration() && $this->registerHook('actionShopDataDuplication')) {
            $gethooks = array();
            require_once ABSPATH . "/hook/hook.php";
            foreach (array_keys($gethooks) as $hook) {
                if ($hook != '') {
                    $this->registerHook($hook);
                }
            } 
            $res = self::installTables(); 
            return true;
        }
        return false;
    }

    public static function installTables(){
        self::createDBTables();
    }
    public static function createDBTables() {

           $res = self::createTable(GlobalsRevSlider::TABLE_SLIDERS_NAME);

            $res &= self::createTable(GlobalsRevSlider::TABLE_SLIDES_NAME); 
            $res &= self::createTable(GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME);

            $res &= self::createTable(GlobalsRevSlider::TABLE_CSS_NAME);
            $res &= self::createTable(GlobalsRevSlider::TABLE_NAVIGATION_NAME);  
            $res &= self::createTable(GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME);

            $res &= self::createTable(GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES);
            
            $res &= self::createTable(GlobalsRevSlider::TABLE_REVSLIDER_OPTIONS_NAME);
         
       //     self::insertValues();
            return $res;
        }

        public static function deleteDBTables() {

            $res = self::deleteDBTable(GlobalsRevSlider::TABLE_SLIDERS_NAME);

            $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_SLIDES_NAME);

            $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME);

            
            $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_NAVIGATION_NAME);
            $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_REVSLIDER_OPTIONS_NAME);
            
            $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_CSS_NAME);

            $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME);

            $res &= self::deleteDBTable(GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES);

            return $res;
        }
        public static function deleteDBTable($tableName) {

            if (!isset(self::$wpdb))
                $wpdb = rev_db_class::rev_db_instance();
            else
                $wpdb = self::$wpdb;



            $tableName = $wpdb->prefix . $tableName;

            $sql = "DROP TABLE IF EXISTS {$tableName}";

            $q = $wpdb->query($sql);

            if ($q)
                return true;
        }
        public static function createTable($tableName) {



            $parseCssToDb = false;


            if (!isset(self::$wpdb))
                $wpdb = rev_db_class::rev_db_instance();
            else
                $wpdb = self::$wpdb;



            $tableRealName = $wpdb->prefix . $tableName;

            switch ($tableName) {

                case GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES: 
                    $sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(

                                                ID INT(10) NOT NULL AUTO_INCREMENT,

                                                file_name VARCHAR(100) NOT NULL, 
                                                subdir VARCHAR(100) NOT NULL,                                                

                                                PRIMARY KEY (ID)

                                            )DEFAULT CHARSET=utf8;"; 
                    break;
                case GlobalsRevSlider::TABLE_REVSLIDER_OPTIONS_NAME: 
                    $sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(

                                                option_id INT(10) NOT NULL AUTO_INCREMENT,

                                                option_name VARCHAR(100) NOT NULL,                                                

                                                option_value longtext NOT NULL,
                                                
                                                PRIMARY KEY (option_id)

                                            )DEFAULT CHARSET=utf8;"; 
                    break;


                case GlobalsRevSlider::TABLE_SLIDERS_NAME: 
                    $sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}( 
							  `id` int(11) NOT NULL AUTO_INCREMENT, 
                                                            `title` tinytext NOT NULL,
                                                            `alias` tinytext,
                                                            `params` longtext NOT NULL,
                                                            `settings` text,
                                                            `type` varchar(191) NOT NULL DEFAULT '',
                                                            PRIMARY KEY (`id`)

							)DEFAULT CHARSET=utf8;";

                    break;
                case GlobalsRevSlider::TABLE_STATIC_SLIDES_NAME:
                    $sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(
								  `id` int(11) NOT NULL AUTO_INCREMENT,
                                                                    `slider_id` int(9) NOT NULL,
                                                                    `params` longtext NOT NULL,
                                                                    `layers` longtext NOT NULL,
                                                                    `settings` text NOT NULL,
                                                                    PRIMARY KEY (`id`)
								)DEFAULT CHARSET=utf8;";
                    break;
                case GlobalsRevSlider::TABLE_SLIDES_NAME:

                    $sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(

								   `id` int(11) NOT NULL AUTO_INCREMENT,
                                                                    `slider_id` int(9) NOT NULL,
                                                                    `slide_order` int(11) NOT NULL,
                                                                    `params` longtext NOT NULL,
                                                                    `layers` longtext NOT NULL,
                                                                    `settings` text NOT NULL,
                                                                    PRIMARY KEY (`id`)

								)DEFAULT CHARSET=utf8;";

                    break; 
                case GlobalsRevSlider::TABLE_NAVIGATION_NAME:

                    $sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(

								  `id` int(11) NOT NULL AUTO_INCREMENT,
                                                                    `name` varchar(191) NOT NULL,
                                                                    `handle` varchar(191) NOT NULL,
                                                                    `css` longtext NOT NULL,
                                                                    `markup` longtext NOT NULL,
                                                                    `settings` longtext NOT NULL,
                                                                    PRIMARY KEY (`id`)
								)DEFAULT CHARSET=utf8;";

                    break; 
                case GlobalsRevSlider::TABLE_CSS_NAME:

                    $sql = "CREATE TABLE IF NOT EXISTS {$tableRealName}(
                                        `id` int(11) NOT NULL AUTO_INCREMENT,
                                          `handle` text NOT NULL,
                                          `settings` longtext,
                                          `hover` longtext,
                                          `params` longtext NOT NULL,
                                          `advanced` longtext,
                                          PRIMARY KEY (`id`)

								)DEFAULT CHARSET=utf8;";

                    $parseCssToDb = true;
                  
                    break;

                case GlobalsRevSlider::TABLE_LAYER_ANIMS_NAME:

                    $sql = "CREATE TABLE IF NOT EXISTS " . $tableRealName . " (

								  id int(9) NOT NULL AUTO_INCREMENT,

								  handle TEXT NOT NULL,

								  params longtext NOT NULL,

								  PRIMARY KEY (id)

								)DEFAULT CHARSET=utf8;";

                    break;

                

                default:

                    UniteFunctionsRev::throwError("table: $tableName not found");

                    break;
            }

            $q = $wpdb->query($sql);
          //  self::sds_caption_css_init($parseCssToDb);
            return $q;
        }

    public function uninstall()
    {
                
        if (parent::uninstall()) {
                
            $res = $this->moduleControllerUnRegistration();
            require_once ABSPATH . "/revslider-admin.class.php";
            $res &= RevSliderAdmin::deleteDBTables();
            $res &= Configuration::deleteByName('sds_rev_hooks');
            $res &= Configuration::deleteByName('tp-google-fonts');
            $this->clearStaticStyles();
            return (bool) $res;
        }
        return false;
    }

    public function clearStaticStyles()
    {
        if (file_exists(ABSPATH . '/public/assets/css/static-captions.css')) {
            file_put_contents(ABSPATH . '/public/assets/css/static-captions.css', '');
        }
    }

    public function hookdisplayHeader()
    {
        $css_url = "{$this->_path}public/assets/";
        $js_url = "{$this->_path}public/assets/";

        $this->context->controller->addCSS($css_url . 'fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css');
        $this->context->controller->addCSS($css_url . 'css/settings.css');
        $this->context->controller->addCSS($css_url . 'css/static-captions.css');
        $this->context->controller->addCSS($css_url . 'css/dynamic-captions.css');
        $this->context->controller->addCSS($css_url . 'css/front.css');
        $operations = new RevSliderOperations();
		$arrValues = $operations->getGeneralSettingsValues(); 
		$load_all_javascript = RevSliderFunctions::getVal($arrValues, "load_all_javascript","off");
        if(_PS_VERSION_ >= 1.7){
             $this->context->controller->registerJavascript('modules-revsliderprestashop12', 'modules/'.$this->name.'/public/assets/js/jquery.themepunch.tools.min.js', ['position' => 'bottom', 'priority' => 1500]);        
             $this->context->controller->registerJavascript('modules-revsliderprestashop13', 'modules/'.$this->name.'/public/assets/js/jquery.themepunch.revolution.min.js', ['position' => 'bottom', 'priority' => 1500]);
                if($load_all_javascript !== 'off'){
                    $this->context->controller->registerJavascript('modules-revsliderprestashop3', 'modules/'.$this->name.'/public/assets/js/extensions/revolution.extension.actions.min.js', ['position' => 'bottom', 'priority' => 1500]);
                    $this->context->controller->registerJavascript('modules-revsliderprestashop4', 'modules/'.$this->name.'/public/assets/js/extensions/revolution.extension.carousel.min.js', ['position' => 'bottom', 'priority' => 1500]);
                    $this->context->controller->registerJavascript('modules-revsliderprestashop5', 'modules/'.$this->name.'/public/assets/js/extensions/revolution.extension.kenburn.min.js', ['position' => 'bottom', 'priority' => 1500]);
                    $this->context->controller->registerJavascript('modules-revsliderprestashop6', 'modules/'.$this->name.'/public/assets/js/extensions/revolution.extension.layeranimation.min.js', ['position' => 'bottom', 'priority' => 1500]);
                    $this->context->controller->registerJavascript('modules-revsliderprestashop7', 'modules/'.$this->name.'/public/assets/js/extensions/revolution.extension.migration.min.js', ['position' => 'bottom', 'priority' => 1500]);
                    $this->context->controller->registerJavascript('modules-revsliderprestashop8', 'modules/'.$this->name.'/public/assets/js/extensions/revolution.extension.navigation.min.js', ['position' => 'bottom', 'priority' => 1500]);
                    $this->context->controller->registerJavascript('modules-revsliderprestashop9', 'modules/'.$this->name.'/public/assets/js/extensions/revolution.extension.parallax.min.js', ['position' => 'bottom', 'priority' => 1500]);
                    $this->context->controller->registerJavascript('modules-revsliderprestashop10', 'modules/'.$this->name.'/public/assets/js/extensions/revolution.extension.slideanims.min.js', ['position' => 'bottom', 'priority' => 1500]);
                    $this->context->controller->registerJavascript('modules-revsliderprestashop11', 'modules/'.$this->name.'/public/assets/js/extensions/revolution.extension.video.min.js', ['position' => 'bottom', 'priority' => 1500]);   
                    }
                    $this->addonAssets();
                    
        }else{
                    $this->context->controller->addJS($js_url . 'js/jquery.themepunch.tools.min.js');
                    $this->context->controller->addJS($js_url . 'js/jquery.themepunch.revolution.min.js');
                    if($load_all_javascript !== 'off'){
                        $this->context->controller->addJS($js_url . 'js/extensions/revolution.extension.actions.min.js');
                        $this->context->controller->addJS($js_url . 'js/extensions/revolution.extension.carousel.min.js');
                        $this->context->controller->addJS($js_url . 'js/extensions/revolution.extension.kenburn.min.js');
                        $this->context->controller->addJS($js_url . 'js/extensions/revolution.extension.layeranimation.min.js');
                        $this->context->controller->addJS($js_url . 'js/extensions/revolution.extension.migration.min.js');
                        $this->context->controller->addJS($js_url . 'js/extensions/revolution.extension.navigation.min.js');
                        $this->context->controller->addJS($js_url . 'js/extensions/revolution.extension.parallax.min.js');
                        $this->context->controller->addJS($js_url . 'js/extensions/revolution.extension.slideanims.min.js');
                        $this->context->controller->addJS($js_url . 'js/extensions/revolution.extension.video.min.js'); 
                        }   
                    }
        
        
//        $pf = new ThemePunchFonts();
//        $pf->registerFonts();
    }
public static function loadAddonAssetsSpeicifically($params,$slider){
         if(isset($params->filmstrip_enabled)){
                
                                Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-filmstrip-addon/public/assets/css/revolution.addon.filmstrip.css');
                                Context::getContext()->controller->registerJavascript('addon-filmstrip', 'modules/'.'revsliderprestashop'.'/addons/revslider-filmstrip-addon/public/assets/js/revolution.addon.filmstrip.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            if(isset($params->particles_enabled)){
                
                                Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-particles-addon/public/assets/css/revolution.addon.particles.css');
                                Context::getContext()->controller->registerJavascript('addon-particles', 'modules/'.'revsliderprestashop'.'/addons/revslider-particles-addon/public/assets/js/revolution.addon.particles.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            if(isset($params->polyfold_bottom_enabled) || isset($params->polyfold_top_enabled)){
                
                                Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-polyfold-addon/public/assets/css/revolution.addon.polyfold.css');
                                Context::getContext()->controller->registerJavascript('addon-polyfold', 'modules/'.'revsliderprestashop'.'/addons/revslider-polyfold-addon/public/assets/js/revolution.addon.polyfold.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            if(isset($params->typewriter_defaults_enabled)){
                
                                Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-typewriter-addon/public/assets/css/revolution.addon.typewriter.css');
                                Context::getContext()->controller->registerJavascript('addon-typewriter', 'modules/'.'revsliderprestashop'.'/addons/revslider-typewriter-addon/public/assets/js/revolution.addon.typewriter.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            
                            if(isset($params->slicey_enabled)){
                
                                Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-slicey-addon/public/assets/css/revolution.addon.slicey.css');
                                Context::getContext()->controller->registerJavascript('addon-slicey', 'modules/'.'revsliderprestashop'.'/addons/revslider-slicey-addon/public/assets/js/revolution.addon.slicey.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            if(isset($params->snow_enabled)){
                
                                Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-snow-addon/public/assets/css/revolution.addon.snow.css');
                                Context::getContext()->controller->registerJavascript('addon-snow', 'modules/'.'revsliderprestashop'.'/addons/revslider-snow-addon/public/assets/js/revolution.addon.snow.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            if(isset($params->wb_enable)){
                
                                Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-whiteboard-addon/public/assets/css/revolution.addon.whiteboard.css');
                                Context::getContext()->controller->registerJavascript('addon-whiteboard', 'modules/'.'revsliderprestashop'.'/addons/revslider-whiteboard-addon/public/assets/js/revolution.addon.whiteboard.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            $slider = (object)$slider;
                            $params = Tools::jsonDecode($slider->params,true);
                            
                            if(isset($params['revealer_enabled']) && $params['revealer_enabled'] == 'true'){
                                    Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-revealer-addon/public/assets/css/revolution.addon.revealer.preloaders.css');
                                Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-revealer-addon/public/assets/css/revolution.addon.revealer.css');
                                    Context::getContext()->controller->registerJavascript('addon-revealer', 'modules/'.'revsliderprestashop'.'/addons/revslider-revealer-addon/public/assets/js/revolution.addon.revealer.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            if(isset($params['panorama_enabled']) && $params['panorama_enabled'] == 'true'){
                                    Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-panorama-addon/public/assets/css/revolution.addon.panorama.css');
                                Context::getContext()->controller->registerJavascript('addon-panorama', 'modules/'.'revsliderprestashop'.'/addons/revslider-panorama-addon/public/assets/js/three.min.js', ['position' => 'bottom', 'priority' => 1500]); 
                                    Context::getContext()->controller->registerJavascript('addon-panorama', 'modules/'.'revsliderprestashop'.'/addons/revslider-panorama-addon/public/assets/js/revolution.addon.panorama.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                             if(isset($params['duotonefilters_enabled']) && $params['duotonefilters_enabled'] == 'true'){
                                    Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-duotonefilters-addon/public/assets/css/revolution.addon.duotonefilters.css');
                                Context::getContext()->controller->registerJavascript('addon-duotonefilters', 'modules/'.'revsliderprestashop'.'/addons/revslider-duotonefilters-addon/public/assets/js/revolution.addon.duotonefilters.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                             }
                            if(isset($params['bubblemorph_enabled']) && $params['bubblemorph_enabled'] == 'true'){
                                    Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-bubblemorph-addon/public/assets/css/revolution.addon.bubblemorph.css');
                                Context::getContext()->controller->registerJavascript('addon-bubblemorph', 'modules/'.'revsliderprestashop'.'/addons/revslider-bubblemorph-addon/public/assets/js/revolution.addon.bubblemorph.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            
                            if(isset($params['beforeafter_enabled']) && $params['beforeafter_enabled'] == 'true'){
                              //  die("fired");
                                Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-beforeafter-addon/public/assets/css/revolution.addon.beforeafter.css');
                                Context::getContext()->controller->registerJavascript('addon-beforeafter', 'modules/'.'revsliderprestashop'.'/addons/revslider-beforeafter-addon/public/assets/js/revolution.addon.beforeafter.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            if(isset($params['revslider-weather-enabled']) && $params['revslider-weather-enabled'] == 'true'){
                                 Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-weather-addon/public/assets/css/revslider-weather-addon-icon.css');
                                    Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-weather-addon/public/assets/css/revslider-weather-addon-public.css');
                                Context::getContext()->controller->registerJavascript('addon-weather', 'modules/'.'revsliderprestashop'.'/addons/revslider-weather-addon/public/assets/js/revslider-weather-addon-public.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            if(isset($params['revslider-refresh-enabled']) && $params['revslider-refresh-enabled'] == 'true'){
                                    Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-refresh-addon/public/assets/css/revslider-refresh-addon-public.css');
                                Context::getContext()->controller->registerJavascript('addon-refresh', 'modules/'.'revsliderprestashop'.'/addons/revslider-refresh-addon/public/assets/js/revslider-refresh-addon-public.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                           if(isset($params['liquideffect_enabled']) && $params['liquideffect_enabled'] == 'true'){
                                    Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-liquideffect-addon/public/assets/css/liquideffect.css');
                                Context::getContext()->controller->registerJavascript('addon-liquideffect-pixi', 'modules/'.'revsliderprestashop'.'/addons/revslider-liquideffect-addon/public/assets/js/pixi.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                                    Context::getContext()->controller->registerJavascript('addon-liquideffect', 'modules/'.'revsliderprestashop'.'/addons/revslider-liquideffect-addon/public/assets/js/revolution.addon.liquideffect.min.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                            }
                            $addon_folder_name = "revslider-maintenance-addon/revslider-maintenance-addon.php";
                                if(get_option($addon_folder_name)=='active'){ 
                                    Context::getContext()->controller->addCSS(RS_PLUGIN_ADDONS_URL . 'revslider-maintenance-addon/public/assets/css/revslider-maintenance-addon-public.css');
                                Context::getContext()->controller->registerJavascript('addon-maintenance', 'modules/'.'revsliderprestashop'.'/addons/revslider-maintenance-addon/public/assets/js/revslider-maintenance-addon-public.js', ['position' => 'bottom', 'priority' => 1500]);  
            
                                } 
    }
 public function addonAssets(){
                
        $cache_id = 'revslider_front_displayHome';
       
        if (!Cache::isStored($cache_id)) {
            $sliders = $this->hookCommonCb();
            
            $content = '';
            if (!empty($sliders)) {
                ob_start();
                foreach ($sliders as $slider):
                    $slider = (object) $slider;
                    $params = Tools::jsonDecode($slider->params);
                   // var_dump($params);die();
                    if (@RevsliderPrestashop::getIsset($params->template) && $params->template != 'false') {
                        continue;
                    } else {
                        if (@RevsliderPrestashop::getIsset($params->id_shop) && $params->id_shop != Shop::getContextShopID()) {
                            continue;
                        } else { 
                            self::loadAddonAssetsSpeicifically($params,$slider);
                        }
                    }
                endforeach; 
               // die();
            }
        }
    }
    public function hookdisplayBackOfficeHeader()
    {
                
//        if(!Module::isEnabled($this->name)) return;
        $css_url = "{$this->_path}admin/assets/css/adminicon.css";
                
        $this->context->controller->addCSS($css_url);
        UniteFunctionsWPRev::initStaticVars();
                
    }

    public function moduleControllerRegistration()
    {
        $tabvalue = array();
        require_once dirname(__FILE__) . '/install/install_tab.php';
        $languages = Language::getLanguages(true);
        if (@RevsliderPrestashop::getIsset($tabvalue) && !empty($tabvalue)) {
            foreach ($tabvalue as $index => $class) {

                $tabexists = Tab::getIdFromClassName($class['class_name']);

                if ($tabexists) {
                    continue;
                }

                $tab = new Tab();
                $tab->class_name = $class['class_name'];

                if (is_string($class['id_parent']) && !empty($class['id_parent'])) {
                    $id_parent = Tab::getIdFromClassName($class['id_parent']);
                    $tab->id_parent = $id_parent;
                } else {
                    $tab->id_parent = $class['id_parent'];
                }
                $tab->module = $class['module'];

                foreach ($languages as $lang) {
                    $tab->name[$lang['id_lang']] = $class['name'];
                }

                $tab->active = $class['active'];
                $tab->add();
                if (!$tab->id) {
                    return false;
                }
            }
        }
        return true;
    }

    public function installQuickAccess()
    {
        $qick_access = new QuickAccess();
        $qick_access->link = 'index.php?controller=AdminModules&configure=revsliderprestashop&tab_module=front_office_features&module_name=revsliderprestashop';
        $qick_access->new_window = false;
        $languages = Language::getLanguages(false);
        foreach ($languages as $language) {
            $qick_access->name[$language['id_lang']] = 'Revolution Slider';
        }
        $qick_access->add();
        if (!$qick_access->id) {
            return false;
        }
        Configuration::updateValue('REV_QUICK_ACCS', Tools::jsonEncode(array($qick_access->id)));
        return true;
    }

    public function uploadControllerRegistration()
    {
        return true;
    }

    public function moduleControllerUnRegistration()
    {
        //        $ids = Tools::jsonDecode(Configuration::get('REVOLUTION_CONTROLLER_TABS'), true);
        $tabvalue = array();
        require_once dirname(__FILE__) . '/install/install_tab.php';

        if (!empty($tabvalue)) {
            foreach ($tabvalue as $class) {
                $id = Tab::getIdFromClassName($class['class_name']);

                $tab = new Tab($id);
                $tab->delete();
            }
        }
        $quickids = Tools::jsonDecode(Configuration::get('REV_QUICK_ACCS'), true);
        if (@RevsliderPrestashop::getIsset($quickids) && !empty($quickids)) {
            foreach ($quickids as $qid) {
                $quc = new QuickAccess($qid);
                $quc->delete();
            }
        }

        return true;
    }

    public function _prehook()
    {
         if (!class_exists('RevSliderFront')) {
        require_once ABSPATH . "/revslider-front.class.php";
         }
        $revfront = new RevSliderFront(ABSPATH);
        return $revfront;
    }

    public function hookCommonCb()
    {
        $revfront = $this->_prehook();
        $sliders = self::$wpdb->getResults("SELECT * FROM " . self::$wpdb->prefix . GlobalsRevSlider::TABLE_SLIDERS_NAME);
        return $sliders;
    }
                
    public function generateSlider($hookPosition = 'displayHome')
    {
        $cache_id = 'revslider_front_' . $hookPosition;
        if (!Cache::isStored($cache_id)) {
            $sliders = $this->hookCommonCb();
            $content = '';
            if (!empty($sliders)) {
                ob_start();
                foreach ($sliders as $slider):
                    $slider = (object) $slider;
                    $params = Tools::jsonDecode($slider->params);
                    if (@RevsliderPrestashop::getIsset($params->template) && $params->template != 'false') {
                        continue;
                    } else {
                        if (@RevsliderPrestashop::getIsset($params->id_shop) && $params->id_shop != Shop::getContextShopID()) {
                            continue;
                        } else {
                            $tp = (array)$params;
                            if (@RevsliderPrestashop::getIsset($params->displayhook) && $params->displayhook === $hookPosition) {
                                
                                if(_PS_VERSION_ < 1.7){
                                    RevSliderFront::rev_head_front(); 
                                }
                                $current_lang = RevSliderWpml::getCurrentLang(); 
                                RevSliderOutput::putSlider($slider->id, '',array(),array(),array(),$current_lang);
                                if(_PS_VERSION_ < 1.7){
                                   RevSliderFront::rev_foot_front();; 
                                }
                            }elseif (@RevsliderPrestashop::getIsset($tp['displayhook']) && $tp['displayhook'] === $hookPosition) {
                                if(_PS_VERSION_ < 1.7){
                                    RevSliderFront::rev_head_front(); 
                                }
                                $current_lang = RevSliderWpml::getCurrentLang(); 
                                RevSliderOutput::putSlider($slider->id, '',array(),array(),array(),$current_lang);
                                if(_PS_VERSION_ < 1.7){
                                   RevSliderFront::rev_foot_front();; 
                                }
                            }
                        }
                    }
                endforeach;
                $content = ob_get_clean();
                Cache::store($cache_id, $content);
            }
        }
//        $this->smarty->assign('revhome', $content);

        return Cache::retrieve($cache_id);
//        return $this->display(__FILE__, 'views/templates/front/revolution_slider.tpl');
    }

    public function generateSliderById($id = 1)
    {
        if (empty($id)) {
            return $this->l('no id found');
        }

        $cache_id = 'revslider_front_' . $id;
        if (!Cache::isStored($cache_id)) {
            ob_start();
            $current_lang = RevSliderWpml::getCurrentLang(); 
            RevSliderOutput::putSlider($id, '',array(),array(),array(),$current_lang);
            $content = ob_get_clean();
            Cache::store($cache_id, $content);
        }
        return Cache::retrieve($cache_id);
//        $this->smarty->assign('revhome', $content);        
//        return $this->display(__FILE__, 'views/templates/front/revolution_slider.tpl');
    }

    public function getContent()
    {
                Tools::redirectAdmin('index.php?controller=AdminRevslider&token='.Tools::getAdminTokenLite('AdminRevslider'));
    }

    public function __call($function, $args)
    {
        $hook = Tools::substr($function, 0, 4);
        if ($hook == 'hook') {
            $hook_name = Tools::substr($function, 4);
            return $this->generateSlider($hook_name);
        } else {
            return false;
        }
    }

    public function addAsTrusted()
    {
        if (defined('self::CACHE_FILE_TRUSTED_MODULES_LIST') == true) {
            if (@RevsliderPrestashop::getIsset($this->context->controller->controller_name) &&
                $this->context->controller->controller_name == 'AdminModules') {
                $sxe = new SimpleXMLElement('<theme/>');

                $modules = $sxe->addChild('modules');
                $module = $modules->addChild('module');
                $module->addAttribute('action', 'install');
                $module->addAttribute('name', $this->name);

                $trusted = $sxe->saveXML();
                file_put_contents(_PS_ROOT_DIR_ . '/config/xml/themes/' . $this->name . '.xml', $trusted);
                if (is_file(_PS_ROOT_DIR_ . Module::CACHE_FILE_UNTRUSTED_MODULES_LIST)) {
                    Tools::deleteFile(_PS_ROOT_DIR_ . Module::CACHE_FILE_UNTRUSTED_MODULES_LIST);
                }
            }
        }
    }

    public function getLang()
    {
        $str_var = array();
        $str_var['help'] = $this->l('Help');
        $str_var['Revolution_Sliders'] = $this->l('Revolution Sliders');
        $str_var['general_settings'] = $this->l('General Settings');
        $str_var['update'] = $this->l('Update');
        $str_var['Update_Slider_Plugin'] = $this->l('Update Slider Plugin');
        $str_var['Update_Slider'] = $this->l('Update Slider');
        $str_var['Update_rev_Slider_Plugin'] = $this->l('Update Revolution Slider Plugin');
        $str_var['Update_rev_Slider_Plugin_desc'] = $this->l('To update the slider please show the slider install package. The files will be overwriten');
        $str_var['File_example'] = $this->l('File example: revslider.zip');
        $str_var['Choose_update_file'] = $this->l('Choose the update file:');
        $str_var['No_Sliders_Found'] = $this->l('No Sliders Found');
        $str_var['Revolution_Slider_Temp'] = $this->l('Revolution Slider Templates');
        $str_var['No_Template_Found'] = $this->l('No Template Sliders Found');
        $str_var['Import_Slider'] = $this->l('Import Slider');
        $str_var['Choose_import_file'] = $this->l('Choose the import file');
        $str_var['CUSTOM_STYLES'] = $this->l('Note: custom styles will be updated if they exist!');
        $str_var['Custom_Animations'] = $this->l('Custom Animations:');
        $str_var['overwrite'] = $this->l('overwrite');
        $str_var['ID'] = $this->l('ID');
        $str_var['Name'] = $this->l('Name');
        $str_var['Source'] = $this->l('Source');
        $str_var['Display_Hook'] = $this->l('Display Hook');
        $str_var['N_Slides'] = $this->l('N. Slides');
        $str_var['Actions'] = $this->l('Actions');
        $str_var['Settings'] = $this->l('Settings');
        $str_var['HTML'] = $this->l('HTML &LT;/&GT;');
        $str_var['Delete'] = $this->l('Delete');
        $str_var['Deleting_Slide'] = $this->l('Deleting Slide...');
        $str_var['Duplicate'] = $this->l('Duplicate');
        $str_var['Preview'] = $this->l('Preview');
        $str_var['New_Template_Slider'] = $this->l('Create New Template Slider');
        $str_var['Add_Slider_Template'] = $this->l('Add Slider Template');
        $str_var['New_Slider'] = $this->l('Create New Slider');
        $str_var['Hook_Name'] = $this->l('Hook Name:');
        $str_var['Remove'] = $this->l('Remove');
        $str_var['custom_hook_desc'] = $this->l('This block is attached to custom hook. To display it in .tpl file use:');
        $str_var['Add_New_Hook'] = $this->l('Add New Hook');
        $str_var['Add_Hook'] = $this->l('Add Hook');
        $str_var['CSS_JavaScript'] = $this->l('CSS / JavaScript');
        $str_var['Custom_CSS'] = $this->l('Custom CSS');
        $str_var['Custom_JS'] = $this->l('Custom JavaScript');
        $str_var['New_Slider_Temp'] = $this->l('New Slider Template');
        $str_var['New_Sldr'] = $this->l('New Slider');
        $str_var['Main_Slider_Settings'] = $this->l('Main Slider Settings');
        $str_var['theme_style'] = $this->l('(Can be different based on Theme Style)');
        $str_var['BROWSER'] = $this->l('BROWSER');
        $str_var['PAGE'] = $this->l('PAGE');
        $str_var['SLIDER'] = $this->l('SLIDER');
        $str_var['LAYERS_GRID'] = $this->l('LAYERS GRID');
        $str_var['Create_Slider'] = $this->l('Create Slider');
        $str_var['Close'] = $this->l('Close');
        $str_var['Slides_List'] = $this->l('Slides List');
        $str_var['Saving_Order'] = $this->l('Saving Order');
        $str_var['No_Slides_Found'] = $this->l('No Slides Found');
        $str_var['Unpublish_Product'] = $this->l('Unpublish Product');
        $str_var['Publish_Product'] = $this->l('Publish Product');
        $str_var['Edit_Post'] = $this->l('Edit Product');
        $str_var['multiple_sources'] = $this->l('The slides are posts that taken from multiple sources.');
        $str_var['Sort_by'] = $this->l('Sort by');
        $str_var['Updating_Sorting'] = $this->l('Updating Sorting...');
        $str_var['Slider_Settings'] = $this->l('Slider Settings');
        $str_var['Warning_Removing'] = $this->l('Warning! Removing this entry will cause the original wordpress post to be deleted.');
        $str_var['Select_Slide_Image'] = $this->l('Select Slide Image');
        $str_var['Punch_Fonts'] = $this->l('Punch Fonts');
        $str_var['Font_Family'] = $this->l('Font Family:');
        $str_var['Handle'] = $this->l('Handle:');
        $str_var['Parameter'] = $this->l('Parameter:');
        $str_var['Google_Font_desc'] = $this->l('Copy the Google Font Family from <a href="https://www.google.com/fonts" target="_blank">https://www.google.com/fonts</a> like: <strong>Open+Sans:400,700,600</strong>');
        $str_var['Edit'] = $this->l('Edit');
        $str_var['Add_New_Font'] = $this->l('Add New Font');
        $str_var['Add_Font'] = $this->l('Add Font');
        $str_var['Unique_handle'] = $this->l('Unique WordPress handle (Internal use only)');
        $str_var['Parameter'] = $this->l('Parameter');
        $str_var['Unpublish_Slide'] = $this->l('Unpublish Slide');
        $str_var['Publish_Slide'] = $this->l('Publish Slide');
        $str_var['Preview_Slide'] = $this->l('Preview Slide');
        $str_var['copy_move_dialog'] = $this->l('Open copy / move dialog');
        $str_var['copy_move_found'] = $this->l('Copy / move disabled, no more sliders found');
        $str_var['copy_move'] = $this->l('Copy / Move');
        $str_var['Working'] = $this->l('Working...');
        $str_var['Edit_Slider_Template'] = $this->l('Edit Slider Template');
        $str_var['Edit_Slider'] = $this->l('Edit Slider');
        $str_var['Save_Settings'] = $this->l('Save Settings');
        $str_var['Delete_Slider'] = $this->l('Delete Slider');
        $str_var['Preview_Slider'] = $this->l('Preview Slider');
        $str_var['Preview'] = $this->l('Preview');
        $str_var['API_Functions'] = $this->l('API Functions');
        $str_var['API_Methods'] = $this->l('API Methods');
        $str_var['copy_paste_js'] = $this->l('Please copy / paste those functions into your functions js file');
        $str_var['Pause_Slider'] = $this->l('Pause Slider');
        $str_var['Resume_Slider'] = $this->l('Resume Slider');
        $str_var['Previous_Slide'] = $this->l('Previous Slide');
        $str_var['Next_Slide'] = $this->l('Next Slide');
        $str_var['Go_To_Slide'] = $this->l('Go To Slide');
        $str_var['Num_Slides'] = $this->l('Get Num Slides');
        $str_var['Slide_Number'] = $this->l('Get Current Slide Number');
        $str_var['Playing_Slide'] = $this->l('Get Last Playing Slide Number');
        $str_var['External_Scroll'] = $this->l('External Scroll');
        $str_var['Redraw_Slider'] = $this->l('Redraw Slider');
        $str_var['API_Events'] = $this->l('API Events');
        $str_var['jQuery_Functions'] = $this->l('Copy and Paste the Below listed API Functions into your jQuery Functions for Revslider Event Listening');
        $str_var['Slider_l'] = $this->l('Slider:');
        $str_var['Edit_Template_Slide'] = $this->l('Edit Template Slide');
        $str_var['Edit_Slide'] = $this->l('Edit Slide');
        $str_var['Title'] = $this->l('Title:');
        $str_var['Static_Layers'] = $this->l('Static / Global Layers');
        $str_var['Add_Slide'] = $this->l('Add Slide');
        $str_var['slide_language'] = $this->l('Choose slide language');
        $str_var['language_related'] = $this->l('All the language related operations are from');
        $str_var['slides_view'] = $this->l('slides view');
        $str_var['General_Slide_Settings'] = $this->l('General Slide Settings');
        $str_var['Warning_jq_ui'] = $this->l('<b>Warning!!! </b>The jquery ui javascript include that is loaded by some of the plugins are custom made and not contain needed components like autocomplete or draggable function.
                Without those functions the editor may not work correctly. Please remove those custom jquery ui includes in order the editor will work correctly.');
        $str_var['Update_Slide'] = $this->l('Update Slide');
        $str_var['Update_Static_Layers'] = $this->l('Update Static Layers');
        $str_var['updating'] = $this->l('updating....');
        $str_var['To_List'] = $this->l('To Slide List');
        $str_var['Delete_Slide'] = $this->l('Delete Slide');
        $str_var['Delete_this_Slide'] = $this->l('Delete this slide?');
        $str_var['Import_Export'] = $this->l('Import / Export');
        $str_var['Import_Slider'] = $this->l('Import Slider');
        $str_var['note_styles'] = $this->l('Note: custom styles will be updated if they exist!');
        $str_var['Custom_Animations'] = $this->l('Custom Animations:');
        $str_var['overwrite'] = $this->l('overwrite:');
        $str_var['append'] = $this->l('append');
        $str_var['Static_Styles'] = $this->l('Static Styles:');
        $str_var['api-desc'] = $this->l('Note, that when you importing slider, it delete all the current slider settings and slides, then replace it with the new ones');
        $str_var['Export_Slider'] = $this->l('Export Slider');
        $str_var['Export_Slider_Dummy'] = $this->l('Export with Dummy Images');
        $str_var['Replace_Image_Url'] = $this->l('Replace Image Url');
        $str_var['Replace_api_desc'] = $this->l('Replace all layer and background image urls. Example: http://localhost/ to http://yourwbsite.com/. <br> Note, the replace is not reversible');
        $str_var['Replace_From'] = $this->l('Replace From (example - http://localhost)');
        $str_var['Replace_to'] = $this->l('Replace To (example - http://yoursite.com)');
        $str_var['Replace'] = $this->l('Replace');
        $str_var['Replacing'] = $this->l('Replacing...');
        $str_var['Edit_Slides'] = $this->l('Edit Slides');
        $str_var['New_Slide'] = $this->l('New Slide');
        $str_var['New_Transparent'] = $this->l('New Transparent Slide');
        $str_var['Adding_Slide'] = $this->l('Adding Slide...');
        $str_var['Select_image'] = $this->l('Select image or multiple images to add slide or slides');
        $str_var['Static_Global'] = $this->l('Edit Static / Global Layers');
        $str_var['To_Settings'] = $this->l('To Slider Settings');
        $str_var['Do_It'] = $this->l('Do It!');
        $str_var['Copy_move_slide'] = $this->l('Copy / move slide');
        $str_var['Choose_Slider'] = $this->l('Choose Slider');
        $str_var['Choose_Operation'] = $this->l('Choose Operation');
        $str_var['Copy'] = $this->l('Copy');
        $str_var['Move'] = $this->l('Move');
        $str_var['Add_Video_Layout'] = $this->l('Add Video Layout');
        $str_var['Choose_video_type'] = $this->l('Choose video type');
        $str_var['Youtube'] = $this->l('Youtube');
        $str_var['Vimeo'] = $this->l('Vimeo');
        $str_var['HTML5'] = $this->l('HTML5');
        $str_var['Vimeo_ID_URL'] = $this->l('Enter Vimeo ID or URL');
        $str_var['example_30300114'] = $this->l('example:  30300114');
        $str_var['Youtube_ID_URL'] = $this->l('Enter Youtube ID or URL');
        $str_var['example'] = $this->l('example');
        $str_var['Poster_Image_Url'] = $this->l('Poster Image Url');
        $str_var['Video_MP4_Url'] = $this->l('Video MP4 Url');
        $str_var['Video_WEBM_Url'] = $this->l('Video WEBM Url');
        $str_var['Video_OGV_Url'] = $this->l('Video OGV Url');
        $str_var['Video_Size'] = $this->l('Video Size');
        $str_var['Full_Width'] = $this->l('Full Width');
        $str_var['Width'] = $this->l('Width');
        $str_var['Height'] = $this->l('Height');
        $str_var['Cover'] = $this->l('Cover');
        $str_var['Dotted_Overlay'] = $this->l('Dotted Overlay:');
        $str_var['none'] = $this->l('none');
        $str_var['2_2_Black'] = $this->l('2 x 2 Black');
        $str_var['2_2_White'] = $this->l('2 x 2 White');
        $str_var['3_3_Black'] = $this->l('3 x 3 Black');
        $str_var['3_3_White'] = $this->l('3 x 3 White');
        $str_var['Aspect_Ratio'] = $this->l('Aspect Ratio:');
        $str_var['16_9'] = $this->l('16:9');
        $str_var['4_3'] = $this->l('4:3');
        $str_var['Video_Settings'] = $this->l('Video Settings');
        $str_var['Loop_Video'] = $this->l('Loop Video:');
        $str_var['Autoplay'] = $this->l('Autoplay:');
        $str_var['Only_1st_Time'] = $this->l('Only 1st Time:');
        $str_var['Next_Slide_End'] = $this->l('Next Slide On End:');
        $str_var['Force_Rewind'] = $this->l('Force Rewind:');
        $str_var['Hide_Controls'] = $this->l('Hide Controls:');
        $str_var['Mute'] = $this->l('Mute:');
        $str_var['Preview_Image'] = $this->l('Preview Image:');
        $str_var['Set'] = $this->l('Set');
        $str_var['Arguments'] = $this->l('Arguments:');
        $str_var['Add_This_Video'] = $this->l('Add This Video');
        $str_var['Update_Video'] = $this->l('Update Video');
        $str_var['Slider_Main_Image_bg'] = $this->l('Slider Main Image / Background');
        $str_var['Background_Source'] = $this->l('Background Source:');
        $str_var['Image_BG'] = $this->l('Image BG');
        $str_var['Change_Image'] = $this->l('Change Image');
        $str_var['External_URL'] = $this->l('External URL');
        $str_var['Get_External'] = $this->l('Get External');
        $str_var['Transparent'] = $this->l('Transparent');
        $str_var['Solid_Colored'] = $this->l('Solid Colored');
        $str_var['Background_Settings'] = $this->l('Background Settings:');
        $str_var['Background_Fit'] = $this->l('Background Fit:');
        $str_var['contain'] = $this->l('contain');
        $str_var['normal'] = $this->l('normal');
        $str_var['Background_Repeat'] = $this->l('Background Repeat:');
        $str_var['Background_Position'] = $this->l('Background Position:');
        $str_var['center_top'] = $this->l('center top');
        $str_var['center_right'] = $this->l('center right');
        $str_var['center_bottom'] = $this->l('center bottom');
        $str_var['center_center'] = $this->l('center center');
        $str_var['left_top'] = $this->l('left top');
        $str_var['left_center'] = $this->l('left center');
        $str_var['left_bottom'] = $this->l('left bottom');
        $str_var['right_top'] = $this->l('right top');
        $str_var['right_center'] = $this->l('right center');
        $str_var['right_bottom'] = $this->l('right bottom');
        $str_var['Pan_Zoom_Settings'] = $this->l('Ken Burns / Pan Zoom Settings:');
        $str_var['On'] = $this->l('On');
        $str_var['on'] = $this->l('On');
        $str_var['Background'] = $this->l('Background');
        $str_var['Start_Position'] = $this->l('Start Position');
        $str_var['Start_Fit'] = $this->l('Start Fit: (in %)');
        $str_var['End_Position'] = $this->l('End Position');
        $str_var['End_Fit'] = $this->l('End Fit: (in %)');
        $str_var['Duration'] = $this->l('Duration (in ms)');
        $str_var['Slide'] = $this->l('Slide');
        $str_var['slide'] = $this->l('Slide');
        $str_var['Helper_Grid'] = $this->l('Helper Grid:');
        $str_var['Disabled'] = $this->l('Disabled');
        $str_var['Snap_to'] = $this->l('Snap to');
        $str_var['Help_Lines'] = $this->l('Help Lines');
        $str_var['Layers'] = $this->l('Layers');
        $str_var['Show_Layers_from_Slide'] = $this->l('Show Layers from Slide');
        $str_var['Add_Layer'] = $this->l('Add Layer');
        $str_var['Add_Layer_Image'] = $this->l('Add Layer: Image');
        $str_var['Add_Layer_Video'] = $this->l('Add Layer: Video');
        $str_var['Duplicate_Layer'] = $this->l('Duplicate Layer');
        $str_var['Delete_Layer'] = $this->l('Delete Layer');
        $str_var['Delete_All_Layers'] = $this->l('Delete All Layers');
        $str_var['Layers_Timing_Sorting'] = $this->l('Layers Timing & Sorting');
        $str_var['z_Index'] = $this->l('z-Index');
        $str_var['Hide_All_Layers'] = $this->l('Hide All Layers');
        $str_var['Lock_All_Layers'] = $this->l('Lock All Layers');
        $str_var['Snap_to_Slide'] = $this->l('Snap to Slide End / Custom End');
        $str_var['Timing'] = $this->l('Timing');
        $str_var['sh_Timer_Settings'] = $this->l('Show / Hide Timer Settings');
        $str_var['Start'] = $this->l('Start');
        $str_var['End'] = $this->l('End');
        $str_var['Static_Options'] = $this->l('Static Options');
        $str_var['Static_Options_desc'] = $this->l('Static Layers will be shown on every slide in template sliders');
        $str_var['Start_on_Slide'] = $this->l('Start on Slide');
        $str_var['End_on_Slide'] = $this->l('End on Slide');
        $str_var['Layer_General_Parameters'] = $this->l('Layer General Parameters');
        $str_var['Layer_Content'] = $this->l('Layer Content');
        $str_var['Position_Styling'] = $this->l('Align, Position & Styling');
        $str_var['Image_Scale'] = $this->l('Image Scale (dimensions in pixel)');
        $str_var['Reset_Size'] = $this->l('Reset Size');
        $str_var['Final_Rotation'] = $this->l('Final Rotation');
        $str_var['Parallax_Setting'] = $this->l('Parallax Setting');
        $str_var['Layer_Animation'] = $this->l('Layer Animation');
        $str_var['Preview_Transition'] = $this->l('Preview Transition (Star end Endtime is Ignored during Demo)');
        $str_var['LAYER_EXAMPLE'] = $this->l('LAYER EXAMPLE');
        $str_var['Start_Transition'] = $this->l('Start Transition');
        $str_var['Custom_Animation'] = $this->l('Custom Animation');
        $str_var['End_Transition_opt'] = $this->l('End Transition (optional)');
        $str_var['Loop_Animation'] = $this->l('Loop Animation');
        $str_var['Anim_Settings_Panel'] = $this->l('Layer Animation Settings Panel');
        $str_var['Randomize'] = $this->l('Randomize');
        $str_var['Transition'] = $this->l('Transition');
        $str_var['Rotation'] = $this->l('Rotation');
        $str_var['Scale'] = $this->l('Scale');
        $str_var['Skew'] = $this->l('Skew');
        $str_var['Opacity'] = $this->l('Opacity');
        $str_var['Perspective'] = $this->l('Perspective');
        $str_var['Origin'] = $this->l('Origin');
        $str_var['Test_Parameters'] = $this->l('Test Parameters');
        $str_var['Test_Parameters_desc'] = $this->l('These Settings are only for Customizer. Settings can be set per Start and End Animation.');
        $str_var['Speed'] = $this->l('Speed');
        $str_var['Transition_Direction'] = $this->l('Transition Direction');
        $str_var['Overwrite_Animation'] = $this->l('Overwrite the current selected Animation');
        $str_var['new_Animation'] = $this->l(' or save as a new Animation?');
        $str_var['Save_Animation'] = $this->l('Save as Animation:');
        $str_var['Advanced_Params'] = $this->l('Layer Links & Advanced Params');
        $str_var['Links_optional'] = $this->l('Links (optional)');
        $str_var['Caption_Sharp'] = $this->l('Caption Sharp Corners (optional only with BG color)');
        $str_var['Responsive_Settings'] = $this->l('Advanced Responsive Settings');
        $str_var['Attributes_opt'] = $this->l('Attributes (optional)');
        $str_var['Template_Insertions'] = $this->l('Template Insertions');
        $str_var['Post_Placeholders'] = $this->l('Post Replace Placeholders:');
        $str_var['Any_custom_Tag'] = $this->l('Any custom Tag');
        $str_var['Product_Name'] = $this->l('Product Name');
        $str_var['Product_Price'] = $this->l('Product Price');
        $str_var['Product_Srt_Desc'] = $this->l('Product Short Description');
        $str_var['Product_Description'] = $this->l('Product Description');
        $str_var['link_Product'] = $this->l('The link to the Product');
        $str_var['link_Product_Cart'] = $this->l('The link to the Product Add to Cart');
        $str_var['Product_Cat_Default'] = $this->l('Product Category Default');
        $str_var['Date_created'] = $this->l('Date created');
        $str_var['Date_modified'] = $this->l('Date modified');
        $str_var['Specials_CountDown'] = $this->l('Specials offer CountDown');
        $str_var['Custom_Placeholders'] = $this->l('Custom Placeholders:');
        $str_var['Example'] = $this->l('Example');
        $str_var['cover'] = $this->l('cover');
        $str_var['None'] = $this->l('None');
        $str_var['Position'] = $this->l('Position');
        $str_var['Appearance'] = $this->l('Appearance');
        $str_var['Navigation'] = $this->l('Navigation');
        $str_var['Thumbnails'] = $this->l('Thumbnails');
        $str_var['Mobile_Visibility'] = $this->l('Mobile Visibility');
        $str_var['Alternative_First'] = $this->l('Alternative First Slide');
        $str_var['Troubleshooting'] = $this->l('Troubleshooting');
        $str_var['Delay'] = $this->l('Delay');
        $str_var['slide_stays'] = $this->l('The time one slide stays on the screen in Milliseconds');
        $str_var['Shuffle_Mode'] = $this->l('Shuffle Mode');
        $str_var['Turn_Shuffle'] = $this->l('Turn Shuffle Mode on and off! Will be randomized only once at the start.');
        $str_var['Lazy_Load'] = $this->l('Lazy Load');
        $str_var['lazy_load_desc'] = $this->l('The lazy load means that the images will be loaded by demand, it speeds the loading of the slider.');
        $str_var['Load_Google_Font'] = $this->l('Load Google Font');
        $str_var['yes_Google_Font'] = $this->l('yes / no to load google font');
        $str_var['Google_Font'] = $this->l('Google Font');
        $str_var['google_font_family'] = $this->l('The google font family to load');
        $str_var['more_google'] = $this->l('To add more google fonts please read <a target="_blank" href="http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380/faqs/15268"> this tutorial </a> ');
        $str_var['Stop_Slider'] = $this->l('Stop Slider');
        $str_var['On_Off_loops'] = $this->l('On / Off to stop slider after some amount of loops / slides');
        $str_var['Stop_After_Loops'] = $this->l('Stop After Loops');
        $str_var['certain_amount_loops'] = $this->l('Stop the slider after certain amount of loops. 0 related to the first loop.');
        $str_var['Stop_At_Slide'] = $this->l('Stop At Slide');
        $str_var['given_slide'] = $this->l('Stop the slider at the given slide');
        $str_var['Position_page'] = $this->l('Position on the page');
        $str_var['Position_slider'] = $this->l('The position of the slider on the page, (float:left, float:right, margin:0px auto;)');
        $str_var['Left'] = $this->l('Left');
        $str_var['Center'] = $this->l('Center');
        $str_var['Right'] = $this->l('Right');
        $str_var['Margin_Top'] = $this->l('Margin Top');
        $str_var['top_wrapper'] = $this->l('The top margin of the slider wrapper div');
        $str_var['px'] = $this->l('px');
        $str_var['Margin_Bottom'] = $this->l('Margin Bottom');
        $str_var['bottom_wrapper'] = $this->l('The bottom margin of the slider wrapper div');
        $str_var['Margin_left'] = $this->l('Margin Left');
        $str_var['left_margin_wrapper'] = $this->l('The left margin of the slider wrapper div');
        $str_var['Margin_wrapper_div'] = $this->l('Margin Right');
        $str_var['right_wrapper'] = $this->l('The right margin of the slider wrapper div');
        $str_var['Shadow_Type'] = $this->l('Shadow Type');
        $str_var['slider_shadow'] = $this->l('The Shadow display underneath the banner. The shadow apply to fixed and responsive modes only, the full width slider do not have a shadow.');
        $str_var['No_Shadow'] = $this->l('No Shadow');
        $str_var['1'] = $this->l('1');
        $str_var['2'] = $this->l('2');
        $str_var['3'] = $this->l('3');
        $str_var['Show_Timer_Show'] = $this->l('Show Timer Line');
        $str_var['running_timer_line'] = $this->l('Show the top running timer line');
        $str_var['Top'] = $this->l('Top');
        $str_var['Bottom'] = $this->l('Bottom');
        $str_var['Hide'] = $this->l('Hide');
        $str_var['Background_color'] = $this->l('Background color');
        $str_var['transparent_slider'] = $this->l('Slider wrapper div background color, for transparent slider, leave empty.');
        $str_var['Padding_border'] = $this->l('Padding (border)');
        $str_var['border_around_slider'] = $this->l('The wrapper div padding, if it has value, then together with background color it it will make border around the slider.');
        $str_var['Show_Background_Image'] = $this->l('Show Background Image');
        $str_var['main_slider_wrapper'] = $this->l('yes / no to put background image to the main slider wrapper.');
        $str_var['Background_Image_Url'] = $this->l('Background Image Url');
        $str_var['slider_preloading'] = $this->l('The background image that will be on the slider wrapper. Will be shown at slider preloading.');
        $str_var['Touch_Enabled'] = $this->l('Touch Enabled');
        $str_var['Function_touch_devices'] = $this->l('Enable Swipe Function on touch devices');
        $str_var['Stop_On_Hover'] = $this->l('Stop On Hover');
        $str_var['hovering_Navigation'] = $this->l('Stop the Timer when hovering the slider');
        $str_var['Navigation_Type'] = $this->l('Navigation Type');
        $str_var['navigation_bar'] = $this->l('Display type of the navigation bar (Default:none');
        $str_var['None'] = $this->l('None');
        $str_var['Bullet'] = $this->l('Bullet');
        $str_var['Thumb'] = $this->l('Thumb');
        $str_var['Both'] = $this->l('Both');
        $str_var['Navigation_Arrows'] = $this->l('Navigation Arrows');
        $str_var['navigation_Thumb_arrows'] = $this->l('Display position of the Navigation Arrows (** By navigation Type Thumb arrows always centered or none visible)');
        $str_var['With_Bullets'] = $this->l('With Bullets');
        $str_var['Solo'] = $this->l('Solo');
        $str_var['Navigation_Style'] = $this->l('Navigation Style');
        $str_var['Navigation_nexttobullets'] = $this->l('Look of the navigation bullets  ** If you choose navbar, we recommend to choose Navigation Arrows to nexttobullets');
        $str_var['Round'] = $this->l('Round');
        $str_var['Navbar'] = $this->l('Navbar');
        $str_var['Old_Round'] = $this->l('Old Round');
        $str_var['Old_Square'] = $this->l('Old Square');
        $str_var['Old_Navbar'] = $this->l('Old Navbar');
        $str_var['Always_Show_Navigation'] = $this->l('Always Show Navigation');
        $str_var['show_navigation_thumbnails'] = $this->l('Always show the navigation and the thumbnails.');
        $str_var['Hide_Navitagion_After'] = $this->l('Hide Navitagion After');
        $str_var['Time_Navigatio_hidden'] = $this->l('Time after that the Navigation and the Thumbs will be hidden(Default: 200 ms)"');
        $str_var['ms'] = $this->l('ms');
        $str_var['Navigation_Horizontal_Align'] = $this->l('Navigation Horizontal Align');
        $str_var['Horizontal_Align_Bullets'] = $this->l('Horizontal Align of Bullets / Thumbnails');
        $str_var['Navigation_Vertical_Align'] = $this->l('Navigation Vertical Align');
        $str_var['Vertical_Align_Bullets'] = $this->l('Vertical Align of Bullets / Thumbnails');
        $str_var['Navigation_Horizontal_Offset'] = $this->l('Navigation Horizontal Offset');
        $str_var['Horizontal_position_Bullets'] = $this->l('Offset from current Horizontal position of Bullets / Thumbnails negative and positive direction');
        $str_var['Navigation_Vertical_Offset'] = $this->l('Navigation Vertical Offset');
        $str_var['current_Vertical_position'] = $this->l('Offset from current Vertical  position of Bullets / Thumbnails negative and positive direction');
        $str_var['Left_Arrow_Horizontal'] = $this->l('Left Arrow Horizontal Align');
        $str_var['Horizontal_Align_left'] = $this->l('Horizontal Align of left Arrow (only if arrow is not next to bullets)');
        $str_var['Left_Arrow_Vertical'] = $this->l('Left Arrow Vertical Align');
        $str_var['Vertical_Align_left'] = $this->l('Vertical Align of left Arrow (only if arrow is not next to bullets)');
        $str_var['Left_Arrow_Offset'] = $this->l('Left Arrow Horizontal Offset');
        $str_var['Offset_Horizontal_position'] = $this->l('Offset from current Horizontal position of of left Arrow  negative and positive direction');
        $str_var['Vertical_Offset'] = $this->l('Left Arrow Vertical Offset');
        $str_var['Offset_Vertical_position'] = $this->l('Offset from current Vertical position of of left Arrow negative and positive direction');
        $str_var['Right_Arrow_Horizontal'] = $this->l('Right Arrow Horizontal Align');
        $str_var['Horizontal_Align'] = $this->l('Horizontal Align of right Arrow (only if arrow is not next to bullets)');
        $str_var['Right_Arrow_Align'] = $this->l('Right Arrow Vertical Align');
        $str_var['Vertical_right_Arrow'] = $this->l('Vertical Align of right Arrow (only if arrow is not next to bullets)');
        $str_var['Right_Horizontal'] = $this->l('Right Arrow Horizontal Offset');
        $str_var['current_Horizontal_position'] = $this->l('Offset from current Horizontal position of of right Arrow negative and positive direction');
        $str_var['Right_Offset'] = $this->l('Right Arrow Vertical Offset');
        $str_var['position_negative_direction'] = $this->l('Offset from current Vertical position of of right Arrow negative and positive direction');
        $str_var['Thumb_Width'] = $this->l('Thumb Width');
        $str_var['thumb_selected'] = $this->l('The basic Width of one Thumbnail (only if thumb is selected)');
        $str_var['Thumb_Height'] = $this->l('Thumb Height');
        $str_var['Thumbnail_selected'] = $this->l('the basic Height of one Thumbnail (only if thumb is selected)');
        $str_var['Thumb_Amount'] = $this->l('Thumb Amount');
        $str_var['Thumbs_visible_selected'] = $this->l('the amount of the Thumbs visible same time (only if thumb is selected)');
        $str_var['Hide_Under_Width'] = $this->l('Hide Slider Under Width');
        $str_var['Hide_slider_width'] = $this->l('Hide the slider under some slider width. Works only in Responsive Style. Not available for Fullwidth.');
        $str_var['Hide_Layers_Under'] = $this->l('Hide Defined Layers Under Width');
        $str_var['Hide_layer_properties'] = $this->l('Hide some defined layers in the layer properties under some slider width.');
        $str_var['Hide_Layers_Under'] = $this->l('Hide All Layers Under Width');
        $str_var['layers_some_width'] = $this->l('Hide all layers under some slider width');
        $str_var['Start_With_Slide'] = $this->l('Start With Slide');
        $str_var['Change_want_start'] = $this->l('Change it if you want to start from a different slide then 1');
        $str_var['First_Transition_Active'] = $this->l('First Transition Active');
        $str_var['overwrite_first_slide'] = $this->l('If active, it will overwrite the first slide transition. Use it when you want a special transition for the first slide only.');
        $str_var['First_Transition_Type'] = $this->l('First Transition Type');
        $str_var['First_slide_transition'] = $this->l('First slide transition type');
        $str_var['Replace_me'] = $this->l('Replace me!');
        $str_var['First_Transition_Duration'] = $this->l('First Transition Duration');
        $str_var['First_slide_duration'] = $this->l('First slide transition duration (Default:300, min: 100 max 2000)');
        $str_var['First_Transition_Slot'] = $this->l('First Transition Slot Amount');
        $str_var['slide_divided'] = $this->l('The number of slots or boxes the slide is divided into. If you use boxfade, over 7 slots can be juggy');
        $str_var['JQuery_No_Conflict'] = $this->l('JQuery No Conflict Mode');
        $str_var['jquery_mode'] = $this->l('Turns on / off jquery noconflict mode. You can play with this option when you have some javascript conflicts.');
        $str_var['JS_Includes_Body'] = $this->l('Put JS Includes To Body');
        $str_var['Putting_javascript_conflicts'] = $this->l('Putting the js to body (in addition to head) is good for fixing some javascript conflicts of type: TypeError: tpj(\'#rev_slider_1_1\').show().revolution is not a function');
        $str_var['True'] = $this->l('True');
        $str_var['False'] = $this->l('False');
        $str_var['Output_Filters_Protection'] = $this->l('Output Filters Protection');
        $str_var['protection_against_wordpress'] = $this->l('Activate a protection against wordpress output filters that adds html blocks to the shortcode output like P and BR');
        $str_var['Compressing_Output'] = $this->l('By Compressing Output');
        $str_var['Echo_Output'] = $this->l('Echo Output');
        $str_var['Gallery'] = $this->l('Gallery');
        $str_var['Posts'] = $this->l('Posts');
        $str_var['Delete_Slide'] = $this->l('Delete Slide');
        $str_var['Edit_Slide'] = $this->l('Edit Slide');
        $str_var['Preview_Slide'] = $this->l('Preview Slide');
        $str_var['New_Post'] = $this->l('<i class=\'revicon-pencil-1\'></i>New Post');
        $str_var['To_Admin'] = $this->l('To Admin');
        $str_var['Editor_Admin'] = $this->l('To Editor, Admin');
        $str_var['Author_Editor_Admin'] = $this->l('Author, Editor, Admin');
        $str_var['edit_plugin'] = $this->l('The role of user that can view and edit the plugin');
        $str_var['off'] = $this->l('off');
        $str_var['Off'] = $this->l('off');
        $str_var['RevSlider_libraries'] = $this->l('Include RevSlider libraries globally');
        $str_var['shortcode_exists'] = $this->l('Add css and js includes only on all pages. Id turned to off they will added to pages where the rev_slider shortcode exists only. This will work only when the slider added by a shortcode.');
        $str_var['Pages_RevSlider'] = $this->l('Pages to include RevSlider libraries');
        $str_var['Specify_homepage'] = $this->l('Specify the page id is that the front end includes will be included in. Example: 2,3,5 also: homepage,3,4');
        $str_var['JS_Includes'] = $this->l('Put JS Includes To Footer');
        $str_var['fixing_javascript'] = $this->l('Putting the js to footer (instead of the head) is good for fixing some javascript conflicts.');
        $str_var['Export_option'] = $this->l('Enable Markup Export option');
        $str_var['export_Slider'] = $this->l('This will enable the option to export the Slider Markups to copy/paste it directly into websites.');
        $str_var['Enable_Logs'] = $this->l('Enable Logs');
        $str_var['Enable_console'] = $this->l('Enable console logs for debugging.');
        $str_var['Slider_Title'] = $this->l('Slider Title');
        $str_var['title_slider'] = $this->l('The title of the slider. Example: Slider1');
        $str_var['Slider_Alias'] = $this->l('Slider Alias');
        $str_var['alias_slider'] = $this->l('The alias that will be used for embedding the slider. Example: slider1');
        $str_var['Display_Hook'] = $this->l('Display Hook');
        $str_var['Products'] = $this->l('Products');
        $str_var['Specific_Products'] = $this->l('Specific Products');
        $str_var['Source_Type'] = $this->l('Source Type');
        $str_var['Types'] = $this->l('Types');
        $str_var['Product_Categories'] = $this->l('Product Categories');
        $str_var['Sort_Posts'] = $this->l('Sort Posts By');
        $str_var['Product_Image_Type'] = $this->l('Product Image Type');
        $str_var['Sort_Direction'] = $this->l('Sort Direction');
        $str_var['Max_Posts'] = $this->l('Max Posts Per Slider');
        $str_var['Limit_Excerpt'] = $this->l('Limit The Excerpt To');
        $str_var['Template_Slider'] = $this->l('Template Slider');
        $str_var['Type_post'] = $this->l('Type here the post IDs you want ');
        $str_var['Specific_Posts'] = $this->l('Specific Posts List');
        $str_var['Fixed'] = $this->l('Fixed');
        $str_var['Custom'] = $this->l('Custom');
        $str_var['Auto_Responsive'] = $this->l('Auto Responsive');
        $str_var['Full_Screen'] = $this->l('Full Screen');
        $str_var['Slider_Layout'] = $this->l('Slider Layout');
        $str_var['height_screen'] = $this->l('Example: #header or .header, .footer, #somecontainer | The height of fullscreen slider will be decreased with the height of these Containers to fit perfect in the screen');
        $str_var['Offset_Containers'] = $this->l('Types');
        $str_var['Defines_Offset'] = $this->l('Defines an Offset to the top. Can be used with px and %. Example: 40px or 10%');
        $str_var['Offset_Size'] = $this->l('Offset Size');
        $str_var['Fullscreen_Height'] = $this->l('Min. Fullscreen Height');
        $str_var['FullScreen_Align'] = $this->l('FullScreen Align');
        $str_var['Unlimited_Height'] = $this->l('Unlimited Height');
        $str_var['Force_Full_Width'] = $this->l('Force Full Width');
        $str_var['Min_Height'] = $this->l('Min. Height');
        $str_var['Layers_Grid'] = $this->l('Layers Grid Size');
        $str_var['Responsive_Sizes'] = $this->l('Responsive Sizes');
        $str_var['shown_slides_list'] = $this->l('The title of the slide, will be shown in the slides list.');
        $str_var['Slide_Title'] = $this->l('Slide Title');
        $str_var['excluded_slider'] = $this->l('The state of the slide. The unpublished slide will be excluded from the slider.');
        $str_var['Published'] = $this->l('Published');
        $str_var['Unpublished'] = $this->l('Unpublished');
        $str_var['State'] = $this->l('State');
        $str_var['language_slide'] = $this->l('The language of the slide.');
        $str_var['Language'] = $this->l('Language');
        $str_var['slide_visible'] = $this->l('If set, slide will be visible after the date is reached');
        $str_var['Visible_from'] = $this->l('Visible from');
        $str_var['slide_visible_reached'] = $this->l('If set, slide will be visible till the date is reached');
        $str_var['Visible_until'] = $this->l('Visible until');
        $str_var['appearance_transitions_slide'] = $this->l('The appearance transitions of this slide');
        $str_var['Transitions'] = $this->l('Transitions');
        $str_var['slide_divided'] = $this->l('The number of slots or boxes the slide is divided into. If you use boxfade, over 7 slots can be juggy');
        $str_var['Slot_Amount'] = $this->l('Slot Amount');
        $str_var['Simple_Transitions'] = $this->l('Rotation (-720 -> 720, 999 = random) Only for Simple Transitions.');
        $str_var['duration_transition'] = $this->l('The duration of the transition (Default:300, min: 100 max 2000).');
        $str_var['Transition_Duration'] = $this->l('Transition Duration');
        $str_var['start_delay_value'] = $this->l('A new delay value for the Slide. If no delay defined per slide, the delay defined via Options (');
        $str_var['end_delay_value'] = $this->l('ms) will be used');
        $str_var['Delay'] = $this->l('Delay');
        $str_var['Save_Performance'] = $this->l('Save Performance');
        $str_var['Enable_Link'] = $this->l('Enable Link');
        $str_var['Enable'] = $this->l('Enable');
        $str_var['Disable'] = $this->l('Disable');
        $str_var['Regular'] = $this->l('Regular');
        $str_var['Link_Type'] = $this->l('Link Type');
        $str_var['To_Slide'] = $this->l('To Slide');
        $str_var['template_sliders_link'] = $this->l('A link on the whole slide pic (use %link% or %meta:somemegatag% in template sliders to link to a post or some other meta)');
        $str_var['Slide_Link'] = $this->l('Slide Link');
        $str_var['Target_slide_link'] = $this->l('The target of the slide link');
        $str_var['Same_Window'] = $this->l('Same Window');
        $str_var['New_Window'] = $this->l('New Window');
        $str_var['Link_Open'] = $this->l('Link Open In');
        $str_var['Not_Chosen'] = $this->l('-- Not_Chosen --');
        $str_var['Next_Slide'] = $this->l('-- Next Slide --');
        $str_var['Previous_Slide'] = $this->l('-- Previous Slide');
        $str_var['Scroll_Below_Slider'] = $this->l('-- Scroll Below Slider');
        $str_var['Slide_Thumbnail_Image'] = $this->l('Slide Thumbnail. If not set - it will be taken from the slide image.');
        $str_var['Thumbnail'] = $this->l('Thumbnail');
        $str_var['Background_Type'] = $this->l('Background Type');
        $str_var['rev_special_class'] = $this->l('Adds a unique class to the li of the Slide like class="rev_special_class" (add only the classnames, seperated by space)');
        $str_var['Class'] = $this->l('Class');
        $str_var['rev_special_id'] = $this->l('Adds a unique ID to the li of the Slide like id="rev_special_id" (add only the id)');
        $str_var['rev_special_attr'] = $this->l('Adds a unique Attribute to the li of the Slide like attr="rev_special_attr" (add only the attribute)');
        $str_var['Attribute'] = $this->l('Attribute');
        $str_var['Attributes_data_custom'] = $this->l('Add as many attributes as you wish here. (i.e.: data-layer="firstlayer" data-custom="somevalue');
        $str_var['Custom_Fields'] = $this->l('Custom Fields');
        $str_var['Layer_Params'] = $this->l('Layer Params');
        $str_var['layer_params'] = $this->l('layer_params');
        $str_var['caption_green'] = $this->l('caption_green');
        $str_var['Style'] = $this->l('Style');
        $str_var['Text_Html'] = $this->l('Text / Html');
        $str_var['Image_Link'] = $this->l('Image Link');
        $str_var['Same_Window'] = $this->l('Same Window');
        $str_var['New_Window'] = $this->l('New Window');
        $str_var['Link_Open_In'] = $this->l('Link Open In');
        $str_var['Start_Animation'] = $this->l('Start Animation');
        $str_var['Start_Easing'] = $this->l('Start Easing');
        $str_var['ms_keep_low'] = $this->l('ms (keep it low i.e. 1- 200)');
        $str_var['Split_Text_per'] = $this->l('Split Text per');
        $str_var['Hide_Under_Width'] = $this->l('Hide Under Width');
        $str_var['Link_ID'] = $this->l('Link ID');
        $str_var['Link_Classes'] = $this->l('Link Classes');
        $str_var['Link_Title'] = $this->l('Link Title');
        $str_var['Link_Rel'] = $this->l('Link Rel');
        $str_var['Width_Height'] = $this->l('Width/Height');
        $str_var['Scale_Proportional'] = $this->l('Scale Proportional');
        $str_var['No_Movement'] = $this->l('No Movement');
        $str_var['4'] = $this->l('4');
        $str_var['5'] = $this->l('5');
        $str_var['6'] = $this->l('6');
        $str_var['7'] = $this->l('7');
        $str_var['8'] = $this->l('8');
        $str_var['9'] = $this->l('9');
        $str_var['10'] = $this->l('10');
        $str_var['Level'] = $this->l('Level');
        $str_var['OffsetX'] = $this->l('OffsetX');
        $str_var['X'] = $this->l('X');
        $str_var['OffsetY'] = $this->l('OffsetY');
        $str_var['Y'] = $this->l('Y');
        $str_var['Hor_Align'] = $this->l('Hor Align');
        $str_var['Vert_Align'] = $this->l('Vert Align');
        $str_var['nbsp_auto'] = $this->l('&nbsp;(example: 50px, 50%, auto)');
        $str_var['Max_Width'] = $this->l('Max Width');
        $str_var['Max_Height'] = $this->l('Max Height');
        $str_var['2D_Rotation'] = $this->l('2D Rotation');
        $str_var['Rotation_Origin_X'] = $this->l('Rotation Origin X');
        $str_var['Rotation_Origin_Y'] = $this->l('Rotation Origin Y');
        $str_var['Normal'] = $this->l('Normal');
        $str_var['Pre'] = $this->l('Pre');
        $str_var['No_Wrap'] = $this->l('No-wrap');
        $str_var['NO_Wrap'] = $this->l('No-wrap');
        $str_var['Pre_Wrap'] = $this->l('Pre-Wrap');
        $str_var['Pre_Line'] = $this->l('Pre-Line');
        $str_var['White_Space'] = $this->l('White Space');
        $str_var['Link_To_Slide'] = $this->l('Link To Slide');
        $str_var['Scroll_Under_Slider'] = $this->l('Scroll Under Slider Offset');
        $str_var['Change_Image_Source'] = $this->l('Change Image Source');
        $str_var['Edit_Video'] = $this->l('Edit Video');
        $str_var['End_Time'] = $this->l('End Time');
        $str_var['End_Duration'] = $this->l('End Duration');
        $str_var['End_Animation'] = $this->l('End Animation');
        $str_var['End_Easing'] = $this->l('End Easing');
        $str_var['No_Corner'] = $this->l('No Corner');
        $str_var['Sharp'] = $this->l('Sharp');
        $str_var['Sharp_Reversed'] = $this->l('Sharp Reversed');
        $str_var['Left_Corner'] = $this->l('Left Corner');
        $str_var['Right_Corner'] = $this->l('Right Corner');
        $str_var['Responsive_Levels'] = $this->l('Responsive Through All Levels');
        $str_var['Classes'] = $this->l('Classes');
        $str_var['Rel'] = $this->l('Rel');
        $str_var['Pendulum'] = $this->l('Pendulum');
        $str_var['Slideloop'] = $this->l('Slideloop');
        $str_var['Pulse'] = $this->l('Pulse');
        $str_var['Wave'] = $this->l('Wave');
        $str_var['Animation'] = $this->l('Animation');
        $str_var['Speed'] = $this->l('Speed');
        $str_var['nbsp'] = $this->l('&nbsp;(0.00 - 10.00)');
        $str_var['Start_Degree'] = $this->l('Start Degree');
        $str_var['End_Degree'] = $this->l('End Degree');
        $str_var['&nbsp'] = $this->l('&nbsp;(-720 - 720)');
        $str_var['x_Origin'] = $this->l('x Origin');
        $str_var['%'] = $this->l('%');
        $str_var['y_Origin'] = $this->l('y Origin');
        $str_var['%_250'] = $this->l('% (-250% - 250%)');
        $str_var['x_Start_Pos'] = $this->l('x Start Pos.');
        $str_var['x_End_Pos'] = $this->l('x End Pos.');
        $str_var['2000px_2000px'] = $this->l('px (-2000px - 2000px)');
        $str_var['y_Start_Pos'] = $this->l('y Start Pos.');
        $str_var['y_End_Pos'] = $this->l('y End Pos.');
        $str_var['px_2000px'] = $this->l('px (-2000px - 2000px)');
        $str_var['Start_Zoom'] = $this->l('Start Zoom');
        $str_var['End_Zoom'] = $this->l('End Zoom');
        $str_var['nbsp_20'] = $this->l('&nbsp;(0.00 - 20.00)');
        $str_var['Angle'] = $this->l('Angle');
        $str_var['0°_360°'] = $this->l('° (0° - 360°)');
        $str_var['Radius'] = $this->l('Radius');
        $str_var['0px_2000px'] = $this->l('px (0px - 2000px)');
        $str_var['Easing'] = $this->l('Easing');
        $str_var['Plugin_Permission'] = $this->l('Plugin Permission');
        $str_var['Use_Multi_Language'] = $this->l('Use_Multi_Language');
        $str_var['Use_Multi_Language_desc'] = $this->l('Use_Multi_Language_desc');
        $str_var['Enable_Static_Layers'] = $this->l('Enable_Static_Layers');
        $str_var['Enable_Static_Layers_desc'] = $this->l('Enable_Static_Layers_desc');
        $str_var['Next_Slide_on_Focus'] = $this->l('Next_Slide_on_Focus');
        $str_var['Simplify_IOS4_IE8'] = $this->l('Simplify_IOS4_IE8');
        $str_var['Simplyfies'] = $this->l('Simplyfies');
        $str_var['Loop_Progress'] = $this->l('Loop_Progress');
        $str_var['Stop_Slider'] = $this->l('Stop_Slider');
        $str_var['Show_Progressbar'] = $this->l('Show_Progressbar');
        $str_var['Show_running_progressbar'] = $this->l('Show_running_progressbar');
        $str_var['Loop_Single_Slide'] = $this->l('Loop_Single_Slide');
        $str_var['ILoop_Single_Slidef'] = $this->l('ILoop_Single_Slidef');
        $str_var['underneath_banner'] = $this->l('underneath_banner');
        $str_var['Background_transparent_slides'] = $this->l('Background_transparent_slides');
        $str_var['Dotted_Overlay_Size'] = $this->l('Dotted_Overlay_Size');
        $str_var['dotted_overlay'] = $this->l('dotted_overlay');
        $str_var['background_fitted'] = $this->l('background_fitted');
        $str_var['background_repeated_into'] = $this->l('background_repeated_into');
        $str_var['background_positioned_Slider'] = $this->l('background_positioned_Slider');
        $str_var['Keyboard_Navigation'] = $this->l('Keyboard_Navigation');
        $str_var['navigate_keyboard'] = $this->l('navigate_keyboard');
        $str_var['Bullet_Type'] = $this->l('Bullet_Type');
        $str_var['Bullets_Thumbnail_Position'] = $this->l('Bullets_Thumbnail_Position');
        $str_var['Select_Spinner_Slider'] = $this->l('Select_Spinner_Slider');
        $str_var['Color_Spinner_shown'] = $this->l('Color_Spinner_shown');
        $str_var['Spinner_Color'] = $this->l('Spinner_Color');
        $str_var['Parallax'] = $this->l('Parallax');
        $str_var['Enable_Parallax'] = $this->l('Enable_Parallax');
        $str_var['parallax_effect'] = $this->l('parallax_effect');
        $str_var['Disable_on_Mobile'] = $this->l('Disable_on_Mobile');
        $str_var['parallax_effect_desc'] = $this->l('parallax_effect_desc');
        $str_var['parallax_effect_react'] = $this->l('parallax_effect_react');
        $str_var['Mouse_Position'] = $this->l('Mouse_Position');
        $str_var['Scroll_Position'] = $this->l('Scroll_Position');
        $str_var['Mouse_and_Scroll'] = $this->l('Mouse_and_Scroll');
        $str_var['BG_Freeze'] = $this->l('BG_Freeze');
        $str_var['freeze_background'] = $this->l('freeze_background');
        $str_var['Level_Depth_1'] = $this->l('Level_Depth_1');
        $str_var['Level_Depth_desc'] = $this->l('Level_Depth_desc');
        $str_var['Level_Depth_2'] = $this->l('Level_Depth_2');
        $str_var['Level_Depth_3'] = $this->l('Level_Depth_3');
        $str_var['Level_Depth_4'] = $this->l('Level_Depth_4');
        $str_var['Level_Depth_5'] = $this->l('Level_Depth_5');
        $str_var['Level_Depth_6'] = $this->l('Level_Depth_6');
        $str_var['Level_Depth_7'] = $this->l('Level_Depth_7');
        $str_var['Level_Depth_8'] = $this->l('Level_Depth_8');
        $str_var['Level_Depth_9'] = $this->l('Level_Depth_9');
        $str_var['Level_Depth_10'] = $this->l('Level_Depth_10');
        $str_var['Mobile_Touch'] = $this->l('Mobile_Touch');
        $str_var['Swipe_Treshhold'] = $this->l('Swipe_Treshhold');
        $str_var['sensibility_gestures'] = $this->l('sensibility_gestures');
        $str_var['Swipe_Min_Finger'] = $this->l('Swipe_Min_Finger');
        $str_var['Swipe_Min_Finger_desc'] = $this->l('Swipe_Min_Finger_desc');
        $str_var['Drag_Block_Vertical'] = $this->l('Drag_Block_Vertical');
        $str_var['Drag_Block_Vertical_desc'] = $this->l('Drag_Block_Vertical_desc');
        $str_var['Disable_Slider_Mobile'] = $this->l('Disable_Slider_Mobile');
        $str_var['Disable_Slider_Mobile_desc'] = $this->l('Disable_Slider_Mobile_desc');
        $str_var['Disable_KenBurn_Mobile'] = $this->l('Disable_KenBurn_Mobile');
        $str_var['Disable_KenBurn_Mobile_desc'] = $this->l('Disable_KenBurn_Mobile_desc');
        $str_var['Hide_Arrows_Mobile'] = $this->l('Hide_Arrows_Mobile');
        $str_var['Navigation_Arrows'] = $this->l('Navigation_Arrows');
        $str_var['Hide_Bullets_Mobile'] = $this->l('Hide_Bullets_Mobile');
        $str_var['ShowHideNavigationBullets'] = $this->l('ShowHideNavigationBullets');
        $str_var['Hide_Thumbnails_Mobile'] = $this->l('Hide_Thumbnails_Mobile');
        $str_var['ShowHideThumbnailsBullets'] = $this->l('ShowHideThumbnailsBullets');
        $str_var['Hide_Thumbs_Under_Width'] = $this->l('Hide_Thumbs_Under_Width');
        $str_var['Thumbnails_Mobile_Devices'] = $this->l('Thumbnails_Mobile_Devices');
        $str_var['Hide_Mobile_After'] = $this->l('Hide_Mobile_After');
        $str_var['Hide_Mobile_After_desc'] = $this->l('Hide_Mobile_After_desc');
        $str_var['Alternative_First_Slide'] = $this->l('Alternative_First_Slide');
        $str_var['Global_Overwrites'] = $this->l('Global_Overwrites');
        $str_var['Reset_Transitions'] = $this->l('Reset_Transitions');
        $str_var['Reset_Transitions_desc'] = $this->l('Reset_Transitions_desc');
        $str_var['Choose_operate'] = $this->l('Choose_operate');
        $str_var['Random_Flat'] = $this->l('Random_Flat');
        $str_var['Random_Premium'] = $this->l('Random_Premium');
        $str_var['Random_Flat_Premium'] = $this->l('Random_Flat_Premium');
        $str_var['Slide_To_Top'] = $this->l('Slide_To_Top');
        $str_var['Slide_To_Bottom'] = $this->l('Slide_To_Bottom');
        $str_var['Slide_To_Right'] = $this->l('Slide_To_Right');
        $str_var['Slide_To_Left'] = $this->l('Slide_To_Left');
        $str_var['Slide_Horizontal'] = $this->l('Slide_Horizontal');
        $str_var['Slide_Vertical'] = $this->l('Slide_Vertical');
        $str_var['Slide_Boxes'] = $this->l('Slide_Boxes');
        $str_var['Slide_Slots_Horizontal'] = $this->l('Slide_Slots_Horizontal');
        $str_var['Slide_Slots_Verticall'] = $this->l('Slide_Slots_Verticall');
        $str_var['No_Transition'] = $this->l('No_Transition');
        $str_var['Fade'] = $this->l('Fade');
        $str_var['Fade_Boxes'] = $this->l('Fade_Boxes');
        $str_var['Fade_Slots_Horizontal'] = $this->l('Fade_Slots_Horizontal');
        $str_var['Fade_Slots_Vertical'] = $this->l('Fade_Slots_Vertical');
        $str_var['Fade_Slide_Right'] = $this->l('Fade_Slide_Right');
        $str_var['Fade_Slide_Left'] = $this->l('Fade_Slide_Left');
        $str_var['Fade_Slide_Top'] = $this->l('Fade_Slide_Top');
        $str_var['Fade_Slide_Bottom'] = $this->l('Fade_Slide_Bottom');
        $str_var['Fade_To_Left'] = $this->l('Fade_To_Left');
        $str_var['Fade_To_Right'] = $this->l('Fade_To_Right');
        $str_var['Fade_To_Top'] = $this->l('Fade_To_Top');
        $str_var['Fade_To_Bottom'] = $this->l('Fade_To_Bottom');
        $str_var['Parallax_Right'] = $this->l('Parallax_Right');
        $str_var['Parallax_Left'] = $this->l('Parallax_Left');
        $str_var['Parallax_Top'] = $this->l('Parallax_Top');
        $str_var['Parallax_Bottom'] = $this->l('Parallax_Bottom');
        $str_var['Zoom_Out'] = $this->l('Zoom_Out');
        $str_var['Zoom_OutLeft'] = $this->l('Zoom_OutLeft');
        $str_var['Zoom_OutTop'] = $this->l('Zoom_OutTop');
        $str_var['Zoom_OutBottom'] = $this->l('Zoom_OutBottom');
        $str_var['Zoom_Slots_Vertical'] = $this->l('Zoom_Slots_Vertical');
        $str_var['Curtain_Left'] = $this->l('Curtain_Left');
        $str_var['Curtain_Middle'] = $this->l('Curtain_Middle');
        $str_var['Curtain_Right'] = $this->l('Curtain_Right');
        $str_var['Curtain_Horizontal'] = $this->l('Curtain_Horizontal');
        $str_var['Curtain_Vertical'] = $this->l('Curtain_Vertical');
        $str_var['Cube_Vertical'] = $this->l('Cube_Vertical');
        $str_var['Cube_Horizontal'] = $this->l('Cube_Horizontal');
        $str_var['In_Cube_Vertical'] = $this->l('In_Cube_Vertical');
        $str_var['In_Cube_Horizontal'] = $this->l('In_Cube_Horizontal');
        $str_var['TurnOff_Horizontal'] = $this->l('TurnOff_Horizontal');
        $str_var['TurnOff_Vertical'] = $this->l('TurnOff_Vertical');
        $str_var['Paper_Cut'] = $this->l('Paper_Cut');
        $str_var['Fly_In'] = $this->l('Fly_In');
        $str_var['Reset_Transition_Duration'] = $this->l('Reset_Transition_Duration');
        $str_var['Troubleshooting'] = $this->l('Troubleshooting');
        $str_var['Reset_all_Duration'] = $this->l('Reset_all_Duration');
        $str_var['Troubleshooting'] = $this->l('Troubleshooting');
        $str_var['JQuery_Conflict_Mode'] = $this->l('JQuery_Conflict_Mode');
        $str_var['JQuery_Conflict_desc'] = $this->l('JQuery_Conflict_desc');
        $str_var['Put_JS_Body'] = $this->l('Put_JS_Body');
        $str_var['Put_JS_Body_desc'] = $this->l('Put_JS_Body_desc');
        $str_var['Output_Filters_Protection'] = $this->l('Output_Filters_Protection');
        $str_var['Output_Filters_desc'] = $this->l('Output_Filters_desc');
        $str_var['By_Compressing_Output'] = $this->l('By_Compressing_Output');
        $str_var['By_Echo_Output'] = $this->l('By_Echo_Output');
        $str_var['Google_Font_Settings'] = $this->l('Google_Font_Settings');
        $str_var['Google_Font_Settings_desc'] = $this->l('Google_Font_Settings_desc');
        $str_var['Load_Google_Font'] = $this->l('Load_Google_Font');
        $str_var['Load_Google_desc'] = $this->l('Load_Google_desc');
        $str_var['google_families_load'] = $this->l('google_families_load');
        $str_var['Choose_Spinner'] = $this->l('Choose_Spinner');
        $str_var['Type'] = $this->l('Type');
        $str_var['Next_Slide_Focus'] = $this->l('Next_Slide_Focus');
        $str_var['Social'] = $this->l('Social');
        $str_var['Facebook'] = $this->l('Facebook');
        $str_var['Twitter'] = $this->l('Twitter');
        $str_var['Flickr'] = $this->l('Flickr');
        $str_var['YouTube'] = $this->l('YouTube');
        $str_var['Vimeo'] = $this->l('Vimeo');
        $str_var['Instagram'] = $this->l('Instagram');
        $str_var['Embed_Slider'] = $this->l('Embed Slider');
        $str_var['Export'] = $this->l('Export');
        $str_var['Export_to_HTML'] = $this->l('Export to HTML');
        $str_var['All_Sliders'] = $this->l('All Sliders');
        $str_var['Slide_Editor'] = $this->l('Slide Editor');
        return $str_var;
    }

    public static function getIsset($var)
    {
        return RevLoader::getIsset($var);
    }
    /**
    * Private helper function for checked, selected, and disabled.
    *
    * Compares the first two arguments and if identical marks as $type
    *
    * @since 2.8.0
    * @access private
    *
    * @param mixed  $helper  One of the values to compare
    * @param mixed  $current (true) The other value to compare if not just true
    * @param bool   $echo    Whether to echo or just return the string
    * @param string $type    The type of checked|selected|disabled we are doing
    * @return string html attribute or empty string
    */
    public static function checkedSelectedHelper( $helper, $current, $echo, $type ) {
        if ( (string) $helper === (string) $current )
            $result = " $type='$type'";
        else
            $result = '';

        if ( $echo )
            echo $result;

        return $result;
    }
    /**
    * Outputs the html selected attribute.
    *
    * Compares the first two arguments and if identical marks as selected
    *
    * @since 1.0.0
    *
    * @param mixed $selected One of the values to compare
    * @param mixed $current  (true) The other value to compare if not just true
    * @param bool  $echo     Whether to echo or just return the string
    * @return string html attribute or empty string
    */
    public static function selected( $selected, $current = true, $echo = true ) {
        return self::checkedSelectedHelper( $selected, $current, $echo, 'selected' );
    }
}
