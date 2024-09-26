<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], [], []],
    '_wdt' => [['token'], ['_controller' => 'web_profiler.controller.profiler::toolbarAction'], [], [['variable', '/', '[^/]++', 'token', true], ['text', '/_wdt']], [], [], []],
    '_profiler_home' => [[], ['_controller' => 'web_profiler.controller.profiler::homeAction'], [], [['text', '/_profiler/']], [], [], []],
    '_profiler_search' => [[], ['_controller' => 'web_profiler.controller.profiler::searchAction'], [], [['text', '/_profiler/search']], [], [], []],
    '_profiler_search_bar' => [[], ['_controller' => 'web_profiler.controller.profiler::searchBarAction'], [], [['text', '/_profiler/search_bar']], [], [], []],
    '_profiler_phpinfo' => [[], ['_controller' => 'web_profiler.controller.profiler::phpinfoAction'], [], [['text', '/_profiler/phpinfo']], [], [], []],
    '_profiler_xdebug' => [[], ['_controller' => 'web_profiler.controller.profiler::xdebugAction'], [], [['text', '/_profiler/xdebug']], [], [], []],
    '_profiler_font' => [['fontName'], ['_controller' => 'web_profiler.controller.profiler::fontAction'], [], [['text', '.woff2'], ['variable', '/', '[^/\\.]++', 'fontName', true], ['text', '/_profiler/font']], [], [], []],
    '_profiler_search_results' => [['token'], ['_controller' => 'web_profiler.controller.profiler::searchResultsAction'], [], [['text', '/search/results'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_open_file' => [[], ['_controller' => 'web_profiler.controller.profiler::openAction'], [], [['text', '/_profiler/open']], [], [], []],
    '_profiler' => [['token'], ['_controller' => 'web_profiler.controller.profiler::panelAction'], [], [['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_router' => [['token'], ['_controller' => 'web_profiler.controller.router::panelAction'], [], [['text', '/router'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_exception' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::body'], [], [['text', '/exception'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_exception_css' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::stylesheet'], [], [['text', '/exception.css'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    'admin' => [[], ['_controller' => 'App\\Controller\\Admin\\DashboardController::index'], [], [['text', '/admin']], [], [], []],
    'import_json' => [[], ['_controller' => 'App\\Controller\\ApiController::importJsonToDatabase'], [], [['text', '/import-json']], [], [], []],
    'app_home' => [[], ['_controller' => 'App\\Controller\\BookController::index'], [], [['text', '/']], [], [], []],
    'book_show' => [['id'], ['_controller' => 'App\\Controller\\BookController::show'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/book']], [], [], []],
    'book_like' => [['id'], ['_controller' => 'App\\Controller\\BookController::like'], [], [['text', '/like'], ['variable', '/', '[^/]++', 'id', true], ['text', '/book']], [], [], []],
    'book_search' => [[], ['_controller' => 'App\\Controller\\BookController::search'], [], [['text', '/search']], [], [], []],
    'category_show' => [['id'], ['_controller' => 'App\\Controller\\CategoryController::show'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/category']], [], [], []],
    'admin_loan_new' => [[], ['_controller' => 'App\\Controller\\LoanController::newLoan'], [], [['text', '/admin/loan/new']], [], [], []],
    'admin_loan_list' => [[], ['_controller' => 'App\\Controller\\LoanController::listLoans'], [], [['text', '/admin/loan/list']], [], [], []],
    'admin_loan_return' => [['id'], ['_controller' => 'App\\Controller\\LoanController::returnLoan'], [], [['text', '/return'], ['variable', '/', '[^/]++', 'id', true], ['text', '/admin/loan']], [], [], []],
    'app_login' => [[], ['_controller' => 'App\\Controller\\LoginController::login'], [], [['text', '/login']], [], [], []],
    'app_logout' => [[], ['_controller' => 'App\\Controller\\LoginController::logout'], [], [['text', '/logout']], [], [], []],
    'app_registration' => [[], ['_controller' => 'App\\Controller\\RegistrationController::registration'], [], [['text', '/registration']], [], [], []],
    'api_download_json' => [[], ['_controller' => 'App\\Controller\\ApiController::downloadJson'], [], [['text', '/download-json']], [], [], []],
    'App\Controller\Admin\DashboardController::index' => [[], ['_controller' => 'App\\Controller\\Admin\\DashboardController::index'], [], [['text', '/admin']], [], [], []],
    'App\Controller\ApiController::importJsonToDatabase' => [[], ['_controller' => 'App\\Controller\\ApiController::importJsonToDatabase'], [], [['text', '/import-json']], [], [], []],
    'App\Controller\BookController::index' => [[], ['_controller' => 'App\\Controller\\BookController::index'], [], [['text', '/']], [], [], []],
    'App\Controller\BookController::show' => [['id'], ['_controller' => 'App\\Controller\\BookController::show'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/book']], [], [], []],
    'App\Controller\BookController::like' => [['id'], ['_controller' => 'App\\Controller\\BookController::like'], [], [['text', '/like'], ['variable', '/', '[^/]++', 'id', true], ['text', '/book']], [], [], []],
    'App\Controller\BookController::search' => [[], ['_controller' => 'App\\Controller\\BookController::search'], [], [['text', '/search']], [], [], []],
    'App\Controller\CategoryController::show' => [['id'], ['_controller' => 'App\\Controller\\CategoryController::show'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/category']], [], [], []],
    'App\Controller\LoanController::newLoan' => [[], ['_controller' => 'App\\Controller\\LoanController::newLoan'], [], [['text', '/admin/loan/new']], [], [], []],
    'App\Controller\LoanController::listLoans' => [[], ['_controller' => 'App\\Controller\\LoanController::listLoans'], [], [['text', '/admin/loan/list']], [], [], []],
    'App\Controller\LoanController::returnLoan' => [['id'], ['_controller' => 'App\\Controller\\LoanController::returnLoan'], [], [['text', '/return'], ['variable', '/', '[^/]++', 'id', true], ['text', '/admin/loan']], [], [], []],
    'App\Controller\LoginController::login' => [[], ['_controller' => 'App\\Controller\\LoginController::login'], [], [['text', '/login']], [], [], []],
    'App\Controller\LoginController::logout' => [[], ['_controller' => 'App\\Controller\\LoginController::logout'], [], [['text', '/logout']], [], [], []],
    'App\Controller\RegistrationController::registration' => [[], ['_controller' => 'App\\Controller\\RegistrationController::registration'], [], [['text', '/registration']], [], [], []],
];
