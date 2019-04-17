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
    <h2>Reports / Quarterly Brand Incentive Audit Report</h2>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="sales admin-page">
                <div class="panel-group" id="accordion">
                    <form action="{{ route('quarterly-brand-incentive-audit-report-generate') }}" method="post" id="incetiveConfiguratorFrm">
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
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <select class="form-control" name="financial_year" id="financial_year" required="">
                                                <option value="">Select Financial Year</option>
                                                <option value="2018-19">2018-19</option>
                                                <option value="2019-20">2019-20</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="profile_role" id="profile_role" required="">
                                                <option value="">Select Profile Type</option>
                                                <option value="5">Territory</option>
                                                <option value="6">Area</option>
                                                <option value="7">Region</option>
                                                <option value="8">Zone/SM</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6" >
                                            <select class="form-control brand-dropddown" name="brand_options" id="brand_options">
                                                <option value="">Select Brand</option>
                                               <!--  @if(!empty($brands))
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->incentive_group }}">{{ $brand->incentive_group }}</option>
                                                    @endforeach
                                                @endif -->
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
                                                        <input type="radio" name="territory_type" value="metro/non-metro"> <span>Metro/Non-Metro </span>
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
                                             
                                            <button type="submit" class="btn btn-success" id="createExcel" ><i class="fa fa-file-excel-o" aria-hidden="true"></i> Create Excel</button>
                                            <a href="{{ route('reports-audit') }}" class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
                                              <!-- <a href="{{ route('incentive-audit-report') }}" class="btn btn-danger"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</a> -->
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
<div class="loader"></div>
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

        $(".loader").hide();

        $("#division").on("change", function(){
            var division_id = $("#division").val();
            var financial_year = $("#financial_year").val();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            if(division_id != '' && financial_year != '')
            {
                $(".loader").show();
                $.ajax({
                    type: "POST",
                    url: "{{ route('get-brands-by-df') }}",
                    data: {division_id: division_id, _token: csrf_token, financial_year: financial_year},
                    success: function(res_opt)
                    {
                        $(".loader").hide();
                        $('#brand_options').html(res_opt);
                    }
                });
            }

        });
        $("#financial_year").on("change", function(){
            var division_id = $("#division").val();
            var financial_year = $("#financial_year").val();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            if(division_id != '' && financial_year != '')
            {
                $(".loader").show();
                $.ajax({
                    type: "POST",
                    url: "{{ route('get-brands-by-df') }}",
                    data: {division_id: division_id, _token: csrf_token, financial_year: financial_year},
                    success: function(res_opt)
                    {
                        $(".loader").hide();
                        $('#brand_options').html(res_opt);
                    }
                });
            }
        });
    });
</script>
@endsection
