(function ($, Drupal) {
  Drupal.behaviors.date = {
    attach: function attach() {
      $('[data-toggle="datepicker"]').datepicker({
        format: 'mm-yyyy',
        autoHide: true,
        container: true,
      });
    }
  };
})(jQuery, Drupal);
