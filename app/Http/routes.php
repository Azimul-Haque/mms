<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/clear', ['as'=>'clear','uses'=>'IndexController@clear']);

// index routes
// index routes
Route::get('/', ['as'=>'index.index','uses'=>'IndexController@index']);
Route::get('/home', ['as'=>'index.homeadhoc','uses'=>'IndexController@homeAdhoc']); // reset password redirect adhoc solve
Route::get('/about', ['as'=>'index.about','uses'=>'IndexController@getAbout']);
Route::get('/contact', ['as'=>'index.contact','uses'=>'IndexController@getContact']);
// Route::get('/people/directors', ['as'=>'index.directors','uses'=>'IndexController@getDirectors']);
// Route::get('/people/advisors', ['as'=>'index.advisors','uses'=>'IndexController@getAdvisors']);
// Route::get('/people/employees', ['as'=>'index.employees','uses'=>'IndexController@getEmployees']);
// Route::get('/people/members', ['as'=>'index.members','uses'=>'IndexController@getMembers']);
// Route::get('/profile/{unique_key}', ['as'=>'index.profile','uses'=>'IndexController@getProfile']);

// Route::get('/research/expertise/{slug}', ['as'=>'index.expertise','uses'=>'IndexController@getExpertise']);

// Route::get('/projects', ['as'=>'index.projects','uses'=>'IndexController@getProjects']);
// Route::get('/project/{slug}', ['as'=>'index.project','uses'=>'IndexController@getProject']);

// Route::get('/publications', ['as'=>'index.publications','uses'=>'IndexController@getPublications']);
// Route::get('/publication/{code}', ['as'=>'index.publication','uses'=>'IndexController@getPublication']);


// Route::get('/disaster/data', ['as'=>'index.disasterdata','uses'=>'IndexController@getDisasterdata']);
// Route::get('/disaster/data/{category_id}/api', ['as'=>'index.disasterdata.api','uses'=>'IndexController@getDisasterdataAPI']);

// Route::get('/constitution', ['as'=>'index.constitution','uses'=>'IndexController@getConstitution']);
// Route::get('/faq', ['as'=>'index.faq','uses'=>'IndexController@getFaq']);
// Route::get('/executive', ['as'=>'index.executive','uses'=>'IndexController@getExecutive']);
// Route::get('/news', ['as'=>'index.news','uses'=>'IndexController@getNews']);
// Route::get('/events', ['as'=>'index.events','uses'=>'IndexController@getEvents']);
// Route::get('/gallery', ['as'=>'index.gallery','uses'=>'IndexController@getGallery']);
// Route::post('/contact/form/message/store', ['as'=>'index.storeformmessage','uses'=>'IndexController@storeFormMessage']);
// Route::get('/application', ['as'=>'index.application','uses'=>'IndexController@getApplication']);
// Route::get('/member/login', ['as'=>'index.login','uses'=>'IndexController@getLogin']);
// Route::post('/member/application/store', ['as'=>'index.storeapplication','uses'=>'IndexController@storeApplication']);

// index routes
// index routes

// blog routes
// blog routes
// Route::resource('blogs','BlogController');
// Route::get('blog/{slug}',['as' => 'blog.single', 'uses' => 'BlogController@getBlogPost']);
// Route::get('blogger/profile/{unique_key}',['as' => 'blogger.profile', 'uses' => 'BlogController@getBloggerProfile']);
// Route::get('/like/{user_id}/{blog_id}',['as' => 'blog.like', 'uses' => 'BlogController@likeBlogAPI']);
// Route::get('/check/like/{user_id}/{blog_id}',['as' => 'blog.checklike', 'uses' => 'BlogController@checkLikeAPI']);
// Route::get('/category/{name}',['as' => 'blog.categorywise', 'uses' => 'BlogController@getCategoryWise']);
// Route::get('/archive/{date}',['as' => 'blog.monthwise', 'uses' => 'BlogController@getMonthWise']);
// blog routes
// blog routes

