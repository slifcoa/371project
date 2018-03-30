<?php
	class Constants {

		
	function __construct($clientURL)
        {
                $this->HOSTNAME=$clientURL;
        }

		public $HOSTNAME = "";
		public $KEY = 'fc06f2ab-41d4-4555-aabf-7f4050fdc26d';
		public $SECRET = '8MmYjh8fojmTwy4pHKlxBwsVyFTxb38c';

		public $AUTH_PATH = '/learn/api/public/v1/oauth2/token';
		public $DSK_PATH = '/learn/api/public/v1/dataSources';
		public $TERM_PATH = '/learn/api/public/v1/terms';
		public $COURSE_PATH = '/learn/api/public/v1/courses';
		public $USER_PATH = '/learn/api/public/v1/users';
		//public $ROLE_PATH = '';		

		public $ssl_verify_peer = FALSE;
		public $ssl_verify_host =  FALSE;
	}
?>
