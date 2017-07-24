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
    $('.create-playlist-search-results').hide();

    $('#add_video').on('click', function () {

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
    });

}
