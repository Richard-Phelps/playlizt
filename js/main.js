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

    $('#search_song').keyup(function () {

        var search_term = $(this).val();

        // Prepare the request
        var request     = gapi.client.youtube.search.list({
            part: 'snippet',
            type: 'video',
            q: encodeURIComponent(search_term).replace(/%20/g, '+'),
            maxResults: 20
        });

        // Execute the request
        request.execute(function (response) {
            console.log(response);
        });

    });

})(jQuery);

/**
 * This function will validate email addresses
 */

function is_valid_email(email) {

    var email_regex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return email_regex.test(email);

}

/**
 * This will initialise the google api
 */

function init() {
    gapi.client.setApiKey('AIzaSyDZqUDzM5Iz5H4w7inMMz0Ght_hlxaheS4');
    gapi.client.load('youtube', 'v3', function () {
        console.log('YouTube API ready');
    });
}
