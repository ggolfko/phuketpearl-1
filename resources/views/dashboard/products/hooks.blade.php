@extends('dashboard.layout')

@section('head')
<link href="/static/bower_components/angular-tooltips/dist/angular-tooltips.min.css" rel="stylesheet" type="text/css">
<link href="/static/bower_components/angular-ui-switch/angular-ui-switch.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/bower_components/fancybox/source/jquery.fancybox.css" type="text/css" media="screen">
<style>
.ui-tooltip {
    font-size: 11.5px;
    font-weight: 400;
    padding: 4px 15px;
    min-width: 96px;
}
.table {
    margin-top: 15px;
}
.table tfoot {
    border-top: 2px solid rgb(221, 221, 221);
}
.table .btn {
    text-transform: uppercase;
}
.table td.focus {
    background-color: #f5f5f5;
}
.table th.focus {
    background-color: #f5f5f5;
}
.table .first-column {
    width: 160px;
}
.table .last-column {
    width: 100px;
}

.status {
    position: relative;
    margin-right: 35px;
    padding-top: .5px;
}
.status .text {
    display: inline-block;
    vertical-align: top;
    margin-top: 6.5px;
    margin-right: 10px;
    font-size: 13.5px;
}
.status .switch-text .on {
    padding-left: 5px;
}
.status .switch-text .off {
    padding-right: 5px;
}
.list {
    position: relative;
}
.list .explain {
    margin-bottom: 10px;
}
.list .explain span {
    padding-left: 35px;
}
.list .items {
    position: relative;
    overflow-x: auto;
}
.list .items .item {
    position: relative;
}
.list .items .item .image {
    position: relative;
}
.list .items .item .image-wrapper {
    position: relative;
    display: block;
    width: 80px;
    margin: 0 auto;
    overflow: hidden;
}
.list .items .item .image .image-wrapper a {
    display: block;
    width: 100%;
}
.list .items .item .image .image-wrapper a img {
    display: block;
    width: 100%;
    opacity: .3;
    filter: alpha(opacity=30);
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
}
.list .items .item .image .image-wrapper a img.active {
    opacity: 1;
    filter: alpha(opacity=100);
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
}
.list .items .item .image .image-wrapper .options {
    position: absolute;
    width: 80px;
    height: 100%;
    left: 0px;
    top: 0px;
    background-color: rgba(0,0,0,.4);
    text-align: center;
}
.list .items .item .image .image-wrapper .options .view {
    position: relative;
    display: inline-block;
    width: auto;
    color: #fff;
    top: 50%;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    margin-left: 2px;
    margin-right: 2px;
}
.list .items .item .image .image-wrapper .options .change {
    position: relative;
    display: inline-block;
    width: auto;
    color: #fff;
    top: 50%;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    margin-left: 2px;
    margin-right: 2px;
}
.list .items .item .image .image-wrapper .options .remove {
    position: relative;
    display: inline-block;
    width: auto;
    color: #fff;
    top: 50%;
    transform: translateY(-50%);
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    margin-left: 2px;
    margin-right: 2px;
}
.list .items .item .image .image-wrapper .uploading {
    position: absolute;
    top: 0px;
    left: -12px;
    width: 104px;
    height: 100%;
}
.list .items .item .input {
    position: relative;
    text-align: center;
    margin-top: 2px;
    margin-bottom: 2px;
}
.list .items .item .text {
    position: relative;
    text-align: center;
}
.list .items .item .text span {
    outline: none;
    font-size: 12px;
}
</style>
@endsection

