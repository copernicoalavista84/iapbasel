(function () {
    tinymce.create("tinymce.plugins.SpyroPressShortcodes", {
        init: function (d, e) {
            d.addCommand("spyropressOpenDialog", function (a, c) {
                spyropressSelectedShortcodeType = c.identifier;
                jQuery.get(spyropress_admin_settings['dialog_url']+'?code='+c.identifier+'&title='+c.title, function (b) {
                    jQuery("#spyropress-dialog").remove();
                    jQuery("body").append(b);
                    jQuery("#spyropress-dialog").hide();
                    var f = jQuery(window).width(),
                        b = jQuery(window).height();
                    f = 720 < f ? 720 : f;
                    f -= 80;
                    b -= 115;
                    tb_show("Insert SpyroPress Shortcode", "#TB_inline?width=" + f + "&height=" + b + "&inlineId=spyropress-dialog");
                    jQuery("#spyropress-options h3:first").text("Customize the " + c.title + " Shortcode");
                });
            });
            d.onNodeChange.add(function (a, c) {
                c.setDisabled("spyropress_shortcodes_button", a.selection.getContent().length > 0)
            })
        },
        createControl: function (d, e) {
            if (d == "spyropress_shortcodes_button") {
                d = e.createMenuButton("spyropress_shortcodes_button", {
                    title: "Insert Shortcode",
                    image: spyropress_admin_settings['favicon_url'],
                    icons: false
                });
                var a = this;
                d.onRenderMenu.add(function (c, b) {
                    c = b.addMenu({
                        title: "Buttons"
                    });
                        a.addWithDialog(c, "Button", "button");
                        a.addImmediate(c, "Button Groups", "[btn_group] buttons goes here [/btn_group]");
                        a.addImmediate(c, "Multiple Button Groups", "[btn_toolbar][btn_group] buttons goes here [/btn_group][btn_group] buttons goes here [/btn_group][/btn_toolbar]");
                        a.addImmediate(c, "Vertical Button Groups", "[btn_group_vertical] buttons goes here [/btn_group_vertical]");
                    c = b.addMenu({
                        title: "Boxes"
                    });
                        a.addWithDialog(c,"Box","box" );
                        a.addWithDialog(c,"Colored Box","box_colored" );
                        a.addWithDialog(c,"Ribbon Box","box_ribbon" );
                        //a.addWithDialog(c,"Icon Box","icon_box" );
                    b.addSeparator();
                    c = b.addMenu({
                        title: "Typography"
                    });                        
                        a.addWithDialog(c, "Abbreviation","typo_abbr" );
                        a.addWithDialog(c, "Badges","typo_badges" );
                        a.addWithDialog(c, "Dropcap", "typo_dropcap");
                        a.addWithDialog(c, "Emphasis Text","typo_empasis" );
                        a.addWithDialog(c, "Highlight","typo_labels" );
                        a.addWithDialog(c, "Icon Text","typo_icon_text" );
                        a.addWithDialog(c, "Icon Link","typo_icon_link" );
                        c.addSeparator();
                        a.addWithDialog(c, "Blockquote", "typo_blockquote");
                        //a.addWithDialog(c, "Custom Typography", "typo_custom");
                        a.addWithDialog(c, "Hero Unit","typo_herounit" );
                    c = b.addMenu({
                        title: "Dividers"
                    });
                        a.addImmediate(c, "Divider", "[divider] ");
                        a.addImmediate(c, "Flat Divider", "[divider_flat] ");
                        a.addWithDialog(c, "Fancy Divider", "divider_hr");
                    c = b.addMenu({
                        title: "Lists"
                    });
                        a.addWithDialog(c, "Fancy Lists", "lists_fancy");
                        a.addWithDialog(c, "Fancy Numbers", "lists_fancy_numbers");
                        a.addWithDialog(c, "Ordered List", "lists_ordered");
                        c.addSeparator();
                        //a.addImmediate(c, "Vertical Description", "<dl><dt>Description lists</dt><dd>A description list is perfect for defining terms.</dd><dt>Euismod</dt><dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd><dd>Donec id elit non mi porta gravida at eget metus.</dd><dt>Malesuada porta</dt><dd>Etiam porta sem malesuada magna mollis euismod.</dd></dl>");
                        //a.addImmediate(c, "Horizontal Description", "<dl class=\"dl-horizontal\"><dt>Description lists</dt><dd>A description list is perfect for defining terms.</dd><dt>Euismod</dt><dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd><dd>Donec id elit non mi porta gravida at eget metus.</dd><dt>Malesuada porta</dt><dd>Etiam porta sem malesuada magna mollis euismod.</dd></dl>");
                    b.addSeparator();
                    c = b.addMenu({
                        title: "UI Elements"
                    });
                        a.addWithDialog(c, "Column Layout", "ui_columns");
                        a.addWithDialog(c, "Tab Layout", "ui_tabs");
                        c.addSeparator();
                        //a.addWithDialog(c, "Call to Action", "ui_action");
                        //a.addWithDialog(c, "Slider", "ui_slider");
                        //c.addSeparator();
                        a.addWithDialog(c, "Accordion", "ui_accordion");
                        a.addWithDialog(c, "Alerts", "ui_alerts");
                        a.addWithDialog(c, "Content Toggles", "ui_toggle");
                        //a.addWithDialog(c, "Popover", "a");
                        //a.addWithDialog(c, "Pricing Table", "a");
                        a.addWithDialog(c, "Progress Bar", "ui_progress_bar");
                        //a.addWithDialog(c, "Slider", "a");
                        a.addWithDialog(c, "Tables", "ui_tables");
                        a.addWithDialog(c, "Tooltip", "ui_tooltip");
                    c = b.addMenu({
                        title: "UI Advance"
                    });
                        a.addWithDialog(c, "Google Maps", "uia_googlemap");
                        a.addWithDialog(c, "Google Charts", "uia_gcharts");
                        a.addWithDialog(c, "Google Viewer", "uia_gviewer");
                        a.addWithDialog(c, "iFrame", "uia_iframe");
                        a.addWithDialog(c, "URL Screenshot", "uia_screenshot");
                        a.addWithDialog(c, "QR Generator", "uia_qrcode");
                    b.addSeparator();
                    c = b.addMenu({
                        title: "Media"
                    });
                        ci = c.addMenu({
                            title: "Image" 
                        }); 
                            a.addWithDialog(ci, "Image Effects", "img_effects");
                            a.addWithDialog(ci, "Image Frames", "img_frames");
                            a.addWithDialog(ci, "Gallery", "img_gallery");
                            a.addWithDialog(ci, "Flickr", "img_flickr");
                        ci = c.addMenu({
                            title: "Video" 
                        }); 
                            a.addWithDialog(ci, "Blip.tv", "video_blip");
                            a.addWithDialog(ci, "Youtube", "video_youtube");
                            a.addWithDialog(ci, "Vimeo", "video_vimeo");
                            a.addWithDialog(ci, "Dailymotion", "video_dailymotion");
                            //a.addWithDialog(ci, "HTML5 Player", "video_player");
                        ci = c.addMenu({
                            title: "Audio" 
                        }); 
                            a.addWithDialog(ci, "SoundCloud", "audio_soundcloud");
                            //a.addWithDialog(ci, "HTML5 Player", "audio_player");
                    c = b.addMenu({
                        title: "Widgets"
                    });
                        a.addWithDialog(c, "Latest Tweets", "a");
                        a.addWithDialog(c, "Latest Posts", "a");
                        a.addWithDialog(c, "Latest Portfolio", "a");
                        a.addWithDialog(c, "Related Posts","related" );
                    c = b.addMenu({
                        title: "Social Buttons"
                    });
                        a.addWithDialog(c,"Twitter","social_twitter" );
                        a.addWithDialog(c,"Twitter Follow Button","social_twitter_follow" );
                        a.addWithDialog(c,"Twitter Embeds","social_twitter_embeds" );
                        c.addSeparator();
                        a.addWithDialog(c,"Like on Facebook","social_fblike" );
                        a.addWithDialog(c,"Share on Facebook","social_fbshare" );
                        c.addSeparator();
                        a.addWithDialog(c,"Digg","social_digg" );
                        a.addWithDialog(c,"Google +1 Button","social_google_plusone" );
                        a.addWithDialog(c,"Share on LinkedIn","social_linkedin" );
                        a.addWithDialog(c,"StumbleUpon Badge","social_stumbleupon" );
                        a.addWithDialog(c,"Pinterest Button","social_pinterest" );											
                });
                return d
            }
            return null
        },
        addImmediate: function (d, e, a) {
            d.add({
                title: e,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("mceInsertContent", false, a)
                }
            })
        },
        addWithDialog: function (d, e, a) {
            d.add({
                title: e,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("spyropressOpenDialog", false, {
                        title: e,
                        identifier: a
                    })
                }
            })
        },
        getInfo: function () {
        }
    });
    
    tinymce.PluginManager.add("SpyroPressShortcodes", tinymce.plugins.SpyroPressShortcodes);
})();