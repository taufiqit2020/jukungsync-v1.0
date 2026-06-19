<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    /**
     * Send a WhatsApp message using Fonnte API.
     *
     * @param string $target Phone number(s), comma separated
     * @param string $message The message body
     * @return bool
     */
    public static function sendMessage($target, $message)
    {
        $token = env('FONNTE_TOKEN');
        
        if (empty($token)) {
            Log::warning('Fonnte Token is not set. WhatsApp message not sent.', [
                'target' => $target,
                'message' => $message
            ]);
            return false;
        }

        // Fonnte accepts numbers starting with 0 or 62
        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully via Fonnte.', ['target' => $target]);
                return true;
            }

            Log::error('Failed to send WhatsApp message via Fonnte.', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Exception while sending WhatsApp message via Fonnte: ' . $e->getMessage());
            return false;
        }
    }
}
