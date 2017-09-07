(function() {

    /**
     * 無料会員に有料プランへの加入を促すダイアログを表示する
     */
    var upgrade = {
        initialize: function() {
            this.registerEvents();
        },

        registerEvents: function() {
            // 2016/1/23 無料プランの登録数制限が無くなったのでダイアログ表示を無効化
            //$('body').on('click', '#new', this.handleMethod);
        },

        handleMethod: function(e) {
            var link = $(this);

            upgrade.sendRequest(link);

            e.preventDefault();
        },

        sendRequest: function(link) {
            var url = link.attr('data-href');

            // ajax call
            $.get(url, function(data) {
                if (parseInt(data) == 1) {
                    // should upgrade
                    $('#modalToPlan').modal();
                } else {
                    // should not upgrade
                    location.href = '/posting/create'
                }
            });
        }
    };

    upgrade.initialize();

})();