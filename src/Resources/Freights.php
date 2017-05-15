<?php

namespace Skyhub\Resources;

class Freights extends \Skyhub\Marketplace {

	private $params;

	public function __construct($data) {
		$this->conf = $data->conf;
	}

	public function __set($var, $val) {
		$this->params[$this->fromCamelCase($var)] = $val;
	}

	public function get() {
		return $this->apiCall('GET', '/freights', $this->params);
	}

}