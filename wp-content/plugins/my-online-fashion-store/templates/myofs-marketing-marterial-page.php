<?php
$MYOFS_Api   = new MYOFS_API();
$marketing  = $MYOFS_Api->GetMarketingMaterial();
$marketingdata = $marketing['data'];
?>
<div class="wrap">	
	<!-- page sidebar  -->
		<?php load_template(MYOFS_PLUGIN_TEMPLATE_PATH.'myofs-sidebar-page.php');?>
	<!-- end sidebar -->
	<div class="page-content-wrapper">	
		<div class="page-content">	
		    <div class="page-bar">
				<h1 class="wp-heading-inline" id="dynamic_heading_title"><?php esc_html_e('Marketing Material','my-online-fashion-store');?></h1>
				<p class="header_img">
					<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/FREEBANNERBANNER.jpg'; ?>">
				</p>
			</div>	
			<div class="row" id="product_data">
				<?php if($marketingdata['status'] == 1){ ?>
					<ul class="marketing_material">
						<?php 						
						foreach($marketingdata['data'] as $marketing_s)
						{ ?>
							<li>
								<a href="<?php echo MYOFS_MARKETINGMATERIAL_PATH.$marketing_s['banner_file'];?>" download="<?php echo $marketing_s['banner_file'];?>"><span><?php echo strtoupper($marketing_s['b_name']);?></span> DOWNLOAD FILE </a>
							</li>
							<?php 
						} ?>
					</ul>	
				<?php } ?>
				<div class="marketing_info">
					<div class="check_banner">
						<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/FIVERRBANNER.jpg';?>">
					</div>
					<h3>
						<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2868713&show_join=true';?>" target="_blank"><?php esc_html_e('Find Freelance Services For Your Business Marketing Needs Today!', 'my-online-fashion-store');?></a>
					</h3>
					<p>
						Access 	<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2868720&show_join=true';?>" target="_blank">FIVERR.com</a><?php esc_html_e (' for an assortment of marketing services including SEO, SOCIAL MEDIA MARKETING, SOCIAL MEDIA ADVERTISING, CONTENT MARKETING, SEM, VIDEO MARKETING, EMAIL MARKETING, E-COMMERCE MARKETING, WEB TRAFFIC, INFLUENCER MARKETING, MOBILE MARKETING & ADVERTISING and much more.
                            ', 'my-online-fashion-store');?></p>
					<h4>
						<?php esc_html_e('Find a qualified freelances no matter what your budget is,', 'my-online-fashion-store');?> <a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2868720&show_join=true';?>" target="_blank">CLICK HERE FOR MORE INFO!</a>
					</h4>
					<ul>
						<li>
							<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=7
							1310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2964945&show_join=true';?>" target="_blank">
								<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/BANNER1.jpg';?>">
							</a>						
						</li>
						<li>
							<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2964945&show_join=true';?>" target="_blank">
								<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/BANNER2.jpg';?>">
							</a>
						</li>
						<li>
							<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2964945&show_join=true';?>" target="_blank">
								<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/BANNER3.jpg';?>">
							</a>
						</li>
						<li>
							<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2964945&show_join=true';?>" target="_blank">
								<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/BANNER4.jpg';?>">
							</a>
						</li>
						<li>
							<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2964945&show_join=true';?>" target="_blank">
								<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/BANNER5.jpg';?>">
							</a>
						</li>
						<li>
							<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2964945&show_join=true';?>" target="_blank">
								<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/BANNER6.jpg';?>">
							</a>
						</li>
						<li>
							<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2964945&show_join=true';?>" target="_blank">
								<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/BANNER7.jpg';?>">
							</a>
						</li>
						<li>
							<a href="<?php echo MYOFS_MARKETINGMATERIAL_BANNER_PATH.'&utm_source=71310&utm_medium=cx_affiliate&utm_campaign=&cxd_token=71310_2964945&show_join=true';?>" target="_blank">
								<img src="<?php echo MYOFS_PUBLIC_IMG_PATH . 'marketing_material/BANNER8.jpg';?>">
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>	
</div>