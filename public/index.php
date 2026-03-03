<?php

declare(strict_types=1);

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

use Carbon\Carbon;

require '../vendor/autoload.php';

session_start();

/*
|--------------------------------------------------------------------------
| Timezone da aplicação
|--------------------------------------------------------------------------
*/

date_default_timezone_set(config('date.tz'));

/*
|--------------------------------------------------------------------------
| Configuração global do Carbon
|--------------------------------------------------------------------------
*/

Carbon::setLocale('pt_BR');



require base_path('/config/routes.php');
