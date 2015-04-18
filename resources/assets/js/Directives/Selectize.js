angular.module('furnace').directive('selectize', function ($http) {
	return {
		restrict: 'A',
		link    : function ($scope, $element) {
			$element.selectize({
				valueField : 'id',
				labelField : 'label',
				searchField: 'label',
				create     : false,
				render     : {
					option: function (item, escape) {
						return '<div>' + item.artist + ' - ' + item.title + ' <em>by</em> <strong>' + item.user + '</strong></div>';
					},
				},
				load       : function (query, callback) {
					$element.addClass('loading');
					if (!query.length) {
						return callback();
					}

					$http.get('/api/search?q=' + encodeURIComponent(query)).success(function (results) {
						$element.removeClass('loading');
						callback(results);
					});
				}
			});
		},
	};
});
