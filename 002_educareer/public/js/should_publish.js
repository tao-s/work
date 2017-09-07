(function() {

    var publish = {
        initialize: function() {
            this.registerEvents();
        },

        registerEvents: function() {
            $('body').on('click', '.publish', this.handleMethod);
        },

        handleMethod: function(e) {
            var link = $(this);

            publish.sendRequest(link);

            e.stopImmediatePropagation();
            e.preventDefault();

        },

        sendRequest: function(link) {
            var url = link.attr('data-href');

            // ajax call
            $.get(url, function(data) {
                if (parseInt(data) == 1) {
                    // should publish
                    var token_value = $('input[name=_token]').val();
                    var form = $('<form>', {'method': 'POST', 'action': link.attr('href')});
                    var token = $('<input>', {'name': '_token', 'type': 'hidden', 'value': token_value});
                    var hiddenInput = $('<input>', {'name': '_method', 'type': 'hidden', 'value': link.data('method')});

                    form.append(token, hiddenInput).appendTo('body').submit();

                } else {
                    // should not publish
                    $('#modalToPlan').modal();
                }
            });
        }
    };

    publish.initialize();

})();
