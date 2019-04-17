<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

//Route::get('/user/login', 'Auth\UserLoginController@showLoginForm')->name('teacher.login');
Route::post('/user/login', 'UserloginController@login')->name('user.login.post');
Route::post('/user/logout', 'UserloginController@logout')->name('user.logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

/* supporting rotes  */
Route::post('/get-brands-by-df', 'HomeController@get_brands_by_df')->name('get-brands-by-df');
Route::post('/get-incentive-type-category', 'HomeController@get_category_by_division')->name('get-incentive-type-category');

/* Incentive Configurator Load View*/
Route::get('/incentive-configurator/slab', 'IncentiveConfiguratorController@load_incentive_configurator_slab')->name('incentive-configurator-slab');
Route::get('/incentive-configurator/prospective-earner-factor', 'IncentiveConfiguratorController@load_incentive_configurator_pef')->name('incentive-configurator-prospective-earner-factor');
Route::post('/incentive-type-slab', 'IncentiveConfiguratorController@incentive_type_slab')->name('incentive-type-slab');
Route::post('/incentive-type-prospective', 'IncentiveConfiguratorController@incentive_type_prospective')->name('incentive-type-prospective');
Route::get('/incentive-configurator', 'IncentiveConfiguratorController@incentive_configurator')->name('incentive-configurator');
Route::post('/single-save-prospective', 'IncentiveConfiguratorController@single_save_prospective')->name('single-save-prospective');
Route::post('/all-save-prospective-perc', 'IncentiveConfiguratorController@all_save_prospective_perc')->name('all-save-prospective-perc');

Route::post('/save-incentive-type', 'IncentiveConfiguratorController@save_incentive_slab')->name('save-incentive-type');
Route::post('/update-incentive-type', 'IncentiveConfiguratorController@updateIncentiveSlabl')->name('update-incentive-type');



/* Process */
Route::get('/process', 'ProcessController@process')->name('process');
Route::post('/process/audit_process', 'ProcessController@audit_process')->name('audit_process');
Route::get('/process/audit', 'ProcessController@load_audit_process')->name('process-audit');
Route::get('/process/actual', 'ProcessController@load_actual_process')->name('process-actual');
Route::post('/update-process', 'ProcessController@processor_query')->name('update-process');


/*Audit Reports Load View Section */
Route::get('/reports/general', 'ReportController@load_report_general')->name('reports-general');
Route::get('/reports/audit', 'ReportController@load_report_audit')->name('reports-audit');

Route::get('/reports/incentive-audit-report-non-brand', 'ReportController@incentive_audit_report_non_brand')->name('reports-inc-aud-rep-nonbrand');
Route::get('/reports/incentive-audit-report-brand', 'ReportController@incentive_audit_report_brand')->name('reports-inc-aud-rep-brand');

/* Audit Reports generate section */
Route::post('/incentive-audit-report-non-brand-generate', 'ReportController@incentive_audit_report_non_brand_generate')->name('reports-inc-aud-rep-non-brand-generate');
Route::post('/incentive-audit-report-brand-generate', 'ReportController@incentive_audit_report_brand_generate')->name('reports-inc-aud-rep-brand-generate');

/*General Reports Load View Section */
Route::get('/reports/quarterly-incentive-report', 'ReportController@load_quarterly_incentive_report')->name('quarterly-incentive-report');

Route::get('/reports/annual-incentive-report', 'ReportController@load_annual_increment_report')->name('annual-incentive-report');
Route::get('/reports/annual-increment-incentive-report', 'ReportController@load_annual_increment_incentive_report')->name('annual-increment-incentive-report');


/* General Reports general section */
Route::post('/annual-incentive-report-generate', 'ReportController@annual_incentive_report_generate')->name('annual-incentive-report-generate');
Route::post('/annual-increment-incentive-report-generate', 'ReportController@annual_increment_incentive_report_generate')->name('annual-increment-incentive-report-generate');


Route::get('/reports/annual-increament-guidance-report', 'ReportController@load_aig_report')->name('annual-increament-guidance-report');
Route::get('/reports/annual-achievement-guidance-report', 'ReportController@load_aag_report')->name('annual-achievement-guidance-report');
Route::get('/reports/incentive-audit-report', 'ReportController@load_ia_report')->name('incentive-audit-report');
Route::get('/reports/quarterly-brand-incentive-audit-report', 'ReportController@load_quarterly_brand_incentive_audit_report')->name('quarterly-brand-incentive-audit-report');
Route::post('/quaterly-qb-incentive-report', 'ReportController@quarterly_qb_incentive_report')->name('quaterly-qb-incentive-report');

Route::post('/annual-achievement-guidance-report-generate', 'ReportController@annual_achievement_guidance_report_generate')->name('annual-achievement-guidance-report-generate');
Route::post('/annual-increment-guidance-report-generate', 'ReportController@annual_increment_guidance_report_generate')->name('annual-increment-guidance-report-generate');
Route::post('/incentive-audit-report-generate', 'ReportController@incentive_audit_report_generate')->name('incentive-audit-report-generate');


/* Incentive Simulator */
Route::get('/incentive-simulator', 'SimulatorController@load_incentive_simulator')->name('incentive-simulator');

/* Incentive Guidance */
Route::get('/incentive-guidance', 'GuidanceController@load_incentive_guidance')->name('incentive-guidance');