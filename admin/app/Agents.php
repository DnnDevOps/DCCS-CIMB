<?php

namespace ObeliskAdmin;

use ObeliskAdmin\Category;

class Agents extends Category
{
    const FILENAME = 'obelisk/agents.conf';
    const MODULE = 'chan_agent.so';

    public function __construct($category)
    {
        parent::__construct($category);

        $this->filename = self::FILENAME;
        $this->module = self::MODULE;
    }

    public static function agents()
    {
        return Agents::findOrFail('agents');
    }
}