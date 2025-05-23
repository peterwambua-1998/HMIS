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

//use Illuminate\Routing\Route;

use App\Http\Controllers\RadiologyServiceController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');



// Auth Routes
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => '', 'uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);

// Password Reset Routes...
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/reset', ['as' => 'password.update', 'uses' => 'Auth\ResetPasswordController@reset']);
Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
// End Auth Routes

//User Profile Language and Dashboard
Route::get('/profile', ['as' => 'profile', 'uses' => 'HomeController@profile'])->middleware('auth', 'lang');
Route::get('/dash', ['as' => 'dash', 'uses' => 'HomeController@index'])->middleware('auth', 'lang');
Route::get('/lang/{lan}', ['as' => 'lang', 'uses' => 'HomeController@setLocale'])->middleware('auth');
Route::post('/changepassword', ['as' => 'change_password', 'uses' => 'UserController@changeUserPassword'])->middleware('auth');
Route::post('/changepropic', ['as' => 'change_propic', 'uses' => 'UserController@changeUserPropic'])->middleware('auth');
Route::post('/changecontactnumber', ['as' => 'changecontactnumber', 'uses' => 'UserController@changecontactnumber'])->middleware('auth');
Route::post('/changeemail', ['as' => 'changeemail', 'uses' => 'UserController@changeemail'])->middleware('auth');
Route::post('/edituserprofile', ['as' => 'editprofile', 'uses' => 'UserController@editprofile'])->middleware('auth');

//Make channels Routes
Route::post('/channel', ['as' => 'makechannel', 'uses' => 'PatientController@getPatientData']);
Route::post('/appoint', ['as' => 'makeappoint', 'uses' => 'PatientController@addChannel']);
Route::get('/createappointment', ['as' => 'create_channel_view', 'uses' => 'PatientController@create_channel_view']);

// Patients Registration (In Patient Out Patients)
Route::get('/patient', ['as' => 'patient', 'uses' => 'PatientController@index']);
Route::get('/patientregcard/{pid}', ['as' => 'pregcard', 'uses' => 'PatientController@regcard']);
Route::post('/patientregister', ['as' => 'patient_register', 'uses' => 'PatientController@registerPatient']);
Route::get('/inpatientregister', ['as' => 'register_in_patient_view', 'uses' => 'PatientController@register_in_patient_view']);
Route::post('/inpatientregister2', ['as' => 'regInPatient', 'uses' => 'PatientController@regInPatientValid']);
Route::post('/inpatientregister3', ['as' => 'save_inpatient', 'uses' => 'PatientController@store_inpatient']);
Route::get('/dischargeInpatient', ['as' => 'discharge_inpatient', 'uses' => 'PatientController@discharge_inpatient']);
Route::post('/dischargeInpatient2', ['as' => 'disInPatient', 'uses' => 'PatientController@disInPatientValid']);
Route::post('/dischargeInpatient3', ['as' => 'save_disinpatient', 'uses' => 'PatientController@store_disinpatient']);

// Issue Medicine(Pharmacist Routes)
Route::post('/searchPharmacy',['as' => 'searchPharmacy', 'uses' => 'MedicineController@search'])->middleware('auth', 'pharmacist');
Route::get('/issueMedicine', ['as' => 'issueMedicineView', 'uses' => 'MedicineController@issueMedicineView'])->middleware('auth', 'pharmacist', 'lang');
Route::post('/issuemed-validate', ['as' => 'issueMedicine2', 'uses' => 'MedicineController@issueMedicineValid'])->middleware('auth', 'pharmacist', 'lang');
Route::get('/issue/{presid}', ['as' => 'issue', 'uses' => 'MedicineController@issueMedicine'])->middleware('auth', 'pharmacist', 'lang');
Route::post('/issuemark', ['as' => 'markIssued', 'uses' => 'MedicineController@markIssued'])->middleware('auth', 'pharmacist', 'lang');
Route::get('/med-issue-save', ['as' => 'medIssueSave', 'uses' => 'MedicineController@medIssueSave'])->middleware('auth', 'pharmacist', 'lang');

