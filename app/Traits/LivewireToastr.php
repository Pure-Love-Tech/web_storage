<?php

namespace App\Traits;

trait LivewireToastr
{
    /**
     * Shows an alert message.
     *
     * @param string $type The type of the alert message (e.g., success, error).
     * @param string $message The message to display in the alert.
     * @param array $options Additional options to customize the alert (e.g., timeout).
     *
     * @return void
     */
    public function toastr(string $type = 'success', string $message = '', array $options = [])
    {
        // Dispatch a browser event to show the alert
        return $this->dispatchBrowserEvent('alert', [
            'type' => $type,
            'message' => $message,
            'options' => $options,
        ]);
    }

}
