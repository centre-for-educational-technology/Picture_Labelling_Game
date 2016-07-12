var app = angular.module('gameApp', ['ngAnimate', 'ngSanitize', 'ngToast', 'ui.bootstrap', 'angularModalService'], function($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
});

app.config(['ngToastProvider', function(ngToastProvider) {
  ngToastProvider.configure({
    animation: 'slide' // or 'fade'
  });
}]);




app.controller('TagController', function($scope, $http, ngToast, $animate, $window, $filter, ModalService) {

  $scope.tags = [];
  $scope.picture = [];

  $scope.matching_words = [];

  $scope.taboo_tag = '';
  
  $scope.loading = false;

  var spinner = document.getElementById('my_spinner');

  console.log(spinner);

  $animate.enabled(spinner, false);

  $scope.init = function() {

    $http.get('/labellinggame/api/game').
    success(function(data, status, headers, config) {
      // Notification.error({message: 'Error notification 1s', delay: 1000});
      $scope.my_session_id = data.my_session_id;
      $scope.second_player = data.second_player;
      $scope.matching_words = data.matching_words_list;
      $scope.pic = data.pic;
      $scope.loading = false;

    });
  };



  $scope.addTag = function() {
    $scope.loading = true;

    //Normalise input
    $scope.newTag.tag = $scope.newTag.tag.toLowerCase().replace(/\s+/g,'-');

    if($scope.tags.length < 5){

      var usedTagTemp = $filter("filter")($scope.tags, $scope.newTag);

      var tabooTagFlag = false;

      angular.forEach($scope.matching_words, function(value, key) {
        if(value == $scope.newTag.tag){
          tabooTagFlag = true;
        }
      });


      if(tabooTagFlag){
        ngToast.create({
          className: 'warning',
          content: 'This tag is in taboo list: ' + $scope.newTag.tag
        });
      }else if(typeof usedTagTemp !== 'undefined' && usedTagTemp.length > 0){
        ngToast.create({
          className: 'warning',
          content: 'You already used that tag: ' + $scope.newTag.tag
        });
      }else{
        $scope.tags.push($scope.newTag);
        $scope.newTag = '';
      }



    }else{
      ngToast.create({
        className: 'warning',
        content: 'You exceeded a limit of 5 tags'
      });
    }
    $scope.loading = false;

  };



  $scope.submitTags = function() {

    $http.post('/labellinggame/api/game', {
      tags: $scope.tags,
      pic: $scope.pic.id,
      my_session_id: $scope.my_session_id
    }).success(function(data, status, headers, config) {

      //New matching case
      if(data.matchingWordAddedFlag == true){

        ModalService.showModal({
          templateUrl: 'modal.html',
          controller: "ModalController",
          inputs: {
            tags: data.matchingWordsList
          }
        }).then(function(modal) {
          modal.element.modal();
          modal.close.then(function(result) {
            $scope.reloadRoute();
          });
        });
      }else{
        ModalService.showModal({
          templateUrl: 'modal.html',
          controller: "ModalController",
          inputs: {
            tags: null
          }
        }).then(function(modal) {
          modal.element.modal();
          modal.close.then(function(result) {
            $scope.reloadRoute();
          });
        });
      }

      $scope.loading = false;



    });
  };

  // $scope.updateTag = function(tag) {
  //   $scope.loading = true;
  //
  //   $http.put('/labellinggame/api/game/' + tag.id, {
  //     title: tag.title,
  //   }).success(function(data, status, headers, config) {
  //     tag = data;
  //     $scope.loading = false;
  //
  //   });
  // };

  $scope.deleteTag = function(index) {
    $scope.loading = true;

    $scope.tags.splice(index, 1);

    $scope.loading = false;

  };


  $scope.reloadRoute = function() {
    $window.location.reload();
  };



  $scope.init();
});

app.controller('ModalController', function($scope, tags, close) {

  $scope.tags = tags;

  console.log($scope.tags);

  $scope.close = function(result) {
    close(result, 500); // close, but give 500ms for bootstrap to animate
  };



});