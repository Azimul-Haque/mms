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
Route::get('/group/{s_id}/{g_id}/members/create', ['as'=>'dashboard.members.create','uses'=>'MemberController@createMember']);
Route::post('/group/{s_id}/{g_id}/members/store', ['as'=>'dashboard.members.store','uses'=>'MemberController@storeMember']);
Route::get('/group/{s_id}/{g_id}/members/{id}/edit', ['as'=>'dashboard.members.edit','uses'=>'MemberController@editMember']);
Route::put('/group/{s_id}/{g_id}/members/{id}/update', ['as'=>'dashboard.members.update','uses'=>'MemberController@updateMember']);

Route::get('/group/{s_id}/{g_id}/{m_id}/member', ['as'=>'dashboard.member.single','uses'=>'MemberController@getSingleMember']);

Route::get('/programs/features', ['as'=>'programs.features','uses'=>'DashboardController@getProgramFeatures']);
Route::get('/staff/{id}/features', ['as'=>'staff.features','uses'=>'StaffController@getStaffFeatures']); // id dhukbe ekhane
Route::get('/group/{s_id}/{g_id}/features', ['as'=>'group.features','uses'=>'GroupController@getGroupFeatures']); // id dhukbe ekhane
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
// Route::delete('/dashboard/deletemember/{id}', ['as'=>'dashboard.deletemember','uses'=>'DashboardController@deleteMember']);

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
