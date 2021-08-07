<div class="wrap">	
	<div class="myofs-layout" id="myofs-layout__notice-list"></div>
	<div class="apploader"><div class="loader"></div></div>
	<div id="firstt">
		<div id="snackbar">
			<a class="close" href="javascript:void(0);">×</a>
			<br>
		</div>
	</div>
	<!-- page sidebar  -->
		<?php load_template(MYOFS_PLUGIN_TEMPLATE_PATH.'myofs-sidebar-page.php');?>
	<!-- end sidebar -->
	<div class="page-content-wrapper" style="position: relative;">
		<div class="page-content" style="min-height: 1312px;">
			<div class="page-bar">
				<h1 class="wp-heading-inline" id="dynamic_heading_title">My Inventory</h1>
			</div>
			<div class="myofs_inventory" id="myofs_myinvproductdta">
				<?php do_action('myofs_my_inventory_products');?>
			</div>
		</div>
	</div>
	
</div>