$(function () {
  $('.search_conditions').click(function () {
    $('.search_conditions_inner').slideToggle();
  });

  $('.subject_edit_btn').click(function () {
      $('.subject_inner').slideToggle(200);
      $(this).toggleClass('open', 200);
  });


});


jQuery(function ($) {
    $('.js-search_conditions').on('click', function () {
        /*クリックでコンテンツを開閉*/
        $(this).next().slideToggle(200);
        /*矢印の向きを変更*/
        $(this).toggleClass('open', 200);
    });

});
