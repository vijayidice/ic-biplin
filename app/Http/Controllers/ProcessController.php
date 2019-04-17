<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use File;

class ProcessController extends Controller
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
    public function load_audit_process()
    {
        if(Auth::user()->usertype == 0)
        {
            return abort(401);
        }
        $page = 'processor';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        
        $categories = DB::table("incentive_catergory")->select('*')->where('division', 3)->where('fyear', '2018-19')->get()->toArray();
        $brands = DB::table('incentive_brandmaster')->select('*')->where('division', 3)->distinct()->get(['incentive_group'])->toArray();
        return view('process.audit_process', compact('page', 'divisions', 'categories', 'brands'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function load_actual_process()
    {
        if(Auth::user()->usertype == 0)
        {
            return abort(401);
        }
        $page = 'processor';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        
        $categories = DB::table("incentive_catergory")->select('*')->where('division', 3)->where('fyear', '2018-19')->get()->toArray();
        $brands = DB::table('incentive_brandmaster')->select('*')->where('division', 3)->distinct()->get(['incentive_group'])->toArray();
        return view('process.actual_process', compact('page', 'divisions', 'categories', 'brands'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function process()
    {
    	if(Auth::user()->usertype == 0)
    	{
    		return abort(401);
    	}
        $page = 'processor';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        
        $categories = DB::table("incentive_catergory")->select('*')->where('division', 3)->where('fyear', '2018-19')->get()->toArray();
        $brands = DB::table('incentive_brandmaster')->select('*')->where('division', 3)->distinct()->get(['incentive_group'])->toArray();
        return view('process', compact('page', 'divisions', 'categories', 'brands'));
    }
    public function audit_process(Request $request)
    {
        if(Auth::user()->usertype == 0)
        {
            return abort(404);
        }
        $validator = \Validator::make($request->all(), [
                'division' => 'required',
                'incentive' => 'required',
                'fin_yr' => 'required',
            ]);
            
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $divisionid = $request['division'];
        $incentive_type = $request['incentive'];
        $fin_yr = $request['fin_yr'];
        #get filename from table

        $file_name_array = DB::table('incentive_slab_filelist')->select('*')->where('divisionid', $divisionid)->where('incentive_type', $incentive_type)->where('fyear', $fin_yr)->get()->toArray();

        if(!empty($file_name_array))
        {
            $file_name = trim($file_name_array[0]->filename);
            if($file_name != '')
            {
                $file_content = File::get(storage_path('process/'.$file_name));
                $content_array = explode(';', $file_content);
                //echo "<pre>"; print_r($content_array); die;
                if(!empty($content_array))
                {
                    for ($i=0; $i<count($content_array); $i++) { 
                        //echo $content_array[$i].'<br><br>';
                        $query = trim($content_array[$i]);
                        if($query != '')
                        {
                            //$affected = DB::update($query);    
                        }
                    }
                    //return response()->json(['success' => 'Records Updated Successfully']);
                }
                else
                {
                    return response()->json(['errors' => 'No Products / Slabs available for processing']);
                }
            }
            else
            {
                return response()->json(['errors' => 'There is no such a file available']);
            }
        }

    }
}
