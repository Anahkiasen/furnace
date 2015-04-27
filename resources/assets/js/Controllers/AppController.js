angular.module('furnace').controller('AppController', function ($scope, $http) {

	/**
	 * @type {boolean}
	 */
	$scope.showImport = false;

	/**
	 * Favorite a track
	 *
	 * @param $event
	 */
	$scope.favorite = function ($event) {
		$event.preventDefault();
		var $link = $($event.currentTarget);
		var endpoint = $link.attr('href');

		$http.post(endpoint).success(function () {
			$link.find('i').toggleClass('glyphicon-heart glyphicon-heart-empty');
		});
	};

	/**
	 * Remove something
	 *
	 * @param $event
	 */
	$scope.remove = function ($event) {
		if (!confirm('Are you sure you want to delete this?')) {
			return;
		}

		$event.preventDefault();
		var $link = $($event.currentTarget);
		var endpoint = $link.attr('href');

		$http.delete(endpoint).success(function () {
			$link.closest('tr').fadeOut(function () {
				this.remove();
			});
		});
	};

});
