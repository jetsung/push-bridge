<?php

/**
 * 返回资源数据
 * @param int $code 错误码
 * @param array $data_arr 数据
 * @param int $level 数据是否和错误码同级
 * @param string $msg 提示信息
 * @return array
 */
function get_response(int $code = 0, array $data_arr = [], int $level = 0, string $msg = ''): array
{

    $data = [
        'code' => $code < 0 ? 0 : $code,
        'message' => $msg === '' ? get_err_msg($code) : $msg,
        'success' => $code <= 0,
    ];

    ($code === 0) && $data['data'] = [];

    if (!empty($data_arr)) {
        if ($level == 1) {
            $data = array_merge($data, $data_arr);
        } else {
            $data['data'] = $data_arr;
        }
    }

    return $data;
}

/**
 * 错误内容
 * @param int $flag 标识 (标识码为数字时,为错误码)
 * @param array $param_arr 格式化时作为 sprintf 的参数
 * @return mixed|string
 */
function get_err_msg(int $flag = 0, array $param_arr = []): string
{
    $flag < 0 && $flag = 0 - $flag;
    $msg = trans('errcodes.' . $flag) ?? 'unknown error.';
    if (!empty($param_arr)) {
        $args[] = $msg;
        if (!is_array($param_arr)) {
            $param_arr = [$param_arr];
        }

        $args = array_merge($args, $param_arr);
        $msg = call_user_func_array("sprintf", $args);
    }

    return $msg;
}