// Check Patient Routes
Route::get('/checkpatient', ['as' => 'check_patient_view', 'uses' => 'PatientController@checkPatientView']);
Route::post('/validateAppNum', ['as' => 'validateAppNum', 'uses' => 'PatientController@validatePatientName']);
Route::post('/checkpatient', ['as' => 'checkPatient', 'uses' => 'PatientController@checkPatient']);
Route::post('/checksave', ['as' => 'checkSave', 'uses' => 'PatientController@checkPatientSave']);
Route::post('/addclinic', ['as' => 'addToClinic', 'uses' => 'PatientController@addToClinic']);
Route::get('/appointment-report/{id}',['as' => 'appointmentReport', 'uses' => 'AppointmentReportController@report']);


// In patient Routes
Route::post('/markinpatient', ['as' => 'markInPatient', 'uses' => 'PatientController@markInPatient'])->middleware('auth', 'doctor');
Route::get('/in-reports', ['as' => 'inPatientReport', 'uses' => 'PatientController@inPatientReport'])->middleware('auth', 'staff');
Route::get('/reports-data', ['as' => 'inPatientReportData', 'uses' => 'PatientController@inPatientReportData'])->middleware('auth', 'staff');

// Search & Patient Profile Routes
Route::get('/searchpatient', ['as' => 'searchPatient', 'uses' => 'PatientController@searchPatient']);
Route::get('/search', ['as' => 'searchData', 'uses' => 'PatientController@patientData']);
Route::get('/patient-profile', ['as' => 'patientProfileIntro', 'uses' => 'PatientController@patientProfileIntro'])->middleware('auth', 'staff', 'lang', 'triage');
Route::get('/patient/{id}', ['as' => 'patientProfile', 'uses' => 'PatientController@patientProfile'])->middleware('auth', 'lang', 'staff', 'triage');
Route::get('/patient-delete/{id}/{action}', ['as' => 'patientDelete', 'uses' => 'PatientController@patientDelete'])->middleware('auth', 'doctor', 'lang', 'triage');
Route::get('/patient-history/{id}', ['as' => 'patientHistory', 'uses' => 'PatientController@patientHistory']);

//edit patitent routes
Route::post('/editpatient', ['as' => 'editpatient', 'uses' => 'PatientController@editPatientview'])->middleware('auth', 'doctor', 'lang');

//update patitent routes
Route::post('/updatepatientdetails', ['as' => 'updatepatientdetails', 'uses' => 'PatientController@updatePatient'])->middleware('auth', 'doctor', 'lang');


//Attendance Routes
Route::get('/myattend', ['as' => 'myattend', 'uses' => 'AttendController@myattend'])->middleware('auth', 'lang');
Route::get('/attendmore', ['as' => 'attendmore', 'uses' => 'AttendController@attendmore'])->middleware('auth', 'admin', 'lang');
Route::get('/attendance', ['as' => 'attendance', 'uses' => 'AttendController@markattendance'])->middleware('guest');
Route::post('/getyearattendance', ['as' => 'getyearattendance', 'uses' => 'AttendController@myattend'])->middleware('auth', 'lang');
Route::post('/getattendancebyid', ['as' => 'getattendancebyid', 'uses' => 'AttendController@attendmore'])->middleware('auth', 'lang');

// Admin Routes For User Registration and Management
Route::get('/regfinger', ['as' => 'regfinger', 'uses' => 'UserController@showRegFingerprint'])->middleware('auth', 'admin', 'lang');
Route::post('regfinger', ['as' => 'user.regfinger', 'uses' => 'UserController@regFinger'])->middleware('auth', 'admin');
Route::get('/newuser', ['as' => 'newuser', 'uses' => 'UserController@regNew'])->middleware('auth', 'admin', 'lang');
Route::get('/resetuser', ['as' => 'resetuser', 'uses' => 'UserController@resetUserView'])->middleware('auth', 'lang', 'admin');
Route::post('/resetusersave', ['as' => 'resetuser_save', 'uses' => 'UserController@resetUser'])->middleware('auth', 'admin');

// Admin Routes For Notices
Route::get('/createnoticeview', ['as' => 'createnoticeview', 'uses' => 'UserController@createnoticeview'])->middleware('auth', 'lang');
Route::post('/sendnotice', ['as' => 'sendnotice', 'uses' => 'UserController@send_notice'])->middleware('auth');
Route::get('/emails', ['as' => 'emails', 'uses' => 'UserController@email'])->middleware('auth');
Route::post('/addnotice', ['as' => 'addnotice', 'uses' => 'NoticeboardController@addnotice'])->middleware('auth');
Route::post('/deletenotice', ['as' => 'deletenotice', 'uses' => 'NoticeboardController@deletenotice'])->middleware('auth');


