$(document).ready(() => {

    $('#iqitwishlist-nb').text(iqitwishlist.nbProducts);

    $('body').on('click', '.js-iqitwishlist-add', function (event) {
        let self = this;
        prestashop.emit('clickIqitWishlistAdd', {
            dataset: self.dataset,
            self: self
        });
        event.preventDefault();
    });

    $('body').on('click', '.js-iqitwishlist-remove', function (event) {

        let self = this;
        prestashop.emit('clickIqitWishlistRemove', {
            dataset: self.dataset
        });
        event.preventDefault();
    });


    prestashop.on('clickIqitWishlistAdd', function (elm) {

        let data = {
            'process': 'add',
            'ajax': 1,
            'idProduct': elm.dataset.idProduct,
            'idProductAttribute': elm.dataset.idProductAttribute,
        };

        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {

            if (!resp.success && resp.data.type == 'notLogged'){
                let quickModal = $('.modal.quickview').first();

                if (quickModal.length){
                    $(quickModal).modal('hide');
                    $(quickModal).on('hidden.bs.modal', function (e) {
                        $('#iqitwishlist-modal').modal('show');
                    });
                } else{
                    $('#iqitwishlist-modal').modal('show');
                }
                return;
            }
            $(elm.self).addClass('iqitwishlist-added');
            if (resp.success){
                iqitwishlist.nbProducts++;
                $('#iqitwishlist-nb').text(iqitwishlist.nbProducts);

                let $notification =  $('#iqitwishlist-notification');
                $notification.addClass('ns-show');

                setTimeout(function(){
                    $notification.removeClass('ns-show');
                }, 3500);
            }

        }).fail((resp) => {
            prestashop.emit('handleError', {eventType: 'clickIqitWishlistAdd', resp: resp});
        });

    });

    prestashop.on('clickIqitWishlistRemove', function (elm) {

        let data = {
            'process': 'remove',
            'ajax': 1,
            'idProduct': elm.dataset.idProduct,
        };

        $.post(elm.dataset.url, data, null, 'json').then(function (resp) {
            console.log('#iqitwishlist-product-' + elm.dataset.idProduct);
            $('#iqitwishlist-product-' + elm.dataset.idProduct).remove();
            iqitwishlist.nbProducts--;
            $('#iqitwishlist-nb').text(iqitwishlist.nbProducts);

            if (iqitwishlist.nbProducts == 0) {
                $('#iqitwishlist-warning').removeClass('hidden-xs-up');
                $('#iqitwishlist-crosseling, #iqitwishlist-share').addClass('hidden-xs-up');
            }

        }).fail((resp) => {
            prestashop.emit('handleError', {eventType: 'clickIqitWishlistRemove', resp: resp});
        });

    });

    prestashop.on('updatedProduct', function (elm) {
        $('#iqit-wishlist-product-btn').data('id-product-attribute', elm.id_product_attribute);
        $('#iqit-wishlist-product-btn').attr('data-id-product-attribute', elm.id_product_attribute);
    });


    $('#iqitwishlist-clipboard-btn').on('click', function () {

        var $btn = $(this);

        var copyInput = $btn.closest('.input-group').children('input.js-to-clipboard');
        copyInput.select();

        try {
            var successful = document.execCommand('copy');
            if (successful) {
                $btn.text($btn.data('textCopied'));
                setTimeout(function(){ $btn.text($btn.data('textCopy'));  }, 1500);
            }
        } catch (err) {
            console.log('Oops, unable to copy');
        }
    });

});


