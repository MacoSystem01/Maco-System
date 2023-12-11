<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */
class Credit {
    private $code;
    
    public function setCode($val){
        $this->code = $val;
    }
    
    public function  getCode(){
        return $this->code;
    }
    
    private $codeClient;
    
    public function setCodeClient($val){
        $this->codeClient = $val;
    }
    
    public function  getCodeClient(){
        return $this->codeClient;
    }
    
    private $codeBill;
    
    public function setCodeBill($val){
        $this->codeBill = $val;
    }
    
    public function  getCodeBill(){
        return $this->codeBill;
    }
    
    private $registrationDate;
    
    public function setRegistrationDate($val){
        $this->registrationDate = $val;
    }
    
    public function  getRegistrationDate(){
        return $this->registrationDate;
    }
    
    private $codeConcept;
    
    public function setCodeConcept($val){
        $this->codeConcept = $val;
    }
    
    public function  getCodeConcept(){
        return $this->codeConcept;
    }
    
    private $value;
    
    public function setValue($val){
        $this->value = $val;
    }
    
    public function  getValue(){
        return $this->value;
    }
    
    private $saldo;
    
    public function setSaldo($val){
        $this->saldo = $val;
    }
    
    public function  getSaldo(){
        return $this->saldo;
    }
    
    private $state;
    
    public function setState($val){
        $this->state = strtoupper($val);
    }
    
    public function  getState(){
        return $this->state;
    }
    
    private $cancelDate;
    
    public function setCancelDate($val){
        $this->cancelDate = $val;
    }
    
    public function  getCancelDate(){
        return $this->cancelDate;
    }
    
    private $user;
    
    public function setUser($val){
        $this->user = $val;
    }
    
    public function  getUser(){
        return $this->user;
    }
}
    
    
    
    
    
