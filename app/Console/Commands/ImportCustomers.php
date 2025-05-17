<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customers:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = fopen(storage_path('wp_tx_customers.csv'), 'r');
        if (! $file) {
            $this->error('Can\'t open file.');
            return;
        }

        $i = 0;
        while (($line = fgetcsv($file, null, ',')) !== false) {
            if ($i++ == 0) {
                continue;
            }

            $customer = $this->upsert($line);

            if ($customer) {
                $this->info('upsert ' . $customer->full_name);
            }
        }
    }

    private function upsert(array $data): ?Client
    {
        if (! $phone = $this->formatPhone($data[2])) {
            return null;
        }
        
        $client = Client::withTrashed()->firstWhere('phone', $phone);

        $clientData = [
            'full_name' => $data[1],
            'phone' => $phone,
        ];

        if ($client) {
            $client->update($clientData);
        } else {
            $client = Client::create($clientData);
        }

        return $client;
    }

    private function formatPhone(string $phone): ?string
    {
        if (strlen($phone) != 10) {
            return null;
        }

        return "({$phone[0]}{$phone[1]}{$phone[2]}) {$phone[3]}{$phone[4]}{$phone[5]}-{$phone[6]}{$phone[7]}-{$phone[8]}{$phone[9]}";
    }
}
