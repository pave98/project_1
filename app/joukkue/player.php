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
            print'<h1 class="introH1"> #'.$this->getNumber().' '.$this->getLname().'</h1>';
        }
        function printPic(){
            print"<div class='imgwrapper'><img src='/project_1/app/images/grozersmol.jpg' alt='grözer'></div>";
        }
        function printStats(){
            print "<p class='stats'>";
            print "Nimi: ".$this->getFname()." ".$this->getLname()."<br>";
            print "Pituus: ".$this->getHeight()."<br>";
            print "Ulottuvuus: ".$this->getReach()."<br>";
            print "Pelipaikka: ".$this->getPosition()."<br>";
            print "</p>";
            
        }
    }
    $grozer = new Player("1", "Györg", "Grözer(C)", "183", "300", "Hakkuri/Yleispelaaja");
    $fromm = new Player("2", "Christian", "Fromm", "180", "305", "Hakkuri/Yleispelaaja");
    $schott = new Player("3", "Ruben", "Schott", "178", "285", "Yleispelaaja");
    $bohme = new Player("7", "Marcus", "Böhme", "189", "307", "Keskitorjuja");
    $kampa = new player("8", "Lukas", "Kampa", "175", "345", "Passari");
    $zimmer = new Player("9", "Jan", "Zimmer(A)", "176", "350", "Passari");
    $kaliberda = new Player("10", "Denys", "Kaliberda", "180", "300", "Yleispelaaja");
    $krick = new Player("29", "Tobias", "Krick", "200", "305", "Keskitorjuja");
    $zenger = new Player("32", "Julian", "Zenger", "174", "250", "Libero");

    $players = array($grozer, $fromm, $schott, $bohme, $kampa, $zimmer, $kaliberda, $krick, $zenger);
?>