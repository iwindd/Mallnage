<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/* FRONTEND CONTROLLER */
use App\Http\Controllers\CashierController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDBController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CategoriesDBController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CooperativeController;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\EmployeeController;

/* BACKEND CONTROLLER */
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDBController;
use App\Http\Controllers\ProfileAdminController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\DepartmentController;

/* BANNED CONTROLLER */
use App\Http\Controllers\BannedController;

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


/* LOGIN ROUTE */

Auth::routes();


Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'guest'])->name('index');
    Route::get('/signup', [UserController::class, 'signup'])->name('signup');


    Route::post('/signup/signup', [UserController::class, 'signupAdd'])->name('signupAdd');
});

/* USER ROUTE */
Route::middleware('isUser')->group(function () {
    /* CASHIER */
    Route::get('/dashboard', [HomeController::class, 'user'])->name('home');
    Route::get('/cashier', [CashierController::class, 'index'])->name('cashier');

    /* BASKET */
    Route::post('/basket/add',                     [BasketController::class, 'add'])->name("basketAdd");
    Route::post('/basket/remove', [BasketController::class, 'remove'])->name('basketRemove');

    Route::post('/basket/end',       [BasketController::class, 'end'])->name('basketEnd');
    Route::get('/basket/destroy',                  [BasketController::class, 'destroy'])->name('basketDestroy');

    /* BORROWS */

    Route::get('/borrows', [BorrowController::class, 'get'])->name("borrows");
    Route::get('/borrows/inproccess', [BorrowController::class, 'inProcess'])->name('borrowsInProcess');
    Route::get('/borrows/inproccess/view/{borrowsId}', [BorrowController::class, 'inProcessView'])->name("borrowsInProcessView");

    Route::get('/borrows/finished', [BorrowController::class, 'finished'])->name('borrowsFinished');
    Route::get('/borrows/finished/view/{borrowsId}', [BorrowController::class, 'borrowsFinishedView'])->name("borrowsFinishedView");
    Route::post('/borrows/finished/summary', [BorrowController::class, 'fetchSummary'])->name('borrowsFetchSummary');


    Route::get('/borrows/canceled', [BorrowController::class, 'canceled'])->name('borrowsCanceled');
    Route::get('/borrows/canceled/view/{borrowsId}', [BorrowController::class, 'borrowsCanceledView'])->name('borrowsCanceledView');

    /*     Route::get('/borrows/summary', [BorrowController::class, 'summary'])->name('borrowsSummary'); */

    Route::post('/borrows/work',       [BorrowController::class, 'work'])->name('borrowsWork');
    Route::post('/borrows/add',       [BorrowController::class, 'borrow'])->name('borrowsAdd');
    Route::post('/borrows/close',       [BorrowController::class, 'close'])->name('borrowsClose');

    /* CATEGORIES */
    Route::get('/categories', [CategoriesController::class, 'get'])->name("categories");
    Route::get('/categories/edit', [CategoriesController::class, 'view'])->name("categoriesEdit");
    Route::get('/categories/pdf', [CategoriesController::class, 'pdf'])->name("categoriesPDF");

    Route::post('/categories/db/store', [CategoriesDBController::class, 'store'])->name("categoriesStore");
    Route::post('/categories/db/update', [CategoriesDBController::class, 'update'])->name("categoriesUpdate");
    Route::post('/categories/db/delete', [CategoriesDBController::class, 'delete'])->name("categoriesDelete");

    /* TRADE */
    Route::get('/trade', [TradeController::class, 'index'])->name('trade');
    Route::post('/trade/add', [TradeController::class, 'add'])->name('tradeAdd');


    /* PRODUCT */
    Route::get('/product', [StockController::class, 'get'])->name("product");
    Route::get('/product/search/{name}', [StockController::class, 'search'])->name("productSearch");
    /*     Route::get('/product/add'           , [ProductController::class, 'add'])   ->name("productAdd"); */
    Route::get('/product/barcode', [ProductController::class, 'barcode'])->name("productBarcode");
    Route::get('/product/edit/{serial}', [ProductController::class, 'edit'])->name("productEdit");
    Route::post('/product/summary', [ProductController::class, 'summary'])->name("productSummary");

    /* PRODUCT DB */
    Route::post('/product/db/store',             [ProductDBController::class, 'store'])->name("product_add");
    Route::post('/product/db/quickstore',        [ProductDBController::class, 'quick_store'])->name("product_quickadd");
    Route::post('/product/db/update/{serial}',   [ProductDBController::class, 'edit'])->name("product_update");
    Route::get('/product/db/delete/{serial}',    [ProductDBController::class, 'delete'])->name("product_remove");

    /* HISTORY */
    Route::get('/history', [HistoryController::class, 'get'])->name("history");
    Route::get('/history/{id}', [HistoryController::class, 'view'])->name("historyView");
    Route::get('/history/receipt/get/{id}', [HistoryController::class, 'get_receipt'])->name("historyReceipt");
    Route::post('/history/receipt', [HistoryController::class, 'receipt'])->name("historyRealReceipt");

    /* SUMMARY */

    /* STOCK */ // ใช้ใน product routeแทน
    //Route::get('/stock'              , [StockController::class,  'get'])    ->name('stock');
    // Route::get('/stock/{name}'       , [StockController::class,  'search']) ->name('stockSearch');

    /* REPORT */
    Route::get('/report', [ReportController::class,  'get'])->name('report');
    Route::get('/report/most', [ReportController::class,  'most'])->name('reportMost');
    Route::get('/report/least', [ReportController::class,  'least'])->name('reportLeast');

    /* EXPORT PDF REPORT */
    Route::get('/report/pdf', [ReportController::class,  'pdf'])->name('reportPdf');

    /* RECEIPT */
    Route::get('/receipt', [ReceiptController::class, 'get'])->name('receipt');
    Route::get('/receipt/{id}', [ReceiptController::class, 'export'])->name('exportReceipt');


    /* EMPLOYEES */
    Route::get('/employees', [EmployeeController::class, 'get'])->name('employees');
    Route::get('/employees/add', [EmployeeController::class, 'add'])->name('employeesAdd');
    Route::post('/employees/add', [EmployeeController::class, 'insert'])->name('employeesInsert');
    Route::get('/employees/employee', [EmployeeController::class, 'manage'])->name('employeesManage');
    Route::post('/employees/employee', [EmployeeController::class, 'edit'])->name('employeesEdit');
    Route::post('/employees/employee/password', [EmployeeController::class, 'editPassword'])->name('employeesEditPassword');

    /* Profile */

    Route::get('/profile', [CooperativeController::class,  'get'])->name('setting');
    Route::post('/profile/db/update/lineNotification', [CooperativeController::class,  'editLineNotification'])->name('updateLineNotification');
    Route::post('/profile/db/update/password', [CooperativeController::class,  'editPassword'])->name('setting_updatePassword');
    Route::post('/profile/db/update/tel', [CooperativeController::class,  'editTel'])->name('setting_updateTel');
    Route::post('/profile/db/update/lineId', [CooperativeController::class,  'editLineId'])->name('setting_updateLineId');
    Route::post('/profile/db/update/address', [CooperativeController::class,  'editAddress'])->name('setting_updateAddress');
});

