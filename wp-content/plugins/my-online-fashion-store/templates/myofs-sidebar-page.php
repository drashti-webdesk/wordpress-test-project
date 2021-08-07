<?php 
$page = isset($_GET['current_page']) && !empty($_GET['current_page']) ? $_GET['current_page'] : '1';
$limit = isset($_GET['limit']) && !empty($_GET['limit']) ? $_GET['limit'] : '30';
$search = isset($_GET['search']) && !empty($_GET['search']) ? base64_decode($_GET['search']) : ' ';
$sortby = isset($_GET['sortby']) && !empty($_GET['sortby']) ? $_GET['sortby'] : '';
$optval = isset($sortby) && !empty($sortby) ? trim( strtolower($sortby) ) : 'not';
$filterby = array('nto'=>'Newest to Oldest','otn'=>'Oldest to Newest','clh'=>'Cost: Low to High','chl'=>'Cost: High to Low');
$category_id = isset($_GET['category_id']) && !empty($_GET['category_id']) ? $_GET['category_id'] : '';
$menu =  isset($_GET['menu']) && !empty($_GET['menu']) ? $_GET['menu'] : '';
$menucls1 = isset($menu) && !empty($menu) ? 'sidebar-menu-expand' : '';
$menucls2 = isset($menu) && !empty($menu) ? 'sidebar-expand' : 'sidebar-collapse';
?>
<div class="page-sidebar-wrapper <?php echo $menucls1; ?>" id="myofs-sidebar">
	<div class="page-sidebar navbar-collapse collapse">
		<div id="sidebar-content">
		 	<span id="topsidebar-icon" class="sidebar-icon"></span>
			<ul class="page-sidebar-menu  page-header-fixed <?php echo $menucls2;?>">
				<li class="sidebar-toggler-wrapper" id="sidebar-collapse" aria-expanded="true">
                    <div class="sidebar-toggler">
                        <span class="sidebar-collapse-icon"></span>
                        <span class="sidebar-collapse-label">Collapse menu</span>
                    </div>
				</li>
				<div id="cat_disp">
					<?php 
						if (isset($_GET['category_name']) && !empty($_GET['category_name']) ) {?>
							<ul class='selected-cat'>
								<li>
									<a href='javascript:void(0);' id='clear_category'><?php echo trim($_GET['category_name']);?>   
										<i class='icon-close'></i>
									</a>
								</li>
							</ul>
							<?php 
						}
					?>
				</div>
				<!-- Categories -->
				<div class="side-panels">	
					<li class="heading Categories">
                        <h3 class="side-panel-title"><?php esc_html_e( 'Categories', 'my-online-fashion-store' ); ?></h3>
                    </li>
					<div id="category_data">
						<?php do_action('myofs_sidebar_categories');?>
					</div>	
				</div>
				<!-- Search Input -->
				<div class="side-panels">	
					<li class="heading Search">
                       <h3 class="side-panel-title"><?php esc_html_e( 'Search', 'my-online-fashion-store' ); ?></h3>
                    </li>
					<div>						
                        <li class="sidebar-search-wrapper">
                            <div class="sidebar-search" id="inventory_search">
                            	<?php if (!empty($search)) {?>
                                	<a style="display:none" href="javascript:;" class="btn submit" id="clear_search_inventory">
                                   		Clear <i class="fa fa-close"></i>
                               		</a>
                               	<?php } ?>
                               <div class="input-group">
                                   <input type="text" style="width: 83%;" class="form-control" name="serach" id="search" placeholder="Search..." value="<?php echo base64_decode($search);?>">
                                   <span class="input-group-btn">
                                       <a href="javascript:;" class="btn submit" id="search_filter">
                                           <i class="fa fa-search"></i>
                                       </a>										  
                                   </span>
                               </div>
                           	</div>
                        </li>
					</div>
				</div>
				<!-- Filter By -->
				<div class="side-panels">
					<li class="heading Filter">
						<h3 class="side-panel-title"><?php esc_html_e( 'Filter By', 'my-online-fashion-store' ); ?></h3>
					</li>
					<div>
						<li class="myofs-filter">
							<div class="input-group input-medium date date-picker" style="border:0">
								
								<select id="filter_by" name="filter_by" class="form-control">
									<?php
										foreach ($filterby as $key => $value) {
											echo '<option value = "'.$key.'" ';
											if($optval == $key) echo "selected";
											echo '>'.$value.'</option>';
										}
									?>
								</select>
							</div>
						</li>
					</div>
				</div>
				<!-- Banner Images -->
				<div class="side-panels side-banner" id="side_banner">
					<a href="<?php echo MYOFS_PLANUPGRADE_PATH;?>"  target="_blank"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/BOXBANNERANNUAL.jpg';?>"></a>
				</div>
				<div class="side-panels side-banner" id="side_banner2">
					<a href="<?php echo MYOFS_CUSTOMPACKEING_PATH;?>" target="_blank"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/SQUARELAYOUT.jpg';?>"></a>
				</div>
				<!-- Helpful Tips & Update -->
				<div class="LeftCarousel"> 
					<div class="LeftCarousel_inner"> 
						<div class="LeftCarousel_grid"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/SOLDmar2021.jpg';?>" alt="HELPFULTIPS7MAY.jpg" /></div>
						<div class="LeftCarousel_grid"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/HELPFULTIPS2.jpg';?>" alt="HELPFULTIPS2.jpg" /></div>
						<div class="LeftCarousel_grid"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/HELPFULTIPS3.jpg';?>" alt="HELPFULTIPS3.jpg" /></div>
						<div class="LeftCarousel_grid"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/HELPFULTIPS4.jpg';?>" alt="HELPFULTIPS4.jpg" /></div>
						<div class="LeftCarousel_grid"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/HELPFULTIPS5.jpg';?>" alt="HELPFULTIPS5.jpg" /></div>
						<div class="LeftCarousel_grid"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/HELPFULTIPS6.jpg';?>" alt="HELPFULTIPS6.jpg" /></div>
						<div class="LeftCarousel_grid"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/HELPFULTIPS7.jpg';?>" alt="HELPFULTIPS7.jpg" /></div>
						<div class="LeftCarousel_grid"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/HELPFULTIPS8.jpg';?>" alt="HELPFULTIPS8.jpg" /></div>
						<div class="LeftCarousel_grid"><img src="<?php echo MYOFS_PUBLIC_IMG_PATH.'sidebar/HELPFULTIPS9.jpg';?>" alt="HELPFULTIPS9.jpg" /></div>
					</div>
				</div>
			</ul>
			<input value="<?php echo admin_url('admin-ajax.php'); ?>" id="admin-url" class="admin-url" type="hidden" />
			<input type="hidden" name="page" id="page" value="<?php echo esc_attr($page); ?>">
			<input type="hidden" name="limit" id="limit" value="<?php echo esc_attr($limit); ?>">
			<input type="hidden" name="sortby" id="sortby" value="<?php echo esc_attr($sortby); ?>">
			<input type="hidden" name="category_id" id="category_id" value="<?php echo esc_attr($category_id);?>">
			<input type="hidden" name="myofs_plugin_url" id="myofs_plugin_url" value="<?php echo get_admin_url('',MYOFS_PLUGIN_URL); ?>">
		</div>
	</div> 
</div>