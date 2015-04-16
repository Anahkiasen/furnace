$.tablesorter.addParser({
	id: 'boolean',
	is: function (text, table, cell) {
		return cell.getElementsByClassName('glyphicon').length;
	},
	format: function (text, table, cell) {
		var icon = cell.getElementsByClassName('glyphicon')[0];

		return icon.classList.contains('glyphicon-ok');

	},
	parsed: false,
	type: 'numeric',
});

$('table').tablesorter();
