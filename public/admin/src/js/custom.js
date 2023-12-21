$(document).ready(function(){
	var sidebarCollapse = localStorage['collapse-indicator'] || 'false';    
	if(sidebarCollapse === 'true'){
		$('body').addClass('sidebar-collapse');
	}  	
    
    window.setTimeout(function() {
        $(".auto-close-alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).slideUp(500);
        });        
    }, 2000);

    $('.input-price').each(function(index, elem) {
        var value = $(this).val();        
        $(this).val(thousandFunction(value));
    });    

    $('.datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        zIndexOffset: 2000
    });
    
    $('.select2').select2({
        placeholder: 'Please Select...',
        width: '100%'
    });
    $('.select2-tag').select2({
        tags: true
    });

});

 window.thousandFunction = function(num) {
    var number = num.toString().replace(/[^,\d]/g, '').toString(),
        split = number.split(','),
        remaining = split[0].length % 3,
        value = split[0].substr(0, remaining),
        thousand = split[0].substr(remaining).match(/\d{3}/gi);

    if (thousand) {
        var separator = remaining ? '.' : '';
        value += separator + thousand.join('.');
    }

    return split[1] !== undefined ? value + ',' + split[1] : value;
};

window.summernoteOptions = {
    fontNames: [
        'Arial', 
        'Arial Black', 
        'Comic Sans MS', 
        'Courier New', 
        'Gotham Black',
        'Gotham BlackItalic',
        'Gotham Bold',
        'Gotham BoldItalic',
        'Gotham Book',
        'Gotham BookItalic',
        'Gotham Light',
        'Gotham LightItalic',
        'Gotham Medium',
        'Gotham MediumItalic',
        'Gotham Thin',
        'Gotham ThinItalic',
        'Gotham Ultra',
        'Gotham UltraItalic',
        'Gotham XLight',
        'Gotham XLightItalic'
    ],
    fontNamesIgnoreCheck: [
        'Gotham Black',
        'Gotham BlackItalic',
        'Gotham Bold',
        'Gotham BoldItalic',
        'Gotham Book',
        'Gotham BookItalic',
        'Gotham Light',
        'Gotham LightItalic',
        'Gotham Medium',
        'Gotham MediumItalic',
        'Gotham Thin',
        'Gotham ThinItalic',
        'Gotham Ultra',
        'Gotham UltraItalic',
        'Gotham XLight',
        'Gotham XLightItalic'
    ],
    height: 700,
    toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link']],
        ['view', ['fullscreen', 'codeview', 'help']],
    ],
};

window.parsleyOptions = {
    //successClass: "has-success",
    errorClass: "has-error",
    classHandler: function (el) {
      return el.$element.closest(".form-group");
    },
    errorsWrapper: "<span class='help-block'></span>",
    errorTemplate: "<span></span>"
};

//has uppercase
window.Parsley.addValidator('uppercase', {
    requirementType: 'number',
    validateString: function(value, requirement) {
      var uppercases = value.match(/[A-Z]/g) || [];
      return uppercases.length >= requirement;
    },
    messages: {
      en: 'Your password must contain at least (%s) uppercase letter.'
    }
  });
  
  //has lowercase
  window.Parsley.addValidator('lowercase', {
    requirementType: 'number',
    validateString: function(value, requirement) {
      var lowecases = value.match(/[a-z]/g) || [];
      return lowecases.length >= requirement;
    },
    messages: {
      en: 'Your password must contain at least (%s) lowercase letter.'
    }
  });
  
  //has number
  window.Parsley.addValidator('number', {
    requirementType: 'number',
    validateString: function(value, requirement) {
      var numbers = value.match(/[0-9]/g) || [];
      return numbers.length >= requirement;
    },
    messages: {
      en: 'Your password must contain at least (%s) number.'
    }
  });
  
  //has special char
  window.Parsley.addValidator('special', {
    requirementType: 'number',
    validateString: function(value, requirement) {
      var specials = value.match(/[^a-zA-Z0-9]/g) || [];
      return specials.length >= requirement;
    },
    messages: {
      en: 'Your password must contain at least (%s) special characters.'
    }
  });
  

window.previewImage = function(element, imageId){
    var reader = new FileReader();
    reader.onload = function (e) {
        $(imageId).attr('src', e.target.result).show();
    };
    reader.readAsDataURL(element.files[0]);
    $(imageId).parent().show();
};

window.slugify = function(element, target){        
    var text = $(element).val()
        .toLowerCase()
        .replace(/(\w)\'/g, '$1')
        .replace(/[^a-zA-Z0-9_\-]+/g, '-')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
    $(target).val(text);
};

window.slugFormat = function(evt) {
    evt = evt || window.event;
    var charCode = evt.which || evt.keyCode;
    var charStr = String.fromCharCode(charCode);
    if ( !(/[a-z0-9-_]/i.test(charStr)) ) {
        evt.preventDefault();
    }
};

window.numericOnly = function(e) {
    var code = ('charCode' in e) ? e.charCode : e.keyCode;
    if (code != 13 && // enter        
        !(code > 47 && code < 58)) { // numeric (0-9)
        e.preventDefault();
    }
};

window.numericDotOnly = function(e) {
    var code = ('charCode' in e) ? e.charCode : e.keyCode;    
    if (code != 13 && // enter  
        code != 46 &&       
        !(code > 47 && code < 58)) { // numeric (0-9)
        e.preventDefault();
    }
};

window.decimalOnly = function(e) {
    var code = ('charCode' in e) ? e.charCode : e.keyCode;
    if (code != 13 && // enter
        code != 46 &&
        !(code > 47 && code < 58)) { // numeric (0-9)
        e.preventDefault();
    }
};

window.thousandFormat = function(e) {        
    var format =  $(e).val().toString().replace(/\./g,'').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $(e).val(format);
};

window.handleDeleteDialog = function(datatable=null){
    $(document).on('click' ,'.deleteDialog', function(e){
        e.preventDefault()
        var title = $(this).data('title');
        var redirect = $(this).attr('href');
        var message = 'Delete ' + '"' + title + '" ?';
        if($(this).data('message')){
            message = $(this).data('message');
        }

        Swal.fire({
            title: title,
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteItem(redirect, datatable);
            }
        })
    })
}

function deleteItem(redirect, datatable) {
    $.ajax({
        url: redirect,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        data: {
            _method: 'DELETE'
        },
        success: function(response) {
            Swal.fire({
                title: 'Deleted!',
                text: 'The item has been deleted.',
                icon: 'success'
            }).then(() => {
                if(datatable){
                    datatable.draw()
                }else{
                    window.location.reload()
                }
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while deleting the item.',
                icon: 'error'
            });
        }
    });
}
