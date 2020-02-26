import threesixty from  './lib/threesixty/threesixty.min';

$(document).ready(() => {
    let videoIframes,
        $videoIframesWrapper,
        $videoModal = $('#iqit-iqitvideos-modal');

    $('#iqit-threesixty-modal').on('shown.bs.modal', function() {
        var iqitThreeSixtySlider = threesixty(
            document.querySelector('#iqit-threesixty'),
            $('#iqit-threesixty').data('threesixty'),
            {
            interactive: true,
            currentImage: 0
        });
        iqitThreeSixtySlider.init();
    });

    $videoModal.on('shown.bs.modal', function() {
        $videoIframesWrapper = $('#iqitvideos-block');
        videoIframes = $videoIframesWrapper.html();
    });

    $videoModal.on('hidden.bs.modal', function() {
        $videoIframesWrapper.html(videoIframes);
    });

});
