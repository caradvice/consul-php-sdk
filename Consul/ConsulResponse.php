<?php

namespace SensioLabs\Consul;

class ConsulResponse
{
    private $headers;
    private $body;
    private $values;

    public function __construct($headers, $body)
    {
        $this->headers = $headers;
        $this->body = $body;
        $this->deconstructBody();
    }

    private function deconstructBody() {
      $body = $this->json();
      if(!is_array($body)) {
        return;
      }

      foreach($body as $kv) {
        $key = end(explode('/',$kv['Key']));
        $values[$key] = base64_decode($kv['Value']);
      }

      $this->values = $values;

    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function __toString() {
      $out = [];
      foreach($this->values as $k => $v) {
        $out[] =  "$k,$v";
      }
      return implode(';', $out);
    }

    public function getValues() {
      return $this->values;
    }

    public function getVals() {
      return $this->getValues();
    }

    public function getBody()
    {
        return $this->body;
    }

    public function json()
    {
        return json_decode($this->body, true);
    }

}
