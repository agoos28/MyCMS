var bxbusy = false;
var bxcar = [];
var startDate, endDate;
var today = moment();
var offDays = new Array();
var block_dates;

function getDateRange(startDate, duration, dateFormat) {
  var dates = []
	
  if (!moment.isDate(startDate)) {
    startDate = moment(startDate, 'YYYY-MM-DD')
  }
	
  var diff = duration;
  for (var i = 0; i < diff; i++) {
		var res = startDate.add(1, 'days').format('YYYY-MM-DD');
    if(res != 'Invalid date'){
    	dates.push(res);
		}
  }
  return dates;
};


function getWeekRange(startDate, duration, dateFormat) {
  var dates = [],
    start = moment(startDate),
    diff = duration;

  for (var i = 0; i < diff; i++) {
		var res = moment(start).add(7 * i, 'days').format(dateFormat);
		if(res != 'Invalid date'){
    	dates.push(res);
		}
  }
  return dates;
}

function validateDate() {
	$('#date-alert').hide()
  var valid = true
  var duration = $('input[name="option"]:checked').data('days')
	var price = $('input[name="option"]:checked').data('price')
  var startDate = $('#start-date').val()
  var dates = getDateRange(startDate, duration + 1)
	
  for (var i = 0; i < dates.length; i++) {
    if (jQuery.inArray(dates[i], block_dates) > 0) {
			$('.booking_duration').text('---')
			if(i == dates.length - 1){
				$('#date-alert').find('p').text('Ooops.. masa sewa + 1 bersinggungan, pilih tanggal atau durasi lain.')
			}else{
				$('#date-alert').find('p').text('Ooops.. masa sewa bersinggungan, pilih tanggal atau durasi lain.')
			}
			setTimeout(function(){
				$('#date-alert').show()
				$("html, body").animate({ scrollTop: $('#date-alert').offset().top - 200 }, 300);
			}, 100)
			jQuery('.addcart').prop('disabled', true)
      return false;
    }
  }
	if(startDate){
		$('.booking_duration').text(moment(startDate, 'YYYY-MM-DD').format('DD MMM YYYY') +' s/d '+ moment(startDate, 'YYYY-MM-DD').add(duration, 'days').format('DD MMM YYYY'))
	}
	if(price){
		$('.booking_cost').text('Rp. ' + addCommas(price))
		jQuery('.addcart').data('price', price) 
	}
  jQuery('.addcart').prop('disabled', false)
	return true
}

function checkForm(formId) {
  var error = [];
  var th = $(formId);
  th.find('.no-empty').each(function() {
    if ($(this).val() == '' && $(this).prop('disabled') == false) {
      $(this).css({
        background: '#f2dede'
      })
      if ($(this).find('option').length) {
        $(this).parent().find('.select2-selection').css({
          background: '#f2dede'
        })
        error.push('Please ' + $(this).find('option:first').text())
      } else {
        $(this).css({
          background: '#f2dede'
        })
        error.push($(this).attr('placeholder') + ' connot be empty')
      }
    } else {
      if ($(this).find('option').length) {
        $(this).parent().find('.select2-selection').css({
          background: '#fff'
        })
      } else {
        $(this).css({
          background: '#fff'
        })
      }
    }
  })
  var dest = 0
  th.find('.dest').each(function() {
    if ($(this).val() == '' && dest == 0) {
      $(this).css({
        background: '#f2dede'
      })
    } else {
      $(this).css({
        background: '#fff'
      })
      dest = 1
    }
  })
  if (th.find('select[name=service]').val() == '') {
    th.find('select[name=service]').css({
      background: '#f2dede'
    })
    if ($.inArray('Check shipping methode!', error) < 0) {
      error.push('Check shipping methode!')
    }
  }
  th.find('select[name=service]').change(function() {
    $(this).css({
      background: ''
    })
  })
  /*if(dest == 0){
  	if($.inArray('Enter shipment destination!', error) < 0){
  			error.push('Enter shipment destination!')
  		}
  }*/
  th.find('.num-only').each(function() {
    if (!/^[0-9]+$/.test($(this).val())) {
      $(this).css({
        background: '#f2dede'
      })
      error.push($(this).attr('placeholder') + ' must be number only!')
    } else {
      $(this).css({
        background: '#fff'
      })
    }
  })

  function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
  };


  th.find('.check-mail').each(function() {
    var th = $(this)
    var emailaddress = th.val()
    if (!isValidEmailAddress(emailaddress)) {
      th.css({
        background: '#f2dede'
      })
      if ($.inArray('Alamat email tidak valid!', error) <= 1 && !error.length) {
        error.push('Alamat email tidak valid!')
      }
    } else {
      th.css({
        background: '#fff'
      })
    }
  })

  if (error.length) {
    return error.join(' <br /> ')
  } else {
    return false;
  }
}

function viewPort() {
  var windowHeight = $(window).height();
  var windowWidth = $(window).width();
	if (windowWidth < 600) {
		$('.desc_blk').find('iframe').attr('width', windowWidth)
		$('.desc_blk').find('iframe').attr('height', windowWidth * 0.56)
	}else{
		var parwidth = $('.desc_blk').find('iframe').parent().width()
		$('.desc_blk').find('iframe').attr('width', parwidth)
		$('.desc_blk').find('iframe').attr('height', parwidth * 0.56)
	}
  $('.height-100').css({
    height: windowHeight
  })
  if ((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i))) {

  }
}

