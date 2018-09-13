require([
  'jquery',
  'menu',
  'easyModal'
  ], function ($, menu, easyModal) {

    var $doc = $(document);

		function init() {
      console.log('123');
      menu();
      var $easyModal = new easyModal({
        triggerSelectorOpen: '.open-modal',
        triggerSelectorClose: '.modal-close'
      })
    }

		$doc.ready(init);
});