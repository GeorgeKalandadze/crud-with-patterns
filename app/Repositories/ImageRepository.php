<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository implements Contracts\ImageRepositoryContract
{
    public function getAll()
    {
        return Image::all();
    }

    public function create(array $data)
    {
        return Image::create($data);
    }

    public function update(int $id, array $data)
    {
        $image = Image::findOrFail($id);
        $image->update($data);

        return $image;
    }

    public function delete(int $id)
    {
        return Image::destroy($id);
    }

    public function getById(int $id)
    {
        return Image::findOrFail($id);
    }
}
