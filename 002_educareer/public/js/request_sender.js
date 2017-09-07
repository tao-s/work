(function() {

    var laravel = {
        initialize: function() {
            this.registerEvents();
        },

        registerEvents: function() {
            $('body').on('click', 'a[data-method]', this.handleMethod);
        },

        handleMethod: function(e) {
            var link = $(this);
            var httpMethod = link.data('method').toUpperCase();
            var form;

            // If the data-method attribute is not PATCH, PUT or DELETE,
            // then we don't know what to do. Just ignore.
            var is_post = false;
            if ( $.inArray(httpMethod, ['PUT', 'DELETE']) === -1 ) {
                var is_post = true;
            }

            // Allow user to optionally provide data-confirm="Are you sure?"
            if ( link.data('confirm') ) {
                if (!laravel.verifyConfirm(link) ) {
                    return false;
                }
            }

            form = laravel.createForm(link, is_post);
            form.submit();

            e.preventDefault();
        },

        verifyConfirm: function(link) {
            return confirm(link.data('confirm'));
        },

        createForm: function(link, is_post) {
            var token_value = $('input[name=_token]').val();
            var form = $('<form>', {'method': 'POST', 'action': link.attr('href')});
            var token = $('<input>', {'name': '_token', 'type': 'hidden', 'value': token_value});
            var inputs = link.children('input').clone();

            var blank = link.attr('target');
            if (blank) {
                form.attr('target', blank);
            }

            if (!is_post) {
                var hiddenInput = $('<input>', {'name': '_method', 'type': 'hidden', 'value': link.data('method')});
                return form.append(token, hiddenInput, inputs).appendTo('body');
            }

            return form.append(token, inputs).appendTo('body');
        }
    };

    laravel.initialize();

})();