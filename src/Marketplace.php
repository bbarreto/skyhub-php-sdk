<?php

namespace Skyhub;

class Marketplace {
	
	protected $conf;

	public function __construct() {
		$this->conf = (object) [
			'endpoint'=>'https://api.skyhub.com.br',
			'auth'=> (object) [
				'email'=>null,
				'senha'=>null
			]
		];
	}

	public function setAuth($email, $key) {
		$this->conf->auth->email = $email;
		$this->conf->auth->key = $key;
	}

	public function products($sku=null) {
		$products = new Resources\Products($this);

		if (!is_null($sku)):
			$products->setSku($sku);
		endif;

		return $products;
	}

	public function categories($id=null) {
		$categories = new Resources\Categories($this);

		if (!is_null($id)):
			$categories->setId($id);
		endif;

		return $categories;
	}

	public function attributes($id=null) {
		$attributes = new Resources\Attributes($this);

		if (!is_null($id)):
			$attributes->setId($id);
		endif;

		return $attributes;
	}

	public function queue($id=null) {
		$queue = new Resources\Queue($this);

		if (!is_null($id)):
			$queue->setId($id);
		endif;

		return $queue;
	}

	public function saleSystems() {
		return $this->apiCall('GET', '/sale_systems');
	}

	public function statusTypes() {
		return $this->apiCall('GET', '/status_types');
	}

	public function freights() {
		return new Resources\Freights($this);
	}

	public function apiCall($type='GET', $uri='/', $data=[]) {
		$url = $this->conf->endpoint.$uri;
		$opts = [
		    "http" => [
		        "method" => $type,
		        "ignore_errors"=>true,
		        "header" => "Content-type: application/json\r\n".
		        			"Accept: application/json\r\n".
						    "X-Api-Key: {$this->conf->auth->key}\r\n".
						    "X-User-Email: {$this->conf->auth->email}"
		    ]
		];

		if (is_array($data) && $type=='GET'):
			$url .= '?'.http_build_query($data);
		else:
			$opts['http']['content'] = json_encode($data);
		endif;

		try {
			$context = stream_context_create($opts);
			$json = file_get_contents($url, false, $context);
			$headers = $this->parseHeaders($http_response_header);

			$json = json_decode($json, true);

			if (isset($json['error'])):
				return ['error'=>['message'=>$json['error'], 'code'=>$headers['response_code']]];
			endif;

			switch ($headers['response_code']) {
				case 201:
					return true;
					break;
				case 204:
					return true;
					break;
				case 400:
					return ['error'=>['code'=>401, 'message'=>'Formato de requisição inválido.']];
					break;
				case 401:
					return ['error'=>['code'=>401, 'message'=>'E-mail ou chave de acesso inválidos.']];
					break;
				case 403:
					return ['error'=>['code'=>403, 'message'=>'Autenticação inválida']];
					break;
				case 404:
					return ['error'=>['code'=>404, 'message'=>'Objeto não encontrado.']];
					break;
			}

			if ($json==null):
				return ['error'=>['message'=>'API SkyHub não retornou resposta.', 'code'=>$headers['response_code']]];
			endif;

			return $json;

		} catch (Exception $e) {
			return $e->getMessage();	
		}
	}

	private function parseHeaders($headers) {
	    $head = array();
	    foreach($headers as $k=>$v):
	        $t = explode(':', $v, 2);
	        if(isset($t[1])):
	            $head[trim($t[0])] = trim($t[1]);
	        else:
	            $head[] = $v;
	            if(preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#",$v, $out))
	                $head['response_code'] = intval($out[1]);
	        endif;
	    endforeach;
	    return $head;
	}

	protected function fromCamelCase($input) {
		preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
		$ret = $matches[0];
		foreach ($ret as &$match) {
			$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
		}
		return implode('_', $ret);
	}

}