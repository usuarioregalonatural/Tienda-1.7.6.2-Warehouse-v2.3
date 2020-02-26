/**
* 2014-2017 IQIT-COMMERCE.COM
*
* NOTICE OF LICENSE
*
*  @author    IQIT-COMMERCE.COM <support@iqit-commerce.com>
*  @copyright 2007-2017 IQIT-COMMERCE.COM
*  @license   GNU General Public License version 2
*
* You can not resell or redistribute this software.
* 
*/

$(document).ready(function () {

    var $myHorizontalTabs = $('#tabs1');
    $myHorizontalTabs.sortable({
        opacity: 0.6,
        cursor: 'move',
        update: function() {
            var order = $(this).sortable('serialize') + "&action=updateHorizontalTabsPosition&ajax=true";
            $.post(iqitsearch_url, order);
        }
    });
    $myHorizontalTabs.hover(function() {
            $(this).css("cursor","move");
        },
        function() {
            $(this).css("cursor","auto");
        });

    var $myVerticalTabs = $('#tabs2');
    $myVerticalTabs.sortable({
        opacity: 0.6,
        cursor: "move",
        update: function() {
            var order = $(this).sortable("serialize") + "&action=updateVerticalTabsPosition&ajax=true";
            $.post(iqitsearch_url, order);
        }
    });
    $myVerticalTabs.hover(function() {
            $(this).css("cursor","move");
        },
        function() {
            $(this).css("cursor","auto");
        });


    $('.list-wrapper').detach().prependTo('#list-container');

    $('.icp-auto').iconpicker({
        iconBaseClass: 'icon',
        iconComponentBaseClass: 'icon',
        iconClassPrefix: 'fa-'
    });

    var p_auto_settings = {
        minChars: 1,
        cache: 0,
        source: function(term, response){
            $.getJSON(iqitsearch_url, { q: term, ajax: true, action: 'SearchProducts' }, function(data){ response(data); });
        },
        renderItem: function (item, search){
            return '<div class="autocomplete-suggestion" data-id="' + item.id + '" data-name="' + item.name + '">' +
                '<img src="' + item.image + '" style="width: 30px; max-height: 100%; margin-right: 5px; border: 1px dotted #cecece; display: inline-block; vertical-align: middle;" />(ID: ' + item.id + ') ' + item.name  + '</div>';
        },
        onSelect: function(e, term, item){
            item.parents('.products-wrapper').first().find('.select-products-ids').first().append('<option value="' + item.data('id') + '">' + '(ID: ' + item.data('id') + ') ' +  item.data('name')  + '</option>');
        }
    };

    $('.product-autocomplete').autoCompleteIq(p_auto_settings);


//fix for tinymce source code edit
    $(document).on('focusin', function (e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });


    /**
     * Grid creator
     * type = 1 = row
     * type = 2 = column
     */


//first rows sortable init
    $('.first-rows-wrapper').sortable({
        items: ".first_rows",
        placeholder: "row-placeholder",
        handle: ".dragger-handle"
    });
//$( '.first-rows-wrapper' ).disableSelection();

//menu row sortable init
    $('.menu_row').sortable({
        items: ".menu_column",
        handle: ".dragger-handle",
        forcePlaceholderSize: true,
        placeholder: "col-placeholder",
        start: function (e, ui) {
            ui.placeholder.height(ui.item.outerHeight());
            ui.placeholder.addClass('col-xs-' + ui.item.data('width'));
        },
        connectWith: ".menu_row"
    });
//$( '.menu_row' ).disableSelection();

//menu column sortable init
    $('.menu_column').sortable({
        items: ".menu_row",
        handle: ".dragger-handle",
        placeholder: "row-placeholder",
        connectWith: ".menu_column"
    });
//$( '.menu_column' ).disableSelection();


//bind sort update
    $('.first-rows-wrapper').on('sortupdate', function (event, ui) {

        tmpelementId1 = ui.item.data('elementId');

        if (typeof ui.item.parent().data('elementId') === 'undefined') {
            tmpparentId = 0;
        }
        ;

        tmpparentId = ui.item.parent().data('elementId');

        if (submenu_content.hasOwnProperty(tmpelementId1)) {
            submenu_content[tmpelementId1].parentId = tmpparentId;
        }

        updateElementsPositions();
    });

//set column width
    $('.grid_creator').on('change', '.select-column-width', function () {
        $element = $(this).parent().parent().parent();
        tmpelementId = $element.data('elementId');

        $element.removeClass('col-xs-' + $element.data('width'));
        $element.addClass('col-xs-' + this.value);
        $element.data('width', this.value);

        if (submenu_content.hasOwnProperty(tmpelementId)) {
            submenu_content[tmpelementId].width = parseInt(this.value);
        }

    });

//open content modal
    $('.grid_creator').on('click', '.column-content-edit', function () {
        $($(this).parent().parent().find('.column-content-modal').first()).modal({
            keyboard: false
        });

    });

//colum type
    $('.grid_creator').on('change', '.select-column-content', function () {
        $element = $(this).parents('.menu_column').first();

        elmid = $element.data('elementId');

        if (submenu_content.hasOwnProperty(elmid)) {
            submenu_content[elmid].contentType = parseInt(this.value);
        }


        setContentForm($element, this.value);


    });

//set content options
    $('.grid_creator').on('hidden.bs.modal', '.column-content-modal', function (e) {

        modid = $(this).parents('.menu_column').first().data('elementId');

        if (submenu_content.hasOwnProperty(modid)) {
            delete submenu_content[modid].content;
        }
        switch (parseInt($(this).find('.select-column-content').first().val())) {
            case 1:
                setHtmlContent(this, modid);
                break;
            case 2:
                setCategoriesContent(this, modid);
                break;
            case 3:
                setLinksContent(this, modid);
                break;
            case 4:
                setProductsContent(this, modid);
                break;
            case 5:
                setManufacturersContent(this, modid);
                break;
            case 6:
                setImagesContent(this, modid);
                break;
            case 7:
                setSuppliersContent(this, modid);
                break;
        }

        setColumnStyle(this, modid);
    });


    function setCategoriesContent(modal, elmid) {
        column_content = {};

        if (ids = $(modal).find('.select-categories-ids').first().val()) {
            column_content.ids = ids;
            column_content.treep = parseInt($(modal).find('.select-categories-treep').first().val());
            column_content.thumb = parseInt($(modal).find('.select-categories-thumb').first().val());
            column_content.depth = parseInt($(modal).find('.select-categories-depth').first().val());
            column_content.line = parseInt($(modal).find('.select-categories-line').first().val());
            column_content.sublimit = parseInt($(modal).find('.select-categories-sublimit').first().val());
        }

        if (submenu_content.hasOwnProperty(elmid)) {
            submenu_content[elmid].content = column_content;
        }

    }

    function getMeta(url) {
        var img = new Image();
        img.src = url;
        var size = {};
        img.addEventListener("load", function () {
            size['w'] = this.naturalWidth;
            size['h'] = this.naturalHeight;
            return size;
        });
        return size;

    }


    function setImagesContent(modal, elmid) {
        column_content = {};

        source = {};
        href = {};
        alt = {};
        size = {};

        if (typeof languages != "undefined") {
            languages.forEach(function (jsLang) {
                source[jsLang.id_lang] = $(modal).find('.image-source-' + jsLang.id_lang).first().val();
                href[jsLang.id_lang] = $(modal).find('.image-href-' + jsLang.id_lang).first().val();
                alt[jsLang.id_lang] = $(modal).find('.image-alt-' + jsLang.id_lang).first().val();
                size[jsLang.id_lang] = getMeta(source[jsLang.id_lang]);


            });
        } else {
            source[id_language] = $(modal).find('.image-source-' + id_language).first().val();
            href[id_language] = $(modal).find('.image-href-' + id_language).first().val();
            alt[id_language] = $(modal).find('.image-alt-' + id_language).first().val();
            size[id_language] = getMeta(source[id_language]);
        }

        column_content.source = source;
        column_content.href = href;
        column_content.alt = alt;
        column_content.size = size;

        if (absolute = parseInt($(modal).find('.select-image-absolute').first().val())) {
            column_content.absolute = 1;
            column_content.i_a_t = $(modal).find('.image-absolute-t').first().val();
            column_content.i_a_r = $(modal).find('.image-absolute-r').first().val();
            column_content.i_a_b = $(modal).find('.image-absolute-b').first().val();
            column_content.i_a_l = $(modal).find('.image-absolute-l').first().val();
        }

        if (submenu_content.hasOwnProperty(elmid)) {
            submenu_content[elmid].content = column_content;
        }

    }


    function setProductsContent(modal, elmid) {
        column_content = {};

        if (ids = serialize_productsselect($(modal).find('.select-products-ids').first().find('option'))) {
            column_content.ids = ids;
            column_content.line = parseInt($(modal).find('.select-products-line').first().val());
            column_content.view = parseInt($(modal).find('.select-products-view').first().val());
        }

        if (submenu_content.hasOwnProperty(elmid)) {
            submenu_content[elmid].content = column_content;
        }

    }


    function setManufacturersContent(modal, elmid) {
        column_content = {};

        if (ids = $(modal).find('.select-manufacturers-ids').first().val()) {
            column_content.ids = ids;
            column_content.line = parseInt($(modal).find('.select-manufacturers-line').first().val());
        }

        if (submenu_content.hasOwnProperty(elmid)) {
            submenu_content[elmid].content = column_content;
        }

    }

    function setSuppliersContent(modal, elmid) {
        column_content = {};

        if (ids = $(modal).find('.select-suppliers-ids').first().val()) {
            column_content.ids = ids;
            column_content.line = parseInt($(modal).find('.select-suppliers-line').first().val());
        }

        if (submenu_content.hasOwnProperty(elmid)) {
            submenu_content[elmid].content = column_content;
        }

    }


    function setLinksContent(modal, elmid) {
        column_content = {};

        if (ids = $(modal).find('.select-links-ids').first().val()) {
            column_content.ids = ids;
            column_content.view = parseInt($(modal).find('.select-links-view').first().val());
        }

        if (submenu_content.hasOwnProperty(elmid)) {
            submenu_content[elmid].content = column_content;
        }

    }

    function setHtmlContent(modal, elmid) {
        column_content = {};

        if (ids = $(modal).find('.select-customhtml').first().val()) {
            column_content.ids = ids;
        }

        if (submenu_content.hasOwnProperty(elmid)) {
            submenu_content[elmid].content = column_content;
        }

    }

    function setColumnStyle(modal, elmid) {
        submenu_style = {};

        title = {};
        href = {};
        legend = {};

        if (typeof languages != "undefined") {
            languages.forEach(function (jsLang) {
                title[jsLang.id_lang] = $(modal).find('.column-title-' + jsLang.id_lang).first().val();
                href[jsLang.id_lang] = $(modal).find('.column-href-' + jsLang.id_lang).first().val();
                legend[jsLang.id_lang] = $(modal).find('.column-legend-' + jsLang.id_lang).first().val();
            });
        } else {
            title[id_language] = $(modal).find('.column-title-' + id_language).first().val();
            href[id_language] = $(modal).find('.column-href-' + id_language).first().val();
            legendf[id_language] = $(modal).find('.column-legen-' + id_language).first().val();
        }

        submenu_style.title = title;
        submenu_style.href = href;
        submenu_style.legend = legend;


        if (bgcolor = $(modal).find('.column_bg_color').first().val())
            submenu_style.bg_color = bgcolor;

        if (legend_bg = $(modal).find('.legend_bg').first().val())
            submenu_style.legend_bg = legend_bg;

        if (legend_txt = $(modal).find('.legend_txt').first().val())
            submenu_style.legend_txt = legend_txt;

        if (title_borderc = $(modal).find('.title_borderc').first().val())
            submenu_style.title_borderc = title_borderc;

        if (title_color = $(modal).find('.title_color').first().val())
            submenu_style.title_color = title_color;

        if (title_colorh = $(modal).find('.title_colorh').first().val())
            submenu_style.title_colorh = title_colorh;

        if (txt_color = $(modal).find('.txt_color').first().val())
            submenu_style.txt_color = txt_color;

        if (txt_colorh = $(modal).find('.txt_colorh').first().val())
            submenu_style.txt_colorh = txt_colorh;


        if (br_top_st = parseInt($(modal).find('.br_top_st').first().val())) {
            submenu_style.br_top_st = br_top_st;
            submenu_style.br_top_wh = parseInt($(modal).find('.br_top_wh').first().val());
            submenu_style.br_top_c = $(modal).find('.br_top_c').first().val();
        }

        if (br_right_st = parseInt($(modal).find('.br_right_st').first().val())) {
            submenu_style.br_right_st = br_right_st;
            submenu_style.br_right_wh = parseInt($(modal).find('.br_right_wh').first().val());
            submenu_style.br_right_c = $(modal).find('.br_right_c').first().val();
        }

        if (br_bottom_st = parseInt($(modal).find('.br_bottom_st').first().val())) {
            submenu_style.br_bottom_st = br_bottom_st;
            submenu_style.br_bottom_wh = parseInt($(modal).find('.br_bottom_wh').first().val());
            submenu_style.br_bottom_c = $(modal).find('.br_bottom_c').first().val();
        }

        if (br_left_st = parseInt($(modal).find('.br_left_st').first().val())) {
            submenu_style.br_left_st = br_left_st;
            submenu_style.br_left_wh = parseInt($(modal).find('.br_left_wh').first().val());
            submenu_style.br_left_c = $(modal).find('.br_left_c').first().val();
        }

        //paddings
        if ($(modal).find('.c-padding-top').first().prop('checked'))
            submenu_style.c_p_t = 1;

        if ($(modal).find('.c-padding-right').first().prop('checked'))
            submenu_style.c_p_r = 1;

        if ($(modal).find('.c-padding-bottom').first().prop('checked'))
            submenu_style.c_p_b = 1;

        if ($(modal).find('.c-padding-left').first().prop('checked'))
            submenu_style.c_p_l = 1;

        //margins
        if ($(modal).find('.c-margin-top').first().prop('checked'))
            submenu_style.c_m_t = 1;

        if ($(modal).find('.c-margin-right').first().prop('checked'))
            submenu_style.c_m_r = 1;

        if ($(modal).find('.c-margin-bottom').first().prop('checked'))
            submenu_style.c_m_b = 1;

        if ($(modal).find('.c-margin-left').first().prop('checked'))
            submenu_style.c_m_l = 1;


        if (submenu_content.hasOwnProperty(elmid)) {
            submenu_content[elmid].content_s = submenu_style;
        }

    }

    function serialize_productsselect(element) {
        options = [];
        element.each(function (i) {
            options[i] = $(this).val();
        });

        return uniqProducts(options);

    }

    function uniqProducts(a) {
        var prims = {"boolean": {}, "number": {}, "string": {}}, objs = [];

        return a.filter(function (item) {
            var type = typeof item;
            if (type in prims)
                return prims[type].hasOwnProperty(item) ? false : (prims[type][item] = true);
            else
                return objs.indexOf(item) >= 0 ? false : objs.push(item);
        });
    }

    function setContentForm($element, val) {

        $element.find('.column-content-info').first().text($element.find('.select-column-content option[value="' + parseInt(val) + '"]').first().text());

        switch (parseInt(val)) {
            case 0:
                $element.find('.content-options-wrapper').hide();
                break;
            case 1:
                $element.find('.content-options-wrapper').not('.htmlcontent-wrapper').hide();
                $element.find('.htmlcontent-wrapper').show();
                break;
            case 2:
                $element.find('.content-options-wrapper').not('.categorytree-wrapper').hide();
                $element.find('.categorytree-wrapper').show();
                break;
            case 3:
                $element.find('.content-options-wrapper').not('.va-links-wrapper').hide();
                $element.find('.va-links-wrapper').show();
                break;
            case 4:
                $element.find('.content-options-wrapper').not('.products-wrapper').hide();
                $element.find('.products-wrapper').show();
                break;
            case 5:
                $element.find('.content-options-wrapper').not('.manufacturers-wrapper').hide();
                $element.find('.manufacturers-wrapper').show();
                break;
            case 6:
                $element.find('.content-options-wrapper').not('.column-image-wrapper').hide();
                $element.find('.column-image-wrapper').show();
                break;
            case 7:
                $element.find('.content-options-wrapper').not('.suppliers-wrapper').hide();
                $element.find('.suppliers-wrapper').show();
                break;
        }

    }


//init submenu elements

    var submenu_content = {};
    var elementId = 0;

    if ($('#submenu-elements').length) {
        var prev_submenu_val = $('#submenu-elements').val();
        if (prev_submenu_val.length !== 0) {
            var old_submenu_content = JSON.parse(prev_submenu_val);
            $.extend(submenu_content, old_submenu_content);

            var ids = $(".menu-element").map(function () {
                return parseInt($(this).data('element-id'), 10);
            }).get();

            elementId = Math.max.apply(Math, ids);

        }
    }

    $('.menu_column').each(function () {

        $(this).find('.column_bg_color-' + $(this).data('element-id')).first().mColorPicker();
        $(this).find('.legend_bg-' + $(this).data('element-id')).first().mColorPicker();
        $(this).find('.legend_txt-' + $(this).data('element-id')).first().mColorPicker();

        $(this).find('.br_top_c-' + $(this).data('element-id')).first().mColorPicker();
        $(this).find('.br_right_c-' + $(this).data('element-id')).first().mColorPicker();
        $(this).find('.br_bottom_c-' + $(this).data('element-id')).first().mColorPicker();
        $(this).find('.br_left_c-' + $(this).data('element-id')).first().mColorPicker();

        $(this).find('.title_borderc-' + $(this).data('element-id')).first().mColorPicker();
        $(this).find('.title_color-' + $(this).data('element-id')).first().mColorPicker();
        $(this).find('.title_colorh-' + $(this).data('element-id')).first().mColorPicker();
        $(this).find('.txt_color-' + $(this).data('element-id')).first().mColorPicker();
        $(this).find('.txt_colorh-' + $(this).data('element-id')).first().mColorPicker();

        setContentForm($(this), $(this).data('contenttype'));
    });


//add first row button
    $('#buttons-sample').on('click', '.add-row-action', function () {

        $parentElement = $(this).parent().parent().parent().find('.first-rows-wrapper');
        $parentElement.append('<div data-element-type="1" data-depth="0" data-element-id="' + (++elementId) + '" class="row menu_row first_rows menu-element menu-element-id-' + (elementId) + '">' + $('#buttons-sample').html() + '</div>');

        $('.menu-element-id-' + elementId).sortable({
            items: ".menu_column",
            handle: ".dragger-handle",
            connectWith: ".menu_row",
            placeholder: "col-placeholder",
        });
        //$( '.menu-element-id-' + elementId).disableSelection();

        position = $parentElement.children().length;

        var newElement = {
            'elementId': elementId,
            'type': 1,
            'depth': 0,
            'position': position,
            'parentId': 0
        };

        submenu_content[elementId] = newElement;
    });

//add row button
    $('.grid_creator').on('click', '.menu-element .add-row-action', function () {

        parentId = $(this).parent().parent().data("element-id");
        depth = $(this).parent().parent().data("depth") + 1;

        $parentElement = $(this).parent().parent();
        $parentElement.append('<div data-element-type="1" data-depth="' + depth + '" data-element-id="' + (++elementId) + '" class="row menu_row menu-element menu-element-id-' + (elementId) + '">' + $('#buttons-sample').html() + ' </div>');

        $('.menu-element-id-' + elementId).sortable({
            items: ".menu_column",
            handle: ".dragger-handle",
            placeholder: "col-placeholder",
            connectWith: ".menu_row"
        });
        //$( '.menu-element-id-' + elementId).disableSelection();

        position = $parentElement.children().length;

        var newElement = {
            'elementId': elementId,
            'type': 1,
            'depth': depth,
            'position': position,
            'parentId': parentId
        };

        submenu_content[elementId] = newElement;

    });

//clone column
    $('.grid_creator').on('click', ' .duplicate-element-action', function () {
        $brotherElement = $(this).parents('.menu-element').first();
        brotherId = $brotherElement.data('element-id');

        if (submenu_content.hasOwnProperty(brotherId)) {

            clonedElement = clone(submenu_content[brotherId]);
            clonedElement.elementId = ++elementId;

            $cloneElement = $brotherElement.clone(true);
            $cloneElement.data('element-id', elementId);
            $cloneElement.removeClass('menu-element-id-' + brotherId);
            $cloneElement.addClass('menu-element-id-' + elementId).appendTo($brotherElement.parent());
            submenu_content[elementId] = clonedElement;
        }
    });


//add column button
    $('.grid_creator').on('click', '.menu-element .add-column-action', function () {
        parentId = $(this).parent().parent().data('element-id');
        depth = $(this).parent().parent().data("depth") + 1;

        $parentElement = $(this).parent().parent();
        $parentElement.append('<div data-element-type="2" data-depth="' + depth + '"  data-width="3" data-element-id="' + (++elementId) + '" class="col-xs-3 menu_column menu-element menu-element-id-' + (elementId) + '">' + $('#buttons-sample').html() + $('#column-content-sample').html() + '</div>');

        $('.menu-element-id-' + elementId).sortable({
            items: ".menu_row",
            handle: ".dragger-handle",
            placeholder: "row-placeholder",
            connectWith: ".menu_column"
        });
        //$( '.menu-element-id-' + elementId).disableSelection();

        position = $parentElement.children().length;

        var newElement = {
            'elementId': elementId,
            'type': 2,
            'depth': depth,
            'width': 3,
            'contentType': 0,
            'position': position,
            'parentId': parentId
        };
        $('.menu-element-id-' + elementId + ' .column_bg_color').addClass('column_bg_color-' + elementId);
        $('.menu-element-id-' + elementId + ' .column_bg_color-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .legend_bg').addClass('legend_bg-' + elementId);
        $('.menu-element-id-' + elementId + ' .legend_bg-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .legend_txt').addClass('legend_txt-' + elementId);
        $('.menu-element-id-' + elementId + ' .legend_txt-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .br_top_c').addClass('br_top_c-' + elementId);
        $('.menu-element-id-' + elementId + ' .br_top_c-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .br_right_c').addClass('br_right_c-' + elementId);
        $('.menu-element-id-' + elementId + ' .br_right_c-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .br_bottom_c').addClass('br_bottom_c-' + elementId);
        $('.menu-element-id-' + elementId + ' .br_bottom_c-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .br_left_c').addClass('br_left_c-' + elementId);
        $('.menu-element-id-' + elementId + ' .br_left_c-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .title_borderc').addClass('title_borderc-' + elementId);
        $('.menu-element-id-' + elementId + ' .title_borderc-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .title_color').addClass('title_color-' + elementId);
        $('.menu-element-id-' + elementId + ' .title_color-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .title_colorh').addClass('title_colorh-' + elementId);
        $('.menu-element-id-' + elementId + ' .title_colorh-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .txt_color').addClass('txt_color-' + elementId);
        $('.menu-element-id-' + elementId + ' .txt_color-' + elementId).mColorPicker();

        $('.menu-element-id-' + elementId + ' .txt_colorh').addClass('txt_colorh-' + elementId);
        $('.menu-element-id-' + elementId + ' .txt_colorh-' + elementId).mColorPicker();


        $('.menu-element-id-' + elementId + ' .image-source').attr('id', elementId + '-image-source-' + $(this).data('lang-id'));


        $('.menu-element-id-' + elementId + ' .image-source').each(function () {
            $(this).attr('id', elementId + '-image-source-' + $(this).data('lang-id'));
            $(this).parent().find('.iframe-column-upload').data('input-name', elementId + '-image-source-' + $(this).data('lang-id'));
        });

        $('.menu-element-id-' + elementId + ' .rte').each(function () {
            $(this).attr('id', elementId + '-htmlcontent-' + $(this).data('lang-id'));

        });


        submenu_content[elementId] = newElement;
        setContentForm($('.menu-element-id-' + elementId), 0);

        $('.menu-element-id-' + elementId + ' .product-autocomplete').autoCompleteIq(p_auto_settings);

    });

//remove element button
    $('.grid_creator').on('click', '.remove-element-action', function () {
        deleteId = $(this).parent().parent().data('element-id');
        $(this).parent().parent().remove();

        delete submenu_content[deleteId];
        deleteMenuElelement(deleteId)
    });

//pass submenu to input field
    $('button[name="submitAddTab"]').on("click", function () {
        if ($.isEmptyObject(submenu_content))
            $('#submenu-elements').val('');
        else
            $('#submenu-elements').val(encodeURIComponent(JSON.stringify(submenu_content)));
    });

//remove product fromc olumn
    $('.grid_creator').on('click', '.remove-products-ids', function () {

        $(this).parent().find('.select-products-ids option:selected').each(function (i) {
            $(this).remove();
        });

    });

//delete menu elements recursivly
    function deleteMenuElelement(id) {
        for (var key in submenu_content) {
            if (submenu_content.hasOwnProperty(key)) {
                if (submenu_content[key].parentId == id) {
                    tmpelid = submenu_content[key].elementId;
                    delete submenu_content[key];
                    deleteMenuElelement(tmpelid);
                }
            }
        }
    }

//update all  menu positions after drag and drop
    function updateElementsPositions() {
        for (var key in submenu_content) {
            if (submenu_content.hasOwnProperty(key)) {
                submenu_content[key].position = $('.menu-element-id-' + submenu_content[key].elementId).index();
            }
        }
    }

    function clone(src) {
        function mixin(dest, source, copyFunc) {
            var name, s, i, empty = {};
            for (name in source) {
                // the (!(name in empty) || empty[name] !== s) condition avoids copying properties in "source"
                // inherited from Object.prototype.	 For example, if dest has a custom toString() method,
                // don't overwrite it with the toString() method that source inherited from Object.prototype
                s = source[name];
                if (!(name in dest) || (dest[name] !== s && (!(name in empty) || empty[name] !== s))) {
                    dest[name] = copyFunc ? copyFunc(s) : s;
                }
            }
            return dest;
        }

        if (!src || typeof src != "object" || Object.prototype.toString.call(src) === "[object Function]") {
            // null, undefined, any non-object, or function
            return src;	// anything
        }
        if (src.nodeType && "cloneNode" in src) {
            // DOM Node
            return src.cloneNode(true); // Node
        }
        if (src instanceof Date) {
            // Date
            return new Date(src.getTime());	// Date
        }
        if (src instanceof RegExp) {
            // RegExp
            return new RegExp(src);   // RegExp
        }
        var r, i, l;
        if (src instanceof Array) {
            // array
            r = [];
            for (i = 0, l = src.length; i < l; ++i) {
                if (i in src) {
                    r.push(clone(src[i]));
                }
            }
            // we don't clone functions for performance reasons
            //		}else if(d.isFunction(src)){
            //			// function
            //			r = function(){ return src.apply(this, arguments); };
        } else {
            // generic objects
            r = src.constructor ? new src.constructor() : {};
        }
        return mixin(r, src, clone);

    }


});
