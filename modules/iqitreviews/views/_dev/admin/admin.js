/**
 * IqitReviews management
 */



$( document ).ready( function () {

    var iqitReviews = (function () {
        var $statusLink = $('.iqitreviews_products .list-action-enable');

        return {
            'init': function () {
                $statusLink.click(function(e) {
                    e.preventDefault();
                    let $self = $(this);

                    $.post($(this).attr('href') + '&ajax=1&action=statusProductReview', null, null, 'json').then(function (resp) {
                        if (resp.success){
                            $self.toggleClass('action-disabled');
                            $self.toggleClass('action-enabled');

                            $self.find('.icon-check').toggleClass('hidden');
                            $self.find('.icon-remove').toggleClass('hidden');
                            showSuccessMessage(resp.text);
                        } else {
                            showErrorMessage(resp.text);
                        }
                    }).fail((resp) => {
                       console.log(resp);
                    });


                });
            },
        };
    })();

iqitReviews.init();

});
