<?php

namespace Indeximstudio\Telegram;

class Telegram
{
    public const TYPE_RECIPIENT = 'recipient';
    public const TYPE_RECIPIENT_ADMIN = 'recipient_admin';

    public $config;
    private $bots;

    function __construct($botName = '')
    {
        $this->bots = json_decode(evolutionCMS()->getConfig('client_telegramBots'), true);
        $this->getBot($botName);
    }

    /**
     * @param $message
     * @param string $type
     */
    public function sendMessages($message, $type = self::TYPE_RECIPIENT)
    {
        $userList = explode(',', $this->config[$type]);

        foreach ($userList as $index => $value) {
            $this->sendMessage($message, trim($value));
        }
    }

    /**
     * @param $message
     * @param $chat_id
     */
    private function sendMessage($message, $chat_id)
    {
        $message = urlencode($message);
        $url = "https://api.telegram.org/bot{$this->config['token']}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$message}";
        $ch = curl_init();
        curl_setopt_array($ch, array(CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true));
        curl_exec($ch);
        curl_close($ch);
    }

    private function getBot($name)
    {
        foreach ($this->bots as $index => $value) {
            if ($name == $value['bots']) {
                return $this->config = $value;
            }
        }
        return $this->config = $this->bots[0];
    }
}