<div class="wrap">	
	<!-- page sidebar  -->
		<?php load_template(MYOFS_PLUGIN_TEMPLATE_PATH.'myofs-sidebar-page.php');?>
	<!-- end sidebar -->
	<div class="page-content-wrapper">	
		<div class="page-content">
			<div class="page-bar">
				<h1 class="wp-heading-inline" id="dynamic_heading_title"><?php esc_html_e('My Account','my-online-fashion-store');?></h1>
			</div>
            <div class="tab-pane active my_account">
			   <div class="portlet light bg-inverse">
			      <div class="portlet-body form">
			         <div class="form-horizontal">
			          <div class="form-body">
			               <h2 class="margin-bottom-20"><?php esc_html_e('Active Plan Information','my-online-fashion-store')?> </h2>
			               <span class="offer_text"><a href="<?php echo MYOFS_PLAN_URL;?>" target="_blank" style="color:#FFF">UPGRADE TO OUR SUBSCRIPTION PLAN ON CCWHOLESALECLOTHING.COM</a></span>
			               <?php do_action('myofs_myaccount_content');?>
			              
			            </div>
			        
			        
			         </div>
			      </div>
			   </div>
			</div>
	    </div>
	</div>
</div>	