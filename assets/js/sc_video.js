/**
 * Created by phuongth on 6/7/2017.
 */
var fat_video_player = [];
(function ($) {
    $(document).ready(function () {

        $('.fat-sc-video[data-type="vimeo"]').each(function () {
            var iframe = $('iframe', this),
                video_container = $(this).closest('.fat-sc-video-container'),
                playButton = $('a.fat-sc-video-icon.icon-play', video_container),
                pauseButton = $('a.fat-sc-video-icon.icon-pause', video_container),
                player = new Vimeo.Player(iframe);

            player.on('play', function () {
                playButton.fadeOut(400, function () {
                    video_container.removeClass('pause').addClass('play');
                });
            });
            player.on('pause', function () {
                pauseButton.fadeOut(function () {
                    playButton.fadeIn(400);
                    video_container.removeClass('play').addClass('pause');
                });
            });
        });

        $('.fat-sc-video[data-type="vimeo"] a.fat-sc-video-icon').off('click').on('click', function () {
            var self = $(this),
                video_container = self.closest('.fat-sc-video-container'),
                video_type = $('.fat-sc-video', video_container).attr('data-type'),
                iframe = $('iframe', video_container),
                video_src = iframe.attr('src');

            if (video_type === 'vimeo') {
                var player = new Vimeo.Player(iframe);
                if (self.hasClass('icon-play')) {
                    player.play();
                    video_container.removeClass('pause').addClass('play');
                }
                if (self.hasClass('icon-pause')) {
                    player.pause();
                    video_container.removeClass('play').addClass('pause');
                }
            }
        });

    });
}(jQuery));

function onYouTubeIframeAPIReady() {
    jQuery('.fat-sc-video[data-type="youtube"]').each(function () {
        var self = jQuery(this),
            iframe_id = self.attr('data-iframe-id'),
            video_id = self.attr('data-video-id'),
            autoplay = self.attr('data-autoplay'),
            fullscreen = self.attr('data-allow-full-screen'),
            show_info = self.attr('data-show-info'),
            show_control = self.attr('data-show-control');

        autoplay = typeof autoplay != 'undefined' && autoplay !== '' ? autoplay : 0;
        show_info = typeof show_info != 'undefined' && show_info !== '' ? show_info : 0;
        show_control = typeof show_control != 'undefined' && show_control !== '' ? show_control : 0;
        fullscreen = typeof fullscreen != 'undefined' && fullscreen !== '' ? fullscreen : 0;
        var player = new YT.Player(iframe_id, {
            height: '390',
            width: '640',
            videoId: video_id,
            playerVars: {
                'autoplay': autoplay,
                'fs': fullscreen,
                'showinfo': show_info,
                'controls': show_control,
                'rel': 0,
                'autohide': 2,
                'modestbranding': 1,
                'version' : 3,
                'hd' : 1,
                'color': 'white'
            },
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    });
}

function onPlayerReady(event) {
    jQuery('.fat-sc-video[data-type="youtube"] a.fat-sc-video-icon').on('click', function () {
        var self = jQuery(this),
            video_container = self.closest('.fat-sc-video-container');

        if (self.hasClass('icon-play')) {
            self.fadeOut();
            jQuery('a.fat-sc-video-icon.icon-play', video_container).hide();
            jQuery('a.fat-sc-video-icon.icon-loading', video_container).show();
            event.target.playVideo();
        }
    });
    jQuery('.fat-youtube-screenshot','.fat-sc-video').on('click',function(){
        var self = jQuery(this),
            video_container = self.closest('.fat-sc-video-container');
        jQuery('a.fat-sc-video-icon.icon-loading', video_container).show();
        event.target.playVideo();
    })
}

function onPlayerStateChange(event) {
    var container = jQuery('#' + event.target.a.id).closest('.fat-sc-video-container'),
        data_show_control = jQuery('.fat-sc-video',container).attr('data-show-control');

    if(event.data == YT.PlayerState.BUFFERING){
        jQuery('a.fat-sc-video-icon.icon-play', container).hide();
        jQuery('a.fat-sc-video-icon.icon-pause', container).hide();
    }

    if (event.data == YT.PlayerState.PLAYING) {
        jQuery('img.fat-youtube-screenshot', container).hide();
        jQuery('a.fat-sc-video-icon', container).hide();
        jQuery('body').addClass('video-playing');
        jQuery('.video-time').hide();
    }

    if (event.data == YT.PlayerState.PAUSED) {
        jQuery('body').removeClass('video-playing');
        jQuery('a.fat-sc-video-icon.icon-loading', container).hide();
        if(data_show_control !='1'){
            var currentTimeMinute = Math.floor(event.target.getCurrentTime() / 60) ,
                currentTimeSecond = Math.floor(event.target.getCurrentTime() % 60),
                duration = Math.floor(event.target.getDuration() / 60) + ':' + Math.floor(event.target.getDuration() % 60),
                time_play = currentTimeMinute;

            if(currentTimeSecond<10){
                time_play += ':0' + currentTimeSecond;
            }else{
                time_play += ':' + currentTimeSecond;
            }
            time_play +=' / ' + duration;
            jQuery('.video-time').text(time_play);
            jQuery('.video-time').show();
        }

    }
    if (event.data == YT.PlayerState.ENDED) {
        jQuery('img.fat-youtube-screenshot', container).show();
        jQuery('a.fat-sc-video-icon.icon-play', container).fadeIn();
        jQuery('body').removeClass('video-playing');
    }
}
