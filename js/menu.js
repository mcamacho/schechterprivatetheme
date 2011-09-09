
jQuery(function() {
  //when page opens-----------------
  //add css style to first word main link
  $mainlinks = jQuery('#main ul.menu > li > a');
  jQuery($mainlinks).each(function(i,val){
    $linktext = jQuery(val).text();
    $firstword = $linktext.indexOf(' ') > 0 ? $linktext.substr(0,$linktext.indexOf(' ')) : $linktext ;
    $linktext = $linktext.replace($firstword,'<span>' + $firstword + '</span>');
    jQuery(val).html($linktext);
    });
  $mainlinks.find('span').css('font-weight','bold');
  //select the ul main menu that has the current-menu-item class
  jQuery('#main ul.menu')
      .children('.current-menu-item, .current-menu-ancestor')
      .css({'min-height':'79px','background-color':'#a40c34'})
      .children('a').css({'padding-top':'2px','height':'auto','color':'#ffe5ae'})
      .end()
      .find('ul').show()
      .end()
      .find('a').css({'margin-left':'5px'})
      .end()
      .find('ul ul').css({'margin-left':'10px'})
      .find('a').css({'width':'187px'});
    jQuery('.current-menu-item > a').addClass('witharrow');
  
  //interactive behavior----------------
  jQuery('#main ul.menu > li').not('li.current-menu-ancestor, li.current-menu-item').hover(
    function() {
      jQuery(this).css('background-color','#A40C34');
      jQuery('a',this).css('color','#FFE5AE');
      },
    function() {
      jQuery(this).css('background-color','#FFE5AE');
      jQuery('a',this).css('color','#731B36');
      }
    );
  
  //other functions
    jQuery('textarea[maxlength]').keyup(function(){
            var max = parseInt(jQuery(this).attr('maxlength'));
            if(jQuery(this).val().length > max){
                    jQuery(this).val(jQuery(this).val().substr(0, jQuery(this).attr('maxlength')));
            }
    });
    jQuery('div.wp-pagenavi').children()
            .not('span.pages').not(':last')
            .each(function(){jQuery(this).after('<span> | </span>');
    });
    
});
