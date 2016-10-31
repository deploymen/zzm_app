<?php

namespace App\Http\Middleware;

use Closure;
use Route;

class Version {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    private static $Versions = ["1.0", "1.1", "1.2", "1.3", "1.4", "1.5"];

    public function handle($request, Closure $next, $guard = null) {

        $route = Route::getCurrentRoute();
        $routes = Route::getRoutes();

        if ($route->getName() == 'try_prev_version') {

            preg_match('/(?P<version>\d+\.\d+)\/{endpoint}$/', $route->getPath(), $matches);
            $currentVersion = $matches['version'];
            $endpoint = $route->getParameter('endpoint');

            $index = array_search($currentVersion, self::$Versions);

            if ($index === false || $index == 0) {
                die('No version define in version middleware, cannot redirect.');
            }

            for ($i = $index; $i > 0; $i--) {
                $version = self::$Versions[$i - 1];
                $path = "/{$version}/" . $endpoint;

                $server = $request->server();
                $server['REQUEST_URI'] = $path;

                $requestX = $request->duplicate(null, $request->all(), null, null, null, $server);


                try {
                    $match = $routes->match($requestX);
                    if ($match->getName() == 'try_prev_version') {
                        continue;
                    }
                    return Route::dispatch($requestX);
                } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
                    die('No default endpoint define in version ' . $version . ' routes, cannot redirect.');
                }
            }

            die('All version also have no such route, cannot redirect.');
        }

//dd(Route::getCurrentRoute()->getPath());
        return $next($request);
    }

}
