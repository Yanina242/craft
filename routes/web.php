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
Route::group(['middleware' => 'auth'], function(){
  Route::group(['middleware' => 'standard'], function () {
         Route::get('/admin', function(){
          return view('admin.home');
          })->name('admin');
      });
});

//##########################################################################################################
                                    //Rutas para el sistema de administracion
//##########################################################################################################
Route::group(['prefix'=>'admin','middleware' => 'auth'], function(){
  Route::group(['middleware' => 'standard'], function () {
         
  //******************************Rutas para lineas******************************************
  Route::resource('lines','LinesController');
  Route::get('/lines/{id}/desable','LinesController@desable')->name('lines.desable');


  //******************************Rutas para categorias******************************************
  Route::resource('categories','CategoriesController');
  Route::get('/categories/{id}/desable','CategoriesController@desable')->name('categories.desable');
  Route::get('/categories/{id}/enable','CategoriesController@enable')->name('categories.enable');


  //******************************Rutas para eventos******************************************
  Route::resource('events','EventController');
  Route::get('/events/{id}/desable','EventController@desable')->name('events.desable');
  Route::get('/events/{id}/enable','EventController@enable')->name('events.enable');
  Route::get('/searchNameLike','EventController@searchNameLike')->name('events.searchNameLike');


  //******************************Rutas para marcas******************************************
  Route::resource('brands','BrandController'); 
  Route::get('/brands/{id}/desable','BrandController@desable')->name('brands.desable'); 


  //******************************Rutas para productos**************************************** 
  Route::resource('products','ProductsController');
  Route::resource('porcentages','PorcentagesController');
  
  Route::get('products/{id}/desable','ProductsController@desable')->name('products.desable');
  Route::get('products/{id}/enable','ProductsController@enable')->name('products.enable');
  Route::post('products/updateStock','ProductsController@updateStock')->name('products.updateStock');
  Route::get('/searchNameProduct', 'ProductsController@searchNameProduct')->name('products.searchNameProduct');


 //-------------para actualizar el stock de productos personalizados-------------------------------
  Route::get('craftProducts','ProductsController@craftProducts')->name('craftProducts');
  Route::post('products/updateStock','ProductsController@updateStock')->name('products.updateStock');
  Route::get('/searchCraftProducts', 'ProductsController@searchCraftProducts');  
  Route::get('/searchCraft', 'ProductsController@searchCraft'); 
 

  //-----------actualizar stock de productos que se utilizan para hacer prod personalizados----------
   Route::get('updateStockCreate','ProductsController@updateStockCreate')->name('updateStockCreate');
   Route::get('/searchUpdateStockCreate', 'ProductsController@searchUpdateStockCreate');
   Route::get('/searchProductsCreateLetter', 'ProductsController@searchProductsCreate');
   Route::post('products/updateStockCreateProduct', 'ProductsController@updateStockCreateProduct')->name('products.updateStockCreateProduct'); 
   Route::get('/listDetailProduct','ProductsController@listDetailProduct');


//######################Rutas solo para el encargado de compras################################################
Route::group(['middleware' => 'purchaseUser'],function(){
 
 //**************************Rutas para proveedores************************************************** 
  Route::resource('providers','ProvidersController');
  Route::get('/listProducts','ProvidersController@listProducts');
  Route::get('/searchProdName','ProvidersProductsController@searchProdName');
  Route::get('/searchProdLetter','ProvidersProductsController@searchProdLetter');
  Route::get('providers/{id}/desable','ProvidersController@desable')->name('providers.desable');
  Route::get('providers/{id}/enable','ProvidersController@enable')->name('providers.enable');
  Route::get('providers/{id}/addProducts','ProvidersController@addProducts')->name('providers.addProducts');
  Route::post('providersproducts/{provider}/storeProducts','ProvidersProductsController@storeProducts')->name('providersproducts.storeProducts');

  //**************************** Rutas para compras**************************************************
  Route::resource('purchases','PurchasesController');
  Route::get('/detailPurchase','PurchasesController@detailPurchase');
  Route::get('/searchProvider','PurchasesController@searchProvider');
  Route::get('/searchProducts','PurchasesController@searchProducts');
   Route::get('/searchLetter','PurchasesController@searchLetter');
  Route::get('/autocompleteProvider', 'PurchasesController@autocompleteProvider')->name('autocompleteProvider');
  Route::get('/autocompleteProdProvider', 'PurchasesController@autocompleteProdProvider')->name('autocompleteProdProvider');
  Route::get('/purchases/{id}/desable','PurchasesController@desable')->name('purchases.desable');
      
  Route::get('/purchases/{id}/detailPurchaseOrder','PurchasesController@detailPurchaseOrder')->name('purchases.detailPurchaseOrder');


//*************************************Rutas para pdf*****************************************************
  Route::get('pdfReport','PdfController@index')->name('pdfReport');
  Route::get('reportStock', 'PdfController@createReportStock')->name('reportStock');
  Route::get('reportRanKing', 'PdfController@createReportRanking')->name('reportRanKing');
  //********************Reporte de compras mensuales*****************************************************
Route::get('/reportPurchase','PdfController@createReportPurchases')->name('admin.reportPurchase');
Route::get('/viewReportPurchase','PdfController@viewReportPurchase')->name('admin.viewReportPurchase');

//*******************Reporte de compras por proveedores************************************************
 Route::get('createReportPPurchase','PdfController@createReportPPurchase')->name('createReportPPurchase');

//*******************Reporte de productos vendidos mensualmente************************************************
 Route::get('createReportSalesProducts','PdfController@createReportSalesProducts')->name('createReportSalesProducts');


//************************************Rutas para facturas de compras***********************************
Route::resource('purchasesInvoice','PurchasesInvoiceController'); 
Route::get('/completeOrder','PurchasesInvoiceController@completeOrder');
Route::get('/detailOrder','PurchasesInvoiceController@detailPurchase');
Route::get('purchasesInvoice/{id}/loadOrder','PurchasesInvoiceController@loadOrder')->name('purchasesInvoice.loadOrder');
Route::post('purchasesInvoice/{id}/storePI','PurchasesInvoiceController@storePI')->name('purchasesInvoice.storePI');
Route::get('/searchDataIP','PurchasesInvoiceController@searchDate');
});

//################################Rutas para el encargado de ventas#####################################
Route::group(['middleware' => 'saleUser'],function(){
//************************************Rutas para ventas***********************************************
  Route::resource('invoices','InvoicesController');
  
  Route::get('/searchDateInvoice','InvoicesController@searchDate');
  Route::get('/invoices/{id}/desable','InvoicesController@desable')->name('invoices.desable');
  Route::get('/invoices/{id}/print','InvoicesController@print')->name('print');
  Route::get('invoices/{id}/pdf','InvoicesController@pdfInvoice')->name('invoices.pdf');
//********************Reporte de ventas mensuales*******************************************************
Route::get('/reportSales','PdfController@createReportSales')->name('admin.reportSales');
Route::get('/viewReportSales','PdfController@viewReportSales')->name('admin.viewReportSales');

//*******************Reporte de compras por clientes************************************************
 Route::get('createReportCOrder','PdfController@createReportCOrder')->name('createReportCOrder');
});

//################################Rutas para el encargado de pedidos#####################################
Route::group(['middleware' => 'orderUser'],function(){
  //************************************Rutas para Pedidos**********************************
  Route::resource('orders','OrdersController');
  Route::get('/searchDateOrder','OrdersController@searchDateOrder');
  Route::get('orders/{id}/pdf','OrdersController@pdfOrder')->name('orders.pdf');
  Route::get('orderPayment/{id}/registerPayment','OrdersController@registerPayment')->name('orderPayment.register');
  Route::post('orderPayment/{id}/storePayment','OrdersController@storePayment')->name('OrderPayment.store');

 Route::put('orders/changeStatus/{order}','OrdersController@changeStatus')->name('orders.changeStatus');
 Route::resource('shoppingcarts','ShoppingCartsController',['only'=>['index']]);
 Route::get('shoppingcarts/createOrders/{id}','ShoppingCartsController@createOrders')->name('shoppingcarts.createOrders');

 Route::resource('webUser','UserWebController',['only'=>'index']);
});

//################################Rutas para el encargado de pedidos y el de ventas#####################################
Route::group(['middleware' => 'saleOrderUser'],function(){
  //para buscar productos
  Route::get('/searchL','InvoicesController@searchL');
  Route::get('/search','InvoicesController@search');
 //*************************Rutas para clientes******************************************************
 
  Route::resource('clients','ClientsController');
  Route::get('/searchClient','InvoicesController@searchClient');
  Route::get('clients/{id}/desable','ClientsController@desable')->name('clients.desable');
  Route::get('clients/{id}/enable','ClientsController@enable')->name('clients.enable');
  Route::get('/autocomplete', 'InvoicesController@autocomplete')->name('autocomplete');
  Route::get('/autocompleteClient', 'InvoicesController@autocompleteClient')->name('autocompleteClient');
});

Route::group(['middleware'=>'adminUser'],function(){
   //***************************Rutas para usuarios******************************************
 Route::post('users/store','UsersController@store')->name('users.store');
 Route::get('users','UsersController@index')->name('users.index');
 Route::get('users/create','UsersController@create')->name('users.create');
 Route::put('users/{user}','UsersController@update')->name('users.update');
 Route::get('users/{user}/edit','UsersController@edit')->name('users.edit');
 Route::get('users/{user}/destroy','UsersController@destroy')->name('users.destroy');
   //*********************Rutas para imagenes del carrusel de la pagina web*******************************
  Route::resource('carrusel','CarruselController');

  
 //*******************administrar datos de pagina web****************************************************
  Route::resource('cotillon','MainPagineController');

  //********************MOVIMIENTOS************************************************************
  Route::resource('movements','MovementsController',['only'=>['create','store','index']]);
  

  //------------------------------Reporte de moviemientos-------------------------------------------

  Route::get('reportMovements/{startDate}/{endDate}/','PdfController@createReportMovements')->name('reportMovements');

 });

//------------------------------Reporte de ventas semanales-------------------------------------------
 Route::get('reportWeeklySales','PdfController@reportWeeklySales')->name('reportWeeklySales');


//**********************CALENDARIO DE PEDIDOS***********************************************************
Route::get('/calendar','CalendarsController@calendar')->name('calendar');

Route::get('/calendar/{status}','CalendarsController@searchStatus')->name('searchStatus');


//*******************Pagina no autorizada******************************
Route::get('/noAutorizhed',function(){
return view('admin.role');})->name('noAutorizhed');

//**********************Ver perfil y cambiar contraseña***************************************************
 //Route::resource('users','UsersController');
Route::post('users/modifyMyPassword','UsersController@modifyMyPassword')->name('users.modifyMyPassword');
Route::post('users/changeMyPassword','UsersController@changeMyPassword')->name('users.changeMyPassword');
Route::get('users/editDatas','UsersController@editDatas')->name('users.editDatas');
Route::post('users/changeMyDatas','UsersController@changeMyDatas')->name('users.changeMyDatas');
Route::get('profile','UsersController@profile')->name('profile');
Route::get('users/{user}','UsersController@show')->name('users.show');
 });



});
Auth::routes();

