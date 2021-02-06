<?php

namespace Indeximstudio\Telegram;

use Indeximstudio\Telegram\components\InlineKeyboardButton;
use Indeximstudio\Telegram\components\ReplyMarkup;

class Telegram
{
    public const TYPE_RECIPIENT = 'recipient';
    public const TYPE_RECIPIENT_ADMIN = 'recipient_admin';

    public $config;
    private $bots;
    private $replyMarkup;

    function __construct($botName = '')
    {
        $this->bots = json_decode(evolutionCMS()->getConfig('client_telegramBots'), true);
        $this->getBot($botName);
        $this->replyMarkup = new ReplyMarkup();
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
        if (is_array($message)) {
            $message = json_encode([$this->getTitleMessage(), 'data' => $message], JSON_PRETTY_PRINT | JSON_UNESCAPED_LINE_TERMINATORS | JSON_UNESCAPED_SLASHES);
        } elseif (is_object($message)) {
            $message->site = $this->getTitleMessage();
        } else {
            $message = $this->getTitleMessage() . $message;
        }
        $message = urlencode($message);
        $url = "https://api.telegram.org/bot{$this->config['token']}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$message}";
        if ($this->replyMarkup->isNotEmpty()) {
            $url.= "&reply_markup={$this->replyMarkup->toJson()}";
        }
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

    private function getTitleMessage()
    {
        global $modx;
        return MODX_SITE_URL . '
';
    }

    public function addInlineButton(InlineKeyboardButton $button)
    {
        $this->replyMarkup->addInlineKeyboardButton($button);
    }
}
