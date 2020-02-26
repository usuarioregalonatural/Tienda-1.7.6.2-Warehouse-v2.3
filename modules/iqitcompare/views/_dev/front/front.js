$(document).ready(() => {

    $('#iqitcompare-nb').text(iqitcompare.nbProducts);

    $('body').on('click', '.js-iqitcompare-add', function (event) {
        let self = this;
        prestashop.emit('clickIqitCompareAdd', {
            dataset: self.dataset,
            self: self
        });
        event.preventDefault();
    });

    $('body').on('click', '.js-iqitcompare-remove', function (event) {

        let self = this;
        prestashop.emit('clickIqitCompareRemove', {
            dataset: self.dataset
        });
        event.preventDefault();
    });

    $('body').on('click', '.js-iqitcompare-remove-all', function (event) {

        let self = this;
        prestashop.emit('clickIqitCompareRemoveAll', {
            dataset: self.dataset
        });
        event.preventDefault();
    });

    prestashop.on('clickIqitCompareAdd', function (elm) {

        let data = {
            'process': 'add',
            'ajax': 1,
            'idProduct': elm.dataset.idProduct,
        };

        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {

            if (resp.success){
                iqitcompare.nbProducts++;
                $('#iqitcompare-nb').text(iqitcompare.nbProducts);
            }

            $(elm.self).addClass('iqitcompare-added');

            let $notification =  $('#iqitcompare-notification');
            $notification.addClass('ns-show');

            setTimeout(function(){
                $notification.removeClass('ns-show');
            }, 3500);


        }).fail((resp) => {
            prestashop.emit('handleError', {eventType: 'clickIqitCompareAdd', resp: resp});
        });

    });

    prestashop.on('clickIqitCompareRemove', function (elm) {

        let data = {
            'process': 'remove',
            'ajax': 1,
            'idProduct': elm.dataset.idProduct,
        };

        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {
            $('.js-iqitcompare-product-' + elm.dataset.idProduct).remove();
            iqitcompare.nbProducts--;
            $('#iqitcompare-nb').text(iqitcompare.nbProducts);

            if (iqitcompare.nbProducts == 0) {
                $('#iqitcompare-table').remove();
                $('#iqitcompare-warning').removeClass('hidden-xs-up');
            }

        }).fail((resp) => {
            prestashop.emit('handleError', {eventType: 'clickIqitCompareRemove', resp: resp});
        });

    });

    prestashop.on('clickIqitCompareRemoveAll', function (elm) {

        let data = {
            'process': 'removeAll',
            'ajax': 1,
        };

        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {

            $('#iqitcompare-nb').text(0);
            $('#iqitcompare-table').remove();
            $('#iqitcompare-warning').removeClass('hidden-xs-up');

        }).fail((resp) => {
            prestashop.emit('handleError', {eventType: 'clickIqitCompareRemove', resp: resp});
        });

    });


});


