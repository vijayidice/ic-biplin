@extends('layouts.main')

@section('content')
<style type="text/css">
    div#slab_response > .calender-row {
    margin-bottom: 15px;
}
.tabledit-toolbar-column { display: none !important; }
.table .thead-light th {
    color: #fff;
    background-color: #055e80;
    border-color: #dee2e6;
}
    table#example1 > caption { text-align: right !important; } 
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<div class="user-dashboard">
    <h2>Slab Configurator</h2>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="sales admin-page">
                <div class="panel-group" id="accordion">
                    <form action="" method="post" id="incetiveConfiguratorFrm">
                        <div id="incen-frst" class="panel checkout-step">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#incetiveConfiguratorFrm" href="#collapseOne"><span class="fa fa-cog">
                                    </span>Setup</a>
                                </h4>
                            </div>                                                
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                             <input type="hidden" name="incentive_configurator_type" value="slab">
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
                                            <select class="form-control" name="incentive_type" id="slab_incentive_type" >
                                                <option value="">Select Incentive Type</option>
                                                <option value="quarterly">QUARTERLY</option>
                                                <option value="anual_inc">ANNUAL INCREMENT</option>
                                                <option value="anual_ach">ANNUAL ACHIEVEMENT</option>
                                                <option value="brandqtr">QUARTERLY BRAND INCENTIVE</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
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
                                        <div id="profileTypes" class="hide">
                                            <ul class="internal-list">
                                                <li><strong><span id="profileTypeLabel"></span></strong></li>
                                                <li>
                                                    <input type="radio" checked name="territory" value="metro"> <span>Metro</span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="territory" value="non-metro"> <span>Non-Metro</span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="territory" value="metro/non-metro"> <span>Metro/Non-Metro </span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="territory" value="others"> <span>Others</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row hide" id="intimaTypes">
                                        <div class="col-md-12">
                                            <ul class="internal-list">
                                                <li><strong>Select Value Incentive For</strong></li>
                                                <li>
                                                    <input type="radio"  name="intima_type" value="2"> <span>New Antimalarials</span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="intima_type" value="3"> <span>Non Antimalarials</span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="intima_type" value="4"> <span>Old Antimalarials</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row hide" id="qtrly_brand_dd">
                                        <div class="col-md-6">
                                            <select class="form-control brand-dropddown" name="brand_options" id="brand_options"  required="">
                                                <option value="">Select Brand</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group text-center">
                                                <a class="collapsed btn btn-page" role="button" data-toggle="collapse" data-parent="#incetiveConfiguratorFrm" id="step1" href="#collapseTwo">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                            </div>
                                    </div>
                                    
                                </div>  
                            </div>                        
                        </div>
                        <div class="panel checkout-step">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#incetiveConfiguratorFrm" href="#collapseTwo"><span class="fa fa-table">
                                    </span>Slab</a>
                                </h4>
                            </div>                                                
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body" style="padding-top: 0; border-top: none;">
                                    <div class="row">
                                        <div class="col-m-12">
                                            <table class="table table-striped table-bordered">
                                                <tr>
                                                    <td class=" hide"></td>
                                                    <td><strong>Division:</strong></td>
                                                    <td><span id="divsion"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class=" hide"></td>
                                                    <td><strong>Incentive Type:</strong></td>
                                                    <td><span id="incentiveType"></span></td>
                                                </tr>
                                                <tr class=" hide" id="brandPw">
                                                    <td class=" hide"></td>
                                                    <td><strong>Brand:</strong></td>
                                                    <td><span id="brandType"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class=" hide"></td>
                                                    <td><strong>Financial Year:</strong></td>
                                                    <td><span id="fin_yr"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class=" hide"></td>
                                                    <td><strong>Profile:</strong></td>
                                                    <td><span id="profile_for"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class=" hide"></td>
                                                    <td><strong>Territory Type:</strong></td>
                                                    <td><span id="territoryType"></span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="slab_response"></div>
                                    </div>
                                    <div id="errors"></div>        
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                                
    </div>
