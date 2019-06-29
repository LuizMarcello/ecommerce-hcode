<?php
//Esta classe vai servir de 'base' para praticamente
//todas as classes a serem criadas.

//Namespace desta classe:
namespace Hcode;

//Local do outro namespace, do 'rain templates':
//Por exemplo, quando for instanciar com o 'new Tpl':
use Rain\Tpl;

class Page
{
    private $tpl;
    private $options = [];
    private $defaults = ["data" => []];

    public function __construct($opts = array())
    {
        $this->options = array_merge($this->defaults, $opts);

        $config = array(
            "tpl_dir"       => $_SERVER['DOCUMENT_ROOT'] . "/views/",
            "cache_dir"     => $_SERVER['DOCUMENT_ROOT'] . "/views-cache/",
            "debug"         => false
        );

        Tpl::configure( $config );

        // create the Tpl object
        $this->tpl = new Tpl();

        $this->setData($this->options['data']);

        $this->tpl->draw("header");
    }
    

    public function __destruct()
    {
        $this->tpl->draw("footer");
    }


    private function setData($data = array())
    {
        foreach ($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }

    public function setTpl($name, $data = array(), $returnHTML = false)
    {
        $this->setData($data);

        return $this->tpl->draw($name, $returnHTML);
    }


    
}
