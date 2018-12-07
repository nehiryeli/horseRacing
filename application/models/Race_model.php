<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Race_model extends CI_Model {


    public $data;
        public $trackLength = 1500; // meters 
        public $advanceTime = 10; //seconds
        public $raceLimit = 3; // concurrent race limit


        public function __construct()
        {
            parent::__construct();
            $this->data = new stdClass();
            $this->load->database();

        }

        public function advance_race(){
            $races = $this->get_races(array(
                'where' => array(
                    'in_progress' => true)
                )
            );

            foreach ($races as $race) {
                $advanceTime = $this->advanceTime;
                foreach ($race->horses as $horse) {
                    if ($horse->speedWithJokey * $advanceTime + $horse->distance > $this->trackLength){ //if passas finish line shorter than 10 seconds
                        $advanceTime = ($this->trackLength - $horse->distance)/$horse->speedWithJokey;
                        $race->in_progress = 0;
                      
                    }
                    

                }
                foreach ($race->horses as $horse) {
                    $horse->distance += $horse->speedWithJokey * $advanceTime;

                }
                $race->time += $advanceTime;
              
                
            }

            $this->update_races($races);

            return $this->get_races(array(
                'where' => array(
                    'in_progress' => true)
                )
            );

            


        }

        public function create_race($horses){
            $count = $this->get_races(array(
                 'where' => array(
                    'in_progress' => true
                ),
                'count' => true)
            );

            if($count>=3){
                die ("Reached to race limit");
            }
            $data = array(
                'time' => 0,
                'winner' => NULL,
                'horses' => json_encode($horses),
                'in_progress' => 1
            );

            
            $this->db->insert('races', $data);


        }

        public function update_races($races){
            foreach ($races as $race) {
                $race->horses = json_encode($race->horses);

                $this->db
                ->where('race_id', $race->race_id)
                ->update('races', $race);
            }
            
            
        }

        public function get_races($param = null){
            if(isset($param['where'])){
                $this->db->where($param['where']);

            }
            $this->db
            ->from('races');

            if(isset($param['count']))
            {
                return $this->db->count_all_results();

            }
            if(isset($param['limit'])){
                $this->db->limit($param['limit']);
            }

            $races =  $this->db->get()->result();


            foreach ($races as $race) {
                $race->horses = json_decode($race->horses);
                usort($race->horses, array($this, "sort_distance")); 

                foreach ($race->horses as $horse) {
                    //$horse->distance += $horse->speedWithJokey * $this->advanceTime;

                }
                
            }
            return $races;
        }

        public function sort_distance($a, $b){
            if($a->distance == $b->distance){ return 0 ; }
            return ($a->distance < $b->distance) ? 1 : -1;
        }






    }