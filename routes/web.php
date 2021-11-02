<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\LeadBoardController;
use App\Http\Controllers\PaymentSuccessController;
use App\Http\Controllers\WebhookController;
use App\Models\McqAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AllMailController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\McqController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\LiveExamController;
use App\Http\Controllers\Admin\UserExamController;
use App\Http\Controllers\Admin\AllSettingController;
use App\Http\Controllers\Admin\ExamManageController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Admin\ResultManageController;
use App\Http\Controllers\Admin\StudentClassController;
use App\Http\Controllers\Frontend\AddToCartController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PackageEnrollController;
use App\Http\Controllers\Frontend\PackageController as FrontendPackageController;
use App\Http\Controllers\Frontend\LiveExamController as FrontendLiveExamController;

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
// cache clear
Route::get('/cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    return 'done';
});
Route::get('/db-migrate', function () {
    Artisan::call('migrate');
    return 'migration done';
});
Route::get('/nohup', function () {
    Artisan::call('queue:listen &');
    return 'nohup done';
});
// Frontend Route
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('/about-us', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/send', [AllMailController::class, 'contact_mail_send'])->name('contact.send');
Route::get('/faqs', [FrontendController::class, 'faqs'])->name('faqs');

Route::post('/paddle/webhook', WebhookController::class);

// live exam
Route::get('/live/exam', [FrontendLiveExamController::class, 'ExamEventPage'])->name('live.exam.page')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/live/{id}/exam', [FrontendLiveExamController::class, 'ExamPage'])->name('exam.page');
    Route::get('/live/{id}/exam-details', [FrontendLiveExamController::class, 'ExamDetails'])->name('exam.details');
    Route::post('/live/exam/submit', [FrontendLiveExamController::class, 'ExamSubmit'])->name('live.exam.submit');
});
// Route::get('/package/free', [FrontendController::class, 'package_free'])->name('package.free');
Route::get('/package', [FrontendController::class, 'package'])->name('package');
// package load more
Route::get('/package/loadmore', [FrontendController::class, 'package_loadmore'])->name('package.loadmore');
Route::get('/package/details/{id}/{title}', [FrontendController::class, 'package_details'])->name('package.details');
Route::get('/classes/{slug}', [FrontendController::class, 'classes'])->name('classes');
Route::get('/product_wishlist', [FrontendController::class, 'product_wishlist'])->name('product_wishlist');
// Route::get('/privacy', [FrontendController::class, 'privacy'])->name('privacy');
Route::get('/error404', [FrontendController::class, 'error404'])->name('error404');
Route::get('/leadboard', [FrontendController::class, 'leadboard'])->name('leadboard');
Route::get('/page/{slug}', [FrontendController::class, 'page'])->name('page');

// add to cart route
Route::get('/cart', [FrontendController::class, 'add_to_cart'])->name('cart')->middleware('auth');
Route::post('/add_to_cart', [AddToCartController::class, 'add_to_cart'])->name('add_to_cart');
Route::post('/remove_cart/{id}', [AddToCartController::class, 'remove_cart'])->name('remove_cart');
Route::post('/empty/cart', [AddToCartController::class, 'empty_cart'])->name('cart.empty');
Route::post('/apply/coupon', [AddToCartController::class, 'apply_coupon'])->name('apply.coupon');
// package wishlist route
Route::post('/add/wishlist', [AddToCartController::class, 'wish_list'])->name('add.wishlist');
// checkout route
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
// checkout route
Route::post('/package/review', [FrontendPackageController::class, 'create_review'])->name('create.review');
Route::get('/all_reviews', [FrontendPackageController::class, 'all_reviews'])->name('all_reviews');
// newsletter
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('news');

// SSLCOMMERZ Start
// Route::group(['middleware' => ['auth']], function () {
    Route::post('/checkout/pay', [CheckoutController::class, 'payment_url']);
    Route::post('/checkout/live_enroll', [CheckoutController::class, 'live_enroll']);
Route::post('/checkout/pay-via-ajax', [CheckoutController::class, 'payment_ajax']);
Route::get('/pay/live_exam/{id}', [CheckoutController::class, 'handlePayment']);

