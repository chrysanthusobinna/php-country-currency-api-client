<?php

namespace GetCountryCurrency;

use Exception;

class CountryCurrencyAPI
{
    private string $apiUrl;

    public function __construct(string $apiUrl = "https://www.getcountrycurrency.com/api/country-currency")
    {
        $this->apiUrl = rtrim($apiUrl, '/') . '/';
    }

    public function fetchCurrencyData(string $country): array
    {
        $constructedUrl = $this->apiUrl . urlencode($country);
        error_log("Constructed URL: " . $constructedUrl); // Logs to the server log for debugging
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $constructedUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('cURL Error: ' . curl_error($ch));
        }
        curl_close($ch);
    
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('JSON Decode Error: ' . json_last_error_msg());
        }
    
        return $data ?? ['error' => 'Invalid response from API'];
    }
}
