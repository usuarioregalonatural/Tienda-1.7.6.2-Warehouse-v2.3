<?php 
define('ABSPATH', _PS_MODULE_DIR_ . 'revsliderprestashop'); 
define('DB_PREFIX', _DB_PREFIX_); 
if (!defined('ARRAY_A'))
    define('ARRAY_A', true); 

if (!defined('RS_PLUGIN_URL'))
    define('RS_PLUGIN_URL', get_module_url());
if (!defined('RS_PLUGIN_PATH'))
    define('RS_PLUGIN_PATH', _PS_MODULE_DIR_ . 'revsliderprestashop');
if (!defined('RS_PLUGIN_ADDONS_PATH'))
    define('RS_PLUGIN_ADDONS_PATH', _PS_MODULE_DIR_ . 'revsliderprestashop'.'/addons/');
if (!defined('RS_PLUGIN_ADDONS_URL'))
    define('RS_PLUGIN_ADDONS_URL', get_module_url().'addons/');
if (!defined('REVSLIDER_TEXTDOMAIN'))
    define('REVSLIDER_TEXTDOMAIN', "revslider");


define( 'KB_IN_BYTES', 1024 );
define( 'MB_IN_BYTES', 1024 * KB_IN_BYTES ); 
define( 'GB_IN_BYTES', 1024 * MB_IN_BYTES );
define( 'TB_IN_BYTES', 1024 * GB_IN_BYTES );  
global $wp_version;
$ps_version = null;
$wp_version = $ps_version;

$revSliderAsTheme = false;
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/base.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/elements-base.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/base-admin.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/base-front.class.php');

//include product files
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/revslider_db.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/globals.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/operations.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/slider.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/output.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/slide.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/navigation.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/object-library.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/template.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/external-sources.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/functions-wordpress.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/functions.class.php');    
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/colorpicker.class.php');    
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/cssparser.class.php');   
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/plugin-update.class.php'); 
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/em_integration.class.php');     
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/extension.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/aq_resizer.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/addon-admin.class.php'); 
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/wpml.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/update.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/revslider-front.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/framework/newsletter.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/hooks.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/settings.class.php');
require_once(_PS_MODULE_DIR_ . 'revsliderprestashop' . '/includes/settings_advances.class.php');

global $wpdb;
$wpdb = rev_db_class::rev_db_instance();

class RevLoader{
    
    public static $hook_args;
    public static $hook_values,$filter_values,$hook_register,$hook_deregister; 
    public static $admin_scripts = array(),$admin_scripts_foot = array(),$front_scripts_foot= array(),$front_scripts= array(),$front_styles= array(),$admin_styles= array(),$registered_script,$registered_style;
   public $headers, $body;
    public function __construct()
    {
        $this->headers = '';
        $this->body = '';
    }
    private function streamHeaders($handle, $headers) {
        $this->headers .= $headers;
        return self::strlen($headers);
    }

