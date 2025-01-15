<?php

namespace App\Services\Auth;

use App\Models\Client;
use App\Services\Cart\CartSession;
use Daaner\TurboSMS\Facades\TurboSMS;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthService
{
    public function sendCode(string $phone): void
    {
        $client = Client::firstOrCreate(['phone' => $phone]);

        $code = $this->generateCode();

        $client->update(['code' => $code]);

        $result = TurboSMS::sendMessages($phone, $code);

        if (
            ! $result['success'] or 
            $result['result'][0]['response_status'] != 'OK'
        ) {
            throw new Exception(
                $result['info'],
                $result['result'][0]['response_code']
            );
        }
    }

    private function generateCode(): int
    {
        do {
            $code = rand(100000, 999999);
        } while (Client::firstWhere('code', $code));
        
        return $code;
    }

    public function login(string $code): bool
    {
        $client = Client::firstWhere(['code' => $code]);

        if (! $client) {
            return false;
        }

        Auth::guard('web')->login($client);

        $client->update(['code' => null]);

        (new CartSession)->saveToDB();

        return true;
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}