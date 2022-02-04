$(window).scroll(function(){
	if ($(this).scrollTop() > 100) {
  	$('.main_menu').addClass('fixed');
	} else {
  	$('.main_menu').removeClass('fixed');
	}
});
if($(window).width() < 992 ){
  $(window).scroll(function(){
    if ($(this).scrollTop() > 0) {
        $('.topbar').addClass('fixed');
    } else {
        $('.topbar').removeClass('fixed');
    }
  });
}
function counter(){
  var a = 0;
  $(window).scroll(function() {
    var oTop = $('.counter-box').offset().top - window.innerHeight;
    if (a == 0 && $(window).scrollTop() > oTop) {
      $('.counter-value').each(function() {
        var $this = $(this),
          countTo = $(this).attr('data-count');
          $({
            countNum: $this.text()
          }).animate({
            countNum: countTo
          },
          {
            duration: 2000,
            easing: 'swing',
            step: function() {
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              $this.text(this.countNum);
              //alert('finished');
            }
          });
      });
      a = 1;
    }
  });
}
function progress(){
  $(window).scroll(function() {
  	var a = 0;
      var vdo = $('.progress_wrap').offset().top - window.innerHeight;
      if (a == 0 && $(window).scrollTop() > vdo) {
      	$('.progress_wrap').addClass('start');
      }
  });
}

$(document).ready(function(){
  $('.deal_with_slider').slick({
    dots: false,
    arrows: false,
    slidesToShow: 4,
    infinite: true,
    slidesToScroll: 1,
    swipesToSlide: 1,
    swipesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1
        }
      }
    ]
  });
});

$(document).ready(function(){
  $('.search-icon').click(function(){
    $('.search_wrap').css('transform','translate(0,0) scale(1,1)');
  });
  $('.search-close').click(function(){
    $('.search_wrap').css('transform','translate(0,-100%) scale(0,0)');
  });
});

$(document).ready(function(){
  $('a[href^="#"]').on('click', function(event) {
    var target = $(this.getAttribute('href'));
    if( target.length ) {
      event.preventDefault();
      $('html, body').stop().animate({
          scrollTop: target.offset().top - 68
      }, 1000);
    }
  });
})

$(document).ready(function(){ 
  var btn = $('#scroll');

  $(window).scroll(function() {
    if ($(window).scrollTop() > 200) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });

  btn.on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '2000');
  });
});

$(document).ready(function(){
  $('body').on('mouseenter mouseleave','.nav-item',function(e){
    if ($(window).width() > 750) {
      var _d=$(e.target).closest('.nav-item');_d.addClass('show');
      setTimeout(function(){
      _d[_d.is(':hover')?'addClass':'removeClass']('show');
      },1);
    }
  }); 
});


$(document).ready(function(){
  $('.testimonial_slider').slick({
    dots: false,
    arrows: true,
    slidesToShow: 1,
    infinite: true,
    slidesToScroll: 1,
    swipesToSlide: 1,
    swipesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    adaptiveHeight: true,
    prevArrow:"<button type='button' class='slick-prev pull-left'></button>",
    nextArrow:"<button type='button' class='slick-next pull-right'></button>"
  });
});


/****************/
$(document).ready(function(){
  $(".card-header").click(function(){
    $('.card-header.actives').not(this).removeClass('actives');
    $(this).toggleClass('actives');
  });
});

/********blogs********/
$(document).ready(function(){
  var maxLength = 120;
  $(".show-read-more").each(function(){
    var myStr = $(this).text();
    if($.trim(myStr).length > maxLength){
      var newStr = myStr.substring(0, maxLength);
      var removedStr = myStr.substring(maxLength, $.trim(myStr).length);
      $(this).empty().html(newStr);
      $(this).append('..');
    }
  });
});