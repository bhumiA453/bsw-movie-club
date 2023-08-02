<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movie';

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['m_name', 'm_image','thumbnail', 'date', 'time', 'venue','trailer_url','trailer_id','genres','cast','city','preview_url','is_active'];

    public function getDetails()
    {
         return $data = $this->get();
        // echo '<pre>';print_r($data);exit();
    }
}
