<?php

namespace ObeliskAdmin;

use ObeliskAdmin\Category;
use ObeliskAdmin\QueueScreenPopUrl;

define('QUEUE_STRATEGIES', serialize([
	'ringall',
	'leastrecent',
	'fewestcalls',
	'random',
	'rrmemory',
	'rrordered',
	'linear',
	'wrandom'
]));

class Queue extends Category
{
	const FILENAME = 'obelisk/queues.conf';
	const MODULE = 'app_queue.so';

	public $screenPopUrl;
	
    public function __construct($queue)
    {
        parent::__construct($queue);

        $this->filename = self::FILENAME;
        $this->module = self::MODULE;

		if ($screenPopUrl = QueueScreenPopUrl::where('queue', $queue)->first()) {
			$this->screenPopUrl = $screenPopUrl->screen_pop_url;
		}
    }
    
	public static function strategies()
	{
		return unserialize(QUEUE_STRATEGIES);
	}
	
	public function save()
	{
		$defaultValues = [
			'strategy' => 'ringall',
			'musicclass' => 'default',
			'ringinuse' => 'no',
			'eventwhencalled' => 'yes',
            'servicelevel' => '60',
			'monitor-format' => 'gsm',
			'monitor-type' => 'MixMonitor'
		];

		foreach ($defaultValues as $name => $value) {
			if (!isset($this->$name)) {
				$this->$name = $value;
			}
		}
		
		parent::save();

		if (!empty($this->screenPopUrl)) {
			$screenPopUrl = QueueScreenPopUrl::firstOrNew(['queue' => $this->category['current']]);
			$screenPopUrl->screen_pop_url = $this->screenPopUrl;
			
			if (isset($this->category['new'])) {
				if ($this->category['new'] != $this->category['current']) {
					$screenPopUrl->queue = $this->category['new'];
				}
			}
			
			$screenPopUrl->save();
		}
	}
	
	public function delete()
	{
		parent::delete();

		if ($screenPopUrl = QueueScreenPopUrl::find($this->category['current'])) {
			$screenPopUrl->delete();
		}
	}
}