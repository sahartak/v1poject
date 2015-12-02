$(document).ready(function(){
  var line1 = [['Cup Holder Pinion Bob', 7], ['Generic Fog Lamp', 9], ['HDTV Receiver', 15],
  ['8 Track Control Module', 12], [' Sludge Pump Fourier Modulator', 3],
  ['Transcender/Spice Rack', 6], ['Hair Spray Danger Indicator', 18]];
  var plot1b = $.jqplot('chart1b', [line1], {
	title: 'Concern vs. Occurrance',
	series:[{renderer:$.jqplot.BarRenderer}],
	axesDefaults: {
		tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
		tickOptions: {
		  fontFamily: 'Georgia',
		  fontSize: '10pt',
		  angle: -30
		}
	},
	axes: {
	  xaxis: {
		renderer: $.jqplot.CategoryAxisRenderer
	  }
	}
  });
});