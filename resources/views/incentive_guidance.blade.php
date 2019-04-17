@extends('layouts.main')

@section('content')
<style type="text/css">
	
/******************Simulator css*****************/
.user-dashboard {
    background: #00adee;
    width: 100%;
    float: left;
    padding: 15px;
}
.user-dashboard img{
    width: 55px;
    height: 55px;
    float: left;
    border-radius: 50%;
    border: 2px solid #fff;
}
.details {
    width: 60%;
    float: left;
    margin-left: 15px;
}
.details h2 {
    margin-top: 0;
    font-size: 17px;
    font-weight: 600;
    color: #fff;
}
.details p {
    font-size: 10px;
    line-height: 8px;
    color: #fff;
}
.table-area {

    background: #fff;
    width: 98%;
    margin: 0 auto;
    box-shadow: 1px 1px 5px 2px #ccc;
    border-radius: 5px;

}
.user-data-main h2 {

    text-align: center;
    padding: 50px 0;
    margin-top: 0;
    color: #045059;
    font-weight: 700;
    text-transform: uppercase;

}
.total-tb {

    width: 100%;
    background: #00adee;
    border: none;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;

}
.total-tb > th, .total-tb > td {

    border: none !important;
    color: #fff !important;
    font-weight: 600 !important;
    font-size: 17px !important;

}
.table
{
    margin-bottom: 0 !important;
}
.user-data-main {
    width: 100%;
    float: left;
    padding: 0 0 30px;
}
.user-data-main .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
    border-bottom-width: 2px;
    color: #045059;
    font-size: 14px;
    text-transform: uppercase;
}
.user-data-main .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th{
    color: #045059;
    font-size: 12px;
}
.heading-tb > th {
    font-size: 16px !important;
    padding: 15px 9px !important;
}

/************range slider***********/
.rangeslider,
.rangeslider__fill {
    display:block;
    border-radius:10px;
}

.rangeslider {
    position:relative;
}
.rangeslider:after{
    top:50%;
    left:0;
    right:0;
    content:'';
    width:100%;
    height:5px;
    margin-top:-2.5px;
    border-radius:5px;
    position:absolute;
    background:#00adee66;
}

.rangeslider--horizontal{
    width:100%;
    height:28px;
}

.rangeslider--vertical{
    width:5px;
    min-height:150px;
    max-height:100%;
}
.rangeslider--disabled{
    filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=40);
    opacity:0.4;
}

.rangeslider__fill{
    position:absolute;
    background:#00adee;
}
.rangeslider--horizontal .rangeslider__fill{
    top:0;
    height:100%;
}
.rangeslider--vertical .rangeslider__fill{
    bottom:0;
    width:100%;
}

.rangeslider__handle{
    top:50%;
    width:28px;
    height:28px;
    cursor:pointer;
    margin-top:-14px;
    background:white;
    position:absolute;
    background:#00adee;
    border-radius:50%;
    display:inline-block;
}
.rangeslider__handle:active{
    background:#00adee;
}

.rangeslider__fill,
.rangeslider__handle{
    z-index:1;
}
.rangeslider--horizontal .rangeslider__fill{
    top:50%;
    height:5px;
    margin-top:-2.5px;
}

/* Budget */

.budget-wrap .header .title{
    color:#fff;
    font-size:18px;
    
}
.budget-wrap .header .title .pull-right{
     font-size: 14px;
    color: #045059;
    font-weight: 600;
}
.budget-wrap .footer{
    margin-top:30px;
}
.budget-wrap .footer .btn{
    color:inherit;
    padding:12px 24px;
    border-radius:50px;
    display:inline-block;
    text-decoration:none;
}
.budget-wrap .footer .btn.btn-def{
    color:#525263;
}
.budget-wrap .footer .btn.btn-pri{
    color:#eee;
    background:#ff5a84;
}
.budget img {
    width: 40px;
    height: 40px;
    float: left;
    border-radius: 50%;
    border: 2px solid #00adee;
}
.content {
    float: left;
    width: 100%;
    padding: 5px 0 5px;
}
.budget-wrap {
    width: 100%;
    display: inline-block;
    padding: 17px;
}
.budget-wrap .title.clearfix p {
    font-size: 14px;
    color: #045059;
    font-weight: 600;
    float: left;
}
.budget-wrap .header {
    float: left;
    width: 100%;
}
.budget-wrap .title.clearfix {
    float: right;
}
.title-brand {
    float: left;
    margin-left: 12px;
    padding: 11px 0;
}
.title-brand h3{
    margin-top: 0;
}
.left-value {
    float: left;
}
.left-value p {

    font-size: 14px;
    color: #045059;
    font-weight: 600;

}
.table-range {
    padding: 24px 0 0;
}
.rg-head-bg {

    width: 100%;
    padding: 16px 25px;
    background: #eee;

}
.range-head h3 {

    font-size: 20px;
    margin: 0;
    color: #045059;
    font-weight: 600;

}
.title-brand h3{
    font-size: 15px;
    margin: 0;
    color: #045059;
    font-weight: 600;

}
/**********rabge slider end**********/

