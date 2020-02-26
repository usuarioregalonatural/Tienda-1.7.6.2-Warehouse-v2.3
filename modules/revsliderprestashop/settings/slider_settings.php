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

//set "slider_main" settings
$sliderMainSettings = new UniteSettingsAdvancedRev();

$sliderMainSettings->addTextBox("title", "", RevsliderPrestashop::$lang['Slider_Title'], array("description" => RevsliderPrestashop::$lang['title_slider'], "required" => "true"));
$sliderMainSettings->addTextBox("alias", "", RevsliderPrestashop::$lang['Slider_Alias'], array("description" => RevsliderPrestashop::$lang['alias_slider'], "required" => "true"));
$sliderMainSettings->addHr();


//start set IMages Size
$gethooks = array();
require_once(dirname(__FILE__) . '../../hook/hook.php');
$hookobj = new SdsRevHooksClass();
$customhooks = $hookobj->getAllHooks();
if (@RevsliderPrestashop::getIsset($customhooks) && !empty($customhooks)) {
    foreach ($customhooks as $values) {
        foreach ($values as $valu) {
            $gethooks[$valu] = $valu;
        }
    }
}
$sliderMainSettings->addSelect("displayhook", $gethooks, RevsliderPrestashop::$lang['Display_Hook'], 'id');

$arrSourceTypes = array("posts" => RevsliderPrestashop::$lang['Products'],
    "specific_posts" => RevsliderPrestashop::$lang['Specific_Products'],
    "gallery" => RevsliderPrestashop::$lang['Gallery']);

$sliderMainSettings->addRadio("source_type", $arrSourceTypes, RevsliderPrestashop::$lang['Source_Type'], "gallery");

$sliderMainSettings->startBulkControl("source_type", UniteSettingsRev::CONTROL_TYPE_SHOW, "posts");

//post types
$arrPostTypes = UniteFunctionsWPRev::getPostTypesAssoc(array("product"));

$arrParams = array("args" => "multiple size='5'");
$sliderMainSettings->addSelect("post_types", $arrPostTypes, RevsliderPrestashop::$lang['Types'], "product", $arrParams);

//post categories
$arrParams = array("args" => "multiple size='7'");
$sliderMainSettings->addSelect("post_category", array(), RevsliderPrestashop::$lang['Product_Categories'], "", $arrParams);

//sort by
$arrSortBy = UniteFunctionsWPRev::getArrSortBy();



$sliderMainSettings->addSelect("post_sortby", $arrSortBy, RevsliderPrestashop::$lang['Sort_Posts'], RevSlider::DEFAULT_POST_SORTBY);

//start set IMages Size
$GetArrImageSize = UniteFunctionsWPRev::getArrImageSize();
$sliderMainSettings->addSelect("prd_img_size", $GetArrImageSize, RevsliderPrestashop::$lang['Product_Image_Type'], '');
//End set IMages Size
//sort direction
$arrSortDir = UniteFunctionsWPRev::getArrSortDirection();
$sliderMainSettings->addRadio("posts_sort_direction", $arrSortDir, RevsliderPrestashop::$lang['Sort_Direction'], RevSlider::DEFAULT_POST_SORTDIR);

//max posts for slider
$arrParams = array("class" => "small", "unit" => "posts");
$sliderMainSettings->addTextBox("max_slider_posts", "30", RevsliderPrestashop::$lang['Max_Posts'], $arrParams);

//exerpt limit
$arrParams = array("class" => "small", "unit" => "words");
$sliderMainSettings->addTextBox("excerpt_limit", "55", RevsliderPrestashop::$lang['Limit_Excerpt'], $arrParams);

//slider template
$sliderMainSettings->addhr();

$slider1 = new RevSlider();
$arrSlidersTemplates = $slider1->getArrSlidersShort(null, RevSlider::SLIDER_TYPE_TEMPLATE);
$sliderMainSettings->addSelect("slider_template_id", $arrSlidersTemplates, RevsliderPrestashop::$lang['Template_Slider'], "", array());

$sliderMainSettings->endBulkControl();

$arrParams = array("description" => RevsliderPrestashop::$lang['Type_post']);
$sliderMainSettings->addTextBox("posts_list", "", RevsliderPrestashop::$lang['Specific_Posts'], $arrParams);
$sliderMainSettings->addControl("source_type", "posts_list", UniteSettingsRev::CONTROL_TYPE_SHOW, "specific_posts");

$sliderMainSettings->addHr();

