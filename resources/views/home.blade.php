@extends('layouts.main')

@section('content')
<div class="user-dashboard">
    <h3>Hello, {{ ucwords(Auth::user()->user_name) }}</h3>
    <div class="row">
        <!-- <div class="col-md-6 col-sm-6 col-xs-12 gutter">
            <div class="sales">
               <h4>Incentive Graph:</h4>
                    <span class="year-title">2000 to 2005</span><span class="pull-right strong">28%</span>
                     <div class="progress">
                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="15"aria-valuemin="0" aria-valuemax="100" style="width:15%">15%</div>
                    </div>
                
                    <span class="year-title">2006 to 2015</span><span class="pull-right strong">58%</span>
                     <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="58"aria-valuemin="0" aria-valuemax="100" style="width:58%">58%</div>
                    </div>
                
                    <span class="year-title">2018 to 2019</span><span class="pull-right strong">88%</span>
                     <div class="progress">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="88"aria-valuemin="0" aria-valuemax="100" style="width:88%">88%</div>
                    </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 gutter">
            <div class="sales">
                <h4>Report Graph</h4>
                <span class="year-title">2000 to 2005</span><span class="pull-right strong">28%</span>
                 <div class="progress">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="15"aria-valuemin="0" aria-valuemax="100" style="width:15%">15%</div>
                </div>
            
                <span class="year-title">2006 to 2015</span><span class="pull-right strong">58%</span>
                 <div class="progress">
                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="58"aria-valuemin="0" aria-valuemax="100" style="width:58%">58%</div>
                </div>
            
                <span class="year-title">2018 to 2019</span><span class="pull-right strong">88%</span>
                 <div class="progress">
                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="88"aria-valuemin="0" aria-valuemax="100" style="width:88%">88%</div>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection
