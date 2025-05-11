function easyNumberSeparator(config) {
    // Currency Separator
    let commaCounter = 10;
  
    const obj = {
      selector: config.selector || ".number-separator",
      separator: config.separator || ",",
      decimalSeparator: config.decimalSeparator || ".",
      resultInput: config.resultInput
    }
  
    console.log(obj.separator);
  
    function numberSeparator(num) {
      for (let i = 0; i < commaCounter; i++) {
        num = num.replace(obj.separator, "");
      }
  
      x = num.split(obj.decimalSeparator);
      y = x[0];
      z = x.length > 1 ? obj.decimalSeparator + x[1] : "";
      let rgx = /(\d+)(\d{3})/;
  
      while (rgx.test(y)) {
        y = y.replace(rgx, "$1" + obj.separator + "$2");
      }
      commaCounter++;
  
      if (obj.resultInput) {
        const resInput = document.querySelector(obj.resultInput)
  
        if (resInput) {
          resInput.value = num.replace(obj.separator, "")
          resInput.value = num.replace(obj.decimalSeparator, ".")
        }
      }
  
      return y + z;
    }
  
    document.querySelectorAll(obj.selector).forEach(function (el) {
      el.addEventListener("input", function (e) {
        const reg = new RegExp(
          `^-?\\d*[${obj.separator}${obj.decimalSeparator}]?(\\d{0,3}${obj.separator})*(\\d{3}${obj.separator})?\\d{0,3}$`
        );
  
        const key = e.data || this.value.substr(-1)
  
        if (reg.test(key)) {
          e.target.value = numberSeparator(e.target.value);
        } else {
          e.target.value = e.target.value.substring(0, e.target.value.length - 1);
          e.preventDefault();
          return false;
        }
      });
      el.value = numberSeparator(el.value);
    });
  }


easyNumberSeparator({
    selector: '.number-format',
    separator: '.',
    decimalSeparator: ','
});

$(".number-format").on("keypress keyup blur",function (event) {
    $(this).val($(this).val().replace(/[^0-9\.|\,]/g,''));
    if(event.which == 44)
    {
    return true;
    }
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57  )) {
    
      event.preventDefault();
    }
  });

  window.setTimeout(function () { 
    if($('.alert-success').length){
      $(".alert-success").alert('close'); 
    }
}, 2000);   


$('.select2').select2();

jQuery(document).ready(function() {
  $('.navbar-toggler').on('click', function(){
    $('#navbarCollapse').slideToggle();
  })
});