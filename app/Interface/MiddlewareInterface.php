<?php

namespace App\Interface;

interface MiddlewareInterface{

    public function handle($request, $next);

}