//set slider type / texts
$sliderMainSettings->addRadio("slider_type", array("fixed" => RevsliderPrestashop::$lang['Fixed'],
    "responsitive" => RevsliderPrestashop::$lang['Custom'],
    "fullwidth" => RevsliderPrestashop::$lang['Auto_Responsive'],
    "fullscreen" => RevsliderPrestashop::$lang['Full_Screen']
    ), RevsliderPrestashop::$lang['Slider_Layout'], "fullwidth");

$arrParams = array("class" => "medium", "description" => RevsliderPrestashop::$lang['height_screen']);
$sliderMainSettings->addTextBox("fullscreen_offset_container", "", RevsliderPrestashop::$lang['Offset_Containers'], $arrParams);

$sliderMainSettings->addControl("slider_type", "fullscreen_offset_container", UniteSettingsRev::CONTROL_TYPE_SHOW, "fullscreen");

$arrParams = array("class" => "medium", "description" => RevsliderPrestashop::$lang['Defines_Offset']);
$sliderMainSettings->addTextBox("fullscreen_offset_size", "", RevsliderPrestashop::$lang['Offset_Size'], $arrParams);

$sliderMainSettings->addControl("slider_type", "fullscreen_offset_size", UniteSettingsRev::CONTROL_TYPE_SHOW, "fullscreen");

$arrParams = array("description" => "");
$sliderMainSettings->addTextBox("fullscreen_min_height", "", RevsliderPrestashop::$lang['Fullscreen_Height'], $arrParams);

$sliderMainSettings->addControl("slider_type", "fullscreen_min_height", UniteSettingsRev::CONTROL_TYPE_SHOW, "fullscreen");

$sliderMainSettings->addRadio("full_screen_align_force", array("on" => RevsliderPrestashop::$lang['on'], "off" => RevsliderPrestashop::$lang['off']), RevsliderPrestashop::$lang['FullScreen_Align'], "off");


$sliderMainSettings->addRadio("auto_height", array("on" => RevsliderPrestashop::$lang['on'], "off" => RevsliderPrestashop::$lang['off']), RevsliderPrestashop::$lang['Unlimited_Height'], "off");
$sliderMainSettings->addRadio("force_full_width", array("on" => RevsliderPrestashop::$lang['on'], "off" => RevsliderPrestashop::$lang['off']), RevsliderPrestashop::$lang['Force_Full_Width'], "off");

$arrParams = array("description" => "");
$sliderMainSettings->addTextBox("min_height", "0", RevsliderPrestashop::$lang['Min_Height'], $arrParams);

$paramsSize = array("width" => 960, "height" => 350, "datatype" => UniteSettingsRev::DATATYPE_NUMBER, "description" => __('
- The <span class="prevxmpl">LAYERS GRID</span> is the container of layers within the <span class="prevxmpl">SLIDER</span> <br>
- The "Grid Size" setting does not relate to the actual "Slider Size". <br>
- "Max Height" of the slider equals the "Grid Height"<br>
- "Slider Width" can be greater than the set "Grid Width"', REVSLIDER_TEXTDOMAIN));
$sliderMainSettings->addCustom("slider_size", "slider_size", "", RevsliderPrestashop::$lang['Layers_Grid'], $paramsSize);


$paramsResponsitive = array("w1" => 940, "sw1" => 770, "w2" => 780, "sw2" => 500, "w3" => 510, "sw3" => 310, "datatype" => UniteSettingsRev::DATATYPE_NUMBER);
$sliderMainSettings->addCustom("responsitive_settings", "responsitive", "", RevsliderPrestashop::$lang['Responsive_Sizes'], $paramsResponsitive);

$sliderMainSettings->addHr();

RevSliderAdmin::storeSettings("slider_main", $sliderMainSettings);

//set "slider_params" settings. 
$sliderParamsSettings = new UniteSettingsAdvancedRev();
$sliderParamsSettings->loadXMLFile(RevSliderAdmin::$path_settings . "/slider_settings.xml");

//update transition type setting.
$settingFirstType = $sliderParamsSettings->getSettingByName("first_transition_type");
$operations = new RevOperations();
$arrTransitions = $operations->getArrTransition();
if (count($arrTransitions) == 0) {
    $arrTransitions = $operations->getArrTransition(true);
} //get premium transitions
$settingFirstType["items"] = $arrTransitions;
$sliderParamsSettings->updateArrSettingByName("first_transition_type", $settingFirstType);

//store params
RevSliderAdmin::storeSettings("slider_params", $sliderParamsSettings);
