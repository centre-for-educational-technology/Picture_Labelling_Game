/**
 * Created by gleb on 18/04/16.
 */




var app = angular.module('gameApp', ['ngAnimate', 'ngSanitize', 'ngToast'], function($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
});

app.config(['ngToastProvider', function(ngToastProvider) {
  ngToastProvider.configure({
    animation: 'slide' // or 'fade'
  });
}]);


app.controller('TagController', function($scope, $http, ngToast, $animate) {


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

    $http.post('/labellinggame/api/game', {
      tag: $scope.tag,
      pic: $scope.pic.id,
      my_session_id: $scope.my_session_id
    }).success(function(data, status, headers, config) {


      //In taboo list case
      if (data.inTabooListFlag == true){
        $scope.taboo_tag = data.tag;
        ngToast.create({
          className: 'warning',
          content: 'This word is in taboo list: ' + data.tag
        });
      } else{
        //Already used tag in this session case
        if(data.usedTagFlag == true){
          $scope.used_tag = data.tag;
          ngToast.create({
            className: 'warning',
            content: 'You have already used this tag: ' + data.tag.tag
          });

        }else{
          //New matching case
          if(data.matchingWordAddedFlag == true){
            $scope.matching_words.push(data.tag.tag);
            ngToast.create({
              className: 'success',
              content: 'You got a new match!'
            });
          }
          $scope.tags.push(data.tag);

        }
      }

      $scope.loading = false;

      $scope.tag = '';


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

    var tag = $scope.tags[index];

    $http.delete('/labellinggame/api/game/' + tag.id, {params: {my_session_id: $scope.my_session_id}})
      .success(function(data, status, headers, config) {
        $scope.tags.splice(index, 1);

        if(data.deleteFromMatchingWordsFlag == true){
          $scope.matching_words.splice(index, 1);
        }

        $scope.loading = false;

      });
  };


  $scope.init();
});

