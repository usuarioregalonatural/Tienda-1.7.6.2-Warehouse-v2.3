/**
 * 2017 IQIT-COMMERCE.COM
 *
 *  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
 *  @copyright 2017 IQIT-COMMERCE.COM
 *  @license   Commercial license (You can not resell or redistribute this software)
 *
 */

$(function() {
    var $mySlides = $("#tabs");
    $mySlides.sortable({
        opacity: 0.6,
        cursor: "move",
        update: function() {
            var order = $(this).sortable("serialize") + "&action=UpdatePositions";
            $.post(iqitModulesAdditionalTabs.ajaxUrl, order);
        }
    });
    $mySlides.hover(function() {
        $(this).css("cursor","move");
    },
    function() {
        $(this).css("cursor","auto");
    });
});