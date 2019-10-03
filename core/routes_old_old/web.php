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


//Payment IPN
Route::get('/ipnbtc', 'Vendor\DepositController@ipnBchain')->name('ipn.bchain');
Route::get('/ipnblockbtc', 'Vendor\DepositController@blockIpnBtc')->name('ipn.block.btc');
Route::get('/ipnblocklite', 'Vendor\DepositController@blockIpnLite')->name('ipn.block.lite');
Route::get('/ipnblockdog', 'Vendor\DepositController@blockIpnDog')->name('ipn.block.dog');
Route::post('/ipnpaypal', 'Vendor\DepositController@ipnpaypal')->name('ipn.paypal');
Route::post('/ipnperfect', 'Vendor\DepositController@ipnperfect')->name('ipn.perfect');
Route::post('/ipnstripe', 'Vendor\DepositController@ipnstripe')->name('ipn.stripe');
Route::post('/ipnskrill', 'Vendor\DepositController@skrillIPN')->name('ipn.skrill');
Route::post('/ipncoinpaybtc', 'Vendor\DepositController@ipnCoinPayBtc')->name('ipn.coinPay.btc');
Route::post('/ipncoinpayeth', 'Vendor\DepositController@ipnCoinPayEth')->name('ipn.coinPay.eth');
Route::post('/ipncoinpaybch', 'Vendor\DepositController@ipnCoinPayBch')->name('ipn.coinPay.bch');
Route::post('/ipncoinpaydash', 'Vendor\DepositController@ipnCoinPayDash')->name('ipn.coinPay.dash');
Route::post('/ipncoinpaydoge', 'Vendor\DepositController@ipnCoinPayDoge')->name('ipn.coinPay.doge');
Route::post('/ipncoinpayltc', 'Vendor\DepositController@ipnCoinPayLtc')->name('ipn.coinPay.ltc');
Route::post('/ipncoin', 'Vendor\DepositController@ipnCoin')->name('ipn.coinpay');
Route::post('/ipncoingate', 'Vendor\DepositController@ipnCoinGate')->name('ipn.coingate');

Route::post('/ipnpaytm', 'Vendor\DepositController@ipnPayTm')->name('ipn.paytm');
Route::post('/ipnpayeer', 'Vendor\DepositController@ipnPayEer')->name('ipn.payeer');
Route::post('/ipnpaystack', 'Vendor\DepositController@ipnPayStack')->name('ipn.paystack');
Route::post('/ipnvoguepay', 'Vendor\DepositController@ipnVoguePay')->name('ipn.voguepay');
//Payment IPN

//Payment IPN
Route::get('/ipnbtc/payment', 'User\GatewayController@ipnBchain')->name('ipn.bchain.payment');
Route::get('/ipnblockbtc/payment', 'User\GatewayController@blockIpnBtc')->name('ipn.block.btc.payment');
Route::get('/ipnblocklite/payment', 'User\GatewayController@blockIpnLite')->name('ipn.block.lite.payment');
Route::get('/ipnblockdog/payment', 'User\GatewayController@blockIpnDog')->name('ipn.block.dog.payment');
Route::post('/ipnpaypal/payment', 'User\GatewayController@ipnpaypal')->name('ipn.paypal.payment');
Route::post('/ipnperfect/payment', 'User\GatewayController@ipnperfect')->name('ipn.perfect.payment');
Route::post('/ipnstripe/payment', 'User\GatewayController@ipnstripe')->name('ipn.stripe.payment');
Route::post('/ipnskrill/payment', 'User\GatewayController@skrillIPN')->name('ipn.skrill.payment');
Route::post('/ipncoinpaybtc/payment', 'User\GatewayController@ipnCoinPayBtc')->name('ipn.coinPay.btc.payment');
Route::post('/ipncoinpayeth/payment', 'User\GatewayController@ipnCoinPayEth')->name('ipn.coinPay.eth.payment');
Route::post('/ipncoinpaybch/payment', 'User\GatewayController@ipnCoinPayBch')->name('ipn.coinPay.bch.payment');
Route::post('/ipncoinpaydash/payment', 'User\GatewayController@ipnCoinPayDash')->name('ipn.coinPay.dash.payment');
Route::post('/ipncoinpaydoge/payment', 'User\GatewayController@ipnCoinPayDoge')->name('ipn.coinPay.doge.payment');
Route::post('/ipncoinpayltc/payment', 'User\GatewayController@ipnCoinPayLtc')->name('ipn.coinPay.ltc.payment');
Route::post('/ipncoin/payment', 'User\GatewayController@ipnCoin')->name('ipn.coinpay.payment');
Route::post('/ipncoingate/payment', 'User\GatewayController@ipnCoinGate')->name('ipn.coingate.payment');

Route::post('/ipnpaytm/payment', 'User\GatewayController@ipnPayTm')->name('ipn.paytm.payment');
Route::post('/ipnpayeer/payment', 'User\GatewayController@ipnPayEer')->name('ipn.payeer.payment');
Route::post('/ipnpaystack/payment', 'User\GatewayController@ipnPayStack')->name('ipn.paystack.payment');
Route::post('/ipnvoguepay/payment', 'User\GatewayController@ipnVoguePay')->name('ipn.voguepay.payment');
//Payment IPN


Route::get('/', 'User\PagesController@home')->name('user.home')->middleware('emailVerification', 'smsVerification', 'bannedUser');
Route::get('/flashsalecheck', 'User\PagesController@flashsalecheck')->name('flashsalecheck');
Route::get('/contact', 'User\PagesController@contact')->name('user.contact');
Route::post('/contact/mail', 'User\PagesController@contactMail')->name('user.contactMail');
Route::get('/products/{slug}/detail/{id}', 'ProductController@detailProduct')->name('user.productdetail.show');
Route::get('/immobiliers/{slug}/detail/{id}', 'ImmobilierController@detailImmobilier')->name('user.immobilierdetail.show');
Route::get('/services/{slug}/detail/{id}', 'ServiceController@detailService')->name('user.servicedetail.show');
Route::get('/emplois/{slug}/detail/{id}', 'EmploiController@detailEmploi')->name('user.emploidetail.show');
Route::get('/evenements/{slug}/detail/{id}', 'EvenementController@detailEvenement')->name('user.evenementdetail.show');

Route::get('/departement','DepartementController@getData')->name('get.departement');
Route::get('/product/{slug?}/{id?}/{category?}/{subcategory?}', 'ProductController@showTriProduct')->name('user.product.showTri');
// Route::get('/shop/{category?}/{subcategory?}', 'SearchController@search')->name('user.search');

