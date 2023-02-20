<?php

namespace ObeliskAdmin;

use ObeliskAdmin\Category;
use ObeliskAdmin\Sip;

class Trunk extends Category
{
    const FILENAME = 'obelisk/sip_trunk.conf';
    const MODULE = 'chan_sip.so';

    private $primaryFields = ['type', 'defaultuser', 'secret', 'host', 'context'];

    public function __construct($trunk)
    {
        parent::__construct($trunk);

        $this->filename = self::FILENAME;
        $this->module = self::MODULE;
    }
    
    public function save()
    {
        if (!isset($this->type)) {
            $this->type = 'peer';
        }

        if (!isset($this->context)) {
            $this->context = 'incoming';
        }

        parent::save();

        $sip = Sip::general();
        $sip->registerTrunk($this);
    }
    
    public function delete()
    {
        parent::delete();
        
        $sip = Sip::general();
        $sip->unregisterTrunk($this);
    }

    public function assignFields(&$request)
    {
        $this->defaultuser = $request->defaultuser;
        $this->host = $request->host;
        $this->context = $request->context;

        if ($request->has('secret')) {
            $this->secret = $request->secret;
        }

        if (!empty($request->field) && count($request->field) == count($request->value)) {
            foreach ($request->field as $key => $value) {
                if (!in_array($value, $this->primaryFields)) {
                    $this->$value = $request->value[$key];
                }
            }
        }
    }

    public function customFields()
    {
        $fields = [];

        foreach ($this->lines as $variable => $value) {
            if (!in_array($variable, $this->primaryFields)) {
                $fields[$variable] = $this->$variable;
            }
        }

        return $fields;
    }
}
