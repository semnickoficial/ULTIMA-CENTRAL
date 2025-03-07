$(function () {
  'use strict'

  // Initialize Bootstrap components
  $('[data-toggle="tooltip"]').tooltip();
  $('[data-toggle="popover"]').popover();

  // Theme functions
  function get(name) {
    if (typeof (Storage) !== 'undefined') {
      return localStorage.getItem(name);
    }
    return null;
  }

  function store(name, val) {
    if (typeof (Storage) !== 'undefined') {
      localStorage.setItem(name, val);
    }
  }

  // Theme switcher
  var mySkins = [
    'theme-fruit',
    'theme-purple',
    'theme-oceansky',
    'theme-rosegold',
    'theme-ultraviolet',
    'theme-botani',
    'theme-ubuntu',
    'theme-patriot',
    'theme-vintage',
    'theme-mint',
    'theme-deepocean',
    'theme-school',
    'theme-leaf',
    'theme-metalred',
    'theme-grey',
  ];

  function changeSkin(cls) {
    $.each(mySkins, function (i) {
      $('body').removeClass(mySkins[i]);
    });

    $('body').addClass(cls);
    store('theme', cls);
    return false;
  }

  // Setup theme
  function setup() {
    var tmp = get('theme');
    if (tmp && $.inArray(tmp, mySkins)) {
      changeSkin(tmp);
    }

    // Add the change skin listener
    $('[data-theme]').on('click', function (e) {
      if ($(this).hasClass('knob')) return;
      e.preventDefault();
      changeSkin($(this).data('theme'));
    });

    // Dark/Light mode toggle
    $('[data-mainsidebarskin="toggle"]').on('click', function () {
      var $body = $('body');
      if ($body.hasClass('dark-skin')) {
        $body.removeClass('dark-skin').addClass('light-skin');
      } else {
        $body.removeClass('light-skin').addClass('dark-skin');
      }
    });
  }

  // Initialize
  setup();
});