(function() {

    tinymce.create('tinymce.plugins.spyroimage', {

        init : function(ed, url){
            ed.addButton('spyroimage', {
                title : 'Insert TinyPlugin',
                onclick : function() {
                    if( typeof wp !== "undefined" && wp.media &&wp.media.editor){
                        wp.media.editor.open(ed.editorId)
                    }
                },
                image: spyropress_admin_settings['media_url']
            });
        }
    });

    tinymce.PluginManager.add('spyroimage', tinymce.plugins.spyroimage);
    
})();