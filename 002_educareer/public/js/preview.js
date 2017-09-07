(function() {

    var preview = {
        initialize: function() {
            this.registerEvents();
        },

        registerEvents: function() {
            $('body').on('click', '#preview', this.handleMethod);
        },

        handleMethod: function(e) {
            var link = $(this);

            preview.openPreview(link);

            e.preventDefault();
        },

        openPreview: function(link) {
            var method_value = $('input[name=_method]').val();

            var form = $('form');
            var original_link = form.attr('action');
            form.attr('action', link.attr('href'));
            form.attr('target', '_blank');
            form.find('input[name=_method]').remove();

            form.submit();
            form.attr('action', original_link);
            form.attr('target', '')
            if (method_value) {
                var method = $('<input>', {'name': '_method', 'type': 'hidden', 'value': method_value});
                form.append(method);
            }
        }
    };

    preview.initialize();

})();