// Report Generation Routes
Route::get('/reportgeneration', ['as' => 'reportgeneration', 'uses' => 'UserController@reportgen'])->middleware('auth');
Route::get('/clinicreports', ['as' => 'clinic_reports', 'uses' => 'ReportController@viewclinicreport'])->middleware('auth');
Route::post('/printclinicreports', ['as' => 'print_clinic', 'uses' => 'ReportController@printclinicreport'])->middleware('auth');
Route::get('/mobclinicreport', ['as' => 'mob_clinic_report', 'uses' => 'ReportController@view_mobile_clinic_report'])->middleware('auth');
Route::get('/monstatreport', ['as' => 'mon_stat_report', 'uses' => 'ReportController@view_monthly_static_report'])->middleware('auth', 'lang');
Route::get('/outpreport', ['as' => 'out_p_report', 'uses' => 'ReportController@view_out_patient_report'])->middleware('auth');
Route::get('/attendancereport', ['as' => 'attendance_report', 'uses' => 'ReportController@view_attendance_report'])->middleware('auth');
Route::get('/wardreport', ['as' => 'ward_report', 'uses' => 'ReportController@view_ward_report'])->middleware('auth');
Route::post('/generatereports', ['as' => 'gen_att_reports', 'uses' => 'ReportController@gen_att_reports'])->middleware('auth');
Route::get('/allprintpreview', ['as' => 'all_print_preview', 'uses' => 'ReportController@all_print_preview'])->middleware('auth');

//Ward Management Routes
Route::get('/wards', ['as' => 'wards', 'uses' => 'WardController@index'])->middleware('auth');
Route::post('/add-ward', ['as' => 'add-ward', 'uses' => 'WardController@createWard'])->middleware('auth');
Route::get('/wards', ['as' => 'wards', 'uses' => 'WardController@index'])->middleware('auth', 'lang');

// Other Routes
Route::get('/herbs', ['as' => 'herbs', 'uses' => 'MedicineController@getherbs']);
Route::get('/wardlist', 'PatientController@get_ward_list');

// Statistics Routes
Route::get('/stats', ['as' => 'stats', 'uses' => 'AnalyticsController@index'])->middleware('doctor', 'admin');
Route::post('/stats-old', ['as' => 'stats_old', 'uses' => 'AnalyticsController@index'])->middleware('doctor', 'admin');


//Triage
Route::get('/searchtriage', ['as' => 'searchTriage', 'uses' => 'TriageController@index']);
Route::post('/searchpost', ['as' => 'searchTriagePost', 'uses' => 'TriageController@search']);
Route::post('/addtriage', ['as' => 'addTriage', 'uses' => 'TriageController@store']);
Route::post('/commence-triage', ['as' => 'commencetriage', 'uses' => 'TriageController@startTriage']);
//inpatient Triage
Route::post('/inpatientTriage', ['as' => 'inpatientTriage', 'uses' => 'InpatientController@sendToTriage']);


//Lab
Route::get('/searchlab', ['as' => 'searchLab', 'uses' => 'LabController@index']);
Route::post('/searchpostlab', ['as' => 'searchLabPost', 'uses' => 'LabController@search']);
Route::post('/addLab', ['as' => 'addLab', 'uses' => 'LabController@store']);
Route::post('/commence-lab', ['as' => 'commencelab', 'uses' => 'LabController@startLab']);
Route::get('/lab-measures-create', ['as' => 'labMeasureCreate', 'uses' => 'LabController@addMeasurePage']);
Route::get('/lab-measures', ['as' => 'labMeasure', 'uses' => 'LabController@measureList']);
Route::post('/save-measure', ['as' => 'saveMeasure', 'uses' => 'LabController@saveMeasure']);
Route::get('/edit-measure/{id}', ['as' => 'measure_edit', 'uses' => 'LabController@editMeasure']);
Route::post('/update-measure', ['as' => 'measure_update', 'uses' => 'LabController@updateMeasure']);
Route::get('/lab-queue',['as' => 'labqueue', 'uses' => 'LabController@queueView']);