</div>
<div class="loader"></div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        $("#division").on("change", function(){
            var inc_type = $("#slab_incentive_type").val();
            var divn = $("#division").val();
            if(divn == '14')
            {
                $("#intimaTypes").removeClass("hide");
            }
            else
            {
                $("#intimaTypes").addClass("hide");
            }
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
            var inc_type = $("#slab_incentive_type").val();
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

        $("#slab_incentive_type").on("change", function(){
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
        });
        
        $(".loader").hide();

        $("#step1").on("click", function(){
            $("#divsion").text($("#division option:selected").text());
            $("#pre_division").text($("#division option:selected").text());
            $("#incentiveType").text($("#slab_incentive_type option:selected").text());
            $("#fin_yr").text($("#financial_year option:selected").text());
            $("#pre_fin_year").text($("#financial_year option:selected").text());
            $("#profile_for").text($("#profile_role option:selected").text());
            $("#pre_profile_for").text($("#profile_role option:selected").text());
            $("#brandType").text($("#brand_options option:selected").text());
            $("#station").val($('input[name=territory]:checked').val());

            var profileRole = $("#profile_role option:selected").val();
            if(profileRole == '5')
            {
                $("#territoryType").text($('input[name=territory]:checked').val());
            }
            else if(profileRole == '6')
            {
                $("#territoryType").text($('input[name=territory]:checked').val());
            }
            else
            {
                $("#territoryType").text('');
            }
            
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var division = $("#division").val();
            var fin_yr = $("#financial_year").val();
            var territory = $('input[name=territory]:checked').val();
            var profile_role = $("#profile_role").val();
            var incentive = $('#slab_incentive_type').val();
            var intima_type = '';
            if(division == '14')
            {
                intima_type = $('input[name=intima_type]:checked').val();
            }
            if(incentive != 'brandqtr')
            {
                $(".loader").show();
                $.ajax({
                    type: "POST",
                    url: "{{ route('incentive-type-slab') }}",
                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, intima_type:intima_type},
                    success: function(res)
                    {
                        $(".loader").hide();
                        $('#brand_options').prop('selectedIndex',0);
                        $("#qtrly_brand_dd").addClass("hide");
                        //$("#example1 > tbody").html(res);
                        $("#slab_response").html(res);
                    }
                });
            }
            else
            {
                if (incentive != 'brandqtr') {
                    $("#qtrly_brand_dd").addClass("hide");
                }
                else
                {
                    $("#qtrly_brand_dd").removeClass("hide");
                    var brand_val = $("#brand_options").val();
                    $(".loader").show();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('incentive-type-slab') }}",
                        data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, brand_val: brand_val},
                        success: function(res)
                        {
                            $(".loader").hide();
                            //$("#example1 > tbody").html(res);
                            $("#slab_response").html(res);
                        }
                    });
                }
            }
        });

        $("#incConfiguratorBtn").on("click", function(){
            $(".loader").show();
            var incentive = $('#slab_incentive_type').val();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var division = $("#division").val();
            var fin_yr = $("#financial_year").val();
            var territory = $('input[name=territory]:checked').val();
            var profile_role = $("#profile_role").val();
            var app_pcent = $("#app_pcent").val();
            var ach_val_fr = $("#ach_val_fr").val();
            var ach_val_to = $("#ach_val_to").val();
            var station = $("#station").val();
            var amount = $("#amount").val();

            if(incentive != 'brandqtr')
            {
                $.ajax({
                    type: "POST",
                    url: "{{ route('save-incentive-type') }}",
                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, app_pcent:app_pcent, ach_val_fr:ach_val_fr, ach_val_to:ach_val_to, station: station, amount: amount },
                    success: function(res)
                    {
                        $(".loader").hide();
                        if(res.errors)
                        {
                            $.alert({
                                title: 'Errors!',
                                content: res.errors,
                            });
                            //$("#errors").html('<p style="color: red;">'+res.errors+'</p>');
                        }
                        else
                        {
                            $("#errors").html("");
                            $.alert({
                                title: 'Success!',
                                content: "New Record Inserted Sucessfully.",
                            });
                            $("#ach_val_fr").val('');
                            $("#ach_val_to").val('');
                            $("#app_pcent").val('');
                            $("#station").val('');
                            $("#amount").val('');
                            //$("#example1 > tbody").html(res);
                            $("#slab_response").html(res);
                        }
                        
                    }
                });
            }
            else
            {
                $brand_options = $("#brand_options").val();
                $.ajax({
                    type: "POST",
                    url: "{{ route('save-incentive-type') }}",
                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, app_pcent:app_pcent, ach_val_fr:ach_val_fr, ach_val_to:ach_val_to, station: station, amount: amount, brand_options:brand_options },
                    success: function(res)
                    {
                        $(".loader").hide();
                        if(res.errors)
                        {
                            $.alert({
                                title: 'Errors!',
                                content: res.errors,
                            });
                            //$("#errors").html('<p style="color: red;">'+res.errors+'</p>');
                        }
                        else
                        {
                            $("#errors").html("");
                            $.alert({
                                title: 'Success!',
                                content: "New Record Inserted Sucessfully.",
                            });
                            $("#ach_val_fr").val('');
                            $("#ach_val_to").val('');
                            $("#app_pcent").val('');
                            $("#station").val('');
                            $("#amount").val('');
                            //$("#example1 > tbody").html(res);
                            $("#slab_response").html(res);
                        }
                        
                    }
                });
            }
        });
    });
</script>
@endsection
