<?php
/**
 * 2007-2015 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2015 PrestaShop SA
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
use PrestaShop\PrestaShop\Adapter\BestSales\BestSalesProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\NewProducts\NewProductsProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\PricesDrop\PricesDropProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Manufacturer\ManufacturerProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider;
use PrestaShop\PrestaShop\Adapter\Image\ImageRetriever;
use PrestaShop\PrestaShop\Adapter\Product\PriceFormatter;
use PrestaShop\PrestaShop\Core\Product\ProductListingPresenter;
use PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext;
use PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery;
use PrestaShop\PrestaShop\Core\Product\Search\SortOrder;

/**
 * Class ElementorWidget_Brands
 */
class IqitElementorWidget_ProductsList
{
    /**
     * @var int
     */
    public $id_base;

    /**
     * @var string widget name
     */
    public $name;
    /**
     * @var string widget icon
     */
    public $icon;
    public $context;

    protected $spacer_size = '2';

    public $status = 1;
    public $editMode = false;

    public function __construct()
    {

        $this->name = IqitElementorWpHelper::__('Products list/sliders', 'elementor');
        $this->id_base = 'ProductsList';
        $this->icon = 'product-list';
        $this->context = Context::getContext();

        if (isset($this->context->controller->controller_name) && $this->context->controller->controller_name == 'IqitElementorEditor'){
            $this->editMode = true;
        }
    }

