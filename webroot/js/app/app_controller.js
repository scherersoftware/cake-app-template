Frontend.AppController = Frontend.Controller.extend({
    baseComponents: ['Attachments', 'DatePicker'],
    _initialize: function() {
        this.initGlobalFunctionality();
        this.startup();
    },
    initGlobalFunctionality: function() {
        $('input.autofocus').focus();

        this.DatePicker.setup(this.$('.form-group.dateTime, .form-group.date'));

        // Place functionality which should _not_ run again when executing a jsonAction request below this
        if (this.getVar('isAjax')) {
            return;
        }

        if (!this.getVar('isMobile')) {
            $('.selectize').selectize();
        }

        $('form.blockui-on-submit').submit(function(e) {
            App.Main.UIBlocker.blockElement($(e.currentTarget));
        });

        // Bootstrap Tabs Toggling via URL hash.
        if (location.hash === '') {
            $('ul.nav-tabs > li:first > a[data-toggle="tab"]').tab('show');
        } else {
            $('a[href="' + location.hash + '"]').tab('show');
        }
        $('a[data-toggle="tab"]').on('click', function(e) {
            location.hash = $(e.target).attr('href').substr(1);
            return location.hash;
        });
    }
});
