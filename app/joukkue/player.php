<?php 
    class Player{
        private $number;
        private $fname;
        private $lname;
        private $height;
        private $reach;
        private $position;
        private $funnyline;
        
        function __construct($number, $fname, $lname, $height, $reach, $position){
            $this->setNumber($number);
            $this->setFname($fname);
            $this->setLname($lname);
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
        function setFname($fname){
            $this->fname = $fname;
        }
        function getFname(){
            return $this->fname;
        }
        function setLname($lname){
            $this->lname = $lname;
        }
        function getLname(){
            return $this->lname;
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
        function printHead(){
            print'<h1> #'.$this->getNumber().' '.$this->getLname().'</h1>';
        }
        function printPic(){
            print"<div class='imgwrapper'><img src='http://localhost/project_1/app/images/grozersmol.jpg' alt='grözer'></div><br>";
        }
        function printStats(){
            print "Nimi: ".$this->getFname()." ".$this->getLname()."<br>";
            print "Pituus: ".$this->getHeight()."<br>";
            print "Ulottuvuus: ".$this->getReach()."<br>";
            print "Pelipaikka: ".$this->getPosition()."<br>";
            
        }
    }
    $keinonen = new Player("1", "Niko", "Hienonen(C)", "183", "300", "Hakkuri/Yleispelaaja");
    $poyhonen = new Player("2", "Riku", "Pöyhönen", "180", "305", "Hakkuri/Yleispelaaja");
    $koskinen = new Player("3", "Antti", "Koskinen", "178", "285", "Yleispelaaja");
    $saviahde = new Player("7", "Jarno", "Saviahde", "189", "307", "Keskitorjuja");
    $mehto = new player("8", "Jyrki", "Mehto", "175", "345", "Passari");
    $mikkonen = new Player("9", "Ilkka", "Mikkonen(A)", "176", "350", "Passari");
    $nevalainen = new Player("10", "Ari", "Nevalainen", "180", "300", "Yleispelaaja");
    $virtanen = new Player("29", "Jasperi", "Virtanen", "200", "305", "Keskitorjuja");

    $players = array($keinonen, $poyhonen, $koskinen, $saviahde, $mehto, $mikkonen, $nevalainen, $virtanen);
?>