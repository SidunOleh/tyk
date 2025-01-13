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
        $client = Client::where(['phone' => $phone])->firstOrFail();

        $code = $this->generateCode();

        $client->update(['code' => $code]);

        $result = TurboSMS::sendMessages($phone, $code);

        if (! $result['success']) {
            throw new Exception($result['info']);
        }
    }

    private function generateCode(): int
    {
        do {
            $code = rand(1000000, 9999999);
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