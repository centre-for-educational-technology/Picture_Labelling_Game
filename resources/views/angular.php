<?php // I AM A FAKER ?>


<div ng-app="gameApp" ng-controller="TagController">
  <toast></toast>
  <div class="container">
    <div class="row">

      <script type="text/ng-template" id="modal.html">
        <div class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" ng-click="close('Cancel')" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Your result</h4>
              </div>
              <div class="modal-body">


                <div ng-if="tags != null">
                  <p>Your matching words:</p>
                  <ul>
                    <li ng-repeat='tag in tags'><% tag.tag %></li>
                  </ul>
                  <p>that give you <% tags.length %> points</p>
                </div>
                <div ng-if="tags == null">
                  <p>No matches this time :(</p>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" ng-click="close('Yes')" class="btn btn-default" data-dismiss="modal">Ok</button>
              </div>
            </div>
          </div>
        </div>
      </script>


      <div class="jumbotron" ng-if="no_pictures_flag==false">
        <div class="container">

        <div class="container-fluid">



          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <div class="card">
                <div class="card-image">
                  <img class="img-responsive" ng-src="<% pic.url %>">

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
                      <li class="list-group-item" ng-repeat='matching_word in matching_words' ng-class="{'list-group-item-warning': matching_word == taboo_tag}">
                        <% matching_word %>
                      </li>


                    </ul>
                  </div>

          </div>

          <div class="col-sm-6">

              <div class="input-group input-group-lg my-tags">
                  <input type="text" class="form-control" placeholder="Add tag..." ng-model="newTag.tag" ng-trim='false'>
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button" ng-click="addTag()"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Add tag</button>
                    <button type="button" class="btn btn-default" aria-label="Left Align" ng-click="submitTags()">
                      <span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> Submit and next
                    </button>
                  </span>


              </div><!-- /input-group -->








                  <div class="panel panel-success">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Your tags</div>


                    <!-- List group -->
                    <ul class="list-group" >
                      <i ng-show="loading" class="glyphicon glyphicon-refresh" id="my_spinner"></i>
                      <li class="list-group-item" ng-repeat='tag in tags'>

                        <% tag.tag %>
                        <button class="btn btn-danger btn-xs pull-right" ng-click="deleteTag($index)">  <span class="glyphicon glyphicon-trash"></span>Delete</button>
                      </li>

                    </ul>
                  </div>




          </div>



        </div>


        </div>



      </div>

      <div class="alert alert-danger" ng-if="no_pictures_flag==true" role="alert">Please add pictures to the game. Only admin can add pictures</div>


    </div>
  </div>

</div>