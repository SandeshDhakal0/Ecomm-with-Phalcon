<?php

class Project extends BaseModel
{
    public function initialize()
    {
        // local field, reference Model, reference field
        $this->belongsTo('user_id', 'User', 'id');
    }
}
