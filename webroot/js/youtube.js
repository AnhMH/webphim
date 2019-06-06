   (function () {
  'use strict';

  angular.
  module('VoHuuNhan', []);
})();

(function () {
  'use strict';

  angular.
  module('VoHuuNhan').
  controller('mainController', mainController);

  function mainController(youtubeService) {

    var vm = this;
    vm.videoListing = [];
    vm.message = "Youtube API By Võ Hữu nhân";

    function showVideos() {
      youtubeService.getVideos().
      success(function (data) {
        vm.videoListing = data.items;
      });
    }
    showVideos();
  }
})();

(function () {
  'use strict';

  angular.
  module('VoHuuNhan').
  factory('youtubeService', youtubeService);

  function youtubeService($http) {
    var apiKey = "AIzaSyD2BlKZRfOC9pRTH9gKf_rBiirwUqv8CcY",
    apiURL = "https://www.googleapis.com/youtube/v3/search?videoEmbeddable=true&order=date&part=snippet&channelId=UC-wNjNTqCfXSKd4S1tNgWUg&type=video&maxResults=50&key=" + apiKey,
    youtubeFactory = {};

    youtubeFactory.getVideos = function () {
      return $http.get(apiURL);
    };

    return youtubeFactory;

  }
})();