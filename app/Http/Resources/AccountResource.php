<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    private int $statusCode = 200;
    private bool $isSuccess = false;
    private string $message = 'Account retrieved successfully';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => $this->isSuccess,
            'message' => $this->message,
            'data' => parent::toArray($request),
        ];
    }

    /**
     * Set the success status of the resource.
     *
     * @param  bool  $success
     * @return $this
     */
    public function setSuccess(bool $success): self
    {
        $this->isSuccess = $success;

        return $this;
    }

    /**
     * Set the message for the resource.
     *
     * @param  string  $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the status code for the response.
     *
     * @param  int  $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Send the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($request = null)
    {
        return parent::response($request)->setStatusCode($this->statusCode);
    }
}
