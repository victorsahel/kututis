<?php

function api_url(string $path) {
    $host = rtrim(config('app.api_url'), '/');
    $path = ltrim($path, '/');

    return $host.'/'.$path;
}
