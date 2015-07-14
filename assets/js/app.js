var app = angular.module('plunker', []);

app.controller('MainCtrl', function ($scope) {
    $scope.name = 'World';
});

app.directive('mypopover', function ($compile, $templateCache, $q, $http) {
    var getTemplate = function (contentType) {
        var def = $q.defer();

        var template = '';
        switch (contentType) {
            case 'user':
                template = $templateCache.get('popoverCurriculum.php');
                if (typeof template === "undefined") {
                    $http.get('popoverCurriculum.php')
                            .success(function (data) {
                                $templateCache.put('popoverCurriculum.php', data);
                                def.resolve(data);
                            });
                } else {
                    def.resolve(template);
                }
                break;
        }
        return def.promise;
    }
    return {
        restrict: "A",
        link: function (scope, element, attrs) {
            getTemplate("user").then(function (popOverContent) {
                var options = {
                    content: popOverContent,
                    placement: "right",
                    html: true,
                    date: scope.date,
                    container: "body"
                };
                $(element).popover(options);
            });
        }
    };
});

app.directive('popovercurriculum', function ($compile, $templateCache, $q, $http) {
    var getTemplate = function (contentType) {
        var def = $q.defer();

        var template = '';
        switch (contentType) {
            case 'user':
                template = $templateCache.get('popoverSemester.php');
                if (typeof template === "undefined") {
                    $http.get('popoverSemester.php')
                            .success(function (data) {
                                $templateCache.put('popoverSemester.php', data);
                                def.resolve(data);
                            });
                } else {
                    def.resolve(template);
                }
                break;
        }
        return def.promise;
    }
    return {
        restrict: "A",
        link: function (scope, element, attrs) {
            getTemplate("user").then(function (popOverContent) {
                var options = {
                    content: popOverContent,
                    placement: "right",
                    html: true,
                    date: scope.date,
                    container: "body"
                };
                $(element).popover(options);
            });
        }
    };
});