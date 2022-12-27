<?php

use App\Core\Middleware\Queue as MiddlewareQueue;

MiddlewareQueue::setMap([
   'Maintenance' => \App\Core\Middleware\Maintenance::class,
   'LoginAdmin' => \App\Core\Middleware\LoginAdmin::class
]);


MiddlewareQueue::setMapDefault([]);
