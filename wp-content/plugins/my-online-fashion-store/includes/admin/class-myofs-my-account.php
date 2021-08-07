<?php
class MYOFS_My_Account extends MYOFS_API{

	public function __construct(){
		add_action('myofs_myaccount_content',array( $this, 'GetMyAccountDetail' ), 7);
	}
	public function GetMyAccountDetail(){
		
		$result   = MYOFS_API::GetMyAccount();
		$response = $result['data']; 
		if ($response['status'] == 1) {
			if ($response['data']['plan_detail'] == 'Monthly Plan') {
				 
				 $endDate = date('Y-m-d',strtotime($response['data']['date']." +1 month"));
				
			}elseif ($response['data']['plan_detail'] == 'Yearly Plan') {
				$endDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($response['data']['date'])) . " + 365 day"));
				
			}
			$plan_array = array(
				'Plan Name' => $response['data']['plan_detail'],
				//'Plan Price' => $response['data']['plan_price'],
				'Plan Type' => str_replace("Plan"," ",$response['data']['plan_detail']),
				'Plan Start Date' => $response['data']['date'],
				'Plan Ends Date' => $endDate,
				'Status' => 'Active'
			);
			$data_html = '';
			foreach ($plan_array as $plan_key => $plan_value) {
				$data_html .= '  <div class="row">
					    <div class="col-md-12">
					    	<div class="form-group">
					        	<label class="control-label col-md-3">'.esc_html($plan_key).':</label>
						        <div class="col-md-9">
						           <p class="form-control-static">'.esc_html($plan_value).'</p>
						        </div>
					        </div>
					    </div>
					</div>';
			}
			
		}else{
			$data_html .= '<div class="notfound"><span>'.esc_html_e('Plan not purchsed','my-online-fashion-store').'</span></div>';
		}
		echo $data_html;
		
	}
	
}
?>