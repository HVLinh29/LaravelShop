<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Silder;
class SliderController extends Controller
{
    public function manage_banner(){
        $all_slider = Slide::orderBy('slider_id,DESC');
        return view('slider.list_slider');
    }
 
}
