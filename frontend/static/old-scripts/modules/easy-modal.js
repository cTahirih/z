define([
], function() {

  var $modal;
  var defaults = {
    'triggerSelectorOpen': null,
    'triggerSelectorClose': null,
    'onClose': null,
    'onAfterShow': null
  };
  
  var EasyModal = function(options) {
    this.options = $.extend({}, defaults,  options);
    this.init();
  }

  EasyModal.prototype = {
    constructor: EasyModal,

    init: function(){
      $modal = $('.modal');

      if ($modal.length == 0) {
        console.log('Debes crear un div con la clase modal y otro con modal-content para iniciar.');
      }

      this._setupEvents(); 
    },

    _setupEvents: function(){
      var self = this;
      
      $(this.options.triggerSelectorOpen).on('click', {obj: this}, this.show);
      
      $(this.options.triggerSelectorClose).on('click', {obj: this}, this.close);

      $(document).on('keydown', {
        obj: this
      }, function(e) {
        if (e.keyCode == 27) {
          self.close(e);
        }
      });
    },

    show: function(e){
      console.log('x');
      $modal.fadeIn(500, e.data.obj.options.onAfterShow);
    },

    close: function(e){
      $modal.fadeOut(500, e.data.obj.options.onClose);
    }


  }

  return EasyModal;
});