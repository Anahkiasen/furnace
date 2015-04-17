angular.module('furnace').directive('tablesorter', function () {
	return {
		restrict: 'A',
		link    : function ($scope, $element) {
			$.tablesorter.addParser({
				id    : 'boolean',
				is    : function (text, table, cell) {
					return cell && cell.getElementsByClassName('glyphicon').length;
				},
				format: function (text, table, cell) {
					var icon = cell.getElementsByClassName('glyphicon')[0];

					return icon.classList.contains('glyphicon-ok');

				},
				parsed: false,
				type  : 'numeric',
			});

			$element.tablesorter();
		},
	};
});
