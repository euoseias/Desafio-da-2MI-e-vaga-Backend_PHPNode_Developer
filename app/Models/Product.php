<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   // use HasFactory;
    protected $fillable = [
        'status',
        'imported_t',
        'product_name',
        'quantity',
        'categories',
        'cities'
        ];

        public function rules()
        {
            return  [
                'status' => 'required',
                'imported_t'  => 'required',
                'product_name'  => 'required',
                'quantity'  => 'required',
                'categories'  => 'required',
                'cities' => 'required'
            ];
       }

       public function feedback()
       {
           return [
               'required' => 'O campo :attribute é obrigatório',
           ];
       }

}
