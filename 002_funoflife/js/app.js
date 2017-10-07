window.$ = window.jQuery = require('jquery');
require('./lib/slick/slick.js')($);
require('./lib/jquery.customSelect/jquery.customSelect.js')($);

$('.slider ul').slick({
  dots: true,
  slidesToShow: 1,
  arrows: false
});

$('.pickySearch__contents').find('input').on('click', function () {
  var $this = $(this);
  $this.closest('label').toggleClass('is-checked', $this.prop('checked'));
});

$('.pickySearch__button a').on('click', function () {
  $(this).closest('.pickySearch').toggleClass('is-active');
  return false;
});

var $container = $('[data-tabs="container"]'),
    $target = $container.find('[data-tabs="target"]'),
    $trigger = $container.find('[data-tabs="trigger"]');

$target.not(':first').hide();
/*
var heights = $target
  .map((i, el) => $(el).outerHeight())
  .get();
$container.find('[data-tabs="body"]').css('height', Math.max.apply({}, heights));
*/

$trigger.on('click', function () {
  var $self = $(this),
      $list = $self.closest('ul').find('li'),
      index = $list.index($self.closest('li'));
  $list.find('a').removeClass('is-active');
  $self.addClass('is-active');
  $target.hide().eq(index).show();
  return false;
});

$('[data-accordion="trigger"]').on('click', function () {
  $(this).closest('[data-accordion="container"]').find('[data-accordion="target"]').toggle();
  return false;
});



/* mobile タブ用 */
var $tabs = $('[data-sptabs="trigger"]').find('div'),
    $triggerSP = $tabs.find('a'),
    $targetSP = $('[data-sptabs="target"]').find('div');

$triggerSP.on('click', function(e){
  e.preventDefault();
  $tabs.removeClass('is-active');
  $(this).closest('div').addClass('is-active');
  var tabIdx = $(this).closest('div').index();
  $targetSP.removeClass('is-active');
  $targetSP.eq(tabIdx).addClass('is-active');
});
