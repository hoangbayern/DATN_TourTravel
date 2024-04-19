<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Tour;
use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $locations = Location::with('tours')->active()->get();
        $dateFormat = now()->format('Y-m-d');
        $tours = Tour::orderBy('t_start_date')
            ->where('t_start_date', '>', $dateFormat)
            ->where('t_end_date', '>=', $dateFormat)
            ->limit(6)->get();
        $viewData = [
            'locations' => $locations,
            'tours' => $tours,
        ];
        return view('page.home.index', $viewData);
    }

    public function contact()
    {
        return view('page.contact.index');
    }

    public function about()
    {
        return view('page.about.index');
    }

    public function transport()
    {
        return view('page.transport.index');
    }

    public function changeReturn()
    {
        return view('page.return.index');
    }

    public function security()
    {
        return view('page.security.index');
    }
}
