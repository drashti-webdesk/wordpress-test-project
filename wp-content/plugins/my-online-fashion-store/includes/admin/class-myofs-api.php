<?php
class MYOFS_API{ 
	public function __construct(){
	}
	private function authentication(){
		$get_opt = maybe_unserialize(get_option('myofs_opt_data'));
		$token   = base64_decode($get_opt['authantication']);
		return base64_decode($token);
	}
	/*
	* API Curl Request Method
	*/
	private function callAPI($method, $path, $data){
		$response   = array();
		$keysencode = base64_encode($this->authentication().':'.get_site_url());
		$auth = array('Authorization: Basic '.$keysencode);
		$curl = curl_init();		  
		switch ($method){
		  	case "POST":
				curl_setopt($curl, CURLOPT_POST, 1);
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					$url = sprintf("%s?%s", MYOFS_API_PATH.$path, http_build_query($data));
				break;
		  	case "PUT":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);	
					$url = sprintf("%s", MYOFS_API_PATH.$path);

				break;
			case "DELETE":
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
				if ($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
					$url = sprintf("%s", MYOFS_API_PATH.$path);

				break;
		  default:
			if ($data == 1){
				$url = sprintf("%s", MYOFS_API_PATH.$path);
			}else{
				$url = sprintf("%s?%s", MYOFS_API_PATH.$path, http_build_query($data));
			}
		}
		// OPTIONS:           
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $auth);
	
		// EXECUTE:
		$curl_result = curl_exec($curl);

		/* 
	    * Check for 404 (file not found). 
	    */
	    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	    // Check the HTTP Status code
	    switch ($httpCode) {
	        case 200:
	            $status_code = array(200 => "Success");
	            break;
	        case 404:
	            $status_code = array(404 =>"API Not found");
	            break;
	        case 500:
	            $status_code = array(500 =>"servers replied with an error.");
	            break;
	        case 502:
	            $status_code = array(502 =>"servers may be down or being upgraded. Hopefully they'll be OK soon!");
	            break;
	        case 503:
	            $status_code = array(503 => "service unavailable. Hopefully they'll be OK soon!");
	            break;
	        default:
	            $status_code = array($httpCode => "Undocumented error: " . $httpCode . " : " . curl_error($curl));
	            break;
	    }
	    if (isset($curl_result) && !empty($curl_result)) {
    		$curl_json = json_decode($curl_result, true);
			$response['data']   = $curl_json;
	    }else{
	    	$response['error']  = 'Data Not Found';
	    }
		curl_close($curl);

