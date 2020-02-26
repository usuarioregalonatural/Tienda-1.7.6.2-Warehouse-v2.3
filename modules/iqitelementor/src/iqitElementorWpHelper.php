<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

if (!defined('ELEMENTOR_ABSPATH')) {
    define('ELEMENTOR_ABSPATH', _PS_MODULE_DIR_ . 'iqitelementor');
}

define( 'ELEMENTOR_VERSION', '0.9.3' );
define( 'ELEMENTOR_PATH', _PS_MODULE_DIR_ . 'iqitelementor' . '/');
define( 'ELEMENTOR_ASSETS_URL',  _MODULE_DIR_.'iqitelementor/views/');


use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;

class IqitElementorWpHelper {

    public static function _e($text, $domain = 'default' ){
        echo $text;
    }

    public static function __($text, $domain = 'default' ){
        return $text;
    }

    public static function _x($text, $context, $domain = 'default'){
       return $text;
    }

    public static function esc_attr_e($text, $domain = 'default'){
        return $text;
    }

    public static function getIqitElementorWidgets(){
        $widgets = IqitElementor::$WIDGETS;
        foreach ($widgets as $key => $widget){
            $widget = 'IqitElementorWidget_'.$widget;
            $instance = new $widget();
            if (!$instance->status){
                unset($widgets[$key]);
            }
        }
        return $widgets ;
    }

    public static function getIqitElementorWidgetInstance($name){
        $widget = new $name();
        return $widget;
    }

    public static function getProduct($id){
        $productSource = self::getProductsByIds($id);



        if (isset($productSource[0])){
            $product['name'] = $productSource[0]['name'];
            $product['price'] = $productSource[0]['price'];
            $product['url'] = $productSource[0]['url'];
            $product['cover'] = $productSource[0]['cover']['bySize']['small_default'];
            return $product;
        }
    }

    public static function renderIqitElementorWidget($name, $options){

        $module = Module::getInstanceByName('iqitelementor');
        return  $module->renderIqitElementorWidget($name, $options);
    }

