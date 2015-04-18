angular.module('furnace').controller('AppController', function ($scope, $http) {

	/**
	 * Favorite a track
	 *
	 * @param $event
	 */
	$scope.favorite = function($event) {
		$event.preventDefault();
		var $link = $($event.currentTarget);
		var endpoint = $link.attr('href');

		$http.post(endpoint).success(function() {
			$link.find('i').toggleClass('glyphicon-heart glyphicon-heart-empty');
		});
	}

});
