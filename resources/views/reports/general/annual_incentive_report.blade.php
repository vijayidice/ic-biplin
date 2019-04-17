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
    <h2>Reports / Annual Incentive Report</h2>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="sales admin-page">
                <div class="panel-group" id="accordion">
                    <form action="{{ route('annual-incentive-report-generate') }}" method="post" id="incetiveConfiguratorFrm">
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
                                                <!-- <option value="2019 - 2020">2019 - 2020</option> -->
                                            </select>
                                        </div>
                                        <div class="col-md-4">
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
<script type="text/javascript">
    jQuery(document).ready(function(){
	
    });
</script>
@endsection
