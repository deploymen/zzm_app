(function () {
    'use strict';

    /**
     * App
     */
    angular
            .module('app', [
                'ngRoute',
                'ngAnimate',
            ]);

    /**
     * Routing
     */
    angular
            .module('app')
            .config(['$locationProvider', '$routeProvider', '$locationProvider', '$httpProvider',
                function ($location, $routeProvider, $locationProvider, $httpProvider) {
                    $routeProvider.
                            when('/welcome', {
                                templateUrl: '/js/app/partials/user/signout.html',
                                controller: 'WelcomeController as vm'
                            }).
                            when('/profiles', {
                                templateUrl: '/js/app/partials/profiles/list.html',
                                controller: 'ProfileController as vm'
                            }).
                            when('/profiles/add', {
                                templateUrl: '/js/app/partials/profiles/add.html',
                                controller: 'AddProfileController as vm'
                            }).
                            when('/profiles/edit/:id', {
                                templateUrl: '/js/app/partials/profiles/edit.html',
                                controller: 'EditProfileController as vm'
                            }).
                            when('/profiles/systems/:profileid', {
                                templateUrl: '/js/app/partials/results/systems.html',
                                controller: 'SystemsController as vm',
                                resolve: {
                                    profileInfoService: profileInfoService
                                }
                            }).
                            when('/profiles/planets/:profileid/:systemid', {
                                templateUrl: '/js/app/partials/results/planets.html',
                                controller: 'PlanetsController as vm',
                                resolve: {
                                    profileInfoService: profileInfoService
                                }
                            }).
                            when('/profiles/questions/:profileid/:planetid', {
                                templateUrl: '/js/app/partials/results/questions.html',
                                controller: 'QuestionsController as vm',
                                resolve: {
                                    profileInfoService: profileInfoService
                                }
                            }).
                            when('/change-password', {
                                templateUrl: '/js/app/partials/user/changePassword.html',
                                controller: 'UserController as vm'
                            }).
                            when('/faq', {
                                templateUrl: '/js/app/partials/user/faq.html',
                                controller: 'PageController as vm'
                            }).
                            when('/signout', {
                                templateUrl: '/js/app/partials/user/signout.html',
                                controller: 'LogoutController'
                            }).
                            otherwise({
                                redirectTo: '/profiles'
                            });
                    $locationProvider.html5Mode(true);
                }]);

    function profileInfoService($route, profileService) {
        var profileId = $route.current.params.profileid;
        return profileService.getProfile(profileId);
    }

    /**
     * Token expiration check
     */
    angular
            .module('app')
            .config(function ($httpProvider) {
                $httpProvider.interceptors.push(function ($q, $injector, $window, APP_CONFIG) {
                    return {
                        responseError: function (rejection) {
                            if (rejection.status === 401) {
                                $window.location.href = APP_CONFIG.signinpage;
                            }

                            // If not a 401, do nothing with this error
                            return $q.reject(rejection);
                        }
                    };
                });
            });

    /**
     * App constants
     */
    angular
            .module('app')
            .constant('APP_CONFIG', {
                api: {
                    base_url: '/api/1.0',
                    fake: 0
                },
                cdnStatic: 'https://d2te1y9qx21itc.cloudfront.net',
                signinpage: '/user/signin/',
                ages: [
                    {id: 5, name: '5 or younger'},
                    {id: 6, name: '6'},
                    {id: 7, name: '7'},
                    {id: 8, name: '8'},
                    {id: 9, name: '9'},
                    {id: 10, name: '10'},
                    {id: 11, name: '11'},
                    {id: 12, name: '12'},
                    {id: 13, name: '13'},
                    {id: 14, name: '14'},
                    {id: 15, name: '15'},
                    {id: 16, name: '16'},
                    {id: 17, name: '17'},
                    {id: 18, name: '18+'}
                ],
                grades: [
                    {id: 'prekindergarten', name: 'Pre-Kindergarten'},
                    {id: 'kindergarten', name: 'Kindergarten'},
                    {id: 1, name: '1'},
                    {id: 2, name: '2'},
                    {id: 3, name: '3'},
                    {id: 4, name: '4'},
                    {id: 5, name: '5'},
                    {id: 6, name: '6'},
                    {id: 7, name: '7'},
                    {id: 8, name: '8'},
                    {id: 9, name: '9'},
                    {id: 10, name: '10'},
                    {id: 11, name: '11'},
                    {id: 12, name: '12'},
                    {id: 'continuous', name: 'Continuous Learner'}
                ]
            });
})();
(function () {
    'use strict';

    /**
     * AnalyticsController
     */
    angular
            .module('app')
            .controller('AnalyticsController', AnalyticsController);

    AnalyticsController.$inject = ['analyticsService'];

    function AnalyticsController(analyticsService) {
        var vm = this;
        
        vm.analyticsService = analyticsService;
    }
})();
/**
 * the HTML5 autofocus property can be finicky when it comes to dynamically loaded
 * templates and such with AngularJS. Use this simple directive to
 * tame this beast once and for all.
 *
 * Usage:
 * <input type="text" zzm-autofocus>
 */

