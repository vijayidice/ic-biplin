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
    <h2>Audit Process</h2>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="sales admin-page">
                <div class="panel-group" id="accordion">
                    <form action="" method="post" id="incetiveConfiguratorFrm">
                        <div class="panel checkout-step">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#incetiveConfiguratorFrm" href="#collapseOne"><span class="fa fa-search">
                                    </span> Search</a>
                                </h4>
                            </div>                                                
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
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
                                                <!-- <option value="2019 - 2020">2019 - 2020</option> -->
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="incentive_type" id="incentive_type" >
                                                <option value="">Select Incentive Type</option>
                                                <option value="audit_nonbrand">QUARTERLY PROCESSING</option>
                                                <option value="audit_brand">QUARTERLY BRAND PROCESSING</option>
                                            </select>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <select class="form-control" name="profile_role" id="profile_role" required="">
                                                <option value="">Select Profile Type</option>
                                                <option value="5">Territory</option>
                                                <option value="6">Area</option>
                                                <option value="7">Region</option>
                                                <option value="8">Zone/SM</option>
                                                <option value="99">ALL</option>
                                            </select>
                                        </div> -->
                                    </div>
                                    <!-- <div class="row hide" id="qtrly_brand_dd">
                                        <div class="col-md-6">
                                            <select class="form-control brand-dropddown" name="brand_options" id="brand_options"  required="">
                                                <option value="">Select Brand</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="form-group text-center">
                                            <a class="collapsed btn btn-page" role="button" data-toggle="collapse" data-parent="#incetiveConfiguratorFrm" id="step2" href="#collapseTwo">Process</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="process_response"></div>
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
        /*$("[rel=tooltip]").tooltip({ placement: 'right'});

        $("#division").on("change", function(){
            var inc_type = $("#incentive_type").val();
            if(inc_type == 'brandqtr')
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
            if(inc_type == 'brandqtr')
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
            if(inc_type != 'brandqtr')
            {
                $("#qtrly_brand_dd").addClass("hide");
                $('#brand_options').prop('selectedIndex', 0);
                $("#brandPw").addClass("hide");
            }
            else
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
        });*/

        $(".loader").hide();

        $("#step2").on("click", function()
        {
            var incentive = $('#incentive_type').val();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var division = $("#division").val();
            var fin_yr = $("#financial_year").val();
            
            if(incentive != '' && division != '' && fin_yr != '')
            {
                $(".loader").show();
                $.ajax({
                    type: "POST",
                    url: "{{ route('audit_process') }}",
                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr},
                    success: function(res)
                    {
                        $(".loader").hide();
                        if(res.success)
                        {
                            $("#process_response").html('<div class="alert alert-success">'+res.success+'</div>');
                        }
                        else if(res.error)
                        {
                            $("#process_response").html('<div class="alert alert-danger">'+res.error+'</div>');
                        }
                        else
                        {
                            $("#process_response").html('<div class="alert alert-danger">Something went wrong</div>');
                        }
                    }
                });
            }
            else
            {
                $.alert({
                        title: "Errors!",
                        content: "All Fields are required.",
                    });   
            }
        });             
    });
</script>
@endsection
