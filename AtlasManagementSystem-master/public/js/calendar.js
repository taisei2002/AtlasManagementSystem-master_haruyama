$(function () {
       $('.delete-modal-open').on('click', function () {
           $('.js-modal').fadeIn();

           var setting_reserve = $(this).attr('setting_reserve');
           var setting_part = $(this).attr('setting_part');
           $('.setting_reserve').text('予約日：' + setting_reserve);
           $('.setting_part').text('時間：リモ' + setting_part + '部');
           $('.setting_reserve').val(setting_reserve);
           $('.setting_part').val(setting_part);
        return false;
    });
    $('.js-modal-close').on('click', function () {
        $('.js-modal').fadeOut();
        return false;
    });

});