    public static function renderIqitElementorWidgetPreview($name, $options){

        $module = Module::getInstanceByName('iqitelementor');
        $data = array();

        $widgetLink = Context::getContext()->link->getModuleLink('iqitelementor', 'Widget', array(
            'iqit_fronteditor_token' =>  $module->getFrontEditorToken(),
            'id_employee' => is_object(Context::getContext()->employee) ? (int) Context::getContext()->employee->id :
                Tools::getValue('id_employee'),
            'ajax'  => 1,
            'action' => 'widgetPreview',
            'widgetName' =>  $name,
        ), true);


        $data['widgetOptions'] = $options;

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ),
        );

        $context  = stream_context_create($options);
        $widgetPreview = file_get_contents($widgetLink , false, $context);


        //$widgetPreview = self::file_get_contents_curl($widgetLink);

        return   $widgetPreview;
    }

    public static function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public static function esc_attr($text){
        return Tools::safeOutput($text);
    }

    public static function wp_parse_args( $args, $defaults = '' ) {
        if ( is_object( $args ) )
            $r = get_object_vars( $args );
        elseif ( is_array( $args ) )
            $r =& $args;
        else
            IqitElementorWpHelper::wp_parse_str( $args, $r );

        if ( is_array( $defaults ) )
            return array_merge( $defaults, $r );
        return $r;
    }

    public static function wp_parse_str( $string, &$array ) {
        parse_str( $string, $array );
        if ( get_magic_quotes_gpc() )
            $array = IqitElementorWpHelper::stripslashes_deep( $array );
        return $array;
    }

    public static function stripslashes_deep( $value ) {
        return IqitElementorWpHelper::map_deep( $value, 'stripslashes_from_strings_only' );
    }

    public static function map_deep( $value, $callback ) {
        if ( is_array( $value ) ) {
            foreach ( $value as $index => $item ) {
                $value[ $index ] = IqitElementorWpHelper::map_deep( $item, $callback );
            }
        } elseif ( is_object( $value ) ) {
            $object_vars = get_object_vars( $value );
            foreach ( $object_vars as $property_name => $property_value ) {
                $value->$property_name = IqitElementorWpHelper::map_deep( $property_value, $callback );
            }
        } else {
            $value = call_user_func( $callback, $value );
        }

        return $value;
    }

    public static function esc_url( $url, $protocols = null, $_context = 'display' ) {
        if ( '' == $url )
            return $url;
        $url = str_replace( ' ', '%20', $url );
        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\[\]\\x80-\\xff]|i', '', $url);
        if ( '' === $url ) {
            return $url;
        }
        $url = str_replace(';//', '://', $url);
        if ( strpos($url, ':') === false && ! in_array( $url[0], array( '/', '#', '?' ) ) &&
            ! preg_match('/^[a-z0-9-]+?\.php/i', $url) )
            $url = 'http://' . $url;
        return $url;
    }

    public static function wp_send_json_success( $data = null) {
        @header( 'Content-Type: application/json; charset=utf-8');
        $response = array( 'success' => true );
        if ( isset( $data ) )
            $response['data'] = $data;
        die (json_encode( $response ));
    }

    public static function absint( $maybeint ) {
        return abs( intval( $maybeint ) );
    }

    public static function is_rtl() {

        if (Context::getContext()->language->is_rtl) {
            return true;
        }
        return false;
    }

    public static function _doing_it_wrong( $function, $message, $version ) {
        die($function . ' - ' . $message . ' - ' .$version);
    }

    public static function triggerWpError($message) {
        die($message);
    }

    public static function get_option($option, $default = false)
    {
        $value = Configuration::get('iqitelementor_' . $option);

        if ($value == '') {
            return $default;
        }
        else {
            $value;
        }
    }

    public static function update_option( $option, $value, $autoload = null )
    {
        Configuration::updateValue('iqitelementor_'  . $option, $value);
    }

    public static function getImage( $image = '' )
    {

    	if (Validate::isAbsoluteUrl($image)) {
    		return $image;
    	} else{
        	$http = Tools::getCurrentUrlProtocolPrefix();
        	return $http.Tools::getMediaServer($image).$image;
    	}
    }

    public static function getProductsByIds($ids)
    {
        if (!is_array($ids)){
            return;
        }
        if (empty($ids)){
            return;
        }

        $context = Context::getContext();

        $products = self::getProductsInfoByIds($ids, $context->language->id, $context );

        $presenterFactory = new ProductPresenterFactory($context );
        $presentationSettings = $presenterFactory->getPresentationSettings();


        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $context ->link
            ),
            $context ->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $context ->getTranslator()
        );


        if (is_array($products)) {
            foreach ($products as &$product) {
                $product = $presenter->present(
                    $presentationSettings,
                    Product::getProductProperties($context ->language->id, $product, $context ),
                    $context->language
                );
            }
            unset($product);
        }

        return $products;
    }

    public static function getProductsInfoByIds($ids, $id_lang,$context, $active = true )
    {
        $product_ids = join(',', $ids);

        $id_shop = (int) $context->shop->id;

        $sql = 'SELECT p.*, product_shop.*, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity, pl.`description`, pl.`description_short`, pl.`link_rewrite`,
					pl.`meta_description`, pl.`meta_keywords`, pl.`meta_title`, pl.`name`, pl.`available_now`, pl.`available_later`,
					image_shop.`id_image` id_image, il.`legend`, m.`name` as manufacturer_name, cl.`name` AS category_default, IFNULL(product_attribute_shop.id_product_attribute, 0) id_product_attribute,
					DATEDIFF(
						p.`date_add`,
						DATE_SUB(
							"'.date('Y-m-d').' 00:00:00",
							INTERVAL '.(Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20).' DAY
						)
					) > 0 AS new
				FROM  `'._DB_PREFIX_.'product` p 
				'.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_attribute_shop` product_attribute_shop
					ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND product_attribute_shop.id_shop='.(int)$id_shop.')
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (
					p.`id_product` = pl.`id_product`
					AND pl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('pl').'
				)
				LEFT JOIN `'._DB_PREFIX_.'category_lang` cl ON (
					product_shop.`id_category_default` = cl.`id_category`
					AND cl.`id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').'
				)
				LEFT JOIN `'._DB_PREFIX_.'image_shop` image_shop
					ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop='.(int)$id_shop.')
				LEFT JOIN `'._DB_PREFIX_.'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.(int)$id_lang.')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (p.`id_manufacturer`= m.`id_manufacturer`)
				'.Product::sqlStock('p', 0).'
				WHERE p.id_product IN ('.$product_ids.')'.
            ($active ? ' AND product_shop.`active` = 1 AND product_shop.`visibility` != \'none\'' : '').'
				ORDER BY FIELD(product_shop.id_product, '.$product_ids.')
				';
        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return false;
        }
        foreach ($result as &$row) {
            $row['id_product_attribute'] = Product::getDefaultAttribute((int)$row['id_product']);
        }
        return Product::getProductsProperties($id_lang, $result);
    }

}