//##########################################################################################################
                                    //Rutas para la pagina Web
//##########################################################################################################
Route::get('/', 'MainController@index');
Route::get('/index', 'MainController@index')->name('index');
Route::get('/aboutUs', 'AboutUsController@aboutUs')->name('aboutUs');
Route::get('/contactUs', 'ContactUsController@contactUs')->name('contactUs');
Route::get('/catalogue', 'CatalogsController@index')->name('catalogue');
Route::post('/contactForm', 'ContactUsController@contact')->name('contactForm');
Route::resource('/catalogueShow', 'CatalogsController');
Route::get('/events/{name}','CatalogsController@filtro')->name('searchEvent');
Route::get('/category/{id}/{name}','CatalogsController@searchCategoryProduct')->name('searchEventCategory');
Route::post('send', ['as' => 'send', 'uses' => 'MailController@send'] );
Route::get('contact', ['as' => 'contact', 'uses' => 'MailController@index'] );

//**************************Rutas para usuarios de pagina web*********************************

Route::get('my_profile/edit','UserWebController@edit')->name('webUsers.edit');
Route::put('my_profile/update','UserWebController@changeDatas')->name('webUsers.changeDatas');
Route::patch('my_profile/changePassword','UserWebController@changePassword')->name('webUsers.changePassword');

//****************************Rutas para carrito de compras************************************
Route::resource('shoppingcartsproducts','ShoppingCartsProductsController',['only'=>['store']]);
Route::get('/shoppingcartsproducts/{id}/destroy','ShoppingCartsProductsController@destroy')->name('shoppingcartsproducts.destroy');
Route::get('/MisCarritos','ShoppingCartsController@indexWeb')->name('MisCarritos');
route::get('/carrito','ShoppingCartsController@edit');
Route::resource('shoppingcarts','ShoppingCartsController',['only'=>['update']]);
Route::get('my_order/pdf','ShoppingCartsController@pdfOrderOnline')->name('my_order.pdf');
Route::get('/orderOnline','ShoppingCartsController@confirmOrderOnline')->name('orderOnline');

                  //se restringe a solo el uso de rutas store y destroy