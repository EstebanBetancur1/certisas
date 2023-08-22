/**
 * Created by jorge on 03/11/15.
 */

(function ( $ ) {

    $.fn.preview = function( options ) {
        // This is the easiest way to have default options.
        var settings = $.extend({
            allowedTypes: "jpg,jpeg,png",
            idTarget: "",
            idShow: "",
            pathPreview: "/images/default-image.png",
            selectedFile: null,
            element: null,
            width: null,
            onSelect: function(file){}
        }, options );

        // Recorre todos los elementos encontrados por el selector
        this.each(function() {
            var element = $(this);
            var name = element.attr('data-field');
            var height = element.attr('data-height');
            var width = element.attr('data-width');
            var text = width+'x'+height;
            var image = null;

            if(typeof (element.attr('data-text')) != 'undefined'){
                text = element.attr('data-text');
            }

            if(typeof (element.attr('data-image'))){
                image = element.attr('data-image')
            }

            if(image){
                var expr = /^(http)/;

                if(!expr.test(image)){
                    image = '/'+image;
                }

                var div_a = $('<div class="image"><img alt="'+image+'" width="'+width+'" src="'+image+'" class="img-responsive img-fluid"></div>').appendTo(element);
            }else{
                var div_a = $('<div class="image"><img alt="'+width+'x'+height+'" width="'+width+'" src="'+settings.pathPreview+'" class="img-responsive img-fluid"></div>').appendTo(element);
            }

            var div_b = $('<div class="input"></div>').appendTo(element);
            var input = $('<input type="file" class="input-preview" id="'+name+'" name="'+name+'" />').hide().appendTo(div_b);

            input.on('change', function(){
                changeInputFile(this, div_a, width);
            });

            div_a.on('click', function(){
                input.click();
            });
        });

        function changeInputFile(input, div, width){

            var filenameStr = $(input).val();

            if (! isFileTypeAllowed(input, settings, filenameStr)) {
                alert("archivo invalido");
                return;
            }

            previewImage(input, div, width);
        }

        function previewImage(input, div, width) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var string_width = 'width="'+width+'"';

                reader.onload = function (e) {
                    var img = $('<img src="#" '+string_width+' alt="#" class="img-responsive img-fluid"/>');
                    img.attr('src', e.target.result);
                    div.html(img);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function isFileTypeAllowed( input, settings, fileName ) {
            var fileExtensions = settings.allowedTypes.toLowerCase().split(",");
            var ext = fileName.split('.').pop().toLowerCase();
            if (settings.allowedTypes != "*" && jQuery.inArray(ext, fileExtensions) < 0) {
                return false;
            }
            return true;
        }
    };

}( jQuery ));