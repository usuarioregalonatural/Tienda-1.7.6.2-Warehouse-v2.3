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

// @codingStandardsIgnoreStart
$operations = RevGlobalObject::getOpInstance();
//set Slide settings

$arrTransitions = $operations->getArrTransition();

$arrPremiumTransitions = $operations->getArrTransition(true);

$defaultTransition = $operations->getDefaultTransition();



$arrSlideNames = array();

$slider = RevGlobalObject::getVar('slider');

if (@RevsliderPrestashop::getIsset($slider) && $slider->isInited()) {
    $arrSlideNames = $slider->getArrSlideNames();
}



$slideSettings = new UniteSettingsAdvancedRev();



//title

$params = array("description" => RevsliderPrestashop::$lang['shown_slides_list'], "class" => "medium");

$slideSettings->addTextBox("title", RevsliderPrestashop::$lang['slide'], RevsliderPrestashop::$lang['Slide_Title'], $params);



//state

$params = array("description" => RevsliderPrestashop::$lang['excluded_slider']);

$slideSettings->addSelect("state", array("published" => RevsliderPrestashop::$lang['Published'], "unpublished" => RevsliderPrestashop::$lang['Unpublished']), RevsliderPrestashop::$lang['State'], "published", $params);



if (@RevsliderPrestashop::getIsset($slider) && $slider->isInited()) {
    $isWpmlExists = true;

    $useWpml = $slider->getParam("use_wpml", "off");



    if ($isWpmlExists && $useWpml == "on") {
        $arrLangs = UniteWpmlRev::getArrLanguages();

        $params = array("description" => RevsliderPrestashop::$lang['language_slide']);

        $slideSettings->addSelect("lang", $arrLangs, RevsliderPrestashop::$lang['Language'], "all", $params);
    }
}



$params = array("description" => RevsliderPrestashop::$lang['slide_visible']);

$slideSettings->addDatePicker("date_from", "", RevsliderPrestashop::$lang['Visible_from'], $params);



$params = array("description" => RevsliderPrestashop::$lang['slide_visible_reached']);

$slideSettings->addDatePicker("date_to", "", RevsliderPrestashop::$lang['Visible_until'], $params);



$slideSettings->addHr("");



//transition

$params = array("description" => RevsliderPrestashop::$lang['appearance_transitions_slide'], "minwidth" => "250px");

$slideSettings->addChecklist("slide_transition", $arrTransitions, RevsliderPrestashop::$lang['Transitions'], $defaultTransition, $params);



//slot amount

$params = array("description" => RevsliderPrestashop::$lang['slide_divided']
    , "class" => "small", "datatype" => "number"
);

$slideSettings->addTextBox("slot_amount", "7", RevsliderPrestashop::$lang['Slot_Amount'], $params);



//rotation:

$params = array("description" => RevsliderPrestashop::$lang['Simple_Transitions']
    , "class" => "small", "datatype" => "number"
);

$slideSettings->addTextBox("transition_rotation", "0", RevsliderPrestashop::$lang['Rotation'], $params);



//transition speed

$params = array("description" => RevsliderPrestashop::$lang['duration_transition']
    , "class" => "small", "datatype" => "number"
);

$slideSettings->addTextBox("transition_duration", "300", RevsliderPrestashop::$lang['Transition_Duration'], $params);


$sliderDelay = RevGlobalObject::getVar('sliderDelay');

RevGlobalObject::reset(); // reset the dynamic_object property and make it useable for next use.


if (empty($sliderDelay)) {
    $sliderDelay = 0;
}



//delay	

$params = array("description" => RevsliderPrestashop::$lang['start_delay_value'] . $sliderDelay . RevsliderPrestashop::$lang['end_delay_value']
    , "class" => "small", "datatype" => UniteSettingsRev::DATATYPE_NUMBEROREMTY
);

$slideSettings->addTextBox("delay", "", RevsliderPrestashop::$lang['Delay'], $params);

$params = array("description" => ""
    , "class" => "small"
);
$slideSettings->addRadio("save_performance", array("on" => RevsliderPrestashop::$lang['on'], "off" => RevsliderPrestashop::$lang['off']), RevsliderPrestashop::$lang['Save_Performance'], "off", $params);

