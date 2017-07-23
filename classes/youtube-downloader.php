<?php
    class youtube_downloader extends yt_downloader
    {

        /**
         * Constructor
         *
         * @param $video_id: The id for the youtube video selected by the user
         */

        public function __construct($video_id)
        {

            $this->video_id = $video_id;

        }

    }
?>
