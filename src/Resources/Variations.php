<?php

namespace Skyhub\Resources;

class Variations extends \Skyhub\Marketplace {

	private $sku;

	public function __construct($data) {
		$this->conf = $data->conf;
	}

	/**
	 * Definir ID padrão
	 * @param type $sku 
	 * @return type
	 */
	public function setSku($sku) {
		$this->sku = $sku;
	}

	public function get() {
		return $this->apiCall('GET', '/variations/'.urlencode($this->sku));
	}

	/**
	 * Adicionar variação a um produto
	 * @param type $variation 
	 * @return type
	 */
	public function insert($variation) {

		if (is_null($this->sku))
			return ['error'=>'Informe o SKU da variação do produto.'];

		if (!is_array($variation))
			return ['error'=>'Variação deve ser um array.'];

		return $this->apiCall('POST', '/products/'.urlencode($this->sku).'/variations', ['variation'=>$variation]);
		
	}

	public function update($sku, $variation) {

		if (!is_array($variation))
			return ['error'=>'Variação deve ser um array.'];

		return $this->apiCall('PUT', '/variations/'.$sku, ['variation'=>$variation]);
		
	}

	public function delete($sku) {
		return $this->apiCall('DELETE', '/variations/'.urlencode($sku));
	}

}