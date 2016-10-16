<?php
class Category extends Eloquent {

    public function classrooms()
    {
        return $this->hasMany('Classroom');
    }
}