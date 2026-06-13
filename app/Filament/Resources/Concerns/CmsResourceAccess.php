<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;

trait CmsResourceAccess
{
    public static function shouldRegisterNavigation(): bool
    {
        return self::cmsCanAccess();
    }

    public static function canViewAny(): bool
    {
        return self::cmsCanAccess();
    }

    public static function canCreate(): bool
    {
        return self::cmsCanAccess();
    }

    public static function canView(Model $record): bool
    {
        return self::cmsCanAccess();
    }

    public static function canEdit(Model $record): bool
    {
        return self::cmsCanAccess();
    }

    public static function canDelete(Model $record): bool
    {
        return self::cmsCanAccess();
    }

    public static function canDeleteAny(): bool
    {
        return self::cmsCanAccess();
    }

    private static function cmsCanAccess(): bool
    {
        return (bool) auth()->user()?->hasAnyRole(['admin', 'cms_manager']);
    }
}