Route::auth();

// dashboard routes
// dashboard routes
Route::resource('users','UserController');
Route::get('/dashboard', ['as'=>'dashboard.index','uses'=>'DashboardController@index']);

Route::get('/staffs', ['as'=>'dashboard.staffs','uses'=>'DashboardController@getStaffs']);
Route::get('/staffs/create', ['as'=>'dashboard.staffs.create','uses'=>'DashboardController@createStaff']);
Route::post('/staffs/store', ['as'=>'dashboard.staffs.store','uses'=>'DashboardController@storeStaff']);
Route::get('/staffs/{id}/edit', ['as'=>'dashboard.staffs.edit','uses'=>'DashboardController@editStaff']);
Route::put('/staffs/{id}/update', ['as'=>'dashboard.staffs.update','uses'=>'DashboardController@updateStaff']);
Route::get('/staffs/add/group/{id}/{routeto}', ['as'=>'dashboard.staffs.getaddgroup','uses'=>'DashboardController@getAddGroupToStaff']);
Route::post('/staffs/add/group/store', ['as'=>'dashboard.staffs.addgroup','uses'=>'DashboardController@addGroupToStaff']);

Route::get('/groups', ['as'=>'dashboard.groups','uses'=>'DashboardController@getGroups']);
Route::get('/groups/create', ['as'=>'dashboard.groups.create','uses'=>'DashboardController@createGroup']);
Route::post('/groups/store', ['as'=>'dashboard.groups.store','uses'=>'DashboardController@storeGroup']);
Route::get('/groups/{id}/edit', ['as'=>'dashboard.groups.edit','uses'=>'DashboardController@editGroup']);
Route::put('/groups/{id}/update', ['as'=>'dashboard.groups.update','uses'=>'DashboardController@updateGroup']);

Route::get('/loanandsavingnames', ['as'=>'dashboard.loanandsavingnames','uses'=>'DashboardController@getLoanAndNames']);
Route::get('/loannames/create', ['as'=>'dashboard.loannames.create','uses'=>'DashboardController@createLoanName']);
Route::post('/loannames/store', ['as'=>'dashboard.loannames.store','uses'=>'DashboardController@storeLoanName']);
Route::get('/loannames/{id}/edit', ['as'=>'dashboard.loannames.edit','uses'=>'DashboardController@editLoanName']);
Route::put('/loannames/{id}/update', ['as'=>'dashboard.loannames.update','uses'=>'DashboardController@updateLoanName']);
Route::get('/savingnames/create', ['as'=>'dashboard.savingnames.create','uses'=>'DashboardController@createSavingName']);
Route::post('/savingnames/store', ['as'=>'dashboard.savingnames.store','uses'=>'DashboardController@storeSavingName']);
Route::get('/savingnames/{id}/edit', ['as'=>'dashboard.savingnames.edit','uses'=>'DashboardController@editSavingName']);
Route::put('/savingnames/{id}/update', ['as'=>'dashboard.savingnames.update','uses'=>'DashboardController@updateSavingName']);
Route::get('/schemenames/create', ['as'=>'dashboard.schemenames.create','uses'=>'DashboardController@createSchemeName']);
Route::post('/schemenames/store', ['as'=>'dashboard.schemenames.store','uses'=>'DashboardController@storeSchemeName']);
Route::get('/schemenames/{id}/edit', ['as'=>'dashboard.schemenames.edit','uses'=>'DashboardController@editSchemeName']);
Route::put('/schemenames/{id}/update', ['as'=>'dashboard.schemenames.update','uses'=>'DashboardController@updateSchemeName']);

