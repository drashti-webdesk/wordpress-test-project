<?php
class MYOFS_All_Inventory extends MYOFS_API{

	public function __construct() {
		add_action('myofs_sidebar_categories', array( $this, 'GetCategoriesListing' ), 7);
		add_action('myofs_all_inventory_products', array( $this, 'GetInventoryProducts' ), 7);
		add_action('myofs_my_inventory_products', array( $this, 'GetMyInventoryProducts' ), 7);
	}
	/*
	* Get All Inventory Product On the Plugin Inventory Page
	* @Used API:GetAllProducts
	* @Used Function:GetQueryStringData()
	* InventoryProductsAfterContent()
	* InventoryProductsBeforeContent()
	* InventoryProductsMiddleContent()
	* NoInventoryProductFound()
	* RemoveProductConfirmContent()
	*/	
	public function GetInventoryProducts(){

		$echo    = "selected";		
		$qry_str = $this->GetQueryStringData();	
		$page    = $qry_str['page'];
		$limit   = $qry_str['limit'];
		$product_html  = '';		
		$result        = MYOFS_API::GetAllProducts($qry_str);
		if(array_key_exists(200,$result['status_code'])){
			$ProductData   = $result['data'];	
			$total_row     = $ProductData['product_count'];
			if (empty($ProductData['data']) && $ProductData['status'] == 0) {
				$product_html .= $this->NoInventoryProductFound();			
			} else {
				$product_html .= $this->InventoryProductsBeforeContent($total_row,$limit,$page);
				
				foreach ($ProductData['data'] as $allproduct) {
					$product_html .= '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">';						
						if ($allproduct['inventory'] == 'no') {
							$product_html .= '<div class="portlet light portlet-fit bordered ">';
								$product_html .= $this->InventoryProductsMiddleContent($allproduct);								
							$product_html .= '</div>';
						} else {
							$product_html .= '<div class="portlet light portlet-fit bordered  item_added_pro_c ">';
								$product_html .= $this->InventoryProductsMiddleContent($allproduct);
								$product_html .= $this->RemoveProductConfirmContent($allproduct['product']['id']);
							$product_html .='</div>';
						/**/}
					$product_html .= '</div>';
				}
				$product_html .= $this->RemoveMultipleProductConfirmContent();
				$product_html .= $this->InventoryProductsAfterContent($total_row,$limit,$page);
			}

		}else{
			$keycode = implode('',array_keys($result['status_code']));
			$product_html .= $statuskey.$result['status_code'][$keycode];
						
		}
		echo $product_html;

	}
	/*
	* Get All Added Inventory Products to woocommerce store  On the Plugin My Inventory Page
	* @Used API:GetMyInventory
	* @Used Function:GetQueryStringData()
	* InventoryProductsAfterContent()
	* InventoryProductsBeforeContent()
	* InventoryProductsMiddleContent()
	* NoInventoryProductFound()
	* RemoveProductConfirmContent()
	*/	
	public function GetMyInventoryProducts(){		
			
		$qry_str = $this->GetQueryStringData();	
		$page  = $qry_str['page'];
		$limit = $qry_str['limit'];			

		$result  = MYOFS_API::GetMyInventory($qry_str);
		if(array_key_exists(200,$result['status_code'])){

			$ProductData  = $result['data'];	
			$total_row    = $ProductData['product_count'];
			$product_html = '';
			if (empty($ProductData['data']) && $ProductData['status'] == 0) 
			{
				$product_html .= $this->NoInventoryProductFound();
			} else {
				$product_html .= $this->InventoryProductsBeforeContent($total_row,$limit,$page);
				foreach ($ProductData['data'] as $allproduct) {
					$product_html .= '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">';
						if ($allproduct['inventory'] == 'yes'){
							$product_html .= '<div class="portlet light portlet-fit bordered item_added_pro_c">';
								$product_html .= $this->InventoryProductsMiddleContent($allproduct);
								$product_html .= $this->RemoveProductConfirmContent($allproduct['product']['id']);
							$product_html .='</div>';
						}
					$product_html .= '</div>';
				}
				$product_html .= $this->InventoryProductsAfterContent($total_row,$limit,$page);
			}
		}else{
			$keycode = implode('',array_keys($result['status_code']));
			$product_html .= $statuskey.$result['status_code'][$keycode];
						
		}
		echo $product_html;
	}
	/*
	* Get Single Product Details 
	* Show on the Plugin All Inventory/My Inventory Detail Popup
	* @Used API:GetSingleProduct
	*/
	public function GetSingleProductData() {
		$return_arr = array();
		$productid  = $_GET['productid'];
		$row_data   = MYOFS_API::GetSingleProduct($productid);
		if(array_key_exists(200,$row_data['status_code'])){

			$productdetails = $row_data['data']['data'];

			$image    = $allimage = $option   = $options  = $productdetails_html  = '';
			$productdetails_html .= '<div class="modal fade in" id="full" tabindex="-1" role="dialog" aria-hidden="true" style="display: block; padding: 50px;">
					<div class="modal-dialog modal-full">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h4 class="modal-title">Product Detailed View</h4>
							</div>
							<div class="modal-body">';
								$productdetails_html .= '<div class="row">';
									if (isset($productdetails) && !empty($productdetails)) {
										
										if (!empty($productdetails['product']['imageradio']) && isset($productdetails['product']['imageradio'])) {
											$image = $productdetails['product']['imageradio'];

										} else {
											if (!empty($productdetails['image'][0]['image']) && isset($productdetails['image'][0]['image'])) {
												$image = $productdetails['image'][0]['image'];
											}
										}
										if (isset($productdetails['image']) && !empty($productdetails['image'])) {			
											$allimage = $productdetails['image'];
										}
										if (isset($productdetails['option']) && !empty($productdetails['option'])) {
											$option = $productdetails['option'];
										}
										if (isset($productdetails['optionS']) && !empty($productdetails['optionS'])) {			
											
											$options = $productdetails['optionS'];
										}
										if (isset($productdetails['tag']) && !empty($productdetails['tag']) && count($productdetails['tag']) > 0) {
											$tag = $productdetails['tag'];
										}
										
										$productdetails_html .=	'<div style="margin-top: 30px" class="col-md-6">
																	<div id="big-image">';
																			if (!empty($image)) {
																				$productdetails_html .= '<img src="' . $image . '" style="width:100%;" >';

																			} else {
																				$productdetails_html .= '<img src="'.MYOFS_ASSETS_URL.'images/placeholder.png" style="width:100%;">';
																			}
												$productdetails_html .= '</div>
																		<div id="thumbs" class="detail-slider">';
																			if (!empty($allimage) && isset($allimage)) {
																				$img_caption_txt_arr = array();
																				$i = 0;
																				foreach ($allimage as $aimg) {
																					if ($i != 0) {
																						if ($aimg['caption'] != '' && !in_array($aimg['caption'], $img_caption_txt_arr)) {$img_caption_txt_arr[] = $aimg['caption'];}
																						$productdetails_html .= '<div class="img-container ng-scope active" style=""><img  src="' . $aimg['image'] . '" alt="">
																										<span class="caption">' . $aimg['caption'] . '</span>
																										</div>';
																					}
																					$i++;}
																			}
												$productdetails_html .= '</div>
																	</div>
																	<div style="margin-top: 30px" class="col-md-6">

																		<h2 class="item-title ng-binding">' . $productdetails['product']['name'] . '</h2>';

																	if ($productdetails['inventory'] == 'no') {

																		$productdetails_html .= '<a class="myofs-add-wc uppercase"  data-product-id="' .
																		$productdetails['product']['id'] . '"   data-product-name="'.urlencode($productdetails['product']['name']).'" data-product-stock = "'.$productdetails['product']['stock'].'" id="myofs_add_wc">Add to Woocommerce</a>';

																	} else {

																		$productdetails_html .= '<button ng-if="!item.uploaded" class="btn btn-success pull-right ng-scope proitem_download" >Item Added</button>';
																	}

																	$discount_value = ($productdetails['product']['cost_price'] / 100) * 20;
																	$discounted_price = $productdetails['product']['cost_price'] - $discount_value;

													$productdetails_html .= '<div ng-if="item.discountPrice" class="good-price ng-scope" style="">
																						<label class="rm-3">Your Cost:</label>
																						<span class="good-price ng-binding">$' . $productdetails['product']['cost_price'] . '</span>
																					</div>
																					<div ng-if="item.discountPrice" class="good-price ng-scope" style="">
																						<label class="rm-3">YOUR COST ( ANNUAL MEMBERS ):</label>
																						<span class="good-price ng-binding">$' . number_format($discounted_price, 2) . '</span>
																					</div>
																					<div ng-if="item.discountPrice" class="good-price ng-scope">
																						<label class="rm-3">Default Selling Price:</label>
																						<span class="label label-success good-price ng-binding">$' . $productdetails['product']['price'] . '</span>
																					</div>
																					<div ng-if="item.discountPrice" class="good-price ng-scope" style="">
																						<label class="rm-3">MSRP:</label>
																						<span class="good-price ng-binding">$' . $productdetails['product']['retail_price'] . '</span>
																					</div>
																					<div>
																						<label class="rm-3">SKU:</label>
																						<span class="ng-binding">' . $productdetails['product']['sku'] . '</span>
																					</div>
																					<div>
																						<label class="rm-3">Weight:</label>
																						<span class="ng-binding">' . $productdetails['product']['weight'] . ' lb</span>
																					</div>';
																if (!empty($option) && isset($option)) {

																	$productdetails_html .= '<div class="product-option " style="">
																									<label class="rm-3">' . $productdetails['optionname'] . ':</label>
																									<ul class="option-data option_data_stock">';
																	foreach ($option as $op) {
																		$optionstock = $op['stock'];

																		$productdetails_html .= '<li><span>' . $op['name'] . '</span> ';

																		$productdetails_html .= '<p> ' . $op['stock'] . 'PC</p>';

																		$productdetails_html .= '</li>';

																	}
																	$productdetails_html .= '</ul>
																								</div>';

																}
																if (!empty($options) && isset($options)) {
																	foreach ($options as $opt) {
																		$value = $opt['value'];
																		$opti = explode(",", $value);

																		$productdetails_html .= '<div class="product-option" style="">
																									<label class="rm-3">' . $opt['name'] . ':</label>
																									<ul class="option-data">';
																		foreach ($opti as $op) {

																			$productdetails_html .= '<li><span>' . $op . '</span></li>';

																		}
																		$productdetails_html .= '</ul>
																								</div>';
																	}
																}
																$productdetails_html .= '<div class="good-stock">
																									<label class="rm-3">In stock:</label>
																									<span class="ng-binding">' . $productdetails['product']['stock'] . '</span>
																								</div>
																								<div class="product-description">
																									<label>Description:</label>
																									<div class="ng-binding">' . base64_decode($productdetails['product']['decc']) . '</div>
																								</div>';
																if (!empty($tag) && isset($tag) && count($tag) > 0) {

																	$productdetails_html .= '<div class="product-option" style="">
																									<label class="rm-3">Tags:</label>
																									<ul class="option-data">';
																	foreach ($tag as $tg) {
																		if (isset($tg['category_name']) && !empty($tg['category_name'])) {
																			$productdetails_html .= '<li><span>' . $tg['category_name'] . '</span> </li>';
																		}
																	}
																	// START image caption as tag
																	if (!empty($allimage) && isset($allimage) && !empty($img_caption_txt_arr)) {
																		foreach ($img_caption_txt_arr as $img_cap_str) {
																			$productdetails_html .= '<li><span>' . $img_cap_str . '</span> </li>';
																		}
																	}
																	// END image caption as tag
																	$productdetails_html .= '</ul>
																								</div>';
																}
																$productdetails_html .= '</div>
																						</div>';
										
										$return_arr['status'] = 1;
										$return_arr['data']   = $productdetails_html;
									}else{
										$productdetails_html .= '<span>Product Detail not found </span>';
										$return_arr['status'] = 0;
										$return_arr['data']   = $productdetails_html;
										
									}
							$productdetails_html .= '</div>
						</div>
					</div>
			</div>';
		}else{
			$keycode = implode('',array_keys($row_data['status_code']));
			$productdetails_html .= $statuskey.$row_data['status_code'][$keycode];
			$return_arr['status'] = 0;
			$return_arr['data']   = $productdetails_html;
													
		}
		echo json_encode($return_arr);		
		exit();
	}
	/*
	* Get All Dashboard Categories 
	* show on Categories on sidebar
	* @Used API:GetAllCategories
	*/
	public function GetCategoriesListing(){
		
		$result = MYOFS_API::GetAllCategories();
		if(array_key_exists(200,$result['status_code'])){

			$categoryData = $result['data']; 	
			$categoryHtml = ' '; 
			if( $categoryData['status'] == 1 && !empty($categoryData['data']) ){			
				foreach ($categoryData['data'] as $categoryValue) {	
									
					$categoryID   = $categoryValue["category_id"];
					$categoryName = $categoryValue["category_name"];
					if (isset($categoryValue["count"]) && !empty($categoryValue["count"])) {
						$count = $categoryValue["count"];		
					}else{
						$count = 0;		
					}
					$categoryHtml .= '<li class="myofs-nav-item">';
						$categoryHtml .= '<a href="javascript:;" class="nav-link nav-toggle">';
							$categoryHtml .= '<span class="title" id="'.$categoryID.'">'.$categoryName.'('.$count.')</span>';
							$categoryHtml .= '<span class="arrow"></span>'; 
						$categoryHtml .= '</a>';
						if ( !empty($categoryValue['subcategories']) ) {
							$categoryHtml .= '<ul class="sub-menu">';
								foreach ($categoryValue['subcategories'] as $subCategoryValue) {	
									$subCategoryID   = $subCategoryValue["category_id"];
									$subCategoryName = $subCategoryValue["category_name"];
									if (isset($subCategoryValue["count"]) && !empty($subCategoryValue["count"])) {	
										$subCatCount = $subCategoryValue["count"];			
									}else{
										$subCatCount = 0;		
									}	
									$categoryHtml .= '<li>';
										$categoryHtml .= '<a href="javascript:;"  class="nav-link">
											<span class="title" id="'.$subCategoryID.'">'.$subCategoryName.'('.$subCatCount.')</span>
										</a>';
									$categoryHtml .= '</li>';
								}
							$categoryHtml .= '</ul>';
							
						}
					$categoryHtml .= '</li>';
				}
				
			}else{
				$categoryHtml .= '<span>Category Not Found</span>'; 			
			}
		}else{
			$keycode = implode('',array_keys($result['status_code']));
			$categoryHtml .= $statuskey.$result['status_code'][$keycode];
						
		}		
		echo $categoryHtml;

	}
	/*
	* Get Product Tag and WC Categories 
	* show on add to woocommerce popup
	* @Used API:GetSingleProduct
	* GetStoreCategories
	*/
	public function GetTagCatgoryForAddPopup(){
		$return_arr   = array();
		$productid    = $_GET['productid'];
		$product_type = $_GET['product_type'];
		
		if ( $product_type == 'single') {			
			$getproductdata  = MYOFS_API::GetSingleProduct($productid);
			if(array_key_exists(200,$getproductdata['status_code'])){
				$gettags = $getproductdata['data']['data'];
				$tagarr = array();		
				if (isset($gettags['tag']) && !empty($gettags['tag']) && count($gettags['tag']) > 0) {
					$tag = $gettags['tag'];
					foreach ($tag as $tagvalue) {
						array_push($tagarr, $tagvalue['category_name']);
					}
					$taglist = implode(",",$tagarr);
					$return_arr['data']['tags'] = $taglist;
				}else{					
					$return_arr['data']['tags'] = ' ';
				}
			}else{
				$keycode = implode('',array_keys($getproductdata['status_code']));
				$return_arr['data']['error'][] = $statuskey.$getproductdata['status_code'][$keycode];
							
			}
		}

		$category_arr = array();
		$getCategory   = MYOFS_API::GetStoreCategories();
		/*$wcCategory   = MYOFS_API::GetStoreCategories();
		$getCategory  = $wcCategory['data']['data'];*/
		//if(array_key_exists(200,$getCategory['status_code'])){

			if (isset($getCategory) && !empty($getCategory)) {					
				foreach ($getCategory as $catvalue) {
					$category_arr[] = array(
						'id' => $catvalue->id,
						'name' => $catvalue->name
					);
				}																	
			}
		/*}else{
			$keycode = implode('',array_keys($getCategory['status_code']));
			$return_arr['data']['error'][] = $statuskey.$getCategory['status_code'][$keycode];
						
		}*/
		$return_arr['status'] = 1;
		$return_arr['data']['category'] = $category_arr;
		echo json_encode($return_arr);		
		exit;
	}
	/*
	* Add Inventory Product from the Woocommerce Store
	* @Used API:AddProducttoStore	
	* @DB Table: MYOFS_DB_TABLE	
	*/	
	public function addProducTowcStore(){
		global $wpdb;
		
		$return_arr   = array();
		$return_arr['error']['product']   = '';
		$return_arr['error']['category']  = '';
        $return_arr['error']['api_error'] = '';
        $return_arr['error']['amount']    = '';
        $return_arr['status'] = '';

        $qry_str          = array();
		$change_price     = $_POST['change_price'];
        $markup_price     = $_POST['markup_price'];
        $product_id       = $_POST['product_id'];
        //$product_name     = $_POST['product_name']; 
        //$product_sku      = $_POST['product_sku']; 
        $modal_pro_tags   = $_POST['modal_pro_tags'];
        //$p_inc_sizechart  = $_POST['p_inc_sizechart'];
        //$p_measuremntinfo = $_POST['p_measuremntinfo'];
        $combain_product  = $_POST['combain_product'];
        $collection_type  = $_POST['collection_type'];
        $amnt             = $_POST['amount'];
        $instanceId       = $_POST['instanceId'];

        if (isset($product_id) && !empty($product_id)) {

        	$modal_pro_tags64 = '';
        	$p_msrp = 0;
			$p_inc_vendernm = 0;
			$pro_stock = 0;
			$pro_name = '';
			if ( ( isset($_POST['myofs_categoryid']) && !empty($_POST['myofs_categoryid']) ) || ( isset($_POST['categoryid_nm']) && !empty($_POST['categoryid_nm']) ) ) {

				if ($collection_type == 'select') {
					$qry_str['wix_categoryid'] = implode(",",$_POST['myofs_categoryid']);
				}else{
					$qry_str['wix_categoryid'] = $_POST['categoryid_nm'];
				}
			}else{
				$return_arr['error']['category'] = 'Please select collection';
			}
			if ( isset($amnt) && $amnt >= 0 ) {
				$qry_str['amount'] = $amnt;			
			}else{
				$return_arr['error']['amount'] = 'Please choose vaild amount';
			}
			if( ( isset($qry_str['wix_categoryid']) && !empty($qry_str['wix_categoryid']) ) && ( isset($qry_str['amount']) && !empty($qry_str['amount']) ) ){

		        if (isset($modal_pro_tags) && !empty($modal_pro_tags)) {
		        	$modal_pro_tags64   = base64_encode($modal_pro_tags);        	
		        }
		        /*if (isset($product_name) && !empty($product_name)) {
		        	$pro_name = $product_name;
		        }
		        if (isset($_POST['product_stock']) && !empty($_POST['product_stock'])) {
		        	$pro_stock = $_POST['product_stock'];
		        }*/
				
				if (isset($_POST['p_msrp']) && !empty($_POST['p_msrp'])) {
					$p_msrp = $_POST['p_msrp'];
				}
				if (isset($_POST['p_inc_vendernm']) && !empty($_POST['p_inc_vendernm'])) {
					$p_inc_vendernm = $_POST['p_inc_vendernm'];
				}
				if (isset($_POST['p_inc_sizechart']) && $_POST['p_inc_sizechart'] == 'on') {
					$p_inc_sizechart = 1;
				}else{					
					$p_inc_sizechart = 0;
				}

				if (isset($_POST['p_measuremntinfo']) && $_POST['p_measuremntinfo'] == 'on') {
					$p_measuremntinfo = 1;
				}else{
					$p_measuremntinfo = 0;

				}

				$qry_str['change_price']     = $change_price;
				$qry_str['markup_price']     = $markup_price;
				$qry_str['product_id']       = $product_id;
				//$qry_str['product_name']     = $pro_name;
				//$qry_str['product_stock']    = $pro_stock;
				$qry_str['modal_pro_tags']   = $modal_pro_tags64;
				$qry_str['p_msrp']           = $p_msrp;
				$qry_str['p_inc_vendernm']   = $p_inc_vendernm;
				$qry_str['p_inc_sizechart']  = $p_inc_sizechart;
				$qry_str['p_measuremntinfo'] = $p_measuremntinfo;
				$qry_str['combain_product']  = $combain_product;
				$qry_str['collection_type']  = $collection_type;
				$qry_str['instanceId']       = $instanceId;
				
				$result  = MYOFS_API::AddProducttoStore($qry_str);
				
				if(array_key_exists(200,$result['status_code'])){
					if ( $result['data']['sync_err'] == 0 ) {				
						$product_ex = explode(',',$product_id);
						$return_arr['total_product'] = count($product_ex);
						$wc_product_id = $result['data']['woocommerce_id'];
						if (isset($wc_product_id) && !empty($wc_product_id)) {
							$table_name = $wpdb->prefix .MYOFS_DB_TABLE;
							for ($i = 0; $i < count($wc_product_id); $i++) {
								$wpdb->insert($table_name, array(
								    'wc_product_id' => $wc_product_id[$i],
								    'status' => 1,
								));
							}
						}
						/*$wc_catids = $result['data']['wc_category_id'];
						if (isset( $wc_catids ) && !empty( $wc_catids )) {
							for ($ci = 0; $ci < count($wc_catids); $ci++) {
								update_term_meta($wc_catids[$ci],'myofs_categoryid',1);
							}
						}*/
						$return_arr['status'] = 1;
						$return_arr['count']  = $result['data']['sync_succ'];
						
					}else{
						$return_arr['status'] = 0;
						$return_arr['error']['product'] = 'something went to wrong please try again!';
					}
				}else{
					$keycode = implode('',array_keys($result['status_code']));
					$return_arr['status'] = 0;					
					$return_arr['error']['product'] = $statuskey.$result['status_code'][$keycode];
								
				}
				
			}else{
				$return_arr['status'] = 0;
				$return_arr['error']['product'] = 'please choose collection and amount';
			}

        }else{
			$return_arr['status'] = 0;
			$return_arr['error']['product'] = 'something went to wrong please try again';        	
        }

        echo json_encode($return_arr);
		exit();
	}
	/*
	* remove Inventory Product from the Woocommerce Store
	* @Used API:RemoveProducttoStore
	* @DB Table: MYOFS_DB_TABLE	
	*/
	public function removeProductTowcStore(){
		global $wpdb;
		$product_ids = $_GET['ids'];	
		$return_arr  = array();
		if (isset($product_ids) && !empty($product_ids)) {

			$ids     = implode(",",$product_ids);
			$qry_str = array('removeid' =>$ids);
			$result  = MYOFS_API::RemoveProducttoStore($qry_str);
			if(array_key_exists(200,$result['status_code'])){
				if ( $result['data']['sync_err'] == 0) {
					$table_name = $wpdb->prefix .MYOFS_DB_TABLE;
					$wc_ids     = implode(",",$result['data']['woocommerce_id']);
					$wpdb->query( "DELETE FROM $table_name WHERE wc_product_id IN($wc_ids)" );
	       			$return_arr['status'] = 1;	
	       			$return_arr['message'] = 'product has been deleted successfully...';

				}else{
	       			$return_arr['status'] = 0;				
	       			$return_arr['message'] = 'something went to wrong please try again';
				}
			}else{
				$keycode = implode('',array_keys($result['status_code']));
				$return_arr['status'] = 0;					
				$return_arr['message'] = $statuskey.$result['status_code'][$keycode];
							
			}

		}else{
   			$return_arr['status'] = 0;				
			$return_arr['message']   = 'something went to wrong please try again';

		}
		echo json_encode($return_arr);
		exit();	
	}
	/*
	* Check Selected Products are combine or not.
	* If products are combine than add to woocommerce
	* @Used API:CombineProducts
	*/
	public function checkCombineProducts(){
		$response = array();   

		$ids = $_GET['productid'];
		if (isset($ids) && !empty($ids)) {	
			$count = count($ids); 
			
			if(trim($count) > 1){
				$product_ids = implode(',', $ids);
				$qry_str     = array('product_ids'=> $product_ids);
				$result        = MYOFS_API::CombineProducts($qry_str);
				if(array_key_exists(200,$result['status_code'])){

					if(isset($result['data']) && !empty($result['data'])){
						$response['status']  = $result['data']['status'];
						$response['message'] = $result['data']['message'];

					}else{
						$response['status']  = '0';
						$response['message'] = 'Please select more than 1 product for the add combine products.';
					}
				}else{
					$keycode = implode('',array_keys($result['status_code']));
					$return_arr['status'] = 0;					
					$return_arr['message'] = $statuskey.$result['status_code'][$keycode];
								
				}

			}else{
				$response['status']  ='0';
				$response['message'] = 'Please select more than 1 product for the add combine products.';
			} 
		}else{
			$response['status']  = '0';
			$response['message'] = 'Please select more than 1 product for the add combine products.';
		} 

		echo json_encode($response);
		exit();	
	}
	/*
	* Get sidebar,pagination,per page query string data from Inventory/My Inventory Page 
	*/
	public function GetQueryStringData(){
		$search  = $catid   = $sort    = '';	
		$limit   = 30;
		$qry_str = array();
		if (isset($_GET['sortby']) && !empty( $_GET['sortby']) ){ 
			$sort = $_GET['sortby']; 
			$qry_str['sortby'] = $sort;
		}

		if (isset($_GET['limit']) && !empty( $_GET['limit'] )) { 
			$limit = $_GET['limit']; 
		}		

		if (isset($_GET['search']) && !empty( $_GET['search'] ) ) {
			$search = base64_decode($_GET['search']);
			$qry_str['searh'] = $search;
		}

		if (isset($_GET['category_id']) && !empty($_GET['category_id']) ) { 
			$catid = $_GET['category_id'];
			$qry_str['category_id'] = $catid;
		}

		if (isset($_GET['current_page']) && !empty($_GET['current_page'])) { $page = $_GET['current_page']; } else { $page = 1; };
		
		$qry_str['limit'] = $limit;
		$qry_str['page']  = $page;
		return $qry_str;
	}
	/*
	* Load Inventory/My Inventory Before HTML
	*/
	public function InventoryProductsBeforeContent($total_row,$limit,$page){
		$product_html = ''; 
		$echo    = "selected";
		$previous_btn = true;
		$next_btn     = true;
		$first_btn    = true;
		$last_btn     = true;
		$start        = ($page - 1) * $limit;
		$showpagi     = 0;
		$product_html .= '
			<div class="col-md-12 col-md-12 margin-bottom-10 margin-top-10 top_header_sec">
				<div class="col-md-4 first_btn" style="float:left;">
					<div class="btn-toolbar margin-top-10">
						<div class="btn-group" id="selection">
							<select name="selection" id="selectionbox"> 
								<option value="0">Select</option>
								<option value="selectall">Select All</option>
								<option value="removeselectall">Remove Selection</option>
								<option value="inverseselectall">Inverse Selection</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-4 secound_btn" style="float:right;">
					<div class="btn-toolbar margin-top-10" style="float:left;">
						<div class="btn-group Pagination" style=" margin-top: 0; ">';

							if (isset($total_row) && !empty($total_row) && $total_row > 30) {
								$product_html .= '<select name="limit" id="limitbox">
												<option value="30" ';
								if ($limit == '30') {$product_html .= $echo;}
								$product_html .= '>30 per page</option>
												<option value="60" ';
								if ($limit == '60') {$product_html .= $echo;}

								$product_html .= '>60 per page</option>
												<option value="90" ';
								if ($limit == '90') {$product_html .= $echo;}
								$product_html .= '>90 per page</option>
											</select>';
							}

			$product_html .= '</div>
					</div>
					<div class="btn-toolbar margin-top-10" style="float:right;">';

						if ($showpagi == 0 && $total_row > $limit) {
					        $no_of_paginations = ceil($total_row / $limit);
					        /* Pagination */
					        $pagination = array(
					            "cur_page" => $page,
					            "no_of_paginations" => $no_of_paginations,
					            "first_btn" => $first_btn,
					            "previous_btn" => $previous_btn,
					            "last_btn" => $last_btn,
					            "next_btn" => $next_btn
					        );
					        $product_html .= MYOFS_API::Pagination($pagination);
					    } else {
					        $product_html .= "";
					    }
			$product_html .= '</div>
				</div>
			</div>
			<div id="section_n" class="col-md-12"></div>
			<div id="product_details"></div>';
		return $product_html;
	}
	/*
	* Load Inventory/My Inventory After HTML
	*/
	public function InventoryProductsAfterContent($total_row,$limit,$page){
		$product_html = '';		
		$previous_btn = true;
		$next_btn     = true;
		$first_btn    = true;
		$last_btn     = true;
		$start        = ($page - 1) * $limit;
		$showpagi     = 0;
		$product_html .= '<div class="col-md-6 bottom_pagination" style="float:left;clear:both;">';
				if ($showpagi == 0 && $total_row > $limit) {
			        $no_of_paginations = ceil($total_row / $limit);
			        /* Pagination */
			        $pagination = array(
			            "cur_page" => $page,
			            "no_of_paginations" => $no_of_paginations,
			            "first_btn" => $first_btn,
			            "previous_btn" => $previous_btn,
			            "last_btn" => $last_btn,
			            "next_btn" => $next_btn
			        );
			        $product_html .= MYOFS_API::Pagination($pagination);
			    } else {
			        $product_html .= "";
			    }

			$product_html .= '</div>';
		return $product_html;
	}
	/*
	* Load Inventory/My Inventory Product Loop HTML
	*/
	public function InventoryProductsMiddleContent($allproduct){
		$product_html = '';
		$discount_value = ($allproduct['product']['cost_price'] / 100) * 20;
		$discounted_price = $allproduct['product']['cost_price'] - $discount_value;
		$product_html .= '<div class="portlet-title">
							<div class="caption">
								<span class="check_cnt">
								<input type="checkbox"  class="product_id"  name="product_id" value="' . $allproduct['product']['id'] . '">
								</span>
								<label class="caption-subject font-green bold uppercase" for="' . $allproduct['product']['id'] . '">' . $allproduct['product']['name'] . '</label>
							</div>
						</div>
						<div class="portlet-body">';
							if ($allproduct['inventory'] == 'yes'){
								$product_html .= '<div class="pro_item_added"><span>Item Added</span></div>';
							}
				            $product_html .= 
				            '<div class="mt-element-overlay">
								<div class="row">
									<div class="col-md-12">
										<div class="mt-overlay-6">';

											$image = '';
											if (!empty($allproduct['product']['imageradio']) && isset($allproduct['product']['imageradio'])) {
												$image = $allproduct['product']['imageradio'];

											} else {

												$image = '';
												if (!empty($allproduct['image'][0]['image']) && isset($allproduct['image'][0]['image'])) {
													$image = $allproduct['image'][0]['image'];
												}
											}

											$stock = 0;
											if ($allproduct['product']['stock'] != '') {
												$stock = $allproduct['product']['stock'];
											}

											if (!empty($image)) {
												$product_html .= '<img  src="https://app.ccwholesaleclothing.com/timthumb.php?src=' . $image . '?h=300&w=300&c=1" alt=""  >';
											} else {
												$product_html .= '<img src="'.MYOFS_ASSETS_URL.'images/placeholder.png" style="width:100%;" >';
											}
											$product_html .= 
											'<div class="mt-overlay">
												<p class="pro-detl">
													<a class="detail-view uppercase"
													data-product-id="'.$allproduct['product']['id'].'"> Detailed view</a>
												</p>';
												if ($allproduct['inventory'] == 'yes'){
													$product_html .=
													'<p class="pro-add-rmv">
														<a class="myofs-remove-wc uppercase" id="myofs-remove-wc" data-toggle="modal" data-product-id="' . $allproduct['product']['id'] . '" >Remove From Woocommerce</a>
													</p>';
												}else{
													$product_html .=
													'<p class="pro-add-rmv">
														<a class="myofs-add-wc uppercase"  data-product-id="' .
														$allproduct['product']['id'] . '"  data-product-name="'.$allproduct['product']['name'].'" data-product-stock = "'.$allproduct['product']['stock'].'" data-product-sku = "'.$allproduct['product']['sku'].'" id="myofs_add_wc">Add to Woocommerce</a>
													</p>';
												}
												$product_html .=
											'</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="portlet-desc">
							<div class="row">
								<div class="col-md-12 uppercase" style="text-align: right;">
									' . $allproduct['product']['sku'] . '</div>
								<div class="col-md-12">
									<a  class="btn btn-sm green qty_c_btn" style=" float: left; "><i class="fa fa-shopping-basket"></i> ' . $stock . ' QTY IN STOCK </a>
									<div class="price">
										<b>Your Cost:</b> $' . $allproduct['product']['cost_price'] . '<br>
										<b>YOUR COST ( ANNUAL MEMBERS ):</b> $' . number_format($discounted_price, 2) . '<br>
										<b>Default Selling Price</b>: $' . $allproduct['product']['price'] . ' <br>

									</div>
								</div>
							</div>
						</div>';
		return $product_html;
	}
	/*
	* Load Inventory/My Inventory Product Not Exist HTML
	*/
	public function NoInventoryProductFound(){
		$product_html = '<div class="col-md-12 col-md-12 margin-bottom-10 margin-top-10 top_header_sec">					
					<span class="myofs-noproduct">'.esc_html_e('No Product Found.','my-online-fashion-store').'</span>
				</div>';
		return $product_html;
	}
	/*
	* Load Inventory/My Inventory Remove Product Popup HTML
	*/
	public function RemoveProductConfirmContent($product_id){
		$product_html = '<div class="modal fade removeconfirm" id="large' . $product_id . '" tabindex="-1" role="basic" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Remove Product from Woocommerce</h4>
								</div>
								<div class="modal-body">Are you sure you want remove this product?</div>
								<div class="modal-footer" data-product-id="'.$product_id.'">
									<button type="button" class="btn red" id="rmv_product">REMOVE</button>
									<button type="button" class="btn dark btn-outline rmv_cancel" data-dismiss="modal">CANCLE</button>
								</div>
							</div>
						</div>
					</div>';
		return $product_html;

	}
	public function RemoveMultipleProductConfirmContent(){
		$product_html = '<div class="modal fade removeconfirm" id="multiallinventory" tabindex="-1" role="basic" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">Remove Product from Woocommerce</h4>
									</div>
									<div class="modal-body">Are you sure you want remove this product?</div>
									<div class="modal-footer">
										<button type="button" class="btn dark btn-outline rmv_mulcancel" data-dismiss="modal">CANCLE</button>
										<button type="button" class="btn red" id="rmv_mulpro">REMOVE</button>
									</div>
								</div>
							</div>
						</div>';
		return $product_html;
	}
}
?>