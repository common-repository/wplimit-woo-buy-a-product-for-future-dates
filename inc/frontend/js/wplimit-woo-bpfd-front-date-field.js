(function($){
	$(document).ready(function(){
		var date = $("#wplimit_woo_bpfd_date_field");
		 date.datepicker({
			dateFormat: 'M dd, yy',
			minDate: 0, 
		 });	
	});
}(jQuery));