<?php
    class errors
    {

        /**
         * Constructor
         */

        public function __construct()
        {

            $this->session_has_errors = $this->session_has_errors();
            $this->errors             = $this->get_errors();

        }

        /**
         * This method will check the errors cookie and return true or false if there are any errors
         *
         * @return boolean
         */

        public function session_has_errors()
        {

            $errors_cookie = $_SESSION['errors'];

            // Check if the errors cookie is set
            if (isset($errors_cookie) && !empty($errors_cookie)) {
                return true;
            } else {
                return false;
            }

        }

        /**
         * This method will add an error to the list
         *
         * @param $error (string): The message to display for the error
         */

        public function add_error($error)
        {

            $this->erorr    = true;
            $this->errors[] = $error;

            $this->set_errors();

        }

        /**
         * This method will add / update the errors cookie
         */

        public function set_errors()
        {

            $_SESSION['errors'] = json_encode($this->errors);

        }

        /**
         * This method will get all of the error in the session
         *
         * @return array
         */

        public function get_errors()
        {

            $error_cookie = $_SESSION['errors'];
            $this->errors = json_decode($error_cookie);

            return $this->errors;

        }

        /**
         * This method will remove all errors in the sesssion
         */

        public function reset()
        {

            $_SESSION['errors'] = '';

        }

    }
?>
