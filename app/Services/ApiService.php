<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
     private string $baseUrl;
     private string $username;
     private string $password;

     public function __construct()
     {
         $this->baseUrl = config('services.external_api.base_url');
         $this->username = config('services.external_api.username');
         $this->password = config('services.external_api.password');
     }

     private function client()
     {
           return Http::withBasicAuth($this->username, $this->password)
               ->acceptJson()
               ->baseUrl($this->baseUrl);
     }

     // get Stock On hand 
     public function getStockOnhand(string $date, string $locationId, string $itemId): array
     {
          $url = rtrim($this->baseUrl, '/') . '/item/getStockOnHand';
          $response = $this->client()->get($url, [
               'date'       => $date,
               'locationId' => $locationId,
               'itemId'     => $itemId,
          ]);

          \Log::info('API getStockOnHand', [
               'url_called' => $url,
               'status'     => $response->status(),
               'body'       => $response->body(),
          ]);

          if ($response->successful()) {
               return [
                    'success' => true,
                    'data'    => $response->json(),
               ];
          }

          return [
               'success' => false,
               'message' => $response->json('message', 'Gagal mengambil data stock.'),
               'status'  => $response->status(),
               'data'    => [],
          ];

     }
}

?>