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

    $operations = new RevOperations();

    //set Layer settings
    $contentCSS = $operations->getCaptionsContent();
    $arrAnimations = $operations->getArrAnimations();
    $arrEndAnimations = $operations->getArrEndAnimations();

    $htmlButtonDown = '<div id="layer_captions_down" style="width:30px; text-align:center;padding:0px;" class="revgray button-primary"><i class="eg-icon-down-dir"></i></div>';
    $buttonEditStyles = UniteFunctionsRev::getHtmlLink("javascript:void(0)", "<i class=\"revicon-magic\"></i>Edit Style", "button_edit_css", "button-primary revblue");
    $buttonEditStylesGlobal = UniteFunctionsRev::getHtmlLink("javascript:void(0)", "<i class=\"revicon-palette\"></i>Edit Global Style", "button_edit_css_global", "button-primary revblue");

    $arrSplit = $operations->getArrSplit();
    $arrEasing = $operations->getArrEasing();
    $arrEndEasing = $operations->getArrEndEasing();

    $captionsAddonHtml = $htmlButtonDown.$buttonEditStyles.$buttonEditStylesGlobal;

    //set Layer settings
    $layerSettings = new UniteSettingsAdvancedRev();
    $layerSettings->addSection(RevsliderPrestashop::$lang['Layer_Params'], RevsliderPrestashop::$lang['layer_params']);
    $layerSettings->addSap(RevsliderPrestashop::$lang['Layer_Params'], RevsliderPrestashop::$lang['layer_params']);
    $layerSettings->addTextBox("layer_caption", RevsliderPrestashop::$lang['caption_green'], RevsliderPrestashop::$lang['Style'], array(UniteSettingsRev::PARAM_ADDTEXT=>$captionsAddonHtml, "class"=>"textbox-caption"));

    $addHtmlTextarea = '';
