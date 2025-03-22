<?php

namespace App\Services\Auth;

use App\Exceptions\TurboSmsException;
use App\Models\Client;
use App\Services\Cart\CartSession;
use Daaner\TurboSMS\Facades\TurboSMS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthService
{
    public function sendCode(string $phone): void
    {
        $client = Client::firstOrCreate(['phone' => $phone]);

        $testMode = config('turbosms.test_mode');

        if ($testMode) {
            $client->update(['code' => '000000']);
        } else {
            $code = $this->generateCode();
        
            $client->update(['code' => $code]);
    
            $result = TurboSMS::sendMessages('+38' . $phone, $code);
        
            if (
                ! $result['success'] or 
                $result['result'][0]['response_status'] != 'OK'
            ) {
                throw new TurboSmsException(
                    $result['info'], 
                    $result['result'][0]['response_code']
                );
            }
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

        (new CartSession)->saveToDB($client);

        return true;
    }

    public function logout(): void
    {
        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();
    }
}