Route::get('/product/{slug}/{id}', 'ProductController@show')->name('user.product.details');
Route::get('/immobilier/{slug}/{id}', 'ImmobilierController@show')->name('user.immobilier.details');
Route::get('/services/{slug}/{id}', 'ServiceController@show')->name('user.service.details');
Route::get('/annuaire/{slug}/{id}', 'AnnuaireController@show')->name('user.annuaire.details');
Route::get('/evenements/{slug}/{id}', 'EvenementController@show')->name('user.evenement.details');
Route::get('/product/getcomments', 'ProductController@getcomments')->name('user.product.getcomments');
Route::post('/cart/getproductdetails', 'CartController@getproductdetails')->name('user.cart.getproductdetails');
Route::get('/cart/getcart', 'CartController@getcart')->name('cart.getcart');
Route::get('/cart/clearcart', 'CartController@clearcart')->name('cart.clearcart');
Route::get('/cart/remove', 'CartController@remove')->name('cart.remove');
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/stock/check', 'CartController@stockcheck')->name('stock.check');
Route::post('/cart/update', 'CartController@update')->name('cart.update');
Route::get('/cart/getTotal', 'CartController@getTotal')->name('cart.getTotal');
Route::get('terms&conditions', 'User\PagesController@terms')->name('terms');
Route::get('privacypolicy', 'User\PagesController@privacy')->name('privacy');
Route::get('/{id}/productratings', 'ProductController@productratings')->name('user.productratings');
Route::get('/{id}/avgrating', 'ProductController@avgrating')->name('user.avgrating');
Route::get('/shop_page/{vendor}/{category?}/{subcategory?}', 'Vendor\VendorController@shoppage')->name('vendor.shoppage');
Route::post('/subscribe', 'User\PagesController@subscribe')->name('user.subscribe');


//Pack Gift User Routes
Route::get('/cartgift', 'User\PackgiftController@index')->name('user.cartgift');
Route::get('/cartgift/{id}/showform', 'User\PackgiftController@formshowpay')->name('user.cartgift.formshowpay');
Route::post('/cartgift/payment', 'User\PackgiftController@store')->name('user.cartgift.store');

//All deposit methods...
Route::get('/deposit-preview/{id}', 'User\DepositController@depositPreview')->name('user.deposit.preview');
Route::post('/deposit-confirm/{id}', 'User\DepositController@depositConfirm')->name('user.deposit.confirm');



// Dynamic Routes
Route::get('/{slug}/pages', 'User\PagesController@dynamicPage')->name('user.dynamicPage');

//SendMailSend
Route::post('/SendMailToVendor','sendMailController@sendmailToVendor')->name('envoi_msg');
Route::post('/sendMailToEmployer','User\EmployeeController@sendCartGiftToEmployee')->name('sendCartGiftToEmployer');
Route::post('/SendMail','sendMailController@sendmailToVendor')->name('sendMail');
// Search Routes
Route::get('/shop/{category?}/{subcategory?}', 'SearchController@search')->name('user.search');
Route::get('{slug?}/show_shop/{itemId}', 'SearchController@show')->name('items.show');
// Route::get('/shop/{category?}/{subcategory?}/{subsubcategory?}', 'SearchController@subsearch')->name('user.subsearch');
Route::get('/bestsellers', 'User\PagesController@bestsellers')->name('user.bestsellers');



// Cron Jobs
// it wil run per day
Route::get('/couponvaliditycheck', 'User\CheckoutController@couponvaliditycheck')->name('checkout.couponvaliditycheck');


// Ad increase route
Route::post('/ad/increaseAdView', 'User\AdController@increaseAdView')->name('ad.increaseAdView');
Route::post('review/submit', 'ProductController@reviewsubmit')->name('user.review.submit');


#=========== User Routes =============#
Route::group(['middleware' => 'guest'], function() {
		Route::get('/login', 'User\LoginController@login')->name('login');
		Route::post('/authenticate', 'User\LoginController@authenticate')->name('user.authenticate');
		Route::get('/page_connect', 'User\InscriptionController@index')->name('user.page_connect');
		
		Route::get('auth/{provider}', 'User\LoginController@redirectToProvider');
        Route::get('auth/{provider}/callback', 'User\LoginController@handleProviderCallback');


		Route::get('/register', 'User\RegController@showregform')->name('user.showregform');
		Route::get('entreprise/register', 'User\RegController@showregform')->name('user.showregform.entreprise');
		Route::post('/register', 'User\RegController@register')->name('user.register');

		// Password Reset Routes
    Route::get('/showEmailForm', 'User\ForgotPasswordController@showEmailForm')->name('user.showEmailForm');
    Route::post('/sendResetPassMail', 'User\ForgotPasswordController@sendResetPassMail')->name('user.sendResetPassMail');
    Route::get('/reset/{code}', 'User\ForgotPasswordController@resetPasswordForm')->name('user.resetPasswordForm');
    Route::post('/resetPassword', 'User\ForgotPasswordController@resetPassword')->name('user.resetPassword');
});


