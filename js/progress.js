(function( $ ){
  // Inputs: Progress as a percent, Callback
  // Add options and jQuery UI support.
  $.fn.animateProgress = function(progress, callback) {    
    return this.each(function() {
      $(this).animate({
        width: progress+'%'
      }, {
        duration: 4000, 
        
        // swing or linear
        easing: 'swing',

        // this gets called every step of the animation, and updates the label
        step: function( progress ){
          var labelEl = $('.ui-label', this),
              valueEl = $('.value', labelEl);
          
          if (Math.ceil(progress) < 20 && $('.ui-label', this).is(":visible")) {
            labelEl.hide();
          }else{
            if (labelEl.is(":hidden")) {
              labelEl.fadeIn();
            };
          }
          
          if (Math.ceil(progress) == 100) {
            labelEl.text('Done');
            setTimeout(function() {
              labelEl.fadeOut();
            }, 1000);
          }else{
            valueEl.text(Math.ceil(progress) + '%');
          }
        },
        complete: function(scope, i, elem) {
          if (callback) {
            callback.call(this, i, elem );
          };
        }
      });
    });
  };
})( jQuery );

$(function() {
  // Hide the label at start
  $('#detail').hide();
  $('#progress_bar .ui-progress .ui-label').hide();
  // Set initial value
  $('#progress_bar .ui-progress').css('width', '7%');

  // Simulate some progress
  $('#progress_bar .ui-progress').animateProgress(43, function() {
    $(this).animateProgress(79, function() {
      setTimeout(function() {
        $('#progress_bar .ui-progress').animateProgress(100, function() {
          $('#detail').show();
          //$('#fork_me').fadeIn();
          $('#progress_bar').hide();
        });
      }, 2000);
    });
  });
  
});