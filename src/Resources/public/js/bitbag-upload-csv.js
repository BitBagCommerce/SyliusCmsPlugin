/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

(function($) {
    $('.bitbag-cms-import input[type="text"]').click(function() {
        $(this).parent().find('input[type="file"]').click();
    });

    $('.bitbag-cms-import input[type="file"]')
        .on('change', function(element) {
            var name = element.target.files[0].name;
            $('input[type="text"]', $(element.target).parent()).val(name);
        });

})( jQuery );