@section('content')
<!--main content start-->
<section id="main-content" class="hidden" ng-controller="Options">
    <section class="wrapper">

        <div class="row">
            <div class="col-lg-12">
                <section class="panel" id="no-more-tables">
                    <header class="panel-heading">
						<div class="row">
                            <div class="col-xs-12">
								<a href="/dashboard/products/{{$product->productid}}" class="btn btn-danger btn-sm">
									<i class="fa fa-chevron-left"></i>
		                            {{trans('_.Back')}}
		                        </a>
                                <a href="/dashboard/products/{{$product->productid}}/images" class="btn btn-danger btn-sm pull-right">
                                    {{trans('product.Product Images')}}
                                </a>
		                    </div>
						</div>
                    </header>
                    <div class="panel-body" style="min-height:calc(100vh - 150px)">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="list">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="explain"><span>{{trans('product.You can edit the text on the table by clicking on the content and type text into it. However, the data will not be changed until you press the button to save the changes.')}}</span></div>
                                        </div>
                                        <div class="col-md-5">
                                            <button class="btn btn-danger btn-sm" type="button" ng-disabled="disabled" ng-click="save()" ng-class="{'pull-right': screen == 'lg' || screen == 'md'}">
                                                {{trans('_.Save changes')}}
                                            </button>
                                            <div class="status" ng-class="{'pull-right': screen == 'lg' || screen == 'md', 'pull-left': screen == 'xs' || screen == 'sm'}">
                                                <div class="text">{{trans('_.Status')}}</div>
                                                <switch ng-model="status" ng-change="changeStatus()" on="{{trans('product.Show')}}" off="{{trans('product.Hide')}}" class="wide"></switch>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="first-column">&nbsp;</th>
                                                    <th class="text-center" ng-repeat="column in columns track by $index" ng-mouseenter="focusColumnMouseEnter($index)" ng-mouseleave="focusColumnMouseLeave()" ng-class="{'focus':(focusColumn==($index+1))}">
                                                        <span ng-model="dataColumn[$index]" content-editable edit-callback="editingColumn" data-id="[[column.id]]" ng-bind-html="column.text" style="outline:none;"></span>
                                                    </th>
                                                    <th class="last-column">
                                                        <button type="button" class="btn btn-xs btn-danger" ng-click="addColumn()" ng-disabled="disabled">{{trans('product.Add column')}}</button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="row in items track by $index">
                                                    <td ng-repeat="column in row track by $index" ng-class="{'focus':focusColumn == $index}">
                                                        <div class="item" ng-if="$index == 0">
                                                            <span ng-model="dataRow[$index]" content-editable edit-callback="editingRow" ng-bind-html="column.text" data-id="[[column.id]]" style="outline:none;"></span>
                                                        </div>
                                                        <div class="item" ng-if="$index > 0" ng-controller="Item" ng-mouseenter="mouseEnter()" ng-mouseleave="mouseLeave()">
                                                            <div class="image">
                                                                <div class="image-wrapper">
                                                                    <a href="#">
                                                                        <img ng-src="[[imageSource(column)]]" ng-class="{'active': isObject(column.image)}">
                                                                    </a>
                                                                    <div class="options" ng-show="imageOptions">
                                                                        <a href="#" class="change" ng-click="uploadImage($event, column)">
                                                                            <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a href="#" class="view" ng-show="isObject(column.image)" ng-click="viewImage($event, column);">
                                                                            <i class="fa fa-picture-o" aria-hidden="true"></i>
                                                                        </a>
                                                                        <a href="#" class="remove" ng-show="isObject(column.image)" ng-click="removeImage($event, column)">
                                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>
                                                                    <img src="/static/dashboard/assets/img/hook-uploading.gif" class="uploading" ng-show="uploadingItem.id == column.id">
                                                                </div>
                                                            </div>
                                                            <div class="input">
                                                                <input type="radio" name="options" icheck>
                                                            </div>
                                                            <div class="text">
                                                                <span ng-model="data[$index]" content-editable edit-callback="editingRow" ng-bind-html="column.text" data-id="[[column.id]]">[[column.text]]</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-xs btn-danger" ng-click="removeRow($index)" ng-disabled="disabled">{{trans('product.Remove row')}}</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        <button type="button" class="btn btn-xs btn-danger" ng-click="addRow()" ng-disabled="disabled">{{trans('product.Add row')}}</button>
                                                    </th>
                                                    <th class="text-center" ng-repeat="column in columns track by $index" ng-mouseenter="focusColumnMouseEnter($index)" ng-mouseleave="focusColumnMouseLeave()" ng-class="{'focus':(focusColumn==($index+1))}">
                                                        <button type="button" class="btn btn-xs btn-danger" ng-click="removeColumn($index)" ng-disabled="disabled">{{trans('product.Remove column')}}</button>
                                                    </th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <input type="file" class="hidden" accept="image/x-png, image/gif, image/jpeg" ng-disabled="disabled" id="fileImage">

    </section>
</section>
<!--main content end-->
@endsection

