var maskBehavior = function (val) {
  return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {onKeyPress: function(val, e, field, options) {
        field.mask(maskBehavior.apply({}, arguments), options);
    }
};

$('.input-tel').mask(maskBehavior, options);
$('.input-money').mask("#,##0.00", {reverse: true});

$("input[type='number']").siblings("label").after("<small class='text-muted'> (somente números)</small>")
$("input[type='number']").on("input paste", function() {
        this.value = this.value.replace(/[^\d\.\-]/g,'');
    }
);