function header() {
  var windowHeight = $(window).height();
  var windowWidth = $(window).width();
  if (windowWidth < 1200) {
    $("html").removeClass("noIE");
  }
  if (windowWidth < 600) {
    $('#header').removeClass('sticky');
  }
  if (windowHeight > 850) {
    if ($('#header').length) {
      $(window).on('scroll', function() {
        var winH = $(window).scrollTop();
        var $pageHeader = $('#header');
        if (winH > 60) {
          $pageHeader.addClass('sticky');
          $('.headreplace').addClass('show')
        } else {
          $pageHeader.removeClass('sticky');
          $('.headreplace').removeClass('show')
        }
      });
    }
  };

  $('.wv').css({
    height: windowHeight,
    width: windowWidth
  })


  $('.scroll_down').click(function(event) {
    event.preventDefault();
    $('html, body').animate({
      scrollTop: windowHeight - 300
    }, 300);
  });
}


function carouselBx() {

  var containerWidth = $('.container').width();

  var itemWidth = (containerWidth / 4) - 15;

  if (containerWidth < 360) {
    itemWidth = containerWidth;
  } else if (containerWidth < 720) {
    itemWidth = (containerWidth / 3) - 15;
  }


  if (bxcar.length) {
    $('.bxcarousel').each(function(i, el) {
      bxcar[i].reloadSlider({
        responsive: true,
        slideWidth: containerWidth,
        moveSlides: 1,
        minSlides: 1,
        maxSlides: 1,
        slideMargin: 0,
      });
    });
  } else {
    $('.bxcarousel').each(function(i, el) {
      if ($(this).find('li').length > 3) {
        bxcar[i] = $(this).bxSlider({
          slideWidth: containerWidth,
          moveSlides: 1,
          minSlides: 1,
          maxSlides: 1,
          slideMargin: 0,
          nextText: '',
          prevText: ''
        });
        $('.bx-next').html(' <i class="fa fa-chevron-right"></i>');
        $('.bx-prev').html(' <i class="fa fa-chevron-left"></i>');
      } else {
        $(this).find('li').css({
          width: itemWidth,
          'marginRight': 0
        });
      }
    });
  }
}



function removeParam(key, sourceURL) {
  var rtn = sourceURL.split("?")[0],
    param,
    params_arr = [],
    queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
  if (queryString !== "") {
    params_arr = queryString.split("&");
    for (var i = params_arr.length - 1; i >= 0; i -= 1) {
      param = params_arr[i].split("=")[0];
      if (param === key) {
        params_arr.splice(i, 1);
      }
    }
    rtn = rtn + "?" + params_arr.join("&");
  }
  return rtn;
}

function get_max($el) {
  /* Get max height */
  var max = 0;
  $el.each(function() {
    var this_h = $(this).outerHeight();
    if (this_h > max) {
      max = this_h;
    }
  });
  return max;
}


function createCookie(name, value, days) {
  var expires;

  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toGMTString();
  } else {
    expires = "";
  }
  document.cookie = encodeURIComponent(name) + "=" + encodeURIComponent(value) + expires + "; path=/";
}

function readCookie(name) {
  var nameEQ = encodeURIComponent(name) + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) === ' ') {
      c = c.substring(1, c.length);
    }
    if (c.indexOf(nameEQ) === 0) {
      return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
  }
  return null;
}

function eraseCookie(name) {
  createCookie(name, "", -1);
}

$(document).mouseup(function(e) {
  var container = $(".menubtn");
  if (container.has(e.target).length === 0) {
    $(".menubtn").removeClass('menu_cshow');
  }
});
$(".menubtn > a").click(function() {
  if ($(this).parent().hasClass("menu_cshow")) {
    $(".menu_cshow").removeClass('menu_cshow');
    $(this).parent().removeClass('menu_cshow');
  } else {
    $(".menu_cshow").removeClass('menu_cshow');
    $(this).parent().addClass('menu_cshow');
  }
});


function addCart(elem) {
	var similar
  var data = elem.data()
  var count = elem.parent().parent().find('.qty').val()
  var option = $('input[name="option"]:checked').val()
	var extend_option = $('input[name="option-'+data.id+'"]:checked').val()
	var optiondata = $('input[name="option"]:checked').data()
	var deliver = $('input#start-date').val()
	
	if((!deliver) && (!data.pickup)){
		$('#date-alert').find('p').text('Pilih tanggal untuk melanjutkan.')
		setTimeout(function(){
			$('#date-alert').show()
			$("html, body").animate({ scrollTop: $('#date-alert').offset().top - 200 }, 300);
		}, 100)
		return false;
	}
	if((!option) && (!extend_option)){
		$('#date-alert').find('p').text('Pilih durasi untuk melanjutkan.')
		setTimeout(function(){
			$('#date-alert').show()
			$("html, body").animate({ scrollTop: $('#date-alert').offset().top - 200 }, 300);
		}, 100)
		return false;
	}
	
	if(!deliver){
		deliver = data.pickup
	}
	if(!option){
		option = extend_option
		optiondata = $('input[name="option-'+data.id+'"]:checked').data()
		data.price = optiondata.price
	}
  if (!count) {
    var count = 1
  }
	if(data.price == false || optiondata.price == true){
		data.price = optiondata.price
	}
	console.log(data)
  var href = baseUrl + 'cart?addcart=' + data.id
  var postdata = {
		'opt': option,
    'count': count,
		'deliver': deliver,
    'useajax': 'true'
  };
	
  var btntext = elem.text()
	elem.data('text', btntext)
  elem.parent().find('.cancel').addClass('hidden')
  elem.show()
	
	$('.shoppingcart .cart_row .item').each(function(index) {
		if ($(this).attr('id') == data.id) {
			alert('Product exist')
			similar = true
			return false
		}
	});
	
	if(similar){
		return false
	}
	
	elem.text('Wait')
	
	
  $.post(href, postdata, function(response) {
    if ($(window).width() < 753) {
      $('body, html').animate({
        scrollTop: 0
      })
    }
		
    setTimeout(function() {
      $('.shoppingcart').parent().addClass('menu_cshow')
      var html = '<ul id="' + data.id + '" class="item row no-padding new"><li class="col-sm-2 col-xs-3 p-r-0"><div class="pro_img"><span><img src="' + baseUrl + data.thumb + '"></span></div></li><li class="col-sm-5 col-xs-7"><h5 class="m-b-10"><a href="#">' + data.title + '</a></h5><div class="size">' + option + ' ' + data.booking_type +'</div></li><li class="col-sm-4 col-xs-10"><div class="price">Rp. <span class="subtotal">' + addCommas(parseInt(data.price)) + '</span></div></li><li class="col-sm-1 col-xs-2 p-l-0"> <a href="#" class="del_btn del"><i class="fa fa-trash-o"></i></a> </li></ul>'
			$("html, body").animate({ scrollTop: 0 });
      setTimeout(function() {
        elem.text(elem.data('text'))
        elem.parent().find('.sizewrap').find('.size').prop('selectedIndex', 0);
        
        
				$('.shoppingcart .cart_row').prepend(html)
				setTimeout(function() {
					$('.shoppingcart .cart_row').find('.new').slideDown()
					updatecart()
				}, 100)
        
        setTimeout(function() {
          $('.shoppingcart').parent().removeClass('menu_cshow')
        }, 3000)
				
				$('#extend-container-'+data.id).addClass('hide')
      }, 1000)
    }, 1000)
  })
}

