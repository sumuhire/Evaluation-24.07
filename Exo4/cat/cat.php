<?php

class Cat{

    /*
    * Properties
    */

    private $firstName;
    private $age;
    private $color;
    private $sex;
    private $race;

    /*
    * Methods
    */
         /*
        * Constructor
        */

        public function __construct(string $name)
        {

            /*
            * if the input is a string and comprised between 3
            * and 20 included.
            */

            if(strlen($name)>2 && strlen($name)<21){

            $this->firstName = $name;
            
            }
        }

        /*
        * Setter/Getter
        */

        public function setFirstName(string $name)
        {

            /*
            * if the input is a string and comprised between 3
            * and 20 included.
            */

            if(strlen($name)>2 && strlen($name)<21)
            {

                $this->firstName = $name;
                
            }
        }

        public function getFirstName() : string
        {
            return $this->firstName;
        }
        
        //

        public function setAge(int $age)
        {
            $this->age = $age;

        }

        public function getAge() : int
        {
            return $this->age;
        }

        //

        public function setColor(string $colour)
        {
            /*
            * if the input is a string and comprised between 3
            * and 10 included.
            */

            if(strlen($colour)>2 && strlen($colour)<11)
            {

                $this->color = $colour;
                
            }
        
        }

        public function getColor() : string
        {
            return $this->color;
        }

        //

        public function setRace(string $catRace)
        {

            /*
            * if the input is a string and comprised between 3
            * and 20 included.
            */

            if(strlen($catRace)>2 && strlen($catRace)<21)
            {

                $this->race = $catRace;
                
            }
        }

        public function getRace() : string
        {
            return $this->race;
        }

        //

        public function setSex(string $gender)
        {

            /*
            * To limit the choice to male or female
            */

            if(strtolower($gender) == 'male')
            {

                $this->sex = 'male';
                
            }elseif(strtolower($gender) == 'female'){

                $this->sex = 'female';

            }else{

                $this->sex='Error gender';

            }
        }

        public function getSex() : string
        {
            return $this->sex;
        }

}

?>