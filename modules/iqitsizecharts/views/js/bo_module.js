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

    //table generator

    $('#table_generator').on('click', function () {
        iqitSizeChartCreateTable();
    });

});


function iqitSizeChartCreateTable() {
    var no_rows = $('.nrows').val();
    var no_col = $('.ncol').val();

    var tblW = document.createElement('div');
    tblW.setAttribute("class", "table-responsive");

    var tbl = document.createElement('table');
    //checking and adding style
    //checking which style is selected

    if ($('.table_bordered').prop('checked')) {
        tbl.setAttribute("class", "table table-bordered table-sizegudie table-responsive");
    }
    if ($('.table_bordered').prop('checked') && $('.table_striped').prop('checked')) {
        tbl.setAttribute("class", "table table-striped table-bordered table-sizegudie table-responsive");
    }
    if ($('.table_striped').prop('checked') && !$('.table_bordered').prop('checked')) {
        tbl.setAttribute("class", "table table-striped table-sizegudie table-responsive");
    }
    if (!$('.table_bordered').prop('checked') && !$('.table_striped').prop('checked')) {
        tbl.setAttribute("class", "table table-sizegudie table-responsive");
    }


    var tblHead = document.createElement('thead');
    tbl.appendChild(tblHead);
    var tblrow = document.createElement("tr");
    tblHead.appendChild(tblrow);
    for (r = 0; r < no_col; r++) {
        var tblHeadCell = document.createElement('th');
        tblrow.appendChild(tblHeadCell);
        var thText = document.createTextNode("th" + r);
        tblHeadCell.appendChild(thText);
    }
    if ($('.header_row').prop('checked')) {
        var tblHeadCell = document.createElement('th');
        tblHeadCell.className = "nobordered-cell";
        tblrow.insertBefore(tblHeadCell, tblrow.firstChild);
        var thText = document.createTextNode("");
        tblHeadCell.appendChild(thText);

    }
    var tblBody = document.createElement("tbody");
    for (var p = 0; p < no_rows; p++) {
        // creates a table row
        var row = document.createElement("tr");

        if ($('.header_row').prop('checked')) {
            var cell = document.createElement("td");
            cell.className = "bordered-cell";
            var cellText = document.createTextNode("header");
            cell.appendChild(cellText);
            row.appendChild(cell);
        }
        for (var q = 0; q < no_col; q++) {
            // Create a <td> element and a text node, make the text
            // node the contents of the <td>, and put the <td> at
            // the end of the table row
            var cell = document.createElement("td");
            var cellText = document.createTextNode("cell" + p + "," + q);
            cell.appendChild(cellText);
            row.appendChild(cell);
        }

        // add the row to the end of the table body
        tblBody.appendChild(row);
    }
    tbl.appendChild(tblBody);
    tblW.appendChild(tbl);
    //display table
    iqitSizeChartAssignToTinyMce(tblW);
}

function iqitSizeChartAssignToTinyMce(content) {
    $('.js-chart-content').each(function(  ) {
        var $container = $(this).parents('.form-group').first();
        if ($container.is( ":visible" )){
            tinymce.get($container.find('textarea').first().attr('id')).execCommand('mceInsertContent', false, content.outerHTML);
        }
    });
}