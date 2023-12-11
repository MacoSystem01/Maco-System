<?php
/**
 * Description of Banco
 *
 * @author MACOSystem
 */
class Stock {
    private $code;
    
    public function setCode($val){
        $this->code = strtoupper($val);
    }
    
    public function getCode(){
        return $this->code;
    }
    
    private $name;
    
    public function setName($val){
        $this->name = strtoupper($val);
    }
    
    public function getName(){
        return $this->name;
    }
    
    private $articulo;
    
    public function setArticulo($val){
        $this->articulo = strtoupper($val);
    }
    
    public function getArticulo(){
        return $this->articulo;
    }

    private $vlrunit;
    
    public function setVlrUnit($val){
        $this->vlrunit = strtoupper($val);
    }
    
    public function getvlrunit(){
        return $this->vlrunit;
    }

    private $vlrtot;
    
    public function setVlrTot($val){
        $this->vlrtot = strtoupper($val);
    }
    
    public function getvlrtot(){
        return $this->vlrtot;
    }

    private $move;
    
    public function setMove($val){
        $this->move = strtoupper($val);
    }
    
    public function getMove(){
        return $this->move;
    }
    
    private $quantity;
    
    public function setQuantity($val){
        $this->quantity = $val;
    }
    
    public function getQuantity(){
        return $this->quantity;
    }
    
    private $priceBuy;
    
    public function setPriceBuy($val){
        $this->priceBuy = $val;
    }
    
    public function getPriceBuy(){
        return $this->priceBuy;
    }
    
    private $priceSold;
    
    public function setPriceSold($val){
        $this->priceSold = $val;
    }
    
    public function getPriceSold(){
        return $this->priceSold;
    }
    
    private $ubication;
    
    public function setUbication($val){
        $this->ubication = $val;
    }
    
    public function getUbication(){
        return $this->ubication;
    }
    
    private $valueSale;
    
    public function setValueSale($val){
        $this->valueSale = $val;
    }
    
    public function  getValueSale(){
        return $this->valueSale;
    }

    private $moveDate;
    
    public function setMoveDate($val){
        $this->moveDate = $val;
    }
    
    public function getMoveDate(){
        return $this->moveDate;
    }
    
    private $user;
    
    public function setUser($val){
        $this->user = $val;
    }
    
    public function getUser(){
        return $this->user;
    }
}