function quickCart(data) {
  var href = baseUrl + 'cart?addcart=' + data.id + '&count=1&useajax=true'
  var postdata = {
    'count': 1,
    'size': data.size,
    'useajax': 'true'
  };
  $.post(href, postdata, function(response) {
    $('.cartadd_item ul#' + data.id).removeClass('hidden').appendTo('.con_row')
    var html = '<ul id="' + data.id + '" class="item row no-padding"><li class="col-sm-2 col-xs-3 p-r-0"><div class="pro_img"><span><img src="' + baseUrl + data.thumb + '"></span></div></li><li class="col-sm-5 col-xs-7"><h5><a href="#">' + data.title + '</a></h5><div class="size">' + data.size + '</div><div class="itemcount type-sm-bl">Rp. <span class="prc">' + addCommas(data.price) + '</span> x <span class="cnt">' + 1 + '</span></div></li><li class="col-sm-4 col-xs-10"><div class="price">Rp. <span class="subtotal">' + addCommas(parseInt(data.price) * parseInt(1)) + '</span></div></li><li class="col-sm-1 col-xs-2 p-l-0"> <a href="#" class="del_btn del"><i class="fa fa-trash-o"></i></a> </li></ul>'
    $('.shoppingcart .cart_row').prepend(html)
    $('.con_row').find('select.size').each(function() {
      $(this).prop('disabled', false)
    });
    setTimeout(function() {
      updatecart()
      updateBag()
      updateCheckout()
      $('#additem' + data.id).remove()
    }, 100)
  })
}



function delitemcart(elem) {
  elem.fadeOut()
  var id = elem.parent().parent().attr('id')
  $.get(baseURL + 'cart?del=' + id + '&useajax=true', function(response) {
    elem.parent().parent().slideUp(function() {
      elem.parent().parent().remove()
      updatecart()
    })
  })
}

function delitembag(elem) {
  var id = elem.parent().attr('id')
  $.get(baseURL + 'cart?del=' + id + '&useajax=true', function(response) {
    elem.parent().slideUp(function() {
      elem.parent().remove()
      updateBag()
      updateCheckout()
    })
  })
}

function updatecart() {
  var total = 0
  var count = 0
  var subtotal = 0
  setTimeout(function() {
    $('.cart_menu.shoppingcart').find('.cart_row').find('.item').each(function() {
      var cnt = 1
      var price = removeCommas($(this).find('.subtotal').text())
      total += cnt * price
      count += cnt
    });
    if (!$('.fa-shopping-basket').parent().find('.qcount').length) {
      $('.fa-shopping-basket').parent().append('<span class="qcount">' + count + '</span>')
    } else {
      $('.fa-shopping-basket').parent().find('.qcount').text(count)
    }
    if (parseInt(count) > 0) {
      $('.shoppingcart .noitem').parent().slideUp(function() {
        $(this).remove()
      })
    } else {
      setTimeout(function() {
				if(!$('.shoppingcart .cart_row').find('.noitem').length){
        	$('.shoppingcart .cart_row').append('<ul style="display: none;"><li class="noitem padding-15" style="text-align: center;">Cart empty!</li></ul>')
				}
        setTimeout(function() {
          $('.fa-shopping-basket').parent().find('.qcount').remove()
          $('.shoppingcart .noitem').parent().slideDown()
        }, 100)
      }, 200)
    }
    $('.total').find('.tot').text(addCommas(total))
  }, 200)
}

function updateCheckout() {
  setTimeout(function() {
    var carttotal = removeCommas($('.carttotal').text())
    var shippingcost = parseInt(removeCommas($('.shippingcost').text()))
    var result = addCommas(parseInt(carttotal) + shippingcost)
    if (isNaN(result)) {
      result = carttotal
    }
    $('.cktotal').text(addCommas(parseInt(carttotal) + shippingcost))
    setTimeout(function() {

    }, 300)
  }, 300)
}

function addCommas(nStr) {
  nStr += '';
  x = nStr.split(',');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + '.' + '$2');
  }
  return x1 + x2;
}

function removeCommas(nStr) {
  var val = nStr.toString().replace(/\./g, '')
  return val
}

var desttemp

