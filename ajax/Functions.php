<?php
/**
 * @param string $url
 * @param array  $params
 * @return array
 */
function sendCurlRequest(string $url, array $params = []): array
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    if (curl_error($ch)) {
        throw new RuntimeException(curl_error($ch), curl_errno($ch));
    }
    curl_close($ch);
    return json_decode($result, true);
}


/**
 * @param string $method
 * @param array  $params
 * @return array
 */
function sendBox(string $method, array $params = []): array
{
    return sendCurlRequest('https://api.telegram.org/bot' . TELEGRAM_BOT_TOKEN . '/' . strtolower($method), $params);
}

