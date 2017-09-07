if (!RedactorPlugins) var RedactorPlugins = {};

(function ($) {
    RedactorPlugins.fontcolor = function () {
        return {
            langs: {
                ja: {
                    "fontcolor": "テキストの色",
                    "backcolor": "背景色"
                }
            },
            init: function () {
                var colors = [
                    '#000000', '#434343', '#666666', '#999999', '#B7B7B7', '#CCCCCC', '#D9D9D9', '#EFEFEF', '#FFFFFF',
                    '#FF0000', '#FF9900', '#FFFF00', '#00FF00', '#00FFFF', '#4A86E8', '#0000FF', '#9900FF', '#FF00FF',
                    '#F4CCCC', '#FCE5CD', '#FFF2CC', '#D9EAD3', '#D0E0E3', '#C9DAF8', '#CFE2F3', '#D9D2E9', '#EAD1DC',
                    '#EA9999', '#F9CB9C', '#FFE599', '#B6D7A8', '#A2C4C9', '#A4C2F4', '#9FC5E8', '#B4A7D6', '#D5A6BD',
                    '#E06666', '#F9CB9C', '#FFD966', '#93C47D', '#76A5AF', '#6D9EEB', '#6FA8DC', '#8E7CC3', '#C27BA0',
                    '#CC0000', '#E69138', '#F1C232', '#6AA84F', '#45818E', '#3C78D8', '#3D85C6', '#674EA7', '#A64D79',
                    '#990000', '#B45F06', '#BF9000', '#38761D', '#134F5C', '#1155CC', '#0B5394', '#351C75', '#802F57',
                    '#6D0B0B', '#7E470F', '#7E6000', '#648056', '#21464E', '#1C4586', '#073763', '#20124D', '#4C1130'
                ];

                var buttons = ['fontcolor', 'backcolor'];

                for (var i = 0; i < 2; i++) {
                    var name = buttons[i];

                    var button = this.button.add(name, this.lang.get(name));
                    var $dropdown = this.button.addDropdown(button);

                    $dropdown.width(242);
                    this.fontcolor.buildPicker($dropdown, name, colors);

                }
            },
            buildPicker: function ($dropdown, name, colors) {
                var rule = (name == 'backcolor') ? 'background-color' : 'color';

                var len = colors.length;
                var self = this;
                var func = function (e) {
                    console.log('set');
                    e.preventDefault();
                    self.fontcolor.set($(this).data('rule'), $(this).attr('rel'));
                };

                for (var z = 0; z < len; z++) {
                    var color = colors[z];

                    var $swatch = $('<a rel="' + color + '" data-rule="' + rule + '" href="#" style="float: left; font-size: 0; border: 2px solid #fff; padding: 0; margin: 0; width: 22px; height: 22px;"></a>');
                    $swatch.css('background-color', color);
                    $swatch.on('click', func);

                    $dropdown.append($swatch);
                }

                var $elNone = $('<a href="#" style="display: block; clear: both; padding: 5px; font-size: 12px; line-height: 1;"></a>').html(this.lang.get('none'));
                $elNone.on('click', $.proxy(function (e) {
                    console.log('remove');
                    e.preventDefault();
                    this.fontcolor.remove(rule);

                }, this));

                $dropdown.append($elNone);
            },
            set: function (rule, type) {
                this.inline.removeFormat();
                this.inline.format('span', 'style', rule + ': ' + type + ';', 'add');
            },
            remove: function (rule) {
                this.inline.removeStyleRule(rule);
            }
        };
    };
})(jQuery);