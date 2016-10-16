<?php
class Article extends Eloquent {

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function category()
    {
        return $this->belongsTo('Category','category_id');
    }

}