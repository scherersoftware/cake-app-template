App.Controllers.DemoListUsersController = Frontend.AppController.extend({
    startup: function() {
        var usersList = this.getVar('users');
        for (var id in usersList) {
            this.$('ul.users').append($('<li/>').text(usersList[id]));
        }
    }
});
