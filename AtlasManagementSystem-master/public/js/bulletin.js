$(function () {
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });

  $(document).on('click', '.like_btn', function (e) {
    e.preventDefault();
    $(this).addClass('un_like_btn');
    $(this).removeClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      console.log(res);
      $('.like_counts' + post_id).text(countInt + 1);
    }).fail(function (res) {
      console.log('fail');
    });
  });

  $(document).on('click', '.un_like_btn', function (e) {
    e.preventDefault();
    $(this).removeClass('un_like_btn');
    $(this).addClass('like_btn');
    var post_id = $(this).attr('post_id');
    var count = $('.like_counts' + post_id).text();
    var countInt = Number(count);

    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: {
        post_id: $(this).attr('post_id'),
      },
    }).done(function (res) {
      $('.like_counts' + post_id).text(countInt - 1);
    }).fail(function () {

    });
  });

  $('.edit-modal-open').on('click',function(){
    $('.js-modal').fadeIn();
    var post_title = $(this).attr('post_title');
    var post_body = $(this).attr('post_body');
    var post_id = $(this).attr('post_id');
    $('.modal-inner-title input').val(post_title);
    $('.modal-inner-body textarea').text(post_body);
    $('.edit-modal-hidden').val(post_id);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

});

/* acordion */


document.addEventListener('DOMContentLoaded', function () {
    const accordions = document.querySelectorAll('.accordion-item');

    accordions.forEach(accordion => {
        const selectBox = accordion.querySelector('.subCategory_pulldown');
        selectBox.size = selectBox.options.length; // オプションの数だけ表示する

        accordion.addEventListener('click', function (event) {
            if (!selectBox.contains(event.target)) {
                this.classList.toggle('active');
                const content = this.querySelector('.accordion-text');
                const arrow = this.querySelector('.arrow-icon');

                if (content.style.display === 'block') {
                    content.style.display = 'none';
                    arrow.classList.remove('rotate');
                } else {
                    content.style.display = 'block';
                    arrow.classList.add('rotate');
                }

                // 選択されたアコーディオン以外のすべてのアコーディオンを閉じる
                accordions.forEach(item => {
                    if (item !== accordion) {
                        item.classList.remove('active');
                        const otherContent = item.querySelector('.accordion-text');
                        const otherArrow = item.querySelector('.arrow-icon');
                        otherContent.style.display = 'none';
                        otherArrow.classList.remove('rotate');
                    }
                });
            } else {
                const content = this.querySelector('.accordion-text');
                const arrow = this.querySelector('.arrow-icon');

                if (content.style.display === 'block') {
                    content.style.display = 'none';
                    arrow.classList.remove('rotate');
                } else {
                    content.style.display = 'block';
                    arrow.classList.add('rotate');
                }
            }
        });
    });
});
