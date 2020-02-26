<?php
/**
 * 2020 Packlink
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Apache License 2.0
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 * @author    Packlink <support@packlink.com>
 * @copyright 2020 Packlink Shipping S.L
 * @license   http://www.apache.org/licenses/LICENSE-2.0.txt  Apache License 2.0
 */

use Packlink\BusinessLogic\Http\DTO\ParcelInfo;
use Packlink\PrestaShop\Classes\Utility\PacklinkPrestaShopUtility;

/** @noinspection PhpIncludeInspection */
require_once rtrim(_PS_MODULE_DIR_, '/') . '/packlink/vendor/autoload.php';

/**
 * Class DefaultParcelController
 */
class DefaultParcelController extends PacklinkBaseController
{
    /**
     * Retrieves default parcel.
     */
    public function displayAjaxGetDefaultParcel()
    {
        $parcel = $this->getConfigService()->getDefaultParcel();

        if (!$parcel) {
            PacklinkPrestaShopUtility::dieJson();
        }

        PacklinkPrestaShopUtility::dieJson($parcel->toArray());
    }

    /**
     * Saves default parcel.
     */
    public function displayAjaxSubmitDefaultParcel()
    {
        $data = PacklinkPrestaShopUtility::getPacklinkPostData();
        $validationResult = $this->validate($data);
        if (!empty($validationResult)) {
            PacklinkPrestaShopUtility::die400($validationResult);
        }

        $data['default'] = true;

        $parcelInfo = ParcelInfo::fromArray($data);
        $this->getConfigService()->setDefaultParcel($parcelInfo);

        PacklinkPrestaShopUtility::dieJson($data);
    }

    /**
     * Validates default parcel data.
     *
     * @param array $data
     *
     * @return array
     */
    private function validate(array $data)
    {
        $result = array();
        $fields = array('weight', 'width', 'height', 'length');
        foreach ($fields as $field) {
            if (!empty($data[$field])) {
                /** @noinspection NotOptimalIfConditionsInspection */
                if (!Validate::isFloat($data[$field]) || $data[$field] <= 0) {
                    $result[$field] = $this->l('Field must be valid number.');
                }
            } else {
                $result[$field] = $this->l('Field is required.');
            }
        }

        return $result;
    }
}
