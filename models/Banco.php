<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */
class Banco {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function getCode(){
        return $this->code;
    }
    
    private $generationDate;
    
    public function setGenerationDate($val){
        $this->generationDate = $val;
    }
    
    public function getGenerationDate(){
        return $this->generationDate;
    }

	private $Valor;
    
    public function setValor($val){
        $this->Valor = $val;
    }
    
    public function getValor(){
        return $this->Valor;
    }

	private $name;
    
    public function setName($val){
        $this->name = strtoupper($val);
    }
    
    public function getName(){
        return $this->name;
    }        
}
