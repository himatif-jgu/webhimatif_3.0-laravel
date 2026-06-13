<?php

namespace App\Filament\Resources\Concerns;

use Illuminate\Database\Eloquent\Model;

trait AdminOnlyResourceAccess
{
    public static function shouldRegisterNavigation(): bool
    {
        return self::adminCanAccess();
    }

    public static function canViewAny(): bool
    {
        return self::adminCanAccess();
    }

    public static function canCreate(): bool
    {
        return self::adminCanAccess();
    }

    public static function canView(Model $record): bool
    {
        return self::adminCanAccess();
    }

    public static function canEdit(Model $record): bool
    {
        return self::adminCanAccess();
    }

    public static function canDelete(Model $record): bool
    {
        return self::adminCanAccess();
    }

    public static function canDeleteAny(): bool
    {
        return self::adminCanAccess();
    }

    private static function adminCanAccess(): bool
    {
        return (bool) auth()->user()?->isAdmin();
    }
}
