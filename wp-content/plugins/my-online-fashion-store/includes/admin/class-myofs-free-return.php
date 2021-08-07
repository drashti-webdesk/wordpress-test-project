<?php
class MYOFS_Free_Return extends MYOFS_API{

	public function __construct() {}

	public function submitFormReturnData(){
          echo "<pre>";
          print_r($_POST);
          echo "<pre>";
          die();
          
          $return_arr = array();
          $qrystr = array();
          /*$return_arr['error']['contactperson']   = '';
          $return_arr['error']['email']  = '';
          $return_arr['error']['ordernumber'] = '';
          $return_arr['error']['itemqty']    = '';
          $return_arr['error']['reasonreturn']    = '';
          $return_arr['error']['additionaln']    = '';*/
          //$return_arr['status'] = '';
          
          $contactperson = sanitize_text_field($_POST['contactperson']);
          $email = sanitize_email($_POST['email']);
          $ordernumber = sanitize_text_field($_POST['ordernumber']);
          $itemqty = sanitize_text_field($_POST['itemqty']);
          $reasonreturn = sanitize_textarea_field($_POST['reasonreturn']);
          $additionaln = sanitize_textarea_field($_POST['additionaln']);

          if (isset($contactperson) && !empty($contactperson)) {
               $qrystr['contactperson'] = $contactperson;
          }else{
               //error
               $contactperson .= '<span> Not Send Data </span>';
               $return_arr['data']   = $contactperson;
               //$return_arr['error']['contactperson'] = 'Please Enter Name';
          }
          if (isset($email) && !empty($email)) {
               $qrystr['email'] = $email;
               
          }else{
               $email .= '<span> Not Send Data </span>';
               $return_arr['data']   = $email;
               //$return_arr['error']['email'] = 'Please Enter vaild email';
          }
          if (isset($ordernumber) && !empty($ordernumber)) {
               $qrystr['ordernumber'] = $ordernumber;               
          }else{
               $ordernumber .= '<span> Not Send Data </span>';
               $return_arr['data']   = $ordernumber;
               //$return_arr['error']['ordernumber'] = 'Please Enter Order Name';
          }
          if (isset($itemqty) && !empty($itemqty)) {
               $qrystr['itemqty'] = $itemqty;               
          }else{
               $itemqty .= '<span> Not Send Data </span>';
               $return_arr['data']   = $itemqty;
               //$return_arr['error']['itemqty'] = 'Please Enter Item Quantity';
          }
          if (isset($reasonreturn) && !empty($reasonreturn)) {
               $qrystr['reasonreturn'] = $reasonreturn;                       
          }else{
               $reasonreturn .=$return_arr['error']['itemqty'] = 'Please Enter Item Quantity'; '<span> Not Send Data </span>';
               $return_arr['data']   = $reasonreturn;
               //$return_arr['error']['reasonreturn'] = 'Please Enter Reason For Return';
          }
          if (isset($additionaln) && !empty($additionaln)) {            
               $qrystr['additionaln'] = $additionaln;
          }else{
               $additionaln .= '<span> Not Send Data </span>';
               $return_arr['data']   = $additionaln;
               //$return_arr['error']['additionaln'] = 'Please Enter Additional Note';
          }

          
          if(!empty($contactperson) && !empty($ordernumber) && !empty($itemqty) && !empty($reasonreturn) &&!empty($additionaln)){
               $return  = MYOFS_API::ReturnFormSubmit($qrystr);
               
               $return_arr['status'] = 1;
               $return_arr['data']   = $return;
          }else{
               $return_arr['status'] = 0;
               $return_arr['data']   = $return;
          }

          echo json_encode($return_arr);
          exit();
	}

}


?>