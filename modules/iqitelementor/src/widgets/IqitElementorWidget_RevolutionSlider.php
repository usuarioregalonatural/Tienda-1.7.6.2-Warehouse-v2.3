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

/**
 * Class ElementorWidget_RevolutionSlider
 */
class IqitElementorWidget_RevolutionSlider
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

    public $status = 1;
    public $revModule;
    public $editMode = false;

    public function __construct()
    {
        if (!Module::isEnabled('revsliderprestashop')) {
            $this->status = 0;
        }

        $this->name = IqitElementorWpHelper::__('Revolution Slider', 'elementor');
        $this->id_base = 'RevolutionSlider';
        $this->icon = 'carousel';
        $this->context = Context::getContext();

        if (isset($this->context->controller->controller_name) && $this->context->controller->controller_name == 'IqitElementorEditor') {
            $this->editMode = true;
        }
    }

    public function getForm()
    {
        $sliders = [];
        $sliders [0] = IqitElementorWpHelper::__('-- None --', 'elementor');

        if ($this->editMode) {
            $this->revModule = Module::getInstanceByName('revsliderprestashop');

            if (Validate::isLoadedObject($this->revModule)) {
                $slidersData = $this->getSliders();
                if ($slidersData) {
                    foreach ($slidersData as $slide) {
                        $sliders[$slide['id']] = $slide['title'] . '(' . $slide['alias'] . ')';
                    }
                }
            }
        }

        return [
            'section_pswidget_options' => [
                'label' => IqitElementorWpHelper::__('Widget settings', 'elementor'),
                'type' => 'section',
            ],
            'slider' => [
                'label' => IqitElementorWpHelper::__('Slider', 'elementor'),
                'type' => 'select',
                'default' => 0,
                'section' => 'section_pswidget_options',
                'options' => $sliders,
            ],
        ];
    }

    public function getSliders()
    {
        $sql = 'SELECT *
				FROM  `' . _DB_PREFIX_ . 'revslider_sliders`  
				';
        if (!$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql)) {
            return false;
        }

        return $result;
    }

    public function parseOptions($optionsSource, $preview = false)
    {

        $slider = '';
        $sliderId = (int)$optionsSource['slider'];

        $widgetPreview = false;

        if (isset($this->context->controller->page_name) && $this->context->controller->page_name == 'module-iqitelementor-Widget') {
            $widgetPreview = true;
        }

        if ($sliderId != 0) {
            $this->revModule = Module::getInstanceByName('revsliderprestashop');

            if (Validate::isLoadedObject($this->revModule)) {
                $this->revModule->_prehook();
                $slider = $this->revModule->generateSliderById($sliderId);
            }
        }

        return [
            'slider' => $slider,
            'widgetPreview' => $widgetPreview,
        ];
    }

}