Route::group(['middleware' => 'auth'], function() {
		Route::get('/logout/{id?}', 'User\LoginController@logout')->name('user.logout');


		// Verification Routes...
	  Route::get('/showEmailVerForm', 'User\VerificationController@showEmailVerForm')->name('user.showEmailVerForm');
		Route::get('/showSmsVerForm', 'User\VerificationController@showSmsVerForm')->name('user.showSmsVerForm');
	  Route::post('/checkEmailVerification', 'User\VerificationController@emailVerification')->name('user.checkEmailVerification');
	  Route::post('/checkSmsVerification', 'User\VerificationController@smsVerification')->name('user.checkSmsVerification');
		Route::post('/sendVcode', 'User\VerificationController@sendVcode')->name('user.sendVcode');


	  // Profile routes
		Route::get('/profile', 'User\ProfileController@profile')->name('user.profile')->middleware('emailVerification', 'smsVerification', 'bannedUser');
	  Route::post('/infoupdate', 'User\ProfileController@infoupdate')->name('user.information.update');
	  Route::get('/changepassword', 'User\ProfileController@changepassword')->name('user.changepassword')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		Route::post('/update/password', 'User\ProfileController@updatePassword')->name('user.updatePassword');

		// Profile routes
		Route::get('/list_professional', 'User\ProfileController@listprofessional')->name('user.professional');
		Route::get('/MailToVendor/{vendorID}','User\ProfileController@envoi_msg')->name('envoi_msg.index');
		Route::post('/SendMailToVendor','User\ProfileController@sendmailToVendor')->name('sendenvoi_msg');
		
		
		// Shipping address routes
		Route::get('/shipping', 'User\ProfileController@shipping')->name('user.shipping')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		Route::post('/shippingupdate', 'User\ProfileController@shippingupdate')->name('user.shippingupdate');
		
		// Billing address routes
		Route::get('/billing', 'User\ProfileController@billing')->name('user.billing')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		Route::post('/billingupdate', 'User\ProfileController@billingupdate')->name('user.billingupdate');
		Route::get('/{vendorId}/billingdetails','User\ProfileController@billingdetail')->name('billing.detail');


		// Checkout Routes
		Route::get('/checkout', 'User\CheckoutController@index')->name('user.checkout.index')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		Route::get('/updateTotal','User\CheckoutController@update')->name('user.update.getTotal');
		Route::post('/coupon/apply', 'User\CheckoutController@applycoupon')->name('user.checkout.applycoupon');
		Route::post('/placeorder', 'User\CheckoutController@placeorder')->name('user.checkout.placeorder');
		Route::get('/checkout/success', 'User\CheckoutController@success')->name('user.checkout.success')->middleware('emailVerification', 'smsVerification', 'bannedUser');


		// Gateway Routes
		Route::match(['get', 'post'], '/gateways/{orderid?}', 'User\GatewayController@gateways')->name('user.gateways')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		Route::post('/paymentDataInsert', 'User\GatewayController@paymentDataInsert')->name('user.paymentDataInsert');
		Route::get('/paymentPreview', 'User\GatewayController@paymentPreview')->name('user.paymentPreview')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		Route::post('/payment-confirm', 'User\GatewayController@paymentConfirm')->name('payment.confirm');

		// Employees Routes
		Route::get('/employees','User\EmployeeController@index')->name('user.employees');
		Route::post('/employees/import','User\EmployeeController@import')->name('user.employees.import');
		Route::get('/employees/edit','User\EmployeeController@edit')->name('user.employees.edit');
		Route::post('/employees/addcartgift','User\EmployeeController@addcartgift')->name('user.employees.addcartgift');
		Route::get('/employees/export','User\EmployeeController@export')->name('user.employees.export');
		Route::get('/employees/export','User\EmployeeController@export')->name('user.employees.export');
		Route::post('/employees/delete','User\EmployeeController@destroy')->name('user.employees.delete');

		// favorit
		Route::get('/wishlist', 'User\ProfileController@wishlist')->name('user.wishlist')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		Route::post('/favorit', 'ProductController@favorit')->name('user.favorit');

		// orders
		Route::get('/{vendorId}/orders', 'User\ProfileController@orders')->name('user.orders')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		Route::get('/{userId}/order', 'User\ProfileController@order')->name('user.orderforUser')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		Route::get('/{orderid}/orderdetails', 'User\ProfileController@orderdetails')->name('user.orderdetails')->middleware('emailVerification', 'smsVerification', 'bannedUser');
		// Route::get('/{orderid}/printOrder', 'User\ProfileController@printorderdetails')->name('print.bell');
		Route::get('/facture/{orderid}/{vendorId}', 'User\ProfileController@view_facture')->name('user.view_facture');
		Route::post('/complain', 'User\ProfileController@complain')->name('user.complain');
		Route::post('/refund', 'User\ProfileController@refund')->name('user.refund');
});

#=========== Vendor Routes =============#
Route::get('/page_inscription', 'Vendor\InscriptionController@index')->name('page_inscription');
Route::get('/vendor','Vendor\LoginController@login')->name('vendor.login')->middleware('guest:vendor');
Route::group(['prefix' => 'vendor', 'middleware' => 'guest:vendor'], function () {
	Route::post('/authenticate', 'Vendor\LoginController@authenticate')->name('vendor.authenticate');

	Route::get('/register', 'Vendor\RegController@showRegForm')->name('vendor.showRegForm');
	Route::post('/register', 'Vendor\RegController@register')->name('vendor.reg');

	// Password Reset Routes
	Route::get('/showEmailForm', 'Vendor\ForgotPasswordController@showEmailForm')->name('vendor.showEmailForm');
	Route::post('/sendResetPassMail', 'Vendor\ForgotPasswordController@sendResetPassMail')->name('vendor.sendResetPassMail');
	Route::get('/reset/{code}', 'Vendor\ForgotPasswordController@resetPasswordForm')->name('vendor.resetPasswordForm');
	Route::post('/resetPassword', 'Vendor\ForgotPasswordController@resetPassword')->name('vendor.resetPassword');
});

