<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HorseRacing extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('horse_model');
		$this->load->model('race_model');
		$this->data = new stdClass();
		//$this->output->enable_profiler(TRUE);

	}
	public function index(){
		
		$this->data->activeRaces = $this->race_model->get_races(array(
                'where' => array(
                    'in_progress' => true)
                )
            );

		$this->data->lastFiveRace = $this->race_model->get_races(array(
				'where' => array(
					'in_progress' => false
				),
				'limit' => 5
			)
		);
		
		$this->data->fastest = $this->race_model->getBestTime();
	
		$this->load->view('races', $this->data);
	}

	public function create(){
		


		$horses = ($this->horse_model->create_horses(8));
		
		$this->race_model->create_race($horses);
		redirect('/');
	}


	public function advance(){
		$this->race_model->advance_race();
		redirect('/');

	}
}
