<?php

namespace Indeximstudio\Telegram\components;

class InlineKeyboardButton
{
    /** @var string $text */
    public $text;
    /** @var string $url */
    public $url;
    public $login_url;
    /** @var string $callback_data */
    public $callback_data;
    /** @var string $switch_inline_query */
    public $switch_inline_query;
    /** @var string $switch_inline_query_current_chat */
    public $switch_inline_query_current_chat;
    public $callback_game;
    /** @var boolean$pay */
    public $pay;

    public function toArray()
    {
        return array_filter(get_object_vars($this), function ($var) {
            return $var !== null;
        });
    }
}