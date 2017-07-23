/**
 * This function will validate email addresses
 */

function is_valid_email(email) {

    var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return email_regex.test(email);

}

// /**
//  * This will initialise the google api
//  */
//
// function init() {
//     gapi.client.setApiKey('AIzaSyDZqUDzM5Iz5H4w7inMMz0Ght_hlxaheS4');
//     gapi.client.load('youtube', 'v3', function () {
//         console.log('YouTube API ready');
//     });
// }

(function ($) {

    /**
     * Functionality to show errors when the create playlist form has empty fields
     */

    $('#start-playlist').submit(function () {

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

    $('#alert-close').click(function () {
        $('#alert-box').fadeOut('slow');
    });

    /**
     * This is the code to search youtube for videos
     */

    var typing_timer;
    var done_typing_interval = 500;

    $('#search_song').keyup(function () {

        clearTimeout(typing_timer);

        typing_timer = setTimeout(function () {

            var search_term = $('#search_song').val();
            $.get('https://www.googleapis.com/youtube/v3/search', {key: 'AIzaSyDZqUDzM5Iz5H4w7inMMz0Ght_hlxaheS4', part: 'snippet', type: 'video', q: search_term, maxResults: 20}, function (response) {

                if (response.items) {

                    $('.create-playlist-search-results').html('');

                    $.each(response.items, function (i, item) {

                        var video_id            = item.id.videoId;
                        var video_title         = item.snippet.title;
                        var video_thumbnail     = item.snippet.thumbnails.default.url;
                        var autocomplete_result = '<li onclick="selected_video(\'' + video_id + '\')"><img src="' + video_thumbnail + '" alt="' + video_title + '" /><span>' + video_title + '</span></li>';

                        $('.create-playlist-search-results').append(autocomplete_result);

                    });
                }

            });

        }, done_typing_interval);

    });

    $('#search_song').keydown(function () {
        clearTimeout(typing_timer);
    });

})(jQuery);

/**
 * This function will post to a script which will save the video
 *
 * @param video_id: The id of the video to save
 */

function selected_video(video_id) {
    var $ = jQuery;
}
