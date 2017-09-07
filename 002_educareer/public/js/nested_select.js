(function () {

    [1, 2, 3].forEach(function (id) {
        $('#inputOccupationCategoryParent' + id).on('change', function () {
            onChange(id);
        });
    });

    function onChange(id) {
        var parent = $('#inputOccupationCategoryParent' + id);
        var select = $('#inputOccupationCategory' + id);
        var freeWord = $('#inputOccupationCategoryFreeWord' + id);

        showOptions(parent.val(), select.children());

        switch (Number(parent.val())) {
            case 0:
                select.hide();
                freeWord.hide();
                break;
            case 8:
                select.hide();
                freeWord.show();
                break;
            default:
                select.show();
                freeWord.hide();
        }
    }

    function showOptions(parentVal, options) {
        Object.keys(options).forEach(function (key) {
            var option = options[key];
            var optionValue = '';
            var prevHidden = option.hidden;

            if (option && option.value) {
                optionValue = options[key].value.toString();
            }

            // オプションのvalueの最初の1文字が親selectのoptionのvalueと
            // 一致しない場合はoptionを非表示にする
            option.hidden = !(optionValue.substr(0, 1) === parentVal.toString());

            // 表示中のoptionが変化したら、selectedをリセット
            if (prevHidden !== option.hidden) {
                option.selected = false;
                options[0].selected = true;
            }
        });
    }

})();