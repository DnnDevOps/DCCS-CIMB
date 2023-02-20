<?php

namespace ObeliskAdmin;

use ObeliskAdmin\Category;

class LocalExtension extends Category
{
	const FILENAME = 'obelisk/local_extension.conf';
	const MODULE = 'pbx_config.so';

    public function __construct($category)
    {
        parent::__construct($category);

        $this->filename = self::FILENAME;
        $this->module = self::MODULE;
    }

    public static function localExtension()
    {
        return LocalExtension::findOrFail('local-extension');
    }
}