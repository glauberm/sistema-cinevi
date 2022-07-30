<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

class WebController extends Controller
{
    public function root(): View
    {
        return view('root');
    }
}