    public static function strlen($str, $encoding = 'UTF-8')
    {
        if (is_array($str)) {
            return false;
        }
        $str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, $encoding);
        }
        return strlen($str);
    }
    private function streamBody($handle, $data) {
            
        $data_length = strlen($data);
        $this->body .= $data;
        // Upon event of this function returning less than strlen( $data ) curl will error with CURLE_WRITE_ERROR.
        return $data_length;
    }

    public static function shouldDecode($headers)
    {
        if (is_array($headers)) {
            if (array_key_exists('content-encoding', $headers) && !empty($headers['content-encoding']))
                return true;
        } elseif (is_string($headers)) {
            return ( stripos($headers, 'content-encoding:') !== false );
        }

        return false;
    }
    public static function decompress($compressed, $length = null)
    {

        if (empty($compressed))
            return $compressed;

        if (false !== ( $decompressed = @gzinflate($compressed) ))
            return $decompressed;

        if (false !== ( $decompressed = self::compatibleGzinflate($compressed) ))
            return $decompressed;

        if (false !== ( $decompressed = @gzuncompress($compressed) ))
            return $decompressed;

        if (function_exists('gzdecode')) {
            $decompressed = @gzdecode($compressed);

            if (false !== $decompressed)
                return $decompressed;
        }

        return $compressed;
    }
    public static function getval($key, $store_id = 0, $group = 'config')
    {
        $value = Configuration::get($key);
        if (@RevsliderPrestashop::getIsset($value)) {
            return $value;
        } else {
            return false;
        }
    }

    public static function setval($key, $value = '', $group = 'config', $store_id = 0, $serialized = 0)
    {
        $value = serialize($value);
        if (Configuration::updateValue($key, $value)) {
            return true;
        } else {
            return false;
        }
    }
    public static function compatibleGzinflate($gzData)
    {

        // Compressed data might contain a full header, if so strip it for gzinflate().
        if (substr($gzData, 0, 3) == "\x1f\x8b\x08") {
            $i = 10;
            $flg = ord(substr($gzData, 3, 1));
            if ($flg > 0) {
                if ($flg & 4) {
                    list($xlen) = unpack('v', substr($gzData, $i, 2));
                    $i = $i + 2 + $xlen;
                }
                if ($flg & 8)
                    $i = strpos($gzData, "\0", $i) + 1;
                if ($flg & 16)
                    $i = strpos($gzData, "\0", $i) + 1;
                if ($flg & 2)
                    $i = $i + 2;
            }
            $decompressed = @gzinflate(substr($gzData, $i, -8));
            if (false !== $decompressed)
                return $decompressed;
        }

        // Compressed data from java.util.zip.Deflater amongst others.
        $decompressed = @gzinflate(substr($gzData, 2));
        if (false !== $decompressed)
            return $decompressed;

        return false;
    }
    public function getHttpCurl($url, $args) {
        global $wp_version;
        if (function_exists('curl_init')) {
            $defaults = array(
                'method' => 'GET',
                'timeout' => 30,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(
                    'Authorization' => 'Basic ',
                    'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                    'Accept-Encoding' => 'x-gzip,gzip,deflate'
                ),
                'body' => array(),
                'cookies' => array(),
                'user-agent' => 'Prestashop' . $wp_version,
                'header' => false,
                'sslverify' => true,
            );
            
            $args = smart_merge_attrs($defaults, $args); 
            $curl_timeout = ceil($args['timeout']);
            $curl = curl_init();

            if ($args['httpversion'] == '1.0') {
                curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            } else {
                curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            }
            curl_setopt($curl, CURLOPT_USERAGENT, $args['user-agent']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $curl_timeout);
            curl_setopt($curl, CURLOPT_TIMEOUT, $curl_timeout);

            $ssl_verify = $args['sslverify'];
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $ssl_verify);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, ( $ssl_verify === true ) ? 2 : false );
            if ($ssl_verify) {
                curl_setopt($curl, CURLOPT_CAINFO, _PS_MODULE_DIR_ . 'revsliderprestashop' . '/admin/views/ssl/ca-bundle.crt');
            }

            curl_setopt($curl, CURLOPT_HEADER, $args['header']);
            /*
             * The option doesn't work with safe mode or when open_basedir is set, and there's
             * a bug #17490 with redirected POST requests, so handle redirections outside Curl.
             */
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
            if (defined('CURLOPT_PROTOCOLS')) { // PHP 5.2.10 / cURL 7.19.4
                curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
            }
            

            $http_headers = array();
            foreach ($args['headers'] as $key => $value) {
                $http_headers[] = "{$key}: {$value}";
            }
           
            if (is_array($args['body']) || is_object($args['body'])) {
                $args['body'] = http_build_query($args['body']);
            }
            $http_headers[] = 'Content-Length: ' . strlen($args['body']);
             
            curl_setopt($curl, CURLOPT_HTTPHEADER, $http_headers);
            switch ($args['method']) {
                case 'HEAD':
                    curl_setopt($curl, CURLOPT_NOBODY, true);
                    break;
                case 'POST':
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $args['body']);
                    break;
                case 'PUT':
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $args['body']);
                    break;
                default:
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $args['method']);
                    if (!is_null($args['body'])) {
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $args['body']);
                    }
                    break;
            }
            
            curl_setopt($curl, CURLOPT_HEADERFUNCTION, array($this, 'streamHeaders'));
            curl_setopt($curl, CURLOPT_WRITEFUNCTION, array($this, 'streamBody'));
         //   curl_setopt($curl, CURLOPT_ENCODING, '');
            
                
            curl_exec($curl);

            $responseBody = $this->body;
            $responseHeader = $this->headers;
          
            if (self::shouldDecode($responseHeader) === true) {
                $responseBody = self::decompress($responseBody);
            }
            $this->body = '';
            $this->headers = '';
           
            $error = curl_error($curl);
            $errorcode = curl_errno($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
            $info_as_response = $info;
            $info_as_response['code'] = $info['http_code'];
            $info_as_response['message'] = 'OK';
            $response = array('body' => $responseBody, 'headers' => $responseHeader, 'info' => $info,'response' => $info_as_response, 'error' => $error, 'errno' => $errorcode);
                
            return $response;
        }
        return false;
    }
                
                
             public static function getIsset($variable)
    {
        return isset($variable);
    }   
	public static function getConstants($this_value){
            if(!is_admin()){
                return null;
            }
		$$this_value = null;
		$rev_slider_version = "5.4.2";

 
		$view_slide = "slide";
		//$url_filemanager_actions = "index.php?option=com_revslider&view=sdsfm&task=sdsfm.filemanager";
                $url_filemanager_actions = 'index.php?controller=AdminRevolutionsliderFmanager&view&token='.Tools::getAdminTokenLite('AdminRevolutionsliderFmanager');

                
//                $revslider_core_url = JRoute::_('index.php?option=com_revslider', false);
                $revslider_core_url = 'index.php?controller=AdminRevslider&token='.Tools::getAdminTokenLite('AdminRevslider');

		//$import_slider = JRoute::_('index.php?option=com_revslider&task=import.slider', false);
                $import_slider = 'index.php?controller=AdminRevslider&view=revaddon&page=rev_addon&token='.Tools::getAdminTokenLite('AdminRevslider');

	//	$ajaxurl = JRoute::_('index.php?option=com_revslider&view=ajaxurl&format=json', false);
                $ajaxurl = 'index.php?controller=AdminRevolutionsliderAjax&page=revslider&token='.Tools::getAdminTokenLite('AdminRevolutionsliderAjax');

          //      $url_ajax = JRoute::_('index.php?option=com_revslider&page=revslider&view=sliders', false);
                $url_ajax = 'index.php?controller=AdminRevslider&view=sliders&page=revslider&token='.Tools::getAdminTokenLite('AdminRevslider');

		$url_ajax_actions = $ajaxurl;
              //  $url_ajax_actions = 'index.php?controller=AdminRevslider&view=revaddon&page=rev_addon&token='.Tools::getAdminTokenLite('AdminRevslider');

		//$url_ajax_showimage = $url_ajax . "&task=ajaxpost.keyaction&tmpl=component";
                $url_ajax_showimage = 'index.php?controller=AdminRevslider&view=revaddon&page=rev_addon&token='.Tools::getAdminTokenLite('AdminRevslider');

	//	$rs_plugin_url = JRoute::_('index.php?option=com_revslider&page=revslider&view=sliders', false);
                $rs_plugin_url = 'index.php?controller=AdminRevslider&page=revslider&view=sliders&token='.Tools::getAdminTokenLite('AdminRevslider');

	//	$browse_sliders = JRoute::_('index.php?option=com_revslider&view=sliders&page=revslider', false);
                $browse_sliders = 'index.php?controller=AdminRevslider&view=sliders&page=revslider&token='.Tools::getAdminTokenLite('AdminRevslider');

		//$addNewLink = JRoute::_('index.php?option=com_revslider&view=slider&page=revslider&layout=edit', false);
                $addNewLink = 'index.php?controller=AdminRevslider&view=slider&page=revslider&token='.Tools::getAdminTokenLite('AdminRevslider');

		//$editLink = JRoute::_('index.php?option=com_revslider&page=revslider&view=slide&id=', false);
                $editLink = 'index.php?controller=AdminRevslider&page=revslider&view=slide&id&token='.Tools::getAdminTokenLite('AdminRevslider');

		//$viewLink = JRoute::_('index.php?option=com_revslider&view=slider&layout=edit&page=revslider&id=', false);
                $viewLink = 'index.php?controller=AdminRevslider&view=slider&page=revslider&id&token='.Tools::getAdminTokenLite('AdminRevslider');

	       //$linksEditSlides = JRoute::_('index.php?option=com_revslider&view=slides&page=revslider&layout=edit&', false);
                $linksEditSlides = 'index.php?controller=AdminRevslider&view=slides&page=revslider&token='.Tools::getAdminTokenLite('AdminRevslider');

                $addon_url = 'index.php?controller=AdminRevslider&view=revaddon&page=rev_addon&token='.Tools::getAdminTokenLite('AdminRevslider');
		$rs_demo = false;
		
           //     $admin_asset_url = JUri::root()."/3.6.5/media/com_revslider/sds_rfm/img";
		return $$this_value;
	}
        
        
     
                
        //addons functions
        public static function loadActiveAddons(){
                                                                                
            $allowed_addons_default=array();
                        $addons = get_option('revslider-addons',$allowed_addons_default); 
//                        $addons = get_option('revslider-addons-new',$addons); 
                        if(!is_array($addons)){
                            $addons = json_decode($addons,true);
                        }
                                                                                
                                            foreach($addons as $addon => $addon_value){
                                                $addon_folder_name =  $addon_value['slug'].'/'.$addon_value['slug'].'.php';
                                                // var_dump($addon);                                                             
                                                if(get_option($addon_folder_name)=='active'){

                                                    $addon_file_path = RS_PLUGIN_ADDONS_PATH.$addon_value['slug'].'/'.$addon_value['slug'].'.php';

                                                    if(file_exists($addon_file_path)){
                                                        require_once $addon_file_path;
                                                    }

                                                }                                        
                                            }  
         }
        public static function loadSpecificAddons($addon){                        
                                                                                
                $addon_folder_name =  $addon.'/'.$addon.'.php';
                                                                                
                if(get_option($addon_folder_name)=='active'){
                    
                    $addon_file_path = RS_PLUGIN_ADDONS_PATH.$addon.'/'.$addon.'.php';
                     if(file_exists($addon_file_path)){
                        require_once $addon_file_path;
                    }
                }                                                                    
            
         }
        public static function loadAllAddons(){ 
            
            $allowed_addons_default=array();
                        $addons = get_option('revslider-addons',$allowed_addons_default); 
                        if(!is_array($addons)){
                            $addons = json_decode($addons,true);
                        }
                                                                                
            foreach($addons as $addon => $addon_value){
                $addon_folder_name =  $addon.'/'.$addon.'.php';
                                                                                
              //  if(get_option($addon_folder_name)=='active'){
                    
                    $addon_file_path = RS_PLUGIN_ADDONS_PATH.$addon.'/'.$addon.'.php';
                    if(file_exists($addon_file_path)){
                        require_once $addon_file_path;
                    }
              //  }                                        
            }
         }
        
        public static function enqueue_style($styleName, $src = '' , $deps = array(),$ver = '1.0',$media = 'all', $noscript)
        {
            if(is_admin()){
                self::$admin_styles[$styleName] = $src;
            }else{
                self::$front_styles[$styleName] = $src;
            }
        }
        public static function enqueue_script($scriptName, $src = '' , $deps = array(),$ver = '1.0',$in_footer = false)
        {                                                                   
            if($in_footer == false){
               if(is_admin()){
                    self::$admin_scripts[$scriptName] = $src;
                }else{
                    self::$front_scripts[$scriptName] = $src;
                } 
            }else{
                if(is_admin()){
                    self::$admin_scripts_foot[$scriptName] = $src;
                }else{
                    self::$front_scripts_foot[$scriptName] = $src;
                } 
            }
            
           
        }
        
        public static function load_admin_styles(){
           // $document = JFactory::getDocument();
          //  var_dump(self::$admin_styles);die();
            foreach(self::$admin_styles as $style){ 
                echo "<link rel='stylesheet' href='{$style['src']}' type='text/css' />";
            }
            
        }
        public static function load_admin_scripts(){
          //  $document = JFactory::getDocument();
            foreach(self::$admin_scripts as $script){ 
                //Context::getcontext()->controller->addJS($script['src']);
                echo "<script type='text/javascript' src='".$script['src']."'></script>";
            }
            
        }
        public static function load_front_styles(){
          //  $document = JFactory::getDocument();
            foreach(self::$front_styles as $style){
                 echo "<link rel='stylesheet' href='{$style['src']}' type='text/css' />";
            } 
        }
        public static function load_front_scripts(){
         //   $document = JFactory::getDocument();
            foreach(self::$front_scripts as $script){
                 echo "<script type='text/javascript' src='".$script['src']."'></script>";
            }
            
        }
        
        function wp_remote_fopen($Url)
{ 
    $UserAgentList = array();
    $UserAgentList[] = "Mozilla/4.0 (compatible; MSIE 6.0; X11; Linux i686; en) Opera 8.01";
    $UserAgentList[] = "Mozilla/5.0 (compatible; Konqueror/3.3; Linux) (KHTML, like Gecko)";
    $UserAgentList[] = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2";
    $UserAgentList[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9.2.25) Gecko/20111212 Firefox/3.6.25";
    $UserAgentList[] = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.52.7 (KHTML, like Gecko) Version/5.1.2 Safari/534.52.7";
    $UserAgentList[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; Win64; x64; SV1; .NET CLR 2.0.50727)";
    $UserAgentList[] = "Mozilla/5.0 (Windows NT 6.1; rv:8.0.1) Gecko/20100101 Firefox/8.0.1";
    $UserAgentList[] = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7";

    $hcurl = curl_init();

    curl_setopt($hcurl, CURLOPT_URL, $Url);
    curl_setopt($hcurl, CURLOPT_USERAGENT, $UserAgentList[array_rand($UserAgentList)]);
    curl_setopt($hcurl, CURLOPT_TIMEOUT, 120);
    curl_setopt($hcurl, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($hcurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($hcurl, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($hcurl);
    curl_close($hcurl);

    return $result;
}
public static function createNonce($pure_string){
		return $pure_string;
		$encryption_key = "909454";
	    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
	    return $encrypted_string;
	}
}
function get_url($link = '')
{
    $url = getHtt().'//'.Tools::getHttpHost()._MODULE_DIR_ . "revsliderprestashop/";
    $double_http = getHtt().'//'.getHtt().'//';
    $url = str_replace($double_http, getHtt().'//', $url);
   // $url = __PS_BASE_URI__ . 'modules/revsliderprestashop/';
    return $url;
}

function get_module_url($link = '')
{
    $url = getHtt().'//'.Tools::getHttpHost()._MODULE_DIR_ . "revsliderprestashop/";
    $double_http = getHtt().'//'.getHtt().'//';
    $url = str_replace($double_http, getHtt().'//', $url);
   // $url = __PS_BASE_URI__ . 'modules/revsliderprestashop/';
    return $url;
}
function getHtt() {
	
	if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
		
		return 'https:'; 
	}
	return 'http:';
}
function add_shortcode($tag, $func) {
    UniteBaseClassRev::add_shortcode($tag, $func);
}
function do_shortcode($str) {
   
    return UniteBaseClassRev::parse($str);
}
function wp_register_script($name,$src){
    RevLoader::$registered_script[$name] = $src;
}
function wp_register_style($name,$src){
    RevLoader::$registered_style[$name] = $src;
}
 function smart_merge_attrs($pairs, $atts) {
        $atts = (array) $atts;
        $out = array();
        foreach ($pairs as $name => $default) {
            if (array_key_exists($name, $atts)) {
                $out[$name] = $atts[$name];
            } else {
                $out[$name] = $default;
            }
        }
        return $out;
    }
function admin_url($link = '') {
    $url = $_SERVER['PHP_SELF'];
    preg_match('/\?(.*)$/', $link, $found);
    // $arr = $_GET;
    $arr = array();
    if (isset($found[1]) && !empty($found[1])) {
        if (!preg_match('/\&route\=/', $found[1])) {
            unset($arr['route']);
        }
        if (isset($arr['token']))
            unset($arr['token']);

        $level1 = explode('&', $found[1]);
        foreach ($level1 as $level2) {
            $lv2 = explode('=', $level2);
            $arr[$lv2[0]] = $lv2[1];
        }
    }
    $url .= '?' . http_build_query($arr);
    return $url;
}
function wp_create_nonce($pure_string){
    RevLoader::createNonce($pure_string);
}
function add_action($tag, $function,$priority = 10,$accepted_args = 1 ){    
                                                                                
    if($tag=='plugins_loaded'){
        $params = array();
        call_user_func_array($function,$params);
    }else{
    if(is_array($function)){
      $function_info['class'] = $function[0];
      $function_info['type'] = 'class';
      $function_info['function_name'] = $function[1];   
    }else{
      $function_info['type'] = 'noclass';
      $function_info['function_name'] = $function; 
    }
    RevLoader::$hook_values[$tag][] = $function_info;
    }
    
    return true;
}
function esc_html($value){
    return $value;
}
function esc_attr($value,$ext=''){
    return $value;
}
function update_option($key, $value)
{ 
    $wpdb = rev_db_class::rev_db_instance();
    $is_exist = $wpdb->get_var("SELECT option_id FROM `{$wpdb->prefix}" . RevSliderGlobals::TABLE_REVSLIDER_OPTIONS_NAME . "` WHERE `option_name`='{$key}'");
   
    if (is_array($value) || is_object($value)) {
       
        $value = json_encode($value);
        $value = addslashes($value);
    }
      
    if (!empty($is_exist)) {
        $wpdb->query("UPDATE `" . $wpdb->prefix . RevSliderGlobals::TABLE_REVSLIDER_OPTIONS_NAME . "` SET `option_value`='{$value}' WHERE `option_id`={$is_exist} AND `option_name`='{$key}';");
    } else {
        $wpdb->query("INSERT INTO `" . $wpdb->prefix . RevSliderGlobals::TABLE_REVSLIDER_OPTIONS_NAME . "` (`option_name`, `option_value`) VALUES ('{$key}', '{$value}');");
    }
    return true;
}

function get_option($key, $default = false)
{ 
    $wpdb = rev_db_class::rev_db_instance();

    $value = $wpdb->get_var("SELECT option_value FROM `{$wpdb->prefix}" . RevSliderGlobals::TABLE_REVSLIDER_OPTIONS_NAME . "` WHERE `option_name`='{$key}'");
       
    
    return $value !== false ? $value : $default;
}     
function add_filter($tag, $function,$priority = 10,$accepted_args = 1 ){    
                
    if(is_array($function)){
      $function_info['class'] = $function[0];
      $function_info['type'] = 'class';
      $function_info['function_name'] = $function[1];   
    }else{  
      $function_info['type'] = 'noclass';
      $function_info['function_name'] = $function; 
    }  
    RevLoader::$filter_values[$tag][] = $function_info;
    return true;
}
                                                                                
function apply_filters($tag, $value,$arg1='',$arg2='',$arg3='',$arg4='',$arg5='') {
                
    if(isset(RevLoader::$filter_values[$tag])){
            $filtered_value=null;
            $params = array($value,$arg1,$arg2,$arg3,$arg4,$arg5);
            
            $filter_tag_values = RevLoader::$filter_values[$tag]; 
             foreach($filter_tag_values as $filter){ 
                if($filter['type']=='class'){ 
                 $return_data = call_user_func_array(array($filter['class'],$filter['function_name']),$params); 
                }else{ 
                 $return_data = call_user_func_array($filter['function_name'],$params);
                }  
                //get the filtered value weather string or array. sometimes returns only string
                $filtered_value = $return_data;   
                //if array then reassign the value 
                    if(is_array($return_data)){  
                        if(count($return_data) == 1 || empty($return_data)){
                            if(!empty($return_data)){
                                $array_value[key($return_data)] = $return_data[key($return_data)];
                            }  else{
                                $array_value = array();
                            }
                        }else{ 
                            $array_value= $return_data;
                        }
                        $filtered_value = $array_value;
                    } 
                
            } 
            
                        
        return $filtered_value;
    }else{
        return $value;
    } 
}
function do_action($tag,$arg1='',$arg2='',$arg3='',$arg4='',$arg5='') {
    if(isset(RevLoader::$hook_values[$tag])){
        $params = array($arg1,$arg2,$arg3,$arg4,$arg5);
       // var_dump(RevLoader::$hook_values[$tag]);
                foreach(RevLoader::$hook_values[$tag] as $hook){ 
                        if($hook['type']=='class'){  
                            call_user_func_array(array($hook['class'],$hook['function_name']),$params);
                        }else{
                            call_user_func_array($hook['function_name'],$params);   
                        } 
                }
                
        
    }else{
        return true;
    } 
}
                                                                                

function is_plugin_active($addon_folder){
    //true means that the plugin is active
    if(get_option($addon_folder)=='active'){
        return true;
    }
    return false;
} 

//function plugins_url($file,$filepath) { 
//    $filename = basename($filepath);
//    
//    $file_dir = str_replace($filename, '', $filepath);
//    
//    $get_mainsite_dir = str_replace("/", '\\', _PS_MODULE_DIR_ . 'revsliderprestashop');
//    
//    $file_url = str_replace($get_mainsite_dir, get_module_url(), $file_dir);
//    $file_url = str_replace( '\\',"/", $file_url);
//                
//    return $file_url;
//}
function plugins_url($file,$filepath) { 
    $addon_folder_name = basename($filepath,".php");
     $addon_url = RS_PLUGIN_ADDONS_URL. $addon_folder_name.'/';       
    return $addon_url;
}
function get_transient($option_name)
{ 
    $main_opt_name = "_trns_{$option_name}";

    $return = false;

    $wpdb = rev_db_class::rev_db_instance();



    $result = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . RevSliderGlobals::TABLE_REVSLIDER_OPTIONS_NAME . "` WHERE `option_name`='{$main_opt_name}'");
   // $data = preg_replace_callback('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $result['value']);
                
    $return_temp = (array)json_decode(stripslashes($result['option_value']));
    
   // var_dump($return_temp);die();
    if ($result && is_array($result) && $return_temp !=null) {
        if ($return_temp['reset_time'] >= time()) {
            $return = $return_temp['data'];
        }
    }
    return $return;
} 