function getIntCost(destination) {
  if ($('#country').val() == '' || desttemp == destination) {
    return false;
  }
  $('.shipmenttext').text('Calculating ' + destination + '...')
  $('.serviceselint').html('<div style="padding: 5px">Fetching...</div>')
  $('#propinsi').val('')
  $('.servicesel').html('<select name="service" class=""><option value="" selected="selected">Enter Shipment Destination</option></select>')
  $.get(baseUrl + 'intshipping?getcost=' + destination, function(data) {
    desttemp = destination
    $('.serviceselint').html(data)
    setTimeout(function() {
      var selected = $('.serviceselint select').find('option[selected="selected"]')
      var val = selected.val().split('||')
      var cost = parseFloat(val[0]) * Math.ceil(parseFloat($('.shippingweight').text()))
      var txt = selected.text()
      $('.shipmenttext').text('To ' + $('#country').val() + ' ' + txt)
      if (isNaN(cost)) {
        cost = 0
      }
      $('span.shippingcost').text(addCommas(cost))
      updateCheckout()
    }, 500)
  })
}

function getCost(destination) {
  if ($('#propinsi').val() == '' || desttemp == destination) {
    return false;
  }
  $('.shipmenttext').text('Calculating ' + destination + '...')
  $('.servicesel').html('<div style="padding: 5px">Fetching...</div>')
  $('#country').val('')
  $('.serviceselint').html('<select name="serviceint" class=""><option value="" selected="selected">Enter Destination Country</option></select>')
  $.get(baseUrl + 'shipping?getcost=' + destination, function(data) {
    desttemp = destination
    $('.servicesel').html(data)
    setTimeout(function() {
      var selected = $('.servicesel select').find('option[selected="selected"]')
      var val = selected.val().split('||')
      var cost = parseFloat(val[0]) * Math.ceil(parseFloat($('.shippingweight').text()))
      var txt = selected.text()
      $('.shipmenttext').text('To ' + $('#propinsi').val() + ' ' + txt)
      if (isNaN(cost)) {
        cost = 0
      }
      $('span.shippingcost').text(addCommas(cost))
      updateCheckout()
    }, 500)
  })
}

function submitCK(formID) {
  var checkf = checkForm(formID)

  if ($('[name="service"]').length) {
    if (!$('[name="service"]:checked').val()) {
      checkf = 'Select shipping method!'
    }
  }
	
	if($('[name="tnc"]').length){
		if(!$('[name="tnc"]:checked').val()){
			checkf = $('[name="tnc"]').attr('placeholder')
		}
	}

  if (!checkf) {
    if ($('input[name="payment_methode"]').val() == 'snap') {
      snap.show();
      $.post(baseUrl + 'checkout?ajax=1', $(formID).serialize(), function(result) {
        result = $.parseJSON(result)

        if (result.token) {
          snap.pay(result.token, {
            onSuccess: function(res) {
              $(location).attr('href', result.success)
            },
            onPending: function(res) {
              $(location).attr('href', result.pending)
            },
            onError: function(res) {
              $(location).attr('href', result.error)
            },
            onClose: function(res) {
              $(location).attr('href', result.unfinish)
            }
          })
        } else {
          snap.hide();
        }
        return false;
      })
    } else {
			if($('input[name="bukti_bayar"]').length){
				$('input[name="bukti_bayar"]').val($('#bukti_bayar_container').find('.fileupload-preview').find('img').attr('src'))
				$('input[name="ident"]').val($('#ident_container').find('.fileupload-preview').find('img').attr('src'))
				$('input#bukti_bayar').val('')
				$('input#ident').val('')
				$(formID).submit()
			}else{
      	$(formID).submit()
			}
		}
  } else {
    $('.notification').html('<div class="error">' + checkf + '</div>')
    $('.alert').removeClass('hide')
    $('body, html').animate({
      scrollTop: $('#content').offset().top
    })
    setTimeout(function() {
      $('.alert').addClass('hide')
    }, 8000)
  }
}

function calculateparalax(elem) {
  if (!elem.length) {
    return false;
  }

  var wh = $(window).height()
  var cur = wh + $(window).scrollTop() - elem.offset().top
  var maxs = wh + elem.height()
  var tot = (cur / maxs) * 100
  if (tot > 100) {
    //tot = 100
  }
  if (elem.hasClass('imgwrapper')) {
    return 100 - tot
  } else {
    return 100 - (tot)
  }
}

function paralax() {
  if ($('.background.paralax').length) {
    $('.background.paralax').css({
      'background-position': '50% ' + (calculateparalax($('.background.paralax'))) + '%'
    })
  }
}

function initVideo(vid, poster) {
  jwplayer('welcomevid').setup({
    //'flashplayer': "player.swf",
    playlist: [{
      file: vid
    }],
    'width': '100%',
    'height': '100%',
    'allowfullscreen': 'true',
    'controlbar': 'false',
    'allowscriptaccess': 'always',
    'wmode': 'opaque',
    'mute': 'false',
    'stretching': 'fill',
    'autostart': 'true',
    'screencolor': 'ffffff',
    'abouttext': 'LunaHabit.com',
    'aboutlink': '',
    'modes': [{
        type: "html5"
      },
      {
        type: "flash",
        src: "/templates/blank_j15/js/player.swf"
      },
      {
        type: "download"
      }
    ]
  });
  $('body').css({
    overflow: 'hidden'
  })
  jwplayer('welcomevid').onReady(function() {
    jwplayer('welcomevid').play()
  })
  $('.skipvid').click(function() {
    $('.wv').fadeOut(function() {
      jwplayer('welcomevid').remove()
    })
    $('body').css({
      overflow: 'auto'
    })
  })
  jwplayer('welcomevid').onComplete(function() {
    $('.wv').fadeOut(function() {
      jwplayer('welcomevid').remove()
    })
    $('body').css({
      overflow: 'auto'
    })
  })
}

