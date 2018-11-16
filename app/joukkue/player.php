<?php 
    class Player{
        private $number;
        private $name;
        private $height;
        private $reach;
        private $position;
        private $funnyline;
        
        function __construct($number, $name, $height, $reach, $position){
            $this->setNumber($number);
            $this->setName($name);
            $this->setHeight($height);
            $this->setReach($reach);
            $this->setPosition($position);
        }
        function setNumber($number){
            $this->number = $number;
        }
        function getNumber(){
            return $this->number;
        }
        function setName($name){
            $this->name = $name;
        }
        function getName(){
            return $this->name;
        }
        function setHeight($height){
            $this->height = $height;
        }
        function getHeight(){
            return $this->height;
        }
        function setReach($reach){
            $this->reach = $reach;
        }
        function getReach(){
            return $this->reach;
        }
        function setPosition($position){
            $this->position = $position;
        }
        function getPosition(){
            return $this->position;
        }
    }
    $keinonen = new Player("1", "Niko Hienonen", "183", "300", "Hakkuri");
?>