// $.noConflict();

$(document).ready(function($) {

	"use strict";

	[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
		new SelectFx(el);
	} );

	$('.selectpicker').selectpicker;


	$('#menuToggle').on('click', function(event) {
		$('body').toggleClass('open');
		$('#right-panel').toggleClass('fullwidth');
	});

	$('.search-trigger').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').addClass('open');
	});

	$('.search-close').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').removeClass('open');
	});

	setTimeout(() => {
		// alert()
		$(".select2-selection").on("focus", function () {
			$(this).parent().parent().prev().select2("open");
		});
	}, 500);
	console.table("x2HfQU7BhWNkILxlm/Lw5wjp/X29cvESJ8cusvbUAkk=");
});


function onlyNumberKey(evt) { 
          
	// Only ASCII charactar in that range allowed 
	var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
	if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
		return false; 
	return true; 
} 
function onlyDecimalKey(evt) { 
          
	// Only ASCII charactar in that range allowed 
	var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
	console.log(ASCIICode);
	if (ASCIICode==46) {
		return true
	}
	if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
		return false; 
	return true; 
} 
  
$("#delete-all").click(function(){


	var RowId = [];
	$.each($("input[name='selection[]']:checked"), function() {
		RowId.push($(this).val());
	});
	var attribName=$("#delete-all").data('attrib-name');
	

	if(RowId.length==0){
	alert("Please Select Row")
	return
	}
	  $.ajax({
		type: "POST",
		url : `index.php?r=${attribName}/multiple-delete`,
		data : {row_id: RowId},
		success : function() {
		  $(this).closest("tr").remove(); //or whatever html you use for displaying rows
		}
	});
	
});
