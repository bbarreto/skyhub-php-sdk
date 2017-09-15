<?php

namespace Skyhub\Resources;

class Attributes extends \Skyhub\Marketplace {

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
	 * Inserir atributo
	 * @param type $name ID da atributo
	 * @param type $label Descrição
	 * @return type
	 */
	public function insert($name, $label, $options = []) {
		return $this->apiCall('POST', '/attributes', [
			'attribute'=>[
				'name'=>$name,
				'label'=>$label,
				'options'=>$options
			]
		]);
	}

	public function update($label, $options = []) {
		return $this->apiCall('PUT', '/attributes/'.rawurlencode($this->id), [
			'attribute'=>[
				'label'=>$label,
				'options'=>$options
			]
		]);
	}

}
