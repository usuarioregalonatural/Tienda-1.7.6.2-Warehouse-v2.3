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

class UniteWpmlRev
{

    public static function isWpmlExists()
    {
        return true;

        if (class_exists("SitePress")) {
            return(true);
        } else {
            return(false);
        }
    }

    private static function validateWpmlExists()
    {
        if (!self::isWpmlExists()) {
            UniteFunctionsRev::throwError("The wpml plugin don't exists");
        }
    }

    public static function getArrLanguages($getAllCode = true)
    {
        $arrLangs = Language::getLanguages();

        $response = array();



        if ($getAllCode == true) {
            $response["all"] = __("All Languages", REVSLIDER_TEXTDOMAIN);
        }



        foreach ($arrLangs as $code => $arrLang) {
            $ind = $arrLang['iso_code'];
            $response[$ind] = $arrLang['name'];
        }



        return($response);
    }

    public static function getArrLangCodes($getAllCode = true)
    {
        $arrCodes = array();

        if ($getAllCode == true) {
            $arrCodes["all"] = "all";
        }

        $arrLangs = Language::getLanguages();

        foreach ($arrLangs as $code => $arr) {
            $ind = $arr['iso_code'];

            $arrCodes[$ind] = $ind;
        }

        return($arrCodes);
    }

    public static function isAllLangsInArray($arrCodes)
    {
        $arrAllCodes = self::getArrLangCodes();

        $diff = array_diff($arrAllCodes, $arrCodes);

        return(empty($diff));
    }

    public static function getLangsWithFlagsHtmlList($props = "", $htmlBefore = "")
    {
        $arrLangs = self::getArrLanguages();

        if (!empty($props)) {
            $props = " " . $props;
        }



        $html = "<ul" . $props . ">" . "\n";

        $html .= $htmlBefore;




        foreach ($arrLangs as $code => $title) {
            $urlIcon = self::getFlagUrl($code);

            $html .= "<li data-lang='" . $code . "' class='item_lang'><a data-lang='" . $code . "' href='javascript:void(0)'>" . "\n";

            $html .= "<img src='" . $urlIcon . "'/> $title" . "\n";

            $html .= "</a></li>" . "\n";
        }



        $html .= "</ul>";





        return($html);
    }

    public static function getFlagUrl($code)
    {
        $arrLangs = Language::getLanguages();

        if ($code == 'all') {
            $url = get_url() . '/views/img/images/icon16.png';
        } else {
            $url = '';
            foreach ($arrLangs as $lang) {
                if ($lang['iso_code'] == $code) {
                    $url = _THEME_LANG_DIR_ . $lang['id_lang'] . '.jpg';
                }
            }
        }


        return($url);
    }

    private function getLangDetails($code)
    {
        $wpdb = rev_db_class::revDbInstance();

        $details = $wpdb->getRow("SELECT * FROM " . $wpdb->prefix . "icl_languages WHERE code='$code'");



        if (!empty($details)) {
            $details = (array) $details;
        }



        return($details);
    }

    public static function getLangTitle($code)
    {
        $langs = self::getArrLanguages();



        if ($code == "all") {
            return(__("All Languages", REVSLIDER_TEXTDOMAIN));
        }



        if (array_key_exists($code, $langs)) {
            return($langs[$code]);
        }



        $details = self::getLangDetails($code);

        if (!empty($details)) {
            return($details["english_name"]);
        }



        return("");
    }

    public static function getCurrentLang()
    {
        $language = Context::getContext()->language;

        $lang = $language->iso_code;

        return($lang);
    }
// @codingStandardsIgnoreStart    
}
// @codingStandardsIgnoreEnd
// @codingStandardsIgnoreStart
class RevSliderWpml extends UniteWpmlRev
{
    // @codingStandardsIgnoreEnd
}
