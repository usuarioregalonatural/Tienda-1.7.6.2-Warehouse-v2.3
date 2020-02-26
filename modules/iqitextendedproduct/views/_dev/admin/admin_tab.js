import urlParser from  './lib/jsVideoUrlParser.min';
/**
 * IqitVideos management
 */
var iqitVideosForm = (function () {
    var videoListContainer = $('#iqitvideos-list');

    return {
        'init': function () {
            iqitVideosForm.setInputVal();
            $('#iqitthreesixty-addvideo').on('click', function () {
                let field = $('#iqitthreesixty-videourl');
                let video = urlParser.parse(field.val());
                let template = $('#iqitvideo-previewsample').children().clone();

                if (video != null) {
                    let videoUrl = urlParser.create({
                        videoInfo: video,
                        format: 'embed'
                    });
                    template.data('video-url', video.id);
                    template.data('video-provider', video.provider);
                    template.find('.js-video-iframe').prop('src', videoUrl);
                    videoListContainer.append(template);
                    field.val('');
                }
                else{
                    return $.growl.error({
                        title: "",
                        size: "large",
                        message: "Something wrong with video link!"
                    });
                }
                iqitVideosForm.setInputVal();
            });

            videoListContainer.on('click', '.js-delete-video', function () {
                $(this).parents('.iqitvideo-preview').first().remove();
                iqitVideosForm.setInputVal();
            });

            videoListContainer.sortable({
                items: "div.iqitvideo-preview",
                opacity: 0.9,
                containment: 'parent',
                distance: 32,
                tolerance: 'pointer',
                cursorAt: {
                    left: 64,
                    top: 64
                },
                cancel: '.disabled',
                start: function (event, ui) {
                    //init zindex
                    videoListContainer.find('.iqitvideo-preview').css('zIndex', 1);
                    ui.item.css('zIndex', 10);
                },
                stop: function (event, ui) {
                    iqitVideosForm.setInputVal();
                }
            });
        },
        'setInputVal': function () {

            var videosIqit = [];

            $('#iqitvideos-list').find('.js-iqitvideo-preview').each(function () {
                videosIqit.push({p: $(this).data('video-provider'), id:$(this).data('video-url') });
            });

            if ($.isEmptyObject(videosIqit)) {
                $('#iqitextendedproduct_videos').val('');
            }
            else {
                $('#iqitextendedproduct_videos').val(JSON.stringify(videosIqit));
            }

        },
    };
})();

/**
 * IqitThreeSixty images management
 */
var uploaderIqitThreeSixty = (function () {
    var myDropzone;
    var dropZoneElem = $('#iqitthreesixty-images-dropzone');

    return {
        'init': function () {
            uploaderIqitThreeSixty.setInputVal();
            Dropzone.autoDiscover = false;
            var errorElem = $('#iqitthreesixty-images-dropzone-error');

            $("#iqitthreesixty-removeall").on("click", function () {
                myDropzone.removeAllFiles(true);
                $(dropZoneElem).find('.dz-image-preview').each(function () {
                    var name = $(this).data('name');
                    $(this).remove();
                    $.ajax({
                        url: dropZoneElem.attr('url-delete'),
                        data: {'file': name},
                    });
                });
                uploaderIqitThreeSixty.setInputVal();
            });

            $(dropZoneElem).on("click", '.dz-remove-custom', function () {
                var $el = $(this).parents('.dz-preview').first();
                $el.remove();
                $.ajax({
                    url: dropZoneElem.attr('url-delete'),
                    data: {'file': $el.data('name')},
                });
                uploaderIqitThreeSixty.setInputVal();
            });

            var dropzoneOptions = {
                url: dropZoneElem.attr('url-upload'),
                paramName: 'threesixty-file-upload',
                maxFilesize: dropZoneElem.attr('data-max-size'),
                addRemoveLinks: true,
                thumbnailWidth: 250,
                clickable: '.threesixty-openfilemanager',
                thumbnailHeight: null,
                uploadMultiple: false,
                acceptedFiles: 'image/*',
                dictRemoveFile: 'Delete',
                dictFileTooBig: 'ToLargeFile',
                dictCancelUpload: 'Delete',
                sending: function (file, response) {
                    errorElem.html('');
                },
                queuecomplete: function () {
                    dropZoneElem.sortable('enable');
                },
                processing: function () {
                    dropZoneElem.sortable('disable');
                },
                success: function (file, response) {
                    //manage error on uploaded file
                    if (response.error !== 0) {
                        errorElem.append('<p>' + file.name + ': ' + response.error + '</p>');
                        this.removeFile(file);
                        return;
                    }
                    $(file.previewElement).data('name', response.name);
                    $(file.previewElement).addClass('ui-sortable-handle');
                    uploaderIqitThreeSixty.setInputVal();
                },
                removedfile: function (file) {
                    var name = $(file.previewElement).data('name');
                    var _ref;
                    if (file.previewElement) {
                        if ((_ref = file.previewElement) != null) {
                            _ref.parentNode.removeChild(file.previewElement);
                        }
                    }
                    $.ajax({
                        url: dropZoneElem.attr('url-delete'),
                        data: {'file': name},
                    });
                    uploaderIqitThreeSixty.setInputVal();
                },
                error: function (file, response) {
                    var message = '';
                    if ($.type(response) === 'undefined') {
                        return;
                    } else if ($.type(response) === 'string') {
                        message = response;
                    } else if (response.message) {
                        message = response.message;
                    }

                    if (message === '') {
                        return;
                    }

                    //append new error
                    errorElem.append('<p>' + file.name + ': ' + message + '</p>');

                    //remove uploaded item
                    this.removeFile(file);
                },
                init: function () {
                    //if already images uploaded, mask drop file message
                    if (dropZoneElem.find('.dz-preview:not(.threesixty-openfilemanager)').length) {
                        dropZoneElem.addClass('dz-started');
                    } else {
                        dropZoneElem.find('.dz-preview.threesixty-openfilemanager').hide();
                    }

                    //init sortable
                    dropZoneElem.sortable({
                        items: "div.dz-preview:not(.disabled)",
                        opacity: 0.9,
                        containment: 'parent',
                        distance: 32,
                        tolerance: 'pointer',
                        cursorAt: {
                            left: 64,
                            top: 64
                        },
                        cancel: '.disabled',
                        start: function (event, ui) {
                            //init zindex
                            dropZoneElem.find('.dz-preview').css('zIndex', 1);
                            ui.item.css('zIndex', 10);
                        },
                        stop: function (event, ui) {
                            uploaderIqitThreeSixty.setInputVal();
                        }
                    });

                    dropZoneElem.disableSelection();
                }
            };
            myDropzone = new Dropzone("div#iqitthreesixty-images-dropzone", jQuery.extend(dropzoneOptions));
        },
        'setInputVal': function () {

            var imagesIqitThreeSixty = [];

            dropZoneElem.find('.dz-image-preview').each(function () {
                imagesIqitThreeSixty.push({n: $(this).data('name')});
            });

            if ($.isEmptyObject(imagesIqitThreeSixty)) {
                $('#iqitextendedproduct_threesixty').val('');
            }
            else {
                $('#iqitextendedproduct_threesixty').val(JSON.stringify(imagesIqitThreeSixty));
            }
        },
    };
})();
$( document ).ready( function () {
uploaderIqitThreeSixty.init();
iqitVideosForm.init();
});



