<?php

namespace App\Http\Api\Admin;

use App\Enums\DefaultDefine;
use App\Helpers\SystemHelper;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomApi extends Controller
{

    public function __construct()
    {
        //レートリミット制限設定
        $this->middleware('throttle_api:20,1');
    }

//    /**
//     * district_idによって、room番号を取得する
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse|object|void
//     */
//    public function getRoom(Request $request)
//    {
//        if (isset($request->target) && $request->target) {
//            //AuthorizationのBear
//            $iv = $request->bearerToken();
//            //復号
//            $decode = json_decode($request->target, true);
//            $target = SystemHelper::decrypt($decode['qer'], $decode['rty'], $decode['adf'], $iv);
//            //通信リクエストがあるの場合：
//            if ($target) {
//                $model = Room::getRoomNumber($target);
//                //データが空白の場合：
//                empty($model) ? $response = SystemHelper::response(DefaultDefine::STATUS_NO_CONTENT, __('messages.errors_empty'))
//                              : $response = SystemHelper::response(DefaultDefine::STATUS_SUCCESS, __('messages.success_region'), $model);
//            } else {
//                $response = SystemHelper::response(DefaultDefine::STATUS_SERVER_ERROR, __('messages.errors_system'));
//            }
//            //クライアントにエラーメッセージを返す
//            return response()->json($response);
//        }
//    }
}
