<?php

namespace ObeliskAdmin;

use ObeliskAdmin\Category;

class Context extends Category
{
    const FILENAME = 'obelisk/extensions.conf';
    const MODULE = 'pbx_config.so';

    public function __construct($context)
    {
        parent::__construct($context);

        $this->filename = self::FILENAME;
        $this->module = self::MODULE;
    }

    public function extensions($extenMatch = NULL)
    {
        $extensions = [];

        if (!is_null($this->exten)) {
            foreach ($this->exten as $value) {
                if (preg_match('/(.+),1,Macro\((.+)\)/', $value, $values)) {
                    if (count($values) >= 3) {
                        $extension = new \stdClass;
                        $extension->value = $value;
                        $extension->extension = $values[1];
                        $extension->trunk = NULL;
                        $extension->destination = NULL;
                        $extension->record = NULL;
                        $extension->peer = NULL;
                        $extension->queue = NULL;

                        $parameters = explode(',', $values[2]);

                        if (count($parameters) > 0) {
                            $extension->macro = array_shift($parameters);
                            $extension->params = $parameters;

                            switch ($extension->macro) {
                                case 'dial-trunk':
                                    $extension->trunk = $parameters[0];
                                    $extension->destination = $parameters[1];
                                    $extension->record = $parameters[2];
                                    
                                    break;
                                case 'dial-peer':
                                    $extension->peer = $parameters[0];
                                    
                                    break;
                                case 'enter-queue':
                                    $extension->queue = $parameters[0];
                                    
                                    break;
                            }

                            $extensions[] = $extension;
                        }

                        if ($extension->extension == $extenMatch) {
                            return $extension;
                        }
                    }
                }
            }
        }

        return $extensions;
    }
}
