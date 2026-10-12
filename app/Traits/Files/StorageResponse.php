<?php

namespace App\Traits\Files;

trait StorageResponse
{
    /**
     * Generates a JSON response indicating that the operation was successful.
     *
     * @param mixed $data Additional data to include in the response.
     * @return object A JSON object representing the response.
     */
    public function success(array $data)
    {
        // Combine the given data with a "type" key indicating success.
        $response = [
            'type' => 'success',
        ] + $data;

        // Convert the response to a JSON object and return it.
        return json_decode(json_encode($response));
    }

    /**
     * Generates a JSON response indicating that an error occurred during the operation.
     *
     * @param string $message A message describing the error that occurred.
     * @return object A JSON object representing the response.
     */
    public function error(string $message)
    {
        // Construct a response object with a "type" key indicating error
        // and a "message" key containing the error message.
        $response = [
            'type' => 'error',
            'message' => $message,
        ];

        // Convert the response to a JSON object and return it.
        return json_decode(json_encode($response));
    }
}
