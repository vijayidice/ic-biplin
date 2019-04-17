<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:userlogins');
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        /*$page = 'dashboard';
        return view('home', compact('page'));*/
        return redirect('dashboard');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $page = 'dashboard';
        return view('home', compact('page'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_category_by_division(Request $request)
    {
       $division = $request['division'];
       $fyear = $request['fin_yr'];
        
        $categories = DB::table("incentive_catergory")->select('*')->where('division', $division)->where('fyear', $fyear)->get()->toArray();
        $options = '';
        if(!empty($categories))
        {
            foreach ($categories as $category) {
               $options .= '<div class="col-md-3"><input type="radio" name="incentive_type" value="'.$category->incentive_type.'"> <span>'.$category->Incentive_name.'</span></div>';
            }
        }
        echo $options;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function get_brands_by_df(Request $request)
    {
       $division = $request['division_id'];
       $fyear = $request['financial_year'];
        
        $brands_array = DB::table("incentive_group")->select('*')->where('division', $division)->where('fyear', $fyear)->groupBy('incentive_group')->get()->toArray();
        $options = '';
        if(!empty($brands_array))
        {
            $options .= '<option value="">Select Brand</option>';
            foreach ($brands_array as $brand) {
               $options .= '<option value="'.$brand->incentive_group.'">'.ucwords($brand->incentive_group).'</option>';
            }
        }
        echo $options;
    }
}