.total-range{
    width: 100%;
    float: left;
    background:#00adee;
    padding: 0px 25px;
}
.total-range h4{
    float: left;
    color: #fff;
    font-weight: 600;
    font-size: 20px;
}
.total-range h3{
    float: right;
    color: #fff;
    font-weight: 600;
    font-size: 20px;
    margin-top: 8px;
}
</style>
    <div class="row">
        <div class="user-dashboard">
            <div class="user-details">
                <img src="{{ asset('public/images/client.png') }}">
                <span class="details">
                    <h2> MR. PUSHPENDRA DUTT</h2>
                    <p>DESG: BE ,HQ TYPE: METRO , DIVISION: PHARMA ,ZONE: WEST</p>
                    <p>REGION: GWALIOR ,AREA: GUNA , TERRITORY: SHIVPURI</p>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="user-data-main">
            <h2>Incentive Guidance </h2>
            <div class="table-area">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Incentive Type</th>
                        <th scope="col">Unit/ Value </th>
                        <th scope="col">Target</th>
                        <th scope="col">Achievement </th>
                        <th scope="col">Achievement %</th>
                        <th scope="col">Incentive Earning(INR)</th>
                        <th scope="col">Additional Effort Required</th>
                        <th scope="col">Additional Incentive (INR)</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">Quarterly (QTR-1) </th>
                        <td>Value In INR</td>
                        <td>732000</td>
                        <td>402600</td>
                        <td>55%</td>
                        <td>0</td>
                        <td>329400</td>
                        <td>21960</td>
                        
                      </tr>
                      <tr class="heading-tb">
                        <th colspan="8">Quarterly Brand Incentive</th>
                      </tr>
                      <tr>
                        <th scope="row">ACERA </th>
                        <td>Units</td>
                        <td>250</td>
                        <td>260</td>
                        <td>104%</td>
                        <td>780</td>
                        <td></td>
                        <td></td>
                        
                      </tr>
                      <tr>
                        <th scope="row">AZIBACT</th>
                        <td>Units</td>
                        <td>300</td>
                        <td>320 </td>
                        <td>107% </td>
                        <td>960</td>
                        <td></td>
                        <td></td>
                        
                      </tr>
                      <tr>
                        <th scope="row">ELECTROSIP</th>
                        <td>Units</td>
                        <td>200</td>
                        <td>210 </td>
                        <td>105%</td>
                        <td>630</td>
                        <td></td>
                        <td></td>
                        
                      </tr>
                      <tr>
                        <th scope="row">SOLVIN </th>
                        <td>Units</td>
                        <td>300</td>
                        <td>340 </td>
                        <td>113%</td>
                        <td>1020</td>
                        <td></td>
                        <td></td>
                        
                      </tr>
                       <tr>
                        <th scope="row">PERISET</th>
                        <td>Units</td>
                        <td>210</td>
                        <td>200 </td>
                        <td>95%</td>
                        <td>0</td>
                        <td>10</td>
                        <td>630</td>
                        
                      </tr>
                      <tr>
                        <th scope="row">RXPLUS</th>
                        <td>Units</td>
                        <td>320</td>
                        <td>280 </td>
                        <td>87%</td>
                        <td>0</td>
                        <td>40</td>
                        <td>960</td>
                        
                      </tr>
                      <tr>
                        <th scope="row">VINICOR</th>
                        <td>Units</td>
                        <td>100</td>
                        <td>120 </td>
                        <td>120%</td>
                        <td>360</td>
                        <td></td>
                        <td></td>
                        
                      </tr>
                      <tr>
                        <th scope="row">ZERODOL</th>
                        <td>Units</td>
                        <td>180</td>
                        <td>190 </td>
                        <td>105% </td>
                        <td>570</td>
                        <td></td>
                        <td></td>
                        
                      </tr>
                      <tr>
                        <th scope="row">RAPICLAV </th>
                        <td>Units</td>
                        <td>300</td>
                        <td>240 </td>
                        <td>80% </td>
                        <td>0</td>
                        <td>60</td>
                        <td>900</td>
                        
                      </tr>
                      <tr class="total-tb">
                        <th scope="row">Total </th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>4320</td>
                        <td></td>
                        <td>24450</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
@endsection
