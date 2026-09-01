<?php

namespace App\Traits;

trait ApiResponse
{
    /**
     * Response sukses dengan format konsisten.
     */
    protected function success(string $message, mixed $data = null, int $code = 200): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'code'    => $code,
        ];
    }

    /**
     * Response error dengan format konsisten.
     */
    protected function error(string $message, mixed $errors = null, int $code = 422): array
    {
        return [
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
            'code'    => $code,
        ];
    }

    /**
     * Flash message ke session untuk redirect response.
     */
    protected function flashSuccess(string $message): void
    {
        session()->flash('success', $message);
    }

    protected function flashError(string $message): void
    {
        session()->flash('error', $message);
    }

    /**
     * Redirect back dengan error message.
     */
    protected function redirectBackWithError(string $message, ?string $inputKey = null): \Illuminate\Http\RedirectResponse
    {
        $redirect = back()->with('error', $message);

        if ($inputKey) {
            $redirect = $redirect->withInput($this->except($inputKey));
        }

        return $redirect;
    }
}