Route::get('/group/{s_id}/{g_id}/members', ['as'=>'dashboard.members','uses'=>'MemberController@getMembers']);
Route::get('/group/{s_id}/{g_id}/members/passbook', ['as'=>'dashboard.members.passbooklist','uses'=>'MemberController@getMembersPassbook']);
Route::post('/group/members/update/passbook/api', ['as'=>'dashboard.members.updatepassbook','uses'=>'MemberController@updatePassBook']);
Route::get('/group/{s_id}/{g_id}/members/create', ['as'=>'dashboard.members.create','uses'=>'MemberController@createMember']);
Route::post('/group/{s_id}/{g_id}/members/store', ['as'=>'dashboard.members.store','uses'=>'MemberController@storeMember']);
Route::get('/group/member/{id}/edit', ['as'=>'dashboard.members.edit','uses'=>'MemberController@editMember']);
Route::put('/group/member/{id}/update', ['as'=>'dashboard.members.update','uses'=>'MemberController@updateMember']);
Route::delete('/group/member/{id}/delete', ['as'=>'dashboard.member.delete','uses'=>'MemberController@deleteMember']);
Route::get('/group/{s_id}/{g_id}/transfer', ['as'=>'dashboard.group.gertransferpage','uses'=>'MemberController@getGroupTransfer']);
Route::put('/group/{id}/transfer', ['as'=>'dashboard.group.transfer','uses'=>'MemberController@transferGroup']);

Route::get('/group/{s_id}/{g_id}/{m_id}/member', ['as'=>'dashboard.member.single','uses'=>'MemberController@getSingleMember']);

// saving accounts
Route::get('/group/{s_id}/{g_id}/{m_id}/member/saving/accounts', ['as'=>'dashboard.member.savings','uses'=>'MemberController@getMemberSavings']);
Route::get('/group/{s_id}/{g_id}/{m_id}/member/saving/accounts/create', ['as'=>'dashboard.savings.create','uses'=>'MemberController@createSavingAccount']);
Route::post('/group/{s_id}/{g_id}/{m_id}/member/saving/accounts/store', ['as'=>'dashboard.savings.store','uses'=>'MemberController@storeSavingAccount']);
Route::put('/group/{s_id}/{g_id}/{m_id}/member/saving/accounts/update/{sv_id}', ['as'=>'dashboard.savings.update','uses'=>'MemberController@updateSavingAccount']);
Route::get('/group/{s_id}/{g_id}/{m_id}/member/saving/accounts/single/{sv_id}', ['as'=>'dashboard.savings.single','uses'=>'MemberController@getMemberSavingSingle']);

// loan accounts
Route::get('/group/{s_id}/{g_id}/{m_id}/member/loan/accounts', ['as'=>'dashboard.member.loans','uses'=>'MemberController@getMemberLoans']);
Route::get('/group/{s_id}/{g_id}/{m_id}/member/loan/accounts/create', ['as'=>'dashboard.loans.create','uses'=>'MemberController@createLoanAccount']);
Route::post('/group/{s_id}/{g_id}/{m_id}/member/loan/accounts/store', ['as'=>'dashboard.loans.store','uses'=>'MemberController@storeLoanAccount']);
Route::put('/group/{s_id}/{g_id}/{m_id}/member/loan/accounts/update/{l_id}', ['as'=>'dashboard.loans.update','uses'=>'MemberController@updateLoanAccount']);
Route::get('/group/{s_id}/{g_id}/{m_id}/member/loan/accounts/single/{l_id}', ['as'=>'dashboard.loans.single','uses'=>'MemberController@getMemberLoanSingle']);
Route::delete('/loan/accounts/single/delete/{l_id}', ['as'=>'dashboard.loan.delete','uses'=>'MemberController@deleteSingleLoan']);

