<?php // I AM A FAKER ?>
<div ng-app="gameApp" ng-controller="TagController">



    <div class="col-md-6">

        <img class="img-responsive" src="<% pic.url %>">
    </div>

    <div class="col-md-6">

        <div class="row">


            <div class="input-group input-group-lg">
                <input type="text" class="form-control" placeholder="Add tag..." ng-model="tag.tag">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button" ng-click="addTag()">Add</button>
                  </span>

                </div><!-- /input-group -->
            <i ng-show="loading" class="fa fa-spinner fa-spin"></i>


        </div>


        <div class="row">
            <table class="table table-striped tags">
                <tr ng-repeat='tag in tags'>
                    <td><% tag.tag %></td>
                    <td><button class="btn btn-danger btn-xs" ng-click="deleteTag($index)">  <span class="glyphicon glyphicon-trash"></span>Delete</button></td>
                </tr>
            </table>
        </div>

    </div>




</div>