function set_transient($option_name, $option_value, $reset_time = 1200)
{ 
    
    $main_opt_name = "_trns_{$option_name}";
    $wpdb = rev_db_class::rev_db_instance();

    $serialized_data = array();

    $serialized_data['reset_time'] = time() + $reset_time;

    $serialized_data['data'] = $option_value;

  //  $serialized_data = addslashes(serialize($serialized_data));
    $serialized_data =  addslashes(json_encode($serialized_data));

    $is_exist = $wpdb->get_row("SELECT * FROM `" . $wpdb->prefix . RevSliderGlobals::TABLE_REVSLIDER_OPTIONS_NAME . "` WHERE `option_name`='{$main_opt_name}'");
                                                                                
    $result_temp =(array) json_decode($is_exist['option_value']);
                
    //if ((!$is_exist || $result_temp['reset_time'] < time())) {
        if ($is_exist && isset($result_temp['reset_time']) && $result_temp['reset_time'] < time()) { 
            $wpdb->query("UPDATE `" . $wpdb->prefix . RevSliderGlobals::TABLE_REVSLIDER_OPTIONS_NAME . "` SET `option_value`='" . $serialized_data . "' WHERE `option_name`='{$main_opt_name}';");
           } elseif(!$is_exist) {
            $wpdb->query("INSERT INTO `" . $wpdb->prefix . RevSliderGlobals::TABLE_REVSLIDER_OPTIONS_NAME . "` (`option_id`, `option_name`, `option_value`) VALUES (NULL, '" . $main_opt_name . "', '" . $serialized_data . "');");
        }
   // }
    
}
function plugin_dir_path($filepath){
    $filename = basename($filepath);
    
    $file_dir = str_replace($filename, '', $filepath);
    return $file_dir;
}