Route::group(['prefix' => 'vendor', 'middleware' => ['auth:vendor']], function () {
	Route::get('/dashboard', 'Vendor\VendorController@dashboard')->name('vendor.dashboard')->middleware('bannedVendor');
	Route::get('/logout/{id?}', 'Vendor\LoginController@logout')->name('vendor.logout');

	//Categorie Route
	Route::get('/category/{slug}/add','Vendor\CategorieController@index')->name('vendor.categorie');
	
	//Immobilier Route
	Route::post('/immovable/store','Vendor\ImmobilierController@store')->name('vendor.immobilier.store');
	Route::get('/immovable/{slug}/create','Vendor\ImmobilierController@create')->name('vendor.immobilier.create');
	Route::get('/immovable/{id}/edit','Vendor\ImmobilierController@edit')->name('vendor.immobilier.edit');
	Route::post('/immovable/{id}/update','Vendor\ImmobilierController@update')->name('vendor.immobilier.update');
	Route::post('/immovable/delete','Vendor\ImmobilierController@destroy')->name('vendor.immobilier.delete');

	//Service Route
	Route::post('/service/store','Vendor\ServiceController@store')->name('vendor.service.store');
	Route::get('/service/{slug}/create','Vendor\ServiceController@create')->name('vendor.service.create');
	Route::get('/service/{id}/edit','Vendor\ServiceController@edit')->name('vendor.service.edit');
	Route::post('/service/{id}/update','Vendor\ServiceController@update')->name('vendor.service.update');
	Route::post('/service/delete','Vendor\ServiceController@destroy')->name('vendor.service.delete');

	//Event Route
	Route::post('/evenement/store','Vendor\EventController@store')->name('vendor.event.store');
	Route::get('/evenement/{slug}/create','Vendor\EventController@create')->name('vendor.event.create');
	Route::get('/evenement/{id}/edit','Vendor\EventController@edit')->name('vendor.event.edit');
	Route::post('/evenement/{id}/update','Vendor\EventController@update')->name('vendor.event.update');
	Route::post('/evenement/delete','Vendor\EventController@destroy')->name('vendor.event.delete');

	//Emploi Route
	Route::post('/emploi/store','Vendor\EmploiController@store')->name('vendor.emploi.store');
	Route::get('/emploi/{slug}/create','Vendor\EmploiController@create')->name('vendor.emploi.create');
	Route::get('/emploi/{id}/edit','Vendor\EmploiController@edit')->name('vendor.emploi.edit');
	Route::post('/emploi/{id}/update','Vendor\EmploiController@update')->name('vendor.emploi.update');
	Route::post('/emploi/delete','Vendor\EmploiController@destroy')->name('vendor.emploi.delete');


	// Charge Setting Routes
	Route::get('/charge/index', 'Vendor\ChargeController@index')->name('vendor.charge.index');
	Route::get('/annonce/index', 'Vendor\AnnonceController@index')->name('vendor.annonce.index');
	Route::post('/shipping/update', 'Vendor\ChargeController@shippingupdate')->name('vendor.shipping.update');
	Route::post('/tax/update', 'Vendor\ChargeController@taxupdate')->name('vendor.tax.update');

	//Partenaire Controller
	Route::get('/partenaire/index', 'Vendor\PartenaireController@index')->name('vendor.partenaire.index');
	Route::post('/partenaire/store', 'Vendor\PartenaireController@store')->name('vendor.partenaire.store');

	// transaction log
	Route::get('/transactions', 'Vendor\VendorController@transactions')->name('vendor.transactions');

	// Coupon log
	Route::get('/couponlog', 'Vendor\VendorController@couponlog')->name('vendor.couponlog');

	// Password Routes
	Route::get('/changepassword', 'Vendor\VendorController@changePassword')->name('vendor.changePassword')->middleware('bannedVendor');
	Route::post('/updatepassword', 'Vendor\VendorController@updatePassword')->name('vendor.updatePassword');


	// All deposit methods...
	Route::match(['get', 'post'], '/depositMethods', 'Vendor\DepositController@showDepositMethods')->name('vendor.showDepositMethods')->middleware('bannedVendor');
	Route::post('/depositDataInsert', 'Vendor\DepositController@depositDataInsert')->name('vendor.depositDataInsert');
	Route::get('/deposit-preview', 'Vendor\DepositController@depositPreview')->name('vendor.deposit.preview')->middleware('bannedVendor');
	Route::post('/deposit-confirm', 'Vendor\DepositController@depositConfirm')->name('deposit.confirm');


	// All withdraw routes...
	Route::get('/withdrawMoney', 'Vendor\WithdrawMoneyController@withdrawMoney')->name('vendor.withdrawMoney')->middleware('bannedVendor');
	Route::post('/withdrawRequest/store', 'Vendor\WithdrawMoneyController@store')->name('vendor.withdrawRequest.store');


	// Package Routes
  	Route::get('/packages', 'Vendor\PackageController@index')->name('package.index')->middleware('bannedVendor');
  	Route::post('/package/buy', 'Vendor\PackageController@buy')->name('package.buy');
	Route::get('/validitycheck', 'Vendor\PackageController@validitycheck')->name('package.validitycheck');



	// Settings Routes
	Route::get('/settings', 'Vendor\SettingController@settings')->name('vendor.setting')->middleware('bannedVendor');
	Route::post('/settings/update', 'Vendor\SettingController@update')->name('vendor.setting.update');
	
	//Message Routes
	Route::get('/settings/message', 'Vendor\MessageController@index')->name('vendor.message');
	Route::get('/settings/MarkMessageAsRead', 'Vendor\MessageController@MessageRead')->name('vendor.message.read');


	// Product Routes
	Route::get('/product/create', 'Vendor\ProductController@create')->name('vendor.product.create')->middleware('bannedVendor');
	Route::post('/product/store', 'Vendor\ProductController@store')->name('vendor.product.store');
	Route::get('/product/getsubcategories', 'Vendor\ProductController@getsubcats')->name('vendor.product.getsubcats');
	Route::get('/product/getattributes', 'Vendor\ProductController@getattributes')->name('vendor.product.getattributes');
	Route::get('/product/manage', 'Vendor\ProductController@manage')->name('vendor.product.manage')->middleware('bannedVendor');
	Route::get('/product/{id}/edit', 'Vendor\ProductController@edit')->name('vendor.product.edit')->middleware('bannedVendor');
	Route::post('/product/update', 'Vendor\ProductController@update')->name('vendor.product.update');
	Route::get('/product/{id}/getimgs', 'Vendor\ProductController@getimgs')->name('vendor.product.getimgs');
	Route::post('/delete', 'Vendor\ProductController@delete')->name('vendor.product.delete');

	//Delivery Man Routes
	Route::get('/deliveryman','Vendor\DeliverymanController@deliveryman')->name('vendor.deliveryman.manage');
	Route::get('/deliveryman/create','Vendor\DeliverymanController@create')->name('vendor.deliveryman.create');
	Route::post('/deliveryman/store','Vendor\DeliverymanController@store')->name('vendor.deliveryman.store');
	Route::get('/deliveryman/{id}/edit','Vendor\DeliverymanController@edit')->name('vendor.deliveryman.edit');
	Route::post('/deliveryman/{id}/update','Vendor\DeliverymanController@update')->name('vendor.deliveryman.update');
	Route::post('/deliveryman/destroy','Vendor\DeliverymanController@destroy')->name('vendor.deliveryman.destroy');
	Route::post('/deliveryman/active','Vendor\DeliverymanController@active')->name('vendor.deliveryman.active');

	// Order Routes
	Route::get('/order', 'Vendor\OrderController@orders')->name('vendor.orders')->middleware('bannedVendor');
	Route::get('/{orderid}/orderdetails', 'Vendor\OrderController@orderdetails')->name('vendor.orderdetails')->middleware('bannedVendor');
	Route::post('/orders/shippingchange', 'Vendor\OrderController@shippingchange')->name('vendor.shippingchange');
	Route::post('/orders/accepted', 'Vendor\OrderController@acceptOrder')->name('vendor.acceptOrder');
	Route::post('/orders/rejected', 'Vendor\OrderController@cancelOrder')->name('vendor.cancelOrder');

	Route::get('/orders/confirmation/pending', 'Vendor\OrderController@PendingOrders')->name('vendor.orders.progress');
	Route::get('/orders/confirmation/accepted', 'Vendor\OrderController@AcceptedOrders')->name('vendor.orders.accepted');
	Route::get('/orders/delivery/pending', 'Vendor\OrderController@pendingDelivery')->name('vendor.orders.in_delivering');
	Route::get('/orders/delivery/inprocess', 'Vendor\OrderController@pendingInprocess')->name('vendor.orders.awaiting_delivery');
	Route::get('/orders/delivered', 'Vendor\OrderController@delivered')->name('vendor.orders.delivered');
	Route::get('/orders/cashondelivery', 'Vendor\OrderController@cashOnDelivery')->name('vendor.orders.payment_on_delivery');
	Route::get('/orders/advance', 'Vendor\OrderController@advance')->name('vendor.orders.advance_paid');

});




