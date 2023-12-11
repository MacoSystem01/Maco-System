<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */
class Client {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function  getCode(){
        return $this->code;
    }
    
    private $name;
    
    public function setName($val){
        $this->name = strtoupper($val);
    }
    
    public function  getName(){
        return $this->name;
    }
    
    private $registrationDate;
    
    public function setRegistrationDate($val){
        $this->registrationDate = $val;
    }
    
    public function  getRegistrationDate(){
        return $this->registrationDate;
    }
    
    private $codeDepartment;
    
    public function setCodeDepartment($val){
        $this->codeDepartment = $val;
    }
    
    public function  getCodeDepartment(){
        return $this->codeDepartment;
    }
    
    private $codeLocality;
    
    public function setCodeLocality($val){
        $this->codeLocality = $val;
    }
    
    public function  getCodeLocality(){
        return $this->codeLocality;
    }
    
    private $direction;
    
    public function setDirection($val){
        $this->direction = strtoupper($val);
    }
    
    public function  getDirection(){
        return $this->direction;
    }
    
    private $mobile;
    
    public function setMobile($val){
        $this->mobile = $val;
    }
    
    public function  getMobile(){
        return $this->mobile;
    }
    
    private $user;
    
    public function setUser($val){
        $this->user = $val;
    }
    
    public function  getUser(){
        return $this->user;
    }
    
    private $tipo;
    
    public function setTipo($val){
        $this->tipo = $val;
    }
    
    public function  getTipo(){
        return $this->tipo;
    }
}