function plugin_dir_url($fileurl){
    $filename = basename($fileurl);
    
    $file_url = str_replace($filename, '', $fileurl);
    
    
    $get_mainsite_dir = str_replace("/", '\\',_PS_MODULE_DIR_ . 'revsliderprestashop');
    
    $file_url = str_replace($get_mainsite_dir, get_module_url(), $file_url);
    $file_url = str_replace( '\\',"/", $file_url);
    
    return $file_url;
}
function _e($string, $text_domain=''){ 
    echo $string;
}

function get_version_from_file($file_path){
    $fp = fopen( $file_path, 'r' );

	// Pull only the first 8kiB of the file in.
	$file_data = fread( $fp, 8192 );

	// PHP will close file handle, but we are good citizens.
	fclose( $fp );

	// Make sure we catch CR-only line endings.
	$file_data = str_replace( "\r", "\n", $file_data );
        if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( 'Version', '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] ){
            return $match[1];
        }
}
function register_activation_hook($file_dir,$activation_name) {
    
    $filename = basename($file_dir);
    $filename_arr = explode('.php',$filename);
    //var_dump($filename_arr);die();
    $file_location = $filename_arr[0].'/'.$filename;                                  
    //RevLoader::$hook_register[$file_location]=$activation_name;
    $registered_hooks = get_option('hook_register',array());
    
    if(empty($registered_hooks)){
        $registered_hooks = $registered_hooks;
    }else{
        $registered_hooks = json_decode($registered_hooks,true);
    }
    
    $registered_hooks[$file_location] = $activation_name;
    
    update_option('hook_register', json_encode($registered_hooks));
    
  //  var_dump(RevLoader::$hook_register);die();
    return true;
}
function register_deactivation_hook($file_dir,$deactivation_name) {
    $filename = basename($file_dir);
    $filename_arr = explode('.php',$filename);
    //var_dump($filename_arr);die();
    $file_location = $filename_arr[0].'/'.$filename;
  //  RevLoader::$hook_deregister[$file_location]=$deactivation_name;
    $deregistered_hooks = get_option('hook_deregister',array());
    
    if(empty($deregistered_hooks)){
        $deregistered_hooks = $deregistered_hooks;
    }else{
        $deregistered_hooks = json_decode($deregistered_hooks,true);
    }
    
    $deregistered_hooks[$file_location] = $deactivation_name;
    
    update_option('hook_deregister', json_encode($deregistered_hooks));
    return true;
}
function get_image_id_by_url($image) {

    $wpdb = rev_db_class::rev_db_instance();

                                                                                
    $image = basename($image);
  $tablename = DB_PREFIX.'revslider_attachment_images';
    $id = $wpdb->get_var("SELECT ID FROM {$tablename} WHERE file_name='{$image}'");

                
    return $id;
}
function wp_enqueue_script($scriptName, $src = '', $deps = array(), $ver = '1.0', $in_footer = false) {
    
     if(isset(RevLoader::$registered_script[$scriptName])){ 
                        $src = RevLoader::$registered_script[$scriptName];
                        $deps = array();
                    }
    RevLoader::enqueue_script($scriptName, $src, $deps, $ver, $in_footer);
    
}

