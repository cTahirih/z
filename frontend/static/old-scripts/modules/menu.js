define([
], function () {

  function menu() {
    $('.BurgerMenu').on('click', function(){
      $('body, html').toggleClass('is-menuOpened');
      if($('body').hasClass('is-menuOpened')){
        $('.MenuWeb').fadeIn();
      } else {
        $('.MenuWeb').fadeOut();
      }
    });
  };

  return menu;
});


