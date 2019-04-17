<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\IncentiveAuditReportNonBrand;
use App\Exports\IncentiveAuditReportNonBrandOther;
use App\Exports\IncentiveAuditReportBrand;

use App\Exports\QuarterlyIncentiveQuarterReport;
use App\Exports\QuarterlyIncentiveBrandReport;
use App\Exports\AnnualIncentiveReport;
use App\Exports\AnnualIncrementIncentiveReport;
use App\Exports\AnnualAchievementGuidanceReport;
use App\Exports\AnnualIncrementGuidanceReport;
use App\Exports\IncentiveMetroNonMetroAuditReport;
use App\Exports\IncentiveOthersAuditReport;
//use App\Exports\IncentiveAuditReport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use File;

class ReportController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function load_report_general()
    {
    	if(Auth::user()->usertype == 0)
    	{
    		return abort(401);
    	}
        $page = 'reports';
        return view('reports.general.general_reports', compact('page'));
    }

    

    /* Audit Report Section */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function load_report_audit()
    {
        if(Auth::user()->usertype == 0)
        {
            return abort(401);
        }
        $page = 'reports';
        return view('reports.audit.audit_reports', compact('page'));
    }

    public function incentive_audit_report_non_brand()
    {
        $page = 'reports';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        return view('reports.audit.incentive_audit_report_non_brand', compact('page', 'divisions'));  
    }

    public function incentive_audit_report_non_brand_generate(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); die;
        $division = $request['division'];
        $financial_year = $request['financial_year'];
        $profile_role = $request['profile_role'];
        $territory_type = $request['territory_type'];
        $intima_type = ($division == '14') ? $request['intima_type'] : '';

        if($territory_type != 'others')
        {
            return Excel::download(new IncentiveAuditReportNonBrand($division, $financial_year, $profile_role, $territory_type, $intima_type), 'incentive_audit_report_non_brand.xlsx');    
        }
        else
        {
            return Excel::download(new IncentiveAuditReportNonBrandOther($division, $financial_year, $profile_role, $territory_type), 'incentive_audit_report_non_brand_other.xlsx');
        }
    }

    public function incentive_audit_report_brand_generate(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); die;
        $division = $request['division'];
        $financial_year = $request['financial_year'];
        $profile_role = $request['profile_role'];
        $brand_options = $request['brand_options'];
        $territory_type = $request['territory_type'];
        $esv_pcent = '';
        $exp_pcent = '';

        $incentive_slab = DB::table("incentive_summaryP")->select('esv_pcent', 'pearn_pcent', 'exp_pcent')->where('divisionid', $division)->where('fyear', $financial_year)->where('territory_type', $territory_type)->where('profileid', $profile_role)->where('noofbrand_bud', $brand_options)->get()->toArray();

        if(!empty($incentive_slab))
        {
            $inc_slab = $incentive_slab[0];
            $esv_pcent = $inc_slab->esv_pcent;
            $exp_pcent = $inc_slab->exp_pcent;
            $pearn_pcent = $inc_slab->pearn_pcent;
        }

        return Excel::download(new IncentiveAuditReportBrand($division, $financial_year, $profile_role, $territory_type, $brand_options, $esv_pcent, $pearn_pcent, $exp_pcent), 'incentive_audit_report_brand.xlsx');
    }

    public function incentive_audit_report_brand()
    {
        $page = 'reports';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        return view('reports.audit.incentive_audit_report_brand', compact('page', 'divisions'));  
    }

    public function load_quarterly_incentive_report(){
        $page = 'reports';
        $brands = DB::table('incentive_brandmaster')->where('division', 3)->distinct()->get(['incentive_group'])->toArray();
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        return view('reports.general.quarterly_incentive_report', compact('page', 'divisions', 'brands'));  
    }
    public function load_annual_increment_report(){
        $page = 'reports';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        return view('reports.general.annual_incentive_report', compact('page', 'divisions'));  
    }

    public function load_annual_increment_incentive_report(){
        $page = 'reports';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        return view('reports.general.annual_increment_incentive_report', compact('page', 'divisions'));  
    }







    public function load_aag_report()
    {
        $page = 'reports';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        return view('annual_achievement_guidance_report', compact('page', 'divisions'));  
    }
    
    public function load_aig_report(){
        $page = 'reports';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        return view('annual_increment_guidance_report', compact('page', 'divisions'));  
    }
    
    

    public function load_ia_report(){
        $page = 'reports';
        $brands = DB::table('incentive_brandmaster')->where('division', 3)->distinct()->get(['incentive_group'])->toArray();
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        return view('incentive_audit_report', compact('page', 'divisions', 'brands'));  
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function load_incentive_simulator()
    {
        $page = 'incentive_simulator';
        return view('incentive_simulator', compact('page'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function load_incentive_guidance()
    {
        $page = 'incentive_guidance';
        return view('incentive_guidance', compact('page'));
    }
	
	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function load_quarterly_brand_incentive_audit_report()
    {
        $page = 'reports';
        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        
        $brands = DB::table('incentive_brandmaster')->where('division', 3)->distinct()->get(['incentive_group'])->toArray();
        return view('quarterly_brand_incentive_audit_report', compact('page', 'divisions', 'brands' ));
    }

    public function quarterly_qb_incentive_report(Request $request)
    {
        $division = $request['division'];
        $incentive_type = $request['incentive_type'];
        $financial_year = $request['financial_year'];
        $quarter = $request['quarter'];
        $brand_options = $request['brand_options'];
        if($incentive_type == 'quarterly')
        {
            return Excel::download(new QuarterlyIncentiveQuarterReport($division, $incentive_type, $financial_year, $quarter), 'quarterly_quater_incentive_report.xlsx');
        }
        else if($incentive_type == 'brand')
        {
            return Excel::download(new QuarterlyIncentiveBrandReport($division, $incentive_type, $financial_year, $brand_options), 'quarterly_brand_incentive_report.xlsx');
        }
        
    }

    public function annual_incentive_report_generate(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); die;
        $division = $request['division'];
        $financial_year = $request['financial_year'];
        
        return Excel::download(new AnnualIncentiveReport($division, $financial_year), 'annual_incentive_report.xlsx');
    }

    public function annual_increment_incentive_report_generate(Request $request)
    {
        $division = $request['division'];
        $financial_year = $request['financial_year'];
        
        return Excel::download(new AnnualIncrementIncentiveReport($division, $financial_year), 'annual_increment_incentive_report.xlsx');
    }

    public function annual_achievement_guidance_report_generate(Request $request)
    {
        $division = $request['division'];
        $financial_year = $request['financial_year'];
        
        return Excel::download(new AnnualAchievementGuidanceReport($division, $financial_year), 'annual_achievement_guidance_report.xlsx');
    }
    public function annual_increment_guidance_report_generate(Request $request)
    {
        $division = $request['division'];
        $financial_year = $request['financial_year'];
        
        return Excel::download(new AnnualIncrementGuidanceReport($division, $financial_year), 'annual_increment_guidance_report.xlsx');
    }

    public function incentive_audit_report_generate(Request $request)
    {
        $division = $request['division'];
        //$intima_type = '';
        $financial_year = $request['financial_year'];
        $territory_type = $request['territory_type'];
        $profile_role = $request['profile_role'];
        /*if($division == '14')
        {
            $intima_type = $request['intima_type'];
        }*/

        /*if ($division == ) {
            # code...
        }
*/


        if($territory_type != 'others')
        {
        	return Excel::download(new IncentiveMetroNonMetroAuditReport($division, $financial_year, $profile_role, $territory_type), 'incentive_audit_metro_non_metro_report.xlsx');
        }
        else
        {
        	return Excel::download(new IncentiveOthersAuditReport($division, $financial_year, $profile_role, $territory_type), 'incentive_audit_others_report.xlsx');
        }

    }

    public function quarterly_brand_incentive_audit_report_generate(Request $request)
    {
        $division = $request['division'];
        $financial_year = $request['financial_year'];
        $territory_type = $request['territory_type'];
        $profile_role = $request['profile_role'];
        if($territory_type != 'others')
        {
        	return Excel::download(new IncentiveMetroNonMetroAuditReport($division, $financial_year, $profile_role, $territory_type), 'incentive_audit_metro_non_metro_report.xlsx');
        }
        else
        {
        	return Excel::download(new IncentiveOthersAuditReport($division, $financial_year, $profile_role, $territory_type), 'incentive_audit_others_report.xlsx');
        }

    }
}
