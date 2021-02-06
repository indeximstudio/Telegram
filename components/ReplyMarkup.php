<?php

namespace Indeximstudio\Telegram\components;

class ReplyMarkup
{
    private $empty = true;
    private $inlineKeyboard;
    private $index = 0;

    public function addInlineKeyboardButton(InlineKeyboardButton $button)
    {
        $this->empty = false;
        if (count($this->inlineKeyboard[$this->index]) > 3) {
            $this->index++;
        }
        $this->inlineKeyboard[$this->index][] = $button->toArray();
    }

    public function toArray()
    {
        return [
            'inline_keyboard' => $this->inlineKeyboard
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function isEmpty()
    {
        return $this->empty;
    }

    public function isNotEmpty()
    {
        return !$this->empty;
    }
}