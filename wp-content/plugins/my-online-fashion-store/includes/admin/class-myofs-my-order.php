<?php
class MYOFS_My_Order  extends MYOFS_API{

	public function __construct(){
		
	}
	public function getMyOrderSearchData(){
		global $wpdb;

		if (isset($_GET['page']) && !empty($_GET['page'])){ $page = $_GET['page']; }else{ $page = 1; }
		$per_page       = 10;
		$previous_btn   = true;
		$next_btn       = true;
		$first_btn      = true;
		$last_btn       = true;
		$start          = ($page - 1) * $per_page;
		$showpagi       = 0;
        $uids           = array();
        $posts          = $wpdb->prefix . "posts";
        $posts_meta     = $wpdb->prefix . "postmeta";
        $users          = $wpdb->prefix . "users";
        $order_item     = $wpdb->prefix . "woocommerce_order_items";
        $order_itemmeta = $wpdb->prefix . "woocommerce_order_itemmeta";
        $inventorypro   = $wpdb->prefix . "myofs_products";
        $left           = '';
        $qr             = '';
        $order_html = $ordritem_html  = '';
        if (isset($_GET['search']) && !empty($_GET['search'])) {
        	$search = $_GET['search'];
        	if (DateTime::createFromFormat('F j, Y, g:i a', $search) !== false || 
        		DateTime::createFromFormat('F', $search) !== false || 
        		DateTime::createFromFormat('j', $search) !== false || 
        		DateTime::createFromFormat('Y', $search) !== false  || 
        		DateTime::createFromFormat('g:i', $search) !== false || 
        		DateTime::createFromFormat('a', $search) !== false || 
        		DateTime::createFromFormat('g:i a', $search) !== false  || 
        		DateTime::createFromFormat('F j, Y', $search) !== false) {			  
       			$qr .= " AND p.`post_date` LIKE '%date('Y-m-d H:i:s',$search)%'";     			
			}else{       		      			
       			$user_res = $wpdb->get_results("SELECT ID FROM $users WHERE user_email LIKE '%$search%' ORDER BY ID ASC",ARRAY_A);
       			for ($ii=0; $ii <count($user_res) ; $ii++) { 
       				array_push($uids, $user_res[$ii]['ID']);
       			}
       			$ids = implode(",",$uids);
       			$qr .= " AND (pm.`meta_key` = '_customer_user' AND pm.`meta_value` IN($ids))";
			}			
        }        

        $where = "p.`post_status` IN ('wc-pending','wc-processing','wc-on-hold','wc-completed','wc-cancelled','wc-refunded','wc-failed') AND p.`post_type` = 'shop_order'";        

        /*check inventory product or not*/        
        /*$oileft  = "LEFT JOIN $order_item woi ON p.ID = woi.order_id LEFT JOIN $order_itemmeta woim ON woi.order_item_id = woim.order_item_id ";
		$oiqr = " AND woim.`meta_key` = '_product_id'";
		$oiwhere = $where.$oiqr;
        $orderitemdata = $wpdb->get_results("SELECT woim.`meta_value` as product_id, p.`ID` FROM $posts p $oileft WHERE $oiwhere ",ARRAY_A);
        $invpro = $wpdb->get_results("SELECT wc_product_id FROM `wp_myofs_products`",ARRAY_A);
        
        $noinventorypro = array();
        $invproduct     = array();
        for ($ip=0; $ip <count($invpro); $ip++) { 
        	array_push($invproduct, $invpro[$ip]['wc_product_id']);
        	if ($invpro[$ip]['wc_product_id'] != $orderitemdata[$ip]['product_id']) {
        		array_push($noinventorypro,$orderitemdata[$ip]['ID']);		
        	}
        }
        $ninvpro = implode(',', array_unique($noinventorypro));*/
        /* end check inventory product or not*/
        $orderwhere = $where.$qr/*." AND p.ID  NOT IN ($ninvpro)"*/;
        $left .= "LEFT JOIN $posts_meta pm ON p.ID = pm.post_id ";
        $query = "SELECT p.`ID`,p.`post_date`,p.`post_status`,pm.* FROM $posts p $left WHERE $orderwhere";
        $count     = $wpdb->get_results($query." GROUP BY p.ID");
        $total_row = count($count);
        $orderdata = $wpdb->get_results($query." GROUP BY p.ID ORDER BY p.ID DESC LIMIT $start, $per_page");

		if (isset($orderdata) && !empty($orderdata)) {
			$orderarray = $products = array();
			$shipping_address = '';
			foreach ($orderdata as $ordervalue) {
		        $order = wc_get_order($ordervalue->ID);
				$user_data = $order->get_user();
					
		        switch($ordervalue->post_status) :      
					case 'wc-pending':
						$status = 'Pending payment';
						break;
					case 'wc-on-hold':
						$status = 'On hold';
						break;
					case 'wc-completed':
						$status = 'Completed';
						break;
					case 'wc-cancelled':						
						$status = 'Cancelled';
						break;
					case 'wc-refunded':						
						$status = 'Refunded';
						break;
					case 'wc-failed':						
						$status = 'Failed';
						break;
				  	default:
						$status = 'Processing';
					
						break;
				endswitch; 
				$totalcal = 0;
				foreach ( $order->get_items() as $item_id => $item ) {
					$product_id = $item->get_product_id();
					$product    = $item->get_product();
					$itemprice  = ($item->get_subtotal()/$item->get_quantity());
					$products[] = array(
							'item_name' => esc_html($item->get_name()),
							'item_price' => esc_html(number_format($itemprice,2)),
							'item_qty' => esc_html($item->get_quantity()),
					);					
					$totalcal = $totalcal +($itemprice*$item->get_quantity());
				}
				$total = number_format($totalcal, 2);
				if ($total > 0) {
					
					if ($order->get_shipping_address_1() != '') {
						
						$shipping_address = esc_html($order->get_shipping_address_1()).' '.esc_html($order->get_shipping_address_2()).',<br>'.esc_html($order->get_shipping_city()).','.esc_html($order->get_shipping_state()).',<br>'.esc_html($order->get_shipping_country()).'-'.esc_html($order->get_shipping_postcode());
					}
					$billing_address = esc_html($order->get_billing_address_1()).' '.esc_html($order->get_billing_address_2()).',<br>'.esc_html($order->get_billing_city()).','.esc_html($order->get_billing_state()).',<br>'.esc_html($order->get_billing_country()).'-'.esc_html($order->get_billing_postcode());				
					$orderarray[] = array(
						'ID' => $ordervalue->ID,
						'date'=> date('F j, Y, g:i a',strtotime($ordervalue->post_date)),
						'user_email'=> $user_data->data->user_email,
						'status'=> $status,
						'items' => $products,
						'total' => $total,
						'currency' => $order->get_currency(),
						'payment'  => $order->get_payment_method_title(),
						'shipping_info'  => array(
							'name' => $order->get_shipping_first_name().' '.$order->get_shipping_last_name(),
							'company' => $order->get_shipping_company(),
							'address' => $shipping_address,
						),
						'billing_info'  => array(
							'name' => $order->get_billing_first_name().' '.$order->get_billing_last_name(),
							'company' => $order->get_billing_company(),
							'address' => $billing_address,
							'phone_no' => $order->get_billing_phone(),
						),
					);
				}
				
			}
			$response['status'] = 1;
			$response['data']   = $orderarray;        	
		}else{     
			$showpagi = 1;
			$response['status'] = 0;
		}
		if ($showpagi == 0 && $total_row > $per_page) {
	        $no_of_paginations = ceil($total_row / $per_page);
	        /* Pagination */
	        $pagination = array(
	            "cur_page" => $page,
	            "no_of_paginations" => $no_of_paginations,
	            "first_btn" => $first_btn,
	            "previous_btn" => $previous_btn,
	            "last_btn" => $last_btn,
	            "next_btn" => $next_btn
	        );
	        $pagination_html = MYOFS_API::Pagination($pagination);
	    } else {
	        $pagination_html = "";
	    }              
	    
	    $response['pagination']   = $pagination_html;
	    echo json_encode($response);
	    exit;

	}	

}
?>