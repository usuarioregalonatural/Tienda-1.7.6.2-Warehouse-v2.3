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

if (!defined('_PS_VERSION_')) {
    exit;
}
            
class AdminRevolutionsliderAjaxController extends ModuleAdminController
{

    protected $_ajax_results;

    protected $_ajax_stripslash;

    protected $_filter_whitespace;

    protected $lushslider_model;

    public function __construct()
    {
        $this->display_header = false;
        $this->display_footer = false;
        $this->content_only   = true;
        parent::__construct();
        $this->_ajax_results['error_on'] = 1; 
    }
    public function init()
    {

        // Process POST | GET
        $this->initProcess();
    }
    /**
     * 
     * @throws Exception
     */
    public function initProcess()
    {
                 ob_start(); 
               
                RevSliderAdmin::onAjaxAction();  
                $output = ob_get_contents();
                ob_end_clean();
             //   die($output);
                die($output); 
    } 
}