Route::post('/checkout/success', [CheckoutController::class, 'payment_success']);
    Route::post('/checkout/fail', [CheckoutController::class, 'payment_fail']);
    Route::post('/checkout/cancel', [CheckoutController::class, 'payment_cancel']);

    Route::post('/checkout/ipn', [CheckoutController::class, 'payment_ipn']);
    Route::post('/checkout/order/{enroll_id}', [CheckoutController::class, 'payment_order']);
    Route::post('/checkout/order/cancel/{enroll_id}', [CheckoutController::class, 'order_cancel']);
// });
//SSLCOMMERZ END

//Student Dashboard
Route::group(['middleware' => ['auth']], function () {
    Route::get('my-section/dashboard', [FrontendController::class, 'student_dashboard'])->name('student_dashboard');
    Route::get('my-section/profile', [FrontendController::class, 'my_profile'])->name('my_profile');
    Route::get('my-section/all_courses', [FrontendController::class, 'all_courses'])->name('all_courses');
    Route::get('my-section/course_stats', [FrontendController::class, 'course_stats'])->name('course_stats');
    Route::get('my-section/live_exams', [FrontendController::class, 'live_exams'])->name('dashboard.live_exam');
    Route::get('my-section/my_orders', [FrontendController::class, 'my_orders'])->name('my_orders');
    Route::get('my-section/settings', [FrontendController::class, 'settings'])->name('settings');
    Route::get('my-section/saved_courses', [FrontendController::class, 'saved_courses'])->name('saved_courses');
    // user setting route
    Route::post('my-section/user/update/{id}', [FrontendController::class, 'user_update'])->name('user.update');
    // remvoe wishlist route
    Route::post('my-section/remove/wishlist', [AddToCartController::class, 'remove_wishlist'])->name('remove.wishlist');
    // free package enroll
    Route::post('my-section/enroll', [PackageEnrollController::class, 'free_package_enroll'])->name('free.enroll');

    // mcq exam route
    Route::get('my-section/package/{package_id}/exam/{mcq_id}', [FrontendPackageController::class, 'get_mcq_exam'])->name('mcq.exam');
    Route::post('my-section/mcq/submit', [FrontendPackageController::class, 'submit_mcq_exam'])->name('mcq.submit');
    Route::get('my-section/mcq/{mcq_id}/view', [FrontendPackageController::class, 'submit_mcq_exam_view'])->name('mcq.submit.view');
    Route::get('payment/success', PaymentSuccessController::class)->name('payment.success');
});

Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Backend Route

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        // Role route
        Route::resource('roles', RoleController::class)->middleware(['permission:manage-role']);
        // user route
        Route::resource('users', UserController::class)->middleware(['permission:manage-user']);
        Route::get('students', [UserController::class, 'students'])
            ->middleware(['permission:manage-user'])->name('students.index');
        // main mcq route
        Route::get('ajax/subject', [McqController::class, 'ajax_subject'])->name('mcqs.subject');

        Route::resource('main-mcqs', McqController::class)->middleware(['permission:manage-mcq']);
        Route::post('/ajax-title/main-mcqs', [McqController::class, 'check_title']);
        // Subject route
        Route::resource('subjects', SubjectController::class)->middleware(['permission:manage-subject']);
        // Classes route
        Route::resource('classes', StudentClassController::class)->middleware(['permission:manage-class']);
        // Packages route
        Route::resource('packages', PackageController::class)->middleware(['permission:manage-package']);
        Route::post('ajax/packages/subject', [PackageController::class, 'ajax_subject'])->name('ajax_subject');
        Route::get('leaderboard', [LeadBoardController::class, 'index'])->name('leaderboard.index');
        // coupons route
        Route::resource('coupons', CouponController::class)->middleware(['permission:manage-coupon']);
        // footer route
        Route::resource('footers', FooterController::class)->middleware(['permission:manage-footer']);
        // footer route
        Route::resource('pages', PageController::class)->middleware(['permission:manage-page']);
        // home page package route
        Route::resource('live-exams', LiveExamController::class)->middleware(['permission:manage-live-exam']);

        Route::get('exam/user/{user_id}/exam/{mcq_id}', [UserExamController::class, 'uer_exam_view']);

        Route::resource('faqs', FaqController::class);
        Route::resource('abouts', AboutController::class);
        // exam set amdin
        Route::group(['middleware' => ['permission:manage-exam']], function () {
            Route::get('manage-exam', [ExamManageController::class, 'index'])->name('manage.exam');
            Route::get('manage-exam/get/{id}', [ExamManageController::class, 'get_exam'])->name('get.exam');
            Route::post('manage-exam/set/{id}', [ExamManageController::class, 'set_admin'])->name('set.exam.teacher');
        });

        // exam review
        Route::group(['middleware' => ['permission:manage-result']], function () {
            Route::get('result-manage', [ResultManageController::class, 'index'])->name('all.exam.set');
            Route::get('result-manage/get-exam/{id}', [ResultManageController::class, 'get_exam'])->name('exam.get');
            Route::post('result-manage/set-result/{id}', [ResultManageController::class, 'set_result'])->name('exam.set.result');
        });

        // Page Daynamic
        Route::group(['middleware' => ['permission:manage-setting']], function () {
            Route::get('setting', [AllSettingController::class, 'get_setting'])->name('get.setting');
            Route::post('setting', [AllSettingController::class, 'update_setting'])->name('update.setting');
            Route::get('home_page', [AllSettingController::class, 'get_home'])->name('get.home_page');
            Route::post('home_page', [AllSettingController::class, 'update_home'])->name('update.home_page');
        });
    });
});
Route::get('/json', function () {
    $row = '[{"field_id":37008,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"multiple_questions_3","options":[{"option_id":96734,"input_name":"Option","input_photo":"","ans":true},{"option_id":96735,"input_name":"Option","input_photo":"","ans":false},{"option_id":96736,"input_name":"Option","input_photo":"","ans":false},{"option_id":96737,"input_name":"Option","input_photo":"","ans":false}],"ans":["ans_96734_opt_37008"],"points":"2","shouldDisable":true,"ans_mode":false},{"field_id":37009,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"multiple_questions_3","options":[{"option_id":96738,"input_name":"Option","input_photo":"","ans":false},{"option_id":96739,"input_name":"Option","input_photo":"","ans":false},{"option_id":96740,"input_name":"Option","input_photo":"","ans":false},{"option_id":96741,"input_name":"Option","input_photo":"","ans":true}],"ans":["ans_96741_opt_37009"],"points":"2","shouldDisable":true,"ans_mode":false},{"field_id":37011,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"shot_questions_1","options":[{"option_id":96746,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":"2","shouldDisable":true,"ans_mode":false},{"field_id":37012,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"paragraph_questions_2","options":[{"option_id":96747,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":"4","shouldDisable":true,"ans_mode":false},{"field_id":37013,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"file_questions_4","options":[{"option_id":96748,"input_name":"Option","input_photo":"","ans":false}],"ans":[],"points":"4","shouldDisable":true,"ans_mode":false},{"field_id":37014,"questions_title":"Untitled Questions","questions_photo":"","questions_type":[{"value":"shot_questions_1","name":"Short Answer"},{"value":"paragraph_questions_2","name":"Paragraph"},{"value":"multiple_questions_3","name":"Multiple Choice"},{"value":"file_questions_4","name":"File Upload"}],"select_type":"multiple_questions_3","options":[{"option_id":96749,"input_name":"Option","input_photo":"","ans":false},{"option_id":96750,"input_name":"Option","input_photo":"","ans":false},{"option_id":96751,"input_name":"Option","input_photo":"","ans":false},{"option_id":96752,"input_name":"Option","input_photo":"","ans":true}],"ans":["ans_96752_opt_37014"],"points":"2","shouldDisable":true,"ans_mode":false}]';
    $custom_row_data = json_decode($row);
    $ans = McqAnswer::where('sl', 'MCQ-5799131')->pluck('id');
    $i = 0;
    foreach ($custom_row_data as $item) {
        $mcq_ans = McqAnswer::find($ans[$i]);
        $mcq_ans->sl = 'MCQ-5799131';
        $mcq_ans->question_id = $item['field_id'];
        $mcq_ans->questions_type = $item['select_type'];
        $mcq_ans->answers = implode('||', $item['ans']);
        $mcq_ans->answer_points = $item['points'];
        $mcq_ans->save();
        $i++;
    }
});
// social auth
Route::get('auth/google', [SocialController::class, 'redirectToGoogle'])->name('google');
Route::get('auth/google/callback', [SocialController::class, 'handleGoogleCallback'])->name('google.callback');
