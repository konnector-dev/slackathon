<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
    // Register scoped middleware for in scopes.
    $builder->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true,
    ]));

    /*
     * Apply a middleware to the current route scope.
     * Requires middleware to be registered through `Application::routes()` with `registerMiddleware()`
     */
    $builder->applyMiddleware('csrf');

    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, templates/Pages/home.php)...
     */
    //$builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 't']);

    $builder->connect('/oauth-github/auth-request', ['controller' => 'OauthGithubController', 'action' => 'sendToGithubAuth']);
    $builder->connect('/oauth-github/auth', ['controller' => 'OauthGithubController', 'action' => 'getAccessTokenFromCode']);
    $builder->connect('/oauth-github/get-user-info', ['controller' => 'OauthGithubController', 'action' => 'getUserInfo']);
    $builder->connect('/oauth-github/get-user-installations', ['controller' => 'OauthGithubController', 'action' => 'getUserInstallations']);
    $builder->connect('/oauth-github/get-user-repos', ['controller' => 'OauthGithubController', 'action' => 'getUserRepos']);
    $builder->connect('/oauth-github/get-user-orgs', ['controller' => 'OauthGithubController', 'action' => 'getUserOrgs']);
    $builder->connect('/oauth-github/get-owner-repo', ['controller' => 'OauthGithubController', 'action' => 'getOwnerRepo']);
    $builder->connect('/oauth-github/get-owner-repos', ['controller' => 'OauthGithubController', 'action' => 'getOwnerRepos']);
    $builder->connect('/oauth-github/get-repo-pulls', ['controller' => 'OauthGithubController', 'action' => 'getRepoPulls']);
    $builder->connect('/oauth-github/set-push-hooks', ['controller' => 'OauthGithubController', 'action' => 'setPushHooks']);
    $builder->connect('/oauth-github/get-commits', ['controller' => 'OauthGithubController', 'action' => 'getCommits']);
    $builder->connect('/oauth-github/get-single-commit', ['controller' => 'OauthGithubController', 'action' => 'getSingleCommit']);

    $builder->connect('/dashboard', ['controller' => 'UsersController', 'action' => 'dashboard']);
    $builder->connect('/organizations', ['controller' => 'UsersController', 'action' => 'dashboard']);
    $builder->connect('/projects', ['controller' => 'UsersController', 'action' => 'projects']);
    $builder->connect('/commits', ['controller' => 'UsersController', 'action' => 'commits']);
    $builder->connect('/commit', ['controller' => 'UsersController', 'action' => 'commit']);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /*
     * Connect catchall routes for all controllers.
     *
     * The `fallbacks` method is a shortcut for
     *
     * ```
     * $builder->connect('/:controller', ['action' => 'index']);
     * $builder->connect('/:controller/:action/*', []);
     * ```
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $builder->fallbacks();
});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *     // Connect API actions here.
 * });
 * ```
 */
