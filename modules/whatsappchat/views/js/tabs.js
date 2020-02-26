/**
*
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
*  @author    idnovate
*  @copyright 2019 idnovate
*  @license   See above
*/

(function($){
    $.createTabs = function(){
        blockTab = '<div class="col-lg-2"><div class="list-group">';
        $.each($('#content').find('form [id^="fieldset"].panel'), function() {
            heading = $(this).find('.panel-heading');
            blockTab += '<a href="#'+$(this).attr('id')+'" class="list-group-item" data-toggle="tab">'+heading.html()+'</a>';
            $(this).addClass('tab-pane');
        });
        blockTab += '</div></div>';

        // Add content
        $('#content').find('form').before(blockTab).addClass('col-lg-10 tab-content');

        // Display first tab
        $('#content').find('.list-group a:first').tab('show').addClass('active');

        // Toggle panel
        $("#content").find(".list-group-item").on('click', function() {
            var el = $(this).parent().closest('.list-group').children('.active');
            if (el.hasClass('active')) {
                el.removeClass('active');
            }
            $(this).addClass('active');
        });
    };
})(jQuery);

$(window).load(function() {
    $.createTabs();
    var url = window.location.href;
    if (window.location.href.indexOf('with_features') !== -1) {
        $("#content").find(".list-group-item")[2].click();
    }
});
