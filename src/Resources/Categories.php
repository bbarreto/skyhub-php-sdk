<?php

namespace Skyhub\Resources;

class Categories extends \Skyhub\Marketplace {

	private $params,
	        $id;

	public function __construct($data) {
		$this->conf = $data->conf;
	}

	/**
	 * Definir SKU padrão
	 * @param type $sku 
	 * @return type
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * Listar todas as categorias cadastradas
	 * @return type
	 */
	public function get() {
		return $this->apiCall('GET', '/categories');
	}

	/**
	 * Inserir categoria
	 * @param type $code ID da categoria
	 * @param type $name Descrição
	 * @return type
	 */
	public function insert($code, $name) {
		return $this->apiCall('POST', '/categories', [
			'category'=>[
				'code'=>$code,
				'name'=>$name
			]
		]);
	}

	/**
	 * Atualizar descrição de uma categoria
	 * @param type $code ID da categoria
	 * @param type $name Nova descrição
	 * @return type
	 */
	public function update($code, $name) {
		return $this->apiCall('PUT', '/categories/'.urlencode($code), [
			'category'=>[
				'name'=>$name
			]
		]);
	}

	/**
	 * Apagar categoria
	 * @param type $code ID da categoria
	 * @return type
	 */
	public function delete($code) {
		return $this->apiCall('DELETE', '/categories/'.urlencode($code));
	}

}