<?php
function nav_route_active_class($routeName) {
    return Route::currentRouteNamed($routeName) ? 'active' : '';
}