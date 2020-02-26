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

// @codingStandardsIgnoreStart
?>

<div class="title_line hook-title">
    <div class="view_title">Create Custom Hook</div>
    <a class="button-primary revblue float_right mtop_10 mleft_10" id="eg-hook-add" href="javascript:void(0);"><?php echo RevsliderPrestashop::$lang['Add_New_Hook']; ?></a>
</div>
<div id="eg-grid-custom-hook-wrapper">
    <?php
    $fonts = new SdsRevHooksClass();
    $custom_fonts = $fonts->getAllHooks();

    if (!empty($custom_fonts)) {
        foreach ($custom_fonts as $font) {
            $cur_font = $font['hookname'];
            $title = $font['hookname'];
            ?>
            <div class="postbox eg-postbox">
                <h3 class="box-closed">
                    <span style="font-weight:400"><?php echo RevsliderPrestashop::$lang['Hook_Name'];?></span>
                    <span style="text-transform:uppercase;"><?php echo $title;?></span>
                    <div class="fontpostbox-arrow"></div>
                </h3>

                <div class="inside" style="display:none;padding:0px !important;margin:0px !important;height:100%;position:relative;">
                    <div class="tp-googlefont-row">
                        <div class="eg-cus-row-l"><label><?php echo RevsliderPrestashop::$lang['Hook_Name'];?></label>
                            <input type="text" name="esg-hook-name[]" value="<?php echo @$font['hookname'];?>">
                        </div>

                        <p><?php echo RevsliderPrestashop::$lang['custom_hook_desc'];?>
                        <span><strong> {hook h="<?php echo $title;?>"}</strong></span></p>
                    </div>
                    <div class="tp-googlefont-save-wrap-settings">
                        <a class="button-primary revred eg-hook-delete" href="javascript:void(0);"><?php echo RevsliderPrestashop::$lang['Remove'];?></a>
                    </div>
                </div>
            </div>
        <?php }
    }

?>
</div>


<div id="hook-dialog-wrap" class="essential-dialog-wrap" title="<?php echo RevsliderPrestashop::$lang['Add_Hook']; ?>"  style="display: none; padding:20px !important;">
    <div class="tp-googlefont-cus-row-l"><label><?php echo RevsliderPrestashop::$lang['Hook_Name']; ?>:</label><input type="text" name="eg-hook-name" value="" />
    </div>
</div>


<script type="text/javascript">
    jQuery(function() {
        UniteAdminRev.inithooksetting();
      //  UniteAdminRev.initfontAccordion();
    });
</script>

<?php
// @codingStandardsIgnoreEnd
