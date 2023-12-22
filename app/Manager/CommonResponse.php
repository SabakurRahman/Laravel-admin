<?php

namespace App\Manager;

use Illuminate\Http\JsonResponse;

class CommonResponse
{
    public const STATUS_CODE_SUCCESS = 200;
    public const STATUS_CODE_FAILED = 460; // common failed code
    public $data = null;
    public bool $status = true;
    public string $status_message = '';
    public int $status_code = self::STATUS_CODE_SUCCESS;
    public string $status_class = 'success';

    public JsonResponse $response;


    /**
     * @return JsonResponse
     */
    final public function commonApiResponse(): JsonResponse
    {
        return response()->json([
            'status'         => $this->status,
            'status_message' => $this->status_message,
            'data'           => $this->data,
            'status_code'    => $this->status_code,
            'status_class'   => $this->status ? 'success' : 'error',
        ], self::STATUS_CODE_SUCCESS);
    }
}
