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

if (!class_exists('SdsRevHooksClass')) {

    class SdsRevHooksClass
    {

        public function addNewHook($new_font)
        {
            if (!@RevsliderPrestashop::getIsset($new_font['hookname'])) {
                return __('Wrong parameter received', REVSLIDER_TEXTDOMAIN);
            }

            $fonts = unserialize(RevLoader::getval('sds_rev_hooks'));

            if (!empty($fonts)) {
                foreach ($fonts as $font) {
                    if ($font['hookname'] == $new_font['hookname']) {
                        return __('Hook Already exist, choose a different Hook', REVSLIDER_TEXTDOMAIN);
                    }
                }
            }

            $new = array('hookname' => $new_font['hookname']);

            $fonts[] = $new;
            $do = RevLoader::setval('sds_rev_hooks', $fonts);
            //start register hook
            $mod_obj = Module::getInstanceByName('revsliderprestashop');
            $mod_obj->registerHook($new_font['hookname']);
            //End register hook
            if ($do) {
                return true;
            }
        }

        public function editHookByHookname($edit_font)
        {
            if (!@RevsliderPrestashop::getIsset($edit_font['hookname'])) {
                return __('Wrong Hook received', REVSLIDER_TEXTDOMAIN);
            }

            $fonts = $this->getAllHooks();

            if (!empty($fonts)) {
                foreach ($fonts as $key => $font) {
                    if ($font['hookname'] == $edit_font['hookname']) {
                        $fonts[$key]['hookname'] = $edit_font['hookname'];
                        $do = RevLoader::setval('sds_rev_hooks', $fonts);
                        return true;
                    }
                }
            }

            return false;
        }

        public function removeHookByHookname($handle)
        {
            $fonts = $this->getAllHooks();

            if (!empty($fonts)) {
                foreach ($fonts as $key => $font) {
                    if ($font['hookname'] == $handle) {
                        unset($fonts[$key]);
                        //start unregister hook
                        $mod_obj = Module::getInstanceByName('revsliderprestashop');
                        $id_hook = Hook::getIdByName($handle);
                        $mod_obj->unregisterHook($id_hook);
                        //End unregister hook
                        $do = RevLoader::setval('sds_rev_hooks', $fonts);
                        return true;
                    }
                }
            }

            return __('Hook not found! Wrong Hook given.', REVSLIDER_TEXTDOMAIN);
        }

        public function getAllHooks()
        {
            $fonts = unserialize(RevLoader::getval('sds_rev_hooks'));
            return $fonts;
        }

        public function getAllHooksHandle()
        {
            $fonts = array();
            $font = unserialize(RevLoader::getval('sds_rev_hooks'));
            if (!empty($font)) {
                foreach ($font as $f) {
                    $fonts[] = $f['hookname'];
                }
            }
            return $fonts;
        }

        public static function propagateDefaultHooks()
        {
            $default = array(
            );
            $fonts = unserialize(RevLoader::getval('sds_rev_hooks'));
            if (!empty($fonts)) {
                foreach ($default as $d_key => $d_font) {
                    $found = false;
                    foreach ($fonts as $font) {
                        if ($font['hookname'] == $d_font['hookname']) {
                            $found = true;
                            break;
                        }
                    }
                    if ($found == false) {
                        $fonts[] = $default[$d_key];
                    }
                }
                RevLoader::setval('sds_rev_hooks', $fonts);
            } else {
                RevLoader::setval('sds_rev_hooks', $default);
            }
        }
    }

}