//	if($sliderTemplate == "true"){
//		$addHtmlTextarea .= UniteFunctionsRev::getHtmlLink("javascript:void(0)", "Insert Meta","linkInsertTemplate","disabled revblue button-primary");
//	}
    $addHtmlTextarea .= UniteFunctionsRev::getHtmlLink("javascript:void(0)", "Insert Button", "linkInsertButton", "disabled revblue button-primary");

    $layerSettings->addTextArea("layer_text", "", RevsliderPrestashop::$lang['Text_Html'], array("class"=>"area-layer-params", UniteSettingsRev::PARAM_ADDTEXT_BEFORE_ELEMENT=>$addHtmlTextarea));
    $layerSettings->addTextBox("layer_image_link", "", RevsliderPrestashop::$lang['Image_Link'], array("class"=>"text-sidebar-link", "hidden"=>true));
    $layerSettings->addSelect("layer_link_open_in", array("same"=>RevsliderPrestashop::$lang['Same_Window'], "new"=>RevsliderPrestashop::$lang['New_Window']), RevsliderPrestashop::$lang['Link_Open_In'], "same", array("hidden"=>true));

    $layerSettings->addSelect("layer_animation", $arrAnimations, RevsliderPrestashop::$lang['Start_Animation'], "fade");
    $layerSettings->addSelect("layer_easing", $arrEasing, RevsliderPrestashop::$lang['Start_Easing'], "Power3.easeInOut");
    $params = array("unit"=>RevsliderPrestashop::$lang['ms']);
    $paramssplit = array("unit"=>RevsliderPrestashop::$lang['ms_keep_low']);
    $layerSettings->addTextBox("layer_speed", "", "Start Duration", $params);
    $layerSettings->addTextBox("layer_splitdelay", "10", "Split Delay", $paramssplit);
    $layerSettings->addSelect("layer_split", $arrSplit, RevsliderPrestashop::$lang['Split_Text_per'], "none");
    $layerSettings->addCheckbox("layer_hidden", false, RevsliderPrestashop::$lang['Hide_Under_Width']);

    $params = array("hidden"=>true);
    $layerSettings->addTextBox("layer_link_id", "", RevsliderPrestashop::$lang['Link_ID'], $params);
    $layerSettings->addTextBox("layer_link_class", "", RevsliderPrestashop::$lang['Link_Classes'], $params);
    $layerSettings->addTextBox("layer_link_title", "", RevsliderPrestashop::$lang['Link_Title'], $params);
    $layerSettings->addTextBox("layer_link_rel", "", RevsliderPrestashop::$lang['Link_Rel'], $params);

    //scale for img
    $textScaleX = RevsliderPrestashop::$lang['Width'];
    $textScaleProportionalX = RevsliderPrestashop::$lang['Width_Height'];
    $params = array("attrib_text"=>"data-textproportional='".$textScaleProportionalX."' data-textnormal='".$textScaleX."'", "hidden"=>false);
    $layerSettings->addTextBox("layer_scaleX", "", RevsliderPrestashop::$lang['Width'], $params);
    $layerSettings->addTextBox("layer_scaleY", "", RevsliderPrestashop::$lang['Height'], array("hidden"=>false));
    $layerSettings->addCheckbox("layer_proportional_scale", false, RevsliderPrestashop::$lang['Scale_Proportional'], array("hidden"=>false));

    $arrParallaxLevel = array(
                            '-' => RevsliderPrestashop::$lang['No_Movement'],
                            '1' => RevsliderPrestashop::$lang['1'],
                            '2' => RevsliderPrestashop::$lang['2'],
                            '3' => RevsliderPrestashop::$lang['3'],
                            '4' => RevsliderPrestashop::$lang['4'],
                            '5' => RevsliderPrestashop::$lang['5'],
                            '6' => RevsliderPrestashop::$lang['6'],
                            '7' => RevsliderPrestashop::$lang['7'],
                            '8' => RevsliderPrestashop::$lang['8'],
                            '9' => RevsliderPrestashop::$lang['9'],
                            '10' => RevsliderPrestashop::$lang['10'],
                            );
    $layerSettings->addSelect("parallax_level", $arrParallaxLevel, RevsliderPrestashop::$lang['Level'], "nowrap", array("hidden"=>false));


    //put left top
    $textOffsetX = RevsliderPrestashop::$lang['OffsetX'];
    $textX = RevsliderPrestashop::$lang['X'];
    $params = array("attrib_text"=>"data-textoffset='".$textOffsetX."' data-textnormal='".$textX."'");
    $layerSettings->addTextBox("layer_left", "", RevsliderPrestashop::$lang['X'], $params);

    $textOffsetY = RevsliderPrestashop::$lang['OffsetY'];
    $textY = RevsliderPrestashop::$lang['Y'];
    $params = array("attrib_text"=>"data-textoffset='".$textOffsetY."' data-textnormal='".$textY."'");
    $layerSettings->addTextBox("layer_top", "", RevsliderPrestashop::$lang['Y'], $params);

    $layerSettings->addTextBox("layer_align_hor", "left", RevsliderPrestashop::$lang['Hor_Align'], array("hidden"=>true));
    $layerSettings->addTextBox("layer_align_vert", "top", RevsliderPrestashop::$lang['Vert_Align'], array("hidden"=>true));

    $para = array("unit"=>RevsliderPrestashop::$lang['nbsp_auto'], 'hidden'=>true);
    $layerSettings->addTextBox("layer_max_width", "auto", RevsliderPrestashop::$lang['Max_Width'], $para);
    $layerSettings->addTextBox("layer_max_height", "auto", RevsliderPrestashop::$lang['Max_Height'], $para);
    
    $layerSettings->addTextBox("layer_2d_rotation", "0", RevsliderPrestashop::$lang['2D_Rotation'], array("hidden"=>false, 'unit'=>'&nbsp;(-360 - 360)'));
    $layerSettings->addTextBox("layer_2d_origin_x", "50", RevsliderPrestashop::$lang['Rotation_Origin_X'], array("hidden"=>false, 'unit'=>'%&nbsp;(-100 - 200)'));
    $layerSettings->addTextBox("layer_2d_origin_y", "50", RevsliderPrestashop::$lang['Rotation_Origin_Y'], array("hidden"=>false, 'unit'=>'%&nbsp;(-100 - 200)'));

    //advanced params
    $arrWhiteSpace = array("normal"=>RevsliderPrestashop::$lang['Normal'],
                        "pre"=>RevsliderPrestashop::$lang['Pre'],
                        "nowrap"=>RevsliderPrestashop::$lang['NO_Wrap'],
                        "pre-wrap"=>RevsliderPrestashop::$lang['Pre_Wrap'],
                        "pre-line"=>RevsliderPrestashop::$lang['Pre_Line']);


    $layerSettings->addSelect("layer_whitespace", $arrWhiteSpace, RevsliderPrestashop::$lang['White_Space'], "nowrap", array("hidden"=>true));
        $arrSlideLink = array();
        $arrSlideLink["nothing"] = __("-- Not Chosen --", 'revslider');
        $arrSlideLink["next"] = __("-- Next Slide --", 'revslider');
        $arrSlideLink["prev"] = __("-- Previous Slide --", 'revslider');

        $arrSlideLinkLayers = $arrSlideLink;
        $arrSlideLinkLayers["scroll_under"] = __("-- Scroll Below Slider --", 'revslider');

    $layerSettings->addSelect("layer_slide_link", $arrSlideLinkLayers, RevsliderPrestashop::$lang['Link_To_Slide'], "nothing");

    $params = array("unit"=>RevsliderPrestashop::$lang['px'],"hidden"=>true);
    $layerSettings->addTextBox("layer_scrolloffset", "0", RevsliderPrestashop::$lang['Scroll_Under_Slider'], $params);

    $layerSettings->addButton("button_change_image_source", RevsliderPrestashop::$lang['Change_Image_Source'], array("hidden"=>true, "class"=>"button-primary revblue"));
    $layerSettings->addTextBox("layer_alt", "", "Alt Text", array("hidden"=>true, "class"=>"area-alt-params"));
    $layerSettings->addButton("button_edit_video", RevsliderPrestashop::$lang['Edit_Video'], array("hidden"=>true, "class"=>"button-primary revblue"));



    $params = array("unit"=>RevsliderPrestashop::$lang['ms']);
    $paramssplit = array("unit"=>RevsliderPrestashop::$lang['ms_keep_low']);
    $params_1 = array("unit"=> RevsliderPrestashop::$lang['ms'], 'hidden'=>true);
    $layerSettings->addTextBox("layer_endtime", "", RevsliderPrestashop::$lang['End_Time'], $params_1);
    $layerSettings->addTextBox("layer_endspeed", "", RevsliderPrestashop::$lang['End_Duration'], $params);
    $layerSettings->addTextBox("layer_endsplitdelay", "10", "End Split Delay", $paramssplit);
    $layerSettings->addSelect("layer_endsplit", $arrSplit, RevsliderPrestashop::$lang['Split_Text_per'], "none");
    $layerSettings->addSelect("layer_endanimation", $arrEndAnimations, RevsliderPrestashop::$lang['End_Animation'], "auto");
    $layerSettings->addSelect("layer_endeasing", $arrEndEasing, RevsliderPrestashop::$lang['End_Easing'], "nothing");
    $params = array("unit"=>RevsliderPrestashop::$lang['ms']);

    //advanced params
    $arrCorners = array("nothing"=>RevsliderPrestashop::$lang['No_Corner'],
                        "curved"=>RevsliderPrestashop::$lang['Sharp'],
                        "reverced"=>RevsliderPrestashop::$lang['Sharp_Reversed']);
    $params = array();
    $layerSettings->addSelect("layer_cornerleft", $arrCorners, RevsliderPrestashop::$lang['Left_Corner'], "nothing", $params);
    $layerSettings->addSelect("layer_cornerright", $arrCorners, RevsliderPrestashop::$lang['Right_Corner'], "nothing", $params);
    $layerSettings->addCheckbox("layer_resizeme", true, RevsliderPrestashop::$lang['Responsive_Levels'], $params);

    $params = array();
    $layerSettings->addTextBox("layer_id", "", RevsliderPrestashop::$lang['ID'], $params);
    $layerSettings->addTextBox("layer_classes", "", RevsliderPrestashop::$lang['Classes'], $params);
    $layerSettings->addTextBox("layer_title", "", RevsliderPrestashop::$lang['Title'], $params);
    $layerSettings->addTextBox("layer_rel", "", RevsliderPrestashop::$lang['Rel'], $params);

    //Loop Animation
    $arrAnims = array("none"=>RevsliderPrestashop::$lang['Disabled'],
                        "rs-pendulum"=>RevsliderPrestashop::$lang['Pendulum'],
                        "rs-slideloop"=>RevsliderPrestashop::$lang['Slideloop'],
                        "rs-pulse"=>RevsliderPrestashop::$lang['Pulse'],
                        "rs-wave"=>RevsliderPrestashop::$lang['Wave']
                        );

    $params = array();
    $layerSettings->addSelect("layer_loop_animation", $arrAnims, RevsliderPrestashop::$lang['Animation'], "none", $params);
    $layerSettings->addTextBox("layer_loop_speed", "2", RevsliderPrestashop::$lang['Speed'], array("unit"=>RevsliderPrestashop::$lang['nbsp']));
    $layerSettings->addTextBox("layer_loop_startdeg", "-20", RevsliderPrestashop::$lang['Start_Degree']);
    $layerSettings->addTextBox("layer_loop_enddeg", "20", RevsliderPrestashop::$lang['End_Degree'], array("unit"=>RevsliderPrestashop::$lang['nbsp']));
    $layerSettings->addTextBox("layer_loop_xorigin", "50", RevsliderPrestashop::$lang['x_Origin'], array("unit"=>RevsliderPrestashop::$lang['%']));
    $layerSettings->addTextBox("layer_loop_yorigin", "50", RevsliderPrestashop::$lang['y_Origin'], array("unit"=>RevsliderPrestashop::$lang['%_250']));
    $layerSettings->addTextBox("layer_loop_xstart", "0", RevsliderPrestashop::$lang['x_Start_Pos'], array("unit"=>RevsliderPrestashop::$lang['px']));
    $layerSettings->addTextBox("layer_loop_xend", "0", RevsliderPrestashop::$lang['x_End_Pos'], array("unit"=> RevsliderPrestashop::$lang['2000px_2000px']));
    $layerSettings->addTextBox("layer_loop_ystart", "0", RevsliderPrestashop::$lang['y_Start_Pos'], array("unit"=>RevsliderPrestashop::$lang['px']));
    $layerSettings->addTextBox("layer_loop_yend", "0", RevsliderPrestashop::$lang['y_End_Pos'], array("unit"=>RevsliderPrestashop::$lang['px_2000px']));
    $layerSettings->addTextBox("layer_loop_zoomstart", "1", RevsliderPrestashop::$lang['Start_Zoom']);
    $layerSettings->addTextBox("layer_loop_zoomend", "1", RevsliderPrestashop::$lang['End_Zoom'], array("unit"=>RevsliderPrestashop::$lang['nbsp_20']));
    $layerSettings->addTextBox("layer_loop_angle", "0", RevsliderPrestashop::$lang['Angle'], array("unit"=>RevsliderPrestashop::$lang['0°_360°']));
    $layerSettings->addTextBox("layer_loop_radius", "10", RevsliderPrestashop::$lang['Radius'], array("unit"=>RevsliderPrestashop::$lang['0px_2000px']));
    $layerSettings->addSelect("layer_loop_easing", $arrEasing, RevsliderPrestashop::$lang['Easing'], "Power3.easeInOut");

    self::storeSettings("layer_settings", $layerSettings);

    //store settings of content css for editing on the client.
    self::storeSettings("css_captions_content", $contentCSS);
