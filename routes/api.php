<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API
|--------------------------------------------------------------------------
|
| Текущий мастер приходит в заголовке X-Master-Id и уже разложен
| в атрибуты запроса middleware'ом ResolveCurrentMaster:
|
|     $master = $request->attributes->get('current_master');
|
| Здесь нужно написать три роута — см. README.md.
|
*/

Route::get('/ping', fn () => ['ok' => true]);
Route::post('/referrals/attach', function (Request $request) {
    $master = $request->attributes->get('current_master');
    $code = $request->input('code');


    // Логика привязки реферала (вызываем сервис)
    $result = app(ReferralService::class)->attachReferral($master->id, $code);


    return response()->json($result);
});
Route::get('/referrals/my', function (Request $request) {
    $master = $request->attributes->get('current_master');

    // Получаем список рефералов мастера
    $referrals = app(ReferralService::class)->getMyReferrals($master->id);

    return response()->json($referrals);
});
Route::get('/referrals/earnings', function (Request $request) {
    $master = $request->attributes->get('current_master');

    // Получаем сводку по вознаграждениям
    $earnings = app(ReferralService::class)->getEarningsSummary($master->id);

    return response()->json($earnings);
});


// TODO: POST /api/referrals/attach
// TODO: GET  /api/referrals/my
// TODO: GET  /api/referrals/earnings