Route::get('/group/{s_id}/{g_id}/{m_id}/member/daily/transaction', ['as'=>'dashboard.member.dailytransaction','uses'=>'MemberController@getDailyTransaction']);
Route::get('/group/{s_id}/{g_id}/{m_id}/member/daily/transaction/{loan_type}/{date}', ['as'=>'dashboard.member.dailytransaction.date','uses'=>'MemberController@getDailyTransactionDate']);
Route::post('/daily/transaction/store/api', ['as'=>'dashboard.dailytransactions.postinstallmentapi','uses'=>'MemberController@postDailyInstallmentAPI']);
Route::post('/old/daily/transaction/store/api', ['as'=>'dashboard.olddailytransactions.postinstallmentapi','uses'=>'MemberController@postOldDailyInstallmentAPI']);

Route::post('/daily/transaction/oldsaving/store/api', ['as'=>'dashboard.dailytransactions.oldsaving.postinstallmentapi','uses'=>'MemberController@postDailyInstallmentOldSavingAPI']);
Route::post('/daily/transaction/newsaving/store/api', ['as'=>'dashboard.dailytransactions.oldsaving.postinstallmentapi','uses'=>'MemberController@postDailyInstallmentNewSavingAPI']);


Route::get('/group/{s_id}/{g_id}/{m_id}/member/transfer', ['as'=>'dashboard.member.gettransfer','uses'=>'MemberController@getMemberTransger']);
Route::put('/member/{m_id}/transfer/group', ['as'=>'dashboard.member.transfer','uses'=>'MemberController@memberTransfer']);
Route::put('/member/{m_id}/close', ['as'=>'dashboard.member.close','uses'=>'MemberController@closeMember']);
Route::get('/member/archive', ['as'=>'dashboard.member.archive','uses'=>'MemberController@getMembersArchive']);
Route::put('/member/{m_id}/activate', ['as'=>'dashboard.member.activate','uses'=>'MemberController@activateMember']);

// group transactions
Route::get('/group/{s_id}/{g_id}/transactions', ['as'=>'dashboard.grouptransactions','uses'=>'GroupController@getGroupTransactions']);
Route::get('/group/{s_id}/{g_id}/transactions/{loan_type}/{date}', ['as'=>'dashboard.grouptransactions.date','uses'=>'GroupController@getGroupTransactionsDate']);
Route::post('/group/transaction/store/api', ['as'=>'dashboard.grouptransactions.postinstallmentapi','uses'=>'GroupController@postGroupInstallmentAPI']);
Route::post('/group/brand/new/transaction/store/api', ['as'=>'dashboard.grouptransactions.brandnew.postinstallmentapi','uses'=>'GroupController@postGroupBrandNewInstallmentAPI']);
Route::post('/group/transaction/for/no/loan/members/api', ['as'=>'dashboard.grouptransactions.installmentsfornoloans','uses'=>'GroupController@postGroupNoLoanMembersAPI']);

Route::get('/programs/features', ['as'=>'programs.features','uses'=>'DashboardController@getProgramFeatures']);
Route::get('/programs/day/close', ['as'=>'programs.day.close','uses'=>'DashboardController@getDayClose']);
Route::post('/programs/day/close/store', ['as'=>'programs.store.day.close','uses'=>'DashboardController@postDayClose']);
Route::delete('/programs/day/close/{id}/delete', ['as'=>'programs.store.day.open','uses'=>'DashboardController@deleteDayClose']);

Route::get('/staff/{id}/features', ['as'=>'staff.features','uses'=>'StaffController@getStaffFeatures']);
Route::get('/group/{s_id}/{g_id}/features', ['as'=>'group.features','uses'=>'GroupController@getGroupFeatures']);

// old data entry
Route::get('/old/data/entry', ['as'=>'olddata.index','uses'=>'OldDataEntryContrller@getIndex']);
Route::get('/old/data/entry/create', ['as'=>'olddata.create','uses'=>'OldDataEntryContrller@getCreate']);
Route::post('/old/data/entry/store', ['as'=>'olddata.store','uses'=>'OldDataEntryContrller@storeOldMember']);

