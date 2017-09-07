/**
 * admin_interview_index.js
 *
 * 管理画面・インタビュー記事一覧用JavaScript
 */
(function (){
    "use strict";

    /**
     * インタビュー記事の並び順をリセット
     */
    $("#interview-order-reset").click(function () {
        $(".interview-order").each(function (key, select) {
            $(select.children).each(function (k, option) {
                // 「掲載なし」を選択している状態にする
                if (option.value === 0) {
                    option.selected = "selected";
                } else {
                    option.selected = "";
                }
            });
        });
    });
})();