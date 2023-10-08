<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RadiologyService extends Model
{
    public static function createModel(array $data)
    {
        $instance= new RadiologyService();
        $instance->name = $data['name'];
        $instance->view = $data['view'];
        $instance->price = $data['price'];
        return $instance->save();
    }

    public static function updateModel(array $data, $id)
    {
        $instance= RadiologyService::find($id);
        $instance->name = $data['name'];
        $instance->view = $data['view'];
        $instance->price = $data['price'];
        return $instance->update();
    }
}
