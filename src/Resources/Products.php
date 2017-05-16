<?php

namespace Skyhub\Resources;

class Products extends \Skyhub\Marketplace {

	private $sku=null,
	        $params;

	public function __construct($data) {
		$this->conf = $data->conf;
	}

	/**
	 * Definir SKU padrão
	 * @param type $sku 
	 * @return type
	 */
	public function setSku($sku) {
		$this->sku = $sku;
	}

	/**
	 * Listar todos os produtos cadastrados
	 * @param type|int $page Número da página
	 * @param type|int $per_page Quantidade de resultados por página
	 * @return type|array Lista de produtos
	 */
	public function get($page=1, $per_page=25) {

		if (isset($page) && (!is_numeric($page) || $page<1)):
			return ['error'=>['code'=>null, 'message'=>'Parâmetro page deve ser um número inteiro maior que zero.']];
		endif;

		if (isset($per_page) && (!is_numeric($per_page) || $per_page<1)):
			return ['error'=>['code'=>null, 'message'=>'Parâmetro per_page deve ser um número inteiro maior que zero.']];
		endif;

		$this->params = [
			'page'=>$page,
			'per_page'=>$per_page
		];

		return $this->apiCall('GET', '/products', $this->params);
	}

	/**
	 * Consultar um único produto a partir do SKU
	 * @param type $sku 
	 * @return type|array 
	 */
	public function getBySku() {
		if (is_null($this->sku))
			return ['error'=>'Informe o SKU do produto'];

		return $this->apiCall('GET', '/products/'.$this->sku);
	}

	/**
	 * Receber próxima página de resultados
	 * @return type
	 */
	public function nextPage() {

		if (isset($this->params->page) && is_numeric($this->params->page)):
			$this->params->page++;
		else:
			$this->params->page = 2;
		endif;

		return $this->apiCall('GET', '/products', $this->params);
	}

	/**
	 * Inserir produto
	 * @param type $product 
	 * @return type
	 */
	public function insert($product) {

		if (!is_array($product))
			return ['error'=>'Produto deve ser um array.'];

		return $this->apiCall('POST', '/products', ['product'=>$product]);

	}

	/**
	 * Atualizar produto
	 * @param type $product 
	 * @return type
	 */
	public function update($product) {

		if (!is_array($product))
			return ['error'=>'Produto deve ser um array.'];

		return $this->apiCall('PUT', '/products/'.urlencode($this->sku), ['product'=>$product]);

	}

	/**
	 * Remover produto
	 * @return type
	 */
	public function delete() {

		if (is_null($this->sku))
			return ['error'=>'Informe o SKU do produto'];

		return $this->apiCall('DELETE', '/products/'.urlencode($this->sku));

	}

	public function urls($mktplace=null) {
		if (is_null($mktplace))
			return $this->apiCall('GET', '/products/urls');
		else
			return $this->apiCall('GET', '/products/urls/'.urlencode($mktplace));
	}

	public function variations($sku=null) {
		
		$variations = new Variations($this);
		
		if (!is_null($this->sku))
			$variations->setSku($this->sku);

		return $variations;
	}

}