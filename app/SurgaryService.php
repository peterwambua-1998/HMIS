<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurgaryService extends Model
{
    public static function createModel(array $data)
    {
        $instance = new SurgaryService;
        $instance->name = $data['name'];
        $instance->price = $data['price'];
        $instance->description = $data['description'];
        $instance->category = $data['category'];
        return $instance->save();
    }

    public static function updateModel(array $data, $id)
    {
        $instance = SurgaryService::find($id);
        $instance->name = $data['name'];
        $instance->price = $data['price'];
        $instance->description = $data['description'];
        $instance->category = $data['category'];
        return $instance->update();
    }
}
