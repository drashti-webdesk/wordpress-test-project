<?php
class MYOFS_Activation_Key extends MYOFS_API{

	public function __construct(){
		
	}
	public function myofs_activate_keys(){

		$email  = sanitize_email($_POST['activation_email']);
		$acvkey = sanitize_text_field($_POST['activation_key']);
		$response = array();	
		$response['status']   = 0;
		if ( !empty($email) && !empty($acvkey) ) {
			if (is_email($email)) {
				$qry_str = array('user_email' => $email,'activation_key' => $acvkey);
				$result = MYOFS_API::GetActivationPlan($qry_str);	
				$res    = $result['data'];
				if ($res['status'] == 1 ) {
					$authantication = base64_encode($res['auth_token']['auth_token']);
					$storeres = array(
						'email' => $email,
						'authantication' => base64_encode($authantication)
					);
					//'activation_key' => base64_encode($acvkey),
					$restkeys = MYOFS_API::StoreGeneratedWcRestApiKeys($email);
					update_option('myofs_opt_data',maybe_serialize($storeres));

					$response['status']   = 1;
					$response['success']  = 'Successfully Activted';		
				}else{ $response['error'] = 'Invaild Activation Data';	}
			}else{ 
				$response['error'] = "Invalid email format";
			}
			
		}else{
			$response['error']   = 'Email & Activation key fields is required!';
		}
		echo json_encode($response);
		exit();
		

	}
	/*public function myofs_remove_keys(){
		global $wpdb;
		$response = array();
		$deleted  = delete_option( 'myofs_opt_data');
		//$table_name = $wpdb->prefix .MYOFS_DB_TABLE;
		//$delete_records = $wpdb->query("TRUNCATE TABLE $table_name");
		if ($deleted == 'TRUE') { $response['success'] = get_admin_url('',MYOFS_PLUGIN_URL);
		}else{$response['error']   = 'Somthing went to wrong please try again.';}
		echo json_encode($response);
		exit();
	}
*/
	
}
?>