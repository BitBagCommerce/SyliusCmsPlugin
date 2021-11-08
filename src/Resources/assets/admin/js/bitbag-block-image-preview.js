// /*
//  This file was created by developers working at BitBag
//  Do you need more information about us and what we do? Visit our https://bitbag.io website!
//  We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
// */

// (function ( $ ) {
//     'use strict';

//     $.fn.extend({
//         previewUploadedImage: function (root) {
//             $(root + ' input[type="file"]').each(function() {
//                 $(this).change(function() {
//                     displayUploadedImage(this);
//                 });
//             });

//             $(root + ' [data-form-collection="add"]').on('click', function() {
//                 var self = $(this);

//                 setTimeout(function() {
//                     self.parent().find('.column:last-child input[type="file"]').on('change', function() {
//                         displayUploadedImage(this);
//                     });
//                 }, 500);
//             });
//         }
//     });

//     function displayUploadedImage(input) {
//         if (input.files && input.files[0]) {
//             var reader = new FileReader();

//             reader.onload = function (e) {
//                 var image = $(input).parent().siblings('.image');

//                 if (image.length > 0) {
//                     image.attr('src', e.target.result);
//                 } else {
//                     var img = $('<img class="ui small bordered image"/>');
//                     img.attr('src', e.target.result);
//                     $(input).parent().before(img);
//                 }
//             };

//             reader.readAsDataURL(input.files[0]);
//         }
//     }
// })( jQuery );

// (function($) {
//     $(document).ready(function () {
//         $(document).previewUploadedImage('#bitbag-block-image')
//     });
// })(jQuery);
