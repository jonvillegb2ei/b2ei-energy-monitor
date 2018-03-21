<?php

namespace App\Traits;



trait TimestampedModel {


    public function getCreatedSinceAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getUpdatedSinceAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

}