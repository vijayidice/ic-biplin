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
    <h2>Reports / Annual Incremental Guidance Report</h2>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="sales admin-page">
                <div class="panel-group" id="accordion">
                    <form action="{{ route('annual-increment-guidance-report-generate') }}" method="post" id="incetiveConfiguratorFrm">
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
                                            <select class="form-control" name="zone" id="zone" >
                                                <option value="">Select Zone</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="region" id="region" required="">
                                                <option value="">Select Region</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control" name="area" id="area" required="">
                                                <option value="">Select Area</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control brand-dropddown" name="territory" id="territory"  required="">
                                                <option value="">Select Territory</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control brand-dropddown" name="territory" id="territory"  required="">
                                                <option value="">Select Financial Year</option>
                                                <option value="2018-19">2018-19</option>
                                                <option value="2019-20">2019-20</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="internal-list">
                                                <li><strong>Qualifier : </strong></li>
                                                <li>
                                                    <input type="radio" checked name="qualifier" value="yes"> <span>YES</span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="qualifier" value="no"> <span>NO</span>
                                                </li>
                                                <li>
                                                    <input type="radio" name="qualifier" value="both"> <span>NOT APPLICABLE</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group text-center">
                                            <button type="button" class="btn btn-success" id="generate"><i class="fa fa-file" aria-hidden="true"></i> Generate</button>
                                            <button type="button" class="btn btn-info" id="createExcel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Create Excel</button>  <a href="{{ route('reports') }}" class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back</a>
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
    	$("[rel=tooltip]").tooltip({ placement: 'right'});

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

        $("#step2").on("click", function()
        {
            var incentive = $('#incentive_type').val();
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var division = $("#division").val();
            var fin_yr = $("#financial_year").val();
            var territory = $('input[name=territory]:checked').val();
            var profile_role = $("#profile_role").val();

            if(incentive != 'brandqtr')
            {
                $(".loader").show();
                $.ajax({
                    type: "POST",
                    url: "{{ route('update-process') }}",
                    data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role},
                    success: function(res)
                    {
                        $(".loader").hide();
                        $('#brand_options').prop('selectedIndex',0);
                        $("#qtrly_brand_dd").addClass("hide");
                        //$("#example1 > tbody").html(res);
                        $("#process_response").html('<div class="alert alert-success">'+res+'</div>');
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
                        url: "{{ route('update-process') }}",
                        data: {incentive: incentive, _token: csrf_token, division: division, fin_yr: fin_yr, territory: territory,profile_role:profile_role, brand_val: brand_val},
                        success: function(res)
                        {
                            $(".loader").hide();
                            //$("#example1 > tbody").html(res);
                            $("#process_response").html('<div class="alert alert-success">'+res+'</div>');
                        }
                    });
                }
            }
        });

        $("#step1").on("click", function(){
            //$(".loader").show();
            $("#divsion").text($("#division option:selected").text());
            $("#pre_division").text($("#division option:selected").text());
            $("#incentiveType").text($("#incentive_type option:selected").text());
            $("#fin_yr").text($("#financial_year option:selected").text());
            $("#pre_fin_year").text($("#financial_year option:selected").text());
            $("#profile_for").text($("#profile_role option:selected").text());
            $("#pre_profile_for").text($("#profile_role option:selected").text());
            $("#brandType").text($("#brand_options option:selected").text());
            $("#station").val($('input[name=territory]:checked').val());
            /*var csrf_token = $('meta[name="csrf-token"]').attr('content');
            var division = $("#division").val();
            var fin_yr = $("#financial_year").val();
            $.ajax({
                type: "POST",
                url: "{{ route('get-incentive-type-category') }}",
                data: {_token: csrf_token, division: division, fin_yr: fin_yr},
                success: function(res)
                {
                    $(".loader").hide();
                    $("#incetive_type_category").html(res);
                }
            });*/
        });

       /* $("#step2").on("click", function(){
            $("#pre_territory").text($('input[name=territory]:checked').val());
        });*/
       
        jQuery(".add-btn").on('click', function(){
        var ele = jQuery(this).closest(".form-group").closest(".col-md-12").closest(".row").prev(".calender-row").clone(true);
        jQuery(this).closest(".form-group").closest(".col-md-12").closest(".row").prev(".calender-row").after(ele);
      });        
      jQuery(".delete-btn").on('click', function(){
        var ele = jQuery(this).closest("div").closest(".calender-row").remove(false);
        jQuery(this).closest("div").closest(".calender-row").after(ele);
      });             
    });
</script>
@endsection
