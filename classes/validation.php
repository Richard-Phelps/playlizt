<?php
    class validation
    {

        /**
         * This method will partially sanitise the user input by stripping out malicious code
         *
         * @param  $input (string): The unsanitised user input
         * @return $string
         */

        public function sanitise_input($input)
        {

            $search = [
                '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
                '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
                '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
            ];

            $output = preg_replace($search, '', $input);

            return $output;

        }

        /**
         * This method will further sanitise the user input so it's safe to use when querying the database
         *
         * @param  $input (string): The partially sanitised user input
         * @return $string
         */

        public function sanitise($input)
        {

            if (is_array($input)) {

                foreach ($input as $var => $val) {
                    $output[$var] = $this->sanitise($val);
                }

            } else {

                if (get_magic_quotes_gpc()) {
                    $input = stripslashes($input);
                }

                $output  = $this->sanitise_input($input);

            }

            return $output;

        }

    }
?>
