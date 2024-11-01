/*--Start-- Refresh Widgets*/
jQuery(document).ready(function () {
    jQuery(document).on("click", "#taggboxRefresh", function () {
	var post_data = "action=data&__taggbox__api_call_security_nones=" + __taggbox__api_call_security_nones_object.__taggbox__api_call_security_nones + "&param=taggboxRefresh";
	return new Promise(function (resolve, reject) {
	    jQuery.ajax({
		url: taggboxAjaxurl.ajax_url,
		type: "POST",
		dataType: 'json',
		data: post_data,
		beforeSend: function () {
		    jQuery('#taggboxRefresh').addClass('tb_btn_icon_rotate tb_disabled00')
		    jQuery('html,body').css('cursor', 'wait');
		},
		complete: function () {
		    jQuery('#taggboxRefresh').removeClass('tb_btn_icon_rotate tb_disabled00')
		    jQuery('html,body').css('cursor', 'auto');
		},
	    }, ).done(function (response) {
		if (response.status === false) {
		    jQuery(".tb_error_msg00").empty();
		    jQuery(".tb_error_msg00").append('<div class="tb_alert__ tb_alert__danger"><div class="tb_alert__text">' + response.message + '</div></div>');
		} else if (response.status === true) {
		    location.reload(true);
		}
	    })
	})
    });
    /*--End-- Refresh Widgets*/
    /*--Start-- Login*/
    jQuery('#formTaggboxLogin').validate({
	submitHandler: function () {
	    var post_data = "action=data&__taggbox__api_call_security_nones=" + __taggbox__api_call_security_nones_object.__taggbox__api_call_security_nones + "&param=taggboxLogin&" + jQuery("#formTaggboxLogin").serialize();
	    return new Promise(function (resolve, reject) {
		jQuery.ajax({
		    url: taggboxAjaxurl.ajax_url, // Url to which the request is send
		    type: "POST", // Type of request to be send, called as method
		    dataType: 'json',
		    data: post_data,
		    beforeSend: function () {
			jQuery('html,body').css('cursor', 'wait');
			jQuery('#tb_submit_login_btn').addClass('tb_spinner__00');
		    },
		}, ).done(function (response) {
		    if (response.status === false) {
			jQuery('#tb_submit_login_btn').removeClass('tb_spinner__00');
			jQuery('html,body').css('cursor', 'auto');
			jQuery(".tb_error_msg00").empty();
			jQuery(".tb_error_msg00").append('<div class="tb_alert__ tb_alert__danger"><div class="tb_alert__text">' + response.message + '</div></div>');
		    } else if (response.status === true) {
			window.location.replace(response.data.redirectUrl);
		    }
		})
	    })
	}
    });
    /*--End-- Login*/
    /*--Start-- Logout*/
    jQuery(document).on("click", "#taggboxLogout", function () {
	var post_data = "action=data&__taggbox__api_call_security_nones=" + __taggbox__api_call_security_nones_object.__taggbox__api_call_security_nones + "&param=taggboxLogout";
	jQuery.ajax({
	    url: taggboxAjaxurl.ajax_url,
	    type: "POST",
	    dataType: 'json',
	    data: post_data,
	}).done(function (response) {
	    if (response.status === false) {
		reject('Oops! Something went wrong.');
		jQuery(".tb_error_msg00").empty();
		jQuery(".tb_error_msg00").append('<div class="tb_alert__ tb_alert__danger"><div class="tb_alert__text">Oops! Something went wrong.</div></div>');
	    } else if (response.status === true) {
		window.location.replace(response.data.redirectUrl);
	    }
	}).error(function () {
	    jQuery(".tb_error_msg00").empty();
	    jQuery(".tb_error_msg00").append("<div class='tb_alert__ tb_alert__danger'><div class='tb_alert__text'>We couldn't connect to the server!</div></div>");
	});

    });
    /*--End-- Logout */
    /*--Start-- Manage Widgets According Collaborator*/
    jQuery("#collaborator").change(function () {
	var post_data = "action=data&__taggbox__api_call_security_nones=" + __taggbox__api_call_security_nones_object.__taggbox__api_call_security_nones + "&param=updateWidgetAccordingUser&userid=" + jQuery(this).val();
	return new Promise(function (resolve, reject) {
	    jQuery.ajax({
		url: taggboxAjaxurl.ajax_url,
		type: "POST",
		dataType: 'json',
		data: post_data,
		beforeSend: function () {
		    jQuery('html,body').css('cursor', 'wait');
		},
		complete: function () {
		    jQuery('html,body').css('cursor', 'auto');
		},
	    }, ).done(function (response) {
		if (response.status === false) {
		    reject('Oops! Something went wrong.');
		} else if (response.status === true) {
		    location.reload(true);
		}
	    }).error(function () {
		jQuery(".tb_error_msg00").empty();
		jQuery(".tb_error_msg00").append("<div class='tb_alert__ tb_alert__danger'><div class='tb_alert__text'>We couldn't connect to the server!</div></div>");
	    });
	})
    });
    /*--End-- Manage Widgets According Collaborator*/
    /*--Start-- Append Embed Js Dynamically*/
    if (jQuery('.taggbox-container > .taggbox-socialwall').length > 0) {
	jQuery.getScript('https://widget.taggbox.com/embed.min.js').done(function (script, textStatus) {
	});
    }
    /*--End-- Append Embed Js Dynamically*/
});
/*--Start-- Manage Copy Short Code*/
function copyTbWidgetToClipboard(element) {
    jQuery('<div class="tb-copy-success-alert">Copied!</div>').insertAfter(jQuery('#input_' + element));
    jQuery('.tb-copy-success-alert').fadeIn(300);
    jQuery('.tb-copy-success-alert').delay(1500).fadeOut(300, function () {
	jQuery('.tb-copy-success-alert').remove();
    });
    var copyText = document.getElementById("input_" + element);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    setTimeout(function () {
	document.getSelection().removeAllRanges();
    }, 1500);
}
/*--End-- Manage Copy Short Code*/

