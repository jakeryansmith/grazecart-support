(function($)
{
    // Add Image Button
    // $.Redactor.prototype.imagePlus = function()
    // {
    //     return {
    //         init: function ()
    //         {
    //             var button = this.button.add('imagePlus', 'Image');
    //             this.button.addCallback(button, this.imagePlus.toggleMediaBrowser);
    //         },
    //         toggleMediaBrowser: function()
    //         {
    //             window.vue.$broadcast('mediaBrowser:toggle', {mode: 'redactor', redactor: this});
    //         }
    //     };
    // };

    // Add Divider Button
    $.Redactor.prototype.divider = function()
    {
        return {
            init: function ()
            {
                var button = this.button.add('divider', 'Divider');
                this.button.addCallback(button, this.divider.addDivider);
            },
            addDivider: function()
            {
                this.line.insert();
            }
        };
    };

    // Add History Buttons
    $.Redactor.prototype.historybuttons = function()
    {
        return {
            init: function()
            {
                var undo = this.button.add('undo', 'Undo');
                var redo = this.button.add('redo', 'Redo');
                
                this.button.setIcon(undo, '<i class="fa fa-undo"></i>');
                this.button.setIcon(redo, '<i class="fa fa-repeat"></i>');

                this.button.addCallback(undo, this.buffer.undo);
                this.button.addCallback(redo, this.buffer.redo);
            }
        };
    };
})(jQuery);

var redactorSettings = {
    buttons: ['format', 'bold', 'italic', 'link', 'lists'],
    plugins: ['alignment','imagePlus','divider','table','historybuttons','source','fullscreen'],
    formatting: ['p', 'h1', 'h2', 'h3'],
    pastePlainText: true,
    imageResizable: true,
    script: false,
    structure: true,
    toolbarFixed: true,
    toolbarFixedTopOffset: 63, // pixels
}

// var redactor = $('.redactor').redactor(redactorSettings);