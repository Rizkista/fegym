(function ($) {
    $('.img-popup a').on('click', function(e){
        e.preventDefault();
        var imgLink = $(this).children('img').attr('src');
        $('.mask').html('<div class="img-box"><img src="'+ imgLink +'"><a class="close">&times;</a>');
        $('.mask').attr('style','display: block !important;');
        $('.close').on('click', function(){
            $('.mask').attr('style','');
        });
    });
})(jQuery);
