(function($R)
{
    $R.add('plugin', 'photo_manager', {

        init: function(app)
        {
            this.app = app;

            // define toolbar service
            this.toolbar = app.toolbar;
        },
        start: function()
        {
            // set up the button
            var buttonData = {
                title: 'Image',
                api: 'plugin.photo_manager.toggle'
            };

            // add the button to the toolbar
            var $button = this.toolbar.addButton('image-button', buttonData);
        },
        toggle: function()
        {
            window.eventHub.$emit('toggleMediaBrowser');
        }
    });
})(Redactor);