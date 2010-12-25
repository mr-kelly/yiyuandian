<?php
	
	
	/**
	 *	出价模型~
	 */
	class Bid_Model extends KK_Model {
	
		function add( $data ) {
			$this->db->insert('bid', $data + array(
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
		}
		
	}
