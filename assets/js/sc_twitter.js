/**
 * Created by phuongth on 6/11/2017.
 */
(function ($) {
    $(document).ready(function () {
        $('a.fat-twitter').on('click',function(){
            var self = $(this),
                content = self.attr('data-content'),
                link = self.attr('data-link');
            var left = (screen.width/2)-(500/2);
            var top = (screen.height/2)-(450/2);
            window.open('https://twitter.com/share?url=' + link +'&amp;text=' + content,'Twitter share','width=500,height=450,resizable=0,top=' + top +',left=' + left).focus();
        });

        $('a.fat-pinterest').on('click',function(){
            var self = $(this),
                title = self.attr('data-title'),
                link = self.attr('data-link'),
                img = self.attr('data-img');
            var left = (screen.width/2)-(500/2);
            var top = (screen.height/2)-(450/2);
            window.open('http://pinterest.com/pin/create/button/?url=' + link +'&amp;description=' + title + '&amp;media=' + img,'Pinterest share','width=500,height=450,resizable=0,top=' + top +',left=' + left).focus();
        });

        $(window).scroll(function(){
            if($(window).scrollTop()>320){
                    $('.social-share.theiaStickySidebar').removeClass('pt-static');
            }else{
                $('.social-share.theiaStickySidebar').addClass('pt-static');
            }
        });
    });
}(jQuery));
