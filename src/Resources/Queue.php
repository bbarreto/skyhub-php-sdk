<?php

namespace Skyhub\Resources;

class Queue extends \Skyhub\Marketplace {

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
	 * Recupera o primeiro pedido disponível na fila de integração. Após o processamento
	 * do pedido, o mesmo deve ser removido da fila de integração em até 5 minutos (ou
	 * retornará para o início da fila)
	 * @return type
	 */
	public function get() {
		return $this->apiCall('GET', '/queues/orders');
	}

	/**
	 * Remove o pedido especificado da fila de integração após ter sido processado
	 * @return type
	 */
	public function delete() {
		return $this->apiCall('DELETE', '/queues/orders/'.rawurlencode($this->id));
	}

}
