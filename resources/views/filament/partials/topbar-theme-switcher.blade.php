@if (filament()->hasDarkMode() && (! filament()->hasDarkModeForced()))
    <style>
        .himatif-topbar-theme {
            display: flex;
            align-items: center;
            margin-left: 8px;
        }

        .himatif-topbar-theme__group {
            display: inline-flex;
            gap: 2px;
            padding: 3px;
            border: 1px solid rgba(148, 163, 184, 0.22);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.88);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .dark .himatif-topbar-theme__group {
            border-color: rgba(148, 163, 184, 0.18);
            background: rgba(15, 23, 42, 0.78);
        }

        .himatif-topbar-theme__button {
            display: grid;
            width: 32px;
            height: 32px;
            place-items: center;
            border-radius: 999px;
            color: rgb(100, 116, 139);
            transition: color 150ms ease, background-color 150ms ease;
        }

        .himatif-topbar-theme__button:hover,
        .himatif-topbar-theme__button.is-active {
            background: #f59e0b;
            color: #111827;
        }

        .dark .himatif-topbar-theme__button {
            color: rgb(203, 213, 225);
        }
    </style>

    <div
        class="himatif-topbar-theme"
        x-data="{ theme: localStorage.getItem('theme') || @js(filament()->getDefaultThemeMode()->value) }"
        x-init="$watch('theme', value => $dispatch('theme-changed', value))"
        aria-label="Theme switcher"
    >
        <div class="himatif-topbar-theme__group">
            <button
                type="button"
                class="himatif-topbar-theme__button"
                x-bind:class="{ 'is-active': theme === 'light' }"
                x-on:click="theme = 'light'"
                aria-label="Light mode"
            >
                {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::Sun, alias: \Filament\View\PanelsIconAlias::THEME_SWITCHER_LIGHT_BUTTON) }}
            </button>

            <button
                type="button"
                class="himatif-topbar-theme__button"
                x-bind:class="{ 'is-active': theme === 'dark' }"
                x-on:click="theme = 'dark'"
                aria-label="Dark mode"
            >
                {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::Moon, alias: \Filament\View\PanelsIconAlias::THEME_SWITCHER_DARK_BUTTON) }}
            </button>

            <button
                type="button"
                class="himatif-topbar-theme__button"
                x-bind:class="{ 'is-active': theme === 'system' }"
                x-on:click="theme = 'system'"
                aria-label="System theme"
            >
                {{ \Filament\Support\generate_icon_html(\Filament\Support\Icons\Heroicon::ComputerDesktop, alias: \Filament\View\PanelsIconAlias::THEME_SWITCHER_SYSTEM_BUTTON) }}
            </button>
        </div>
    </div>
@endif
