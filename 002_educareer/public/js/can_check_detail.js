(function() {

    var publish = {
        initialize: function() {
            this.registerEvents();
        },

        registerEvents: function() {
            $('body').on('click', '.check_detail', this.handleMethod);
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
            var return_to = link.attr('href');
            $.get(url, function(data) {
                if (parseInt(data) == 1) {
                    // can check detail
                    location.href = return_to;

                } else {
                    // should not publish
                    $('#modalToPlan').modal();
                }
            });
        }
    };

    publish.initialize();

})();
