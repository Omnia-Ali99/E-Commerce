<?php

namespace App\Repositories\Dashboard;

class AttributeValueRepository
{
    /**
     * Create a new class instance.
     */
      // public function getAttributeValues($attribute)
    // {
    //     return $attribute->attributeValues->get();
    // }
    public function createAttributeValues($attribute , $value)
    {
        return $attribute->attributeValues()->create([
            'value'=>$value,
        ]);
    }
    // public function updateAttributeValues($attribute_obj, $key , $value)
    // {
    //      return $attribute_obj->attributeValues()->updateOrCreate(['id'=>$key],['value'=>$value]);
    // }
    public function deleteAttributeValues($attribute_obj)
    {
        return $attribute_obj->attributeValues()->delete();
    }

}
