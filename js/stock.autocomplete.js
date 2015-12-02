$(document).ready(function(){
	$(".stock-autocomplete").autocomplete({
		source: function (request, response) {

			var search = request.term;

			var mapped;
			$.ajax({
				url: "https://widgetdata.tradingview.com/search/?text="+search+"&exchange=&type=stock",
				dataType : "json",
				success: function(data) {
					mapped = $.map(data, function (e) {
						return {
							label: e.symbol + ' (' + e.full_name + ')',
							value: e.symbol,
							exch: e.exchange
						};
					});
					response(mapped);
				}
			});

		},
		select: function(event, ui) {
			$(this).next('.stock-exch').val(ui.item.exch);
		},
		minLength: 2
	});
});