function updateBag() {
  var total = 0
  var oldtotal = 0
  var alldisc = 0
  $('.con_row .old-price').each(function(index, element) {
    oldtotal += parseInt($(this).data('hemat')) * parseInt($(this).parent().parent().parent().find('.prodcount').val())
  });
  $('.con_row input.prodcount').each(function() {
    var suptot = parseInt($(this).val()) * parseInt($(this).data('prodprice'))
    $(this).parent().parent().parent().parent().find('span.subtot').html(addCommas(suptot))
    total += suptot
  });

  if($('span.alldisc').length) {
    alldisc = parseInt($('span.alldisc').data('value'))
    total = total - alldisc
    oldtotal = oldtotal + alldisc
    $('.con_row span.alldisc').html(addCommas(alldisc))
  }


  $('#cart').find('span.allold').html(addCommas(oldtotal))
  $('#cart').find('span.alltot').html(addCommas(total))
}

function stickyHeader() {
  if ($('#header').length && $(window).width() > 790) {
    var winH = $(window).scrollTop();
    var $pageHeader = $('#header');
    if (winH > 115) {
      $pageHeader.addClass('sticky');
      $('.headreplace').addClass('show')
    }
    if (winH == 0) {
      $pageHeader.removeClass('sticky');
      $('.headreplace').removeClass('show')
    }
  }
}

function mobileMenu() {
  $('nav#mobile-menu').mmenu({
    offCanvas: {
      position: 'right',
			pageSelector: "#my-wrapper"
    },
    extensions: ['effect-slide-menu', 'shadow-page', 'shadow-panels', 'theme-dark'],
    keyboardNavigation: true,
    screenReader: true,
    counters: true,
    navbar: {
      title: 'MENUS'
    },
    navbars: [{
      position: 'top',
      content: ['searchfield']
    }, {
      position: 'top',
      content: [
        'prev',
        'title',
        'close'
      ]
    }, {
      position: 'bottom',
      content: [

      ]
    }]
  }, {
    classNames: {
      fixedElements: {
        fixed: "popup-container"
      }
    }
  });
}