//Dialysis
Route::get('/searchdialysis', ['as' => 'searchDialysis', 'uses' => 'DialysisController@index']);
Route::get('/searchdialysispost', ['as' => 'searchDialysisPost', 'uses' => 'DialysisController@search']);
Route::post('/adddialysis', ['as' => 'addDialysis', 'uses' => 'DialysisController@store']);
Route::post('/intro-dialysis', ['as' => 'introdialysis', 'uses' => 'DialysisController@intro']);

//Check Patient Routes
Route::get('/checkpatientdentals', ['as' => 'check_patient_viewDental', 'uses' => 'DentalController@checkPatientView'])->middleware('auth', 'doctor', 'lang', 'admin');
Route::post('/validateAppNumDental', ['as' => 'validateAppNumDental', 'uses' => 'DentalController@validateAppNum'])->middleware('auth', 'doctor', 'lang');
Route::post('/checkpatientDental', ['as' => 'checkPatientDental', 'uses' => 'DentalController@checkPatient'])->middleware('auth', 'doctor', 'lang');
Route::post('/checksaveDental', ['as' => 'checkSaveDental', 'uses' => 'DentalController@checkPatientSave'])->middleware('auth', 'doctor', 'lang');
Route::post('/addclinicDental', ['as' => 'addToClinicDental', 'uses' => 'DentalController@addToClinic'])->middleware('auth', 'doctor', 'lang');


//radiology and imaging
Route::get('/searchradiology', ['as' => 'searchRadiology', 'uses' => 'RadiologyimagingController@index']);
Route::post('/searchradiologypost', ['as' => 'searchradiologypost', 'uses' => 'RadiologyimagingController@search']);
Route::post('/addradiology', ['as' => 'addRadiology', 'uses' => 'RadiologyimagingController@store']);
Route::post('/commence-radiology', ['as' => 'commenceradiology', 'uses' => 'RadiologyimagingController@startRadiology']);
Route::resource('radiology-services', 'RadiologyServiceController')->only('index','store','update','destroy');
Route::post('/radiology-patient-measures', ['as' => 'patientRadiologyMeasures', 'uses' => 'MeasureController@storeRadiology']);

//physiotherapy
Route::get('/searchphysiotherapy', ['as' => 'searchphysiotherapy', 'uses' => 'PhysiotherapyController@index']);
Route::get('/searchphysiotherapypost', ['as' => 'searchphysiotherapypost', 'uses' => 'PhysiotherapyController@search']);
Route::post('/addphysiotherapy', ['as' => 'addphysiotherapy', 'uses' => 'PhysiotherapyController@store']);


//inventory

Route::get('/medinventory', ['as' => 'medinventory', 'uses' => 'InventoryController@index']);
Route::get('/medinventoryadd', ['as' => 'medinventoryadd', 'uses' => 'InventoryController@create']);
Route::post('/medinventoryaddmed', ['as' => 'medinventoryaddmed', 'uses' => 'InventoryController@store']);
Route::patch('/medinventoryupdate/{id}', ['as' => 'medinventoryupdate', 'uses' => 'InventoryController@update']);


//theatre
Route::get('/searchtheatre', ['as' => 'searchtheatre', 'uses' => 'TheatreController@index']);
Route::get('/searchtheatrepost', ['as' => 'searchtheatrepost', 'uses' => 'TheatreController@search']);
Route::post('/addtheatre', ['as' => 'addtheatre', 'uses' => 'TheatreController@store']);
Route::post('/theatre-measures', ['as' => 'theatremeasures', 'uses' => 'TheatreMeasureController@store']);

//discharged patients
Route::get('/dischaged', ['as' => 'dischaged', 'uses' => 'DischargedPatientController@index']);

//cashier
Route::get('/cashiercheckp', ['as'=> 'cashiercheckp', 'uses'=>'CashierController@index']);
Route::post('/searchcashierpost', ['as' => 'searchcashierpost', 'uses' => 'CashierController@search']);
Route::post('/commence-cashier', ['as' => 'commencecashier', 'uses' => 'CashierController@startCashier']);
Route::post('/cashiercheckpprint', ['as' => 'cashiercheckprint', 'uses' => 'CashierController@print']);
Route::get('/inpatientlist', ['as' => 'inpatientlist', 'uses' => 'CashierController@inpatientQueue']);
Route::get('/allservices', ['as' => 'allservices', 'uses' => 'CashierController@getService']);
Route::get('/searchservice', ['as' => 'searchservice', 'uses' => 'CashierController@searchService']);
Route::get('/services/{id}',['as' => 'services', 'uses' => 'CashierController@getServices']);
Route::get('/cashier-queue',['as' => 'cashierqueue', 'uses' => 'CashierController@queueView']);
//Route::post('/addtheatre', ['as' => 'addtheatre', 'uses' => 'TheatreController@store']);

