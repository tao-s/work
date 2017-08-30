$(function() {

  $(".jsc-modal-open").click( function() {

    $(this).blur() ;
    if($(".jsc-modal-overlay")[0]) return false ;

    $("body").append('<div class="jsc-modal-overlay"></div>');
    $(".jsc-modal-overlay").fadeIn("slow");
    $(".jsc-modal-content").fadeIn("slow");
  });

  $(".jsc-modal-close").unbind().click(function() {

    $(".jsc-modal-content, .jsc-modal-overlay").fadeOut("slow",function() {

      $(".jsc-#modal-overlay").remove();
    });
  });

  $(document).on("click", ".jsc-modal-overlay", function() {

    $(".jsc-modal-content, .jsc-modal-overlay").fadeOut("slow",function() {

      $(".jsc-modal-overlay").remove();
    });
  });

});
