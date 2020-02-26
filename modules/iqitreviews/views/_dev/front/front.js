import './lib/bootstrap-rating-input/bootstrap-rating-input.min';


iqitreviews.script = (function () {
    var $productReviewForm = $('#iqitreviews-productreview-form');

    return {
        'init': function () {

            $productReviewForm.submit(function(e) {

                e.preventDefault();

                var $productReviewFormAlert = $('#iqitreviews-productreview-form-alert'),
                    $productReviewFormSuccessAlert = $('#iqitreviews-productreview-form-success-alert');


                $.post($(this).attr('action'), $(this).serialize(), null, 'json').then(function (resp) {

                    if (!resp.success){
                        let htmlResp = '<strong>' + resp.data.message + '</strong>';

                        htmlResp = htmlResp + '<ul>';
                        $.each(resp.data.errors, function( index, value ) {
                            htmlResp = htmlResp + '<li>' + value + '</li>';
                        });
                        htmlResp = htmlResp + '</ul>';

                        $productReviewFormAlert.html(htmlResp);
                        $productReviewFormAlert.removeClass('hidden-xs-up');
                    } else {
                        let htmlResp = '<strong>' + resp.data.message + '</strong>';
                        $productReviewFormSuccessAlert.html(htmlResp);
                        $productReviewFormSuccessAlert.removeClass('hidden-xs-up');
                        $('#iqit-reviews-modal').modal('hide');
                    }

                }).fail((resp) => {
                    $productReviewFormAlert.html(resp);
                    $productReviewFormAlert.removeClass('invisible');
                });

                e.preventDefault();

            });


        },
    };
})();

$(document).ready(() => {
        iqitreviews.script.init();
});