$(document).ready(function(e) {

  //header()
  //mobileMenu()

  if ($('.bxcarousel').length) {
    carouselBx()
  }

  paralax()
  //stickyHeader()
  viewPort()
	$('#bukti_bayar').change(function(){
		setTimeout(function(){
			$('input[name="bukti_bayar"]').val($('#bukti_bayar_container').find('.fileupload-preview').find('img').attr('src'))
		}, 1500)
	})
	$('#ident').change(function(){
		setTimeout(function(){
			$('input[name="ident"]').val($('#ident_container').find('.fileupload-preview').find('img').attr('src'))
		}, 1500)
	})
  $(".flex-control-nav").prepend('<a class="prev" href="/"><span class="fa fa-chevron-left"></span></a>');
  $(".flex-control-nav").append('<a class="next" href="/"><span class="fa fa-chevron-right"></span></a>');
  $(".flex-control-nav .prev").click(function() {
    $(".flex-prev").trigger('click');
  });
  $(".flex-control-nav .next").click(function() {
    $(".flex-next").trigger('click');
  });
  $(".flex-control-nav").wrap("<div class='container'></div>");
  $('#carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 117,
    itemMargin: 4,
    asNavFor: '#slider-product'
  });

  $('#slider-product').flexslider({
    animation: "fade",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: "#carousel",
    before: function() {
      $('.zoomContainer').remove()
    },
    after: function() {

    }
  });

  $('.category-slider').flexslider({
    animation: 'fade',
    slideshowSpeed: 7000,
    animationSpeed: 600,
    pauseOnHover: false,
    prevText: "",
    nextText: ""
  });

  $('.outofstock').click(function() {
    delitembag($(this))
  })

  $('a.color-option').click(function(e) {
    e.preventDefault()
    var th = $(this)
    var id = th.attr('id').replace('option-', '')
    var data = th.data('value')
    //console.log(data)
    th.addClass('current')
    $('a.color-option').not(th).removeClass('current')
    th.parent().find('.size').val(data)
    $('#carousel #item-' + id).click()
  })

  $("#nav .navbar-nav > li .dropdown-toggle").click(function() {
    $(this).parent().toggleClass("open-nav")
  });

  $('a.popup').click(function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    var name = $(this).attr('title');
    var w = window.open(href, "popupWindow", "width=600, height=400, scrollbars=yes");
  });

  $('#contact-form').on('submit', function(e) {
    e.preventDefault();
    $(this).find('.error').removeClass('error');
    $(this).find('.err_msg').fadeOut(200);
    var validation = validate_contact(e);
    for (var i = 0; i < validation.length; i++) {
      $(validation[i]).addClass('error');
    }
    if (validation.length) {
      $('body, html').animate({
        'scrollTop': $(validation[0]).offset().top - 100
      }, 'easeInCube', function() {
        $(this).select();
      });
      return false;
    } else {
      return true;
    }
  });
  $('input, textarea').blur(function() {
    $(this).css({
      background: ''
    })
  })
  $('select').change(function() {
    $(this).css({
      background: ''
    })
    $(this).parent().find('.select2-selection').css({
      background: ''
    })
  })
  $('input').iCheck({
    checkboxClass: 'icheckbox_minimal',
    radioClass: 'iradio_minimal',
    increaseArea: '20%' // optional
  });
  $('input#newsletter').on('ifUnchecked', function(event) {
    $(this).removeAttr('checked')
  });
  $('input#newsletter').on('ifChecked', function(event) {
    $(this).attr('checked', 'checked')
  });
	
	$('input#availableOnly').on('ifChanged', function(event) {
    $('#productFilter').submit();
  });
	
  $('input[name="payment_methode"]').on('ifChecked', function(event) {
    if ($(this).attr('value') != 'bt') {
      $('.ckinfo p').not($('.info_cc')).hide()
      $('.ckinfo .info_cc').show()
      $('.sendck').text('GO TO PAYMENT PAGE')
    } else {
      $('.ckinfo p').not($('.info_bt')).hide()
      $('.ckinfo .info_bt').show()
      $('.sendck').text('FINISH CHECKOUT')
    }
    $(this).parent().parent().addClass('checked')
    $('input[name="payment_methode"]').not($(this)).parent().parent().removeClass('checked')
  });
  $('.dropopt').change(function(e) {
    var th = $(this)
    var data = th.val()
    //console.log(data)
    $('a.color-option').removeClass('current')
    th.parent().find('input.size').val(data)
  })
  $('.overlimit').click(function() {
    var id = $(this).data('id');
    var maxi = $(this).data('max');
    $('input[name="prodcount[' + id + ']"]').val(maxi)
    $(this).fadeOut(function() {
      updateBag()
    })
  })
  $('.delbag').click(function(e) {
    e.preventDefault()
    delitembag($(this).parent().parent())
  })
  $('.next_btn').click(function(e) {
    if (!$(this).hasClass('cartempty')) {
      e.preventDefault()
      $('#cart').submit()
    } else {
      return true
    }
  })
  jQuery(".minus_btn").click(function() {
    var inputEl = jQuery(this).parent().children().next();
    var qty = inputEl.val();
    if (jQuery(this).parent().hasClass("minus_btn"))
      qty++;
    else
      qty--;
    if (qty < 1)
      qty = 1;
    inputEl.val(qty);
    setTimeout(function() {
      updateBag()
      setTimeout(function() {}, 300)
    }, 100)
  })
  $('button.val_disc_code').click(function(e) {
    e.preventDefault()
    var code = $('#discount_code').val()
    var url = baseUrl + 'validate-promo?ajax=1&discount_code=' + code
    $.get(url, function(data) {
      $('.dis_cd_respons').html(data)
      setTimeout(function() {
        var disc = $('.dis_cd_respons').find('.value').data()
        var baseValue = $('.carttotal').data('carttotal')
        if (disc) {
          var alldisc = 'Discount -Rp. <span class="alldisc" data-value="' + disc.value + '">' + addCommas(disc.value) + '</span>'
          $('.dicount').html(alldisc)
          setTimeout(function() {
            updateBag()
          }, 300)
        } else {
          $('.ckinfo').find('.disc-info').remove()
          $('.dicount').empty()
          setTimeout(function() {
            updateBag()
          }, 300)
        }
      }, 300)
    })
  })
  jQuery(".plus_btn").click(function() {
    var inputEl = jQuery(this).parent().children().next();
    var lmax = inputEl.data('max')
    var qty = inputEl.val();
    if (jQuery(this).hasClass("plus_btn"))
      qty++;
    else
      qty--;
    if (qty < 0) {
      qty = 0;
    }
    if (qty > lmax) {
      qty = lmax;
    }
    inputEl.val(qty);
    setTimeout(function() {
      updateBag()
      setTimeout(function() {}, 300)
    }, 100)
  })
  $('input.num').keydown(function(e) {
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
      (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
      (e.keyCode >= 35 && e.keyCode <= 40)) {
      return;
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
    }
  });
  $(".sidebar h5").click(function(e) {
    e.preventDefault();
    $(this).parent().find(".tgl_c").slideToggle(300);
    if ($(this).hasClass("active")) {
      $(this).removeClass('active');
    } else {
      $(this).addClass('active');
    }
  });
  if ($('#system-message').length) {
    $('#system-message').parent().append('<div class="close fa fa fa-close" style="color:#fff;"></div>')
  }
  $('body').on('click', '.message .close', function(e) {
    e.preventDefault()
    $('#system-message').parent().fadeOut()
  })
  $('.show_cp').click(function(e) {
    e.preventDefault()
    var th = $(this)
    if ($('form.user').css('display') == 'none') {
      $('form.user').slideDown()
      $('.pas_sample').slideUp()
      th.slideUp()
    }
  })
  $('.edit_acc').click(function(e) {
    e.preventDefault()
    var th = $(this)
    if ($('form.acc').css('display') == 'none') {
      $('form.acc').slideDown()
      $('.dsk').slideUp()
      th.slideUp()
    }
  })
  $('body').on('click', 'form.user .cancel', function(e) {
    e.preventDefault()
    var th = $(this)
    if ($('form.user').css('display') == 'block') {
      $('form.user').slideUp()
      $('.pas_sample').slideDown()
      $('.show_cp').slideDown()
    }
  })
  $('body').on('click', 'form.acc .cancel', function(e) {
    e.preventDefault()
    var th = $(this)
    if ($('form.acc').css('display') == 'block') {
      $('form.acc').slideUp()
      $('.dsk').slideDown()
      $('.edit_acc').slideDown()
    }
  })
  $('body').on('click', '.addcart', function(e) {
    addCart($(this))
    e.preventDefault()
  })
  $('body').on('click', '.cart_row ul li .del', function(e) {
    delitemcart($(this))
    e.preventDefault()
  })
  $('body').on('click', '.sendck', function(e) {
    submitCK('form#ckform')
    e.preventDefault()
  })

  $('form#userform').submit(function(e) {
    var th = $(this);
    var checkf = checkForm('#userform');
    if (checkf) {
      e.preventDefault()
      th.find('.notification').html('<div class="error">' + checkf + '</div>')
      th.find('.alert').removeClass('hide')
      $('body, html').animate({
        scrollTop: th.offset().top - 300
      })
      setTimeout(function() {
        th.find('.alert').addClass('hide')
      }, 8000)
    }
  })

  $('form#user_pass').submit(function(e) {
    var th = $(this);
    var checkf = checkForm('#user_pass');
    if ($('#password').val() !== $('#password2').val()) {
      checkf = 'Password not match!'
    }
    if (checkf) {
      e.preventDefault()
      th.find('.notification').html('<div class="error">' + checkf + '</div>')
      th.find('.alert').removeClass('hide')
      $('body, html').animate({
        scrollTop: th.offset().top - 300
      })
      setTimeout(function() {
        th.find('.alert').addClass('hide')
      }, 8000)
    }
  })

  var countries
  if ($('#country').length) {
    $.getJSON(baseUrl + 'cart', {
      getCountry: 1
    }, function(result) {
      $('#country').select2({
        data: result,
        theme: "bootstrap"
      });
    })
  }

	

  $('#country').on('change', function(e) {
    var th = $(this)
    $('#country_name').val(th.find('option:selected').text())
    if (th.val() == '103' || th.val() == '999') {
      $('#province').prop("disabled", false);
    } else {
      $('#province').prop("disabled", true);
      $('#district').prop("disabled", true);
    }
  })

  $('#province').select2({
    ajax: {
      url: baseUrl + 'cart',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        if (!params.term) {
          params.term = ' '
        }
        return {
          getProvince: params.term
        };
      },
      processResults: function(data, params) {
        return {
          results: data
        };
      },
      cache: true
    },
    minimumInputLength: 0,
    theme: "bootstrap"
  });

  $('#province').on('change', function(e) {
    $('#district').html('<option value="">Select District/Kecamatan</option>')
    var th = $(this).val()
    if (th != '') {
      $.getJSON(baseUrl + 'cart', {
        getDistrict: th
      }, function(result) {
        $('#district').select2({
          placeholder: 'Select district/Kecamatan',
          data: result,
          theme: "bootstrap",
          minimumResultsForSearch: Infinity
        })
      })

      $('#district').prop("disabled", false);
    } else {
      $('#district').prop("disabled", true);
    }
  })

  $('#district').select2({
    theme: "bootstrap"
  })

  if (!$('#district').val()) {
    $('#district').prop("disabled", true);
  }

  $('#district').on('change', function(e) {
    var th = $(this)
    $('#district_name').val(th.find('option:selected').text())
  })
	
	$('#asuser').select2({
    ajax: {
      url: baseUrl + 'cart',
      dataType: 'json',
      delay: 250,
      data: function(params) {
        if (!params.term) {
          params.term = ' '
        }
        return {
          getUsers: params.term
        };
      },
      processResults: function(data, params) {
        return {
          results: data
        };
      },
      cache: true
    },
		placeholder: "Use another user",
    minimumInputLength: 0,
    theme: "bootstrap"
  });
	
	$('#asuser').change(function(){
		var val = $(this).val()
		$.getJSON(baseUrl + 'cart', {
			getUser : val
		}, function(result) {
			console.log(result)
			$('#username').text(result.name)
			$('#phone').text(result.phone)
			$('#email').text(result.email)
			$('#address1').val(result.address.address.address)
			$('#reciever_name').val(result.name)
			$('#reciever_phone').val(result.phone)
			$('#postal').val(result.address.address.postal)
			if(result.address.address.province){
				$('#province').html('<option value="'+result.address.address.province+'" selected="selected">'+result.address.address.province+'</option>')
				$('#province').val(result.address.address.province)
			}else{
				$('#province').html('<option value="" selected="selected">Select Province</option>')
				$('#province').val(result.address.address.province)
			}
			if(!result.address.address.district){
				$('#province').trigger('change')
			}else{
				$('#district').html('<option value="'+result.address.address.district+'" selected="selected">'+result.address.address.district_name+'</option>')
				$('#district').val(result.address.address.district)
			}
			$('#district').trigger('change')
		})
	})

  $('option').each(function() {
    if (this.defaultSelected) {
      this.selected = true;
      return false;
    }
  });
	

  $('.edit_cart_item').click(function(e) {
    e.preventDefault()
    var th = $(this)
    th.parent().find('.sizewrap').show()
    th.parent().find('.save').show()
    th.parent().find('.opt-desc').hide()
    th.hide()
  })

  $('.buywrap').find('.cancel').click(function(e) {
    e.preventDefault()
    var th = $(this)
    th.parent().find('.sizewrap').hide()
    th.addClass('hidden')
  })
  $('.main_box select.size').change(function(e) {
    var th = $(this).parent().parent().find('.addcart')
    addCart(th)
  })
  $('.servicesel').on('change', 'select', function() {
    var selected = $('.servicesel select').find('option:selected')
    var val = selected.val().split('||')
    var txt = selected.text()
    var cost = parseFloat(val[0]) * Math.ceil(parseFloat($('.shippingweight').text()))
    if (isNaN(cost)) {
      return false;
    }
    if (val[1] == 'COD') {
      $('.row.payment_methode').slideUp()
      $('.row.payment_cod').slideDown()
    } else {
      $('.row.payment_methode').slideDown()
      $('.row.payment_cod').slideUp()
    }
    $('span.shippingcost').text(addCommas(cost))
    $('.shipmenttext').text('To ' + $('#propinsi').val() + ' ' + txt)
    updateCheckout()
  })
  $('.ck_login_togle').click(function() {
    $('.show_login').trigger('click')
  })
  $(window).scroll(function() {
    paralax()
    //stickyHeader()
  });
  $('.fb-login').click(function(e) {
    e.preventDefault()
    fbLogin()
  })
  $('#pop_newsletter').submit(function(e) {
    e.preventDefault()
    var th = $(this)
    var value = th.serialize()
    if (th.find('#nw_email').val()) {
      if (!isValidEmailAddress(th.find('#nw_email').val())) {
        th.find('.info').addClass('alert-danger').text('Invalid emial address.').removeClass('hide')
        return false;
      }
    } else {
      th.find('.info').addClass('alert-danger').html('Enter your email.').removeClass('hide')
      return false;
    }
    th.find('button[type="submit"]').text('WAIT')
    $.post(th.attr('action'), value, function(data) {
      var respond = '<div>' + data + '</div>'
      respond = $(respond).find('#respond').html()
      if (respond == 'OK') {
        th.find('.info').removeClass('alert-danger').addClass('alert-success').html('Thank You for subscribing.').removeClass('hide')
      } else {
        th.find('.info').addClass('alert-danger').html(respond).removeClass('hide')
      }
      th.find('button[type="submit"]').text('SUBMIT')

    })
  })
  $('.g-signin').click(function(e) {
    e.preventDefault()
    auth2.grantOfflineAccess().then(signInCallback);
  })
  $('#vtsnap').click(function(e) {
    e.preventDefault()
    snap.show();
    $.get($(this).attr('href'), {}, function(result) {
      result = $.parseJSON(result)
      if (result.token) {
        snap.pay(result.token, {
          onSuccess: function(res) {
            console.log(res)
            //$(location).attr('href', result.success)
          },
          onPending: function(res) {
            console.log(res)
            //$(location).attr('href', result.pending)
          },
          onError: function(res) {
            console.log(res)
            //$(location).attr('href', result.error)
          },
          onClose: function(res) {
            console.log(res)
            //$(location).attr('href', result.unfinish)
          }
        })
      } else {
        snap.hide();
      }
    })
  })
  $('input.cartadd').prop('checked', false).parent().removeClass('checked')
  $('input.cartadd').on('ifChecked', function(event) {
    var data = $(this).data();
    quickCart(data)
  });
  $('select.size').change(function() {
    background: ''
  })
  $('form#cart').submit(function(e) {
    var err = false
    $('select.size').each(function() {
      var th = $(this)
      if ((!th.val()) && th.prop('disabled') != true) {
        err = true
        th.css({
          background: '#f2dede'
        })
        th.parent().parent().parent().find('.edit_cart_item').click()
      }
    });
    if (err) {
      $('body, html').animate({
        scrollTop: $('#content').offset().top
      })
      e.preventDefault()
    }
  })
  $('.ck-cart-togle-btn').click(function(e) {
    if ($('.ck-cart-body').css('display') == 'none') {
      $('.ck-cart-body').show()
    } else {
      $('.ck-cart-body').hide()
    }
    e.preventDefault()
  })
  jQuery('[name="option"]').on('ifChanged', function() {
    setTimeout(function() {
      validateDate()
    }, 100)
  })

  jQuery('#start-date').change(function() {
    setTimeout(function() {
      validateDate()
    }, 100)
  })

  jQuery('#start-date').val('')

  jQuery('#start-date').datetimepicker({
    timepicker: false,
    scrollMonth: false,
    inline: true,
    startDate: '+1970/01/02',
    minDate: 0,
    defaultSelect: false,
    format: 'Y-m-d',
    disabledWeekDays: offDays,
    disabledDates: block_dates,
    formatDate: 'Y-m-d',
    onChangeMonth: function(ct, input) {
      var result = new Date(ct);
      result.setMonth(result.getMonth() + 1);
    },
    onChangeDateTime: function(ct, input) {
      
    },
    onGenerate: function(ct) {
			
		}
  });
	$('.show-extend').click(function(e){
		e.preventDefault()
		$('#extend-container-'+ $(this).data('id')).removeClass('hide')
	})
	$('.hide-extend').click(function(e){
		e.preventDefault()
		$('#extend-container-'+ $(this).data('id')).addClass('hide')
	})
});

