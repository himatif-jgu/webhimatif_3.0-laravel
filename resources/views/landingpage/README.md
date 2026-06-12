# Landing Page View Structure

This folder follows a practical Atomic Design structure for Blade views.

## Layers

- `atoms`: Small reusable UI pieces with one job, such as links, logos, and simple calls to action.
- `molecules`: Small combinations of atoms, such as contact lists.
- `organisms`: Larger reusable interface blocks, such as site headers, footers, and asset bundles.
- `templates`: Page shells that define document structure, shared assets, header/footer placement, and content slots.
- `pages`: Route-level views. These should compose templates and organisms instead of owning global layout concerns.

## UX writing rules

- Use clear action labels: `Login`, `Back to Homepage`, `See More`.
- Prefer user outcomes over internal labels. Example: use `Blog` or `Latest Articles`, not `Content Module`.
- Keep navigation labels short and scannable.
- Use sentence case for helper text and empty states.
- Error messages should explain what happened and offer the next action.

## Development rules

- New public pages go in `pages`.
- Shared page chrome belongs in `templates`.
- Shared page sections belong in `organisms`.
- Do not put route logic or database access in Blade files.
- Keep admin panel work in Filament resources and pages, not in landing page views.
