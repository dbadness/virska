$(document).ready(function() {
	
	$.ajax({
		type: 'POST',
		url: '/admin/p_dod_growth',
		success: function(response) {
			
			// parse both arrays into their respective arrays on the client side of things
			var data = jQuery.parseJSON(response);
			
			var new_data = 	[[data.days[7], data.values[7]],
							[data.days[6], data.values[6]],
							[data.days[5], data.values[5]],
							[data.days[4], data.values[4]],
							[data.days[3], data.values[3]],
							[data.days[2], data.values[2]],
							[data.days[1], data.values[1]],
							[data.days[0], data.values[0]]];

		  var plot1 = $.jqplot('dodGrowth', [new_data], {
		      title:'Day Over Day Growth',
		      axes:{
		        xaxis:{
		          renderer:$.jqplot.DateAxisRenderer,
		          tickOptions:{
		            formatString:'%b&nbsp;%#d'
		          } 
		        },
		        yaxis:{
		        }
		      },
		      highlighter: {
		        show: true,
		        sizeAdjust: 7.5
		      },
		      cursor: {
		        show: false
		      }
		  }); // end of plot 1
		}, // of of success
	});
	
}); // end doc ready