/**
 * Initialize Angular module and Settings resource object for
 * REST transactions
 */
var tasks = angular.module('tasks', ['ngResource']),
    credentials = {
        client_id: 'frontend-app',
        client_secret: 'V655r0vaHgk4CrMiYvjckxMD54aE81-KIR!)Ku13tE2JqoVoC6fSkOHaTRlCC'
    };

/**
 * Items resource object for interfacing with the server API. Handles
 * GET, POST, PUT, and DELETE methods for all task item operations.
 */
tasks.factory('Items', ['$resource', function($resource) {
    return $resource('/tasks/api/items', null, {
        update: { method: 'PUT' }
    });
}]);

/**
 * The TasksController
 */
tasks.controller('TasksController', function($scope, Items) {
    
    /**
     * Data models - supplied outside app, customizable
     */
    $scope.items = Items.get(credentials);
    
    /**
     * Run setup routines once response received from API and
     * Params resource object is populated with data
     */
    $scope.items.$promise.then(function(settings) {
        
        /**
         * Creates a new task item against the API and refreshes the
         * task items list with a GET call
         */
        $scope.create = function() {
            new Items(angular.extend({ title: $scope.params.title }, credentials)).$save(function(item) {
                $scope.items = Items.get(credentials);
                $scope.params.title = '';
            });
        };
        
        /**
         * Checks an existing task item as completed against the API
         */
        $scope.check = function() {
            var $this = this.item;
            $this.completed = $this.completed == true ? false : true;
            new Items(angular.extend($this, credentials)).$update(function(item) {
                $this.completed = item.completed;
            });
        };
        
        /**
         * Toggles inline editing pane
         */
        $scope.edit = function() {
            this.item.editing = true;
        };
        
        /**
         * Updates an existing task item against the API and refreshes
         * the task items list with a GET call
         */
        $scope.update = function() {
            var $this = this.item;
            new Items(angular.extend($this, credentials)).$update(function(item) {
                $this.editing = false;
            });
            
        };
        
        /**
         * Deletes an existing task item against the API and
         * refreshes the task items list with a GET call
         */
        $scope.delete = function() {
            var $this = this.item;
            new Items().$delete(angular.extend($this, credentials), function(item) {
                $scope.items = Items.get(credentials);
            });
        };
    });
});