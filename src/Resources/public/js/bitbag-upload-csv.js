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
