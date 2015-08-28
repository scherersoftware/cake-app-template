App.Controllers.TeaserGroupsViewController = Frontend.AppController.extend({
    startup: function() {
        this.$('.sortable').sortable({
            update: function(event, ui) {
                var $teaser = $(ui.item);
                var position = $teaser.index();
                this.oneMoveTeaser($teaser.data('teaser-id'), position);
            }.bind(this)
        });
    },
    oneMoveTeaser: function(teaserId, newPosition, teaserGroupId) {
        var url = {
            plugin: 'admin',
            controller: 'Teasers',
            action: 'move',
            pass: [teaserId]
        };
        var data = {
            position: newPosition
        };
        App.Main.request(url, data, function(response) {
            this.refreshPage();
        }.bind(this));
    },
    refreshPage: function() {
        App.Main.UIBlocker.blockElement(this.$('.teaser_groups-view'));
        window.location.reload();
    }
});