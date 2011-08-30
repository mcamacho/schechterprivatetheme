jQuery('a.lightbox').click(function(event){
    event.preventDefault();
    $content = jQuery(this).siblings('ul').html();
    jQuery.colorbox({title:'<ul>'+ $content +'</ul>', href:jQuery(this).attr('href')});
});