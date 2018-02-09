<?php

namespace Skyhub\Resources;

class Orders extends \Skyhub\Marketplace {

	private $params,
	        $id;

	public function __construct($data) {
		$this->conf = $data->conf;
	}

	/**
	 * Definir ID padrão
	 * @param type $id 
	 * @return type
	 */
	public function setId($id) {
		$this->id = $id;
		
		return $this;
	}

	public function get($page=1, $per_page=25, $sale_system=null, $statuses=[]) {

		if (isset($this->id) && !is_null($this->id))
			return $this->apiCall('GET', '/orders/'.urlencode($this->id));

		$this->params = [
			'page'=>$page,
			'per_page'=>$per_page,
			'filters'=>[
				'sale_system'=>$sale_system,
				'statuses'=>$statuses
			]
		];
		return $this->apiCall('GET', '/orders', $this->params);
	}

	public function next() {
		if (isset($this->params['page'])):
			$this->params['page']++;
		else:
			$this->params['page']=2;
		endif;
		return $this->apiCall('GET', '/orders', $this->params);	
	}

	public function export()
	{
		$this->params = [
			'exported'=>true
		];
		return $this->apiCall('PUT', '/orders/'.rawurlencode($this->id).'/exported', $this->params);
	}

	/**
	 * Faturar um pedido
	 * @param array $invoice
	 * @return type
	 */
	public function invoice($invoice) {

		if (!is_array($invoice))
			return ['error'=>'Invoice deve ser um array.'];

		return $this->apiCall('POST', '/orders/'.rawurlencode($this->id).'/invoice', $invoice);
	}

	/**
	 * Enviar informações de shipments
	 * @param array $invoice
	 * @return type
	 */
	public function shipments($shipments) {

		if (!is_array($shipments))
			return ['error'=>'Shipments deve ser um array.'];

		return $this->apiCall('POST', '/orders/'.rawurlencode($this->id).'/shipments', $shipments);
	}
}
