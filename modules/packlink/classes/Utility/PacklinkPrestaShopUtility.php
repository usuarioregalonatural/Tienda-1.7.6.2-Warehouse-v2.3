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

namespace Packlink\PrestaShop\Classes\Utility;

/**
 * Class PacklinkPrestaShopUtility
 *
 * @package Packlink\PrestaShop\Classes\Utility
 */
class PacklinkPrestaShopUtility
{
    /**
     * Die with 400 status in header.
     *
     * @param array $data
     */
    public static function die400(array $data = array())
    {
        header('HTTP/1.1 400 Bad Request');

        self::dieJson($data);
    }

    /**
     * Die with 404 status in header.
     *
     * @param array $data
     */
    public static function die404(array $data = array())
    {
        header('HTTP/1.1 404 Not Found');

        self::dieJson($data);
    }

    /**
     * Die with 404 status in header.
     *
     * @param array $data
     */
    public static function die500(array $data = array())
    {
        header('HTTP/1.1 500 Internal Server Error');

        self::dieJson($data);
    }

    /**
     * Sets response header content type to json, echos supplied $data as json and terminates the process.
     *
     * @param array $data Array to be encoded to json response.
     */
    public static function dieJson(array $data = array())
    {
        header('Content-Type: application/json');

        die(json_encode($data));
    }

    /**
     * Sets response header content plaintext, echos $plainText and terminates the process.
     *
     * @param string $plainText
     */
    public static function diePlain($plainText = '')
    {
        header('Content-Type: text/plain');

        die($plainText);
    }

    /**
     * Sets file specified by $filePath as response.
     *
     * @param string $filePath
     * @param string $outputFileName
     */
    public static function dieFile($filePath, $outputFileName = '')
    {
        $fileName = $outputFileName !== '' ? $outputFileName : basename($filePath);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $fileName);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);

        die(200);
    }

    /**
     * Sets string specified by $content as a file response.
     *
     * @param string $content
     * @param string $fileName
     */
    public static function dieFileFromString($content, $fileName)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $fileName);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . \Tools::strlen($content));

        echo $content;

        die(200);
    }

    /**
     * Returns file inline.
     *
     * @param string $filePath
     * @param string $outputFileName
     */
    public static function dieInline($filePath, $outputFileName = '')
    {
        $fileName = $outputFileName !== '' ? $outputFileName : basename($filePath);

        header('Content-Type: ' . mime_content_type($filePath));
        header('Content-Disposition: inline; filename=' . $fileName);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);

        die(200);
    }

    /**
     * Retrieves post input.
     *
     * @return array
     */
    public static function getPacklinkPostData()
    {
        return json_decode(\Tools::getValue('plPostData'), true);
    }
}
