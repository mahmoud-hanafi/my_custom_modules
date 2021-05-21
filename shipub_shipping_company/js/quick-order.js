(function ($, Drupal) {
  Drupal.behaviors.shipubQuickOrder = {
    attach: function (context, settings) {
      $('form.node-form input.form-text:visible:enabled:first').focus();
      //.autocomplete('search', '');
    },
  };
})(jQuery, Drupal);
