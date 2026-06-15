<?php

namespace App\Filament\Resources\BlogCategoryResource\Pages;

use App\Filament\Resources\BlogCategoryResource;
use App\Filament\Resources\Pages\Concerns\RedirectsToResourceIndex;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogCategory extends CreateRecord
{
    use RedirectsToResourceIndex;

    protected static string $resource = BlogCategoryResource::class;
}
