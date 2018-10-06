<?php
/* Copyright (C) 2012 SEBLOD. All Rights Reserved. */

// No Direct Access
defined( '_JEXEC' ) or die( 'Restricted access' );

//echo'<pre>';print_r($model->transaction);
$base = JURI::base();
$model = $this->getModel();
$month = JRequest::getInt('month', date('m'));
$year = JRequest::getInt('year', date('Y'));
$date = JRequest::getVar('date');



//echo'<pre>';print_r($bookings);echo'</pre>';
?>
<?php if($date){
	$bookings = $model->getBookingCalendarView($date);
?>

<div id="ajaxcontent">
  <div class="row">
    <div class="col-md-12">
      <h2 class="event-title" style="margin-bottom: 30px;"><?php echo JHtml::_('date', $date); ?></h2>
    </div>
    <div class="col-md-12">
      <?php foreach($bookings as $booking){ 
				$action_link = JURI::current().'?task=update_booking&id='.$booking->id.'&status=';
			
			?>
      <div class="panel panel-white">
        <div class="panel-heading <?php if($date == $booking->deliver){ ?>partition-pink<?php }else{ ?>partition-orange<?php } ?>">
          <?php if($date == $booking->deliver){ ?>
          <h4 class="panel-title"><span class="text-bold">Delivery</span></h4>
          <?php }else{ ?>
          <h4 class="panel-title"><span class="text-bold">Pickup</span></h4>
          <?php } ?>
          <div class="panel-tools" style="opacity: 1;">
            <div class="btn-group btn-group-xs">
              <button type="button" class="btn btn-blue"> Status <?php echo $booking->book_status; ?> </button>
              <button type="button" class="btn btn-blue dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span> </button>
              <ul class="dropdown-menu booking_stat" role="menu">
                <li role="presentation" class="dropdown-header"> Change Status </li>
                <li> <a href="<?php echo $action_link; ?>pending"> Pending </a> </li>
                <li> <a href="<?php echo $action_link; ?>processing"> Processing </a> </li>
                <li> <a href="<?php echo $action_link; ?>booked"> Booked </a> </li>
                <li> <a href="<?php echo $action_link; ?>done"> Done </a> </li>
                <li> <a href="<?php echo $action_link; ?>expired"> Expired </a> </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-7">
              <h4><?php echo $booking->product; ?></h4>
              <p>
                <?php 
								$shipment = json_decode($booking->shipment); 
								$address = $shipment->address;
								?>
                <strong><?php echo $address->name; ?></strong> - <?php echo $address->phone; ?><br />
                <?php echo $address->address.' '.$address->address_opt; ?><br />
                <?php echo $address->district_name; ?>, <?php echo $address->province; ?><br />
                <?php echo $address->postal; ?> </p>
            </div>
            <div class="col-sm-5 text-right"> Transaction ID <br />
              <a class="text-large" title="View order detail" href="<?php echo $base; ?>administration/store/invoices?invoice=<?php echo $booking->order_id; ?>">#<?php echo $booking->order_id; ?></a><br /><br />
            	Deliver - <?php echo JHtml::_('date', $booking->deliver); ?><br />Pickup - <?php echo  JHtml::_('date', $booking->pickup); ?>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
    <div class="col-md-12">
      <div class="event-content"></div>
    </div>
  </div>
</div>
<?php }else{ 

$bookings = $model->getBookingCalendar($month, $year);

?>
<div class="row">
  <div class="col-sm-12"> 
    <!-- start: FULL CALENDAR PANEL -->
    <div class="panel panel-white">
      <div class="panel-heading"> <i class="fa fa-calendar"></i> Full Calendar
        <div class="panel-tools">
          <div class="dropdown"> <a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey"> <i class="fa fa-cog"></i> </a>
            <ul class="dropdown-menu dropdown-light pull-right" role="menu">
              <li> <a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a> </li>
              <li> <a class="panel-refresh" href="#"> <i class="fa fa-refresh"></i> <span>Refresh</span> </a> </li>
              <li> <a class="panel-config" href="#panel-config" data-toggle="modal"> <i class="fa fa-wrench"></i> <span>Configurations</span> </a> </li>
              <li> <a class="panel-expand" href="#"> <i class="fa fa-expand"></i> <span>Fullscreen</span> </a> </li>
            </ul>
          </div>
          <a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a> </div>
      </div>
      <div class="panel-body">
        <div class="col-sm-12">
          <div id='full-calendar'></div>
        </div>
      </div>
    </div>
    <!-- end: FULL CALENDAR PANEL --> 
  </div>
</div>
<div class="subviews">
  <div class="subviews-container"></div>
</div>
<div id="readFullEvent">
  <div class="noteWrap col-md-8 col-md-offset-2"> </div>
</div>
<script src="<?php echo $base; ?>templates/admin/plugins/moment/min/moment.min.js"></script> 
<script src="<?php echo $base; ?>templates/admin/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script> 
<script src="<?php echo $base; ?>templates/admin/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script> 
<script>
var Calendar = function () {
	"use strict";
	var dateToShow, calendar, demoCalendar, eventClass, eventCategory, subViewElement, subViewContent, $eventDetail;
	var defaultRange = new Object;
	defaultRange.start = moment();
	defaultRange.end = moment().add('days', 1);
	//Calendar
	var setFullCalendarEvents = function() {
		var date = new Date();
		dateToShow = date;
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		demoCalendar = <?php echo json_encode($bookings); ?>
	};
    //function to initiate Full Calendar
    var runFullCalendar = function () {
    	$(".add-event").off().on("click", function() {
    					subViewElement = $(this);
			subViewContent = subViewElement.attr('href');
    	$.subview({
					content : subViewContent,
					onShow : function() {
						editFullEvent();
					},
					onHide : function() {
						hideEditEvent();
					}
				});
    	});
    	
        $('#event-categories div.event-category').each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 50 //  original position after the drag
            });
        });
        /* initialize the calendar
		-----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';
        $('#full-calendar').fullCalendar({
            buttonText: {
                prev: '<i class="fa fa-chevron-left"></i>',
                next: '<i class="fa fa-chevron-right"></i>'
            },
            header: {
                right: 'prev,next',
                left: 'title'
            },
            events: demoCalendar,
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped
                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');
                
                var $categoryClass = $(this).attr('data-class');
                var $category = $categoryClass.replace("event-", "").toLowerCase().replace(/\b[a-z]/g, function(letter) {
				    return letter.toUpperCase();
				});
                // we need to copy it, so that multiple events don't have a reference to the same object

                
                
                newEvent = new Object;
				newEvent.title = originalEventObject.title, newEvent.start = new Date(date), newEvent.end =  moment(new Date(date)).add('hours', 1), newEvent.allDay = true, newEvent.className = $categoryClass, newEvent.category = $category, newEvent.content = "";

                
                demoCalendar.push(newEvent);
                $('#full-calendar').fullCalendar( 'refetchEvents' );
               
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            selectable: false,
            selectHelper: false,
            select: function (start, end, allDay) {
            	defaultRange.start = moment(start);
				defaultRange.end = moment(start).add('hours', 1);
				$.subview({
					content : "#newFullEvent",
					onShow : function() {
						editFullEvent();
					},
					onHide : function() {
						hideEditEvent();
					}
				});
            },
            eventClick: function (calEvent, jsEvent, view) {
            	dateToShow = calEvent.start;
				var showdate
				if(calEvent.deliver){
					showdate = calEvent.deliver
				}else{
					showdate = calEvent.pickup
				}
				$.subview({
					content : "#readFullEvent",
					startFrom : "right",
					onShow : function() {
						readFullEvents(showdate);
					}
				});
                
            }
        });
    };
	var editFullEvent = function(el) {
		$(".close-new-event").off().on("click", function() {
			$(".back-subviews").trigger("click");
		});
		$(".form-full-event .help-block").remove();
		$(".form-full-event .form-group").removeClass("has-error").removeClass("has-success");
		$eventDetail = $('.form-full-event .summernote');
		
		$eventDetail.summernote({
			oninit: function() {
				if ($eventDetail.code() == "" || $eventDetail.code().replace(/(<([^>]+)>)/ig, "") == "") {
					$eventDetail.code($eventDetail.attr("placeholder"));
				}
			},
			onfocus: function(e) {
				if ($eventDetail.code() == $eventDetail.attr("placeholder")) {
					$eventDetail.code("");
				}
			},
			onblur: function(e) {
				if ($eventDetail.code() == "" || $eventDetail.code().replace(/(<([^>]+)>)/ig, "") == "") {
					$eventDetail.code($eventDetail.attr("placeholder"));
				}
			},
			onkeyup: function(e) {
				$("span[for='detailEditor']").remove();
			},
			toolbar: [
			['style', ['bold', 'italic', 'underline', 'clear']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			]
		});
		if ( typeof el == "undefined") {
			$(".form-full-event .event-id").val("");
			$(".form-full-event .event-name").val("");
			$(".form-full-event .all-day").bootstrapSwitch('state', false);
			$('.form-full-event .all-day-range').hide();
			$(".form-full-event .event-start-date").val(defaultRange.start);
			$(".form-full-event .event-end-date").val(defaultRange.end);
			
			$('.form-full-event .no-all-day-range .event-range-date').val(moment(defaultRange.start).format('MM/DD/YYYY h:mm A') + ' - ' + moment(defaultRange.end).format('MM/DD/YYYY h:mm A'))
			.daterangepicker({  
				startDate: defaultRange.start,
				endDate: defaultRange.end,
				timePicker: true, 
				timePickerIncrement: 30, 
				format: 'MM/DD/YYYY h:mm A' 
			});
			
			$('.form-full-event .all-day-range .event-range-date').val(moment(defaultRange.start).format('MM/DD/YYYY') + ' - ' + moment(defaultRange.end).format('MM/DD/YYYY'))
			.daterangepicker({  
				startDate: defaultRange.start,
				endDate: defaultRange.end
			});
			
			$('.form-full-event .event-categories option').filter(function() {
				return ($(this).text() == "Generic");
			}).prop('selected', true);
			$('.form-full-event .event-categories').selectpicker('render');
			$eventDetail.code($eventDetail.attr("placeholder"));
			
			defaultRange.start = moment();
			defaultRange.end = moment().add('days', 1);

		} else {
			
			$(".form-full-event .event-id").val(el);

			for (var i = 0; i < demoCalendar.length; i++) {

				if (demoCalendar[i]._id == el) {
					$(".form-full-event .event-name").val(demoCalendar[i].title);
					$(".form-full-event .all-day").bootstrapSwitch('state', demoCalendar[i].allDay);
					$(".form-full-event .event-start-date").val(moment(demoCalendar[i].start));
					$(".form-full-event .event-end-date").val(moment(demoCalendar[i].end));
							if(typeof $('.form-full-event .no-all-day-range .event-range-date').data('daterangepicker') == "undefined"){
				$('.form-full-event .no-all-day-range .event-range-date').val(moment(demoCalendar[i].start).format('MM/DD/YYYY h:mm A') + ' - ' + moment(demoCalendar[i].end).format('MM/DD/YYYY h:mm A'))
					.daterangepicker({  
						startDate:moment(moment(demoCalendar[i].start)),
						endDate: moment(moment(demoCalendar[i].end)),
						timePicker: true, 
						timePickerIncrement: 10, 
						format: 'MM/DD/YYYY h:mm A' 
					});			
					
					$('.form-full-event .all-day-range .event-range-date').val(moment(demoCalendar[i].start).format('MM/DD/YYYY') + ' - ' + moment(demoCalendar[i].end).format('MM/DD/YYYY'))
					.daterangepicker({  
						startDate:moment(demoCalendar[i].start),
						endDate: moment(demoCalendar[i].end)
					});
			} else {
				$('.form-full-event .no-all-day-range .event-range-date').val(moment(demoCalendar[i].start).format('MM/DD/YYYY h:mm A') + ' - ' + moment(demoCalendar[i].end).format('MM/DD/YYYY h:mm A'))
				.data('daterangepicker').setStartDate(moment(moment(demoCalendar[i].start)));
				$('.form-full-event .no-all-day-range .event-range-date').data('daterangepicker').setEndDate(moment(moment(demoCalendar[i].end)));
				$('.form-full-event .all-day-range .event-range-date').val(moment(demoCalendar[i].start).format('MM/DD/YYYY') + ' - ' + moment(demoCalendar[i].end).format('MM/DD/YYYY'))
				.data('daterangepicker').setStartDate(demoCalendar[i].start);
				$('.form-full-event .all-day-range .event-range-date').data('daterangepicker').setEndDate(demoCalendar[i].end);
			}
					
					if (demoCalendar[i].category == "" || typeof demoCalendar[i].category == "undefined") {
						eventCategory = "Generic";
					} else {
						eventCategory = demoCalendar[i].category;
					}
					$('.form-full-event .event-categories option').filter(function() {
						return ($(this).text() == eventCategory);
					}).prop('selected', true);
					$('.form-full-event .event-categories').selectpicker('render');
					if ( typeof demoCalendar[i].content !== "undefined" && demoCalendar[i].content !== "") {
						$eventDetail.code(demoCalendar[i].content);
					} else {
						$eventDetail.code($eventDetail.attr("placeholder"));
					}
				}

			}
		}
		$('.form-full-event .all-day').bootstrapSwitch();
	
		$('.form-full-event .all-day').on('switchChange.bootstrapSwitch', function(event, state) {
			$(".daterangepicker").hide();
			var startDate = moment($("#newFullEvent").find(".event-start-date").val());
			var endDate = moment($("#newFullEvent").find(".event-end-date").val());
			if (state) {
				$("#newFullEvent").find(".no-all-day-range").hide();
				$("#newFullEvent").find(".all-day-range").show();
				$("#newFullEvent").find('.all-day-range .event-range-date').val(startDate.format('MM/DD/YYYY') + ' - ' + endDate.format('MM/DD/YYYY')).data('daterangepicker').setStartDate(startDate);
				$("#newFullEvent").find('.all-day-range .event-range-date').data('daterangepicker').setEndDate(endDate);
			} else {
				$("#newFullEvent").find(".no-all-day-range").show();
				$("#newFullEvent").find(".all-day-range").hide();
				$("#newFullEvent").find('.no-all-day-range .event-range-date').val(startDate.format('MM/DD/YYYY h:mm A') + ' - ' + endDate.format('MM/DD/YYYY h:mm A')).data('daterangepicker').setStartDate(startDate);
				$("#newFullEvent").find('.no-all-day-range .event-range-date').data('daterangepicker').setEndDate(endDate);			
			}
	
		});
		$('.form-full-event .event-range-date').on('apply.daterangepicker', function(ev, picker) {
			$(".form-full-event .event-start-date").val(picker.startDate);
			$(".form-full-event .event-end-date").val(picker.endDate);
		});
	};    
    var readFullEvents = function(date) {
		
		$("#readFullEvent .noteWrap").html('<h3 style="margin-top: 100px; text-align: center;">Loading..</h3>').load('<?php echo JURI::current(); ?>?tmpl=component&date='+date+' #ajaxcontent', function(e){
		})
		
		

	};
	
	var runFullCalendarValidation = function(el) {
		
		var formEvent = $('.form-full-event');
		var errorHandler2 = $('.errorHandler', formEvent);
		var successHandler2 = $('.successHandler', formEvent);

		formEvent.validate({
			errorElement : "span", // contain the error msg in a span tag
			errorClass : 'help-block',
			errorPlacement : function(error, element) {// render error placement for each input type
				if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {// for chosen elements, need to insert the error after the chosen container
					error.insertAfter($(element).closest('.form-group').children('div').children().last());
				} else if (element.parent().hasClass("input-icon")) {

					error.insertAfter($(element).parent());
				} else {
					error.insertAfter(element);
					// for other inputs, just perform default behavior
				}
			},
			ignore : "",
			rules : {
				eventName : {
					minlength : 2,
					required : true
				},
				eventStartDate : {
					required : true,
					date : true
				},
				eventEndDate : {
					required : true,
					date : true
				}
			},
			messages : {
				eventName : "* Please specify your first name"

			},
			invalidHandler : function(event, validator) {//display error alert on form submit
				successHandler2.hide();
				errorHandler2.show();
			},
			highlight : function(element) {
				$(element).closest('.help-block').removeClass('valid');
				// display OK icon
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
				// add the Bootstrap error class to the control group
			},
			unhighlight : function(element) {// revert the change done by hightlight
				$(element).closest('.form-group').removeClass('has-error');
				// set error class to the control group
			},
			success : function(label, element) {
				label.addClass('help-block valid');
				// mark the current input as valid and display OK icon
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
			},
			submitHandler : function(form) {
				successHandler2.show();
				errorHandler2.hide();
				var newEvent = new Object;
				newEvent.title = $(".form-full-event .event-name ").val(), newEvent.start = new Date($('.form-full-event .event-start-date').val()), newEvent.end = new Date($('.form-full-event .event-end-date').val()), newEvent.allDay = $(".form-full-event .all-day").bootstrapSwitch('state'), newEvent.className = $(".form-full-event .event-categories option:checked").val(), newEvent.category = $(".form-full-event .event-categories option:checked").text(), newEvent.content = $eventDetail.code();

				$.blockUI({
					message : '<i class="fa fa-spinner fa-spin"></i> Do some ajax to sync with backend...'
				});
				
				if ($(".form-full-event .event-id").val() !== "") {
				el = $(".form-full-event .event-id").val();

					for ( var i = 0; i < demoCalendar.length; i++) {

						if (demoCalendar[i]._id == el) {
							newEvent._id = el;
							var eventIndex = i;
						}

					}
					//mockjax simulates an ajax call
					$.mockjax({
					url : '/event/edit/webservice',
					dataType : 'json',
					responseTime : 1000,
					responseText : {
						say : 'ok'
					}
				});

				$.ajax({
					url : '/event/edit/webservice',
					dataType : 'json',
					success : function(json) {
						$.unblockUI();
						if (json.say == "ok") {
							demoCalendar[eventIndex] = newEvent;
							$('#full-calendar').fullCalendar( 'refetchEvents' );
							$.hideSubview();
							toastr.success('The event has been successfully modified!');
						}
					}
				});

				} else {
				//mockjax simulates an ajax call
				$.mockjax({
					url : '/event/new/webservice',
					dataType : 'json',
					responseTime : 1000,
					responseText : {
						say : 'ok'
					}
				});

				$.ajax({
					url : '/event/new/webservice',
					dataType : 'json',
					success : function(json) {
						$.unblockUI();
						if (json.say == "ok") {
							demoCalendar.push(newEvent);
							$('#full-calendar').fullCalendar( 'refetchEvents' );
							$.hideSubview();
							toastr.success('A new event has been added to your calendar!');
						}
					}
				});
					
				}



			}
		});
	};
	// on hide event's form destroy summernote and bootstrapSwitch plugins
	var hideEditEvent = function() {
		$.hideSubview();
		$('.form-full-event .summernote').destroy();
		$(".form-full-event .all-day").bootstrapSwitch('destroy');
		
	};
    return {
        init: function () {
        	setFullCalendarEvents();
            runFullCalendar();

            runFullCalendarValidation();
        }
    };
}();

jQuery(document).ready(function() {
	Calendar.init();
});
</script>
<?php } ?>
