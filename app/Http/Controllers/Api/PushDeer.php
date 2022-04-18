<?php declare(strict_types=1);

/*
 * This file is part of Push-Bridge.
 *
 * (c) Jetsung Chan <jetsungchan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Pusher\Channel\PushDeer as ChannelPushDeer;
use Pusher\Message\PushDeerMessage;

class PushDeer extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'string|required',
                'desp' => 'string|required',
            ]
        );

        $errors = $validator->errors();
        if ($errors->has('title')) {
            return $this->response(2, [], 0, $errors->first('title'));
        }
        if ($errors->has('desp')) {
            return $this->response(2, [], 0, $errors->first('desp'));
        }

        $title = $request->input('title');
        $desp = $request->input('desp');

        $title = "**${title}**";
        $push_time = date('Y-m-d H:i:s');
        $desp = "**时间：${push_time}**   

${desp}";

        $resp = [];
        if ($this->pushData($title, $desp)) {
            $resp['time'] = $push_time;

            return $this->response(-11010, $resp);
        }

        return $this->response(11011, $resp);
    }

    /**
     * 推送消息
     *
     * @param string $title 标题
     * @param string $desp 详情
     * @return bool
     */
    private function pushData(string $title, string $desp): bool
    {
        try {
            $token = env('PUSHER_PUSHDEER_TOKEN', '');

            $message = new PushDeerMessage($title, $desp, 'markdown');
            $channel = new ChannelPushDeer();
            $channel->setToken($token)->request($message);
            $completed = $channel->getStatus();
        } catch (\Exception $e) {
            $completed = false;

            Log::warning($e->getMessage());
        }

        return $completed;
    }
}
