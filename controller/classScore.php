<?php
require_once 'model/ScoreModel.php';

class Score extends ScoreModel 
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    function generation_tableauscore($nbligne){
        $score = $this->req_scoreparutil($this->id, $nbligne);
        foreach ($score as $value){
            echo '<tr>';
            foreach($value as $value2){
                echo '<td>'.$value2.'</td>';
            }
        }echo '</tr>';
    }

    function generation_top(){
        $top = $this->req_top10();
        foreach ($top as $value){
            echo '<tr>';
            foreach($value as $value2){
                echo '<td>'.$value2.'</td>';
            }
        }echo '</tr>';
    }

    function get_scoremoyen(){
        $scoremoyen = $this->req_scoremoyenparutil($this->id);
        return $scoremoyen;
    }

    function get_tempstotal(){
        $tempstotal = $this->req_tempstotal($this->id);
        return $tempstotal;
    }

}