function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = '', $media = 'all', $noscript = false) {
    if(isset(RevLoader::$registered_style[$handle])){ 
                        $src = RevLoader::$registered_style[$handle];
                        $deps = array();
                    }
    RevLoader::enqueue_style($handle, $src, $deps, $ver, $media, $noscript);
    
}
                                                                                
function is_admin()
{
//    if(isset($_POST['client_action'])){
//        if($_POST['client_action']== "preview_slider" || $_POST['client_action']== "preview_slide"){
//            return false;
//        }
//    }
    if (isset(Context::getContext()->controller->admin_webpath) && !empty(Context::getContext()->controller->admin_webpath)){
        return true;
    }else{
        return false;
    }
              
}
function load_plugin_textdomain() {
    return true;
}
function is_ssl() {
// Config

    if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1')))
        return true;
    return false;
}
function __($text, $textdomain = '') {
    return $text;
}
function maybe_unserialize($original) {
    if (is_serialized($original)) // don't attempt to unserialize data that wasn't serialized going in
        return @unserialize($original);
    return $original;
}
 function serializedataCallback($matches){
            
            return "'s:'.strlen('$2').':\"$2\";'";
        }
function is_serialized($data, $strict = true) {
    // if it isn't a string, it isn't serialized.
    if (!is_string($data)) {
        return false;
    }
    $data = trim($data);
    if ('N;' == $data) {
        return true;
    }
    if (strlen($data) < 4) {
        return false;
    }
    if (':' !== $data[1]) {
        return false;
    }
    if ($strict) {
        $lastc = substr($data, -1);
        if (';' !== $lastc && '}' !== $lastc) {
            return false;
        }
    } else {
        $semicolon = strpos($data, ';');
        $brace = strpos($data, '}');
        // Either ; or } must exist.
        if (false === $semicolon && false === $brace)
            return false;
        // But neither must be in the first X characters.
        if (false !== $semicolon && $semicolon < 3)
            return false;
        if (false !== $brace && $brace < 4)
            return false;
    }
    $token = $data[0];
    switch ($token) {
        case 's' :
            if ($strict) {
                if ('"' !== substr($data, -2, 1)) {
                    return false;
                }
            } elseif (false === strpos($data, '"')) {
                return false;
            }
        // or else fall through
        case 'a' :
        case 'O' :
            return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
        case 'b' :
        case 'i' :
        case 'd' :
            $end = $strict ? '$' : '';
            return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
    }
    return false;
}

