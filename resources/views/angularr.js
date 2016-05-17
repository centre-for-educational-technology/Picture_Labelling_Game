/**
 * Created by gleb on 18/04/16.
 */
var app = angular.module('gameApp', [], function($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
});


app.controller('TagController', function($scope, $http) {

  $scope.tags = [];
  $scope.picture = [];
  
  $scope.loading = false;

  $scope.init = function() {
    $scope.loading = true;
    $http.get('/labellinggame/api/game').
    success(function(data, status, headers, config) {
      $scope.tags = data.tags;
      $scope.pic = data.pic;
      $scope.loading = false;

    });
  }

  $scope.addTag = function() {
    $scope.loading = true;

    $http.post('/labellinggame/api/game', {
      tag: $scope.tag.tag,
      pic: $scope.pic,
    }).success(function(data, status, headers, config) {
      $scope.tags.push(data);
      $scope.tag = '';
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

    var tag = $scope.tags[index];

    $http.delete('/labellinggame/api/game/' + tag.id)
      .success(function() {
        $scope.tags.splice(index, 1);
        $scope.loading = false;

      });
  };


  $scope.init();
});

