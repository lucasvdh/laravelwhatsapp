function ignore(evt) {
  evt.stopPropagation();
  evt.preventDefault();
}

$(function () {
  $('.iban.validate').each(function () {
    var iban = $(this),
      validate_url = iban.data('validate-url'),
      input = $(':input', iban),
      check = $('.check', iban),
      icon = $('.mdi', check),
      timeout = 0,
      ignore_keys = [13, 38, 40, 39, 37, 27, 17, 18, 16];

    input.on('keyup blur', function (e) {
      console.log('$.inArray(e.which, ignore_keys)', $.inArray(e.which, ignore_keys), e.which)
      if (typeof e.which !== 'undefined' && $.inArray(e.which, ignore_keys) !== -1) {
        return
      }
      clearTimeout(timeout);
      timeout = setTimeout(checkIban, 200);
    });

    function checkIban() {
      var iban_val = input.val(),

        iban_val = iban_val.replace(/\//g, '');

      if (iban_val.length > 0) {
        $.ajax({
          type: "GET",
          url: validate_url + '/' + iban_val
        }).done(function (json) {
          console.log('typeof json.suggestion !== undefined', typeof json.suggestion !== 'undefined');
          if (typeof json.error !== 'undefined') {
            iban.addClass('has-error').removeClass('has-success');

            icon.addClass('mdi-alert');
            icon.removeClass('mdi-checkbox-blank-circle-outline');
            icon.removeClass('mdi-check');
          }
          else if (typeof json.suggestion !== 'undefined') {
            iban.addClass('has-error').removeClass('has-success');

            icon.addClass('mdi-checkbox-blank-circle-outline');
            icon.removeClass('mdi-alert');
            icon.removeClass('mdi-check');

            $.snackbar({
              content: 'De IBAN is mogelijk incorrect, bedoel je misschien: ' + json.suggestion + ' ?',
              style: 'toast',
              timeout: 10000
            });
          }
          else {
            iban.addClass('has-success').removeClass('has-error');

            input.val(json.iban);

            icon.addClass('mdi-check');
            icon.removeClass('mdi-checkbox-blank-circle-outline');
            icon.removeClass('mdi-alert');
          }
        });
      }
      else {
        iban.removeClass('has-error').removeClass('has-success');

        icon.addClass('mdi-checkbox-blank-circle-outline');
        icon.removeClass('mdi-alert');
        icon.removeClass('mdi-check');
      }
    }

    checkIban();
  });

  $(document).on('blur', '.license-plate.validate input', function () {
    var licenseplate = $(this),
      wrapper = licenseplate.parent(),
      validate_url = licenseplate.data('validate-url');

    $.get(validate_url + '/' + encodeURIComponent(licenseplate.val().replace('/', '')), function (result) {
      if (result.error) {
        wrapper.addClass('invalid');
      }
      if (result.success) {
        wrapper.removeClass('invalid');
        licenseplate.val(result.formatted);
      }
    });
  });

  $(document).on('blur', '.housenumber.validate', function () {
    var housenumber = $(this),
      parent = housenumber.closest('.form-group').parent(),
      validate_url = housenumber.data('validate-url');

    if (parent.find('.postcode').length == 0) {
      parent = housenumber.closest('.panel-body');
    }

    if ($('.ignore:checkbox', housenumber.parents('.panel-body')).is(':checked')) {
      return;
    }

    var postalcode = parent.find('.postcode'),
      street = parent.find('.street'),
      city = parent.find('.city'),
      county = parent.find('.county'),
      address = parent.find('.address');

    if (housenumber.val().length > 0) {
      street.val('Moment ...');
      $.ajax({
        type: "GET",
        dataType: "json",
        url: validate_url + '/' + postalcode.val() + '/' + housenumber.val()
      }).done(function (json) {
        if (typeof json.error !== 'undefined') {
          if (street.length > 0) {
            street.val('Onbekend');
          }
        }
        else {
          if (street.length > 0) {
            street.val(json.street);
          }
          if (city.length > 0) {
            city.val(json.city);
          }
          if (county.length > 0) {
            county.val(json.county);
          }
          if (address.length > 0) {
            address.val(json.street + ' ' + json.housenumber);
          }
          postalcode.val(json.postcode);
        }
      });
    }
  });

  $('form .date-picker:not(.dont-check)').parents('form').submit(function () {
    var o = $(this),
      dateFields = o.find('.date-picker:not(.dont-check)'),
      submit = true,
      dateRegex = /^(0[1-9]|1\d|2\d|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/,
      first;


    dateFields.each(function () {
      if (!(dateRegex.test($(this).val()))) {
        submit = false;
        $(this).parents('.form-group').addClass('has-error');
        $(this).parents('.input-group').after($('<span class="help-block">Ongeldige datum</span>'));
        if (!first) {
          first = $(this);
          first.focus();
        }
      }
    });

    return submit;
  });

  // Init date picker
  $('.date-picker').datepicker()
    .on('changeDate', function (ev) {
      $(this).datepicker('hide');
      $(this).trigger("setvalue");
      $(this).change();
    })
    .on('blur', function (ev) {
      var o = $(this);
      setTimeout(function () {
        if ($(':input:focus').length == 1) {
          o.datepicker('hide');
        }
      }, 100);
    })
    .focusin(function () {
      $(this).data('current-val', $(this).val());
    })
    .inputmask(
      "d/m/y",
      {
        "placeholder": "dd/mm/jjjj",
        "showMaskOnHover": false
      }
    )
    .click(function () {
      $(this).val($(this).data('current-val'));
    });

  $(document).on('change', 'form .date-picker:not(.dont-check)', function () {
    var o = $(this),
      dateRegex = /^(0[1-9]|1\d|2\d|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/;

    if (!(dateRegex.test(o.val()))) {
      o.parents('.form-group').addClass('has-error');
      o.parents('.input-group').after($('<span class="help-block">Ongeldige datum</span>'));
    }
    else {
      o.parents('.form-group').removeClass('has-error');
      o.parents('.form-group').find('.help-block').remove();
    }

    return submit;
  });

  // Init chosen select
  $(".chosen-select:not(.inline)").chosen({
    width: '100%',
    placeholder_text_single: "Selecteer..",
    placeholder_text_multiple: "Selecteer..",
    no_results_text: "Helaas, niets gevonden voor",
    search_contains: true
  });
  $(".chosen-select.inline:not(.table-cell)").chosen({
    width: 'initial',
    placeholder_text_single: "Selecteer..",
    placeholder_text_multiple: "Selecteer..",
    no_results_text: "Helaas, niets gevonden voor",
    search_contains: true
  });
  $(".chosen-select.inline.table-cell").chosen({
    styles: {
      width: 'initial',
      display: 'table-cell'
    },
    placeholder_text_single: "Selecteer..",
    placeholder_text_multiple: "Selecteer..",
    no_results_text: "Helaas, niets gevonden voor",
    search_contains: true
  });

  $(document).on('click', '.input-group .input-group-addon', function () {
    $(this).siblings(':input').focus();
  });

  $(document).ajaxComplete(function () {
    $('.form-control.amount, .form-control.integer')
      .inputmask(
        "decimal",
        {
          radixPoint: ".",
          // autoGroup: true,
          // groupSeparator: ".",
          // groupSize: 3
        }
      );
    $('[data-toggle="popover"]').popover();
    // Init chosen select
    $(".chosen-select:not(.inline)").chosen({
      width: '100%',
      placeholder_text_single: "Selecteer..",
      placeholder_text_multiple: "Selecteer..",
      no_results_text: "Helaas, niets gevonden voor",
      search_contains: true
    });
    $(".chosen-select.inline:not(.table-cell)").chosen({
      width: 'initial',
      placeholder_text_single: "Selecteer..",
      placeholder_text_multiple: "Selecteer..",
      no_results_text: "Helaas, niets gevonden voor",
      search_contains: true
    });
    $(".chosen-select.inline.table-cell").chosen({
      styles: {
        width: 'initial',
        display: 'table-cell'
      },
      placeholder_text_single: "Selecteer..",
      placeholder_text_multiple: "Selecteer..",
      no_results_text: "Helaas, niets gevonden voor",
      search_contains: true
    });
    // Tooltip dynamically loaded content
    $('.tooltip-toggle').tooltip();
    $('.checkbox > label:not(:has(.ripple))').each(function () {
      $('<span class="ripple"></span><span class="check"></span>').insertAfter($(':checkbox', this));
    });
    $('.radio > label:not(:has(.circle))').each(function () {
      $('<span class="circle"></span><span class="check"></span>').insertAfter($(':radio', this));
    });

    $('.date-picker').datepicker()
      .on('changeDate', function (ev) {
        $(this).datepicker('hide');
        $(this).trigger("setvalue");
        $(this).change();
      })
      .on('blur', function (ev) {
        var o = $(this);
        setTimeout(function () {
          if ($(':input:focus').length == 1) {
            o.datepicker('hide');
          }
        }, 100);
      })
      .focusin(function () {
        $(this).data('current-val', $(this).val());
      })
      .inputmask(
        "d/m/y",
        {
          "placeholder": "dd/mm/jjjj",
          "showMaskOnHover": false
        }
      )
      .click(function () {
        $(this).val($(this).data('current-val'));
      });
  });
});