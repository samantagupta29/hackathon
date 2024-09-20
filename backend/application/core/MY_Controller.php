<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public $user_id;

	public function __construct() {
		parent::__construct();
		$this->user_id = 1;
	}
}
