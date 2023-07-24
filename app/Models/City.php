<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'city';

     /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = ['name', 'c_id'];

    public function getDetails()
    {
         return $data = $this->get();
        // echo '<pre>';print_r($data);exit();
    }

    public function getEncodeID($name)
    {
        $c_id = City::select('c_id')->where('name',$name)->get();
        $c_id = $c_id->toArray();
        return $c_id[0]['c_id'];
    }
}
