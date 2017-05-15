<?php

namespace Skyhub\Resources;

class Statuses extends \Skyhub\Marketplace {

	private $id;

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
	 * Listar todos os status cadastrados
	 * @return type
	 */
	public function get() {
		return $this->apiCall('GET', '/statuses');
	}

	/**
	 * Inserir status
	 * @param type $code ID do status
	 * @param type $label Descrição
	 * @param type $type Tipo do status
	 * @return type
	 */
	public function insert($code, $label, $type) {
		return $this->apiCall('POST', '/statuses', [
			'status'=>[
				'code'=>$code,
				'label'=>$label,
				'type'=>$type
			]
		]);
	}

	/**
	 * Atualizar status
	 * @param type $label Descrição
	 * @param type $type Tipo do status
	 * @return type
	 */
	public function update($label, $type) {
		return $this->apiCall('PUT', '/statuses/'.urlencode($this->id), [
			'status'=>[
				'label'=>$label,
				'type'=>$type
			]
		]);
	}

	/**
	 * Apagar status
	 * @return type
	 */
	public function delete() {
		return $this->apiCall('DELETE', '/statuses/'.urlencode($this->id));
	}

}