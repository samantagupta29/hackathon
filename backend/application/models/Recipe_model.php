<?php

use Internshala\Helpers\Aws\Kinesis_Firehose\Kinesis_Firehose_Helper;
use Internshala\Helpers\Aws\Kinesis_Firehose\Models\Admin_Access_Log;

class recipe_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', true);
	}


}
