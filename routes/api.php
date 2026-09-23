<?php

use Illuminate\Support\Facades\Route;

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

// TODO: POST /api/referrals/attach
// TODO: GET  /api/referrals/my
// TODO: GET  /api/referrals/earnings
