<?php

namespace ObeliskAdmin;

use ObeliskAdmin\Category;

class AgentLogin extends Category
{
    const FILENAME = 'obelisk/agent_login.conf';
    const MODULE = 'pbx_config.so';

    public function __construct($category)
    {
        parent::__construct($category);

        $this->filename = self::FILENAME;
        $this->module = self::MODULE;
    }

    public static function agentLogin()
    {
        return AgentLogin::findOrFail('agent-login');
    }
}