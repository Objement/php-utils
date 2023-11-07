<?php

namespace Objement\OmPhpUtils\Models;

class OmOption
{
    private mixed $key;
    private mixed $caption;

    public function __construct($key, $caption)
    {
        $this->key = $key;
        $this->caption = $caption;
    }

    /**
     * @return mixed
     */
    public function getKey(): mixed
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey(mixed $key): void
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getCaption(): mixed
    {
        return $this->caption;
    }

    /**
     * @param mixed $caption
     */
    public function setCaption(mixed $caption): void
    {
        $this->caption = $caption;
    }
}
