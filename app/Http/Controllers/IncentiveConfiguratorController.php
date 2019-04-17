<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use File;

class IncentiveConfiguratorController extends Controller
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
    public function load_incentive_configurator_slab()
    {
        if(Auth::user()->usertype == 0)
        {
            return abort(401);
        }

        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        
        $categories = DB::table("incentive_catergory")->select('*')->where('division', 3)->where('fyear', '2018-19')->get()->toArray();

        $brands = DB::table('incentive_brandmaster')->where('division', 3)->distinct()->get(['incentive_group'])->toArray();

        $inc_labels = DB::table('incentive_labels')->select('*')->get()->toArray();
        //echo "<pre>"; print_r($inc_labels); die;
        $incentive_type = DB::table("incentive_slab_ram")->select('ach_val_fr', 'ach_val_to', 'app_pcent', 'app_amount', 'incentive_type')->where('divisionid', 3)->where('fyear', '2018-19')->where('territory_type', 'metro')->where('group_code', 5)->where('profileid', 5)->where('incentive_type', 'quarterly')->get()->toArray();

        $page = 'incentive_configurator';
        return view('incentive_config.incentive_configurator_slab', compact('divisions', 'categories', 'brands', 'incentive_type', 'inc_labels', 'page'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function load_incentive_configurator_pef()
    {
        if(Auth::user()->usertype == 0)
        {
            return abort(401);
        }

        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        
        $categories = DB::table("incentive_catergory")->select('*')->where('division', 3)->where('fyear', '2018-19')->get()->toArray();

        $brands = DB::table('incentive_brandmaster')->where('division', 3)->distinct()->get(['incentive_group'])->toArray();

        $inc_labels = DB::table('incentive_labels')->select('*')->get()->toArray();
        //echo "<pre>"; print_r($inc_labels); die;
        $incentive_type = DB::table("incentive_slab_ram")->select('ach_val_fr', 'ach_val_to', 'app_pcent', 'app_amount', 'incentive_type')->where('divisionid', 3)->where('fyear', '2018-19')->where('territory_type', 'metro')->where('group_code', 5)->where('profileid', 5)->where('incentive_type', 'quarterly')->get()->toArray();

        $page = 'incentive_configurator';
        return view('incentive_config.incentive_configurator_pros_earner_factor', compact('divisions', 'categories', 'brands', 'incentive_type', 'inc_labels', 'page'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function incentive_configurator()
    {
    	if(Auth::user()->usertype == 0)
    	{
    		return abort(401);
    	}

        $divisions = DB::table("division")->select('divisionid', 'name')->get()->toArray();
        
        $categories = DB::table("incentive_catergory")->select('*')->where('division', 3)->where('fyear', '2018-19')->get()->toArray();

        $brands = DB::table('incentive_brandmaster')->where('division', 3)->distinct()->get(['incentive_group'])->toArray();

        $inc_labels = DB::table('incentive_labels')->select('*')->get()->toArray();
        //echo "<pre>"; print_r($inc_labels); die;
        $incentive_type = DB::table("incentive_slab_ram")->select('ach_val_fr', 'ach_val_to', 'app_pcent', 'app_amount', 'incentive_type')->where('divisionid', 3)->where('fyear', '2018-19')->where('territory_type', 'metro')->where('group_code', 5)->where('profileid', 5)->where('incentive_type', 'quarterly')->get()->toArray();

        $page = 'incentive_configurator';
        return view('incentive_configurator', compact('divisions', 'categories', 'brands', 'incentive_type', 'inc_labels', 'page'));
    }

    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function incentive_type_slab(Request $request)
    {
    	if(Auth::user()->usertype == 0)
    	{
    		return abort(401);
    	}
       // DB::enableQueryLog();
        $profileid = $request['profile_role'];
        $division = $request['division'];

        $intima_type = ($division == '14') ? $request['intima_type'] : '';
        
        $fyear = $request['fin_yr'];
        if($profileid == '7')
        {
            $territory = '';
        }
        else if($profileid == '8')
        {
            $territory = '';
        }
        else
        {   
            $territory = $request['territory'];
        }
        
        $incentive = $request['incentive'];
        if(isset($request['brand_val']) && $request['brand_val'] != '')
        {
            if($incentive == 'brandqtr')
            {
                $incentive = 'quarterly';
            }
            $brand_val = $request['brand_val'];

            if($territory != 'all')
            {
                $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('territory_type', $territory)->where('profileid', $profileid)->where('noofbrand_bud', $brand_val)->where('incentive_type', $incentive)->where("txn_no", 1)->get()->toArray();
            }
            else
            {
                $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('profileid', $profileid)->where('noofbrand_bud', $brand_val)->where('incentive_type', $incentive)->where("txn_no", 1)->get()->toArray();
            }
        }
        else
        {
            if($territory != 'all')
            {
                if($division == '14')
                {
                    $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('territory_type', $territory)->where('profileid', $profileid)->where('incentive_type', $incentive)->where('group_code', $intima_type)->where("txn_no", 1)->get()->toArray();
                }
                else
                {
                    $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('territory_type', $territory)->where('profileid', $profileid)->where('incentive_type', $incentive)->where('group_code', '<>', 5)->where("txn_no", 1)->get()->toArray();
                }
            }
            else
            {
                if($division == '14')
                {
                    $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('profileid', $profileid)->where('incentive_type', $incentive)->where('group_code', $intima_type)->where("txn_no", 1)->get()->toArray();
                }
                else
                {
                    $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('profileid', $profileid)->where('incentive_type', $incentive)->where('group_code', '<>', 5)->where("txn_no", 1)->get()->toArray();
                }
            }
        }
        /*$query = DB::getQueryLog();
            dd($query);*/
        /*echo "<pre>";
        print_r($incentive_type); die;*/
        //dd($sd);
        //echo "<pre>"; print_r($request->all()); die;

        //$incentive_type = $request->input('incentive_type');
        //echo "<pre>"; print_r($incentive_type); die;
        $table = '';
        $total_no_header = '';
        $headers_array = [];
        $table .= '<style>
        				#collapseTwo table#example1 > tbody > tr[id="0"] > td .tabledit-input[value=""] {
						    display: block !important;
					        margin: 0 !important;
						}
                        #collapseTwo table#example1 > tbody > tr[id="0"] td.tp input[name="territory_type"]{
                                display: none !important;
                            }

						#collapseTwo table#example1 > tbody > tr[id=""] > td button.tabledit-edit-button, #collapseTwo table#example1 > tbody > tr[id="0"] > td button.tabledit-delete-button {
						    display: none;
						}
                        #collapseTwo table#example1 > tbody > tr[id="0"] > td .tabledit-input[name="noofbrand_bud"] {
                                display: none !important;
                        }
                        #collapseTwo table#example1 > tbody > tr[id="0"] > td input[name="noofbrand_bud"] {
                                display: none !important;
                        }
                        .save-btn-td + td {
						    display: none;
						}
						table#example1 td.save-btn-td > .btn {
						    padding: 5px 10px;
						    margin-right: 1px;
						}
						.save-btn-td .btn-page {
						    padding: 5px 10px;
						}
						.new-record-btn { text-align: center;padding: 14px 0px;}
        			</style>
        			<div class="new-record-btn">
        				<button type="button" id="new_record_row" class="btn btn-info">Add New Record</button>
    				</div>
        			<div class="table-responsive">
                    <table class="table table-striped table-bordered" id="example1">
                        <thead class="thead-light">
                            <tr>';
        if(!empty($incentive_type)):
            $header_id = $incentive_type[0]->header_id;
            $headers_array = DB::table("incentive_slab_header")->select('*')->where('pid', $header_id)->get()->toArray();
            if(!empty($headers_array))
            {
                $total_no_header = $headers_array[0]->field_no;
                $table .=   '<th>#</th><th>S.No.</th>';
                if($total_no_header == 4)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>';
                }
                else if($total_no_header == 5)
                {            
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>';
                }
                else if($total_no_header == 6)
                {
                     $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>';
                }
                else if($total_no_header == 7)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>';
                }
                else if($total_no_header == 8)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>';
                }
                else if($total_no_header == 9)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>';
                }
                else if($total_no_header == 10)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>
                            <th>'.$headers_array[0]->header10.'</th>';
                }
                else if($total_no_header == 11)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>
                            <th>'.$headers_array[0]->header10.'</th>
                            <th>'.$headers_array[0]->header11.'</th>';
                }
                else if($total_no_header == 12)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>
                            <th>'.$headers_array[0]->header10.'</th>
                            <th>'.$headers_array[0]->header11.'</th>
                            <th>'.$headers_array[0]->header12.'</th>';
                }
                else if($total_no_header == 13)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>
                            <th>'.$headers_array[0]->header10.'</th>
                            <th>'.$headers_array[0]->header11.'</th>
                            <th>'.$headers_array[0]->header12.'</th>
                            <th>'.$headers_array[0]->header13.'</th>';
                }
                $table .= '<th>Action</th>';
            }
            
        endif;
        $table .=  '        </tr>
                        </thead>
                    <tbody>';
                if(!empty($incentive_type)):
                    $headers_array = DB::table("incentive_slab_header")->select('*')->where('pid', $header_id)->get()->toArray();
                    if(!empty($headers_array))
                    {
                        //print_r($headers_array); die;
                        $i = 1;
                        $total_no_header = $headers_array[0]->field_no;
                        foreach($incentive_type as $it):
                            if($total_no_header == 4 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                
                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                        </tr>';
                            }
                            else if($total_no_header == 5 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;

                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                        </tr>';

                            }
                            else if ($total_no_header == 6 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                        </tr>';
                            }
                            else if($total_no_header == 7 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;

                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                        </tr>';
                            }
                            else if($total_no_header == 8 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;

                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                        </tr>';
                            }
                            else if($total_no_header == 9 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;

                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>
                                        </tr>';
                            }
                            else if($total_no_header == 10 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;
                                $f10 = $headers_array[0]->field10;

                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>
                                            <td>'.$it->$f10.'</td>
                                        </tr>';
                            }
                            else if($total_no_header == 11 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;
                                $f10 = $headers_array[0]->field10;
                                $f11 = $headers_array[0]->field11;

                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>
                                            <td>'.$it->$f10.'</td>
                                            <td>'.$it->$f11.'</td>
                                        </tr>';
                            }
                            else if($total_no_header == 12 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;
                                $f10 = $headers_array[0]->field10;
                                $f11 = $headers_array[0]->field11;
                                $f12 = $headers_array[0]->field12;

                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>
                                            <td>'.$it->$f10.'</td>
                                            <td>'.$it->$f11.'</td>
                                            <td>'.$it->$f12.'</td>
                                        </tr>';
                            }
                            else if($total_no_header == 13 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;
                                $f10 = $headers_array[0]->field10;
                                $f11 = $headers_array[0]->field11;
                                $f12 = $headers_array[0]->field12;
                                $f13 = $headers_array[0]->field13;
                                $table .= '<tr>
                                            <td>'.$it->pid.'</td>
                                            <td>'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>
                                            <td>'.$it->$f10.'</td>
                                            <td>'.$it->$f11.'</td>
                                            <td>'.$it->$f12.'</td>
                                            <td>'.$it->$f13.'</td>
                                        </tr>';
                            }
                            $i++;
                        endforeach;
                        if($total_no_header == 4 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td class="tp"><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                        }
                        else if($total_no_header == 5 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;
                            $f5 = $headers_array[0]->field5;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></tr>';
                        }
                        else if($total_no_header == 6 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;
                            $f5 = $headers_array[0]->field5;
                       		$f6 = $headers_array[0]->field6;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></tr>';
                        }
                        else if($total_no_header == 7 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;
                            $f5 = $headers_array[0]->field5;
                       		$f6 = $headers_array[0]->field6;
                           	$f7 = $headers_array[0]->field7;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" style="display: block;" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                        }
                        else if($total_no_header == 8 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;
                            $f5 = $headers_array[0]->field5;
                       		$f6 = $headers_array[0]->field6;
                           	$f7 = $headers_array[0]->field7;
                           	$f8 = $headers_array[0]->field8;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf7="'.$f8.'" value="" ></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                        }
                        else if($total_no_header == 9 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;
                            $f5 = $headers_array[0]->field5;
                       		$f6 = $headers_array[0]->field6;
                           	$f7 = $headers_array[0]->field7;
                           	$f8 = $headers_array[0]->field8;
                           	$f9 = $headers_array[0]->field9;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf7="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf7="'.$f9.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></tr>';
                        }
                        else if($total_no_header == 10 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;
                            $f5 = $headers_array[0]->field5;
                       		$f6 = $headers_array[0]->field6;
                           	$f7 = $headers_array[0]->field7;
                           	$f8 = $headers_array[0]->field8;
                           	$f9 = $headers_array[0]->field9;
                           	$f10 = $headers_array[0]->field10;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf8="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf9="'.$f9.'" value=""></td><td><input type="text" style="display: block;" name="'.$f10.'" idf10="'.$f10.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                        }
                        else if($total_no_header == 11 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;
                            $f5 = $headers_array[0]->field5;
                       		$f6 = $headers_array[0]->field6;
                           	$f7 = $headers_array[0]->field7;
                           	$f8 = $headers_array[0]->field8;
                           	$f9 = $headers_array[0]->field9;
                           	$f10 = $headers_array[0]->field10;
                           	$f11 = $headers_array[0]->field11;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf8="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf9="'.$f9.'" value=""></td><td><input type="text" style="display: block;" name="'.$f10.'" idf10="'.$f10.'" value=""></td><td><input type="text" style="display: block;" name="'.$f11.'" idf11="'.$f11.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                        }
                        else if($total_no_header == 12 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;
                            $f5 = $headers_array[0]->field5;
                       		$f6 = $headers_array[0]->field6;
                           	$f7 = $headers_array[0]->field7;
                           	$f8 = $headers_array[0]->field8;
                           	$f9 = $headers_array[0]->field9;
                           	$f10 = $headers_array[0]->field10;
                           	$f11 = $headers_array[0]->field11;
                           	$f12 = $headers_array[0]->field12;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf8="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf9="'.$f9.'" value=""></td><td><input type="text" style="display: block;" name="'.$f10.'" idf10="'.$f10.'" value=""></td><td><input type="text" style="display: block;" name="'.$f11.'" idf11="'.$f11.'" value=""></td><td><input type="text" style="display: block;" name="'.$f12.'" idf12="'.$f12.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                        }
                        else if($total_no_header == 13 && $total_no_header != '')
                        {
                        	$f1 = $headers_array[0]->field1;
                            $f2 = $headers_array[0]->field2;
                            $f3 = $headers_array[0]->field3;
                            $f4 = $headers_array[0]->field4;
                            $f5 = $headers_array[0]->field5;
                       		$f6 = $headers_array[0]->field6;
                           	$f7 = $headers_array[0]->field7;
                           	$f8 = $headers_array[0]->field8;
                           	$f9 = $headers_array[0]->field9;
                           	$f10 = $headers_array[0]->field10;
                           	$f11 = $headers_array[0]->field11;
                           	$f12 = $headers_array[0]->field12;
                           	$f13 = $headers_array[0]->field13;

							$table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf8="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf9="'.$f9.'" value=""></td><td><input type="text" style="display: block;" name="'.$f10.'" idf10="'.$f10.'" value=""></td><td><input type="text" style="display: block;" name="'.$f11.'" idf11="'.$f11.'" value=""></td><td><input type="text" style="display: block;" name="'.$f12.'" idf12="'.$f12.'" value=""></td><td><input type="text" style="display: block;" name="'.$f13.'" idf13="'.$f13.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                        }
                    }
                    
                       
                    $table .'</tbody>
                            </table>
                        </div>';
                        $table .= '<script type="text/javascript">
                                    $(document).ready(function(){
                                    	$("table th:nth-child(1)").hide();
                                        $("table td:nth-child(1)").hide();
                                        
                                        $.ajaxSetup({
                                            headers: {
                                                "X-CSRF-Token": $("meta[name=\"csrf-token\"]").attr("content")
                                            }
                                        });
                                        $("#example1").Tabledit({
                                            url: "'.route("update-incentive-type").'",
                                            restoreButton:false,
                                            //editButton: false,
                                            columns: {
                                                identifier: [0, "pid"],';
                                                if(!empty($headers_array))
                                                {
                                                    $total_no_header = $headers_array[0]->field_no;
                                                    if($total_no_header == 4)
                                                    {
                                                    	$f1 = $headers_array[0]->field1;
							                            $f2 = $headers_array[0]->field2;
							                            $f3 = $headers_array[0]->field3;
							                            $f4 = $headers_array[0]->field4;
                                                        
                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        $table .= ']';
                                                    }
                                                    else if($total_no_header == 5)
                                                    {     		
                                                    	$f1 = $headers_array[0]->field1;
							                            $f2 = $headers_array[0]->field2;
							                            $f3 = $headers_array[0]->field3;
							                            $f4 = $headers_array[0]->field4;
							                            $f5 = $headers_array[0]->field5;       
                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        if($f5 != 'territory_type')
                                                        {
                                                            $table .= ',[6, "'.$f5.'"]';
                                                        }
                                                        $table .= ']';
                                                    }
                                                    else if($total_no_header == 6)
                                                    {
                                                    	$f1 = $headers_array[0]->field1;
							                            $f2 = $headers_array[0]->field2;
							                            $f3 = $headers_array[0]->field3;
							                            $f4 = $headers_array[0]->field4;
							                            $f5 = $headers_array[0]->field5;
							                       		$f6 = $headers_array[0]->field6;
                                                        //$table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"], [5, "'.$f4.'"], [6, "'.$f5.'"], [7, "'.$f6.'"]]';

                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        if($f5 != 'territory_type')
                                                        {
                                                            $table .= ',[6, "'.$f5.'"]';
                                                        }
                                                        if($f6 == 'noofbrand_bud')
                                                        {
                                                            
                                                        }
                                                        else if($f6 == 'min_brand')
                                                        {

                                                        }
                                                        else
                                                        {
                                                            $table .= ',[6, "'.$f6.'"]';
                                                        }

                                                        $table .= ']';
                                                    }
                                                    else if($total_no_header == 7)
                                                    {
                                                    	$f1 = $headers_array[0]->field1;
							                            $f2 = $headers_array[0]->field2;
							                            $f3 = $headers_array[0]->field3;
							                            $f4 = $headers_array[0]->field4;
							                            $f5 = $headers_array[0]->field5;
							                       		$f6 = $headers_array[0]->field6;
							                           	$f7 = $headers_array[0]->field7;
                                                        //$table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"], [5, "'.$f4.'"], [6, "'.$f5.'"], [7, "'.$f6.'"], [8, "'.$f7.'"]]';

                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        if($f5 != 'territory_type')
                                                        {
                                                            $table .= ',[6, "'.$f5.'"]';
                                                        }
                                                        if($f6 != 'min_brand'){
                                                            $table .= ',[7, "'.$f6.'"]';
                                                        }
                                                        if($f7 != 'max_brand')
                                                        {
                                                            $table .= ', [8, "'.$f7.'"]';
                                                        }
                                                        $table .= ']';
                                                    }
                                                    else if($total_no_header == 8)
                                                    {
                                                    	$f1 = $headers_array[0]->field1;
							                            $f2 = $headers_array[0]->field2;
							                            $f3 = $headers_array[0]->field3;
							                            $f4 = $headers_array[0]->field4;
							                            $f5 = $headers_array[0]->field5;
							                       		$f6 = $headers_array[0]->field6;
							                           	$f7 = $headers_array[0]->field7;
							                           	$f8 = $headers_array[0]->field8;
                                                        //$table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"], [5, "'.$f4.'"], [6, "'.$f5.'"], [7, "'.$f6.'"], [8, "'.$f7.'"]]';

                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        if($f5 != 'territory_type')
                                                        {
                                                            $table .= ',[6, "'.$f5.'"]';
                                                        }
                                                        $table .= ',[7, "'.$f6.'"], [8, "'.$f7.'"]';
                                                        $table .= ']';
                                                    }
                                                }

                                        $table .= '        
                                            },
                                            onAjax: function(action, serialize) {
                                                $(".loader").show();
                                            },
                                            onSuccess: function(data, textStatus, jqXHR) {
                                                $(".loader").hide();
                                                if(textStatus == "success")
                                                {
                                                    if(data.action == "delete")
                                                    {
                                                        if(data.success)
                                                        {
                                                            $("table#example1 tr#"+data.pid).remove();
                                                            $.alert({
                                                                title: "Success!",
                                                                content: data.success,
                                                            });
                                                        }
                                                        else if(data.errors)
                                                        {
                                                            $.alert({
                                                                title: "Errors!",
                                                                content: data.errors,
                                                            });
                                                        }
                                                    }
                                                    else  if(data.action == "edit")
                                                    {
                                                        if(data.success)
                                                        {
                                                            $.alert({
                                                                title: "Success!",
                                                                content: data.success,
                                                            });
                                                        }
                                                        else if(data.errors)
                                                        {
                                                            $.alert({
                                                                title: "Errors!",
                                                                content: data.errors,
                                                            });
                                                        }   
                                                    }
                                                }
                                            }
                                        });
                                        $("#incConfiguratorBtn").on("click", function(){
								            
								            var incentive = $("#slab_incentive_type").val();
								            var csrf_token = $("meta[name=\"csrf-token\"]").attr("content");
								            var division = $("#division").val();
								            var fin_yr = $("#financial_year").val();
								            var territory = $("input[name=territory]:checked").val();
								            var profile_role = $("#profile_role").val();
								            var app_pcent = $("table#example1 tr:last input[name=app_pcent]").val();
								            var ach_val_fr = $("table#example1 tr:last input[name=ach_val_fr]").val();
								            var ach_val_to = $("table#example1 tr:last input[name=ach_val_to]").val();
								            var app_amount = $("table#example1 tr:last input[name=app_amount]").val();
								            if(ach_val_fr != "" && ach_val_to != "")
                                        	{						            
									            if(incentive == "quarterly" || incentive == "anual_ach")
									            {
									            	var min_brand = $("table#example1 tr:last input[name=min_brand]").val();

									            	var max_brand = $("table#example1 tr:last input[name=max_brand]").val();
									            	if(min_brand <= max_brand)
									            	{
		                                                $(".loader").show();
										            	$.ajax({
										                    type: "POST",
										                    url: "'.route("save-incentive-type").'",
										                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, app_pcent:app_pcent, ach_val_fr:ach_val_fr, ach_val_to:ach_val_to,app_amount: app_amount, min_brand:min_brand, max_brand:max_brand  },
										                    success: function(res)
										                    {
										                        $(".loader").hide();
										                        if(res.errors)
										                        {
										                        	$("table#example1 tr:last .tabledit-input").css("display", "block");
										                            $.alert({
										                                title: "Errors!",
										                                content: res.errors,
										                            });
										                        }
										                        else
										                        {
										                            $("#errors").html("");
										                            $.alert({
										                                title: "Success!",
										                                content: "New Record Inserted Sucessfully.",
										                            });
										                            $("#ach_val_fr").val("");
										                            $("#ach_val_to").val("");
										                            $("#app_pcent").val("");
										                            $("#amount").val("");
										                            $("#slab_response").html(res);
										                        }
										                        
										                    }
										                });
									                }
									                else
									                {
									                	$.alert({
							                                title: "Errors!",
							                                content: "Min Brand must be less then Max Brand",
							                            });	
									                }
									            }
									            else if(incentive == "anual_inc")
									            {
									            	var b_pmpt_fr = $("table#example1 tr:last input[name=b_pmpt_fr]").val();

									            	var b_pmpt_to = $("table#example1 tr:last input[name=b_pmpt_to]").val();
	                                                $(".loader").show();
									            	$.ajax({
									                    type: "POST",
									                    url: "'.route("save-incentive-type").'",
									                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, app_pcent:app_pcent, ach_val_fr:ach_val_fr, ach_val_to:ach_val_to, app_amount: app_amount, b_pmpt_fr:b_pmpt_fr, b_pmpt_to:b_pmpt_to  },
									                    success: function(res)
									                    {
									                        $(".loader").hide();
									                        if(res.errors)
									                        {
									                        	$("table#example1 tr:last .tabledit-input").css("display", "block");
									                            $.alert({
									                                title: "Errors!",
									                                content: res.errors,
									                            });
									                        }
									                        else
									                        {
									                            $("#errors").html("");
									                            $.alert({
									                                title: "Success!",
									                                content: "New Record Inserted Sucessfully.",
									                            });
									                            $("#ach_val_fr").val("");
									                            $("#ach_val_to").val("");
									                            $("#app_pcent").val("");
									                            $("#amount").val("");
									                            $("#slab_response").html(res);
									                        }
									                    }
									                });
									            }
									            else if(incentive == "brandqtr")
									            {
									                var brand_options = $("#brand_options").val();
	                                                $(".loader").show();
									                $.ajax({
									                    type: "POST",
									                    url: "'.route("save-incentive-type").'",
									                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, app_pcent:app_pcent, ach_val_fr:ach_val_fr, ach_val_to:ach_val_to, app_amount: app_amount, brand_options:brand_options },
									                    success: function(res)
									                    {
									                        $(".loader").hide();
									                        if(res.errors)
									                        {
									                            $.alert({
									                                title: "Errors!",
									                                content: res.errors,
									                            });
									                        }
									                        else
									                        {
									                            $("#errors").html("");
									                            $.alert({
									                                title: "Success!",
									                                content: "New Record Inserted Sucessfully.",
									                            });
									                            $("#ach_val_fr").val("");
									                            $("#ach_val_to").val("");
									                            $("#app_pcent").val("");
									                            $("#amount").val("");
									                            $("#slab_response").html(res);
									                        }
								                        }
									                });
									            }
								            }
								            else
								            {
								            	$.alert({
					                                title: "Errors!",
					                                content: "Please enter Achieved Value FROM and Achieved Value TO",
					                            });
								            }
                                    });

								        jQuery("#collapseTwo table#example1 tbody tr:last").hide();
                                        jQuery("#collapseTwo table#example1 tbody button.tabledit-edit-button").css("display", "none");

								        jQuery("#new_record_row").on("click", function(){
                                            var last_to_slab = $("#collapseTwo table#example1 tbody tr:last").prev().find("input[name=ach_val_to]").val();
                                            jQuery("#collapseTwo table#example1 tbody tr:last input[name=territory_type]").css("display", "none");

                                            jQuery("#collapseTwo table#example1 tbody tr:last input[type=\"text\"]").val("");

								        	jQuery("#collapseTwo table#example1 tbody tr:last").show();
	                                        jQuery("#collapseTwo table#example1 tbody tr:last input[type=\"text\"]").removeAttr("disabled");
	                                        jQuery("#collapseTwo table#example1 tbody tr:last input[type=\"text\"]").css("display", "block");
	                                        jQuery("#collapseTwo table#example1 tbody tr:last input[type=\"text\"]:first").focus();
	                                        jQuery("#collapseTwo table#example1 tbody tr:last").attr("id","0");
                                        });

                                        jQuery("#incConfiguratorRemoveBtn").on("click", function(){
                                        	jQuery("#collapseTwo table#example1 tbody tr:last").hide();
                                    	});
                                    	jQuery(".tabledit-edit-button").on("click", function(){
                                        	jQuery("#collapseTwo table#example1 tbody tr:last").hide();
                                    	});
                                    });
                                </script>';
                else:
                    $table  .= '<tr ><td>!!Record Not Found!!</td></tr>';
                    $table .'</tbody>
                            </table>
                        </div>';
                endif;
        echo $table;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function incentive_type_prospective(Request $request)
    {
    	if(Auth::user()->usertype == 0)
    	{
    		return abort(404);
    	}
        //DB::enableQueryLog();
        $profileid = $request['profile_role'];
        $division = $request['division'];
        $fyear = $request['fin_yr'];
        $territory = $request['territory'];
        $incentive = $request['incentive'];
        $t = '';

        $intima_type = ($division == '14') ? $request['intima_type'] : '';
        
        if(isset($request['brand_val']) && $request['brand_val'] != '')
        {
            if($incentive == 'brandqtr')
            {
                $incentive = 'quarterly';
            }
            $brand_val = $request['brand_val'];

            if($territory != 'all')
            {
                $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('territory_type', $territory)->where('profileid', $profileid)->where('noofbrand_bud', $brand_val)->where('incentive_type', $incentive)->where("txn_no", 1)->get()->toArray();
            }
            else
            {
                $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('profileid', $profileid)->where('noofbrand_bud', $brand_val)->where('incentive_type', $incentive)->where("txn_no", 1)->get()->toArray();
            }
        }
        else
        {
            if($territory != 'all')
            {
                if($division == '14')
                {
                    $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('territory_type', $territory)->where('profileid', $profileid)->where('incentive_type', $incentive)->where('group_code', $intima_type)->where("txn_no", 1)->get()->toArray();
                }
                else
                {
                    $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('territory_type', $territory)->where('profileid', $profileid)->where('incentive_type', $incentive)->where('group_code', '<>', 5)->where("txn_no", 1)->get()->toArray(); 
                }
            }
            else
            {
                if($division == '14')
                {
                    $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('profileid', $profileid)->where('incentive_type', $incentive)->where('group_code', $intima_type)->where("txn_no", 1)->get()->toArray();
                }
                else 
                {
                    $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('profileid', $profileid)->where('incentive_type', $incentive)->where('group_code', '<>', 5)->where("txn_no", 1)->get()->toArray();
                }
            }
        }
        /*$query = DB::getQueryLog();
            dd($query);
        echo "<pre>";
        print_r($incentive_type); die;*/
        //dd($sd);
        //echo "<pre>"; print_r($request->all()); die;

        //$incentive_type = $request->input('incentive_type');
        //echo "<pre>"; print_r($incentive_type); die;
        $prospective_percent = '';
        $esv_pcent = '';
        $exp_qual = '';
        if(!empty($incentive_type)){
            $header_id = $incentive_type[0]->header_id;
            $headers_array = DB::table("incentive_slab_header")->select('*')->where('pid', $header_id)->get()->toArray();
            if(!empty($headers_array))
            {
                foreach($incentive_type as $it)
                {
                    $prospective_percent = $it->pearn_pcent;
                    $esv_pcent = $it->esv_pcent;
                    $exp_qual = $it->exp_pcent;
                }
            }
        }
        if($request['incentive'] == 'brandqtr')
        {
            $t = ', <strong>Weightage Avg ESV:</strong> <input type="text" id="weightage_avg_esv" style="width: 9%" name="weightage_avg_esv" value="'.$esv_pcent.'"> % ,  <strong>Expected Qualifier:</strong> <input type="text" id="expected_qualifier" style="width: 9%" name="expected_qualifier" value="'.$exp_qual.'"> % ';
        }
        $table = '';
        $total_no_header = '';
        $headers_array = [];
        $table .= '<style>table#example1 > caption { text-align: right !important; } .btn-medium { padding: 3px 8px; font-size: 13px;}</style>
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="example1">
                        <caption><strong>Prospective Percentage: </strong><input type="text" name="prospective_percent" style="width: 9%" id="prospective_percent" value="'.$prospective_percent.'"> %  '.$t. '  <button type="button" class="btn btn-success btn-medium" id="prospective_percent_btn"><i class="fa fa-save"></i> Save</button></caption>
                        <thead class="thead-light">
                            <tr>';
        if(!empty($incentive_type)):
            $header_id = $incentive_type[0]->header_id;
            $headers_array = DB::table("incentive_slab_header")->select('*')->where('pid', $header_id)->get()->toArray();
            //echo "<pre>"; print_r($headers_array); die;
            if(!empty($headers_array))
            {
                $total_no_header = $headers_array[0]->field_no;
                $flag = $headers_array[0]->flag;
                $table .=   '<th>S.No.</th>';
                if($total_no_header == 4)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>';
                }
                else if($total_no_header == 5)
                {            
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>';
                }
                else if($total_no_header == 6)
                {
                     $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>';
                }
                else if($total_no_header == 7)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>';
                }
                else if($total_no_header == 8)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>';
                }
                else if($total_no_header == 9)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>';
                }
                else if($total_no_header == 10)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>
                            <th>'.$headers_array[0]->header10.'</th>';
                }
                else if($total_no_header == 11)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>
                            <th>'.$headers_array[0]->header10.'</th>
                            <th>'.$headers_array[0]->header11.'</th>';
                }
                else if($total_no_header == 12)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>
                            <th>'.$headers_array[0]->header10.'</th>
                            <th>'.$headers_array[0]->header11.'</th>
                            <th>'.$headers_array[0]->header12.'</th>';
                }
                else if($total_no_header == 13)
                {
                    $table .= '<th>'.$headers_array[0]->header1.'</th>
                            <th>'.$headers_array[0]->header2.'</th>
                            <th>'.$headers_array[0]->header3.'</th>
                            <th>'.$headers_array[0]->header4.'</th>
                            <th>'.$headers_array[0]->header5.'</th>
                            <th>'.$headers_array[0]->header6.'</th>
                            <th>'.$headers_array[0]->header7.'</th>
                            <th>'.$headers_array[0]->header8.'</th>
                            <th>'.$headers_array[0]->header9.'</th>
                            <th>'.$headers_array[0]->header10.'</th>
                            <th>'.$headers_array[0]->header11.'</th>
                            <th>'.$headers_array[0]->header12.'</th>
                            <th>'.$headers_array[0]->header13.'</th>';
                }
                if($flag == 1)
                {
                    $table .= '<th>Prospective Factor</th>';    
                }
                
            }
            
        endif;
        $table .=  '        </tr>
                        </thead>
                    <tbody>';
                if(!empty($incentive_type)):
                    $headers_array = DB::table("incentive_slab_header")->select('*')->where('pid', $header_id)->get()->toArray();
                    if(!empty($headers_array))
                    {
                        //print_r($headers_array); die;
                        $i = 1;
                        $pids_arr = [];
                        $total_no_header = $headers_array[0]->field_no;
                        $flag = $headers_array[0]->flag;
                        $flag_field_name = $headers_array[0]->flag_field;
                        foreach($incentive_type as $it):
                            $pids_arr[] = $it->pid;
                            if($total_no_header == 4 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                
                                $table .= '<tr>
                                            <td>
                                            <input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>';
                                            if($flag == 1)
                                            {
                                              $table .= '<td><input type="text" name="prospective_earn_val" pid="'.$it->pid.'" class="pros_earn_val" style="width: 50%" value="'.$it->$flag_field_name.'" ></td>';   
                                            }
                                $table .= '</tr>';
                            }
                            else if($total_no_header == 5 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;

                                $table .= '<tr>
                                           <td><input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>';
                                            if($flag == 1)
                                            {
                                              $table .= '<td><input type="text" name="prospective_earn_val" pid="'.$it->pid.'" class="pros_earn_val" style="width: 50%" value="'.$it->$flag_field_name.'" ></td>';   
                                            }
                                $table .= '</tr>';

                            }
                            else if ($total_no_header == 6 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $table .= '<tr>
                                            <td><input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>';
                                            if($flag == 1)
                                            {
                                              $table .= '<td><input type="text" name="prospective_earn_val" pid="'.$it->pid.'" class="pros_earn_val" style="width: 50%" value="'.$it->$flag_field_name.'" ></td>';  
                                            }
                                $table .= '</tr>';
                            }
                            else if($total_no_header == 7 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;

                                $table .= '<tr>
                                            <td><input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>';
                                            if($flag == 1)
                                            {
                                              $table .= '<td><input type="text" name="prospective_earn_val" pid="'.$it->pid.'" class="pros_earn_val" style="width: 50%" value="'.$it->$flag_field_name.'" ></td>';   
                                            }
                                $table .= '</tr>';
                            }
                            else if($total_no_header == 8 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;

                                $table .= '<tr>
                                            <td><input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>';
                                            if($flag == 1)
                                                {
                                                  $table .= '<td><input type="text" name="prospective_earn_val" class="pros_earn_val" style="width: 50%" pid="'.$it->pid.'" value="'.$it->$flag_field_name.'" ></td>';   
                                                }
                                    $table .= '</tr>';
                            }
                            else if($total_no_header == 9 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;

                                $table .= '<tr>
                                            <td><input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>';
                                            if($flag == 1)
                                            {
                                                $table .= '<td><input type="text" name="prospective_earn_val" class="pros_earn_val" style="width: 50%" pid="'.$it->pid.'" value="'.$it->$flag_field_name.'" ></td>';   
                                            }
                                $table .= '</tr>';
                            }
                            else if($total_no_header == 10 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;
                                $f10 = $headers_array[0]->field10;

                                $table .= '<tr>
                                            <td><input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>
                                            <td>'.$it->$f10.'</td>';
                                            if($flag == 1)
                                            {
                                                $table .= '<td><input type="text" name="prospective_earn_val" class="pros_earn_val" style="width: 50%" pid="'.$it->pid.'" value="'.$it->$flag_field_name.'" ></td>';   
                                            }
                                $table .= '</tr>';
                            }
                            else if($total_no_header == 11 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;
                                $f10 = $headers_array[0]->field10;
                                $f11 = $headers_array[0]->field11;

                                $table .= '<tr>
                                            <td><input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>
                                            <td>'.$it->$f10.'</td>
                                            <td>'.$it->$f11.'</td>';
                                            if($flag == 1)
                                            {
                                                $table .= '<td><input type="text" name="prospective_earn_val" class="pros_earn_val" style="width: 50%" pid="'.$it->pid.'" value="'.$it->$flag_field_name.'" ></td>';   
                                            }
                                $table .= '</tr>';
                            }
                            else if($total_no_header == 12 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;
                                $f10 = $headers_array[0]->field10;
                                $f11 = $headers_array[0]->field11;
                                $f12 = $headers_array[0]->field12;

                                $table .= '<tr>
                                            <td><input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>
                                            <td>'.$it->$f10.'</td>
                                            <td>'.$it->$f11.'</td>
                                            <td>'.$it->$f12.'</td>';
                                            if($flag == 1)
                                            {
                                                $table .= '<td><input type="text" name="prospective_earn_val" class="pros_earn_val" style="width: 50%" pid="'.$it->pid.'" value="'.$it->$flag_field_name.'" ></td>';   
                                            }
                                $table .= '</tr>';
                            }
                            else if($total_no_header == 13 && $total_no_header != '')
                            {
                                $f1 = $headers_array[0]->field1;
                                $f2 = $headers_array[0]->field2;
                                $f3 = $headers_array[0]->field3;
                                $f4 = $headers_array[0]->field4;
                                $f5 = $headers_array[0]->field5;
                                $f6 = $headers_array[0]->field6;
                                $f7 = $headers_array[0]->field7;
                                $f8 = $headers_array[0]->field8;
                                $f9 = $headers_array[0]->field9;
                                $f10 = $headers_array[0]->field10;
                                $f11 = $headers_array[0]->field11;
                                $f12 = $headers_array[0]->field12;
                                $f13 = $headers_array[0]->field13;
                                $table .= '<tr>
                                            <td><input type="hidden" name="pid" class="pid" value="'.$it->pid.'" >'.$i.'</td>
                                            <td>'.$it->$f1.'</td>
                                            <td>'.$it->$f2.'</td>
                                            <td>'.$it->$f3.'</td>
                                            <td>'.$it->$f4.'</td>
                                            <td>'.$it->$f5.'</td>
                                            <td>'.$it->$f6.'</td>
                                            <td>'.$it->$f7.'</td>
                                            <td>'.$it->$f8.'</td>
                                            <td>'.$it->$f9.'</td>
                                            <td>'.$it->$f10.'</td>
                                            <td>'.$it->$f11.'</td>
                                            <td>'.$it->$f12.'</td>
                                            <td>'.$it->$f13.'</td>';
                                            if($flag == 1)
                                            {
                                                $table .= '<td><input type="text" name="prospective_earn_val" class="pros_earn_val" style="width: 50%" pid="'.$it->pid.'" value="'.$it->$flag_field_name.'"></td>';   
                                            }
                                $table .= '</tr>';
                            }

                            $i++;
                        endforeach;
                        if(!empty($pids_arr))
                        {
                            $pids_val = implode(',', $pids_arr);
                            $table .= '<input type="hidden" name="pids_pros_perc" id="pids_pros_perc" value="'.$pids_val.'">';
                        }
                    }
                    $table .='</tbody>
                            </table>
                        </div>';
                else:
                    $table  .= '<tr ><td>!!Record Not Found!!</td></tr>';
                    $table .'</tbody>
                            </table>
                        </div>';
                endif;
            $table .='<script type="text/javascript">
                            $(document).ready(function(){
                                $("#inc-table").hide();
                                /* $(".pros_earn_val").on("keyup", function(){
                                    
                                    var per_earn_val = $(this).val();
                                    var single_pros_ear = [];
                                    if($.isNumeric(per_earn_val))
                                    {
                                        $(".loader").show();

                                        var pid = $(this).attr("pid");
                                        var csrf_token = $(\'meta[name="csrf-token"]\').attr("content");
                                        $.ajax({
                                            url: "'.route('single-save-prospective').'",
                                            type: "post",
                                            data: {per_earn_val:per_earn_val,pid:pid,_token: csrf_token},
                                            success: function(res){
                                                $(".loader").hide();
                                                if(res.errors)
                                                {
                                                    $.alert({
                                                        title: "Errors!",
                                                        content: res.errors,
                                                    });
                                                }
                                                else
                                                {
                                                    $("#errors").html("");
                                                    $.alert({
                                                        title: "Success!",
                                                        content: res.success,
                                                    });
                                                }
                                            },
                                        });
                                    }
                                    else
                                    {
                                        $.alert({
                                                title: "Errors!",
                                                content: "Please enter valid number.",
                                            });
                                    } 
                                }); */
                                $("#prospective_percent_btn").on("click", function(){
                                    var single_pros_ear = [];
                                    var pros_earn_perc_val = $("#prospective_percent").val();
                                    var weightage_avg_esv = $("#weightage_avg_esv").val();
                                    var expected_qualifier = $("#expected_qualifier").val();
                                    if($.isNumeric(pros_earn_perc_val))
                                    {
                                        $(".loader").show();
                                        var pids = $("#pids_pros_perc").val();
                                        $(".pros_earn_val").each(function() {
										    var pid = $(this).attr("pid");
										    var pid_val = $(this).val();
										    var pid_and_val = pid+"#"+pid_val;
										    single_pros_ear.push(pid_and_val);
										});
										
										var csrf_token = $(\'meta[name="csrf-token"]\').attr("content");
                                        $.ajax({
                                            url: "'.route('all-save-prospective-perc').'",
                                            type: "post",
                                            data: {pros_earn_perc_val:pros_earn_perc_val,pids:pids,_token: csrf_token, single_pros_ears: single_pros_ear, esv_pcent: weightage_avg_esv, expected_qualifier: expected_qualifier},
                                            success: function(res){
                                                $(".loader").hide();
                                                if(res.errors)
                                                {
                                                    $.alert({
                                                        title: "Errors!",
                                                        content: res.errors,
                                                    });
                                                }
                                                else
                                                {
                                                    $("#errors").html("");
                                                    $.alert({
                                                        title: "Success!",
                                                        content: res.success,
                                                    });
                                                }
                                            },
                                        });
                                    }
                                    else
                                    {
                                        $.alert({
                                                title: "Errors!",
                                                content: "Please enter valid number.",
                                            });
                                    }     
                                });
                            });
                        </script>';
        echo $table;
    }

    public function single_save_prospective(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); die;
        $validator = \Validator::make($request->all(), [
            //'pid' => 'required|regex:/^\d*(\.\d{1,2})?$/|',
            'pid' => 'required|integer|between:0,100',
            'per_earn_val' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $pid = $request['pid'];
        $per_earn_val = $request['per_earn_val'];


        $aff_row = DB::table('incentive_slab_ram')->where('pid', $pid)->update(['pearn_factor' => $per_earn_val]);
        if($aff_row)
        {
            return response()->json(['success'=> "Prospective factor has been updated."]);
        }
    }

    public function all_save_prospective_perc(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); die;
        $validator = \Validator::make($request->all(), [
            'pids' => 'required',
            'pros_earn_perc_val' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $pids = $request['pids'];
        $pros_earn_perc_val = $request['pros_earn_perc_val'];
        $single_pros_ears = $request['single_pros_ears'];
		$esv_pcent = (isset($request['esv_pcent']) && $request['esv_pcent'] != '') ? $request['esv_pcent'] : '';
        $expected_qualifier = (isset($request['expected_qualifier']) && $request['expected_qualifier'] != '') ? $request['expected_qualifier'] : '';   
        if($single_pros_ears != '')
        {
        	for($j=0;$j< count($single_pros_ears);$j++){
        		$single_pros_ears_array = explode('#', $single_pros_ears[$j]);

        		DB::table('incentive_slab_ram')->where('pid', $single_pros_ears_array[0])->update(['pearn_factor' => $single_pros_ears_array[1]]);
    		}
    		
        }

        if($pids != '')
        {
            $pids_array = explode(',', $pids);
            
            if(!empty($pids_array))
            {
                for ($i=0; $i < count($pids_array); $i++) { 
                    DB::table('incentive_slab_ram')->where('pid', $pids_array[$i])->update(['pearn_pcent' => $pros_earn_perc_val, 'esv_pcent' => $esv_pcent, 'exp_pcent' => $expected_qualifier]);
                }
                return response()->json(['success'=> "Prospective percentage has been updated"]);
            }
            else
            {
               return response()->json(['errors'=> "Something went wrong"]); 
            }
        }
    }

    public function save_incentive_slab(Request $request)
    {
        //echo "<pre>"; print_r($request->all()); die;
        $validator = \Validator::make($request->all(), [
            'ach_val_fr' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'ach_val_to' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            //'app_pcent'  => 'regex:/^\d*(\.\d{1,2})?$/',
            //'app_amount' => 'regex:/^\d*(\.\d{1,2})?$/'
        ]);
        
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $b_pmpt_fr = 0.00;
    	$b_pmpt_to = 0.00;
    	$min_brand = 0;
    	$max_brand = 0;
        $ach_val_fr = $request['ach_val_fr'];
        $ach_val_to = $request['ach_val_to'];
        if (!is_float($ach_val_fr))
        {
          $ach_val_fr = sprintf('%0.2f', $ach_val_fr);
        }
        if (!is_float($ach_val_to))
        {
          $ach_val_to = sprintf('%0.2f', $ach_val_to);
        }
        $app_pcent  = 0;
        $app_amount = 0;
        if($request['app_pcent'] != '')
        {
            $app_pcent  = $request['app_pcent'];
        }
        if($request['app_amount'] != '')
        {
            $app_amount = $request['app_amount'];
        }   
        $fyear      = $request['fin_yr'];
        $territory = $request['territory'];
        $profileid  = $request['profile_role'];
        $incentivetype = $request['incentive'];
        $division = $request['division'];
        $brand_options = '';
        $group_code = 1;
        $intima_type = ($division == '14') ? $request['intima_type'] : '';
        if($intima_type != '')
        {
            $group_code = $intima_type;
        }
        $header_id = 1;
        if($profileid == '7')
        {
            $territory = '';
        }
        else if($profileid == '8')
        {
            $territory = '';
        }

        //echo $app_amount."#".$app_pcent; die;
        if($ach_val_fr >= 0 && $ach_val_fr < $ach_val_to)
        {
            if($incentivetype != 'brandqtr')
            {
                $incetiveSlab = DB::table("incentive_slab_ram")->select("*")->where('fyear', $fyear)->where('territory_type', $territory)->where('incentive_type', $incentivetype)->where('profileid', $profileid)->where('divisionid', $division)->where('group_code', '<>', 5)->where('txn_no', 1)->orderBy("pid", "DESC")->get()->toArray();
            }
            else
            {
                if($incentivetype == 'brandqtr')
                {
                    $incentive = 'quarterly';
                }
                $brand_val = $request['brand_options'];

                if($territory != 'all')
                {
                    $incetiveSlab = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('territory_type', $territory)->where('profileid', $profileid)->where('noofbrand_bud', $brand_val)->where('incentive_type', $incentive)->where("txn_no", 1)->orderBy("pid", "DESC")->get()->toArray();
                        //echo "<pre>";print_r($incetiveSlab); die;
                }
                else
                {
                    $incetiveSlab = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('profileid', $profileid)->where('noofbrand_bud', $brand_val)->where('incentive_type', $incentive)->where("txn_no", 1)->orderBy("pid", "DESC")->get()->toArray();
                }
                //$incetiveSlab = DB::table("incentive_slab_ram")->select("*")->where('fyear', $fyear)->where('territory_type', $territory)->where('incentive_type', $incentivetype)->where('profileid', $profileid)->where('divisionid', $division)->where('group_code', '<>', 5)->where('txn_no', 1)->orderBy("pid", "DESC")->get()->toArray();
            }
            //print_r($incetiveSlab);die;
            if(!empty($incetiveSlab))
            {   
                $isb = $incetiveSlab[0];
                $header_id = $isb->header_id;
                if($incentivetype == 'brandqtr')
                {
                    $brand_options    = $request['brand_options'];
                    $group_code = 5;
                    $incentivetype = 'quarterly';
                }
                else if($incentivetype == 'anual_ach' || $incentivetype == 'quarterly')
                {
                    $min_brand = $request['min_brand'];
                    $max_brand = $request['max_brand'];
                }
                else if($incentivetype == 'anual_inc')
                {
                    $b_pmpt_fr = $request['b_pmpt_fr'];
                    $b_pmpt_to = $request['b_pmpt_to'];
                }

                //foreach ($incetiveSlab as $isb)
                //{   
                //echo 'isbfrom'.$isb->ach_val_fr.'#'.$ach_val_fr.'#isbto'.$isb->ach_val_to.'<br>';
                if(($ach_val_fr > $isb->ach_val_fr && $ach_val_fr == $isb->ach_val_to) && ($ach_val_to > $isb->ach_val_to))
                {
                    //return response()->json(['errors' => 'Incentive slab rang is already defined.']);
                }
                else if($isb->ach_val_fr == $ach_val_fr && $ach_val_to == $isb->ach_val_to)
                {

                    if($incentivetype == 'anual_inc')
                    {
                        if($isb->b_pmpt_fr == $b_pmpt_fr && $isb->b_pmpt_to == $b_pmpt_to)
                        {
                            return response()->json(['errors' => 'Incentive slab rang is already defined.']);
                        }
                    }
                    else if($incentivetype == 'quarterly')
                    {
                    	if($isb->min_brand == $min_brand && $isb->max_brand == $max_brand)
                        {
                            return response()->json(['errors' => 'Incentive slab rang is already defined.']);
                        }
                    }
                    else
                    {
                        return response()->json(['errors' => 'Incentive slab rang is already defined.']);
                    }
                }
                else
                {
                    return response()->json(['errors' => 'Incentive slab rang is invalid.']);
                }
                //}
            }
        	
            $territory_code = '0';
            
            $quarterid = 1;
            $var_pcent = 0;
            $app_amount2 = $app_amount;
            $app_amount3 = 0;
            $app_amount4 = 0;
            
            $txn_no = 1;
            $txn_date = date('Y-m-d H:i:s');
            $deleted = 0;
            $pearn_pcent = 0;
            $pearn_factor = 0;

            $id = DB::table('incentive_slab_ram')->insertGetId(
                ['divisionid' => $division, 'ach_val_fr' => $ach_val_fr, 'ach_val_to' => $ach_val_to, 'app_pcent' => $app_pcent, 'app_amount' => $app_amount, 'fyear' => $fyear, 'noofbrand_bud' => $brand_options, 'territory_type' => $territory, 'profileid' => $profileid, 'incentive_type' => $incentivetype, 'territory_code' => $territory_code, 'group_code' => $group_code, 'quarterid' => $quarterid, 'var_pcent' => $var_pcent, 'app_amount2' => $app_amount2, 'app_amount3' => $app_amount3, 'app_amount4' => $app_amount4, 'b_pmpt_fr' => $b_pmpt_fr, 'b_pmpt_to' => $b_pmpt_to, 'txn_no' => $txn_no, 'txn_date' => $txn_date, 'deleted' => $deleted, 'pearn_pcent' => $pearn_pcent, 'pearn_factor' => $pearn_factor, 'header_id' => $header_id, 'min_brand' => $min_brand, 'max_brand' => $max_brand]);
            if($id)
            {
                if(isset($request['brand_options']) && $request['brand_options'] != '')
                {
                    if($request['incentive'] == 'brandqtr')
                    {
                        $incentivetype = 'quarterly';
                    }
                    $brand_val = $request['brand_options'];

                    if($territory != 'all')
                    {
                        $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('territory_type', $territory)->where('profileid', $profileid)->where('noofbrand_bud', $brand_val)->where('incentive_type', $incentivetype)->where("txn_no", 1)->get()->toArray();
                    }
                    else
                    {
                        $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('profileid', $profileid)->where('noofbrand_bud', $brand_val)->where('incentive_type', $incentivetype)->where("txn_no", 1)->get()->toArray();
                    }
                }
                else
                {
                    if($territory != 'all')
                    {
                        $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('territory_type', $territory)->where('profileid', $profileid)->where('incentive_type', $incentivetype)->where('group_code', '<>', 5)->where("txn_no", 1)->get()->toArray();
                    }
                    else
                    {
                        $incentive_type = DB::table("incentive_slab_ram")->select('*')->where('divisionid', $division)->where('fyear', $fyear)->where('profileid', $profileid)->where('incentive_type', $incentivetype)->where('group_code', '<>', 5)->where("txn_no", 1)->get()->toArray();
                    }
                }
                /*$query = DB::getQueryLog();
                    dd($query);
                echo "<pre>";
                print_r($incentive_type); die;*/
                //dd($sd);
                //echo "<pre>"; print_r($request->all()); die;

                //$incentive_type = $request->input('incentive_type');
                //echo "<pre>"; print_r($incentive_type); die;
                $table = '';
                $total_no_header = '';
                $headers_array = [];
                $table .= '<style>
                                #collapseTwo table#example1 > tbody > tr[id="0"] > td .tabledit-input[value=""] {
                                    display: block !important;
                                    margin: 0 !important;
                                }
                                #collapseTwo table#example1 > tbody > tr[id="0"] td.tp input[name="territory_type"]{
                                        display: none !important;
                                    }

                                #collapseTwo table#example1 > tbody > tr[id=""] > td button.tabledit-edit-button, #collapseTwo table#example1 > tbody > tr[id="0"] > td button.tabledit-delete-button {
                                    display: none;
                                }
                                #collapseTwo table#example1 > tbody > tr[id="0"] > td .tabledit-input[name="noofbrand_bud"] {
                                        display: none !important;
                                }
                                .save-btn-td + td {
                                    display: none;
                                }
                                table#example1 td.save-btn-td > .btn {
                                    padding: 5px 10px;
                                    margin-right: 1px;
                                }
                                .save-btn-td .btn-page {
                                    padding: 5px 10px;
                                }
                                .new-record-btn { text-align: center;padding: 14px 0px;}
                            </style>
                            <div class="new-record-btn">
                                <button type="button" id="new_record_row" class="btn btn-info">Add New Record</button>
                            </div>
                            <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="example1">
                                <thead class="thead-light">
                                    <tr>';
                if(!empty($incentive_type)):
                    $header_id = $incentive_type[0]->header_id;
                    $headers_array = DB::table("incentive_slab_header")->select('*')->where('pid', $header_id)->get()->toArray();
                    if(!empty($headers_array))
                    {
                        $total_no_header = $headers_array[0]->field_no;
                        $table .=   '<th>#</th><th>S.No.</th>';
                        if($total_no_header == 4)
                        {
                            $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>';
                        }
                        else if($total_no_header == 5)
                        {            
                            $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>
                                    <th>'.$headers_array[0]->header5.'</th>';
                        }
                        else if($total_no_header == 6)
                        {
                             $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>
                                    <th>'.$headers_array[0]->header5.'</th>
                                    <th>'.$headers_array[0]->header6.'</th>';
                        }
                        else if($total_no_header == 7)
                        {
                            $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>
                                    <th>'.$headers_array[0]->header5.'</th>
                                    <th>'.$headers_array[0]->header6.'</th>
                                    <th>'.$headers_array[0]->header7.'</th>';
                        }
                        else if($total_no_header == 8)
                        {
                            $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>
                                    <th>'.$headers_array[0]->header5.'</th>
                                    <th>'.$headers_array[0]->header6.'</th>
                                    <th>'.$headers_array[0]->header7.'</th>
                                    <th>'.$headers_array[0]->header8.'</th>';
                        }
                        else if($total_no_header == 9)
                        {
                            $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>
                                    <th>'.$headers_array[0]->header5.'</th>
                                    <th>'.$headers_array[0]->header6.'</th>
                                    <th>'.$headers_array[0]->header7.'</th>
                                    <th>'.$headers_array[0]->header8.'</th>
                                    <th>'.$headers_array[0]->header9.'</th>';
                        }
                        else if($total_no_header == 10)
                        {
                            $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>
                                    <th>'.$headers_array[0]->header5.'</th>
                                    <th>'.$headers_array[0]->header6.'</th>
                                    <th>'.$headers_array[0]->header7.'</th>
                                    <th>'.$headers_array[0]->header8.'</th>
                                    <th>'.$headers_array[0]->header9.'</th>
                                    <th>'.$headers_array[0]->header10.'</th>';
                        }
                        else if($total_no_header == 11)
                        {
                            $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>
                                    <th>'.$headers_array[0]->header5.'</th>
                                    <th>'.$headers_array[0]->header6.'</th>
                                    <th>'.$headers_array[0]->header7.'</th>
                                    <th>'.$headers_array[0]->header8.'</th>
                                    <th>'.$headers_array[0]->header9.'</th>
                                    <th>'.$headers_array[0]->header10.'</th>
                                    <th>'.$headers_array[0]->header11.'</th>';
                        }
                        else if($total_no_header == 12)
                        {
                            $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>
                                    <th>'.$headers_array[0]->header5.'</th>
                                    <th>'.$headers_array[0]->header6.'</th>
                                    <th>'.$headers_array[0]->header7.'</th>
                                    <th>'.$headers_array[0]->header8.'</th>
                                    <th>'.$headers_array[0]->header9.'</th>
                                    <th>'.$headers_array[0]->header10.'</th>
                                    <th>'.$headers_array[0]->header11.'</th>
                                    <th>'.$headers_array[0]->header12.'</th>';
                        }
                        else if($total_no_header == 13)
                        {
                            $table .= '<th>'.$headers_array[0]->header1.'</th>
                                    <th>'.$headers_array[0]->header2.'</th>
                                    <th>'.$headers_array[0]->header3.'</th>
                                    <th>'.$headers_array[0]->header4.'</th>
                                    <th>'.$headers_array[0]->header5.'</th>
                                    <th>'.$headers_array[0]->header6.'</th>
                                    <th>'.$headers_array[0]->header7.'</th>
                                    <th>'.$headers_array[0]->header8.'</th>
                                    <th>'.$headers_array[0]->header9.'</th>
                                    <th>'.$headers_array[0]->header10.'</th>
                                    <th>'.$headers_array[0]->header11.'</th>
                                    <th>'.$headers_array[0]->header12.'</th>
                                    <th>'.$headers_array[0]->header13.'</th>';
                        }
                        $table .= '<th>Action</th>';
                    }
                    
                endif;
                $table .=  '        </tr>
                                </thead>
                            <tbody>';
                        if(!empty($incentive_type)):
                            $headers_array = DB::table("incentive_slab_header")->select('*')->where('pid', $header_id)->get()->toArray();
                            if(!empty($headers_array))
                            {
                                //print_r($headers_array); die;
                                $i = 1;
                                $total_no_header = $headers_array[0]->field_no;
                                foreach($incentive_type as $it):
                                    if($total_no_header == 4 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        
                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                </tr>';
                                    }
                                    else if($total_no_header == 5 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        $f5 = $headers_array[0]->field5;

                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                    <td>'.$it->$f5.'</td>
                                                </tr>';

                                    }
                                    else if ($total_no_header == 6 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        $f5 = $headers_array[0]->field5;
                                        $f6 = $headers_array[0]->field6;
                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                    <td>'.$it->$f5.'</td>
                                                    <td>'.$it->$f6.'</td>
                                                </tr>';
                                    }
                                    else if($total_no_header == 7 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        $f5 = $headers_array[0]->field5;
                                        $f6 = $headers_array[0]->field6;
                                        $f7 = $headers_array[0]->field7;

                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                    <td>'.$it->$f5.'</td>
                                                    <td>'.$it->$f6.'</td>
                                                    <td>'.$it->$f7.'</td>
                                                </tr>';
                                    }
                                    else if($total_no_header == 8 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        $f5 = $headers_array[0]->field5;
                                        $f6 = $headers_array[0]->field6;
                                        $f7 = $headers_array[0]->field7;
                                        $f8 = $headers_array[0]->field8;

                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                    <td>'.$it->$f5.'</td>
                                                    <td>'.$it->$f6.'</td>
                                                    <td>'.$it->$f7.'</td>
                                                    <td>'.$it->$f8.'</td>
                                                </tr>';
                                    }
                                    else if($total_no_header == 9 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        $f5 = $headers_array[0]->field5;
                                        $f6 = $headers_array[0]->field6;
                                        $f7 = $headers_array[0]->field7;
                                        $f8 = $headers_array[0]->field8;
                                        $f9 = $headers_array[0]->field9;

                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                    <td>'.$it->$f5.'</td>
                                                    <td>'.$it->$f6.'</td>
                                                    <td>'.$it->$f7.'</td>
                                                    <td>'.$it->$f8.'</td>
                                                    <td>'.$it->$f9.'</td>
                                                </tr>';
                                    }
                                    else if($total_no_header == 10 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        $f5 = $headers_array[0]->field5;
                                        $f6 = $headers_array[0]->field6;
                                        $f7 = $headers_array[0]->field7;
                                        $f8 = $headers_array[0]->field8;
                                        $f9 = $headers_array[0]->field9;
                                        $f10 = $headers_array[0]->field10;

                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                    <td>'.$it->$f5.'</td>
                                                    <td>'.$it->$f6.'</td>
                                                    <td>'.$it->$f7.'</td>
                                                    <td>'.$it->$f8.'</td>
                                                    <td>'.$it->$f9.'</td>
                                                    <td>'.$it->$f10.'</td>
                                                </tr>';
                                    }
                                    else if($total_no_header == 11 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        $f5 = $headers_array[0]->field5;
                                        $f6 = $headers_array[0]->field6;
                                        $f7 = $headers_array[0]->field7;
                                        $f8 = $headers_array[0]->field8;
                                        $f9 = $headers_array[0]->field9;
                                        $f10 = $headers_array[0]->field10;
                                        $f11 = $headers_array[0]->field11;

                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                    <td>'.$it->$f5.'</td>
                                                    <td>'.$it->$f6.'</td>
                                                    <td>'.$it->$f7.'</td>
                                                    <td>'.$it->$f8.'</td>
                                                    <td>'.$it->$f9.'</td>
                                                    <td>'.$it->$f10.'</td>
                                                    <td>'.$it->$f11.'</td>
                                                </tr>';
                                    }
                                    else if($total_no_header == 12 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        $f5 = $headers_array[0]->field5;
                                        $f6 = $headers_array[0]->field6;
                                        $f7 = $headers_array[0]->field7;
                                        $f8 = $headers_array[0]->field8;
                                        $f9 = $headers_array[0]->field9;
                                        $f10 = $headers_array[0]->field10;
                                        $f11 = $headers_array[0]->field11;
                                        $f12 = $headers_array[0]->field12;

                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                    <td>'.$it->$f5.'</td>
                                                    <td>'.$it->$f6.'</td>
                                                    <td>'.$it->$f7.'</td>
                                                    <td>'.$it->$f8.'</td>
                                                    <td>'.$it->$f9.'</td>
                                                    <td>'.$it->$f10.'</td>
                                                    <td>'.$it->$f11.'</td>
                                                    <td>'.$it->$f12.'</td>
                                                </tr>';
                                    }
                                    else if($total_no_header == 13 && $total_no_header != '')
                                    {
                                        $f1 = $headers_array[0]->field1;
                                        $f2 = $headers_array[0]->field2;
                                        $f3 = $headers_array[0]->field3;
                                        $f4 = $headers_array[0]->field4;
                                        $f5 = $headers_array[0]->field5;
                                        $f6 = $headers_array[0]->field6;
                                        $f7 = $headers_array[0]->field7;
                                        $f8 = $headers_array[0]->field8;
                                        $f9 = $headers_array[0]->field9;
                                        $f10 = $headers_array[0]->field10;
                                        $f11 = $headers_array[0]->field11;
                                        $f12 = $headers_array[0]->field12;
                                        $f13 = $headers_array[0]->field13;
                                        $table .= '<tr>
                                                    <td>'.$it->pid.'</td>
                                                    <td>'.$i.'</td>
                                                    <td>'.$it->$f1.'</td>
                                                    <td>'.$it->$f2.'</td>
                                                    <td>'.$it->$f3.'</td>
                                                    <td>'.$it->$f4.'</td>
                                                    <td>'.$it->$f5.'</td>
                                                    <td>'.$it->$f6.'</td>
                                                    <td>'.$it->$f7.'</td>
                                                    <td>'.$it->$f8.'</td>
                                                    <td>'.$it->$f9.'</td>
                                                    <td>'.$it->$f10.'</td>
                                                    <td>'.$it->$f11.'</td>
                                                    <td>'.$it->$f12.'</td>
                                                    <td>'.$it->$f13.'</td>
                                                </tr>';
                                    }
                                    $i++;
                                endforeach;
                                if($total_no_header == 4 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td class="tp"><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                                }
                                else if($total_no_header == 5 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;
                                    $f5 = $headers_array[0]->field5;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></tr>';
                                }
                                else if($total_no_header == 6 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;
                                    $f5 = $headers_array[0]->field5;
                                    $f6 = $headers_array[0]->field6;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></tr>';
                                }
                                else if($total_no_header == 7 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;
                                    $f5 = $headers_array[0]->field5;
                                    $f6 = $headers_array[0]->field6;
                                    $f7 = $headers_array[0]->field7;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                                }
                                else if($total_no_header == 8 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;
                                    $f5 = $headers_array[0]->field5;
                                    $f6 = $headers_array[0]->field6;
                                    $f7 = $headers_array[0]->field7;
                                    $f8 = $headers_array[0]->field8;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf7="'.$f8.'" value="" ></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                                }
                                else if($total_no_header == 9 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;
                                    $f5 = $headers_array[0]->field5;
                                    $f6 = $headers_array[0]->field6;
                                    $f7 = $headers_array[0]->field7;
                                    $f8 = $headers_array[0]->field8;
                                    $f9 = $headers_array[0]->field9;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf7="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf7="'.$f9.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></tr>';
                                }
                                else if($total_no_header == 10 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;
                                    $f5 = $headers_array[0]->field5;
                                    $f6 = $headers_array[0]->field6;
                                    $f7 = $headers_array[0]->field7;
                                    $f8 = $headers_array[0]->field8;
                                    $f9 = $headers_array[0]->field9;
                                    $f10 = $headers_array[0]->field10;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf8="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf9="'.$f9.'" value=""></td><td><input type="text" style="display: block;" name="'.$f10.'" idf10="'.$f10.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                                }
                                else if($total_no_header == 11 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;
                                    $f5 = $headers_array[0]->field5;
                                    $f6 = $headers_array[0]->field6;
                                    $f7 = $headers_array[0]->field7;
                                    $f8 = $headers_array[0]->field8;
                                    $f9 = $headers_array[0]->field9;
                                    $f10 = $headers_array[0]->field10;
                                    $f11 = $headers_array[0]->field11;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf8="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf9="'.$f9.'" value=""></td><td><input type="text" style="display: block;" name="'.$f10.'" idf10="'.$f10.'" value=""></td><td><input type="text" style="display: block;" name="'.$f11.'" idf11="'.$f11.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                                }
                                else if($total_no_header == 12 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;
                                    $f5 = $headers_array[0]->field5;
                                    $f6 = $headers_array[0]->field6;
                                    $f7 = $headers_array[0]->field7;
                                    $f8 = $headers_array[0]->field8;
                                    $f9 = $headers_array[0]->field9;
                                    $f10 = $headers_array[0]->field10;
                                    $f11 = $headers_array[0]->field11;
                                    $f12 = $headers_array[0]->field12;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf8="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf9="'.$f9.'" value=""></td><td><input type="text" style="display: block;" name="'.$f10.'" idf10="'.$f10.'" value=""></td><td><input type="text" style="display: block;" name="'.$f11.'" idf11="'.$f11.'" value=""></td><td><input type="text" style="display: block;" name="'.$f12.'" idf12="'.$f12.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                                }
                                else if($total_no_header == 13 && $total_no_header != '')
                                {
                                    $f1 = $headers_array[0]->field1;
                                    $f2 = $headers_array[0]->field2;
                                    $f3 = $headers_array[0]->field3;
                                    $f4 = $headers_array[0]->field4;
                                    $f5 = $headers_array[0]->field5;
                                    $f6 = $headers_array[0]->field6;
                                    $f7 = $headers_array[0]->field7;
                                    $f8 = $headers_array[0]->field8;
                                    $f9 = $headers_array[0]->field9;
                                    $f10 = $headers_array[0]->field10;
                                    $f11 = $headers_array[0]->field11;
                                    $f12 = $headers_array[0]->field12;
                                    $f13 = $headers_array[0]->field13;

                                    $table .='<tr><td>0</td><td></td><td><input type="text" style="display: block;" idf1="'.$f1.'" name="'.$f1.'" value=""></td><td><input type="text" style="display: block;" name="'.$f2.'" idf2="'.$f2.'" style="display: block;" value=""></td><td><input type="text" style="display: block;" name="'.$f3.'" idf3="'.$f3.'" value=""></td><td><input style="display: block;" type="text" name="'.$f4.'" idf4="'.$f4.'" value=""></td><td class="tp"><input type="text" name="'.$f5.'" value=""></td><td><input style="display: block;" type="text" name="'.$f6.'" idf6="'.$f6.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f7.'" idf7="'.$f7.'" value="" class="tabledit-input form-control input-sm"></td><td><input type="text" style="display: block;" name="'.$f8.'" idf8="'.$f8.'" value=""></td><td><input type="text" style="display: block;" name="'.$f9.'" idf9="'.$f9.'" value=""></td><td><input type="text" style="display: block;" name="'.$f10.'" idf10="'.$f10.'" value=""></td><td><input type="text" style="display: block;" name="'.$f11.'" idf11="'.$f11.'" value=""></td><td><input type="text" style="display: block;" name="'.$f12.'" idf12="'.$f12.'" value=""></td><td><input type="text" style="display: block;" name="'.$f13.'" idf13="'.$f13.'" value=""></td><td class="save-btn-td"><button type="button" id="incConfiguratorBtn" class="btn btn-success btn-xs" title="Save Record"><i class="fa fa-save"></i></button><button type="button" id="incConfiguratorRemoveBtn" class="btn btn-danger btn-xs" title="Remove row"><i class="fa fa-trash"></i></button></td></tr>';
                                }
                            }
                            
                               
                            $table .'</tbody>
                                    </table>
                                </div>';
                               $table .= '<script type="text/javascript">
                                    $(document).ready(function(){
                                        $("table th:nth-child(1)").hide();
                                        $("table td:nth-child(1)").hide();
                                        
                                        $.ajaxSetup({
                                            headers: {
                                                "X-CSRF-Token": $("meta[name=\"csrf-token\"]").attr("content")
                                            }
                                        });
                                        $("#example1").Tabledit({
                                            url: "'.route("update-incentive-type").'",
                                            restoreButton:false,
                                            //editButton: false,
                                            columns: {
                                                identifier: [0, "pid"],';
                                                if(!empty($headers_array))
                                                {
                                                    $total_no_header = $headers_array[0]->field_no;
                                                    if($total_no_header == 4)
                                                    {
                                                        $f1 = $headers_array[0]->field1;
                                                        $f2 = $headers_array[0]->field2;
                                                        $f3 = $headers_array[0]->field3;
                                                        $f4 = $headers_array[0]->field4;
                                                        
                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        $table .= ']';
                                                    }
                                                    else if($total_no_header == 5)
                                                    {           
                                                        $f1 = $headers_array[0]->field1;
                                                        $f2 = $headers_array[0]->field2;
                                                        $f3 = $headers_array[0]->field3;
                                                        $f4 = $headers_array[0]->field4;
                                                        $f5 = $headers_array[0]->field5;       
                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        if($f5 != 'territory_type')
                                                        {
                                                            $table .= ',[6, "'.$f5.'"]';
                                                        }
                                                        $table .= ']';
                                                    }
                                                    else if($total_no_header == 6)
                                                    {
                                                        $f1 = $headers_array[0]->field1;
                                                        $f2 = $headers_array[0]->field2;
                                                        $f3 = $headers_array[0]->field3;
                                                        $f4 = $headers_array[0]->field4;
                                                        $f5 = $headers_array[0]->field5;
                                                        $f6 = $headers_array[0]->field6;
                                                        //$table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"], [5, "'.$f4.'"], [6, "'.$f5.'"], [7, "'.$f6.'"]]';

                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        if($f5 != 'territory_type')
                                                        {
                                                            $table .= ',[6, "'.$f5.'"]';
                                                        }
                                                        if($f6 == 'noofbrand_bud')
                                                        {
                                                            
                                                        }
                                                        else if($f6 == 'min_brand')
                                                        {

                                                        }
                                                        else
                                                        {
                                                            $table .= ',[6, "'.$f6.'"]';
                                                        }

                                                        $table .= ']';
                                                    }
                                                    else if($total_no_header == 7)
                                                    {
                                                        $f1 = $headers_array[0]->field1;
                                                        $f2 = $headers_array[0]->field2;
                                                        $f3 = $headers_array[0]->field3;
                                                        $f4 = $headers_array[0]->field4;
                                                        $f5 = $headers_array[0]->field5;
                                                        $f6 = $headers_array[0]->field6;
                                                        $f7 = $headers_array[0]->field7;
                                                        //$table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"], [5, "'.$f4.'"], [6, "'.$f5.'"], [7, "'.$f6.'"], [8, "'.$f7.'"]]';

                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        if($f5 != 'territory_type')
                                                        {
                                                            $table .= ',[6, "'.$f5.'"]';
                                                        }
                                                        if($f6 != 'min_brand'){
                                                            $table .= ',[7, "'.$f6.'"]';
                                                        }
                                                        if($f7 != 'max_brand')
                                                        {
                                                            $table .= ', [8, "'.$f7.'"]';
                                                        }
                                                        $table .= ']';
                                                    }
                                                    else if($total_no_header == 8)
                                                    {
                                                        $f1 = $headers_array[0]->field1;
                                                        $f2 = $headers_array[0]->field2;
                                                        $f3 = $headers_array[0]->field3;
                                                        $f4 = $headers_array[0]->field4;
                                                        $f5 = $headers_array[0]->field5;
                                                        $f6 = $headers_array[0]->field6;
                                                        $f7 = $headers_array[0]->field7;
                                                        $f8 = $headers_array[0]->field8;
                                                        //$table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"], [5, "'.$f4.'"], [6, "'.$f5.'"], [7, "'.$f6.'"], [8, "'.$f7.'"]]';

                                                        $table .= 'editable: [[2, "'.$f1.'"], [3, "'.$f2.'"], [4, "'.$f3.'"]';
                                                        if($f4 != 'territory_type')
                                                        {
                                                            $table .= ',[5, "'.$f4.'"]';
                                                        }
                                                        if($f5 != 'territory_type')
                                                        {
                                                            $table .= ',[6, "'.$f5.'"]';
                                                        }
                                                        $table .= ',[7, "'.$f6.'"], [8, "'.$f7.'"]';
                                                        $table .= ']';
                                                    }
                                                }

                                        $table .= '        
                                            },
                                            onAjax: function(action, serialize) {
                                                 $(".loader").show();
                                            },
                                            onSuccess: function(data, textStatus, jqXHR) {
                                                $(".loader").hide();
                                                if(textStatus == "success")
                                                {
                                                    if(data.action == "delete")
                                                    {
                                                        if(data.success)
                                                        {
                                                            $("table#example1 tr#"+data.pid).remove();
                                                            $.alert({
                                                                title: "Success!",
                                                                content: data.success,
                                                            });
                                                        }
                                                        else if(data.errors)
                                                        {
                                                            $.alert({
                                                                title: "Errors!",
                                                                content: data.errors,
                                                            });
                                                        }
                                                    }
                                                    else  if(data.action == "edit")
                                                    {
                                                        if(data.success)
                                                        {
                                                            $.alert({
                                                                title: "Success!",
                                                                content: data.success,
                                                            });
                                                        }
                                                        else if(data.errors)
                                                        {
                                                            $.alert({
                                                                title: "Errors!",
                                                                content: data.errors,
                                                            });
                                                        }   
                                                    }
                                                }
                                            }
                                        });
                                        $("#incConfiguratorBtn").on("click", function(){
								            
								            var incentive = $("#slab_incentive_type").val();
								            var csrf_token = $("meta[name=\"csrf-token\"]").attr("content");
								            var division = $("#division").val();
								            var fin_yr = $("#financial_year").val();
								            var territory = $("input[name=territory]:checked").val();
								            var profile_role = $("#profile_role").val();
								            var app_pcent = $("table#example1 tr:last input[name=app_pcent]").val();
								            var ach_val_fr = $("table#example1 tr:last input[name=ach_val_fr]").val();
								            var ach_val_to = $("table#example1 tr:last input[name=ach_val_to]").val();
								            var app_amount = $("table#example1 tr:last input[name=app_amount]").val();
								            if(ach_val_fr != "" && ach_val_to != "")
                                        	{						            
									            if(incentive == "quarterly" || incentive == "anual_ach")
									            {
									            	var min_brand = $("table#example1 tr:last input[name=min_brand]").val();

									            	var max_brand = $("table#example1 tr:last input[name=max_brand]").val();
									            	if(min_brand <= max_brand)
									            	{
		                                                $(".loader").show();
										            	$.ajax({
										                    type: "POST",
										                    url: "'.route("save-incentive-type").'",
										                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, app_pcent:app_pcent, ach_val_fr:ach_val_fr, ach_val_to:ach_val_to,app_amount: app_amount, min_brand:min_brand, max_brand:max_brand  },
										                    success: function(res)
										                    {
										                        $(".loader").hide();
										                        if(res.errors)
										                        {
										                        	$("table#example1 tr:last .tabledit-input").css("display", "block");
										                            $.alert({
										                                title: "Errors!",
										                                content: res.errors,
										                            });
										                        }
										                        else
										                        {
										                            $("#errors").html("");
										                            $.alert({
										                                title: "Success!",
										                                content: "New Record Inserted Sucessfully.",
										                            });
										                            $("#ach_val_fr").val("");
										                            $("#ach_val_to").val("");
										                            $("#app_pcent").val("");
										                            $("#amount").val("");
										                            $("#slab_response").html(res);
										                        }
										                        
										                    }
										                });
									                }
									                else
									                {
									                	$.alert({
							                                title: "Errors!",
							                                content: "Min Brand must be less then Max Brand",
							                            });	
									                }
									            }
									            else if(incentive == "anual_inc")
									            {
									            	var b_pmpt_fr = $("table#example1 tr:last input[name=b_pmpt_fr]").val();

									            	var b_pmpt_to = $("table#example1 tr:last input[name=b_pmpt_to]").val();
	                                                $(".loader").show();
									            	$.ajax({
									                    type: "POST",
									                    url: "'.route("save-incentive-type").'",
									                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, app_pcent:app_pcent, ach_val_fr:ach_val_fr, ach_val_to:ach_val_to, app_amount: app_amount, b_pmpt_fr:b_pmpt_fr, b_pmpt_to:b_pmpt_to  },
									                    success: function(res)
									                    {
									                        $(".loader").hide();
									                        if(res.errors)
									                        {
									                        	$("table#example1 tr:last .tabledit-input").css("display", "block");
									                            $.alert({
									                                title: "Errors!",
									                                content: res.errors,
									                            });
									                        }
									                        else
									                        {
									                            $("#errors").html("");
									                            $.alert({
									                                title: "Success!",
									                                content: "New Record Inserted Sucessfully.",
									                            });
									                            $("#ach_val_fr").val("");
									                            $("#ach_val_to").val("");
									                            $("#app_pcent").val("");
									                            $("#amount").val("");
									                            $("#slab_response").html(res);
									                        }
									                    }
									                });
									            }
									            else if(incentive == "brandqtr")
									            {
									                var brand_options = $("#brand_options").val();
	                                                $(".loader").show();
									                $.ajax({
									                    type: "POST",
									                    url: "'.route("save-incentive-type").'",
									                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, app_pcent:app_pcent, ach_val_fr:ach_val_fr, ach_val_to:ach_val_to, app_amount: app_amount, brand_options:brand_options },
									                    success: function(res)
									                    {
									                        $(".loader").hide();
									                        if(res.errors)
									                        {
									                            $.alert({
									                                title: "Errors!",
									                                content: res.errors,
									                            });
									                        }
									                        else
									                        {
									                            $("#errors").html("");
									                            $.alert({
									                                title: "Success!",
									                                content: "New Record Inserted Sucessfully.",
									                            });
									                            $("#ach_val_fr").val("");
									                            $("#ach_val_to").val("");
									                            $("#app_pcent").val("");
									                            $("#amount").val("");
									                            $("#slab_response").html(res);
									                        }
								                        }
									                });
									            }
								            }
								            else
								            {
								            	$.alert({
					                                title: "Errors!",
					                                content: "Please enter Achieved Value FROM and Achieved Value TO",
					                            });
								            }
                                    });

                                        jQuery("#collapseTwo table#example1 tbody tr:last").hide();
                                        jQuery("#collapseTwo table#example1 tbody button.tabledit-edit-button").css("display", "none");

                                        jQuery("#new_record_row").on("click", function(){
                                            var last_to_slab = $("#collapseTwo table#example1 tbody tr:last").prev().find("input[name=ach_val_to]").val();
                                            jQuery("#collapseTwo table#example1 tbody tr:last input[name=territory_type]").css("display", "none");

                                            jQuery("#collapseTwo table#example1 tbody tr:last input[type=\"text\"]").val("");

                                            jQuery("#collapseTwo table#example1 tbody tr:last").show();
                                            jQuery("#collapseTwo table#example1 tbody tr:last input[type=\"text\"]").removeAttr("disabled");
                                            jQuery("#collapseTwo table#example1 tbody tr:last input[type=\"text\"]").css("display", "block");
                                            jQuery("#collapseTwo table#example1 tbody tr:last input[type=\"text\"]:first").focus();
                                            jQuery("#collapseTwo table#example1 tbody tr:last").attr("id","0");
                                        });

                                        jQuery("#incConfiguratorRemoveBtn").on("click", function(){
                                            jQuery("#collapseTwo table#example1 tbody tr:last").hide();
                                        });
                                        jQuery(".tabledit-edit-button").on("click", function(){
                                            jQuery("#collapseTwo table#example1 tbody tr:last").hide();
                                        });
                                    });
                                </script>';
                        else:
                            $table  .= '<tr ><td>!!Record Not Found!!</td></tr>';
                            $table .'</tbody>
                                    </table>
                                </div>';
                        endif;
                echo $table;
            }
        }
        else
        {
            return response()->json(['errors' => 'Invalid Inncentive Slab Range']);
        }
    }

    public function updateIncentiveSlabl(Request $request)
    {
        $inputs = $request->all();
        $action = $request['action'];
        $pid = $request['pid'];
        if($action == 'edit')
        {
            $validator = \Validator::make($request->all(), [
                'ach_val_fr' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                'ach_val_to' => 'required|regex:/^\d*(\.\d{1,2})?$/',
                //'app_pcent'  => 'required',
            ]);
            
            if ($validator->fails())
            {
                return response()->json(['errors'=>$validator->errors()->all()]);
            }
            $ach_val_fr = $request['ach_val_fr'];
            $ach_val_to = $request['ach_val_to'];
            if (!is_float($ach_val_fr))
            {
              $ach_val_fr = sprintf('%0.2f', $ach_val_fr);
            }
            if (!is_float($ach_val_to))
            {
              $ach_val_to = sprintf('%0.2f', $ach_val_to);
            }
            $app_pcent  = 0;
            $app_amount = 0;
            if($request['app_pcent'] != '')
            {
                $app_pcent  = $request['app_pcent'];
            }
            if($request['app_amount'] != '')
            {
                $app_amount = $request['app_amount'];
            }
            $station  = $request['territory_type'];
            $b_pmpt_fr  = (isset($request['b_pmpt_fr']) && $request['b_pmpt_fr'] != '') ? $request['b_pmpt_fr'] : 0.00;
            $b_pmpt_to  = (isset($request['b_pmpt_to']) && $request['b_pmpt_to'] != '') ? $request['b_pmpt_to'] : 0.00;

            $min_brand  = (isset($request['min_brand']) && $request['min_brand'] != '') ? $request['min_brand'] : 0.00;
            $max_brand  = (isset($request['max_brand']) && $request['max_brand'] != '') ? $request['max_brand'] : 0.00;

            if($ach_val_fr >= 0 && $ach_val_fr < $ach_val_to)
            {
                $incetiveSlab = DB::table("incentive_slab_ram")->select("*")->where('pid', $pid)->get()->toArray();

                if(!empty($incetiveSlab))
                {
                    $isb = $incetiveSlab[0];
                    if($isb->ach_val_fr == $ach_val_fr && $isb->ach_val_to == $ach_val_to)
                    {
                        if($b_pmpt_fr != 0.00 && $b_pmpt_to != 0.00)
                        {
                            DB::table('incentive_slab_ram')
                            ->where('pid', $pid)
                            ->update(['app_pcent' => $app_pcent, 'app_amount' => $app_amount, 'b_pmpt_fr' => $b_pmpt_fr, 'b_pmpt_to' => $b_pmpt_to]);
                            return response()->json(['success' => 'Record has been updated.', 'pid' => $pid, 'action' => 'edit']);
                        }
                        else if($min_brand != 0.00 && $max_brand != 0.00)
                        {
                            DB::table('incentive_slab_ram')
                            ->where('pid', $pid)
                            ->update(['app_pcent' => $app_pcent, 'app_amount' => $app_amount, 'min_brand' => $min_brand, 'max_brand' => $max_brand]);
                            return response()->json(['success' => 'Record has been updated.', 'pid' => $pid, 'action' => 'edit']);
                        }
                        else
                        {
                            DB::table('incentive_slab_ram')
                            ->where('pid', $pid)
                            ->update(['app_pcent' => $app_pcent, 'app_amount' => $app_amount]);
                            return response()->json(['success' => 'Record has been updated.', 'pid' => $pid, 'action' => 'edit']);
                        }
                    }
                    else if($isb->ach_val_fr == $ach_val_fr && $isb->ach_val_to != $ach_val_to)
                    {
                        if($b_pmpt_fr != 0.00 && $b_pmpt_to != 0.00)
                        {
                            DB::table('incentive_slab_ram')
                            ->where('pid', $pid)
                            ->update(['ach_val_fr' => $ach_val_fr, 'ach_val_to' => $ach_val_to, 'app_pcent' => $app_pcent, 'app_amount' => $app_amount, 'b_pmpt_fr' => $b_pmpt_fr, 'b_pmpt_to' => $b_pmpt_to]);
                            return response()->json(['success' => 'Record has been updated.', 'pid' => $pid, 'action' => 'edit']);
                        }
                        else if($min_brand != 0.00 && $max_brand != 0.00)
                        {
                            DB::table('incentive_slab_ram')
                            ->where('pid', $pid)
                            ->update(['ach_val_fr' => $ach_val_fr, 'ach_val_to' => $ach_val_to, 'app_pcent' => $app_pcent, 'app_amount' => $app_amount, 'min_brand' => $min_brand, 'max_brand' => $max_brand]);
                            return response()->json(['success' => 'Record has been updated.', 'pid' => $pid, 'action' => 'edit']);
                        }
                        else
                        {
                            DB::table('incentive_slab_ram')
                            ->where('pid', $pid)
                            ->update(['ach_val_fr' => $ach_val_fr, 'ach_val_to' => $ach_val_to, 'app_pcent' => $app_pcent, 'app_amount' => $app_amount]);
                            return response()->json(['success' => 'Record has been updated.', 'pid' => $pid, 'action' => 'edit']);
                        }
                    }
                    else
                    {
                        return response()->json(['errors' => 'Incentive slab rang is already defined.', 'pid' => $pid, 'action' => 'edit']);
                    }

                    /*foreach ($incetiveSlab as $isb)
                    {
                        if($isb->ach_val_to <= $ach_val_fr)
                        {

                        }
                        else
                        {
                            return response()->json(['errors' => 'Incentive slab rang is already defined.', 'pid' => $pid, 'action' => 'edit']);
                        }
                    }*/
                }
                else
                {
                    return response()->json(['errors' => 'Incentive slab rang is already defined.', 'pid' => $pid, 'action' => 'edit']);
                }
                /*if($b_pmpt_fr != 0.00 && $b_pmpt_to != 0.00)
                {
                    DB::table('incentive_slab_ram')
                    ->where('pid', $pid)
                    ->update(['ach_val_fr' => $ach_val_fr, 'ach_val_to' => $ach_val_to, 'app_pcent' => $app_pcent, 'app_amount' => $app_amount, 'territory_type' => $station, 'b_pmpt_fr' => $b_pmpt_fr, 'b_pmpt_to' => $b_pmpt_to]);
                }
                else if($min_brand != 0.00 && $max_brand != 0.00)
                {
                    DB::table('incentive_slab_ram')
                    ->where('pid', $pid)
                    ->update(['ach_val_fr' => $ach_val_fr, 'ach_val_to' => $ach_val_to, 'app_pcent' => $app_pcent, 'app_amount' => $app_amount, 'territory_type' => $station, 'min_brand' => $min_brand, 'max_brand' => $max_brand]);
                }
                else
                {
                    DB::table('incentive_slab_ram')
                    ->where('pid', $pid)
                    ->update(['ach_val_fr' => $ach_val_fr, 'ach_val_to' => $ach_val_to, 'app_pcent' => $app_pcent, 'app_amount' => $app_amount, 'territory_type' => $station]);
                }
                return response()->json(['success' => 'Record has been updated.', 'pid' => $pid, 'action' => 'edit']);*/
            }
            else
            {
                return response()->json(['errors' => 'Invalid Inncentive Slab Range', 'pid' => $pid, 'action' => 'edit']);
            }
        }
        else if($action == 'delete') 
        {
            DB::table('incentive_slab_ram')->where('pid', $pid)->delete();
            return response()->json(['success' => 'Record has been deleted.', 'pid' => $pid, 'action' => 'delete']);
        }
    }
}