@section('foot')
<script src="/static/bower_components/moment/moment.js"></script>
<script src="/static/bower_components/angular-tooltips/dist/angular-tooltips.min.js"></script>
<script src="/static/bower_components/angular-ui-switch/angular-ui-switch.min.js"></script>
<script src="/static/node_modules/angular-content-editable/dist/content-editable.directive.min.js"></script>
<script src="/static/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script src="/static/bower_components/fancybox/source/jquery.fancybox.pack.js"></script>
<script>
app.requires.push('720kb.tooltips');
app.requires.push('content-editable');
app.requires.push('uiSwitch');

app.controller('Options', function($scope, $log, $http, $window, $timeout){
    $scope.columns  = {!! $product->hook->columns !!};
    $scope.items    = {!! $product->hook->items !!};
    $scope.status   = {{$product->hook_status == '1'?'true':'false'}};
    $scope.disabled = false;
    $scope.focusColumn = null;

    $scope.editingColumn = function(text, elem){
        $scope.columns.forEach(function(item, i){
            if (item.id == $(elem).attr('data-id')){
                $scope.columns[i].text = text;
            }
        });
    };

    $scope.editingRow = function(text, elem){
        $scope.items.forEach(function(row, i){
            row.forEach(function(column, j){
                if (column.id == $(elem).attr('data-id')){
                    $scope.items[i][j].text = text;
                }
            });
        });
    };

    $scope.save = function(){
        $scope.disabled = true;

        $http.post('/ajax/dashboard/products/{{$product->productid}}/hooks/save', {
            columns: JSON.stringify($scope.columns),
            items: JSON.stringify($scope.items)
        })
        .success(function(resp){
            if (resp.status == 'ok'){
                noty({
                    text: '{{trans('_.Save changes successfully.')}}',
                    layout: 'topRight',
                    type: 'success',
                    dismissQueue: true,
                    template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
                    animation: {
                        open: {height: 'toggle'},
                        close: {height: 'toggle'},
                        easing: 'swing',
                        speed: 300
                    },
                    timeout: 4500
                });
                $scope.disabled = false;
            }
            else {
                alert(resp.message);
                $scope.disabled = false;
            }
        })
        .error(function(){
            alert('{{trans('error.general')}}');
            $window.location.reload();
        });
    };

    $scope.addColumn = function(){
        var column = {
            id: $scope.generateID(),
            text: 'Click edit text'
        };
        $scope.columns.push(column);
        $scope.items.forEach(function(item, index){
            $scope.items[index].push({
                id: $scope.generateID(),
                image: '',
                text: 'Click edit text'
            });
        });
    };

    $scope.addRow = function(){
        var item = [{
            id: $scope.generateID(),
            text: 'Click edit text'
        }];
        angular.forEach($scope.columns, function(value, key){
            item.push({
                id: $scope.generateID(),
                image: '',
                text: 'Click edit text'
            });
        });
        $scope.items.push(item);
    };

    $scope.removeColumn = function($index){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.columns.splice($index, 1);
            $scope.items.forEach(function(item, index){
                var removeKey = -1;
                angular.forEach(item, function(value, key){
                    if ((key-1) == $index){
                        removeKey = key;
                    }
                });
                if (removeKey > -1){
                    item.splice(removeKey, 1);
                }
            });
        }
    };

    $scope.removeRow = function($index){
        if (confirm('{{trans('_.Are you sure?')}}')){
            $scope.items.forEach(function(item, index){
                if (index == $index){
                    $scope.items.splice($index, 1);
                }
            });
        }
    };

    $scope.focusColumnMouseEnter = function($index){
        $scope.focusColumn = $index+1;
    };
    $scope.focusColumnMouseLeave = function(){
        $scope.focusColumn = null;
    };

    $scope.generateID = function()
    {
        var id = moment().format('DDMMYYHHmmss');
        var fn = function(){
            var gn = Math.floor(Math.random()*10);
            return (gn > -1 && gn < 10)? ""+gn: fn();
        };
        for(var i = 0;i < 4; i++){
            id += fn();
        }
        return id;
    };

    $scope.changeStatus = function(){
        $http.post('/ajax/dashboard/products/{{$product->productid}}/hooks/status',{
            status: $scope.status?'yes':'no'
        })
        .success(function(resp){
            if (resp.status == 'ok'){
                noty({
                    text: '{{trans('product.Save change the status successfully.')}}',
                    layout: 'topRight',
                    type: 'success',
                    dismissQueue: true,
                    template: '<div class="noty_message"><span class="noty_text" style="font-weight:normal;"></span><div class="noty_close"></div></div>',
                    animation: {
                        open: {height: 'toggle'},
                        close: {height: 'toggle'},
                        easing: 'swing',
                        speed: 300
                    },
                    timeout: 4500
                });
            }
            else {
                alert(resp.message);
                $scope.status = !$scope.status;
            }
        })
        .error(function(){
            alert('{{trans('error.general')}}');
            $window.location.reload();
        });
    };

    $scope.imageSource = function(item){
        var source = 'http://placehold.it/80x80';
        if (typeof item.image == 'object'){
            source = '/app/product/{{$product->productid}}/{{$product->hook->hookid}}/'+item.image.imageid+'_t.png';
        }
        return source;
    };

    $scope.viewImage = function($event, item){
        $.fancybox({
            href: '/app/product/{{$product->productid}}/{{$product->hook->hookid}}/'+item.image.imageid+'.png',
            closeBtn: true,
            padding: 9
        });
        $event.preventDefault();
    };

    $scope.removeImage = function($event, item){
        if (confirm('{{trans('_.Are you sure?')}}'))
        {
            $scope.items.forEach(function(row, i){
                row.forEach(function(column, j){
                    if (typeof column.id != 'undefined'){
                        if (column.id == item.id){
                            $scope.items[i][j].image = '';
                        }
                    }
                });
            })
        }
        $event.preventDefault();
    };

    $scope.uploadImage = function($event, item){
        $('#fileImage').trigger('click');
        $scope.uploadItem = item;

        $event.preventDefault();
    };

    $('#fileImage').bind('change', function(){
        if ($(this).val() != '' && $(this)[0].files.length == 1){
            var file = $(this)[0].files[0];
            if ($.inArray(file.type.toLowerCase(), ['image/jpeg', 'image/gif', 'image/png']) >= 0){
                $scope.disabled = true;
                $scope.uploadingItem = $scope.uploadItem;
                $scope.$apply();

                var formData = new FormData();
                formData.append('image', file);
                formData.append('_token', '{{csrf_token()}}');

                $.ajax({
                    url: '/ajax/dashboard/products/{{$product->productid}}/hooks/image',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    data: formData
                })
                .success(function(resp){
                    if (resp.status == 'ok'){
                        $scope.items.forEach(function(row, i){
                            row.forEach(function(column, j){
                                if (typeof column.id != 'undefined'){
                                    if (column.id == $scope.uploadItem.id){
                                        $scope.items[i][j].image = resp.payload.image;
                                    }
                                }
                            });
                        });
                    }
                    else {
                        alert(resp.message);
                    }
                })
                .error(function(){
                    alert('{{trans('error.general')}}');
                    $window.location.reload();
                })
                .complete(function(){
                    $scope.disabled = false;
                    $scope.uploadItem = null;
                    $scope.uploadingItem = null;
                    $scope.$apply();
                });
            }
            else {
                alert('{!! trans('gallery.Allowed only "jpeg, jpg, gif, png" file extension only.') !!}');
            }
        }
    });

    $scope.isObject = function(obj){
        return (typeof obj == 'object');
    };
});

app.controller('Item', function($scope){
    $scope.imageOptions = false;
    $scope.mouseEnter = function(){
        $scope.imageOptions = true;
    };
    $scope.mouseLeave = function(){
        $scope.imageOptions = false;
    };
});

app.directive('icheck', function($timeout, $parse) {
    return {
        link: function($scope, element, $attrs) {
            return $timeout(function() {
                var ngModelGetter, value;
                ngModelGetter = $parse($attrs['ngModel']);
                value = $parse($attrs['ngValue'])($scope);
                return $(element).iCheck({
                    checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red',
                    increaseArea: '20%'
                }).on('ifChanged', function(event) {
                        if ($(element).attr('type') === 'checkbox' && $attrs['ngModel']) {
                            $scope.$apply(function() {
                                return ngModelGetter.assign($scope, event.target.checked);
                            });
                        }
                        if ($(element).attr('type') === 'radio' && $attrs['ngModel']) {
                            return $scope.$apply(function() {
                                return ngModelGetter.assign($scope, value);
                            });
                        }
                    });
            });
        }
    };
});
</script>
@endsection