$(window).resize(function() {
  //stickyHeader()
 // header();
  paralax()
  viewPort()
  if ($('.bxcarousel').length) {
    if (!bxbusy) {
      bxbusy = 1
      setTimeout(function() {
        carouselBx();
        bxbusy = false
      }, 2000)
    }
  }
});

$(window).load(function() {
  loadgplus()
	mobileMenu()
  var count = 0
  paralax()
  if ($('.bxcarousel').length) {
    carouselBx()
  }
  $('.shoppingcart .cart_row .item').each(function() {
    count += parseInt($(this).find('.cnt').text())
  });
  if (count) {
    if (!$('.fa-shopping-cart').parent().find('.qcount').length) {
      $('.fa-shopping-cart').parent().append('<span class="qcount">' + count + '</span>')
    } else {
      $('.fa-shopping-cart').parent().find('.qcount').text(count)
    }
  } else {
    $('.fa-shopping-cart').parent().find('.qcount').remove()
  }
  $('.bx-wrapper .bx-loading').css({
    'visibility': 'hidden'
  })
	if($('#start-date').length){
	}
})

//FACEBOOK
window.fbAsyncInit = function() {
  FB.init({
    appId: '312985772505702',
    cookie: true,
    xfbml: true,
    version: 'v2.8'
  });
  FB.AppEvents.logPageView();
};

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {
    return;
  }
  js = d.createElement(s);
  js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function submitpost(location, args) {
  var form = $('<form></form>');
  form.attr("method", "post");
  form.attr("action", location);

  $.each(args, function(key, value) {
    var field = $('<input></input>');

    field.attr("type", "hidden");
    field.attr("name", key);
    field.attr("value", value);

    form.append(field);
  });

  $(form).appendTo('body').submit();
}

function checkLoginState() {
  FB.getLoginStatus(function(response) {
    if (response.status === 'connected') {
      var data = {
        fbtoken: response.authResponse.accessToken,
        'return': $('input[name="return"]').val(),
        task: 'fblogin'
      }
      submitpost(baseUrl + 'user', data)
    } else {

    }
  });
}

function fbLogin() {
  FB.login(function() {
    checkLoginState()
  }, {
    scope: 'email'
  });
}

//google
function loadgplus() {
  gapi.load('auth2', function() {
    auth2 = gapi.auth2.init({
      client_id: '675085133160-hdjkv2a43cibb1npev6juapla3ah3h1q.apps.googleusercontent.com',
      cookiepolicy: 'single_host_origin',
      scope: 'profile'
    });
  });
}

function signInCallback(resp) {
  if (!resp.code) {
    return false;
  }
  var data = {
    gtoken: gapi.client.getToken().access_token,
    'return': $('input[name="return"]').val(),
    task: 'glogin'
  }
  submitpost(baseUrl + 'user', data)
}