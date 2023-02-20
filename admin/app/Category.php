<?php

namespace ObeliskAdmin;

use ObeliskAdmin\AsteriskManager;

class Category
{
    public $reloadModule = TRUE;

    protected $category = ['current' => NULL, 'new' => NULL];
    protected $lines = [];
    protected $loaded = FALSE;

    protected $filename;
    protected $module;

    private function isMulti($name)
    {
        return in_array($name, ['exten', 'include', 'agent', 'member', 'register', 'same']);
    }

    private function addAction(&$actions, $variable, $loaded, $removed, $currentValue, $newValue)
    {
        $action = NULL;
        $value = NULL;
        $match = NULL;

        if ($removed) {
            $action = 'Delete';
            $match = $currentValue;
        } else if ($newValue == NULL && !$loaded) {
            $action = 'Append';
            $value = ($this->isMulti($variable) ? '>' : '') . $currentValue;
        } else if (!empty($newValue) && $newValue != $currentValue) {
            $action = 'Update';
            $value = $newValue;

            if ($this->isMulti($variable)) {
                $match = $currentValue;
            }
        } else {
            return;
        }

        $actionFields = [
            'action' => $action,
            'category' => $this->category['current'],
            'variable' => $variable
        ];

        if ($match != NULL) {
            $actionFields['match'] = $match;
        }

        if ($value != NULL) {
            $actionFields['value'] = $value;
        }

        $actions[] = $actionFields;
    }

    public function __construct($category)
    {
        $this->category['current'] = $category;
    }

    public function __get($name)
    {
        if (isset($this->lines[$name])) {
            if ($this->isMulti($name)) {
                return $this->$name();
            } else if (!$this->lines[$name]['removed']) {
                return $this->lines[$name]['new'] != NULL ? $this->lines[$name]['new'] : $this->lines[$name]['current'];
            }
        } else if ($name == 'category') {
            return $this->category['new'] != NULL ? $this->category['new'] : $this->category['current'];
        }
    }

    public function __set($name, $value)
    {
        if (empty($name)) {
            return;
        }

        if ($name == 'category') {
            $this->category['new'] = $value;
        } else {
            if ($this->isMulti($name)) {
                $this->$name($value);
            } else {
                if (!isset($this->lines[$name])) {
                    $this->lines[$name] = [
                        'loaded' => FALSE,
                        'removed' => FALSE,
                        'current' => $value,
                        'new' => NULL
                    ];
                } else if ($this->lines[$name]['current'] != $value) {
                    $this->lines[$name]['removed'] = FALSE;
                    $this->lines[$name]['new'] = $value;
                }
            }
        }
    }

    public function __isset($name)
    {
        return isset($this->lines[$name]);
    }

    public function __unset($name)
    {
        if (isset($this->lines[$name]) && !$this->isMulti($name)) {
            $this->lines[$name]['removed'] = TRUE;
        }
    }

    public function __call($name, $arguments)
    {
        if ($this->isMulti($name)) {
            if (empty($arguments)) {
                if (isset($this->lines[$name])) {
                    return array_keys($this->lines[$name]);
                }

                return [];
            } else {
                if (!isset($this->lines[$name])) {
                    $this->lines[$name] = [];
                }

                if (!isset($this->lines[$name][$arguments[0]])) {
                    $this->lines[$name][$arguments[0]] = [
                        'loaded' => FALSE,
                        'removed' => FALSE,
                        'new' => NULL
                    ];
                }
                
                if (count($arguments) == 2) {
                    if ($arguments[0] != $arguments[1]) {
                        $this->lines[$name][$arguments[0]]['new'] = $arguments[1];
                    }
                }
            }
        }
    }

    public function changed($name)
    {
        if (isset($this->lines[$name]) && !$this->isMulti($name)) {
            return $this->lines[$name]['new'] != NULL;
        }
    }

    public function old($name)
    {
        if (isset($this->lines[$name]) && !$this->isMulti($name)) {
            if ($this->lines[$name]['loaded']) {
                return $this->lines[$name]['current'];
            }
        }
    }

    public function load($name, $value)
    {
        $this->$name = $value;

        if ($this->isMulti($name)) {
            $this->lines[$name][$value]['loaded'] = TRUE;
        } else {
            $this->lines[$name]['loaded'] = TRUE;
        }
    }

    public function remove($name, $value)
    {
        if (isset($this->lines[$name]) && $this->isMulti($name)) {
            if (isset($this->lines[$name][$value])) {
                $this->lines[$name][$value]['removed'] = TRUE;
            }
        }
    }

    public static function factory($category, $lines, $filename, $module)
    {
        $currentClass = get_called_class();

        $categoryModel = new $currentClass($category);
        $categoryModel->loaded = TRUE;
        $categoryModel->filename = $filename;
        $categoryModel->module = $module;

        foreach ($lines as $line) {
            $variable = explode('=', $line, 2);

            if (count($variable) == 2) {
                $categoryModel->load($variable[0], $variable[1]);
            }
        }

        return $categoryModel;
    }

    protected static function readAll($filename, $module)
    {
        $categories = [];
        $currentClass = get_called_class();

        foreach (AsteriskManager::getInstance()->getConfig($filename) as $category => $lines) {
            $categories[] = $currentClass::factory($category, $lines, $filename, $module);
        }

        return $categories;
    }

    protected static function readOne($filename, $module, $category)
    {
        $categories = AsteriskManager::getInstance()->getConfig($filename, $category);

        if (!empty($categories)) {
            $currentClass = get_called_class();
            
            return $currentClass::factory($category, $categories[$category], $filename, $module);
        }

        throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
    }

    public static function all($filename = NULL)
    {
        $currentClass = get_called_class();

        return $currentClass::readAll(is_null($filename) ? $currentClass::FILENAME : $filename, $currentClass::MODULE);
    }
    
    public static function findOrFail($category)
    {
        $currentClass = get_called_class();

        return $currentClass::readOne($currentClass::FILENAME, $currentClass::MODULE, $category);
    }

    public function save()
    {
        $actions = [];

        if (!$this->loaded) {
            $actions[] = [
                'action' => 'NewCat',
                'category' => $this->category['current']
            ];
        } else if ($this->category['new'] != NULL && $this->category['current'] != $this->category['new']) {
            $actions[] = [
                'action' => 'RenameCat',
                'category' => $this->category['current'],
                'value' => $this->category['new']
            ];
        }

        foreach ($this->lines as $variable => $value) {
            if ($this->isMulti($variable)) {
                foreach ($value as $currentValue => $valueMeta) {
                    $this->addAction($actions, $variable, $valueMeta['loaded'], $valueMeta['removed'], $currentValue, $valueMeta['new']);
                }
            } else {
                $this->addAction($actions, $variable, $value['loaded'], $value['removed'], $value['current'], $value['new']);
            }
        }

        if (!empty($actions)) {
            AsteriskManager::getInstance()->updateConfig($this->filename, $this->reloadModule ? $this->module : NULL, $actions);

            // TODO: update state Category setelah operasi simpan berhasil
        }
    }

    public function delete()
    {
        AsteriskManager::getInstance()->updateConfig($this->filename, $this->reloadModule ? $this->module : NULL, [
            [
                'action' => 'DelCat',
                'category' => $this->category['current']
            ]
        ]);
    }
}