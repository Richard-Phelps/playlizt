/**
 * This function will validate email addresses
 */

function is_valid_email(email) {

    var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return email_regex.test(email);

}

(function ($) {

    /**
     * Functionality to show errors when the create playlist form has empty fields
     */

    $('#start-playlist').on('submit', function () {

        var playlist_name  = $('#playlist_name');
        var playlist_email = $('#playlist_email');

        // If the playlist name is empty, show the field error
        if (playlist_name.val() == '') {

            playlist_name.addClass('invalid');
            $('label[for=playlist_name]').addClass('active').focus();

            return false;

        }

        // If the user email is empty, show the field error
        if (playlist_email.val() == '') {

            playlist_email.addClass('invalid');
            $('label[for=playlist_email]').addClass('active').focus();

            return false;

        }

        if (!is_valid_email(playlist_email.val())) {

            playlist_email.addClass('invalid');
            $('label[for=playlist_email]').attr('data-error', 'Sorry, that is not a valid email address').addClass('active').focus();

            return false;

        }

    });

    /**
     * This will fade the alert box out
     */

    $('#alert-close').on('click', function () {
        $('#alert-box').fadeOut('slow');
    });

    /**
     * This is the code to search youtube for videos
     */

    var typing_timer;
    var done_typing_interval = 500;

    $('#search_song').on('keyup', function () {

        clearTimeout(typing_timer);

        typing_timer = setTimeout(function () {

            var search_term = $('#search_song').val();
            $.get('https://www.googleapis.com/youtube/v3/search', {key: 'AIzaSyDZqUDzM5Iz5H4w7inMMz0Ght_hlxaheS4', part: 'snippet', type: 'video', q: search_term, maxResults: 20}, function (response) {

                if (response.items) {

                    $('.create-playlist-search-results').show().html('');

                    $.each(response.items, function (i, item) {

                        var video_id            = item.id.videoId;
                        var video_title         = item.snippet.title;
                        var video_thumbnail     = item.snippet.thumbnails.default.url;
                        var autocomplete_result = '<li onclick="selected_video(\'' + video_id + '\')" yt-id=' + video_id + '><img src="' + video_thumbnail + '" alt="' + video_title + '" /><span class="main-text-important">' + video_title + '</span></li>';

                        $('.create-playlist-search-results').append(autocomplete_result);

                    });
                }

            });

        }, done_typing_interval);

    });

    $('#search_song').on('keydown', function () {
        clearTimeout(typing_timer);
    });

    /**
     * This will hide the autosuggesst box when the page is clicked anywhere outside of the autosuggest box
     */

    $(document).on('click', function () {
        $('.create-playlist-search-results').hide();
    });

    $('.create-playlist-search-results').on('click', function (e) {
        e.stopPropagation();
        return false;
    });

    /**
     * Couple of variable for the playlist
     */

    window.playing_count = 1;
    window.repeat        = false;
    window.loop_current  = false;
    var player;

    /**
     * When the repeat playlist option is selected, make it active and set repeat to true
     */

    $('#repeat-playlist').on('click', function () {

        $('#replay').hide();
        $('#loop-current').show();

        if (!$(this).hasClass('playlist-option-active')) {
            window.repeat = true;
            $(this).addClass('playlist-option-active');
        } else {
            window.repeat = false;
            $(this).removeClass('playlist-option-active').removeClass('main-text-hover-important');
        }

        // If the playlist finished without repeat on
        if (window.playing_count == 0) {
            window.playing_count = 1;
            onYouTubeIframeAPIReady(videos[window.playing_count].video_id, videos[window.playing_count].start);
        }

    });

    $('#repeat-playlist').hover(function () {
        if (!$(this).hasClass('main-text-hover-important') && !$(this).hasClass('playlist-option-active')) {
            $('#repeat-playlist').addClass('main-text-hover-important');
        }
    });

    /**
     * When the loop current video option is selected, make it active and set loop to true
     */

    $('#loop-current').on('click', function () {

        if (!$(this).hasClass('playlist-option-active')) {
            window.loop = true;
            $(this).addClass('playlist-option-active');
        } else {
            window.loop = false;
            $(this).removeClass('playlist-option-active').removeClass('main-text-hover-important');
        }

    });

    $('#loop-current').hover(function () {
        if (!$(this).hasClass('main-text-hover-important') && !$(this).hasClass('playlist-option-active')) {
            $('#loop-current').addClass('main-text-hover-important');
        }
    });

    // When the playlist finished without repeat on and the repeat button is clicked, start from the beginning
    $('#replay').on('click', function () {

        if (window.playing_count == 0) {
            window.playing_count = 1;
            onYouTubeIframeAPIReady(videos[window.playing_count].video_id, videos[window.playing_count].start);
            $(this).hide();
            $('#loop-current').show();
        }

    });

    /**
     * When the play video button is clicked, play the video
     */

    $('.play-video').on('click', function () {

        window.playing_count = $(this).attr('vid-count');
        onYouTubeIframeAPIReady(videos[window.playing_count].video_id, videos[window.playing_count].start);
        $('#replay').hide();
        $('#loop-current').show();

    });

})(jQuery);