// reports
Route::get('/report/test', ['as'=>'report.test','uses'=>'ReportController@test']);
Route::get('/report/program/top/sheet/primary', ['as'=>'report.program.topsheetprimary','uses'=>'ReportController@generateProgramTopSheetPrimary']);
Route::get('/report/program/top/sheet/product', ['as'=>'report.program.topsheetproduct','uses'=>'ReportController@generateProgramTopSheetProduct']);
Route::get('/report/program/top/sheet/savings', ['as'=>'report.program.topsheetsavings','uses'=>'ReportController@generateProgramTopSheetsavings']);
Route::get('/report/program/transaction/summary/page', ['as'=>'report.program.transactionsummarypage','uses'=>'ReportController@getTransactionSummaryPage']);
Route::post('/report/program/transaction/summary', ['as'=>'report.program.transactionsummary','uses'=>'ReportController@generateTransactionSummary']);
Route::get('/report/group/loan/balancesheet/{s_id}/{g_id}', ['as'=>'report.group.loanbalancesheet','uses'=>'ReportController@generateGroupLoanBalanceSheet']);
Route::get('/report/group/saving/balancesheet/{s_id}/{g_id}', ['as'=>'report.group.savingbalancesheet','uses'=>'ReportController@generateGroupSavingBalanceSheet']);
Route::get('/report/staff/topsheet/{s_id}', ['as'=>'report.staff.topsheet','uses'=>'ReportController@generateStaffTopSheet']);

Route::get('/report/daily/summary/{transactiondate}', ['as'=>'report.daily.summary','uses'=>'ReportController@dailySummary']);
Route::post('/report/daily/summary/dailyotheramounts', ['as'=>'report.post.dailyotheramounts','uses'=>'ReportController@postDailyOtherAmounts']);

// Route::get('/dashboard/committee', ['as'=>'dashboard.committee','uses'=>'DashboardController@getCommittee']);
// Route::post('/dashboard/committee', ['as'=>'dashboard.storecommittee','uses'=>'DashboardController@storeCommittee']);
// Route::put('/dashboard/committee/{id}', ['as'=>'dashboard.updatecommittee','uses'=>'DashboardController@updateCommittee']);
// Route::delete('/dashboard/committee/{id}', ['as'=>'dashboard.deletecommittee','uses'=>'DashboardController@deleteCommittee']);

// Route::get('/dashboard/news', ['as'=>'dashboard.news','uses'=>'DashboardController@getNews']);
// Route::get('/dashboard/events', ['as'=>'dashboard.events','uses'=>'DashboardController@getEvents']);
// Route::get('/dashboard/gallery', ['as'=>'dashboard.gallery','uses'=>'DashboardController@getGallery']);
// Route::get('/dashboard/blogs', ['as'=>'dashboard.blogs','uses'=>'DashboardController@getBlogs']);
// Route::get('/dashboard/members', ['as'=>'dashboard.members','uses'=>'DashboardController@getMembers']);
// Route::get('/dashboard/member/create', ['as'=>'dashboard.member.create','uses'=>'DashboardController@createMember']);
// Route::post('/dashboard/member/store', ['as'=>'dashboard.member.store','uses'=>'DashboardController@storeMember']);
// Route::get('/dashboard/member/{id}/edit', ['as'=>'dashboard.member.edit','uses'=>'DashboardController@editMember']);
// Route::put('/dashboard/member/{id}/update', ['as'=>'dashboard.member.update','uses'=>'DashboardController@updateMember']);



