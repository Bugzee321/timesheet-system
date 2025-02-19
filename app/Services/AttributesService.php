<?php

namespace App\Services;

use App\Models\Attribute;
class AttributesService
{
    /**
     * Get a paginated list of attributes.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAttributesPaginated()
    {
        return Attribute::paginate(10);
    }

    /**
     * Create a new attribute.
     *
     * @param  array  $data
     * @return \App\Models\Attribute
     */
    public function createAttribute(array $data)
    {
        return Attribute::create($data);
    }

    /**
     * Update the specified attribute.
     *
     * @param  \App\Models\Attribute  $attribute
     * @param  array  $data
     * @return \App\Models\Attribute
     */
    public function updateAttribute(Attribute $attribute, array $data)
    {
        $attribute->update($data);
        return $attribute;
    }

    /**
     * Delete the specified attribute.
     *
     * @param Attribute $attribute
     * @return void
     */
    public function deleteAttribute(Attribute $attribute): void
    {
        $attribute->delete();
    }
    
}
