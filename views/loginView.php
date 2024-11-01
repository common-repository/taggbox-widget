<?php $__taggbox__csrfToken = ___taggbox_generate_csrf_token();?><!-- Generate Csrf For Api Call -->
<div class="taggbox_content_wrapper___">
    <div class="taggbox_info_wrapper">
        <div class="taggbox_info_in___">
	    <?php _e('<div class="tg_login_head_001">Welcome to Tagbox Widget</div>', 'textdomain');?>
	    <?php _e('<div class="tg_login_des00">Embed in your WordPress site and Showcase the power of your hashtag. Build trust and engagement with your audience. Drive more social purchase and increase revenues too</div>', 'textdomain');?>
        </div>
    </div>
    <div class="taggbox-login-container">
        <div class="taggbox_custom-row">
            <div class="tb_form_area">
                <div class="taggbox__form__">
                    <div class="taggbox-logoLogin">
                        <a href="https://taggbox.com/widget/" target="_blank">
                            <img src="<?php echo esc_html(TAGGBOX_PLUGIN_URL) . '/assets/images/taggbox-widget.svg?var=1'?>" width="260" height="42" alt="Tagbox Widget">
                        </a>
                    </div>
                    <div class="taggbox-loginWithSocials">
                        <div class="taggbox-loginHead">
                            <div class="tgg_login_heading">Login to Tagbox</div>
                        </div>
                        <div class="taggbox-loginSocials">
                            <div class="tgg_sign_in__">Sign in with:</div>
                            <div class="taggbox-social-network taggbox-social-circle">
				<a href="<?php echo esc_html(TAGGBOX_PLUGIN_API_URL) . "api/google_login?wpredirecturl=" . esc_html(TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL) . "&csrf=" . esc_html($__taggbox__csrfToken);?>" class="icoGoogle" title="Google +">
				    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 256 262" preserveAspectRatio="xMidYMid"><path d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" fill="#4285F4"></path><path d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" fill="#34A853"></path><path d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" fill="#FBBC05"></path><path d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" fill="#EB4335"></path></svg>
				    <div>Google</div>
                                </a>
                                <a href="<?php echo esc_html(TAGGBOX_PLUGIN_API_URL) . "api/fb_login?wpredirecturl=" . esc_html(TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL) . "&csrf=" . esc_html($__taggbox__csrfToken);?>" class="icoFacebook" title="Facebook">
				    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="23" height="23" id="Capa_1" x="0px" y="0px" viewBox="0 0 167.657 167.657" style="enable-background:new 0 0 167.657 167.657;" xml:space="preserve"><path style="fill:#1777F2" d="M83.829,0.349C37.532,0.349,0,37.881,0,84.178c0,41.523,30.222,75.911,69.848,82.57v-65.081H49.626   v-23.42h20.222V60.978c0-20.037,12.238-30.956,30.115-30.956c8.562,0,15.92,0.638,18.056,0.919v20.944l-12.399,0.006   c-9.72,0-11.594,4.618-11.594,11.397v14.947h23.193l-3.025,23.42H94.026v65.653c41.476-5.048,73.631-40.312,73.631-83.154   C167.657,37.881,130.125,0.349,83.829,0.349z"></path></svg>
				    <div>Facebook</div>
                                </a>
                                <a href="<?php echo esc_html(TAGGBOX_PLUGIN_API_URL) . "api/linkedin_login?wpredirecturl=" . esc_html(TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL) . "&csrf=" . esc_html($__taggbox__csrfToken);?>" class="icoTwitter" title="Twitter">
				    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 167 167"><g id="Group_6571" data-name="Group 6571" transform="translate(8377 19537)"><rect id="Rectangle_2461" data-name="Rectangle 2461" width="167" height="167" transform="translate(-8377 -19537)" fill="none" opacity="0.707"></rect><g id="Group_6570" data-name="Group 6570" transform="translate(-8378.3 -19538.301)"><path id="Path_4793" data-name="Path 4793" d="M14.3,24.6H45.88v96.873H14.3V24.6Z" transform="translate(0 33.656)" fill="#127bb6"></path><path id="Path_4794" data-name="Path 4794" d="M97.759,25.8c-1.071-.665-5.634-1.126-7.766-1.2-18.35,0-29.873,13.229-33.713,18.35V24.6H24.7v96.873H55.853V68.982s23.9-33.287,33.713-8.962V121.9h31.58V56.18A31.156,31.156,0,0,0,97.759,25.8Z" transform="translate(33.982 33.656)" fill="#127bb6"></path><circle id="Ellipse_435" data-name="Ellipse 435" cx="15.363" cy="15.363" r="15.363" transform="translate(14.3 14.3)" fill="#127bb6"></circle></g></g></svg>
                                    <div>LinkedIn</div>
                                </a>
                            </div>
                            <div class="tgg_or_txt00"><div>or</div></div>
                        </div>
                    </div>
                    <div class="taggbox-account-widget">
                        <div class="tb_error_msg00"></div>
			<?php if (isset($_GET['error'])):?>
			    <?php if ($_GET['error'] == "social-login-error"):?>
				<div class="tb_alert__ tb_alert__danger"><div class="tb_alert__text">You don't have any account. please create account first.</div></div>
			    <?php elseif ($_GET['error'] == "s-w-r"):?>
				<div class="tb_alert__ tb_alert__danger"><div class="tb_alert__text">Something went wrong. Please try after sometime.</div></div>
			    <?php endif;?>
			<?php endif;?>
                        <form action="javascript:void(0)" id="formTaggboxLogin" class="taggbox-form-signin">
                            <div class="tb_form_group">
                                <label class="tb_form_label" for="email">Email<div>*</div></label>
                                <input type="email" name="email" id="email" class="tb_form_control" required autofocus />
                            </div>
                            <div class="tb_form_group">
                                <label class="tb_form_label" for="password">Password<div>*</div></label>
                                <input type="password" name="password" id="password" class="tb_form_control" required />
                            </div>
                            <div class="tb_form_group">
                                <button id="tb_submit_login_btn" class="tb_btn submit_btn" type="submit">Login</button>
                            </div>
                            <div class="tb_form_group">
                                <div class="tgg_signup_00">Don't have an account? <a class="btnSignUp" target="_blank" href="https://app.taggbox.com/widget/accounts/register">Sign Up</a></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tb_content_area taggbox_form_side____">
                <div class="taggbox__side_img" <?php echo 'style="background-image: url(' . esc_html(TAGGBOX_PLUGIN_URL) . '/assets/images/taggbox_wall_bg-min.png' . ')"'?>></div>
            </div>
        </div>
    </div>
</div>