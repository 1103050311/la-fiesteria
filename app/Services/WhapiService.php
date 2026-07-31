<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhapiService
{
    protected string $token;
    protected string $baseUrl;

    public function __construct()
    {
        $this->token = config('services.whapi.token');
        $this->baseUrl = config('services.whapi.base_url');
    }

    /**
     * Envía un mensaje de texto por WhatsApp
     *
     * @param string $to Número en formato internacional sin '+' (ej: 5211234567890) o Chat ID
     * @param string $body Texto del mensaje
     * @param array $options Opciones extra (quoted, typing_time, no_link_preview, mentions, etc.)
     */
    public function sendText(string $to, string $body, array $options = []): array
    {
        $payload = array_merge([
            'to' => $to,
            'body' => $body,
        ], $options);

        $response = Http::withToken($this->token)
            ->acceptJson()
            ->post("{$this->baseUrl}/messages/text", $payload);

        if ($response->failed()) {
            Log::error('Error enviando mensaje WhatsApp', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);
        }

        return $response->json();
    }
}