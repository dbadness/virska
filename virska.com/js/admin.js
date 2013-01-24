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
							['Today', data.values[0]]];

			var plot1 = $.jqplot('dodGrowth', [new_data], {
			    title: 'Day over Day Growth (Last Eight Days)',
			    series:[{renderer:$.jqplot.BarRenderer}],
			    axesDefaults: {
			        tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
			        tickOptions: {
			          angle: -30,
			          fontSize: '10pt'
			        }
			    },
			    axes: {
			      xaxis: {
			        renderer: $.jqplot.CategoryAxisRenderer
			      }
			    }
		  	});
		},
	});
	
	
}); // end doc ready