// Route::get('/dashboard/deletemember/{id}', ['as'=>'dashboard.deletemember','uses'=>'DashboardController@deleteMember']);
// Route::get('/dashboard/deletestaff/{id}', ['as'=>'dashboard.deletestaff','uses'=>'DashboardController@deleteStaff']);
// Route::get('/dashboard/deletegroup/{id}', ['as'=>'dashboard.deletegroup','uses'=>'DashboardController@deleteGroup']);
Route::get('/dashboard/delete/double/installments/{date}/{loanorsavings}/{type}', ['as'=>'dashboard.deletedoubleinstallments','uses'=>'DashboardController@deleteDoubleInstallments']);
Route::get('/run/double/delete/{date}', ['as'=>'dashboard.rundouble.delete','uses'=>'DashboardController@runDoubleDelete']);
Route::get('/dashboard/savings/missing', ['as'=>'dashboard.checkmissingsavings','uses'=>'DashboardController@checkMissingSavings']);
Route::get('/dashboard/userid/missing', ['as'=>'dashboard.useridmissing','uses'=>'DashboardController@checkUserIDMissing']);
Route::get('/dashboard/deben/change', ['as'=>'dashboard.debenmannan','uses'=>'DashboardController@changeDebenLoanAndSaving']);




// Route::get('/dashboard/applications', ['as'=>'dashboard.applications','uses'=>'DashboardController@getApplications']);
// Route::patch('/dashboard/applications/{id}/approve', ['as'=>'dashboard.approveapplication','uses'=>'DashboardController@approveApplication']);
// Route::delete('/dashboard/application/{id}', ['as'=>'dashboard.deleteapplication','uses'=>'DashboardController@deleteApplication']);

// Route::get('/dashboard/expertises', ['as'=>'dashboard.expertises','uses'=>'DashboardController@getExpertises']);
// Route::get('/dashboard/expertise/create', ['as'=>'dashboard.expertise.create','uses'=>'DashboardController@createExpertise']);
// Route::post('/dashboard/expertise/store', ['as'=>'dashboard.expertise.store','uses'=>'DashboardController@storeExpertise']);

// Route::get('/dashboard/projects', ['as'=>'dashboard.projects','uses'=>'DashboardController@getProjects']);
// Route::get('/dashboard/project/create', ['as'=>'dashboard.project.create','uses'=>'DashboardController@createProject']);
// Route::post('/dashboard/project/store', ['as'=>'dashboard.project.store','uses'=>'DashboardController@storeProject']);

// Route::get('/dashboard/publications', ['as'=>'dashboard.publications','uses'=>'DashboardController@getPublications']);
// Route::get('/dashboard/publication/create', ['as'=>'dashboard.publication.create','uses'=>'DashboardController@createPublication']);
// Route::post('/dashboard/publication/store', ['as'=>'dashboard.publication.store','uses'=>'DashboardController@storePublication']);

// Route::get('/dashboard/disasterdatas', ['as'=>'dashboard.disasterdatas','uses'=>'DashboardController@getDisasterdatas']);
// Route::post('/dashboard/disasterdata/category/store', ['as'=>'dashboard.discategory.store','uses'=>'DashboardController@storeDisasterCategory']);
// Route::put('/dashboard/disasterdata/category/{id}/update', ['as'=>'dashboard.discategory.update','uses'=>'DashboardController@updateDisasterCategory']);
// Route::get('/dashboard/disasterdata/create', ['as'=>'dashboard.disasterdata.create','uses'=>'DashboardController@createDisasterdata']);
// Route::post('/dashboard/disasterdata/store', ['as'=>'dashboard.disasterdata.store','uses'=>'DashboardController@storeDisasterdata']);
// Route::get('/dashboard/disasterdata/{id}/edit', ['as'=>'dashboard.disasterdata.edit','uses'=>'DashboardController@editDisasterdata']);
// Route::put('/dashboard/disasterdata/{id}/update', ['as'=>'dashboard.disasterdata.update','uses'=>'DashboardController@updateDisasterdata']);

// Route::get('/dashboard/personal/publications', ['as'=>'dashboard.personal.pubs','uses'=>'DashboardController@getPersonalPubs']);
// Route::get('/dashboard/personal/profile', ['as'=>'dashboard.personal.profile','uses'=>'DashboardController@getPersonalProfile']);


// dashboard routes
// dashboard routes
