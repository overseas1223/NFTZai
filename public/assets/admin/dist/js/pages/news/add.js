(function($) {
    "use strict";
    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Write here..',
            height: 300,
            styleTags: [
                'p',
                { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
            ],
            prettifyHtml: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'add-text-tags', 'highlight', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'videoAttributes']],
                ['view', ['fullscreen', 'codeview', 'help']],
            ],
            imageAttributes: {
                icon: '<i class="note-icon-pencil"/>',
                figureClass: 'figureClass',
                figcaptionClass: 'captionClass',
                captionText: 'Caption Goes Here.',
                manageAspectRatio: true // true = Lock the Image Width/Height, Default to true
            },
            lang: 'en-US',
            popover: {
                image: [
                    ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']],
                    ['custom', ['imageAttributes']],
                ],
            },
            callbacks: {
                onImageUpload: function(image) {
                    let editor;
                    editor = $(this);
                    uploadImageContent(image[0], editor);
                },
                onMediaDelete: function(target) {
                    deleteImage(target[0].src);
                }
            },
        });

    });
})(jQuery)
