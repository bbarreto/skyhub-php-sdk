<?php

namespace Skyhub\Resources;

class Freights extends \Skyhub\Marketplace {

	private $params;

	public function __construct($data) {
		$this->conf = $data->conf;
	}

	public function __set($var, $val) {

		if ($var=='saleSystems')
			$this->params['filters[sale_systems]'] = $val;
			return;

		$this->params[$this->fromCamelCase($var)] = $val;
	}

	public function get() {
		return $this->apiCall('GET', '/freights', $this->params);
	}

}