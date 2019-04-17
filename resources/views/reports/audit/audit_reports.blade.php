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
    <h2>{{ ucwords(str_replace("_", " ", $page)) }}</h2>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="sales admin-page">
                <div class="panel-group" id="accordion">
                    <form action="" method="post" id="incetiveConfiguratorFrm">
                        <div class="panel checkout-step">
                        	<div class="panel-heading">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#incetiveConfiguratorFrm" href="#collapseOne"><span class="fa fa-search">
                                    </span> IPCA AUDIT REPORTS</a>
                                </h4>
                            </div>                                                
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row">
                                		<div class="col-md-12">
                            				<ul class="link-ul">
                            					<!--<li><a href="{{ route('quarterly-incentive-report') }}">QUARTERLY INCENTIVE REPORT</a></li>
                            					<li><a href="{{ route('annual-incentive-report') }}">ANNUAL INCENTIVE REPORT</a></li>
                            					<li><a href="{{ route('annual-increment-incentive-report') }}">ANNUAL INCREMENT INCENTIVE REPORT</a></li>
                            					 <li><a href="{{ route('annual-achievement-guidance-report') }}">ANNUAL ACHIEVEMENT GUIDANCE REPORT</a></li>
                            					<li><a href="{{ route('annual-increament-guidance-report') }}">ANNUAL INCREMENT GUIDANCE REPORT</a></li> -->
                                                <li><a href="{{ route('reports-inc-aud-rep-nonbrand') }}">INCENTIVE AUDIT REPORT(NON-BRAND)</a></li>
                                                <li><a href="{{ route('reports-inc-aud-rep-brand') }}">INCENTIVE AUDIT REPORT(BRAND)</a></li>
                            				</ul>
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
    });
</script>
@endsection
