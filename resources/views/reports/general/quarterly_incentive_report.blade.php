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
    <h2>Reports / Quarterly Incentive Report</h2>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="sales admin-page">
                <div class="panel-group" id="accordion">
                    <form action="{{ route('quaterly-qb-incentive-report') }}" method="post" id="incetiveConfiguratorFrm">
                        <div class="panel checkout-step">
                        	<div class="panel-heading">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#incetiveConfiguratorFrm" href="#collapseOne"><span class="fa fa-search">
                                    </span> Search</a>
                                </h4>
                            </div> 
                            @csrf                                               
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
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
                                                <!-- <option value="2019 - 2020">2019 - 2020</option> -->
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control" name="incentive_type" id="incentive_type" >
                                                <option value="">Select Incentive Type</option>
                                                <option value="quarterly">QUARTERLY</option>
                                                <option value="brand">BRAND INCENTIVE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-md-4 hide" id="opt-quarter">
                                            <select class="form-control brand-dropddown" name="quarter" id="quarter" >
                                                <option value="">Select Quarter</option>
                                                <option value="1">APR-JUN</option>
                                                <option value="2">JUL-SEP</option>
                                                <option value="3">OCT-DEC</option>
                                                <option value="4">JAN-MAR</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 hide" id="qtrly_brand_dd">
                                            <select class="form-control brand-dropddown" name="brand_options" id="brand_options">
                                                <option value="">Select Brand</option>
                                                <!-- @if(!empty($brands))
                                                    @foreach($brands as $brand)
                                                        <option value="{{ $brand->incentive_group }}">{{ $brand->incentive_group }}</option>
                                                    @endforeach
                                                @endif -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-info" id="createExcel" ><i class="fa fa-file-excel-o" aria-hidden="true"></i> Create Excel</button>  <a href="{{ route('reports-general') }}" class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
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
    jQuery(document).ready(function(){
    	$("[rel=tooltip]").tooltip({ placement: 'right'});
        $(".loader").hide();

        $("#division").on("change", function(){
            var inc_type = $("#incentive_type").val();
            if(inc_type == 'brand')
            {
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
                $("#qtrly_brand_dd").removeClass("hide");
                $("#brandPw").removeClass("hide");   
            }

        });
        $("#financial_year").on("change", function(){
            var inc_type = $("#incentive_type").val();
            if(inc_type == 'brand')
            {
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
                $("#qtrly_brand_dd").removeClass("hide");
                $("#brandPw").removeClass("hide");   
            }
        });

        $("#incentive_type").on("change", function(){
            var inc_type = $(this).val();
            if(inc_type == 'quarterly')
            {
                $("#opt-quarter").removeClass("hide");
                $('#quarter').prop('selectedIndex', 0);
                $("#qtrly_brand_dd").addClass("hide");
            }
            else if(inc_type == 'brand')
            {
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
                $("#qtrly_brand_dd").removeClass("hide");
                $("#opt-quarter").addClass("hide");
                $("#brandPw").removeClass("hide");
            }
        });
    });
</script>
@endsection
