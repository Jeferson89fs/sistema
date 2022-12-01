<?php
 use App\Core\Middleware\Queue as MiddlewareQueue;

 MiddlewareQueue::setMap([
    'Maintenance' => \App\Core\Middleware\Maintenance::class
 ]);


 MiddlewareQueue::setMapDefault([
    
]);
