var baseurl,inventorytab,myinventorytab,category_id,sortby,limit,category_name,page,search,redirect_url,Base64,qryurl,start_notice_html,start_error_html,end_errnotice_html,proid_cnt,product_type,combain_product,ajaxurl,menu;
jQuery( document ).ready(function() {	
    ajaxurl        = jQuery("#admin-url").val();
    baseurl        = jQuery('#myofs_plugin_url').val();
    inventorytab   = baseurl+'&tab=all-inventory';
    myinventorytab = baseurl+'&tab=my-inventory';
	Base64  = {_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
	qryurl  = '';
	jQuery('#page').val('1');
    limit       = jQuery("#limit").val();
    sortby      = jQuery("#sortby").val();
    category_id = jQuery("#category_id").val();        
    search      = jQuery("#search").val(); 
    page        = jQuery("#page").val();
    start_notice_html  = '<div id="message" class="updated notice is-dismissible "><p>';
	start_error_html   = '<div id="message" class="error notice is-dismissible "><p>';
	end_errnotice_html = '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';


    inventorySidebarFilters();
    sidebarslider();
    categoryFilter();
    categorySubmenu();//submenu open close
    if(jQuery('#myofs_productdta').hasClass('myofs_inventory')){

        detailProductDisplay();//detail product popup
        closeProductDetailDisplay();//close popup
        addProducToWCStoreDisplay();//add to product wc popup
        closeaddProducToWCStoreDisplay();//close popup
        selectUnselectProduct(); //products selection
        selectionDropdown();
        multipleProductAdd();// multiple product
        combineProductAdd();//combine product
        itemAddToWC();//item add to wc
        removeSingleProduct();//remove product
        removemultiProducts();// remove multiple all product
    } else if(jQuery('#myofs_myinvproductdta').hasClass('myofs_inventory')){
    	detailProductDisplay();//detail product popup
        closeProductDetailDisplay();//close popup                
        selectUnselectProduct(); //products selection
        selectionDropdown();
        removeSingleProduct();//remove product
        removemultiProducts();//remove multiple products
    }  
    
       
    /*remove success add popup*/
    jQuery('#snackbar .close').click(function () {
        jQuery('#snackbar').removeClass('show_spin');
        jQuery('#snackbar').html('<a class="close" href="javascript:void(0);">×</a><br>');
    });
   
});

function inventorySidebarFilters(){
    
    jQuery('#limitbox').change(function() {
        limit       = jQuery(this).val();       
        returnSuccessRedirect(limit,sortby,category_id,search,page);
    });
    //pagination
    jQuery('#myofs_productdta .myofs-pagination li.active').click(function () {
        page        = jQuery(this).attr('p');
        returnSuccessRedirect(limit,sortby,category_id,search,page);
    }); 
    /*sortby*/
    jQuery('#filter_by').change(function() {
        sortby      = jQuery(this).val();     
        returnSuccessRedirect(limit,sortby,category_id,search,page);             
        
    });
    // search input
    jQuery('#search_filter').click(function () {
        search = jQuery("#search").val();
        if (search != '') {            
            search = Base64.encode(search);
        	returnSuccessRedirect(limit,sortby,category_id,search,page);

        } else {
            var display = jQuery("#clear_search_inventory").css("display");
            if( display == 'block' ){
                jQuery('#clear_search_inventory').trigger('click');
            }
            jQuery("#search_inventory").focus();
        }
    });
    jQuery("#clear_search_inventory").click(function() {        
        jQuery(this).hide();      
        jQuery("#search").val('');
        search = jQuery("#search").val();            
        returnSuccessRedirect(limit,sortby,category_id,search,page);          
    });    
}

function sidebarslider(){
    //sidebar slider 
    jQuery('.LeftCarousel .LeftCarousel_inner').slick({
        dots: false,
        arrows: true,
        infinite: false,
        autoplay: false,
        autoplaySpeed: 5000,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        /*slide: '.LeftCarousel_grid', */
        responsive: [
            {
                breakpoint: 990,
                settings: { 
                   slidesToShow: 1,
                   slidesToScroll: 1
                }
            }, 
            {
                breakpoint: 767,
                settings: {
                   slidesToShow: 1,
                   slidesToScroll: 1
                }
            },
            {
                breakpoint: 479,
                settings: {
                   slidesToShow: 1,
                   slidesToScroll: 1
                }
            } 
        ]
    }); 
}
// category filter
function categoryFilter(){
    // category filter
    jQuery('.myofs-nav-item .title').click(function() {
        category_id   = jQuery(this).attr('id');
        category_name = jQuery(this).text();        
        
        if (sortby.length > 0) {
            qryurl += 'sortby='+sortby+'&';
        }
        if (category_id.length > 0) {
            qryurl += 'category_id'+'='+category_id+'&'+'category_name'+'='+category_name+'&';
            qryurl += 'category_id='+category_id+'&';
        }
        if (search.length > 0) {
            qryurl += 'search='+Base64.encode(search)+'&';
        }
        if (jQuery('#myofs-sidebar').hasClass('sidebar-menu-expand')) {
            qryurl += '&menu=expand';
        }
        redirect_url = inventorytab+'&'+'limit'+'='+limit+'&'+'current_page'+'='+page+'&'+qryurl;
        window.location.href = redirect_url; 
        
    });
    /*clear category filter*/
    jQuery('#clear_category').click(function() {
        jQuery("#category_id").val('');
             
        category_id   = jQuery("#category_id").val();
        page          =  1;
        search        = jQuery("#search").val();
        if (sortby.length > 0) {
            qryurl += 'sortby='+sortby+'&';
        }
        if (category_id.length > 0) {
            qryurl += 'category_id='+category_id+'&';
        }
        if (search.length > 0) {
            qryurl += 'search='+Base64.encode(search)+'&';
        }
        if (jQuery('#myofs-sidebar').hasClass('sidebar-menu-expand')) {
            qryurl += '&menu=expand';
        }
        redirect_url = inventorytab+'&'+'limit'+'='+limit+'&'+'current_page'+'='+page+'&'+qryurl;

        window.location.href = redirect_url;             
    });
}
/*collspan category sub menus*/
function categorySubmenu(){
    jQuery('li.myofs-nav-item .arrow').click(function (event) {
        event.preventDefault(); //prevent default action
      jQuery(this).toggleClass('open');
      jQuery(this).parents('li.myofs-nav-item').toggleClass('open');
    });   
}
// View Details of Products on popup
function detailProductDisplay(){
    jQuery('.detail-view').click(function (event) {       
        event.preventDefault(); //prevent default action
        var productid = jQuery(this).attr('data-product-id');
        var ajaxurl = jQuery("#admin-url").val();
        var post_data = {
            productid: productid,
            action: "productdisplay",
        };
        jQuery.ajax({
            type: 'GET',
            url: ajaxurl,
            data: post_data,
            dataType:"JSON",
            beforeSend: function() {
             jQuery(".apploader").css({"display":"block","background-color":"black","z-index":"999","width":"100%","opacity":"0.5"});
                          
            },
            success: function (response) {
                jQuery(".apploader").removeAttr('style');
                if(response.status == 1){
                    jQuery("#product_details").html(response.data);
                    jQuery('html,body').animate({
                        scrollTop: jQuery("#product_details").offset().top
                    },'slow');
                    closeProductDetailDisplay();
                }
           
            },
            error: function (errorThrown) {}
        });  
    });   
}
// close detail product popup
function closeProductDetailDisplay(){
    jQuery('#product_details .close').click(function () {
        jQuery("#product_details").html("");
    });
}
// add product to wc popup
function addProducToWCStoreDisplay(){
    jQuery(document).on('click', '#myofs_add_wc', function (event) {
        event.preventDefault(); //prevent default action       
        product_id    = jQuery(this).attr('data-product-id');
        /*product_name  = jQuery(this).attr('data-product-name');
        product_stock = jQuery(this).attr('data-product-stock');
        product_sku   = jQuery(this).attr('data-product-sku');*/
        product_type  = 'single';
        combain_product = 0;
        proid_cnt = product_id.length;
        addToPopupAjaxCall(product_id,product_type,proid_cnt,combain_product);
    });
     /*collection hide show*/  
    jQuery(document).on('click', '.add_categorytostore', function () {
        jQuery('#collection_select').hide();
        jQuery('#collection_manully').show();
        jQuery('#collection_type').val('manully');
    });
    jQuery(document).on('click', '.gocategorylist', function () {
        jQuery('#collection_select').show();
        jQuery('#collection_manully').hide();
        jQuery('#collection_type').val('select');
    });
    /*end collection hide show*/  
    
}
function addToPopupAjaxCall(product_id,product_type,proid_cnt,combain_product){
    
    var post_data = {
        productid: product_id,
        product_type: product_type,
        action: "gettagcategories"
    };
    jQuery.ajax({
        type: 'GET',
        url: ajaxurl,
        data: post_data,
        dataType:"JSON",
        beforeSend: function() {           
            jQuery(".apploader").css({"display":"block","background-color":"black","z-index":"999","width":"100%","opacity":"0.5"});
        },
        success: function (response) {
            jQuery(".apploader").removeAttr('style');
            if(response.status == 1){
                var cat  = response.data.category;
                var clen = cat.length;
                for(var i=0; i<clen; i++){
                    var cat_html = '<option value="'+cat[i].id+'">'+cat[i].name+'</option>';
                    jQuery('#myofs_categoryid').append(cat_html);                        
                }
                if( proid_cnt == 1 ){ 
                    jQuery('#pro_default_tag').show();
                    jQuery('#modal_pro_tags').html(response.data.tags);
                }else{
                    jQuery('#pro_default_tag').hide();
                }
               
                jQuery('#modal_pro_id').val(product_id);
                jQuery('#combain_product').val(combain_product);                
                jQuery('#collection_type').val('select');
                jQuery('#addtowc_modal').addClass('in');
                jQuery('#addtowc_modal').show();
               /* jQuery("#myofs_categoryid").select2({
                      placeholder: "Select a collection",
                      allowClear: true
                });*/
                /*
                jQuery('html,body').animate({
                    scrollTop: jQuery("#product_addtowc").offset().top
                },'slow');*/
            }
        },
        error: function (errorThrown) {}
    }); 
}
/*add single product to wc submit */
function itemAddToWC(){    
    jQuery(document).on('click', '#addtomyofs_btn', function (event) {
    //jQuery("#addtomyofs_btn").click(function (event) {
        event.preventDefault(); //prevent default action
        jQuery('#addtomyofs_btn').prop('disabled', false);         
        jQuery('#addtowc_modal #myofs-layout__notice-list').empty();
        var collection_type  = jQuery('#collection_type').val();
        var amnt             = jQuery('#amount').val();
        var productname      = jQuery('#modal_pro_name').val();
        if(collection_type == 'select'){
            var categoryids = jQuery('#myofs_categoryid option:selected').toArray().map(item => item.value).join();
        }else{
            var categoryids = jQuery('#categoryid_nm').val();
        }
        if(amnt != undefined && amnt != null && amnt != ''){
            var amount = amnt;
        }else{ var amount = ''; }  
        
        if( categoryids == '' && (amount == '' && amount <= 0) ) { 
            jQuery('#addtowc_modal #myofs-layout__notice-list').html(start_error_html + 'Please select collection & select valid amount' + end_errnotice_html);
            jQuery('#addtomyofs_btn').prop('disabled', false);
            jQuery('#addtowc_modal').animate({
                scrollTop: jQuery("#myofs-layout__notice-list").offset().top
            },'slow');
            return false;
        }else if(categoryids == undefined || categoryids == ''){ 
            
            jQuery('#addtowc_modal #myofs-layout__notice-list').html(start_error_html + 'Please select collection' + end_errnotice_html);
            jQuery('#addtomyofs_btn').prop('disabled', false); 
            jQuery('#addtowc_modal').animate({
                scrollTop: jQuery("#myofs-layout__notice-list").offset().top
            },'slow');
            return false; 
        }else if(amount == '' && amount <= 0){ 
            
            jQuery('#addtowc_modal #myofs-layout__notice-list').html(start_error_html + 'Please select valid amount' + end_errnotice_html);
            jQuery('#addtomyofs_btn').prop('disabled', false); 
            jQuery('#addtowc_modal').animate({
                scrollTop: jQuery("#myofs-layout__notice-list").offset().top
            },'slow');
            return false; 
        }else{
            var form_data = jQuery('#addtostore_form').serialize();                 
            var name = '';
            if(productname != ''){
                name = productname;
            }
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: form_data,
                dataType: "json",
                beforeSend: function() {
                    jQuery(".apploader").css({"display":"block","background-color":"black","z-index":"999","width":"100%","opacity":"0.5"});
                     
                },
                success: function (response) {
                    jQuery(".apploader").removeAttr('style');
                    if( response.status == 1 ){
                        jQuery('#addtowc_modal').removeClass('in');
                        jQuery('#addtowc_modal').hide();
                        jQuery('#snackbar').addClass('show_spin');
                        if(response.count > 1){
                         jQuery('#snackbar').append(response.count+' out of '+response.total_product+' products has been migrated successfully... ');
                        } else{
                         jQuery('#snackbar').append(name +' product has been migrated successfully... ');
                        }
                        jQuery("#addtostore_form")[0].reset();
                        
                        setTimeout(function(){
                        	jQuery('#snackbar').removeClass('show_spin');                        
        					returnSuccessRedirect(limit,sortby,category_id,search,page);
                            
                        }, 1000);
                        
                    }else{ 
                        jQuery('#addtowc_modal #myofs-layout__notice-list').empty();                     
                        if( response.error.product !== '' ) {
                            jQuery('#addtowc_modal #myofs-layout__notice-list').append(start_error_html + response.error.product + end_errnotice_html);
                        }
                        if( response.error.category  !== ''  ) {
                            jQuery('#addtowc_modal #myofs-layout__notice-list').append(start_error_html + response.error.category + end_errnotice_html);
                        }
                        if( response.error.amount  !== ''  ) {
                            jQuery('#addtowc_modal #myofs-layout__notice-list').append(start_error_html + response.error.amount + end_errnotice_html);
                        }

                    }
                    
                },
                error: function (errorThrown) {}
            }); 
            
        }

    });
}
// close add product to wc popup
function closeaddProducToWCStoreDisplay(){
    jQuery(document).on('click', '#addtowc_modal .close,#addtocancle', function () {
        jQuery("#addtostore_form")[0].reset();
        jQuery('#addtowc_modal').removeClass('in');
        jQuery('#addtowc_modal').hide(); 
    });
}
/*select single product checkbox*/
function selectUnselectProduct() {   
    jQuery(document).on('click', '.product_id', function () {   
        var val = jQuery(this).val();           
        if (jQuery(this).is(":checked")){ 
                      
            jQuery(this).closest("div.portlet").addClass("Pro_selected");
            jQuery(".pro-add-rmv a[data-product-id$=" + val + "]").hide();
            jQuery("#" + val).parent(".check_cnt").addClass("active_check_cnt");
            checkb();            
        }else{        
            
            jQuery(this).closest("div.portlet").removeClass("Pro_selected");
            jQuery(".pro-add-rmv a[data-product-id$=" + val + "]").show();
            checkb();
        }
    });
    
}
/*selected base show combine , multiple ,remove products buttons*/
function checkb(){ 
    var checkboxes = jQuery('.product_id');
    
    checkboxes.change(function() {    
        var count = checkboxes.filter(':checked').length;
        if (count > 0) { 
            if(jQuery('#myofs_productdta').hasClass('myofs_inventory')){
                jQuery("#multi-add:first").remove();
                jQuery("#multi-combine-add:first").remove();
                jQuery("#selection").after('<a class="add-wc uppercase" id="multi-add" href="javascript:void(0);" style="display: inline-block;">Add to Woocommerce</a>');
                jQuery( "#selection").after('<a class="add-wc uppercase" id="multi-combine-add" href="javascript:void(0);" style="display: inline-block;">COMBINE PRODUCTS & ADD</a>');      
            }  
            
            if (jQuery(".Pro_selected a").hasClass("myofs-remove-wc")) {
                
                jQuery("#section_n").html('<a class="remove-wc uppercase" id="remove-product" href="javascript:void(0);" style="display: inline-block;">Remove Products</a>');
            } else {
                
                jQuery("#section_n").html('');
            }
        } else {
            if(jQuery('#myofs_productdta').hasClass('myofs_inventory')){
                jQuery("#multi-add:first").remove();
                jQuery("#multi-combine-add:first").remove();
            }
            jQuery("#section_n").html('');
        }
    });
}
/*remove single product*/
function removeSingleProduct(){
    var sids = new Array();
    jQuery(document).on('click', '#myofs-remove-wc', function () {
        var prid = "#large"+jQuery(this).attr('data-product-id'); 
        jQuery(prid).addClass('in');
        jQuery(prid).show();        
    });  
    jQuery(document).on('click', '#rmv_product', function () {
        var pid = jQuery(this).parent().attr('data-product-id');        
        sids.push(pid);
        jQuery("#large"+pid).removeClass('in');
        jQuery("#large"+pid).hide();
        removeProductAjaxCall(sids);
    });
    jQuery(document).on('click', '.rmv_cancel', function () {
        var pid = jQuery(this).parent().attr('data-product-id');
        jQuery("#large"+pid).removeClass('in');
        jQuery("#large"+pid).hide();
    });
    
}
/*remove multiple products*/
function removemultiProducts(){
    var product_ids = new Array();
    jQuery(document).on('click', '#remove-product', function () {
        if (jQuery(".Pro_selected").is(":not(.item_added_pro_c)")) {
            jQuery("#snackbar").html('<a class="close" href="javascript:void(0);">×</a><br>You have selected unadded product. Please remove it from selected products... ');
            jQuery('#snackbar').addClass('show_spin');                        
            setTimeout(function(){ jQuery('#snackbar').removeClass('show_spin');}, 1000);
        }else{
            jQuery("#multiallinventory").addClass('in');
            jQuery("#multiallinventory").show();
            jQuery(document).on('click', '#rmv_mulpro', function () {
                jQuery.each(jQuery(".product_id:checked"), function() {
                    product_ids.push(jQuery(this).val());
                });
                jQuery("#multiallinventory").removeClass('in');
                jQuery("#multiallinventory").hide();
                removeProductAjaxCall(product_ids);
            });
            jQuery(document).on('click', '.rmv_mulcancel', function () {
                jQuery("#multiallinventory").removeClass('in');
                jQuery("#multiallinventory").hide();
            });
        }
    });

}
function removeProductAjaxCall(product_id){
    
    var post_data = {
        ids:product_id,
        action:'productremovetowcstore'
    };
    jQuery.ajax({
        type: 'GET',
        url: ajaxurl,
        data: post_data,
        dataType: "json",
        beforeSend: function() {
            jQuery(".apploader").css({"display":"block","background-color":"black","z-index":"999","width":"100%","opacity":"0.5"});
        },
        success: function (response) {
            jQuery(".apploader").removeAttr('style');
            
            if( response.status == 1 ){
                jQuery('#snackbar').addClass('show_spin');
                jQuery('#snackbar').append(' product has been deleted successfully... ');
                setTimeout(function(){
                	jQuery('#snackbar').removeClass('show_spin');                        
					returnSuccessRedirect(limit,sortby,category_id,search,page);
                    
                }, 1000);
            }else{                    
                if (response.error.api_error) {
                    jQuery('#snackbar').append(response.error.api_error);

                } else if(response.error.product){
                    jQuery('#snackbar').append(response.error.product);
                }
                jQuery('#snackbar').addClass('show_spin');
                setTimeout(function(){
                    jQuery('#snackbar').removeClass('show_spin');                        
                }, 1000);
            }
        },
        error: function (errorThrown) {}
    }); 
}
/*multiple products add to wc*/
function multipleProductAdd(){
    jQuery(document).on('click', '#multi-add', function () {
        if (jQuery(".Pro_selected").hasClass("item_added_pro_c")) {
            jQuery("#snackbar").html('<a class="close" href="javascript:void(0);">×</a><br> You have selected already added product. Please remove it from selected products... ');

            jQuery('#snackbar').addClass('show_spin');
            setTimeout(function(){ jQuery('#snackbar').removeClass('show_spin');}, 1000);
        }else{ 
            jQuery('#addtomyofs_btn').prop('disabled', false);
            //jQuery('.selectpicker').selectpicker('deselectAll'); 
            var ids = new Array();
            jQuery.each(jQuery(".product_id:checked"), function() {
                ids.push(jQuery(this).val());
            });
            jQuery('#modal_pro_id').val(ids);     
            proid_cnt = ids.length;
            product_type = 'multiple';
            if (proid_cnt == 1) {
                product_type = 'single';
            }
            combain_product = 0;
            addToPopupAjaxCall(ids,product_type,proid_cnt,combain_product);   
        }  
    });
}
//combine product add to wc
function combineProductAdd(){
    jQuery(document).on('click', '#multi-combine-add', function () {
        
        jQuery('#addtomyofs_btn').prop('disabled', false);
        var ids = new Array();
        jQuery.each(jQuery(".product_id:checked"), function() {
            ids.push(jQuery(this).val());
        });
        jQuery('#modal_pro_id').val(ids); 
        var ajaxurl     = jQuery("#admin-url").val();
        proid_cnt       = ids.length; 
        product_type    = 'combine';
        combain_product = 1;  
        var post_data = {
            productid: ids,
            action: "checkcombineproduct"
        }; 
        jQuery.ajax({
            type: 'GET',
            url: ajaxurl,
            data: post_data,
            dataType:"JSON",
            beforeSend: function() {
                jQuery(".apploader").css({"display":"block","background-color":"black","z-index":"999","width":"100%","opacity":"0.5"});
                             
            },
            success: function (response) {
                jQuery(".apploader").removeAttr('style');
                if(response.status == 1){
                    addToPopupAjaxCall(ids,product_type,proid_cnt,combain_product);
                   
                } else {  
                    jQuery("#snackbar").html('<a class="close" href="javascript:void(0);">×</a><br>'+response.message);
                    jQuery('#snackbar').addClass('show_spin');                       
                    setTimeout(function(){ jQuery('#snackbar').removeClass('show_spin');}, 1000);
                } 
                
            },
            error: function (errorThrown) {}
        });
	    
    });
}
//selection  dropdown. select all,inverser select all, remove all dropdown
function selectionDropdown(){
    jQuery("#selectionbox").change(function () {
        var value = jQuery(this).val();
        if(value == 'selectall'){
            selectAll();
        }else if(value == 'removeselectall'){
            removeSelectAll();
        }else if(value == 'inverseselectall'){
            inverseSelectAll();
        }
        jQuery(this).val(0);
    });
}
//select all products
function selectAll(){
    jQuery(".product_id").each(function() {
        this.checked = true;
        jQuery(this).closest("div.portlet").addClass("Pro_selected");
        var val = jQuery(this).attr("id");
        jQuery(".pro-add-rmv a[data-product-id$=" + val + "]").hide();
    });

    var checkboxes = jQuery('.product_id');
    var count = checkboxes.filter(':checked').length;
    if (count > 0) { 
        if(jQuery('#myofs_productdta').hasClass('myofs_inventory')){  
            jQuery("#multi-combine-add:first").remove();
            jQuery("#multi-add:first").remove();
            jQuery("#selection").after('<a class="add-wc uppercase" id="multi-add" href="javascript:void(0);" style="display: inline-block;">Add to Woocommerce</a>');
            jQuery( "#selection").after('<a class="add-wc uppercase" id="multi-combine-add" href="javascript:void(0);" style="display: inline-block;">COMBINE PRODUCTS & ADD</a>'); 
        }
        if (jQuery(".Pro_selected a").hasClass("myofs-remove-wc")) {
                
            jQuery("#section_n").html('<a class="remove-wc uppercase" id="remove-product" href="javascript:void(0);" style="display: inline-block;">Remove Products</a>');
        }
    } else {  
        if(jQuery('#myofs_productdta').hasClass('myofs_inventory')){  

            jQuery("#multi-combine-add:first").remove();
            jQuery("#multi-add:first").remove();
        }
        jQuery("#section_n").html('');
    }
}
// Remove selected all products
function removeSelectAll() {   

    jQuery(".product_id").each(function() {
        this.checked = false;
        jQuery(this).closest("div.portlet").removeClass("Pro_selected");
        var val = jQuery(this).attr("id");
        jQuery(".pro-add-rmv a[data-product-id$=" + val + "]").show();
        
    });
    var checkboxes = jQuery('.product_id');
    var count = checkboxes.filter(':checked').length;
        if (count > 0) {

            if(jQuery('#myofs_productdta').hasClass('myofs_inventory')){  
                jQuery("#multi-add:first").remove();
                jQuery("#multi-combine-add:first").remove();
                jQuery("#selection").after('<a class="add-wc uppercase" id="multi-add" href="javascript:void(0);" style="display: inline-block;">Add to Woocommerce</a>');
            }
                jQuery( "#selection").after('<a class="add-wc uppercase" id="multi-combine-add" href="javascript:void(0);" style="display: inline-block;">COMBINE PRODUCTS & ADD</a>'); 
            
        } else {
            if(jQuery('#myofs_productdta').hasClass('myofs_inventory')){  

                jQuery("#multi-add:first").remove();
                jQuery("#multi-combine-add:first").remove();
            }
            jQuery("#section_n").html('');
        }
}
//inverse product.selected all products and remove all products(toggle)
function inverseSelectAll(){
    jQuery(".product_id").each(function() {
        var val = jQuery(this).attr("id");
        if (!this.checked) {
            this.checked = true;
            jQuery(this).closest("div.portlet").addClass("Pro_selected");
            jQuery(".pro-add-rmv a[data-product-id$=" + val + "]").hide();
            
        } else {
            this.checked = false;
            jQuery(this).closest("div.portlet").removeClass("Pro_selected");
            jQuery(".pro-add-rmv a[data-product-id$=" + val + "]").show();
            
        }
    });
    var checkboxes = jQuery('.product_id');
    var count = checkboxes.filter(':checked').length;
    if (count > 0) {
        if(jQuery('#myofs_productdta').hasClass('myofs_inventory')){  

            jQuery("#multi-combine-add:first").remove();
            jQuery("#multi-add:first").remove();
            jQuery("#selection").after('<a class="add-wc uppercase" id="multi-add" href="javascript:void(0);" style="display: inline-block;">Add to Woocommerce</a>');
            jQuery( "#selection").after('<a class="add-wc uppercase" id="multi-combine-add" href="javascript:void(0);" style="display: inline-block;">COMBINE PRODUCTS & ADD</a>'); 
        }

        if (jQuery(".Pro_selected a").hasClass("myofs-remove-wc")) {
                
            jQuery("#section_n").html('<a class="remove-wc uppercase" id="remove-product" href="javascript:void(0);" style="display: inline-block;">Remove Products</a>');
        }
    } else {
        if(jQuery('#myofs_productdta').hasClass('myofs_inventory')){  

            jQuery("#multi-add:first").remove();
            jQuery("#multi-combine-add:first").remove();
        }
        jQuery("#section_n").html('');
    }
}

function returnSuccessRedirect(limit,sortby,category_id,search,page){
    qryurl = '';
    if (sortby.length > 0) {
        qryurl += 'sortby='+sortby+'&';
    }
    if (category_id.length > 0) {
        qryurl += 'category_id='+category_id+'&';
    }
    if (search.length > 0) {
        qryurl += 'search='+Base64.encode(search)+'&';
    }
    if (jQuery('#myofs-sidebar').hasClass('sidebar-menu-expand')) {
        qryurl += '&menu=expand';
    }

    if(jQuery('#myofs_myinvproductdta').length > 0){ 
    	
    	redirect_url = myinventorytab+'&'+'limit'+'='+limit+'&'+'current_page'+'='+page+'&'+qryurl; 
        window.location.href = redirect_url;
    }else{
    	
        redirect_url = inventorytab+'&'+'limit'+'='+limit+'&'+'current_page'+'='+page+'&'+qryurl;
        window.location.href = redirect_url;
    }
}