<?php

function get_home_url()
{
    return route(get_home_route_name());
}

function get_home_route_name()
{
    if (auth()->guest()) {
        return 'register';
    }
    if (auth()->user()->isAdmin()) {
        return 'admin.index';
    }
    return 'my_order.index';
}

function get_resource_url($url)
{
    $path = str_replace("/", DIRECTORY_SEPARATOR, $url);
    $version = md5_file(public_path($path));
    return "$url?v=$version";

}
