<?php
/**
 * 2017 IQIT-COMMERCE.COM
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software.)
 *
 */

include _PS_MODULE_DIR_ . '/iqitsociallogin/vendor/autoload.php';

use PrestaShop\PrestaShop\Adapter\ServiceLocator;
use Hybridauth\Hybridauth;



class IqitSocialLoginAuthenticateModuleFrontController extends ModuleFrontController
{
    public $page;

    public function initContent()
    {
        parent::initContent();

        $provider = Tools::getValue('provider');
        $page = Tools::getValue('page');
        $callbackUrl = $this->context->link->getModuleLink('iqitsociallogin', 'authenticate', array('provider' => $provider, 'page' => $page),  true);
        $noError = true;
        $popup = Configuration::get($this->module->cfgName . 'type');

        $facebookKey = Configuration::get($this->module->cfgName . 'facebook_key');
        $facebookSecret = Configuration::get($this->module->cfgName . 'facebook_secret');

        $googleKey = Configuration::get($this->module->cfgName . 'google_key');
        $googleSecret = Configuration::get($this->module->cfgName . 'google_secret');

        $twitterKey = Configuration::get($this->module->cfgName . 'twitter_key');
        $twitterSecret = Configuration::get($this->module->cfgName . 'twitter_secret');

        $instagramKey = Configuration::get($this->module->cfgName . 'instagram_key');
        $instagramSecret = Configuration::get($this->module->cfgName . 'instagram_secret');

        $config = [
            'callback' => $callbackUrl,

            'providers' => [
                'Google' => [
                    'enabled' => true,
                    'keys'    => [ 'id' => $googleKey, 'secret' => $googleSecret ],
                ],
                'Facebook' => [
                    'enabled' => true,
                    'keys'    => [ 'id' => $facebookKey, 'secret' => $facebookSecret],
                    'scope'    => 'email'
                ],
                'Twitter' => [
                    'enabled' => true,
                    'keys'    => [ 'key' => $twitterKey, 'secret' => $twitterSecret ],
                    'authorize' => true
                ],
                'Instagram' => [
                    'enabled' => true,
                    'keys'    => [ 'id' => $instagramKey, 'secret' => $instagramSecret ],
                ],
            ],
        ];

        try {

            $hybridauth = new Hybridauth( $config );

            switch ($provider) {
                case 'facebook':
                    $adapter = $hybridauth->authenticate( 'Facebook' );
                    break;
                case 'twitter':
                    $adapter = $hybridauth->authenticate( 'Twitter' );
                    break;
                case 'google':
                    $adapter = $hybridauth->authenticate( 'Google' );
                    break;
                case 'instagram':
                    $adapter = $hybridauth->authenticate( 'Instagram' );
                    break;
            }

            $userProfile = $adapter->getUserProfile();

            if (Customer::customerExists($userProfile->email)) {
                $noError = $this->authenticateCustomer($userProfile->email);
            } else{

                $firstName = $userProfile->firstName;
                $lastName = $userProfile->lastName;


                switch ($provider) {
                    case 'twitter':
                        if ($lastName  == ''){
                            $lastName = $userProfile->firstName;
                        }
                        break;
                    case 'instagram':
                        if ($lastName  == ''){
                            $lastName = $userProfile->displayName;
                        }
                        if ($firstName == ''){
                            $firstName = $userProfile->displayName;
                        }
                        break;
                }


                $noError = $this->createCustomer($userProfile->email, $firstName, $lastName);
                $noError = $this->authenticateCustomer($userProfile->email);
            }

            $adapter->disconnect();

            if (!$popup){
                if ($noError){
                    if ($page == 'checkout'){
                        Tools::redirect($this->context->link->getPageLink('order'));
                    } else{
                        Tools::redirect($this->context->link->getPageLink('my-account'));
                    }
                }
            }

            $this->context->smarty->assign(array(
                'popup' => $popup,
            ));
        }
        catch (\Exception $e) {
            $this->context->smarty->assign(array(
                'message' => $e->getMessage(),
            ));
        }

        $this->setTemplate('module:iqitsociallogin/views/templates/front/info.tpl');
    }


    public function createCustomer($email, $firstName, $lastName) {

        $customer = new Customer();
        $customer->active = 1;
        $customer->firstname = $firstName;
        $customer->lastname = $lastName;
        $customer->email = $email;
        $customer->optin = true;



        $password = Tools::passwdGen(8, 'RANDOM');
        $crypto = ServiceLocator::get('\\PrestaShop\\PrestaShop\\Core\\Crypto\\Hashing');
        $customer->passwd = $crypto->hash($password);

        if ($customer->add()){
            return true;
        } else{
            return false;
        }

    }

    public function authenticateCustomer($email) {

        Hook::exec('actionAuthenticationBefore');

        $customer = new Customer();
        $authentication = $customer->getByEmail($email);

        if (!$authentication){
            return false;
        }

        if (!$customer->active){
           return false;
        }

        $this->context->updateCustomer($customer);

        Hook::exec('actionAuthentication', ['customer' => $this->context->customer]);
        // Login information have changed, so we check if the cart rules still apply
        CartRule::autoRemoveFromCart($this->context);
        CartRule::autoAddToCart($this->context);

        return true;
    }
}