(function () {
    'use strict';
    
    angular
            .module('app')
            .directive('zzmAutofocus', zzmAutofocus);

    zzmAutofocus.$inject = ['$timeout'];

    function zzmAutofocus($timeout) {
        return {
            restrict: 'A',
            link: function ($scope, $element) {
                $timeout(function () {
                    $element[0].focus();
                });
            }
        }
    }

})();
(function () {
    'use strict';

    /**
     * zzmMatchOtherField
     */
    angular
            .module('app')
            .directive('zzmMatchOtherField', zzmMatchOtherField);

    function zzmMatchOtherField() {
        return {
            restrict: 'A',
            scope: true,
            require: 'ngModel',
            link: function (scope, elem, attrs, control) {
                var checker = function () {
                    var e1 = scope.$eval(attrs.ngModel);
                    var e2 = scope.$eval(attrs.zzmMatchOtherField);
                    return e1 == e2;
                };
                scope.$watch(checker, function (n) {
                    control.$setValidity("zzmmatchotherfield", n);
                });
            }
        };
    }
})();
(function () {
    'use strict';

    /**
     * NavController
     */
    angular
            .module('app')
            .controller('NavController', NavController);

    NavController.$inject = ['$scope', '$location'];

    function NavController($scope, $location) {
        $scope.isActive = function (viewLocation) {
            return viewLocation === $location.path();
        }

        $scope.classActive = function (viewLocation) {
            if ($scope.isActive(viewLocation)) {
                return 'active';
            }
        }
    }

})();
(function () {
    'use strict';

    /**
     * NotificationsController
     */
    angular
            .module('app')
            .controller('NotificationsController', NotificationsController);

    NotificationsController.$inject = ['notify'];

    function NotificationsController(notify) {
        var vm = this;

        vm.notify = notify;
    }
})();
(function () {
    'use strict';

    /**
     * PageController
     */
    angular
            .module('app')
            .controller('PageController', PageController);

    PageController.$inject = ['$location', 'notify'];

    function PageController($location, notify) {
        var vm = this;
    }

})();
(function () {
    'use strict';

    /**
     * WelcomeController
     */
    angular
            .module('app')
            .controller('WelcomeController', WelcomeController);

    WelcomeController.$inject = ['$location', 'notify'];

    function WelcomeController($location, notify) {
        var vm = this;

        notify.setMessage('info', 'Logged in');
        $location.path("profiles");
    }

})();
(function () {
    'use strict';

    /**
     * AddProfileController
     */
    angular
            .module('app')
            .controller('AddProfileController', AddProfileController);
    AddProfileController.$inject = ['profileService', '$location', 'notify', 'APP_CONFIG'];
    function AddProfileController(profileService, $location, notify, APP_CONFIG) {
        var vm = this;
        vm.profileData = {};
        vm.ages = APP_CONFIG.ages;
        vm.grades = APP_CONFIG.grades;
        vm.submitProfile = submitProfile;
        ////////////

        function submitProfile() {
            profileService.save(vm.profileData)
                    .then(function (response) {
                        if (response.status === 'success') {
                            notify.setMessage('success', 'Profile added');
                        } else {
                            notify.setMessage('error', 'Oops! Something went wrong', response);
                        }
                    }, function (response) {
                        notify.setMessage('error', 'Oops! Something went wrong', response);
                    })
                    .then(function () {
                        $location.path("profiles");
                    });
        }
    }
})();
(function () {
    'use strict';

    /**
     * EditProfileController
     */
    angular
            .module('app')
            .controller('EditProfileController', EditProfileController);

    EditProfileController.$inject = ['$routeParams', '$location', 'profileService', 'notify', 'APP_CONFIG', '$timeout'];

    function EditProfileController($routeParams, $location, profileService, notify, APP_CONFIG, $timeout) {
        var vm = this;

        vm.APP_CONFIG = APP_CONFIG;
        vm.ages = APP_CONFIG.ages;
        vm.grades = APP_CONFIG.grades;
        vm.deleteProfile = deleteProfile;
        vm.updateProfile = updateProfile;

        activate();

        ////////////

        function activate() {
            profileService.getProfile($routeParams.id).
                    then(function (response) {
                        vm.profile = response.data.profile;

                        // Reflow Foundation Equalizer column height after delay to allow content to display first
                        $timeout(function () {
                            $(document).foundation('equalizer', 'reflow');
                        }, 500);
                    }, function (response) {
                        notify.setMessage('error', 'Oops! Something went wrong', response);
                    })
        }

        function deleteProfile(item) {
            profileService.destroy(item)
                    .then(function (response) {
                        $('#profiledelete').foundation('reveal', 'close');

                        if (response.status === 'success') {
                            notify.setMessage('success', 'Profile deleted');
                        } else {
                            if (response.message === 'account must have at least one profile') {
                                notify.setMessage('warning', 'You must have at least one profile in your account');
                            } else {
                                notify.setMessage('error', 'Oops! Something went wrong', response);
                            }
                        }
                    }, function (response) {
                        notify.setMessage('error', 'Oops! Something went wrong', response);
                    })
                    .then(function () {
                        $location.path("profiles");
                    });
        }

        function updateProfile(form) {
            var fieldsToUpdate = {};

            angular.forEach(form, function (value, key) {
                if (key[0] !== '$' && !value.$pristine) {
                    fieldsToUpdate[key] = vm.profile[key];
                }
            }, fieldsToUpdate);

            // Only update if something has been changed
            if (!$.isEmptyObject(fieldsToUpdate)) {
                profileService.update(vm.profile, fieldsToUpdate)
                        .then(function (response) {
                            notify.setMessage('success', 'Profile updated');
                            $location.path("profiles");
                        }, function (response) {
                            notify.setMessage('error', 'Oops! Something went wrong', response);
                        });
            }
        }
    }
})();
(function () {
    'use strict';

    /**
     * ProfileController
     */
    angular
            .module('app')
            .controller('ProfileController', ProfileController);

    ProfileController.$inject = ['profileService', 'notify', 'APP_CONFIG', '$timeout'];

    function ProfileController(profileService, notify, APP_CONFIG, $timeout) {
        var vm = this;

        vm.profiles = {};
        vm.APP_CONFIG = APP_CONFIG;

        activate();

        ////////////

        function activate() {
            profileService.getProfiles().
                    then(function (response) {
                        vm.profiles = response.data.list;

                        // Reflow Foundation Tooltip column height after delay to allow content to display first
                        $timeout(function () {
                            $(document).foundation('tooltip', 'reflow');
                        }, 3000);
                    }, function (response) {
                        notify.setMessage('error', 'Oops! Something went wrong', response);
                    });
        }
    }
})();
(function () {
    'use strict';

    /**
     * PlanetsController
     */
    angular
            .module('app')
            .controller('PlanetsController', PlanetsController);

    PlanetsController.$inject = ['$routeParams', 'resultsService', 'notify', 'profileInfoService', 'APP_CONFIG', '$timeout'];

    function PlanetsController($routeParams, resultsService, notify, profileInfoService, APP_CONFIG, $timeout) {
        var vm = this;

        vm.APP_CONFIG = APP_CONFIG;
        vm.profile = profileInfoService.data.profile;
        vm.planets = [];
        vm.breadcrumbs = [];
        vm.systemId = $routeParams.systemid;
        vm.profileId = $routeParams.profileid;

        activate();

        ////////////

        function activate() {
            resultsService.getResultsPlanets(vm.profileId, vm.systemId)
                    .then(function (response) {
                        vm.planets = response.data.planet;
                        vm.breadcrumbs = response.data.breadcrumb;

                        // Reflow Foundation Equalizer column height after delay to allow content to display first
                        $timeout(function () {
                            $(document).foundation('equalizer', 'reflow');
                        }, 500);
                    }, function (response) {
                        notify.setMessage('error', 'Oops! Something went wrong', response);
                    });
        }
    }
})();
(function () {
    'use strict';

    /**
     * QuestionsController
     */
    angular
            .module('app')
            .controller('QuestionsController', QuestionsController);

    QuestionsController.$inject = ['$routeParams', 'resultsService', 'notify', 'profileInfoService', 'APP_CONFIG', '$timeout'];

    function QuestionsController($routeParams, resultsService, notify, profileInfoService, APP_CONFIG, $timeout) {
        var vm = this;

        vm.APP_CONFIG = APP_CONFIG;
        vm.profile = profileInfoService.data.profile;
        vm.questions = [];
        vm.pageSize = 100;
        vm.page = 1;
        vm.breadcrumbs = [];
        vm.profileId = $routeParams.profileid;
        vm.planetId = $routeParams.planetid;

        activate();

        ////////////

        function activate() {
            resultsService.getResultsQuestions(vm.profileId, vm.planetId)
                    .then(function (response) {
                        vm.questions = response.data.questions;
                        vm.breadcrumbs = response.data.breadcrumb;
                        var i;
                        for (i = 0; i < vm.questions.length; i++) {
                            var r = vm.questions[i].result;
                            vm.answer = r.correct;
                        }

                        // Reflow Foundation Equalizer column height after delay to allow content to display first
                        $timeout(function () {
                            $(document).foundation('equalizer', 'reflow');
                        }, 500);
                    }, function (response) {
                        notify.setMessage('error', 'Oops! Something went wrong', response);
                    });
        }
    }
})();
(function () {
    'use strict';

    /**
     * SystemsController
     */
    angular
            .module('app')
            .controller('SystemsController', SystemsController);

    SystemsController.$inject = ['$routeParams', 'resultsService', 'notify', 'profileInfoService', 'APP_CONFIG', '$timeout'];

    function SystemsController($routeParams, resultsService, notify, profileInfoService, APP_CONFIG, $timeout) {
        var vm = this;

        vm.APP_CONFIG = APP_CONFIG;
        vm.profile = profileInfoService.data.profile;
        vm.systems = [];
        vm.profileId = $routeParams.profileid;

        activate();

        ////////////

        function activate() {
            resultsService.getResultsSystems(vm.profileId)
                    .then(function (response) {
                        vm.systems = response.data.system;

                        // Reflow Foundation Equalizer column height after delay to allow content to display first
                        $timeout(function () {
                            $(document).foundation('equalizer', 'reflow');
                        }, 500);
                    }, function (response) {
                        notify.setMessage('error', 'Oops! Something went wrong', response);
                    });
        }

    }
})();
(function () {
    'use strict';

    /**
     * Analytics
     */
    angular
            .module('app')
            .factory('analyticsService', analyticsService);

    function analyticsService($window) {
        var service = {
            sendEvent: sendEvent
        };

        return service;

        ////////////

        function sendEvent(category, action, label, nonInteraction) {
            if (!$window.ga) {
                return;
            }
            $window.ga('send', 'event', category, action, label, {nonInteraction: nonInteraction});
        }
    }
})();
(function () {
    'use strict';

    /**
     * notify
     */
    angular
            .module('app')
            .factory('notify', notify);

    function notify($rootScope) {
        var queue = [];
        var currentMessage = '';
        var service = {
            setMessage: setMessage,
            getMessage: getMessage,
            hasMessage: hasMessage,
            markRead: markRead
        };

        $rootScope.$on("$routeChangeSuccess", function () {
            currentMessage = queue.shift() || '';
        });

        return service;

        ////////////

        function setMessage(type, message, response) {
            if (typeof response !== 'undefined') {
                console.log(response);
            }

            var cssClass = '';
            switch (type) {
                case 'error':
                    cssClass = 'alert';
                    break;
                case 'success':
                    cssClass = 'success';
                    break;
                case 'warning':
                    cssClass = 'warning';
                    break;
            }

            queue.push({class: cssClass, message: message});

        }

        function getMessage() {
            return currentMessage;
        }

        function hasMessage() {
            return currentMessage !== '';
        }
        
        function markRead() {
            currentMessage = '';
        }
    }
})();
(function () {
    'use strict';

    /**
     * profileService
     */
    angular
            .module('app')
            .factory('profileService', profileService);

    function profileService($http, APP_CONFIG) {
        var service = {
            getProfiles: getProfiles,
            getProfile: getProfile,
            save: save,
            update: update,
            destroy: destroy
        };
        return service;

        ////////////

        function getProfiles() {
            return $http.get(APP_CONFIG.api.base_url + '/profiles').then(function (result) {
                return result.data;
            });
        }

        function getProfile(id) {
            return $http.get(APP_CONFIG.api.base_url + '/profiles/' + id).then(function (result) {
                return result.data;
            });
        }

        function save(profileData) {
            var config = {
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            };

            return $http.post(APP_CONFIG.api.base_url + '/profiles', $.param(profileData), config)
                    .then(function (result) {
                        return result.data;
                    });

        }

        function update(item, updateFields) {
            return $http.put(APP_CONFIG.api.base_url + '/profiles/' + item.id + '/edit', updateFields).then(function (result) {
                return result.data;
            });

        }

        function destroy(item) {
            return $http.delete(APP_CONFIG.api.base_url + '/profiles/' + item.id).then(function (result) {
                return result.data;
            });
        }
    }
})();
(function () {
    'use strict';

    /**
     * resultsService
     */
    angular
            .module('app')
            .factory('resultsService', resultsService);

    function resultsService($http, APP_CONFIG) {
        var service = {
            getResultsSystems: getResultsSystems,
            getResultsPlanets: getResultsPlanets,
            getResultsQuestions: getResultsQuestions
        };
        return service;

        ////////////

        function getResultsSystems(profileId) {
            var config = {
                params: {
                    profile_id: profileId,
                    page: 1,
                    page_size: 100,
                    fake: APP_CONFIG.api.fake
                }
            };
            return $http.get(APP_CONFIG.api.base_url + '/profiles/result/only-system', config).then(function (result) {
                return result.data;
            });
        }

        function getResultsPlanets(profileId, systemId) {
            var config = {
                params: {
                    profile_id: profileId,
                    system_id: systemId,
                    page: 1,
                    page_size: 100,
                    fake: APP_CONFIG.api.fake
                }
            };
            return $http.get(APP_CONFIG.api.base_url + '/profiles/result/only-planet', config).then(function (result) {
                return result.data;
            });
        }

        function getResultsQuestions(profileId, planetId) {
            var config = {
                params: {
                    profile_id: profileId,
                    planet_id: planetId,
                    page: 1,
                    page_size: 100,
                    fake: APP_CONFIG.api.fake
                }
            };
            return $http.get(APP_CONFIG.api.base_url + '/profiles/result/only-questions', config).then(function (result) {
                return result.data;
            });
        }
    }
})();
(function () {
    'use strict';

    /**
     * userService
     */
    angular
            .module('app')
            .factory('userService', userService);

    function userService($http, APP_CONFIG) {
        var service = {
            changePassword: changePassword
        };
        return service;

        ////////////

        function changePassword(user) {
            var config = {
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            };

            return $http.post(APP_CONFIG.api.base_url + '/auth/change-password', $.param(user), config)
                    .then(function (result) {
                        return result.data;
                    });
        }

    }
})();
(function () {
    'use strict';

    /**
     * LogoutController
     */
    angular
            .module('app')
            .controller('LogoutController', LogoutController);

    LogoutController.$inject = ['$location', 'notify', '$window'];

    function LogoutController($location, notify, $window) {
        var destinationUrl = '/user/signout/';
        $window.location.href = destinationUrl;
    }

})();
(function () {
    'use strict';

    /**
     * UserController
     */
    angular
            .module('app')
            .controller('UserController', UserController);

    UserController.$inject = ['userService', '$location', 'notify'];

    function UserController(userService, $location, notify) {
        var vm = this;

        vm.user = {};
        vm.changePassword = changePassword;

        function changePassword() {
            userService.changePassword(vm.user)
                    .then(function (response) {
                        notify.setMessage('success', 'Password changed');
                    }, function (response) {
                        notify.setMessage('error', 'Oops! Something went wrong', response);
                    })
                    .then(function () {
                        $location.path("profiles");
                    });
        }
    }

})();