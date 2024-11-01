jQuery(document).ready(function () {
    /* BEGIN  REFRESH ALL DATA FOR TAGGBOX PLUGIN*/
    jQuery(document).on("click", "#taggboxRefresh", function () {
           // var post_data = "action=data&param=taggboxRefresh&" + jQuery("#formTaggboxLogin").serialize();
            var post_data = "action=data&param=taggboxRefresh";
            return new Promise(function (resolve, reject) {
                jQuery.ajax({
                    url: taggboxAjaxurl, // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    dataType: 'json',
                    data: post_data,
                    beforeSend: function () {
                        jQuery('#ajaxLoading').show();
                        jQuery('html,body').css('cursor', 'wait');
                    },
                    complete: function () {
                        jQuery('#ajaxLoading').hide();
                        jQuery('html,body').css('cursor', 'auto');
                    },
                },).done(function (response) {
                    if (response.status === false) {
                        swal("Oops", response.message, "error");
                    } else if (response.status === true) {
                        location.reload(true);
                    }
                })
            })

    });
    /* END  REFRESH ALL DATA  FOR TAGGBOX PLUGIN*/

    /* BEGIN  LOGIN FOR TAGGBOX PLUGIN*/
    jQuery('#formTaggboxLogin').validate({
        submitHandler: function () {
            var post_data = "action=data&param=taggboxLogin&" + jQuery("#formTaggboxLogin").serialize();
            return new Promise(function (resolve, reject) {
                jQuery.ajax({
                    url: taggboxAjaxurl, // Url to which the request is send
                    type: "POST", // Type of request to be send, called as method
                    dataType: 'json',
                    data: post_data,
                    beforeSend: function () {
                        jQuery('#ajaxLoading').show();
                        jQuery('html,body').css('cursor', 'wait');
                    },
                    /* complete: function () {
                        jQuery('#ajaxLoading').hide();
                        jQuery('html,body').css('cursor', 'auto');
                    }, */
                },).done(function (response) {
                    if (response.status === false) {

                        jQuery('#ajaxLoading').hide();
                        jQuery('html,body').css('cursor', 'auto');

                        //swal("Oops test", response.message, "error");
                        swal({
                            title: "Oops",
                            text: response.message,
                            type: 'error',
                            confirmButtonColor: '#c20e5e',
                        });
                    } else if (response.status === true) {
                        window.location.replace(response.data.redirectUrl);
                    }
                })
            })
        }
    });
    /* END  LOGIN FOR TAGGBOX PLUGIN*/

    /* BEGIN  LOGOUT FOR TAGGBOX PLUGIN*/
    jQuery(document).on("click", "#taggboxLogout", function () {
        var post_data = "action=data&param=taggboxLogout";
        swal({
            title: 'Are you sure?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c20e5e',
            cancelButtonColor: 'transparent',
            confirmButtonText: 'Yes, sign out',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve, reject) {
                    jQuery.ajax({
                        url: taggboxAjaxurl, // Url to which the request is send
                        type: "POST", // Type of request to be send, called as method
                        dataType: 'json',
                        data: post_data,
                    }).done(function (response) {
                        if (response.status === false) {
                            reject('Oops! Something went wrong.');
                        } else if (response.status === true) {
                            window.location.replace(response.data.redirectUrl);
                        }
                    }).error(function () {
                        swal("Oops", "We couldn't connect to the server!", "error");
                    });
                })
            },
            allowOutsideClick: false
        }).catch(swal.noop);
    });
    /* END  LOGOUT FOR TAGGBOX PLUGIN*/

    /* BEGIN  MANAGE WIDGET ACCORDING COLLABORATOR FOR TAGGBOX PLUGIN*/
    jQuery("#collaborator").change(function () {
        // console.log("chnage");
        var post_data = "action=data&param=updateWidgetAccordingUser&userid=" + jQuery(this).val();
        return new Promise(function (resolve, reject) {
            jQuery.ajax({
                url: taggboxAjaxurl, // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                dataType: 'json',
                data: post_data,
                beforeSend: function () {
                    jQuery('#ajaxLoading').show();
                    jQuery('html,body').css('cursor', 'wait');
                },
                complete: function () {
                    jQuery('#ajaxLoading').hide();
                    jQuery('html,body').css('cursor', 'auto');
                },
            },).done(function (response) {
                if (response.status === false) {
                    reject('Oops! Something went wrong.');
                } else if (response.status === true) {
                    location.reload(true);
                }
            }).error(function () {
                swal("Oops", "We couldn't connect to the server!", "error");
            });
        })
    });
    /* END  MANAGE WIDGET ACCORDING COLLABORATOR FOR TAGGBOX PLUGIN*/

});

/*
* * BEGIN MANAGE SHORT CODE
*/
/*BEGIN COPY*/
function copyToClipboard(element) {
    var $temp = jQuery("<input>");
    jQuery("body").append($temp);
    //$temp.val(jQuery(element).text()).select();
    $temp.val(element).select();
    document.execCommand("copy");
    $temp.remove();
    swal({
        icon: 'info',
        type: 'success',
        customClass:'copyToClipboard',
        title: "Shortcode Copied!",
        // text: "Copied!",
        timer: 1000,
        showCancelButton: false, 
        showConfirmButton: false,
        animation : true
    });
}
/*END COPY*/
/*
* * END MANAGE SHORT CODE
*/