<?php
/**
* NOTICE OF LICENSE
*
* This product is licensed for one customer to use on one installation (test stores and multishop included).
* Site developer has the right to modify this module to suit their needs, but can not redistribute the module in
* whole or in part. Any other use of this module constitues a violation of the user agreement.
*
* DISCLAIMER
*
* NO WARRANTIES OF DATA SAFETY OR MODULE SECURITY
* ARE EXPRESSED OR IMPLIED. USE THIS MODULE IN ACCORDANCE
* WITH YOUR MERCHANT AGREEMENT, KNOWING THAT VIOLATIONS OF
* PCI COMPLIANCY OR A DATA BREACH CAN COST THOUSANDS OF DOLLARS
* IN FINES AND DAMAGE A STORES REPUTATION. USE AT YOUR OWN RISK.
*
*  @author    idnovate.com <info@idnovate.com>
*  @copyright 2019 idnovate.com
*  @license   See above
*/

/**
 * Class allow to display tpl on the FO
 */
class Helper extends HelperCore
{
    public $tpl_vars = array();

    public function __construct()
    {
        $this->context = Context::getContext();
    }

    public function generateForm($fields_form, $module_name = null)
    {
        $html = '';
        $html .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data">';

        $tpl = $this->context->smarty->createTemplate(dirname(__FILE__).'/views/admin/_configure/input.tpl');
        $tpl->assign($this->tpl_vars);

        foreach ($fields_form as $fieldset_key => &$fieldset) {
            $html .= '<fieldset style="margin: 20px 0;">';
            if (isset($fieldset['form']['legend']['title'])) {
                $html .= '<legend>'.$fieldset['form']['legend']['title'].'</legend>';
            }

            if (isset($fieldset['form']['input'])) {
                foreach ($fieldset['form']['input'] as $key => &$params) {
                    if ($module_name) {
                        $tpl = $this->context->smarty->createTemplate(_PS_ROOT_DIR_.'/modules/'.$module_name.'/backward_compatibility/views/admin/_configure/input.tpl');
                    } else {
                        $tpl = $this->context->smarty->createTemplate(dirname(__FILE__).'/views/admin/_configure/input.tpl');
                    }
                    $tpl->assign(array(
                        'params' => $params,
                    ));
                    $tpl->assign($this->tpl_vars);
                    $html .= $tpl->fetch();
                }
            }

            if (isset($fieldset['form']['submit'])) {
                $tpl->assign(array(
                    'params' => $fieldset['form']['submit']
                ));

                $html .= $tpl->fetch();
            }

            $html .= '</fieldset>';
        }

        $html .= '</form>';
        return $html;
    }
}
