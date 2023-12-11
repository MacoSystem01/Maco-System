<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */
class Locality {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function getCode(){
        return $this->code;
    } 
    
    private $codeDepartment;
    
    public function setCodeDepartment($val){
        $this->codeDepartment = $val;
    }
    
    public function getCodeDepartment(){
        return $this->codeDepartment;
    }
    
    private $name;
    
    public function setName($val){
        $this->name = $val;
    }
    
    public function getName(){
        return $this->name;
    }
}
