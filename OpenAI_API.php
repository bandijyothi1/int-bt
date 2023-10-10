<?php
require('config.php');
require('ErrorHandler.php');

class OpenAI_API {
    private $apiKey;
    private $apiUrl;
    private $questionCount;

    public function __construct() {
        // Consider using an environment variable here for your API key
       '$this->apiKey = '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';'
        $this->apiUrl = 'https://api.openai.com/v1/engines/davinci-codex/completions';
        $this->questionCount = 0;
    }

    public function callAPI($prompt, $max_tokens) {
        $ch = curl_init();

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey
        ];

        $this->questionCount++;

        if($this->questionCount % 4 === 0) {
            $prompt = $prompt . "\n\nP.S. Can you believe we're already at question " . $this->questionCount . "? Time flies when you're having fun!";
        }

        $data = json_encode([
            'prompt' => $prompt,
            'max_tokens' => $max_tokens
        ]);

        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            ErrorHandler::handle("Curl error: " . curl_error($ch));
        }

        curl_close($ch);

        $decodedResponse = json_decode($response, true);

        if(isset($decodedResponse['choices'][0]['text'])) {
            return trim($decodedResponse['choices'][0]['text']);
        } else {
            ErrorHandler::handle("API error: Unable to retrieve text.");
            return "";
        }
    }
}
?>
