<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Horse{
        public $str;
        public $speed;
        public $endurance;

 
}
class Horse_model extends CI_Model {

       
        public $data;
        public $baseSpeed = 5; // horse's base speed (m/s) 
        public $jokeyEffect = 5; // slows down 5 (m/s)

         public function __construct()
        {
                parent::__construct();
                $this->data = new stdClass();
        }
      


        public function create_horses(int $num){
                $this->data->horses =  array();
               
                for($i=0;$i<$num;$i++){
                        $horse = new stdClass();
                        $horse->strength = rand(10,100)/10;
                        $horse->speed = $this->baseSpeed + rand(10,100)/10;
                        $horse->speedWithJokey = $horse->speed - $this->jokeyEffect * (1-($horse->strength *8/100));
                        $horse->endurance = rand(10,100)/10;
                        $this->data->horses[] = $horse;
                }
                return $this->data;
        }

        public function get_last_ten_entries()
        {
                $query = $this->db->get('entries', 10);
                return $query->result();
        }

       

}