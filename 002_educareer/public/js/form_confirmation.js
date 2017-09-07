(function() {

    var form_confirm = {
        initialize: function() {
            this.registerEvents();
        },

        registerEvents: function() {
            $('body').on('click', 'input[data-confirm]', this.handleMethod);
        },

        handleMethod: function(e) {
            var link = $(this);
            var form = $('form');
            var ret = confirm(link.data('confirm'));

            if (!ret) {
                e.preventDefault();
                return;
            }

            form.submit();
        },

    };

    form_confirm.initialize();

})();