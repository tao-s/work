window.$ = window.jQuery = require('jquery');
require('./lib/slick/slick.js')($);
require('./lib/jquery.customSelect/jquery.customSelect.js')($);

var $trigger = $('[data-accordion-trigger]');
$trigger.on('click', function () {
  var val = $(this).data('accordionTrigger'),
      $target = $(`[data-accordion-target="${val}"]`);
  $target.toggle();
  return false;
});

$('.slider ul').slick({
  dots: true,
  slidesToShow: 1,
  arrows: false,
  responsive: [
    {
      breakpoint: 568,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    }
  ]
});

$('.pickySearch__contents').find('input').on('click', function () {
  var $this = $(this);
  $this.closest('label').toggleClass('is-checked', $this.prop('checked'));
});

$('.pickySearch__button a').on('click', function () {
  $(this).closest('.pickySearch').toggleClass('is-active');
  return false;
});
