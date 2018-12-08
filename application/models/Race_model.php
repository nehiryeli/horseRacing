<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Race_model extends CI_Model {


    public $data;
        public $trackLength = 1500; // meters 
        public $advanceTime = 10; //seconds
        public $raceLimit = 3; // concurrent race limit
        public $horsesAtFinish = 0;
        public $horseSpeed = 0;

        public function __construct()
        {
            parent::__construct();
            $this->data = new stdClass();
            $this->load->database();

        }

        public function advance_race(){
            $races = $this->get_races(
                array(
                    'where' => array(
                        'in_progress' => true)
                )
            );

            foreach ($races as $race) { // loop  all active races
                foreach ($race->horses as $horse) { // loop all horses for all active races
                   
                    (!isset($horse->raceCompleteTiming)) ? $horse->raceCompleteTiming = 0: $horse->raceCompleteTiming; // init timing 0 for start
                    for ($i = 0; $i < $this->advanceTime; $i++) { // advence race for spefied time
                        if($horse->distance < $this->trackLength){ // if horse is not already at finish line
                            if($horse->enduranceMeters > $horse->speed){ //check horse if it has enough endurance
                                $horse->enduranceMeters -= $horse->speed; 
                               $horseRealSpeed = $horse->speed;
                            }else{ // horse hasn't enough endurance, jokey weight will apply 
                            $horseRealSpeed = $horse->speedWithJokey; 
                        } 
                        //$horse->distance += $horseRealSpeed;
                        //$horse->raceCompleteTiming += 1; 
                            if($horse->distance+$horseRealSpeed >= $this->trackLength){ //check again if horse arrives at finish line
                                $finishLineTime = ($horse->distance + $horseRealSpeed - $this->trackLength)/$horseRealSpeed; // its lesser than a second so lets calculate it
                                $horse->distance = $this->trackLength;
                                $horse->raceCompleteTiming += $finishLineTime;
                                $race->horsesAtFinish ++;
                                if($race->horsesAtFinish == 8){ // better to get this from var
                                    $this->advanceTime = $finishLineTime; // it's lesser than advanceTime 
                            
                                  
                                }
                            }else{ // not arrived to finish line yet
                                $horse->distance += $horseRealSpeed;
                                $horse->raceCompleteTiming += 1; // advance by 1 sec
                            }
                        }
                    }
                }
                $race->time += $this->advanceTime; // advance time 
                if($race->horsesAtFinish == 8){ //check if all horses at finish line
                 
                    $race->in_progress = 0;
                }
            }
            $this->update_races($races);
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

        public function getBestTime(){
            $races =  $this->get_races(array(
                'where' => array(
                    'in_progress' => false)
            )
        );
            if ($races) {
                $fastest = $races[0]->horses[0];
                foreach ($races as $race) {
                    foreach ($race->horses as $horse) {
                        if($horse->raceCompleteTiming < $fastest->raceCompleteTiming)
                            $fastest = $horse;
                    }
                    
                }
                return $fastest;
            }
            
        }

        public function sort_distance($a, $b){
            if($a->distance == $b->distance){ return 0 ; }
            return ($a->distance < $b->distance) ? 1 : -1;
        }






    }