<?php
/*
 *  +----------------------------------------------------------------------
 *  | XinAdmin [ A Full stack framework ]
 *  +----------------------------------------------------------------------
 *  | Copyright (c) 2023~2024 http://xinadmin.cn All rights reserved.
 *  +----------------------------------------------------------------------
 *  | Apache License ( http://www.apache.org/licenses/LICENSE-2.0 )
 *  +----------------------------------------------------------------------
 *  | Author: 小刘同学 <2302563948@qq.com>
 *  +----------------------------------------------------------------------
 */

namespace app\common\trait;

use app\common\enum\ApiEnum\ShowType as ShopTypeEnum;
use app\common\enum\ApiEnum\StatusCode;
use think\exception\HttpResponseException;
use think\Response;
use think\response\Json;

/**
 * 控制器基础类.
 */
trait RequestJson
{
    /**
     *  抛出 API 数据.
     * @param mixed $data 返回数据
     */
    public static function renderThrow(bool $success = true, array $data = [], int $status = 200, string $msg = '', int $showType = 0)
    {
        $response = Response::create(compact('data', 'success', 'status', 'msg', 'showType'), 'json', $status);
        throw new HttpResponseException($response);
    }

    /**
     *  成功响应.
     * @param array|string $data 响应数据
     * @param string $message 响应内容
     */
    protected function success(array|string $data = [], string $message = 'ok'): Json
    {
        if (is_array($data)) {
            return self::renderJson(true, $data, StatusCode::OK->value, $message);
        }
        return self::renderJson(true, [], StatusCode::OK->value, $data);
    }

    /**
     * 抛出成功响应，中断程序运行.
     * @param array|string $data 响应数据
     * @param string $message 响应内容
     */
    protected function throwSuccess(array|string $data = [], string $message = 'ok'): void
    {
        if (is_array($data)) {
            self::renderThrow(true, $data, StatusCode::OK->value, $message);
        }
        self::renderThrow(true, [], StatusCode::OK->value, $data);
    }

    /**
     *  返回失败响应.
     * @param array|string $data 响应数据
     * @param string $message 响应内容
     */
    protected function error(array|string $data = [], string $message = ''): Json
    {
        if (is_array($data)) {
            return self::renderJson(false, $data, StatusCode::ERROR->value, $message, ShopTypeEnum::ERROR_MESSAGE->value);
        }
        return self::renderJson(false, [], StatusCode::ERROR->value, $data, ShopTypeEnum::ERROR_MESSAGE->value);
    }

    /**
     * 抛出失败响应，中断程序运行.
     */
    protected function throwError(array|string $data = [], string $message = ''): void
    {
        if (is_array($data)) {
            self::renderThrow(false, $data, StatusCode::ERROR->value, $message, ShopTypeEnum::ERROR_MESSAGE->value);
        }
        self::renderThrow(false, [], StatusCode::ERROR->value, $data, ShopTypeEnum::ERROR_MESSAGE->value);
    }

    /**
     *  返回警告响应.
     * @param array|string $data 响应数据
     * @param string $message 响应内容
     */
    protected function warn(array|string $data = [], string $message = ''): Json
    {
        if (is_array($data)) {
            return self::renderJson(false, $data, StatusCode::WARN->value, $message, ShopTypeEnum::WARN_MESSAGE->value);
        }
        return self::renderJson(false, [], StatusCode::WARN->value, $data, ShopTypeEnum::WARN_MESSAGE->value);
    }

    /**
     * 抛出警告响应，中断程序运行.
     */
    protected function throwWarn(array|string $data = [], string $message = ''): void
    {
        if (is_array($data)) {
            self::renderThrow(false, $data, StatusCode::WARN->value, $message, ShopTypeEnum::WARN_MESSAGE->value);
        }
        self::renderThrow(false, [], StatusCode::WARN->value, $data, ShopTypeEnum::WARN_MESSAGE->value);
    }

    /**
     *  返回 Json 响应.
     * @param bool $success 响应状态
     * @param array $data 响应数据
     * @param int $status 响应码
     * @param string $msg 响应内容
     * @param int $showType 响应类型
     */
    protected static function renderJson(bool $success = true, array $data = [], int $status = 200, string $msg = '', int $showType = 0): Json
    {
        return json(compact('data', 'success', 'status', 'msg', 'showType'), $status);
    }
}
