<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */
class Concept {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function getCode(){
        return $this->code;
    }
    
    private $name;
    
    public function setName($val){
        $this->name = strtoupper($val);
    }
    
    public function  getName(){
        return $this->name;
    }        
}