#=========== Admin Routes =============#
Route::group(['prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
	Route::get('/','Admin\AdminLoginController@index')->name('admin.loginForm');
	Route::post('/authenticate', 'Admin\AdminLoginController@authenticate')->name('admin.login');
});



Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin']], function () {
  Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('admin.dashboard');
	Route::get('/logout', 'Admin\AdminController@logout')->name('admin.logout');



	// Coupon Routes
	Route::get('/coupon/index', 'Admin\CouponController@index')->name('admin.coupon.index');
	Route::get('/coupon/create', 'Admin\CouponController@create')->name('admin.coupon.create');
	Route::post('/coupon/store', 'Admin\CouponController@store')->name('admin.coupon.store');
	Route::get('/coupon/{id}/edit', 'Admin\CouponController@edit')->name('admin.coupon.edit');
	Route::post('/coupon/update', 'Admin\CouponController@update')->name('admin.coupon.update');
	Route::post('/coupon/delete', 'Admin\CouponController@delete')->name('admin.coupon.delete');


	// Report Routes
//   Route::get('/reports', 'Admin\ReportController@reports')->name('admin.reports');



  // Profile Routes
  Route::get('/changePassword', 'Admin\AdminController@changePass')->name('admin.changePass');
  Route::post('/profile/updatePassword', 'Admin\AdminController@updatePassword')->name('admin.updatePassword');
  Route::get('/profile/edit/{adminID}', 'Admin\AdminController@editProfile')->name('admin.editProfile');
	Route::post('/profile/update/{adminID}', 'Admin\AdminController@updateProfile')->name('admin.updateProfile');




  // Website Control Routes...
  Route::get('/generalSetting', 'Admin\GeneralSettingController@GenSetting')->name('admin.GenSetting');
	Route::post('/generalSetting', 'Admin\GeneralSettingController@UpdateGenSetting')->name('admin.UpdateGenSetting');
  Route::get('/EmailSetting', 'Admin\EmailSettingController@index')->name('admin.EmailSetting');
  Route::post('/EmailSetting', 'Admin\EmailSettingController@updateEmailSetting')->name('admin.UpdateEmailSetting');
  Route::get('/SmsSetting', 'Admin\SmsSettingController@index')->name('admin.SmsSetting');
  Route::post('/SmsSetting', 'Admin\SmsSettingController@updateSmsSetting')->name('admin.UpdateSmsSetting');
	Route::get('/facebook/index', 'Admin\FacebookController@index')->name('admin.facebook.index');
	Route::post('/facebook/update', 'Admin\FacebookController@update')->name('admin.facebook.update');


	// Charge Setting Routes
	Route::get('/charge/index', 'Admin\ChargeController@index')->name('admin.charge.index');
	Route::post('/shipping/update', 'Admin\ChargeController@shippingupdate')->name('admin.shipping.update');
	Route::post('/tax/update', 'Admin\ChargeController@taxupdate')->name('admin.tax.update');



	// Package Routes
  Route::get('/packages', 'Admin\PackageController@index')->name('admin.package');
  Route::post('/packages/store', 'Admin\PackageController@store')->name('admin.package.store');
  Route::post('/packages/update', 'Admin\PackageController@update')->name('admin.package.update');

	// Pack gift Routes
  Route::get('/packgift', 'Admin\PackgiftController@index')->name('admin.packgift');
  Route::get('/packgift/{id}/cartgift','Admin\PackgiftController@show')->name('admin.packgift.show');
  Route::post('/packgift/store', 'Admin\PackgiftController@store')->name('admin.packgift.store');
  Route::post('/packgift/update', 'Admin\PackgiftController@update')->name('admin.packgift.update');
  Route::post('/packgift/delete', 'Admin\PackgiftController@delete')->name('admin.packgift.delete');
  // Cart gift Routes
  Route::get('/cartgift', 'Admin\CartgiftController@index')->name('admin.cartgift');
  Route::post('/cartgift/store', 'Admin\CartgiftController@store')->name('admin.cartgift.store');
  Route::post('/cartgift/update', 'Admin\CartgiftController@update')->name('admin.cartgift.update');
  Route::post('/cartgift/delete', 'Admin\CartgiftController@delete')->name('admin.cartgift.delete');


	// Product Attribute Management...
	Route::get('/productattr/index', 'Admin\ProductattrController@index')->name('admin.productattr.index');
	Route::post('/productattr/store', 'Admin\ProductattrController@store')->name('admin.productattr.store');
	Route::post('/productattr/update', 'Admin\ProductattrController@update')->name('admin.productattr.update');