//-----------------------
//enable link

$slideSettings->addSelectBoolean("enable_link", RevsliderPrestashop::$lang['Enable_Link'], false, RevsliderPrestashop::$lang['Enable'], RevsliderPrestashop::$lang['Disable']);



$slideSettings->startBulkControl("enable_link", UniteSettingsRev::CONTROL_TYPE_SHOW, "true");



//link type

$slideSettings->addRadio("link_type", array("regular" => RevsliderPrestashop::$lang['Regular'], "slide" => RevsliderPrestashop::$lang['To_Slide']), RevsliderPrestashop::$lang['Link_Type'], "regular");



//link	

$params = array("description" => RevsliderPrestashop::$lang['template_sliders_link']);

$slideSettings->addTextBox("link", "", RevsliderPrestashop::$lang['Slide_Link'], $params);



//link target

$params = array("description" => RevsliderPrestashop::$lang['Target_slide_link']);

$slideSettings->addSelect("link_open_in", array("same" => RevsliderPrestashop::$lang['Same_Window'], "new" => RevsliderPrestashop::$lang['New_Window']), RevsliderPrestashop::$lang['Link_Open'], "same", $params);



//num_slide_link

$arrSlideLink = array();

$arrSlideLink["nothing"] = RevsliderPrestashop::$lang['Not_Chosen'];

$arrSlideLink["next"] = RevsliderPrestashop::$lang['Next_Slide'];

$arrSlideLink["prev"] = RevsliderPrestashop::$lang['Previous_Slide'];



$arrSlideLinkLayers = $arrSlideLink;

$arrSlideLinkLayers["scroll_under"] = RevsliderPrestashop::$lang['Scroll_Below_Slider'];



foreach ($arrSlideNames as $slideNameID => $arr) {
    $slideName = $arr["title"];

    $arrSlideLink[$slideNameID] = $slideName;

    $arrSlideLinkLayers[$slideNameID] = $slideName;
}



$slideSettings->addSelect("slide_link", $arrSlideLink, "Link To Slide", "nothing");



$params = array("description" => "The position of the link related to layers");

$slideSettings->addRadio("link_pos", array("front" => "Front", "back" => "Back"), "Link Position", "front", $params);



$slideSettings->addHr("link_sap");



$slideSettings->endBulkControl();



$slideSettings->addControl("link_type", "slide_link", UniteSettingsRev::CONTROL_TYPE_ENABLE, "slide");

$slideSettings->addControl("link_type", "link", UniteSettingsRev::CONTROL_TYPE_DISABLE, "slide");

$slideSettings->addControl("link_type", "link_open_in", UniteSettingsRev::CONTROL_TYPE_DISABLE, "slide");





$params = array("description" => RevsliderPrestashop::$lang['Slide_Thumbnail_Image']);

$slideSettings->addImage("slide_thumb", "", RevsliderPrestashop::$lang['Thumbnail'], $params);

$slideSettings->addTextBox("background_type", "image", RevsliderPrestashop::$lang['Background_Type'], array("hidden" => true));

$slideSettings->addHr("");
//store settings
$params = array("description" => RevsliderPrestashop::$lang['rev_special_class']);
$slideSettings->addTextBox("class_attr", "", RevsliderPrestashop::$lang['Class'], $params);

$params = array("description" => RevsliderPrestashop::$lang['rev_special_id']);
$slideSettings->addTextBox("id_attr", "", RevsliderPrestashop::$lang['ID'], $params);

$params = array("description" => RevsliderPrestashop::$lang['rev_special_attr']);
$slideSettings->addTextBox("attr_attr", "", RevsliderPrestashop::$lang['Attribute'], $params);

$params = array("description" => RevsliderPrestashop::$lang['Attributes_data_custom']);
$slideSettings->addTextArea("data_attr", "", RevsliderPrestashop::$lang['Custom_Fields'], $params);

self::storeSettings("slide_settings", $slideSettings);

// @codingStandardsIgnoreEnd