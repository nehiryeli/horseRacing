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

        public function insert_horses_db($horses){
                $horse_ids = array();
                foreach ($horses as $horse) {
                        $this->db->insert(
                            'horses', $horse
                    );
                        $horse_ids[] = $this->db->insert_id();
                }
                return $horse_ids;
        }


        public function create_horses(int $num){
                $this->data->horses =  array();

                for($i=1; $i<=$num; $i++){
                        $horse = new stdClass();
                        $horse->no = $i;
                        $horse->strength = rand(10,100)/10;
                        $horse->speed = $this->baseSpeed + rand(10,100)/10;
                        $horse->speedWithJokey = number_format($horse->speed - $this->jokeyEffect * (1-($horse->strength *8/100)),2);
                        $horse->endurance = rand(10,100)/10;
                        $horse->enduranceMeters = number_format(($horse->endurance * 100),0,'','');
                        $horse->distance = 0;
                        $this->data->horses[] = $horse;
                       
                }
                return $this->data->horses;
               // return $this->insert_horses_db($this->data->horses);

        }





}