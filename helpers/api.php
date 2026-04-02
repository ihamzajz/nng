<?php

declare(strict_types=1);

if (!function_exists('api_base_url')) {
    function api_base_url(): string
    {
        return (string) config('api', 'https://api.jamtechsolutionz.com');
    }
}

if (!function_exists('api')) {
    function api(string $endpoint = ''): string
    {
        return api_url($endpoint);
    }
}

if (!function_exists('api_url')) {
    function api_url(string $endpoint = ''): string
    {
        $baseUrl = rtrim(api_base_url(), '/');
        $endpoint = ltrim($endpoint, '/');

        return $endpoint === '' ? $baseUrl : $baseUrl . '/' . $endpoint;
    }
}

if (!function_exists('api_request')) {
    function api_request(
        string $method,
        string $endpoint,
        array $payload = [],
        array $headers = [],
        ?string $token = null
    ): array {
        $url = api($endpoint);
        $method = strtoupper($method);
        $curl = curl_init();

        $requestHeaders = [
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        if ($token !== null && $token !== '') {
            $requestHeaders[] = 'Authorization: Bearer ' . $token;
        }

        foreach ($headers as $header) {
            $requestHeaders[] = $header;
        }

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $requestHeaders,
            CURLOPT_TIMEOUT => (int) config('api_timeout', 30),
        ];

        if (in_array($method, ['GET', 'DELETE'], true) && !empty($payload)) {
            $queryString = http_build_query($payload);
            $options[CURLOPT_URL] = $url . '?' . $queryString;
        } elseif (!empty($payload)) {
            $options[CURLOPT_POSTFIELDS] = json_encode($payload, JSON_THROW_ON_ERROR);
        }

        curl_setopt_array($curl, $options);

        $responseBody = curl_exec($curl);
        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        curl_close($curl);

        $decodedBody = null;

        if (is_string($responseBody) && $responseBody !== '') {
            $decodedBody = json_decode($responseBody, true);
        }

        return [
            'success' => $curlError === '' && $statusCode >= 200 && $statusCode < 300,
            'status' => $statusCode,
            'data' => $decodedBody,
            'raw' => is_string($responseBody) ? $responseBody : null,
            'error' => $curlError !== '' ? $curlError : null,
        ];
    }
}
