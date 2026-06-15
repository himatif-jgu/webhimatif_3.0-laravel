<style>
    .himatif-brand-title {
        display: grid;
        gap: 1px;
        margin-left: 10px;
        min-width: 0;
        line-height: 1.1;
    }

    .himatif-brand-title__name {
        color: rgb(15, 23, 42);
        font-size: 15px;
        font-weight: 900;
        letter-spacing: 0;
        white-space: nowrap;
    }

    .himatif-brand-title__meta {
        color: rgb(100, 116, 139);
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .dark .himatif-brand-title__name {
        color: rgb(248, 250, 252);
    }

    .dark .himatif-brand-title__meta {
        color: rgb(148, 163, 184);
    }

    .fi-sidebar:not(.fi-sidebar-open) .himatif-brand-title {
        display: none;
    }

    @media (max-width: 640px) {
        .himatif-brand-title__meta {
            display: none;
        }
    }
</style>

<div class="himatif-brand-title">
    <span class="himatif-brand-title__name">HIMATIF App</span>
    <span class="himatif-brand-title__meta">Internal Portal</span>
</div>