	 	$response['status_code'] = $status_code;	   	
	    return $response;
	}
	/*
	* Get Activation Plan
	*/
	public function GetActivationPlan($qry_str){
        $get_data = $this->callAPI('POST', 'Purchase/gettoken', $qry_str);
		return $get_data;  
	}
	/*
	* Get Subscription Plane Information
	*/
	public function GetMyAccount(){ 
		$qry_str = array('auth_token'=> $this->authentication());
        $get_data = $this->callAPI('POST', 'Account', $qry_str);
		return $get_data;  
	}
	/*
	* Get Inventory All Products Details
	*/
	public function GetAllProducts($qry_str){
		$filter = array_filter($qry_str);
		$user   = array('user_id' => MYOFS_API_ID);
		$queryStrMerge = array_merge($user,$filter);
		$get_data = $this->callAPI('GET', 'products',$queryStrMerge );	
		return $get_data;
	}
	/*
	* Get My Inventory Products Details
	*/
	public function GetMyInventory($qry_str){
		$filter = array_filter($qry_str);
		$user   = array('user_id' => MYOFS_API_ID);
		$queryStrMerge = array_merge($user,$filter);
		$get_data = $this->callAPI('GET', 'products/getMyProducts',$queryStrMerge );	
		return $get_data;
	}
	/*
	* Get Inventory Single Product Details 
	*/
	public function GetSingleProduct($product_id){
		
		$queryStr = array('user_id' => MYOFS_API_ID,'product_id' => $product_id);
		$get_data = $this->callAPI('GET', 'products/getProduct',$queryStr );	
		return $get_data;
	}
	/*
	* Get Inventory Categories
	*/
	public function GetAllCategories(){
		$get_data = $this->callAPI('GET', 'categories', true);
		return $get_data;
	}
	/*
	* Get Marketing Material Banner Details
	*/
	public function GetMarketingMaterial(){
        $get_data = $this->callAPI('GET', 'marketing', true);
		return $get_data;  
	}
	
	/*
	* get woocommerce store categories
	*/
	public function GetStoreCategories(){
		/*$get_data = $this->callAPI('GET', 'WcStoreCategories', true);
		return $get_data;*/
		$consumer_key    = "ck_2faa4e4648ffd6a9f0a0b87c32bc1a39b26b1b50";
		$consumer_secret = "cs_b336c67bb4e8a94c11366b4c8ebcd2dad27f2aea";
		$keysencode = base64_encode($consumer_key.':'.$consumer_secret);
		$auth = 'Authorization: Basic '.$keysencode;
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://wdszone.com/WP/wp_demo/wp-json/wc/v3/products/categories',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				$auth
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		$curlresponse = json_decode($response);
		return $curlresponse;

	}
	/*
	* Create Single/Bulk Product on the woocommerce
	*/
	public function AddProducttoStore($qry_str){
		$get_data = $this->callAPI('POST', 'products/item_addtowix', $qry_str);
		return $get_data;  	
	}
	/*
    *Remove Single/Bulk Product on the woocommerce
    */
	public function RemoveProducttoStore($qry_str){

		$get_data = $this->callAPI('POST', 'products/itemremove', $qry_str);
		return $get_data; 
	}
	/*
    * Create Combine Product on the woocommerce
    */
	public function CombineProducts($qry_str){
		$get_data = $this->callAPI('POST', 'products/checkCombineProduct', $qry_str);
		return $get_data; 
	}

	/*
	* Submit Return Page form
	*/
	public function ReturnFormSubmit($qry_str){
		$get_data = $this->callAPI('POST', 'Returnemail', $qry_str);
		return $get_data;  
	}
	/*
	* Store Generated woocommerce Rest API Keys
	*/
	public function StoreGeneratedWcRestApiKeys($email){
		$get_data = '';
		/*$qry_str  = $this->GenerateWcRestApiKeys();
		  $qry_str['email'] = $email;
		$get_data = $this->callAPI('POST', 'WcRestApiKeys', $qry_str);*/
		return $get_data; 
	}
	/*
	* Generate woocommerce Rest API Keys
	*/
	private function GenerateWcRestApiKeys(){
		global $wpdb;
		update_option('woocommerce_api_enabled','yes',true);
		$consumer_key    = 'ck_' . wc_rand_hash();
		$consumer_secret = 'cs_' . wc_rand_hash();
		$user_id         = get_current_user_id();
		$store_url       = get_site_url();
		$description     = MYOFS_PLUGIN_NAME;
		$permissions     = 'read_write';
		$data = array(
			'user_id'         => $user_id,
			'description'     => $description,
			'permissions'     => $permissions,
			'consumer_key'    => hash_hmac( 'sha256', $consumer_key, 'wc-api' ),
			'consumer_secret' => $consumer_secret,
			'truncated_key'   => substr( $consumer_key, -7 ),
		);

		$wpdb->insert(
			$wpdb->prefix . 'woocommerce_api_keys',
			$data,
			array('%d','%s','%s','%s','%s','%s')
		);
		$key_id                      = $wpdb->insert_id;
		$response                    = array();
		$response['consumer_key']    = $consumer_key;
		$response['consumer_secret'] = $consumer_secret;
		$response['store_url']       = $store_url;
		return $response;
	}
	/*
	* Pagination on the inventory
	*/
	public function Pagination($pagination) {
	    extract($pagination);
	    $pag_container = "";
	    if ($cur_page >= 3) {
	        $start_loop = $cur_page;
	    	
	        if ($no_of_paginations > $cur_page + 2){
	            $end_loop = $cur_page + 2;
	        }else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 2) {
	            $start_loop = $no_of_paginations - 2;
	            $end_loop = $no_of_paginations;
	        } else {
	            $end_loop = $no_of_paginations;
	        }
	    } else {
	        $start_loop = 1;
	        if ($no_of_paginations > 3){

	            $end_loop = 3;
	        }else{

	            $end_loop = $no_of_paginations;
	        }
	    }
	    $pag_container .= "<div class='myofs-pagination'>
	        <ul>";
	    if ($first_btn && $cur_page > 1) {
	        $pag_container .= "<li p='1' class='active'> « First </li>";
	    } else if ($first_btn) {
	        $pag_container .= "<li p='1' class='inactive'> « First </li>";
	    }
	    if ($previous_btn && $cur_page > 1) {
	        $pre = $cur_page - 1;
	        $pag_container .= "<li p='$pre' class='active previ'>«</li>";
	    } else if ($previous_btn) {
	        $pag_container .= "<li class='inactive previ'>«</li>";
	    }
	    
	    for ($i = $start_loop; $i <= $end_loop; $i++) {
	        if ($cur_page == $i){
	            $pag_container .= "<li p='$i' class = 'selected' >{$i}</li>";
	        }else{
	            $pag_container .= "<li p='$i' class='active'>{$i}</li>";
	        }
	        
	    }
	    if ($next_btn && $cur_page < $no_of_paginations) {
	        $nex = $cur_page + 1;
	        $pag_container .= "<li p='$nex' class='active next'>»</li>";
	    } else if ($next_btn) {
	        $pag_container .= "<li class='inactive next'>»</li>";
	    }
	    if ($last_btn && $cur_page < $no_of_paginations) {
	        $pag_container .= "<li p='$no_of_paginations' class='active'> Last » </li>";
	    } else if ($last_btn) {
	        $pag_container .= "<li p='$no_of_paginations' class='inactive'> Last » </li>";
	    }
	    $pag_container = $pag_container . "
	        </ul>
	    </div>";
	    return $pag_container;
	}
}
?>