/**
 * This function will post to a script which will save the video details
 *
 * @param video_id: The id of the video to save
 */

function selected_video(video_id) {

    var $           = jQuery;
    var video_title = $('li[yt-id=' + video_id + ']').html();

    // Show preview of the video
    $('.selected-video-preview-container').show();
    $('#selected-video-preview').html('<iframe src="https://www.youtube.com/embed/' + video_id + '?vq=small" style="selected-video-preview"></iframe>');
    $('#add_video').attr('vid-id', video_id);
    $('.create-playlist-search-results').hide();
    $('#video_start').val('');

    $('#add_video').on('click', function () {

        if (video_id == $(this).attr('vid-id')) {

            var start = $('#video_start').val();

            if (start == '') {
                var start = 0;
            }

            var playlist_id = $('#playlist_id').html();

            // Send data to file to save in database
            $.get('../save-video.php', {video_posted: 'true', playlist_id: playlist_id, video_id: video_id, start: start}, function (data) {

                // If the video was successfully added
                if (data == 'success') {

                    $('.selected-video-preview-container').hide();

                    var added_video_html = '<div class="song-container smooth-box-shadow white-bg"><p class="margin0 main-text">' + video_title + '</p></div>';

                    // Remove the no videos added message and append the video that has been added and remove disabled class from finish creating playlist button
                    $('.no-videos-added').remove();
                    $('.videos-added-container').append(added_video_html);
                    $('#finish-creating-playlist-btn').removeClass('disabled');

                }

            });

        }

    });

}

/**
 * This will create the iframe to play the youtube video
 */

var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

/**
 * This function will setup the video in the iframe
 *
 * @param video_id: This is the id for the next video to be played
 * @param start   : This is the amount of seconds to start the next video at
 */

function onYouTubeIframeAPIReady(video_id, start) {

    if (typeof videos !== 'undefined') {

        // Remove main-bg from all song-container elements and add white-bg then add main-bg to the active song element and remove white-bg
        $('.song-container').removeClass('main-bg').addClass('white-bg');
        $('.song-container[vid-count=' + window.playing_count + ']').removeClass('white-bg').addClass('main-bg');

        // Remove white-text from all song-container p elements and add main-text then add white-text to the active song element and remove main-text
        $('.song-container > p').removeClass('white-text').addClass('main-text');
        $('.song-container[vid-count=' + window.playing_count + '] > p').removeClass('main-text').addClass('white-text');

        // Remove white-text from all song-container p span elements and add main-text-important then add white-text to the active song element and remove main-text-important
        $('.song-container > p > span').removeClass('white-text').addClass('main-text-important');
        $('.song-container[vid-count=' + window.playing_count + '] > p > span').removeClass('main-text-important').addClass('white-text');

        if (!video_id && !start) {

            // Initiate the video video in the playlist
            player = new YT.Player('player', {
                playerVars: {start: videos[window.playing_count].start},
                videoId   : videos[window.playing_count].video_id,
                events    : {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });

        } else {

            // Play the next video in the playlist
            player.loadVideoById({
                'videoId'         : video_id,
                'startSeconds'    : start,
            });

        }

    }

}

/**
 * This function will execute when the youtube video is ready to play
 *
 * @param event: The current event
 */

function onPlayerReady(event) {
    event.target.playVideo();
}

/**
 * This function will execute when the currently playing video is finished
 *
 * @param event: The current event
 */

function onPlayerStateChange(event) {

    // If the video currently being played is finished
    if (event.data == 0) {

        // If loop current video has been turned on, don't go to the next video
        if (!window.loop) {
            window.playing_count = (parseInt(window.playing_count) + 1);
        }

        if (window.playing_count != 0) {

            // If the final video in the playlist has finished
            if (typeof videos[window.playing_count] === 'undefined') {

                // Only go back to the first video if loop is set to true
                if (window.repeat) {

                    window.playing_count = 1;

                } else {

                    window.playing_count = 0;

                    // Hide the loop current button
                    $('#loop-current').hide();

                    // Show the replay playlist button
                    $('#replay').show();

                }

            }

            // Play the next video
            onYouTubeIframeAPIReady(videos[window.playing_count].video_id, videos[window.playing_count].start);

        }

    }

}

/**
 * This function will execute when the user stops playing the video
 */

function stopVideo() {
    player.stopVideo();
}
