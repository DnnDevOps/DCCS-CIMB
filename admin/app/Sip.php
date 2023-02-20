<?php

namespace ObeliskAdmin;

use ObeliskAdmin\Category;
use ObeliskAdmin\Trunk;

class Sip extends Category
{
    private function notNull($field)
    {
        return isset($field) ? ":$field" : NULL;
    }

    private function registerValue(Trunk $trunk, $old = FALSE)
    {
        $user = $old ? $trunk->old('defaultuser') : $trunk->defaultuser;
        $secret = NULL;
        $authuser = NULL;
        $host = $old ? $trunk->old('host') : $trunk->host;
        $host = !empty($host) ? "@$host" : NULL; 

        if (isset($trunk->secret)) {
            $secret = $old ? $this->notNull($trunk->old('secret')) : $this->notNull($trunk->secret);
        }
        
        if (isset($trunk->auth)) {
            $authuser = $old ? $this->notNull($trunk->old('auth')) : $this->notNull($trunk->auth);
        }
        
        return "$user$secret$authuser$host";
    }

    public static function general()
    {
        return Sip::readOne('sip.conf', 'chan_sip.so', 'general');
    }
    
    public function registerTrunk(Trunk $trunk)
    {
        $newValue = $this->registerValue($trunk);
        $oldValue = $this->registerValue($trunk, TRUE);

        if ($newValue == $oldValue) {
            return;
        }

        if (empty($oldValue)) {
            $this->register($newValue);
        } else {
            $this->register($oldValue, $newValue);
        }
        
        $this->save();
    }

    public function unregisterTrunk(Trunk $trunk)
    {
        $this->remove('register', $this->registerValue($trunk, TRUE));
        $this->save();
    }
}
