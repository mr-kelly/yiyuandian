<?php

	class Product_Model extends KK_Model {
	
		function add( $data ) {
			$this->db->insert('products', $data + array(
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
		}
		
		
		/**
		 *	根据$which查询数据库,获取一系列数据
		 */
		function get( $which ) {
			$query = $this->db->get_where('products', $which );
			
			return $query->result_array();
			
		}
		
		
		/**
		 *	获取单条数据~ 传入ID
		 */
		function get_product_by_id( $product_id ) {
			$query = $this->db->get_where('products', array(
				'id' => $product_id,
			));
			
			if ( $query->num_rows() == 1 ) {
				return $query->row_array();
			} else {
				exit( 'Model query not single!' );
			}
		}
	
	}
