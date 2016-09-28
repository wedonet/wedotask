<?php

class Cls_document {

	public $ic;
	public $channel;

	function __construct() {
		$this->cid = 0;

		$this->cid = $GLOBALS['main']->rqid('cid');

		$this->a_channel = $GLOBALS['main']->getarr('channel', $this->cid);


		if (FALSE == $this->a_channel) {
			showerr(1022);
		}

		crumb($this->a_channel['title']);
	}

// end func 
}

