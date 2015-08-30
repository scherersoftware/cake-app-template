App.Controllers.HomeIndexController = Frontend.AppController.extend({
    startup: function() {
        console.log('Hello from HomeIndexController');

        // with this.getVar() you can access view variables which have been set via
        // FrontendBridgeHelper::setJson() in the CakePHP controller
        var demoText = this.getVar('demoText');

        // this.$ refers to the current controller action div jQuery object
        this.$('.set-json-demo').text(demoText);

        // With the Router you can construct URL objects and convert them to strings
        // There is no routing configuration support.
        var stringUrl = App.Main.Router.url({
            plugin: 'Admin',
            controller: 'Dashboard',
            action: 'index',
            pass: ['arg1', 'arg2'],
            query: {
                key1: 'val1',
                key2: 'val2'
            }
        });
        console.log('Stringified URL: ' + stringUrl);

        // AJAX JSON Requests
        this.$('.ajax-json-demo').click(function() {
            var url = {
                controller: 'Home',
                action: 'getJsonData'
            };
            // if postData is null, a GET request will be made
            var postData = null;
            App.Main.request(url, postData, function (response) {
                alert('Response Code ' + response.code + ' - see console for details');
                console.log(response);
            });
        }.bind(this));
        
        // AJAX JSON Requests
        this.$('.json-action-demo').click(function() {
            var $renderTarget = this.$('.render-target');
            App.Main.UIBlocker.blockElement($renderTarget);
            var url = {
                controller: 'Home',
                action: 'listUsers'
            };
            App.Main.loadJsonAction(url, {
                data: null, // Optional POST data,
                target: $renderTarget, // render the HTML into this selector
                onComplete: function() {
                    App.Main.UIBlocker.unblockElement($renderTarget);
                }
            });
        }.bind(this));
    }
});