    public function getForm()
    {
        $slidesToShow = range(1, 6);
        $slidesToShow = array_combine($slidesToShow, $slidesToShow);

        $itemsPerColumn = range(1, 6);
        $itemsPerColumn = array_combine($itemsPerColumn, $itemsPerColumn);

        $categories = [];
        $brandsOptions = array();

        if ($this->editMode) {
            $categories = $this->generateCategoriesOption($this->customGetNestedCategories($this->context->shop->id,
                null, (int)$this->context->language->id, false));

            $brands = Manufacturer::getManufacturers();
            foreach ($brands as $brand) {
                $brandsOptions[$brand['id_manufacturer']] = $brand['name'];
            }
        }


        $productSourceOptions['ms'] = IqitElementorWpHelper::__('Manual selection', 'elementor');
        $productSourceOptions['bb'] = IqitElementorWpHelper::__('By brand', 'elementor');
        $productSourceOptions['np'] = IqitElementorWpHelper::__('New products', 'elementor');
        $productSourceOptions['pd'] = IqitElementorWpHelper::__('Price drops', 'elementor');
        $productSourceOptions['bs'] = IqitElementorWpHelper::__('Best sellers', 'elementor');
        $productSourceOptions = array_merge($productSourceOptions, $categories);

        return [
            'section_pswidget_options' => [
                'label' => IqitElementorWpHelper::__('Widget settings', 'elementor'),
                'type' => 'section',
            ],
            'product_source' => [
                'label' => IqitElementorWpHelper::__('Products source', 'elementor'),
                'type' => 'select',
                'default' => 'np',
                'label_block' => true,
                'section' => 'section_pswidget_options',
                'options' => $productSourceOptions,
            ],
            'products_ids' => [
                'label' => IqitElementorWpHelper::__('Search for products', 'elementor'),
                'placeholder' => IqitElementorWpHelper::__( 'Product name, id, ref', 'elementor' ),
                'type' => 'autocomplete_products',
                'label_block' => true,
                'condition' => [
                    'product_source' => ['ms'],
                ],
                'section' => 'section_pswidget_options',
            ],
            'brand_list' => [
                'label' => IqitElementorWpHelper::__('Select brand', 'elementor'),
                'type' => 'select',
                'default' => 0,
                'label_block' => true,
                'section' => 'section_pswidget_options',
                'condition' => [
                    'product_source' => ['bb'],
                ],
                'options' => $brandsOptions,
            ],
            'products_limit' => [
                'label' => IqitElementorWpHelper::__('Limit', 'elementor'),
                'type' => 'number',
                'default' => '10',
                'min' => '1',
                'condition' => [
                    'product_source!' => ['ms'],
                ],
                'section' => 'section_pswidget_options',
            ],
            'order_by' => [
                'label' => IqitElementorWpHelper::__('Order by', 'elementor'),
                'type' => 'select',
                'default' => 'position',
                'condition' => [
                    'product_source!' => ['np', 'bs', 'ms'],
                ],
                'section' => 'section_pswidget_options',
                'options' => [
                    'position' => IqitElementorWpHelper::__('Position', 'elementor'),
                    'name' => IqitElementorWpHelper::__('Name', 'elementor'),
                    'date_add' => IqitElementorWpHelper::__('Date add', 'elementor'),
                    'price' => IqitElementorWpHelper::__('Price', 'elementor'),
                    'random' => IqitElementorWpHelper::__('Random (works only with categories)', 'elementor'),
                ],
            ],
            'order_way' => [
                'label' => IqitElementorWpHelper::__('Order way', 'elementor'),
                'type' => 'select',
                'default' => 'asc',
                'section' => 'section_pswidget_options',
                'condition' => [
                    'product_source!' => ['np', 'bs', 'ms'],
                ],
                'options' => [
                    'asc' => IqitElementorWpHelper::__('Ascending', 'elementor'),
                    'desc' => IqitElementorWpHelper::__('Descending', 'elementor'),
                ],
            ],
            'view' => [
                'label' => IqitElementorWpHelper::__('View', 'elementor'),
                'type' => 'select',
                'default' => 'grid',
                'condition' => [
                    'view!' => 'default',
                ],
                'section' => 'section_pswidget_options',
                'options' => [
                    'carousel' => IqitElementorWpHelper::__('Carousel - big images', 'elementor'),
                    'grid' => IqitElementorWpHelper::__('Grid - big images', 'elementor'),
                    'carousel_s' => IqitElementorWpHelper::__('Carousel - small images', 'elementor'),
                    'grid_s' => IqitElementorWpHelper::__('Grid - small images', 'elementor'),
                    'list' => IqitElementorWpHelper::__('List', 'elementor')
                ],
            ],
            'slides_to_show' => [
                'responsive' => true,
                'label' => IqitElementorWpHelper::__('Show per line', 'elementor'),
                'type' => 'select',
                'default' => '6',
                'label_block' => true,
                'section' => 'section_pswidget_options',
                'options' => $slidesToShow,
                'condition' => [
                    'view' => ['carousel', 'grid', 'carousel_s', 'grid_s'],
                ],
            ],
            'items_per_column' => [
                'label' => IqitElementorWpHelper::__('Items per column', 'elementor'),
                'type' => 'select',
                'default' => '1',
                'condition' => [
                    'view' => [ 'carousel', 'carousel_s'],
                ],
                'section' => 'section_pswidget_options',
                'options' => $itemsPerColumn,
            ],
            'navigation' => [
                'label' => IqitElementorWpHelper::__('Navigation', 'elementor'),
                'type' => 'select',
                'default' => 'both',
                'condition' => [
                    'view' => [ 'carousel', 'carousel_s'],
                ],
                'section' => 'section_pswidget_options',
                'options' => [
                    'both' => IqitElementorWpHelper::__('Arrows and Dots', 'elementor'),
                    'arrows' => IqitElementorWpHelper::__('Arrows', 'elementor'),
                    'dots' => IqitElementorWpHelper::__('Dots', 'elementor'),
                    'none' => IqitElementorWpHelper::__('None', 'elementor'),
                ],
            ],
            'autoplay' => [
                'label' => IqitElementorWpHelper::__('Autoplay', 'elementor'),
                'type' => 'select',
                'default' => 'yes',
                'condition' => [
                    'view' => [ 'carousel', 'carousel_s'],
                ],
                'section' => 'section_pswidget_options',
                'options' => [
                    'yes' => IqitElementorWpHelper::__('Yes', 'elementor'),
                    'no' => IqitElementorWpHelper::__('No', 'elementor'),
                ],
            ],
            'infinite' =>  [
                'label' => \IqitElementorWpHelper::__( 'Infinite Loop', 'elementor' ),
                'type' => 'select',
                'default' => 'yes',
                'condition' => [
                    'view' => [ 'carousel', 'carousel_s'],
                ],
                'section' => 'section_pswidget_options',
                'options' => [
                    'yes' => \IqitElementorWpHelper::__( 'Yes', 'elementor' ),
                    'no' => \IqitElementorWpHelper::__( 'No', 'elementor' ),
                ],
            ],
            'section_style_navigation' => [
                'label' => IqitElementorWpHelper::__('Navigation', 'elementor'),
                'type' => 'section',
                'tab' => 'style',
            ],
            'arrows_position' => [
                'label' => IqitElementorWpHelper::__('Arrows position', 'elementor'),
                'type' => 'select',
                'default' => 'middle',
                'tab' => 'style',
                'condition' => [
                    'view' => [ 'carousel', 'carousel_s'],
                    'navigation' => [ 'both', 'arrows'],
                ],
                'section' => 'section_style_navigation',
                'options' => [
                    'middle' => IqitElementorWpHelper::__('Middle', 'elementor'),
                    'above' => IqitElementorWpHelper::__('Above', 'elementor'),
                ],
            ],
            'arrows_position_top' => [
                'label' => IqitElementorWpHelper::__('Position top', 'elementor'),
                'type' => 'number',
                'default' => '-20',
                'min' => '-100',
                'tab' => 'style',
                'condition' => [
                    'arrows_position' => ['above'],
                ],
                'section' => 'section_style_navigation',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'top: {{VALUE}}px;',
                ],
            ],
            'arrows_color' => [
                'label' => IqitElementorWpHelper::__('Arrows Color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_navigation',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'color: {{VALUE}};',
                ],
            ],
            'arrows_bg_color' => [
                'label' => IqitElementorWpHelper::__('Arrows background', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_navigation',
                'selectors' => [
                    '{{WRAPPER}} .slick-arrow' => 'background: {{VALUE}};',
                ],
            ],
            'dots_color' => [
                'label' => IqitElementorWpHelper::__('Dots color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_navigation',
                'condition' => [
                    'navigation' => [ 'dots', 'both' ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button:before' => 'color: {{VALUE}};',
                ],
            ],
            'section_style_product' => [
                'label' => IqitElementorWpHelper::__('Product', 'elementor'),
                'type' => 'section',
                'tab' => 'style',
            ],
            'product_bg_color' => [
                'label' => IqitElementorWpHelper::__('Product box bg color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature' => 'background: {{VALUE}};',
                ],
            ],
            'product_text_color' => [
                'label' => IqitElementorWpHelper::__('Product text color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature, .product-miniature a:link:not(.nav-link):not(.btn), .product-miniature a:visited:not(.nav-link):not(.btn)' => 'color: {{VALUE}};',
                ],
            ],
            'product_price_color' => [
                'label' => IqitElementorWpHelper::__('Product price color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature .product-price' => 'color: {{VALUE}};',
                ],
            ],
            'product_stars_color' => [
                'label' => IqitElementorWpHelper::__('Product stars color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature .iqit-review-star' => 'color: {{VALUE}};',
                ],
            ],
            'border' => [
                'group_type_control' => 'border',
                'name' => 'product_border',
                'label' => IqitElementorWpHelper::__('Border', 'elementor'),
                'tab' => 'style',
                'placeholder' => '1px',
                'default' => '1px',
                'section' => 'section_style_product',
                'selector' => '{{WRAPPER}} .product-miniature',
            ],
            'box-shadow' => [
                'group_type_control' => 'box-shadow',
                'name' => 'product_box_shadow',
                'label' => IqitElementorWpHelper::__('Box shadow', 'elementor'),
                'tab' => 'style',
                'placeholder' => '1px',
                'default' => '1px',
                'section' => 'section_style_product',
                'selector' => '{{WRAPPER}} .product-miniature',
            ],
            'section_style_product_h' => [
                'label' => IqitElementorWpHelper::__('Product hover', 'elementor'),
                'type' => 'section',
                'tab' => 'style',
            ],
            'product_bg_color_h' => [
                'label' => IqitElementorWpHelper::__('Product box bg color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product_h',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature:hover' => 'background: {{VALUE}};',
                ],
            ],
            'product_overlay_h' => [
                'label' => IqitElementorWpHelper::__('Product overlay', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product_h',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature-layout-3 .product-description' => 'background: {{VALUE}};',
                ],
            ],
            'product_text_color_h' => [
                'label' => IqitElementorWpHelper::__('Product text color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product_h',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature:hover, .product-miniature:hover a:link:not(.nav-link):not(.btn), .product-miniature:hover a:visited:not(.nav-link):not(.btn)' => 'color: {{VALUE}};',
                ],
            ],
            'product_price_color_h' => [
                'label' => IqitElementorWpHelper::__('Product price color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product_h',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature:hover .product-price' => 'color: {{VALUE}};',
                ],
            ],
            'product_stars_color_h' => [
                'label' => IqitElementorWpHelper::__('Product stars color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product_h',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature:hover .iqit-review-star' => 'color: {{VALUE}};',
                ],
            ],
            'border_h' => [
                'label' => IqitElementorWpHelper::__('Border color', 'elementor'),
                'type' => 'color',
                'tab' => 'style',
                'section' => 'section_style_product_h',
                'selectors' => [
                    '{{WRAPPER}} .product-miniature:hover' => 'border-color: {{VALUE}};',
                ],
            ],
            'box-shadow_h' => [
                'group_type_control' => 'box-shadow',
                'name' => 'product_box_shadow_h',
                'label' => IqitElementorWpHelper::__('Box shadow', 'elementor'),
                'tab' => 'style',
                'placeholder' => '1px',
                'default' => '1px',
                'section' => 'section_style_product_h',
                'selector' => '{{WRAPPER}} .product-miniature:hover',
            ],

        ];
    }


    public function parseOptions($optionsSource, $preview = false)
    {
        $source = $optionsSource['product_source'];

        if ($source == 'ms') {
            $products = $this->getProductsByIds($optionsSource['products_ids']);
        } else{
            $products = $this->getProducts($source, $optionsSource['products_limit'], $optionsSource['order_by'], $optionsSource['order_way'], $optionsSource['brand_list']);
        }

        $return = [
            'products' => $products,
            'view' => $optionsSource['view'],
        ];

        if ($optionsSource['view'] == 'grid' || $optionsSource['view'] == 'grid_s'){

            $optionsSource['slides_to_show'] = $this->calculateGrid($optionsSource['slides_to_show']);
            $optionsSource['slides_to_show_tablet'] = $this->calculateGrid($optionsSource['slides_to_show_tablet']);
            $optionsSource['slides_to_show_mobile'] = $this->calculateGrid($optionsSource['slides_to_show_mobile']);

            $return['slidesToShow'] = [
                'desktop' => $optionsSource['slides_to_show'],
                'tablet' => $optionsSource['slides_to_show_tablet'],
                'mobile' => $optionsSource['slides_to_show_mobile'],
            ];

        } else if ($optionsSource['view'] == 'carousel' || $optionsSource['view'] == 'carousel_s'){

            $return['arrows_position'] = $optionsSource['arrows_position'];

            $show_dots = ( in_array( $optionsSource['navigation'], [ 'dots', 'both' ] ) );
            $show_arrows = ( in_array( $optionsSource['navigation'], [ 'arrows', 'both' ] ) );

            $return['options'] = [
                'slidesToShow' => IqitElementorWpHelper::absint( $optionsSource['slides_to_show'] ),
                'slidesToScroll' => IqitElementorWpHelper::absint( $optionsSource['slides_to_show'] ),
                'slidesToShowTablet' => IqitElementorWpHelper::absint( $optionsSource['slides_to_show_tablet'] ),
                'slidesToShowMobile' => IqitElementorWpHelper::absint( $optionsSource['slides_to_show_mobile']),
                'itemsPerColumn' => IqitElementorWpHelper::absint( $optionsSource['items_per_column']),
                'autoplay' => ( 'yes' === $optionsSource['autoplay'] ),
                'infinite' => ( 'yes' === $optionsSource['infinite'] ),
                'arrows' => $show_arrows,
                'dots' => $show_dots,
            ];
        }

        if ($preview){
            $result = Hook::exec('actionBeforeElementorWidgetRender', array(), null, true);
            if (isset($result['iqitthemeeditor'])){
                $return['iqitTheme'] = $result['iqitthemeeditor'];
            }
        }

        return $return;
    }

    private function generateCategoriesOption($categories)
    {
        $return_categories = array();

        foreach ($categories as $key => $category) {
            if ($category['id_parent'] != 0) {
                $return_categories['xc_' . $key] = str_repeat('&nbsp;', $this->spacer_size * (int)$category['level_depth']) . $category['name'];
            }

            if (isset($category['children']) && !empty($category['children']))
                $return_categories = array_merge($return_categories, $this->generateCategoriesOption($category['children']));
        }

        return $return_categories;
    }

    public function customGetNestedCategories($shop_id, $root_category = null, $id_lang = false, $active = false, $groups = null, $use_shop_restriction = true, $sql_filter = '', $sql_sort = '', $sql_limit = '')
    {
        if (isset($root_category) && !Validate::isInt($root_category)) {
            die(Tools::displayError());
        }

        if (!Validate::isBool($active)) {
            die(Tools::displayError());
        }

        if (isset($groups) && Group::isFeatureActive() && !is_array($groups)) {
            $groups = (array)$groups;
        }

        $cache_id = 'Category::getNestedCategories_' . md5((int)$shop_id . (int)$root_category . (int)$id_lang . (int)$active . (int)$active
                . (isset($groups) && Group::isFeatureActive() ? implode('', $groups) : ''));

        if (!Cache::isStored($cache_id)) {
            $result = Db::getInstance()->executeS('
							SELECT c.*, cl.*
				FROM `' . _DB_PREFIX_ . 'category` c
				INNER JOIN `' . _DB_PREFIX_ . 'category_shop` category_shop ON (category_shop.`id_category` = c.`id_category` AND category_shop.`id_shop` = "' . (int)$shop_id . '")
				LEFT JOIN `' . _DB_PREFIX_ . 'category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.`id_shop` = "' . (int)$shop_id . '")
				WHERE 1 ' . $sql_filter . ' ' . ($id_lang ? 'AND cl.`id_lang` = ' . (int)$id_lang : '') . '
				' . ($active ? ' AND (c.`active` = 1 OR c.`is_root_category` = 1)' : '') . '
				' . (isset($groups) && Group::isFeatureActive() ? ' AND cg.`id_group` IN (' . implode(',', $groups) . ')' : '') . '
				' . (!$id_lang || (isset($groups) && Group::isFeatureActive()) ? ' GROUP BY c.`id_category`' : '') . '
				' . ($sql_sort != '' ? $sql_sort : ' ORDER BY c.`level_depth` ASC') . '
				' . ($sql_sort == '' && $use_shop_restriction ? ', category_shop.`position` ASC' : '') . '
				' . ($sql_limit != '' ? $sql_limit : '')
            );

            $categories = array();
            $buff = array();

            foreach ($result as $row) {
                $current = &$buff[$row['id_category']];
                $current = $row;

                if ($row['id_parent'] == 0) {
                    $categories[$row['id_category']] = &$current;
                } else {
                    $buff[$row['id_parent']]['children'][$row['id_category']] = &$current;
                }
            }

            Cache::store($cache_id, $categories);
        }

        return Cache::retrieve($cache_id);
    }

    public function getProducts($source, $limit, $orderBy, $orderWay, $brand = null)
    {

        $context = new ProductSearchContext($this->context);
        $query = new ProductSearchQuery();
        $nProducts = $limit;
        if ($nProducts < 0) {
            $nProducts = 12;
        }
        $query
            ->setResultsPerPage($nProducts)
            ->setPage(1);

        switch ($source) {
            case 'np':
                $searchProvider = new NewProductsProductSearchProvider(
                    $this->context->getTranslator()
                );
                $query
                    ->setQueryType('new-products')
                    ->setSortOrder(new SortOrder('product', 'date_add', 'desc'));
                break;
            case 'pd':
                $searchProvider = new PricesDropProductSearchProvider(
                    $this->context->getTranslator()
                );
                $query->setQueryType('prices-drop');
                if ($orderBy == 'random') {
                    $orderBy = 'position';
                } else {
                    $query->setSortOrder(new SortOrder('product', $orderBy, $orderWay));
                }
                break;
            case 'bb':
                $brand = new Manufacturer((int)$brand);
                $searchProvider = new ManufacturerProductSearchProvider(
                    $this->context->getTranslator(),
                    $brand
                );
                if ($orderBy == 'random') {
                    $orderBy = 'position';
                } else {
                    $query->setSortOrder(new SortOrder('product', $orderBy, $orderWay));
                }
                break;
            case 'bs':
                if (Configuration::get('PS_CATALOG_MODE')) {
                    return false;
                }
                $searchProvider = new BestSalesProductSearchProvider(
                    $this->context->getTranslator()
                );
                $query->setQueryType('best-sales');
                $query->setSortOrder(new SortOrder('product', 'name', 'asc'));
                break;
            default:
                $idCategory = (int)str_replace('xc_', '', $source);
                $category = new Category((int)$idCategory);
                $searchProvider = new CategoryProductSearchProvider(
                    $this->context->getTranslator(),
                    $category
                );
                if ($orderBy == 'random') {
                    $query->setSortOrder(SortOrder::random());
                } else {
                    $query->setSortOrder(new SortOrder('product', $orderBy, $orderWay));
                }

                $query->setQueryType('prices-drop');
        }

        $result = $searchProvider->runQuery(
            $context,
            $query
        );
        $assembler = new ProductAssembler($this->context);
        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->context->getTranslator()
        );
        $products_for_template = [];
        foreach ($result->getProducts() as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        }
        return $products_for_template;
    }

    public function getProductsByIds($ids)
    {
        if (!is_array($ids)){
            return;
        }
        if (empty($ids)){
            return;
        }

        $products = $this->getProductsInfoByIds($ids, $this->context->language->id);
        $presenterFactory = new ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();

        $presenter = new ProductListingPresenter(
            new ImageRetriever(
                $this->context->link
            ),
            $this->context->link,
            new PriceFormatter(),
            new ProductColorsRetriever(),
            $this->context->getTranslator()
        );

        if (is_array($products)) {
            foreach ($products as &$product) {
                $product = $presenter->present(
                    $presentationSettings,
                    Product::getProductProperties($this->context->language->id, $product, $this->context),
                    $this->context->language
                );
            }
            unset($product);
        }
        return $products;
    }


    public function getProductsInfoByIds($ids, $id_lang, $active = true)
    {
        $product_ids = join(',', $ids);
        $id_shop = (int) $this->context->shop->id;

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

    public function calculateGrid($nb) {
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
}
