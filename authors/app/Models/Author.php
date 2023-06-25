<?php

    namespace App\Models;
    use Illuminate\Database\Eloquent\Model;

    class Author extends Model{
        protected $table = 'tblauthors';
        protected $fillable = [
            'fullname','gender','birthday'
        ];

        public $timestamps = false;
        protected $primaryKey = 'id';
    }

