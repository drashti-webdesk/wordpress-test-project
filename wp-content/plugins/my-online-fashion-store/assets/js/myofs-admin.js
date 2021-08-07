/*activation keys*/
var ajaxurl,start_notice_html,start_error_html,end_notice_html;
jQuery(document).ready(function () {
    start_notice_html = '<div id="message" class="updated notice is-dismissible "><p>';
    start_error_html  = '<div id="message" class="error notice is-dismissible "><p>';
    end_notice_html   = '</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
    ajaxurl           = jQuery("#admin-url").val(); 
    activationKey();
    //removeActivationKey();// remove key
    helpSectionAccordian();//help page
    returnSectionFormSubmit()//free return page
    sidebarCollapse();
});

function activationKey(){
    jQuery("#myofs-activate-keys").validate({
        rules: {
            activation_email: {
                required: true,
                email: true
            } ,
            activation_key: "required"     
        },
        messages: {
            activation_email: {
                required: "This field is required",
                email: "Please enter a valid email address"
            },                   
            activation_key: "This field is required"
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            jQuery('#myofs-layout__notice-list').html();
            var $form     = jQuery(form);            
            var form_data = $form.serialize();
            jQuery.ajax({
                type:"POST",
                url: ajaxurl,
                dataType: "json",
                data: form_data,
                beforeSend: function() {
                    jQuery(".spin_main").css('display','block');
                },
                success: function (response) {
                    jQuery(".spin_main").removeAttr('style');
                    jQuery(".spin_main").css('display','none');
                    if (response.status == 1) {
                        jQuery('#myofs-layout__notice-list').html(start_notice_html + response.success + end_notice_html);
                        location.reload();                   
                    }else{
                        jQuery('#myofs-layout__notice-list').html(start_error_html + response.error + end_notice_html);
                    }
                },
                error: function (errorThrown) {}
            });
        }
    });
}
/*function removeActivationKey(){
    jQuery('#remove_key').click(function (event) {
        event.preventDefault(); //prevent default action
        var confirmation = confirm ("Are you sure you want to remove activation key and all products?");
        if (confirmation)
        {
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: "json",
                data: {'action':'myofs_remove_keys'},
                beforeSend: function() {
                    jQuery(".spin_main").css('display','block');
                },
                success: function (response) {
                    jQuery(".spin_main").removeAttr('style');
                    jQuery(".spin_main").css('display','none');
                    if (response.success) {
                        window.location.replace(response.success);                   
                    }else if(response.error){jQuery('#myofs-layout__notice-list').html(start_error_html + response.error + end_notice_html);}
                },
                error: function (errorThrown) {}
            });
        }
    }); 
}*/

//Help Section accordion
function helpSectionAccordian(){
   jQuery(".acc-set > h4").on("click", function() {
        if (jQuery(this).hasClass("active")) {
          jQuery(this).removeClass("active");
          jQuery(this).siblings(".content").slideUp(200);
          jQuery(".acc-set > h4 i").removeClass("fa-minus").addClass("fa-plus");
        } else {
          jQuery(".acc-set > h4 i").removeClass("fa-minus").addClass("fa-plus");
          jQuery(this).find("i").removeClass("fa-plus").addClass("fa-minus");
          jQuery(".acc-set > h4").removeClass("active");
          jQuery(this).addClass("active");
          jQuery(".content").slideUp(200);
          jQuery(this).siblings(".content").slideDown(200);
        }
    }); 
}

function returnSectionFormSubmit(){
    /*return page*/        
    jQuery("#free_returns").validate({
        rules: {
            contactperson: "required",
            email: "required",
            ordernumber: "required",
            itemqty: "required",
            reasonreturn: "required"        
        },
        messages: {
            contactperson: "This field is required",                   
            email: "This field is required",                   
            ordernumber: "This field is required",                   
            itemqty: "This field is required",                   
            reasonreturn: "This field is required"                   
            
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
          
            var $form = jQuery(form);            
            var serializedData = $form.serialize();                      
            jQuery.ajax({
               type: 'POST',
               url: ajaxurl,
               async: false,
               data: serializedData + "&action=submitformreturndata",
               dataType: "json",
               beforeSend: function() {
                   jQuery('.loader').addClass('show');   
                   jQuery("#myofs_return").css('background-color','black');
                   jQuery("#myofs_return").css('opacity','0.5');  
                   jQuery("#myofs_return").css(' z-index','999');
               },
               success: function (response) {
                   jQuery('.loader').removeClass('show');            
                   jQuery("#myofs_returndata").removeAttr('style');
                   jQuery(".loader").css('display','none');
                   //alert('success');
               },
               error: function (errorThrown) {}
           }); 

        }
    });
    /********RESET CLEAR FORM********/
    jQuery('#reset1').click(function(){
        jQuery('#free_returns')[0].reset();
    });
}

function sidebarCollapse(){
  
// dislay or hide the menu if the user resize the window
jQuery(window).resize(function() {
    var wi = jQuery(window).width();
    if (wi >= 641) {
        jQuery('#topsidebar-icon').css({'display':'none'});
        jQuery('#sidebar-collapse').css({'display':'block'});
        jQuery('ul.page-header-fixed').css({'display':'block'});
        jQuery('ul.page-header-fixed').removeClass('responsive_sidebar');        
    } else {     
        jQuery('#topsidebar-icon').css({'display':'block'});
        jQuery('#sidebar-collapse').css({'display':'none'});
        jQuery('ul.page-header-fixed').addClass('responsive_sidebar');
        jQuery('ul.page-header-fixed').css({'display':'none'});       
        
    }
});
if(window.matchMedia("(max-width: 767px)").matches){
    jQuery('#topsidebar-icon').css({'display':'block'});
    jQuery('#sidebar-collapse').css({'display':'none'});
    jQuery('ul.page-header-fixed').addClass('responsive_sidebar');
    jQuery('ul.page-header-fixed').css({'display':'none'});
} else{
    jQuery('#topsidebar-icon').css({'display':'none'});
    jQuery('#sidebar-collapse').css({'display':'block'});
    jQuery('ul.page-header-fixed').css({'display':'block'});
    jQuery('ul.page-header-fixed').removeClass('responsive_sidebar');
}
//desktop
jQuery("#sidebar-collapse").on("click", function() {
  if (jQuery('ul.page-sidebar-menu').hasClass('sidebar-collapse')) {
    jQuery('#myofs-sidebar').addClass('sidebar-menu-expand');
    jQuery('ul.page-sidebar-menu').removeClass('sidebar-collapse');
    jQuery('ul.page-sidebar-menu').addClass('sidebar-expand');
    jQuery(this).attr("aria-expanded","false");
  }else{
    jQuery('#myofs-sidebar').removeClass('sidebar-menu-expand');
    jQuery('ul.page-sidebar-menu').removeClass('sidebar-expand');
    jQuery('ul.page-sidebar-menu').addClass('sidebar-collapse');
    jQuery(this).attr("aria-expanded","true");
  }
});
/*responsive*/
jQuery('#topsidebar-icon').click(function(){
  
  if (jQuery('ul.responsive_sidebar').css('display') == 'none') {
      jQuery('ul.responsive_sidebar').css({'display':'block'});
      jQuery(this).addClass('open-sidebar');
      jQuery('.tab-content .wrap').addClass('responsive-sidebar-open');
  }else {
      jQuery('ul.responsive_sidebar').css({'display':'none'});
      jQuery(this).removeClass('open-sidebar');
      jQuery('.tab-content .wrap').removeClass('responsive-sidebar-open');
  }
});
  
}

  
 