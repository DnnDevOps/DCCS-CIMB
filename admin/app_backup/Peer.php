<?php

namespace ObeliskAdmin;

use ObeliskAdmin\Category;
use ObeliskAdmin\LocalExtension;
use ObeliskAdmin\Subscribe;
use ObeliskAdmin\PeerMapping;

class Peer extends Category
{
	const FILENAME = 'obelisk/sip_peer.conf';
	const MODULE = 'chan_sip.so';

    public function __construct($peer)
    {
        parent::__construct($peer);

        $this->filename = self::FILENAME;
        $this->module = self::MODULE;
		$this->type = 'friend';
		$this->host = 'dynamic';
		$this->callcounter = 'yes';
    }

	public function save()
	{
		if (!isset($this->context)) {
			$this->context = 'local-extension';
		}

		parent::save();

		$localExtension = LocalExtension::localExtension();
		$localExtension->reloadModule = $this->reloadModule;

		$subscribe = Subscribe::subscribe();
		$subscribe->reloadModule = $this->reloadModule;

		$currentCategory = $this->category['current'];
		$currentLocalExtension = "$currentCategory,1,Dial(SIP/$currentCategory)";
		$currentSubscribe = "$currentCategory,hint,SIP/$currentCategory";

		if (!isset($this->category['new'])) {
			$localExtension->exten($currentLocalExtension);
			$subscribe->exten($currentSubscribe);
		} else {
			$newCategory = $this->category['new'];

			$localExtension->exten($currentLocalExtension, "$newCategory,1,Dial(SIP/$newCategory)");
			$subscribe->exten($currentSubscribe, "$newCategory,hint,SIP/$newCategory");
		}
		
		$localExtension->save();
		$subscribe->save();
	}
	
	public function delete()
	{
		parent::delete();

		$currentCategory = $this->category['current'];

		$localExtension = LocalExtension::localExtension();
		$localExtension->remove('exten', "$currentCategory,1,Dial(SIP/$currentCategory)");
		$localExtension->save();

		$subscribe = Subscribe::subscribe();
		$subscribe->remove('exten', "$currentCategory,hint,SIP/$currentCategory");
		$subscribe->save();
	}
}