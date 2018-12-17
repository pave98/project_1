<?php 
/*This is a simple class to create the player profiles for the 'team'-tab. Each player has their own object with
stats. The problem with this approach is that new players can only be added by using the code same as deleting 
some of the current ones. The client of this project happily said that this won't be a problem.*/

    
    
    class Player{
        private $id;
        private $number;
        private $fname;
        private $lname;
        private $height;
        private $reach;
        private $position;
        private $funnyline;
        
        function __construct($id, $number, $fname, $lname, $height, $reach, $position){
            $this->setId($id);
            $this->setNumber($number);
            $this->setFname($fname);
            $this->setLname($lname);
            $this->setHeight($height);
            $this->setReach($reach);
            $this->setPosition($position);
        }
        function setId($id) {
            $this->id = $id;
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
        function getId() {
            return $this->id;
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
        function printPlayer(){
            print'<h1 class="introH1"> #'.$this->getNumber().' '.$this->getLname().'</h1>';
            print"<div class='imgwrapper'><img src='/project_1/app/images/players/".$this->id.".jpg' alt='player image'></div>";
            print "<p class='stats'>";
            print "Nimi: ".$this->getFname()." ".$this->getLname()."<br>";
            print "Pituus: ".$this->getHeight()."<br>";
            print "Ulottuvuus: ".$this->getReach()."<br>";
            print "Pelipaikka: ".$this->getPosition()."<br>";
            print "</p>";
            
        }
    }

    include_once '../functions.php';
    $players = array();
    

    $query = "SELECT * FROM players";
    $result = mysqli_query($db, $query);
    $num = 1;
    while($row = mysqli_fetch_assoc($result)) {
        
        $player = new Player($row['player_id'], $row['player_number'], $row['player_fname'], $row['player_lname'], $row['height'], $row['reach'], $row['player_position']);
        array_push($players, $player);
        $num++;
    }
    
?>