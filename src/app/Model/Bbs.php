<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bbs extends Model
{
    //
    protected $primaryKey = 'article_id';
    protected $fillable = ['article_id', 'github_id', 'favorite_github_id', 'contents'];
}