/* 	//Central d'Achat
	Route::get('/central_achat/index','Admin\CentralAchatController@index')->name('admin.centralachat.index');
	Route::post('/central_achat/store','Admin\CentralAchatController@store')->name('admin.centralachat.store');
	Route::post('/central_achat/update','Admin\CentralAchatController@update')->name('admin.centralachat.update');
 */

	// Option Management...
	Route::get('/options/{id}/index', 'Admin\OptionController@index')->name('admin.options.index');
	Route::post('/options/store', 'Admin\OptionController@store')->name('admin.options.store');
	Route::post('/options/update', 'Admin\OptionController@update')->name('admin.options.update');


  // Category Management...
  Route::get('/category/index', 'Admin\CategoryController@index')->name('admin.category.index');
  Route::post('/category/store', 'Admin\CategoryController@store')->name('admin.category.store');
  Route::post('/category/update', 'Admin\CategoryController@update')->name('admin.category.update');
  Route::post('/category/delete', 'Admin\CategoryController@delete')->name('admin.category.delete');



	// Subcategory Management...
	Route::get('/subcategory/{id}/index', 'Admin\SubcategoryController@index')->name('admin.subcategory.index');
  Route::post('/subcategory/store', 'Admin\SubcategoryController@store')->name('admin.subcategory.store');
	Route::post('/subcategory/update', 'Admin\SubcategoryController@update')->name('admin.subcategory.update');
	Route::post('/subcategory/delete', 'Admin\SubcategoryController@destroy')->name('admin.subcategory.destroy');
	
	// Subcategory1 Management...
	Route::get('/subsubcategory/{id}/index', 'Admin\SubsubcategoryController@index')->name('admin.subcategory1.index');
  Route::post('/subsubcategory/store', 'Admin\SubsubcategoryController@store')->name('admin.subcategory1.store');
	Route::post('/subsubcategory/update', 'Admin\SubsubcategoryController@update')->name('admin.subcategory1.update');
	Route::post('/subsubcategory/delete', 'Admin\SubsubcategoryController@destroy')->name('admin.subcategory1.destroy');
	
	// Subcategory2 Management...
	Route::get('/subsubsubcategory/{id}/index', 'Admin\SubSubsubcategoryController@index')->name('admin.subcategory2.index');
  Route::post('/subsubsubcategory/store', 'Admin\SubSubsubcategoryController@store')->name('admin.subcategory2.store');
	Route::post('/subsubsubcategory/update', 'Admin\SubSubsubcategoryController@update')->name('admin.subcategory2.update');


	// Vendor management Routes...
	Route::get('/vendorManagement/allVendors', 'Admin\VendorManagementController@allVendors')->name('admin.allVendors');
  Route::get('/vendorManagement/allVendorsSearchResult', 'Admin\VendorManagementController@allVendorsSearchResult' )->name('admin.allVendorsSearchResult');
  Route::get('/vendorManagement/bannedVendors', 'Admin\VendorManagementController@bannedVendors')->name('admin.bannedVendors');
	Route::get('/vendorManagement/bannedVendorsSearchResult', 'Admin\VendorManagementController@bannedVendorsSearchResult' )->name('admin.bannedVendorsSearchResult');
	Route::get('/vendorManagement/vendorDetails/{vendorID}', 'Admin\VendorManagementController@vendorDetails')->name('admin.vendorDetails');
  Route::post('/vendorManagement/updateVendorDetails', 'Admin\VendorManagementController@updateVendorDetails')->name('admin.updateVendorDetails');
  Route::get('/vendorManagement/addSubtractBalance/{vendorID}', 'Admin\VendorManagementController@addSubtractBalance')->name('admin.vendor.addSubtractBalance');
  Route::post('/vendorManagement/updateVendorBalance', 'Admin\VendorManagementController@updateVendorBalance')->name('admin.updateVendorBalance');
  Route::get('/vendorManagement/emailToVendor/{vendorID}', 'Admin\VendorManagementController@emailToVendor')->name('admin.emailToVendor');
  Route::post('/vendorManagement/sendEmailToVendor', 'Admin\VendorManagementController@sendEmailToVendor')->name('admin.sendEmailToVendor');



  // User management Routes...
	Route::get('/userManagement/allUsers', 'Admin\UserManagementController@allUsers')->name('admin.allUsers');
  Route::get('/userManagement/allUsersSearchResult', 'Admin\UserManagementController@allUsersSearchResult' )->name('admin.allUsersSearchResult');
  Route::get('/userManagement/bannedUsers', 'Admin\UserManagementController@bannedUsers')->name('admin.bannedUsers');
	Route::get('/userManagement/bannedUsersSearchResult', 'Admin\UserManagementController@bannedUsersSearchResult' )->name('admin.bannedUsersSearchResult');
  Route::get('/userManagement/verifiedUsers', 'Admin\UserManagementController@verifiedUsers')->name('admin.verifiedUsers');
  Route::get('/userManagement/verUsersSearchResult', 'Admin\UserManagementController@verUsersSearchResult' )->name('admin.verUsersSearchResult');
  Route::get('/userManagement/mobileUnverifiedUsers', 'Admin\UserManagementController@mobileUnverifiedUsers')->name('admin.mobileUnverifiedUsers');
	Route::get('/userManagement/mobileUnverifiedUsersSearchResult', 'Admin\UserManagementController@mobileUnverifiedUsersSearchResult' )->name('admin.mobileUnverifiedUsersSearchResult');
  Route::get('/userManagement/emailUnverifiedUsers', 'Admin\UserManagementController@emailUnverifiedUsers')->name('admin.emailUnverifiedUsers');
  Route::get('/userManagement/emailUnverifiedUsersSearchResult', 'Admin\UserManagementController@emailUnverifiedUsersSearchResult' )->name('admin.emailUnverifiedUsersSearchResult');
	Route::get('/userManagement/userDetails/{userID}', 'Admin\UserManagementController@userDetails')->name('admin.userDetails');
  Route::post('/userManagement/updateUserDetails', 'Admin\UserManagementController@updateUserDetails')->name('admin.updateUserDetails');
  Route::get('/userManagement/addSubtractBalance/{userID}', 'Admin\UserManagementController@addSubtractBalance')->name('admin.addSubtractBalance');
  Route::post('/userManagement/updateUserBalance', 'Admin\UserManagementController@updateUserBalance')->name('admin.updateUserBalance');
  Route::get('/userManagement/emailToUser/{userID}', 'Admin\UserManagementController@emailToUser')->name('admin.emailToUser');
  Route::post('/userManagement/sendEmailToUser', 'Admin\UserManagementController@sendEmailToUser')->name('admin.sendEmailToUser');
	Route::get('/userManagement/ads/{userID}', 'Admin\UserManagementController@ads')->name('admin.userManagement.ads');


	// Subscriber Management Routes
  Route::get('/subscribers', 'Admin\SubscManageController@subscribers')->name('admin.subscribers');
	Route::post('/mailtosubsc', 'Admin\SubscManageController@mailtosubsc')->name('admin.mailtosubsc');


  // Gateway Routes...
  Route::get('/gateways', 'Admin\GatewayController@index')->name('admin.gateways');
	Route::post('/gateway/update', 'Admin\GatewayController@update')->name('update.gateway');
	Route::post('/gateway/store', 'Admin\GatewayController@store')->name('store.gateway');


	// Vendor Routes...
	Route::get('/vendors/all', 'Admin\VendorController@all')->name('admin.vendors.all');
	Route::post('/vendors/create','Admin\VendorController@register')->name('admin.vendor.register');
	Route::get('/vendors/pending', 'Admin\VendorController@pending')->name('admin.vendors.pending');
	Route::get('/vendors/accepted', 'Admin\VendorController@accepted')->name('admin.vendors.accepted');
	Route::get('/vendors/rejected', 'Admin\VendorController@rejected')->name('admin.vendors.rejected');
	Route::post('/vendors/accept', 'Admin\VendorController@accept')->name('admin.vendors.accept');
	Route::post('/vendors/reject', 'Admin\VendorController@reject')->name('admin.vendors.reject');


	// Flash Sale setups
	Route::get('/flashsale/times', 'Admin\FlashsaleController@times')->name('admin.flashsale.times');
	Route::post('/flashsale/updatetimes', 'Admin\FlashsaleController@updatetimes')->name('admin.flashsale.updatetimes');
	Route::get('/flashsale/all', 'Admin\FlashsaleController@all')->name('admin.flashsale.all');
	Route::get('/flashsale/pending', 'Admin\FlashsaleController@pending')->name('admin.flashsale.pending');
	Route::get('/flashsale/accepted', 'Admin\FlashsaleController@accepted')->name('admin.flashsale.accepted');
	Route::get('/flashsale/rejected', 'Admin\FlashsaleController@rejected')->name('admin.flashsale.rejected');
	Route::post('/flashsale/changestatus', 'Admin\FlashsaleController@changestatus')->name('admin.flashsale.changestatus');



	// Order Routes...
	Route::get('/orders/all', 'Admin\OrderController@all')->name('admin.orders.all');
	Route::get('/orders/confirmation/pending', 'Admin\OrderController@cPendingOrders')->name('admin.orders.cPendingOrders');
	Route::get('/orders/confirmation/accepted', 'Admin\OrderController@cAcceptedOrders')->name('admin.orders.cAcceptedOrders');
	Route::get('/orders/confirmation/rejected', 'Admin\OrderController@cRejectedOrders')->name('admin.orders.cRejectedOrders');
	Route::get('/orders/delivery/pending', 'Admin\OrderController@pendingDelivery')->name('admin.orders.pendingDelivery');
	Route::get('/orders/delivery/inprocess', 'Admin\OrderController@pendingInprocess')->name('admin.orders.pendingInprocess');
	Route::get('/orders/delivered', 'Admin\OrderController@delivered')->name('admin.orders.delivered');
	Route::get('/orders/cashondelivery', 'Admin\OrderController@cashOnDelivery')->name('admin.orders.cashOnDelivery');
	Route::get('/orders/advance', 'Admin\OrderController@advance')->name('admin.orders.advance');
	Route::get('/{orderid}/orderdetails', 'Admin\OrderController@orderdetails')->name('admin.orderdetails');



	// Comment routes..
	Route::get('/comments', 'Admin\CommentController@all')->name('admin.comments.all');
	Route::get('/complains', 'Admin\CommentController@complains')->name('admin.complains');
	Route::get('/suggestions', 'Admin\CommentController@suggestions')->name('admin.suggestions');


	// Refund routes..
	Route::get('/refunds/all', 'Admin\RefundController@all')->name('admin.refunds.all');
	Route::get('/refunds/pending', 'Admin\RefundController@pending')->name('admin.refunds.pending');
	Route::get('/refunds/accepted', 'Admin\RefundController@accepted')->name('admin.refunds.accepted');
	Route::get('/refunds/rejected', 'Admin\RefundController@rejected')->name('admin.refunds.rejected');
	Route::post('/refunds/accept', 'Admin\RefundController@accept')->name('admin.refunds.accept');
	Route::post('/refunds/reject', 'Admin\RefundController@reject')->name('admin.refunds.reject');



	Route::post('/shippingchange', 'Admin\OrderController@shippingchange')->name('admin.shippingchange');
	Route::post('/cancelOrder', 'Admin\OrderController@cancelOrder')->name('admin.cancelOrder');
	Route::post('/acceptOrder', 'Admin\OrderController@acceptOrder')->name('admin.acceptOrder');



	// Deposit Routes...
  Route::get('/deposit/pending','Admin\DepositController@pending')->name('admin.deposit.pending');
	Route::get('/deposit/showReceipt', 'Admin\DepositController@showReceipt')->name('admin.deposit.showReceipt');
	Route::post('/deposit/accept', 'Admin\DepositController@accept')->name('admin.deposit.accept');
	Route::post('/deposit/rejectReq','Admin\DepositController@rejectReq')->name('admin.deposit.rejectReq');
	Route::get('/deposit/acceptedRequests','Admin\DepositController@acceptedRequests')->name('admin.deposit.acceptedRequests');
	Route::get('/deposit/depositLog','Admin\DepositController@depositLog')->name('admin.deposit.depositLog');
	Route::get('/deposit/rejectedRequests','Admin\DepositController@rejectedRequests')->name('admin.deposit.rejectedRequests');



	// Withdraw method CRUD routes...
	Route::get('/withdrawMethod', 'Admin\withdrawMoney\withdrawMethodController@withdrawMethod')->name('admin.withdrawMethod');
	Route::post('/withdrawMethod/store', 'Admin\withdrawMoney\withdrawMethodController@store')->name('withdrawMethod.store');
	Route::get('/withdrawMethod/edit', 'Admin\withdrawMoney\withdrawMethodController@edit')->name('withdrawMethod.edit');
	Route::post('/withdrawMethod/update', 'Admin\withdrawMoney\withdrawMethodController@update')->name('withdrawMethod.update');
	Route::post('/withdrawMethod/delete', 'Admin\withdrawMoney\withdrawMethodController@destroy')->name('withdrawMethod.destroy');
	Route::post('/withdrawMethod/enable', 'Admin\withdrawMoney\withdrawMethodController@enable')->name('withdrawMethod.enable');
  // Withdraw Money Routes
  Route::get('/withdrawLog', 'Admin\withdrawMoney\withdrawLogController@withdrawLog')->name('admin.withdrawLog');
	Route::get('/successLog', 'Admin\withdrawMoney\successLogController@successLog')->name('admin.withdrawMoney.successLog');
	Route::get('/refundedLog', 'Admin\withdrawMoney\refundedLogController@refundedLog')->name('admin.withdrawMoney.refundedLog');
	Route::get('/pendingLog', 'Admin\withdrawMoney\pendingLogController@pendingLog')->name('admin.withdrawMoney.pendingLog');

	Route::get('/withdrawLog/{wID}', 'Admin\withdrawMoney\withdrawLogController@show')->name('withdrawLog.show');
	Route::post('/withdrawLog/message/store', 'Admin\withdrawMoney\withdrawLogController@storeMessage')->name('withdrawLog.message.store');



  // Ad Routes...
  Route::get('/Ad/index', 'Admin\AdController@index')->name('admin.ad.index');
  Route::get('/Ad/create', 'Admin\AdController@create')->name('admin.ad.create');
  Route::post('/Ad/store', 'Admin\AdController@store')->name('admin.ad.store');
  Route::get('/Ad/showImage', 'Admin\AdController@showImage')->name('admin.ad.showImage');
  Route::post('/Ad/delete', 'Admin\AdController@delete')->name('admin.ad.delete');


	// Refund Policy Routes
	Route::get('policy/refund/index', 'Admin\PolicyController@refund')->name('admin.refund.index');
	Route::post('policy/refund/update', 'Admin\PolicyController@refundupdate')->name('admin.refund.update');

	// Refund Policy Routes
	Route::get('policy/replacement/index', 'Admin\PolicyController@replacement')->name('admin.replacement.index');
	Route::post('policy/replacement/update', 'Admin\PolicyController@replacementupdate')->name('admin.replacement.update');


	// Menu Manager Routes
	Route::get('/menuManager/index', 'Admin\menuManagerController@index')->name('admin.menuManager.index');
    Route::get('/menuManager/add', 'Admin\menuManagerController@add')->name('admin.menuManager.add');
	Route::post('/menuManager/store', 'Admin\menuManagerController@store')->name('admin.menuManager.store');
	Route::get('/menuManager/{menuID}/edit', 'Admin\menuManagerController@edit')->name('admin.menuManager.edit');
	Route::post('/menuManager/{menuID}/update', 'Admin\menuManagerController@update')->name('admin.menuManager.update');
	Route::post('/menuManager/{menuID}/delete', 'Admin\menuManagerController@delete')->name('admin.menuManager.delete');


	// Terms & COndition Routes
	Route::get('/tos/index', 'Admin\TosController@index')->name('admin.tos.index');
	Route::post('/tos/update', 'Admin\TosController@update')->name('admin.tos.update');

	// Privacy Policy Routes
	Route::get('/privacy/index', 'Admin\PrivacyController@index')->name('admin.privacy.index');
	Route::post('/privacy/update', 'Admin\PrivacyController@update')->name('admin.privacy.update');

	// Interface Control Routes
  Route::get('/interfaceControl/logoIcon/index', 'Admin\InterfaceControl\LogoIconController@index')->name('admin.logoIcon.index');
	Route::post('/interfaceControl/logoIcon/update', 'Admin\InterfaceControl\LogoIconController@update')->name('admin.logoIcon.update');
	Route::get('/interfaceControl/slider/index', 'Admin\InterfaceControl\SliderController@index')->name('admin.slider.index');
	Route::post('/interfaceControl/slider/store', 'Admin\InterfaceControl\SliderController@store')->name('admin.slider.store');
	Route::post('/interfaceControl/slider/delete', 'Admin\InterfaceControl\SliderController@delete')->name('admin.slider.delete');
	Route::get('/interfaceControl/partner/index', 'Admin\InterfaceControl\PartnerController@index')->name('admin.partner.index');
	Route::post('/interfaceControl/partner/store', 'Admin\InterfaceControl\PartnerController@store')->name('admin.partner.store');
	Route::post('/interfaceControl/partner/delete', 'Admin\InterfaceControl\PartnerController@delete')->name('admin.partner.delete');
	Route::post('/interfaceControl/partner/update', 'Admin\InterfaceControl\PartnerController@update')->name('admin.partner.update');
	Route::get('/interfaceControl/contact/index', 'Admin\InterfaceControl\ContactController@index')->name('admin.contact.index');
	Route::post('/interfaceControl/contact/update', 'Admin\InterfaceControl\ContactController@update')->name('admin.contact.update');
	Route::get('/interfaceControl/support/index', 'Admin\InterfaceControl\SupportController@index')->name('admin.support.index');
	Route::post('/interfaceControl/support/update', 'Admin\InterfaceControl\SupportController@update')->name('admin.support.update');
	Route::get('/interfaceControl/footer/index', 'Admin\InterfaceControl\FooterController@index')->name('admin.footer.index');
	Route::post('/interfaceControl/footer/update', 'Admin\InterfaceControl\FooterController@update')->name('admin.footer.update');


	Route::get('/interfaceControl/logintext/index', 'Admin\InterfaceControl\LogintextController@index')->name('admin.logintext.index');
	Route::post('/interfaceControl/logintext/update', 'Admin\InterfaceControl\LogintextController@update')->name('admin.logintext.update');
	Route::get('/interfaceControl/registertext/index', 'Admin\InterfaceControl\RegistertextController@index')->name('admin.registertext.index');
	Route::post('/interfaceControl/registertext/update', 'Admin\InterfaceControl\RegistertextController@update')->name('admin.registertext.update');



	Route::get('/interfaceControl/social/index', 'Admin\InterfaceControl\SocialController@index')->name('admin.social.index');
	Route::post('/interfaceControl/social/store', 'Admin\InterfaceControl\SocialController@store')->name('admin.social.store');
  Route::post('/interfaceControl/social/delete', 'Admin\InterfaceControl\SocialController@delete')->name('admin.social.delete');


	// Transactions Route...
	Route::get('/trxlog/{vendorid?}', 'Admin\TrxController@index')->name('admin.trxLog');

	// Ad Routes...
  Route::get('/Ad/index', 'Admin\AdController@index')->name('admin.ad.index');
	Route::get('/Ad/create', 'Admin\AdController@create')->name('admin.ad.create');
	Route::post('/Ad/store', 'Admin\AdController@store')->name('admin.ad.store');
	Route::get('/Ad/showImage', 'Admin\AdController@showImage')->name('admin.ad.showImage');
	Route::post('/Ad/delete', 'Admin\AdController@delete')->name('admin.ad.delete');
});
