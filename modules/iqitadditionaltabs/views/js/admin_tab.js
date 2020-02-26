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
 *  @license   Commercial license (You can not resell or redistribute this software)
 *
 */

$(document).ready(function () {

    var $iqitadditionaltabList = $('#iqitadditionaltab-list');


    //reorder
    $(function () {
        var $mySlides = $('#iqitadditionaltab-list');
        $mySlides.sortable({
            opacity: 0.6,
            cursor: "move",
            update: function () {
                var order = $(this).sortable("serialize") + "&action=UpdatePositionsProduct";
                $.post(iqitModulesAdditionalTabs.ajaxUrl, order);
            }
        });
        $mySlides.hover(function () {
                $(this).css("cursor", "move");
            },
            function () {
                $(this).css("cursor", "auto");
            });
    });


    //add tab
    $('#iqitadditionaltabs_add, #iqitadditionaltabs_edit').on('click', function () {

        var $inputFields = $('.js-iqitadditionaltabs-field');
        var fields = $('.js-iqitadditionaltabs-field').serialize();
        var idProduct = $(this).data('product');

        $.ajax({
            url: iqitModulesAdditionalTabs.ajaxUrl,
            type: 'POST',
            data: {
                ajax: true,
                action: 'addTabProduct',
                fields: fields,
                idProduct: idProduct,
            },
            success: function (data) {
                if (data.status) {

                    if (data.action == 'add'){
                        var $tmpl = $('#tmpl-iqitadditionaltab-list-item');
                        var tmplHtml = $tmpl.html();

                        tmplHtml = tmplHtml.replace(new RegExp('::tabId::', 'g'), data.tab.id);

                        $.each(iqitadditionaltabs_languages, function(k, v) {
                            tmplHtml = tmplHtml.replace(new RegExp('::tabTitle'+v.id_lang+'::', 'g'), data.tab.title[v.id_lang])
                        });

                        $iqitadditionaltabList.append(tmplHtml);
                    } else {
                        $.each(iqitadditionaltabs_languages, function(k, v) {
                            $('.translationsFields-iqitadditionaltabs_title_p_'+data.tab.id+'_'+v.id_lang+'').text(data.tab.title[v.id_lang]);
                        });
                    }

                    showSuccessMessage(data.message);
                    $('#iqitadditionaltabs_add').removeClass('hide');
                    $('#iqitadditionaltabs_edit').addClass('hide');
                    $('#iqitadditionaltabs_cancel').addClass('hide');

                    $inputFields.each(function() {
                         $( this ).val('');
                    });

                    $('.iqitadditionaltabs_description').each(function(  ) {
                         tinymce.get($( this ).find('textarea').first().attr('id')).setContent('');
                    });
                } else {
                    showErrorMessage(data.message);
                }
            },
        });
    });

    //cancel form
    $('#iqitadditionaltabs_cancel').on('click', function () {

        var $inputFields = $('.js-iqitadditionaltabs-field');

        $inputFields.each(function() {
            $( this ).val('');
        });

        $('.iqitadditionaltabs_description').each(function(  ) {
            tinymce.get($( this ).find('textarea').first().attr('id')).setContent('');
        });

        $('#iqitadditionaltabs_add').removeClass('hide');
        $('#iqitadditionaltabs_edit').addClass('hide');
        $('#iqitadditionaltabs_cancel').addClass('hide');

    });

    //remove tab
    $iqitadditionaltabList.on('click', '.js-iqitadditionaltabs-remove', function () {
        var tabId = $(this).data('tab');
        modalConfirmation.create(translate_javascripts['Are you sure to delete this?'], null, {
            onContinue: function () {

                $.ajax({
                    url: iqitModulesAdditionalTabs.ajaxUrl,
                    type: 'POST',
                    data: {
                        ajax: true,
                        action: 'deleteTabProduct',
                        id_iqitadditionaltab: tabId,
                    },
                    success: function (data) {
                        $('#iqitadditionaltabs_' + tabId).remove();
                    },
                });

            }
        }).show();
    });

    //edit tab
    $iqitadditionaltabList.on('click', '.js-iqitadditionaltabs-edit', function () {

        var tabId = $(this).data('tab');

        $('#iqitadditionaltabs_add').addClass('hide');
        $('#iqitadditionaltabs_edit').removeClass('hide');
        $('#iqitadditionaltabs_cancel').removeClass('hide');

        $('#iqitadditionaltabs_id_iqitadditionaltab').val(tabId);

        $.ajax({
            url: iqitModulesAdditionalTabs.ajaxUrl,
            data: {
                ajax: true,
                action: 'getTabProduct',
                id_iqitadditionaltab: tabId,
            },
            success: function (data) {
                if (data.tab.active){
                    $('#iqitadditionaltabs_active').prop( "checked", true );
                } else {
                    $('#iqitadditionaltabs_active').prop( "checked", false );
                }

                $.each( data.tab.title, function( i, val ) {
                    $('#iqitadditionaltabs_title_' + i).val(val);
                });

                $.each( data.tab.description, function( i, val ) {
                    var $textarea =  $('#iqitadditionaltabs_description_' + i);
                    if ($textarea.length){
                        $textarea.val(val);
                        tinymce.get('iqitadditionaltabs_description_' + i).setContent(val);
                    }
                });
            },
        });
    });

});