/* ADMIN ROUTE */
Route::middleware('isAdmin')->group(function () {
    /* INDEX */
    Route::get('/admin', [HomeController::class, 'admin'])->name('admin.home');/* USER MANAGEMENT IS INDEX */
    Route::get('/admin/users', [HomeController::class, 'adminUsers'])->name('admin.users');/* USER MANAGEMENT IS INDEX */

    /* USER MANAGEMENT */
    Route::get('/admin/user', [UserManagementController::class, 'management'])->name('admin.managements');
    Route::middleware('management')->group(function () {
        /* PRODUCT */
        Route::get('/admin/user/product', [ProductController::class, '_get'])->name('admin.managements.product');
        Route::get('/admin/user/product/{name}', [ProductController::class, '_view'])->name('admin.managements.product.view');

        /* PRODUCT DB */
        Route::post('/admin/user/db/product/add', [ProductDBController::class, '_store'])->name('admin.managements.product_add');
        Route::post('/admin/user/db/product/edit', [ProductDBController::class, '_edit'])->name('admin.managements.product_edit');
        Route::post('/admin/user/db/product/delete', [ProductDBController::class, '_delete'])->name('admin.managements.product_remove');


        /* HISTORY */
        Route::get('/admin/user/history', [HistoryController::class, '_get'])->name('admin.managements.history');
        Route::get('/admin/user/history/{name}', [HistoryController::class, '_view'])->name('admin.managements.history.view');


        /* receipt */
        Route::get('/admin/user/receipt', [ReceiptController::class, '_get'])->name('admin.managements.receipt');
        Route::post('/admin/user/receipt/db', [ReceiptController::class, 'insert'])->name('admin.managements.receipt.insert');

        /* EDIT PROFILE */
        Route::post('/admin/user/db/edit/group', [UserDBController::class, 'editGroup'])->name('admin.user_editGroup');
        Route::post('/admin/user/db/edit/grade', [UserDBController::class, 'editGrade'])->name('admin.user_editGrade');
        Route::post('/admin/user/db/edit/name', [UserDBController::class, 'editName'])->name('admin.user_editCooperativeName');
        Route::post('/admin/user/db/edit/fullname', [UserDBController::class, 'editFullname'])->name('admin.user_editFullname');
        Route::post('/admin/user/db/edit/accountage', [UserDBController::class, 'editAccountAge'])->name('admin.user_editAccountAge');
        Route::post('/admin/user/db/edit/password', [UserDBController::class, 'editPassword'])->name('admin.user_editPassword');
        Route::post('/admin/user/db/edit/tel', [UserDBController::class, 'editTel'])->name('admin.user_editTel');
        Route::post('/admin/user/db/edit/lineId', [UserDBController::class, 'editLineId'])->name('admin.user_editlineId');
        Route::post('/admin/user/db/edit/address', [UserDBController::class, 'editAddress'])->name('admin.user_addressEdit');
        Route::post('/admin/user/db/edit/toggleAllowed', [UserDBController::class, 'toggleAllowed'])->name('admin.user_toggleAllowed');
    });

    /* DEPARTMENTS */
    Route::get('/admin/departments', [DepartmentController::class, 'get'])->name('admin.departments');
    Route::post('/admin/departments/add', [DepartmentController::class, 'add'])->name('admin.departments.add');
    Route::post('/admin/departments/edit', [DepartmentController::class, 'edit'])->name('admin.departments.edit');
    Route::post('/admin/departments/delete', [DepartmentController::class, 'delete'])->name('admin.departments.delete');



    /* USERS */
    Route::get('/admin/user/add', [UserController::class, 'add'])->name('admin.userAdd');


    /* USER DB */
    Route::post('/admin/user/db/add', [UserDBController::class, 'add'])->name('admin.user_add');

    /* PROFILE */
    Route::get('/admin/profile', [ProfileAdminController::class, 'index'])->name('admin.profile');
    Route::post('/admin/profile/db/edit/group', [ProfileAdminController::class, 'editGroup'])->name('admin.profile_editGroup');
    Route::post('/admin/profile/db/edit/password', [ProfileAdminController::class, 'editPassword'])->name('admin.profile_editPassword');
});


/* BANNED ROUTE */
Route::get('/banned', [BannedController::class,  'index'])->name('banned')->middleware('isBanned');
