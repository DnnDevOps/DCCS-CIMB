<?php

namespace ObeliskAdmin;

use ObeliskAdmin\Category;

class Subscribe extends Category
{
	const FILENAME = 'obelisk/subscribe.conf';
	const MODULE = 'pbx_config.so';

    public function __construct($category)
    {
        parent::__construct($category);

        $this->filename = self::FILENAME;
        $this->module = self::MODULE;
    }

    public static function subscribe()
    {
        return Subscribe::findOrFail('subscribe');
    }
}