jQuery(function () {
	
var  opener = jQuery('.nav-opener');

		opener.click(function(e){
			e.preventDefault();
			opener.toggleClass('opened-burger');
		})
		jQuery('.carousel').carousel({
	  interval: 7000
	})
});

jQuery(document).ready(function(){
    resizeMobileVideoImages();
    resizeTopImage();
    
    jQuery('.tab-default').find('a').each(function(){
        jQuery(this).click(function(){
            setTimeout(resizeMobileVideoImages, 50);
        });
    })
    
    jQuery('.carousel-inner').find('.item').each(function(){
		jQuery(this).css('cursor', 'pointer');
        jQuery(this).click(function(){
            var link = jQuery(this).find('.watch-now').eq(0).find('a').attr('href');
            parent.location = link;
        });
    });
});

jQuery(window).load(function(){    
    setTimeout(function(){
    resizeMobileVideoImages();
    resizeTopImage();
    }, 400);
});

jQuery(window).resize(function(){
    resizeMobileVideoImages();
    resizeTopImage();
});

function resizeMobileVideoImages(){    
    jQuery('.news-img').each(function(){
        var width16x9 = jQuery(this).width();
        jQuery(this).height(set16x9Height(width16x9));
    });    
}

function resizeTopImage(){ 
    var windowWidth = jQuery(window).width();
    if(windowWidth < 750){ 
        jQuery('.img-holder').height(set16x9Height(windowWidth));         
    }else{
        if(windowWidth <= 767){
            jQuery('.img-holder').height(400);
        }else{
            jQuery('.img-holder').height(480);
        }
    }
}

function set16x9Height(width){
    var height = width*9/16;
    return Math.round(height);
}

var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    iPhone: function() {
        return navigator.userAgent.match(/iPhone|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};