<?php

namespace App\Http\ResponseTraits;

trait ResponseTrait
{
    public function errors(string $message = "Validation errors", int $status = 422, mixed $errors = null)
    {
        $response = [
            'message' => $message,
        ];
        if ($errors) {
            $response["errors"] = $errors;
        }
        return response()->json($response, $status);
    }
}
