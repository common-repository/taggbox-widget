jQuery(function (blocks, element, editor, components, i18n, data, compose) {

    var El = element.createElement;
    var TBVars = {};
    const {registerBlockType} = blocks;
    const {RichText, InspectorControls} = editor;
    const {Fragment} = element;
    const {IconButton, TextControl, ToggleControl, Panel, PanelBody, PanelRow} = components;
    const {select, withSelect, withDispatch} = data;
    const {compos} = compose;
    const iconEl = El("svg", {
        xmlns: "http://www.w3.org/2000/svg",
        width: "36.84",
        height: "36.84",
        viewBox: "0 0 36.84 36.84"
    }, El("g", {
        id: "Layer_2",
        "data-name": "Layer 2"
    }, El("g", {
        id: "Layer_1-2",
        "data-name": "Layer 1"
    }, El("g", {
        id: "Layer_2-2",
        "data-name": "Layer 2-2"
    }, El("path", {
        className: "taggbox-icon",
        d: "M18.42,36.84A18.42,18.42,0,1,1,36.84,18.42h0A18.45,18.45,0,0,1,18.42,36.84Zm0-35.35A16.93,16.93,0,1,0,35.35,18.42,16.93,16.93,0,0,0,18.42,1.49Z"
    })), El("path", {
        className: "taggbox-icon",
        d: "M18.39,2.16A16.26,16.26,0,1,0,34.65,18.42,16.26,16.26,0,0,0,18.39,2.16Zm5.19,16.91L13.52,27.93V19.07H6.77V11.8h23.3v7.27Z"
    }))));

    /* REGISTER BLOCK*/
    registerBlockType('taggbox-block/taggbox', {
        title: 'Taggbox Widget',
        description: 'Display your social media content with the Taggbox Wordpress plugin - including hashtags and user content - in a beautiful and richly interactive view.',
        category: 'widgets',
        icon: iconEl,
        keywords: ['taggbox widget'],
        supports: {align: true},
        attributes: {
            shortCode: {default: null},
            widgetId: {default: null},
            height: {default: '500px'},
            width: {default: '100%'},
            url: {default: 'https://app.taggbox.com/widget/e/'},
            preview: {default: 'hide'}
        },
        edit:
            function (props) {
                // function updateShortCode(event) {
                //     props.setAttributes({shortCode: event.target.value});
                //     var widgetId = event.target.value.slice(19, -1);
                //     props.setAttributes({widgetId: widgetId});
                // }

                function getWidgetId(event) {
                    var widgetId = event.target.value.slice(19, -1);
                    TBVars.widgetId = widgetId;
                }

                function hidePreview() {
                    var parent = jQuery(event.target).closest(".is-selected");
                    parent.children(".taggbox-preview").hide();
                    parent.children(".taggbox-editor-main-div").show();
                    props.setAttributes({preview: "hide"});
                }

                function showPreview(event) {
                    // if (props.attributes.widgetId !== '' && props.attributes.widgetId !== null) {
                    //     var parent = jQuery(event.target).closest(".is-selected");
                    //     parent.children(".taggbox-preview").show();
                    //     parent.children(".taggbox-editor-main-div").hide();
                    //     props.setAttributes({preview: "show"});
                    // }
                    if (TBVars.widgetId !== '' && TBVars.widgetId !== null && TBVars.widgetId !== undefined) {
                        var parent = jQuery(event.target).closest(".is-selected");
                        parent.children(".taggbox-preview").show();
                        parent.children(".taggbox-editor-main-div").hide();
                        props.setAttributes({preview: "show"});
                    } else {
                        if(jQuery('#tb_flash_msg').length < 1){
                            errMgs = '<div class="alert alert-danger" id="tb_flash_msg" style="font-size: larger;"><button type="button" class="close" data-dismiss="alert">&times;</button>'+
                            'Enter a valid shortCode <i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" title="Sample shortcode:<br>[taggbox widgetid = 30000]"></i></div>';
                            jQuery('.taggbox-editor-singup-msg-div').prepend(errMgs);
                            jQuery('[data-toggle="tooltip"]').tooltip();
                            jQuery('.fa').css('cursor', 'pointer');
                            setTimeout(function() {
                                if (!jQuery('#tb_flash_msg').is(':hover')) {
                                    jQuery('#tb_flash_msg').remove();
                                } else {
                                    jQuery('#tb_flash_msg').on('mouseleave', function(){
                                        setTimeout(function(){
                                            jQuery('#tb_flash_msg').remove();
                                        }, 500);
                                    });
                                }
                            }, 1000);
                        }
                    }
                }

                return [
                    El(Fragment, {},
                        El(
                            InspectorControls, {},
                            El(PanelBody, {title: 'Widget Settings', initialOpen: true},
                                /* Height Field */
                                El(PanelRow, {},
                                    El(TextControl,
                                        {
                                            label: 'Height',
                                            type: 'text',
                                            onChange: (value) => {
                                                props.setAttributes({height: value});
                                            },
                                            value: props.attributes.height
                                        }
                                    )
                                ),
                                /* Width Field */
                                El(PanelRow, {},
                                    El(TextControl,
                                        {
                                            label: 'Width',
                                            type: 'text',
                                            onChange: (value) => {
                                                props.setAttributes({width: value});
                                            },
                                            value: props.attributes.width
                                        }
                                    )
                                ),
                            ),
                        ),
                    ),
                    El(
                        "div", {
                        className: ((props.attributes.preview == "hide") ? "taggbox-preview-show" : "taggbox-preview-hide") + " container-fluid taggbox-editor-main-div"
                    }, El("div", {
                        className: "row taggbox-editor-widget-main-div"
                    }, El("div", {
                        className: "col-md-12"
                    }, El("div", {
                            className: "row form-group"
                        }, El("div", {
                            className: "col-md-12 taggbox-editor-heading"
                        }, El("strong", null, "Taggbox Widget")), El("div", {
                            className: "col-md-6 col-sm-6 col-xs-6"
                        }, El("input", {
                            type: "text",
                            className: "form-control b-0 z-index10",
                            placeholder: "Enter Widget Shortcode",
                            value: props.attributes.shortCode,
                            // onChange: updateShortCode
                            onChange: getWidgetId
                        })), El("div", {
                            className: "col-md-6 col-sm-6 col-xs-6"
                        },
                        El("button", {
                            className: "btn btn-primary b-0 taggbox-preview-btn",
                            onClick: showPreview,
                            // onClick: updateShortCode
                        }, "Preview")),
                        El("div", {
                                className: "col-md-12 clear-both"
                            }, El("div", {
                                className: "taggbox-editor-singup-msg-div"
                            }, " If you don't have a widget yet, create one at taggbox : "),
                            El("a", {
                                className: "taggbox-editor-singup-link",
                                href: "https://app.taggbox.com/widget/accounts/register",
                                target: "_blank"
                            }, " Sign Up ")))))),
                    El("button", {
                        className: ((props.attributes.preview == "show") ? "taggbox-preview-show" : "taggbox-preview-hide") + " taggbox-close-preview-btn taggbox-preview",
                        onClick: hidePreview
                    }, El("i", {
                        class: "fa fa-close"
                    })),
                    El("div", {
                        className: ((props.attributes.preview == "show") ? "taggbox-preview-show" : "taggbox-preview-hide") + " row taggbox-preview",
                    }, El("div", {
                        className: "col-md-12"
                    }, El("iframe", {
                        className: "taggbox-editor-iframe",
                        // src: props.attributes.url + props.attributes.widgetId,
                        src: props.attributes.url + TBVars.widgetId,
                        allowfullscreen: "allowfullscreen",
                        frameborder: "0",
                        title: "Taggbox-widget",
                        border: "0",
                    }))),
                ]
            },
        save: function (props) {
            return El("div", {
                    className: "taggbox-container",
                    style: "width:" + props.attributes.width + ";height:" + props.attributes.height + ";overflow: auto;",
                },
                El("div", {
                    className: "taggbox-socialwall taggbox-analystic",
                    style: "width:100%;height:100%;",
                    // "data-wall-id": props.attributes.widgetId,
                    "data-wall-id": TBVars.widgetId,
                    // "view-url": props.attributes.url + props.attributes.widgetId
                    "view-url": props.attributes.url + TBVars.widgetId
                }));
        },
    });
}(
    wp.blocks,
    wp.element,
    wp.editor,
    wp.components,
    wp.i18n,
    wp.data,
    wp.compose,
));
