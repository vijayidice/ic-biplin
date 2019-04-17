@extends('layouts.main')

@section('content')
<style type="text/css">
    div#slab_response > .calender-row {
    margin-bottom: 15px;
}
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<div class="user-dashboard">
    <h2>Reports / Incentive Audit Report</h2>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="sales admin-page">
                <div class="panel-group" id="accordion">
                    <form action="{{ route('incentive-audit-report-generate') }}" method="post" id="incetiveConfiguratorFrm">
                        <div class="panel checkout-step">
                        	<div class="panel-heading">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#incetiveConfiguratorFrm" href="#collapseOne"><span class="fa fa-cog">
                                    </span> Setting</a>
                                </h4>
                            </div>                                                
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            @csrf
                                            <select class="form-control selectpicker" name="division" id="division" required="" data-dropup-auto="false">
                                                <option value="">Select Division</option>
                                                @if(!empty($divisions))
                                                    @foreach($divisions as $division)
                                                    <option value="{{ $division->divisionid }}">{{ $division->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select> 
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="financial_year" id="financial_year" required="">
                                                <option value="">Select Financial Year</option>
                                                <option value="2018-19">2018-19</option>
                                                <option value="2019-20">2019-20</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="profile_role" id="profile_role" required="">
                                                <option value="">Select Profile Type</option>
                                                <option value="5">Territory</option>
                                                <option value="6">Area</option>
                                                <option value="7">Region</option>
                                                <option value="8">Zone/SM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="profileTypes" class="hide">
                                                <ul class="internal-list">
                                                    <li><strong><span id="profileTypeLabel"></span></strong></li>
                                                    <li>
                                                        <input type="radio" checked name="territory_type" value="metro"> <span>Metro</span>
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="territory_type" value="non-metro"> <span>Non-Metro</span>
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="territory_type" value="metro/non-metro"> <span>Metro/Non-Metro</span>
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="territory_type" value="others"> <span>Others</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="intimaTypes" class="hide">
                                                <ul class="internal-list">
                                                    <li><strong>Select Value Incentive For</strong></li>
                                                    <li>
                                                        <input type="radio"  name="intima_type" value="new_antimalarials"> <span>New Antimalarials</span>
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="intima_type" value="non_antimalarials"> <span>Non Antimalarials</span>
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="intima_type" value="old_antimalarials"> <span>Old Antimalarials</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-success" id="createExcel" ><i class="fa fa-file-excel-o" aria-hidden="true"></i> Create Excel</button>  
                                            <a href="{{ route('reports-audit') }}" class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a> <!-- <a href="{{ route('incentive-audit-report') }}" class="btn btn-danger"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</a> -->
                                        </div>
                                    </div>
                                </div>  
                            </div>                        
                    	</div> <!--/.checkout-step -->
                    </form>
                </div>
            </div>
        </div>                                
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
	    $("#profile_role").on("change", function(){
            var pro_type = $(this).val();
            if(pro_type == 5)
            {
                $("#profileTypes").removeClass("hide");
                $("#profileTypeLabel").text("Territory Type");
            }
            else if(pro_type == 6)
            {
                $("#profileTypes").removeClass("hide");
                $("#profileTypeLabel").text("Area Type");
            }
            else
            {
                $("#profileTypes").addClass("hide");
                $("#profileTypeLabel").text("");
            }
        });
        $("#division").on("change", function(){
            var divn = $(this).val();
            if(divn == '14')
            {
                $("#intimaTypes").removeClass("hide");
            }
            else
            {
                $("#intimaTypes").addClass("hide");
            }
        });
    });
</script>
@endsection
