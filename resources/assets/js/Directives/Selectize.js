angular.module('furnace').directive('selectize', function () {
	return {
		restrict: 'A',
		link    : function ($scope, $element) {
			$element.selectize();
		},
	};
});
