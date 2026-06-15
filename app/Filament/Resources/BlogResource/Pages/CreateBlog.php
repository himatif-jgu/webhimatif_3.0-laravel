<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = BlogResource::class;
}
