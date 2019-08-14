//define bootrapdatepicker
var BootstrapDatepicker = function() {
	var t;
	t = mUtil.isRTL() ? {
		leftArrow: '<i class="la la-angle-right"></i>',
		rightArrow: '<i class="la la-angle-left"></i>'
	} : {
		leftArrow: '<i class="la la-angle-left"></i>',
		rightArrow: '<i class="la la-angle-right"></i>'
	};
	return {
		init: function() {
			var currentTime = new Date();
			var currentYear = currentTime.getFullYear();
			var formattedDate = moment(currentTime).format('ddMyyyy');
			
			$("#sale_from").datepicker({
				rtl: mUtil.isRTL(),
				orientation: "bottom left",
				todayHighlight: !0,
				templates: t,
				format: 'ddMyyyy',
				startDate: '01-01-'+currentYear,
				autoclose: true
			});

			$('#sale_from').datepicker('setDate',formattedDate);

			$("#sale_to").datepicker({
				rtl: mUtil.isRTL(),
				orientation: "bottom left",
				todayHighlight: !0,
				templates: t,
				format: 'ddMyyyy',
				startDate: new Date(),
				autoclose: true
			});
			
			$("#booking_from").datepicker({
				rtl: mUtil.isRTL(),
				orientation: "bottom left",
				todayHighlight: !0,
				templates: t,
				format: 'ddMyyyy',
				startDate: new Date(),
				autoclose: true
			});

			$('#booking_from').datepicker('setDate',formattedDate);

			$("#booking_to").datepicker({
				rtl: mUtil.isRTL(),
				orientation: "bottom left",
				todayHighlight: !0,
				templates: t,
				format: 'ddMyyyy',
				autoclose: true
			});

			//------------------
			$('#sale_from').datepicker().on('changeDate', function(e) {
				var value_salefrom = $('#sale_from').datepicker('getDate');
				var value_bookfrom = $('#booking_from').datepicker('getDate');
				var value_saleto   = $('#sale_to').datepicker('getDate');
				
				$('#booking_from').datepicker('setStartDate', value_salefrom);
				$('#booking_to').datepicker('setStartDate', value_salefrom);
				$('#sale_to').datepicker('setStartDate', value_salefrom);

				if (value_saleto != null){
					var diff2 = (value_salefrom.getTime() - value_saleto.getTime()) / (24 * 60 * 60 * 1000);
					if(diff2 > 0){
						$('#sale_to').datepicker('setDate', value_salefrom);
					}
				}

				if (value_bookfrom != null){
					var diff1 = (value_salefrom.getTime() - value_bookfrom.getTime()) / (24 * 60 * 60 * 1000);
					if(diff1 > 0){
						$('#booking_from').datepicker('setDate', value_salefrom);
					}
				}
				else {
					$('#booking_from').datepicker('setDate', value_salefrom);
				}
			});

			$('#sale_to').datepicker().on('changeDate', function(e) {
			    var value_saleto = $('#sale_to').datepicker('getDate');
				var value_bookingto = $('#booking_to').datepicker('getDate');
				$('#booking_from').datepicker('setEndDate', value_saleto);
				$('#booking_to').datepicker('setEndDate', value_saleto);

				if(value_bookingto == null)
					$('#booking_to').datepicker('setDate', value_saleto);
			});

			$('#booking_from').datepicker().on('changeDate', function(e) {
			    var value_bookingfrom = $('#booking_from').datepicker('getDate');
				var value_bookingto = $('#booking_to').datepicker('getDate');
				
				$('#booking_to').datepicker('setStartDate', value_bookingfrom);
				if (value_bookingto != null){
					var diff = (value_bookingfrom.getTime() - value_bookingto.getTime()) / (24 * 60 * 60 * 1000);
					if(diff > 0){
						$('#booking_to').datepicker('setDate', value_bookingfrom);
					}
				}
			});
			//------------------
		}
	}
}();

//Applicable Day
//-----------------------
$('#m_wizard_form_step_5' + ' a.applicable-select-all').click(function(){
	$(this).parent('div').find('input[type="checkbox"]').prop('checked', true);
});

$('#m_wizard_form_step_5' + ' a.applicable-unselect').click(function(){
	$(this).parent('div').find('input[type="checkbox"]').prop('checked', false);
});
//-----------------------

//Promotion
//-----------------------
$('#package_rate').change(function(){
	var valueSelected = this.value;
	if (valueSelected == "contract"){
		$("#div_offer_text"+ " input[type='text']").val('');
		$("#div_advance_purchase"+ " input[type='number']").val(0);
		$("#div_discount_value"+ " input[type='text']").val('');

		$("#div_offer_text").addClass('m--hide');
		$("#div_row_offer").addClass('m--hide');
		$("#div_advance_purchase").addClass('m--hide');
		$("#div_discount_type").addClass('m--hide');
		$("#div_discount_value").addClass('m--hide');
	}
	else{
		$("#div_offer_text").removeClass('m--hide');
		$("#div_row_offer").removeClass('m--hide');
		$("#div_advance_purchase").removeClass('m--hide');
		$("#div_discount_type").removeClass('m--hide');
		$("#div_discount_value").removeClass('m--hide');
	}
});

$('#discount_type').change(function(){
	var valueSelected = this.value;
	if (valueSelected == "percent"){
		$("#discount_label").empty();
		$("#discount_label").append('%');
	}
	else{
		$("#discount_label").empty();
		$("#discount_label").append('$');
	}
});
//------------------------

//------------------------
$('.js-example-basic-multiple').select2({
	theme: "bootstrap",
	placeholder: "Please select an option",
	maximumSelectionLength: 5,
	width: null
});

$(".keyword-select").select2({
	tags: true,
	theme: "bootstrap",
	placeholder: "Enter your keywords",
	width: null,
	createTag: function (params) {
	  return {
		id: params.term,
		text: params.term,
		newOption: true
	  }
	},
	templateResult: function (data) {
	  var $result = $("<span></span>");
  
	  $result.text(data.text);
  
	  if (data.newOption) {
		$result.append(" <em>(new)</em>");
	  }
  
	  return $result;
	}
});

$('.input-numeral').each(function (index, field) {
	new Cleave(field, {
		numeral: true,
		numeralThousandsGroupStyle: 'thousand',
	});
});