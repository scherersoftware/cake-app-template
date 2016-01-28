Frontend.AppController = Frontend.Controller.extend({
    baseComponents: ['Attachments', 'ModelHistory', 'DatePicker', 'TinyMce', 'MoxmanPicker'],
    _initialize: function() {
        this.initGlobalFunctionality();
        if (this.isAdminArea()) {
            this.initGlobalFunctionalityForAdminArea();
        }
        this.startup();
    },
    initGlobalFunctionality: function() {
        $('input.autofocus').focus();

        this.DatePicker.setup(this.$('.form-group.dateTime, .form-group.date'));

        this.TinyMce.initEditors(this._dom);

        // Place functionality which should _not_ run again when executing a jsonAction request below this
        if (this.getVar('isAjax')) {
            return;
        }

        if (!this.getVar('isMobile')) {
            //$('.selectize').selectize();
        }

        $('form.blockui-on-submit').submit(function(e) {
            App.Main.UIBlocker.blockElement($(e.currentTarget));
        });

        // Bootstrap Tabs Toggling via URL hash.
        if (location.hash !== '') {
            $('a[href="' + location.hash + '"]').tab('show');
        } else {
            $('ul.nav-tabs > li:first > a[data-toggle="tab"]').tab('show');
        }
        $('a[data-toggle="tab"]').on('click', function(e) {
            return location.hash = $(e.target).attr('href').substr(1);
        });
    },
    initGlobalFunctionalityForAdminArea: function() {
        // Place functionality which should _not_ run again when executing a jsonAction request below this
        if (this.getVar('isAjax')) {
            return;
        }
        $('#side-menu').metisMenu();
        $(window).bind("load resize", function() {
            topOffset = 50;
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 768) {
                $('div.navbar-collapse').addClass('collapse');
                topOffset = 100; // 2-row-menu
            } else {
                $('div.navbar-collapse').removeClass('collapse');
            }
            height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            if (height < 1) height = 1;
            if (height > topOffset) {
                $("#page-wrapper").css("min-height", (height) + "px");
            }
        });
    },
    isAdminArea: function() {
        return (this._frontendData.request.plugin == 'Admin' || this._frontendData.request.plugin == 'Cms' || this._frontendData.request.plugin == 'Notifications');
    }
});