//lab measrures
Route::post('/measures', ['as' => 'measures', 'uses' => 'MeasureController@store']);

//radiology/imaging measrures
Route::post('/radiologymeasures', ['as' => 'radiologymeasures', 'uses' => 'MeasureradiologyController@store']);

//Accounts
Route::get('/accounts-search', ['as' => 'accountsearch', 'uses' => 'AccountController@index']);


//inpatient

Route::get('/check-inpatient-search', ['as' => 'checkinpatientsearch', 'uses' => 'InpatientController@index']);
Route::get('/inpatient-search-result', ['as' => 'inpatientsearchresult', 'uses' => 'InpatientController@search']);
Route::get('/inpatient-queue', ['as' => 'inpatientqueue', 'uses' => 'InpatientController@inpatientQueue']);
Route::post('/validateAppNumInpatient', ['as' => 'validateAppNumInpatient', 'uses' => 'InpatientController@validateAppNum']);
Route::post('/checkinpatient', ['as' => 'checkInPatient', 'uses' => 'InpatientController@checkPatient']);
Route::post('/checksaveinpatient', ['as' => 'checksaveinpatient', 'uses' => 'InpatientController@checkInpatientSave']);
Route::post('/inptient-edit/{id}', ['as' => 'inptientedit', 'uses' => 'InpatientController@edit']);
Route::patch('/inptient-edit-save/{id}', ['as' => 'inptienteditsave', 'uses' => 'InpatientController@update']);


//Mertanity 

Route::get('/checkmertanitypatient', ['as' => 'checkmertanitypatient', 'uses' => 'AntenatalController@checkPatientView']);
Route::post('/checkmertanitypatientview', ['as' => 'checkmertanitypatientview', 'uses' => 'AntenatalController@checkPatient']);
Route::post('/checkmertanitysave', ['as' => 'checkmertanitysave', 'uses' => 'AntenatalController@checkPatientSave']);
Route::post('/inpatientmertanityregister', ['as' => 'inpatientmertanityregister', 'uses' => 'AntenatalController@store_inpatient']);
Route::get('/deliveryinto', ['as' => 'deliveryinto', 'uses' => 'AntenatalController@deliveryinto']);

Route::post('/deliveryformbegin', ['as' => 'deliveryformbegin', 'uses' => 'AntenatalController@deliveryformbegin']);
Route::post('/savedeliveryinfo', ['as' => 'savedeliveryinfo', 'uses' => 'AntenatalController@savedeliveryinfo']);

//Route::post('/validateAppNum', ['as' => 'validateAppNum', 'uses' => 'PatientController@validateAppNum']);


//send patient to dentist from consultation
Route::post('/consultation-sendto-dentist', ['as' => 'consultation-sendto-dentist','uses' => 'PatientController@sendToDentistFromConsultation']);
//send patient to phsiotherapy from consultation
Route::post('/consultation-sendto-physiotherapy', ['as' => 'consultation-sendto-physiotherapy','uses' => 'PatientController@sendToPhysiotherapyFromConsultation']);

//excel medicine
Route::get('/medicine-excel-view', ['as' => 'medexcelview', 'uses' => "MedicineExcelController@index"]);
Route::post('/medicine-excel-store', ['as' => 'medexcelstore', 'uses' => "MedicineExcelController@store"]);

//Surgery 
Route::resource('surgery-services', 'SurgaryServiceController');
Route::post('surgery-measures', ['as' => 'storeSurgery', 'uses' => "MeasureController@storeSurgery"]);
Route::get('/suregry-search-patient',['as' => 'surgerySearchPatient', 'uses' => 'SurgeryController@index']);
Route::post('/suregry-search-patient-get',['as' => 'surgerySearchPatientGet', 'uses' => 'SurgeryController@search']);
Route::post('/suregry',['as' => 'surgeryStart', 'uses' => 'SurgeryController@startSurgery']);
Route::post('/suregry-report-store',['as' => 'surgeryStore', 'uses' => 'SurgeryController@store']);