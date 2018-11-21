<?php
  /**
   * Index
   *
   * @package Wojo Framework
   * @author wojoscripts.com
   * @copyright 2016
   * @version $Id: index.php, v1.00 2016-06-05 10:12:05 gewa Exp $
   */
  define("_WOJO", true);

  include ('init.php');
  $router = new Router();
  $tpl = App::View(BASEPATH . 'view/');
  
  //admin routes
  $router->mount('/admin', function() use ($router, $tpl) {
      //admin login
	  $router->match('GET|POST', '/login', function () use ($tpl)
	  {
		  if (App::Auth()->is_Admin()) {
			  Url::redirect(SITEURL . '/admin/'); 
			  exit; 
		  }
		  
		  $tpl->template = 'admin/login.tpl.php'; 
		  $tpl->title = Lang::$word->LOGIN; 
	  });
	  
	  //admin index
	  $router->get('/', 'AdminController@Index');
	  
	  //admin users
	  $router->mount('/users', function() use ($router, $tpl) {
		  $router->match('GET|POST', '/', 'Users@Index');
		  $router->get('/grid', 'Users@Index');
		  $router->get('/history/(\d+)', 'Users@History');
		  $router->get('/edit/(\d+)', 'Users@Edit');
		  $router->get('/new', 'Users@Save');
	  });
	  
	  //admin memberships
	  $router->mount('/memberships', function() use ($router, $tpl) {
		  $router->match('GET', '/', 'Membership@Index');
		  $router->get('/history/(\d+)', 'Membership@History');
		  $router->get('/edit/(\d+)', 'Membership@Edit');
		  $router->get('/new', 'Membership@Save');
	  });

	  //admin email templates
	  $router->mount('/templates', function() use ($router, $tpl) {
		  $router->get('/', 'Content@Templates');
		  $router->get('/edit/(\d+)', 'Content@TemplateEdit');
	  });

	  //admin countries
	  $router->mount('/countries', function() use ($router, $tpl) {
		  $router->get('/', 'Content@Countries');
		  $router->get('/edit/(\d+)', 'Content@CountryEdit');
	  });

	  //admin coupons
	  $router->mount('/coupons', function() use ($router, $tpl) {
		  $router->get('/', 'Content@Coupons');
		  $router->get('/edit/(\d+)', 'Content@CouponEdit');
		  $router->get('/new', 'Content@CouponSave');
	  });

	  //admin custom fields
	  $router->mount('/fields', function() use ($router, $tpl) {
		  $router->get('/', 'Content@Fields');
		  $router->get('/edit/(\d+)', 'Content@FieldEdit');
		  $router->get('/new', 'Content@FieldSave');
	  });

	  //admin news
	  $router->mount('/news', function() use ($router, $tpl) {
		  $router->get('/', 'Content@News');
		  $router->get('/edit/(\d+)', 'Content@NewsEdit');
		  $router->get('/new', 'Content@NewsSave');
	  });

	  //admin account
	  $router->mount('/myaccount', function() use ($router, $tpl) {
		  $router->get('/', 'AdminController@Account');
		  $router->get('/password', 'AdminController@Password');
	  });

	  //admin gateways
	  $router->mount('/gateways', function() use ($router, $tpl) {
		  $router->get('/', 'AdminController@Gateways');
		  $router->get('/edit/(\d+)', 'AdminController@GatewayEdit');
	  });

	  //admin permissions
	  $router->mount('/permissions', function() use ($router, $tpl) {
		  $router->get('/', 'AdminController@Permissions');
		  $router->get('/privileges/(\d+)', 'AdminController@Privileges');
	  });
	  
	  //admin maintenance manager
	  $router->get('/maintenance', 'AdminController@Maintenance');
	  
	  //admin backup
	  $router->get('/backup', 'AdminController@Backup');

	  //admin files
	  $router->get('/files', 'AdminController@Files');
	  
	  //admin newsletter
	  $router->get('/mailer', 'AdminController@Mailer');

	  //admin system
	  $router->get('/system', 'AdminController@System');

	  //admin transactions
	  $router->match('GET|POST', '/transactions', 'AdminController@Transactions');

	  //admin configuration
	  $router->get('/configuration', 'AdminController@Configuration');
	  
	  //admin help
	  $router->get('/help', 'AdminController@Help');

	  //admin trash
	  $router->get('/trash', 'AdminController@Trash');
	  
	  //admin language manager
	  $router->get('/language', 'Lang@Index');
	  
	  //logout
	  $router->get('/logout', function()
	  {
		  App::Auth()->logout();
		  Url::redirect(SITEURL . '/admin/');
	  });
  });
  
  //front end routes
  $router->match('GET|POST', '/', 'FrontController@Index');
  $router->match('GET|POST', '/register', 'FrontController@Register');
  $router->get('/contact', 'FrontController@Contact');
  $router->get('/activation', 'FrontController@Activation');
  $router->get('/packages', 'FrontController@Packages');
  $router->get('/validate', 'FrontController@Validate');
  $router->get('/privacy', 'FrontController@Privacy');

  $router->mount('/dashboard', function() use ($router, $tpl) {
	  $router->match('GET|POST', '/', 'FrontController@Dashboard');
	  $router->get('/history', 'FrontController@History');
	  $router->get('/profile', 'FrontController@Profile');
	  $router->get('/downloads', 'FrontController@Downloads');
  });
	  

  //Custom Routes add here
  $router->get('/logout', function()
  {
	  App::Auth()->logout();
	  Url::redirect(SITEURL . '/');
  });

  //404
  $router->set404(function () use($router)
  {
      $tpl = App::View(BASEPATH . 'view/'); 
	  $tpl->dir = $router->segments[0] == "admin" ? 'admin/' : 'front/';
	  $tpl->segments = $router->segments;
	  $tpl->template = $router->segments[0] == "admin" ? 'admin/404.tpl.php' : 'front/404.tpl.php'; 
	  $tpl->title = Lang::$word->META_ERROR; 
	  echo $tpl->render(); 
  });

  // Run router
  $router->run(function () use($tpl, $router)
  {
	  $tpl->segments = $router->segments;
      echo $tpl->render(); 
  });
 