function content_url($link = '') {
    $url = get_module_url(). "";
    return $url;
}

        
function wp_upload_dir(){
    return _PS_MODULE_DIR_ . 'revsliderprestashop'.'/uploads/';
}
function uploads_url($src = '') {
    return _PS_MODULE_DIR_ . 'revsliderprestashop'.'/uploads/' . $src;
}
function uploads_real_url($src = '') {
    return get_module_url().'uploads/' . $src;
}
function wp_upload_url(){
     //return HTTP_SERVER.'image/catalog/revslider_media_folder/';
     return get_module_url().'uploads/';
                
}
function get_attached_file($file)
{
     
    $filepath = ABSPATH . "/uploads/{$file}";
    return file_exists($filepath) ? $filepath : false;
}

function wp_convert_hr_to_bytes( $size ) {
	$size  = strtolower( $size );
	$bytes = (int) $size;
	if ( strpos( $size, 'k' ) !== false )
		$bytes = intval( $size ) * 1024;
	elseif ( strpos( $size, 'm' ) !== false )
		$bytes = intval($size) * 1024 * 1024;
	elseif ( strpos( $size, 'g' ) !== false )
		$bytes = intval( $size ) * 1024 * 1024 * 1024;
	return $bytes;
}

function wp_is_writable( $path ) {
    if ( 'WIN' === strtoupper( substr( PHP_OS, 0, 3 ) ) )
        return win_is_writable( $path );
    else
        return @is_writable( $path );
}
function win_is_writable( $path ) {
 
    if ( $path[strlen( $path ) - 1] == '/' ) { // if it looks like a directory, check a random file within the directory
        return win_is_writable( $path . uniqid( mt_rand() ) . '.tmp');
    } elseif ( is_dir( $path ) ) { // If it's a directory (and not a file) check a random file within the directory
        return win_is_writable( $path . '/' . uniqid( mt_rand() ) . '.tmp' );
    }
    // check tmp file for read/write capabilities
    $should_delete_tmp_file = !file_exists( $path );
    $f = @fopen( $path, 'a' );
    if ( $f === false )
        return false;
    fclose( $f );
    if ( $should_delete_tmp_file )
        unlink( $path );
    return true;
}
function get_object_taxonomies($object, $output = 'names') {
    return null;
}
function selected($selected, $current = true, $echo = true)
{ 
    return __checked_selected_helper($selected, $current, $echo, 'selected');
}
function __checked_selected_helper($helper, $current, $echo, $type)
{ 
    if ((string) $helper === (string) $current) {
        $result = " $type='$type'";
    } else {
        $result = '';
    }

    if ($echo) {
        echo $result;
    } else {
        return $result;
    }
}
function checked($checked, $current = true, $echo = true)
{ 
    return __checked_selected_helper($checked, $current, $echo, 'checked');
}
function get_intermediate_image_sizes() { 
    $image_sizes = array('thumbnail', 'medium', 'medium_large', 'large','custom-size'); // Standard sizes
                
    /**
     * Filters the list of intermediate image sizes.
     *
     * @since 2.5.0
     *
     * @param array $image_sizes An array of intermediate image sizes. Defaults
     *                           are 'thumbnail', 'medium', 'medium_large', 'large'.
     */
    return  $image_sizes  ;
}
function is_multisite() {
    return false;
}
function esc_url($url){
    return $url;
}
function sanitize_title($title)
{ 
    $raw_title = $title;

    $title = strtolower($title);

    $title = str_replace(' ', '-', $title);

    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);

    return $title;
}
function size_format( $bytes, $decimals = 0 ) {
    $quant = array(
        'TB' => TB_IN_BYTES,
        'GB' => GB_IN_BYTES,
        'MB' => MB_IN_BYTES,
        'KB' => KB_IN_BYTES,
        'B'  => 1,
    );
 
    if ( 0 === $bytes ) {
        return number_format_i18n( 0, $decimals ) . ' B';
    }
 
    foreach ( $quant as $unit => $mag ) {
        if ( doubleval( $bytes ) >= $mag ) {
            return number_format_i18n( $bytes / $mag, $decimals ) . ' ' . $unit;
        }
    }
 
    return false;
}
function absint( $maybeint ) {
    return abs( intval( $maybeint ) );
}
function is_wp_error(){
    return false;
} 
function delete_files($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!delete_files($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
function esc_sql($data) {

    $wpdb = rev_db_class::rev_db_instance();

    return $wpdb->_escape($data);
}
function wp_strip_all_tags($string, $remove_breaks = false)
{ 
    $string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
    $string = strip_tags($string);

    if ($remove_breaks) {
        $string = preg_replace('/[\r\n\t ]+/', ' ', $string);
    }

    return trim($string);
}
function number_format_i18n( $number, $decimals = 0 ) {
    global $wp_locale;
 
    if ( isset( $wp_locale ) ) {
        $formatted = number_format( $number, absint( $decimals ), $wp_locale->number_format['decimal_point'], $wp_locale->number_format['thousands_sep'] );
    } else {
        $formatted = number_format( $number, absint( $decimals ) );
    }
 
    /**
     * Filters the number formatted based on the locale.
     *
     * @since  2.8.0
     *
     * @param string $formatted Converted number in string format.
     */
    return apply_filters( 'number_format_i18n', $formatted );
}
//function wp_localize_script($handle,$varName,$value){
//    RevSliderBase::$local_scripts[$varName] = $value;
//}
function rev_head() { 
    UniteBaseClassRev::rev_head();
}
function sanitize_text_field($str)
{
    $filtered = $str;

    if (strpos($filtered, '<') !== false) {
        $filtered = wp_pre_kses_less_than($filtered);
        // This will strip extra whitespace for us.
        $filtered = wp_strip_all_tags($filtered, true);
    } else {
        $filtered = trim(preg_replace('/[\r\n\t ]+/', ' ', $filtered));
    }

    $found = false;
    while (preg_match('/%[a-f0-9]{2}/i', $filtered, $match)) {
        $filtered = str_replace($match[0], '', $filtered);
        $found = true;
    }

    if ($found) {
        // Strip out the whitespace that may now exist after removing the octets.
        $filtered = trim(preg_replace('/ +/', ' ', $filtered));
    }

    return $filtered;
}
function wp_get_attachment_image_src($attach_id, $size = 'thumbnail', $args = array()) {
    $wpdb = rev_db_class::rev_db_instance();
    $tablename = $wpdb->prefix . GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES;
    $filename = $wpdb->get_var("SELECT file_name FROM {$tablename} WHERE ID={$attach_id}");
    if (!empty($filename)) {
        $filerealname = substr($filename, 0, strrpos($filename, '.'));
        $fileext = substr($filename, strrpos($filename, '.'), strlen($filename) - strlen($filerealname));
        $newfilename = $filerealname;
                
        if (gettype($size) == 'string') {
            switch ($size) {
                case "thumbnail":
                    $px = GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL;
                    $newfilename .= "-{$px}x{$px}";
                    break;
                case "thumb":
                    $px = GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL;
                    $newfilename .= "-{$px}x{$px}";
                    break;
                case "medium":
                    $px = GlobalsRevSlider::IMAGE_SIZE_MEDIUM;
                    $px_H = GlobalsRevSlider::IMAGE_SIZE_MEDIUM_H;
                    $newfilename .= "-{$px}x{$px_H}";
                    break;
                case "large":
                    $px = GlobalsRevSlider::IMAGE_SIZE_LARGE;
                    $newfilename .= "-{$px}x{$px}";
                    break;
                default: break;
            }
            $newfilename .= $fileext;
        //    var_dump($newfilename);die();
            $imagesize = get_image_real_size($newfilename);
            return array(uploads_url($newfilename), $imagesize[0], $imagesize[1]);
        }
    }
    return false;
}

function wp_get_attachment_image_src_by_url($file_url, $size = 'thumbnail', $args = array()) {
    $wpdb = rev_db_class::rev_db_instance();
   // $tablename = $wpdb->prefix . GlobalsRevSlider::TABLE_ATTACHMENT_IMAGES;
     $filename = basename($file_url);
   
    $filepath = RevSliderFunctionsWP::getImageDirFromUrl($file_url);
    // var_dump($filepath);die();
   if (file_exists($filepath)) {
        $filerealname = substr($filename, 0, strrpos($filename, '.'));
        $fileext = substr($filename, strrpos($filename, '.'), strlen($filename) - strlen($filerealname));
        $newfilename = $filerealname;
                $no_ext = false;
        if (gettype($size) == 'string') {
            switch ($size) {
                case "thumbnail":
                    $px = GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL;
                    $newfilename .= "-{$px}x{$px}";
                    break;
                case "medium":
                    $px = GlobalsRevSlider::IMAGE_SIZE_MEDIUM;
                    $px_H = GlobalsRevSlider::IMAGE_SIZE_MEDIUM_H;
                    $newfilename .= "-{$px}x{$px_H}";
                    break;
                case "thumb":
                    $px = GlobalsRevSlider::IMAGE_SIZE_THUMBNAIL;
                    $newfilename .= "-{$px}x{$px}";
                    break;
                case "large":
                    $px = GlobalsRevSlider::IMAGE_SIZE_LARGE;
                    $newfilename .= "-{$px}x{$px}";
                    break;
                default: 
                    $newfilename = $file_url;
                    $no_ext = true;
                    break;
            }
            
            if($no_ext == false){
                $newfilename .= $fileext;
                
                $newfilename = uploads_real_url($newfilename);
            }
            
            $imagesize = get_image_real_size($newfilename);
            
            return $newfilename ;
        }
     }
    return false;
}

function get_image_real_size($image) {
    $filepath = uploads_url() .'/'. $image;
    if (file_exists($filepath))
        return list($width, $height) = getimagesize($filepath);
    return false;
}
function wp_is_stream( $path ) {
    $wrappers = stream_get_wrappers();
    $wrappers_re = '(' . join('|', $wrappers) . ')';
 
    return preg_match( "!^$wrappers_re://!", $path ) === 1;
}
function wp_mkdir_p( $target ) {
    $wrapper = null;
 
    // Strip the protocol.
    if ( wp_is_stream( $target ) ) {
        list( $wrapper, $target ) = explode( '://', $target, 2 );
    }
 
    // From php.net/mkdir user contributed notes.
    $target = str_replace( '//', '/', $target );
 
    // Put the wrapper back on the target.
    if ( $wrapper !== null ) {
        $target = $wrapper . '://' . $target;
    }
 
    /*
     * Safe mode fails with a trailing slash under certain PHP versions.
     * Use rtrim() instead of untrailingslashit to avoid formatting.php dependency.
     */
    $target = rtrim($target, '/');
    if ( empty($target) )
        $target = '/';
 
    if ( file_exists( $target ) )
        return @is_dir( $target );
 
    // We need to find the permissions of the parent folder that exists and inherit that.
    $target_parent = dirname( $target );
    while ( '.' != $target_parent && ! is_dir( $target_parent ) ) {
        $target_parent = dirname( $target_parent );
    }
 
    // Get the permission bits.
    if ( $stat = @stat( $target_parent ) ) {
        $dir_perms = $stat['mode'] & 0007777;
    } else {
        $dir_perms = 0777;
    }
 
    if ( @mkdir( $target, $dir_perms, true ) ) {
 
        /*
         * If a umask is set that modifies $dir_perms, we'll have to re-set
         * the $dir_perms correctly with chmod()
         */
        if ( $dir_perms != ( $dir_perms & ~umask() ) ) {
            $folder_parts = explode( '/', substr( $target, strlen( $target_parent ) + 1 ) );
            for ( $i = 1, $c = count( $folder_parts ); $i <= $c; $i++ ) {
                @chmod( $target_parent . '/' . implode( '/', array_slice( $folder_parts, 0, $i ) ), $dir_perms );
            }
        }
 
        return true;
    }
 
    return false;
}
function wp_remote_post($url, $args) {
    $args['method'] = 'POST';
    $RevLoader = new RevLoader();
    return $RevLoader->getHttpCurl($url, $args);
}
 function wp_remote_get($url, $args = array())
{  
    $RevLoader = new RevLoader();
    return $RevLoader->getHttpCurl($url, $args);
}
function get_bloginfo($parms) {
    if ($parms == 'version') {
        return '';
    }elseif($parms =='url'){
        return get_module_url();
    } else {
        return true;
    }
}
function wp_is_mobile() {
    if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
        $is_mobile = false;
    } elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false // many mobile devices (all iPhone, iPad, etc.)
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
            $is_mobile = true;
    } else {
        $is_mobile = false;
    }
 
    return $is_mobile;
}
function wp_remote_fopen($Url)
{ 
    $UserAgentList = array();
    $UserAgentList[] = "Mozilla/4.0 (compatible; MSIE 6.0; X11; Linux i686; en) Opera 8.01";
    $UserAgentList[] = "Mozilla/5.0 (compatible; Konqueror/3.3; Linux) (KHTML, like Gecko)";
    $UserAgentList[] = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/15.0.874.121 Safari/535.2";
    $UserAgentList[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9.2.25) Gecko/20111212 Firefox/3.6.25";
    $UserAgentList[] = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.52.7 (KHTML, like Gecko) Version/5.1.2 Safari/534.52.7";
    $UserAgentList[] = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; Win64; x64; SV1; .NET CLR 2.0.50727)";
    $UserAgentList[] = "Mozilla/5.0 (Windows NT 6.1; rv:8.0.1) Gecko/20100101 Firefox/8.0.1";
    $UserAgentList[] = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7";

    $hcurl = curl_init();

    curl_setopt($hcurl, CURLOPT_URL, $Url);
    curl_setopt($hcurl, CURLOPT_USERAGENT, $UserAgentList[array_rand($UserAgentList)]);
    curl_setopt($hcurl, CURLOPT_TIMEOUT, 120);
    curl_setopt($hcurl, CURLOPT_CONNECTTIMEOUT, 1);
    curl_setopt($hcurl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($hcurl, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($hcurl);
    curl_close($hcurl);

    return $result;
}
function wp_remote_retrieve_response_code( $response ) {
    
	if (! isset($response['info']['http_code']) || ! is_array($response['info']))
		return '';

	return $response['info']['http_code'];
}
function wp_remote_retrieve_body( $response ) {
	if ( ! isset($response['body']) )
		return '';

	return $response['body'];
}
function rev_footer() { 
  //  var_dump(RevLoader::$admin_scripts_foot);die("okk");
    foreach(RevLoader::$admin_scripts_foot as $script){
                  echo "<script type='text/javascript' src='{$script}'></script>";
            }
}
function wp_localize_script($handle,$varName,$value,$toFooter = false){
    if($toFooter != true){
        RevSliderBase::$local_scripts[$varName] = $value;
    }else{
         RevSliderBase::$local_scripts_footer[$varName] = $value;
    }
    
}