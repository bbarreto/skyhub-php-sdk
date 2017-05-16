<?php

namespace Skyhub\Resources;

class Categories extends \Skyhub\Marketplace {

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
	public function update($name) {
		return $this->apiCall('PUT', '/categories/'.urlencode($this->id), [
			'category'=>[
				'name'=>$name
			]
		]);
	}

	/**
	 * Apagar categoria
	 * @return type
	 */
	public function delete() {
		return $this->apiCall('DELETE', '/categories/'.urlencode($this->id));
	}

}