<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Lang;

class LocalizationController extends Controller
{
    public function index($locale)
    {
        App::setLocale($locale);
        //storing the locale in session to get it back in the middleware
        session()->put('locale', $locale);
        return redirect()->back();
    }

    public function switchLang(Request $request, $lang)
    {
        // Store the URL on which the user was
        $previous_url = url()->previous();

        // Transform it into a correct request instance
        $previous_request = app('request')->create($previous_url);

        // Get Query Parameters if applicable
        $query = $previous_request->query();

        // In case the route name was translated
        $route_name = app('router')->getRoutes()->match($previous_request)->getName();

        // Store the segments of the last request as an array
        $segments = $previous_request->segments();



        // Check if the first segment matches a language code
        if (array_key_exists($lang, ['en' => 'English', 'ru' => 'Russian'])) {

            // If it was indeed a translated route name
            if ($route_name && Lang::has('routes.' . $route_name, $lang)) {

                // Translate the route name to get the correct URI in the required language, and redirect to that URL.
                if (count($query)) {
                    return redirect()->to($lang . '/' .  trans('routes.' . $route_name, [], $lang) . '?' . http_build_query($query));
                }

                return redirect()->to($lang . '/' .  trans('routes.' . $route_name, [], $lang));
            }

            // Replace the first segment by the new language code
            $segments[0] = $lang;

            // Redirect to the required URL
            if (count($query)) {
                return redirect()->to(implode('/', $segments) . '?' . http_build_query($query));
            }

            return redirect()->to(implode('/', $segments));
        }

        return redirect()->back();
    }



}
