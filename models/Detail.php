<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */
class Detail {
    private $codeBill;
    
    public function setCodeBill($val){
        $this->codeBill = $val;
    }
    
    public function  getCodeBill(){
        return $this->codeBill;
    }
    
    private $codeArticle;
    
    public function setCodeArticle($val){
        $this->codeArticle = strtoupper($val);
    }
    
    public function  getCodeArticle(){
        return $this->codeArticle;
    }
    
    private $quantity;
    
    public function setQuantity($val){
        $this->quantity = $val;
    }
    
    public function  getQuantity(){
        return $this->quantity;
    }
    
     private $valueUnit;
    
    public function setValueUnit($val){
        $this->valueUnit = $val;
    }
    
    public function  getValueUnit(){
        return $this->valueUnit;
    }
    
     private $total;
    
    public function setTotal($val){
        $this->total = $val;
    }
    
    public function  getTotal(){
        return $this->total;
    }
    
    private $move;
    
    public function setMove($val){
        $this->move = strtoupper($val);
    }
    
    public function  getMove(){
        return $this->move;
    }    
    
    private $moveDate;
    
    public function setMoveDate($val){
        $this->moveDate = $val;
    }
    
    public function  getMoveDate(){
        return $this->moveDate;
    }
    
    private $origen;
    
    public function setOrigen($val){
        $this->origen = $val;
    }
    
    public function  getOrigen(){
        return $this->origen;
    }
    
    
}
