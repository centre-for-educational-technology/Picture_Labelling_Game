<?php // I AM A FAKER ?>
<div ng-app="gameApp" ng-controller="TagController">




    <div class="alert alert-warning alert-dismissible" ng-show="usedTagFlag" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        You have already used this tag: <strong><% usedTag.tag %></strong>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="card">
            <div class="card-image">
              <img class="img-responsive" src="<% pic.url %>">

            </div><!-- card image -->


          </div>
        </div>
      </div>
    </div>
    <div class="row">

      <div class="col-sm-6">

              <div class="well well-lg">Your competitor: <% second_player %></div>
              <div class="panel panel-danger">
                <!-- Default panel contents -->
                <div class="panel-heading">List of taboo words</div>

                <!-- List group -->
                <ul class="list-group">
                  <li class="list-group-item">Cras justo odio</li>
                  <li class="list-group-item">Dapibus ac facilisis in</li>
                  <li class="list-group-item">Morbi leo risus</li>
                  <li class="list-group-item">Porta ac consectetur ac</li>
                  <li class="list-group-item">Vestibulum at eros</li>
                </ul>
              </div>

      </div>

      <div class="col-sm-6">

              <div class="input-group input-group-lg my-tags">
                  <input type="text" class="form-control" placeholder="Add tag..." ng-model="tag.tag">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button" ng-click="addTag()">Add</button>
                    </span>

              </div><!-- /input-group -->
              <i ng-show="loading" class="fa fa-spinner fa-spin"></i>






              <div class="panel panel-success">
                <!-- Default panel contents -->
                <div class="panel-heading">Your tags</div>


                <!-- List group -->
                <ul class="list-group" >
                  <li class="list-group-item" ng-repeat='tag in tags'>

                    <% tag.tag %>
                    <button class="btn btn-danger btn-xs pull-right" ng-click="deleteTag($index)">  <span class="glyphicon glyphicon-trash"></span>Delete</button>
                  </li>

                </ul>
              </div>





      </div>



    </div>



</div>