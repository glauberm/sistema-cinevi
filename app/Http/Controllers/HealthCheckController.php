<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class HealthCheckController extends Controller
{
    public function healthCheck(): RedirectResponse
    {
        return new RedirectResponse('/', 301);
    }
}
