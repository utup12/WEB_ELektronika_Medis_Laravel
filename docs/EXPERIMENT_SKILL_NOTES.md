# Experiment: agent skills applied to the website

Branch: `experiment-skill` (also merged into `deployment/vercel` for preview).
Nothing here is on `main` until it is approved.

## Skills installed

| Skill | Source | Used for |
| --- | --- | --- |
| `frontend-design` | anthropics/skills | Quality floor for UI: keyboard focus, reduced motion, restraint |
| `web-design-guidelines` | vercel-labs/agent-skills | Review of markup against Web Interface Guidelines |
| `vercel-react-best-practices` | vercel-labs/agent-skills | React/Inertia performance rules (no React pages changed yet) |
| `laravel-best-practices` | AsyrafHussin/agent-skills | Controller / validation / Eloquent structure |
| `laravel-owasp-security` | AsyrafHussin/agent-skills | OWASP Top 10 audit of the Laravel app |
| `laravel-inertia-react` | AsyrafHussin/agent-skills | Inertia page conventions |
| `laravel-database-optimization` | AsyrafHussin/agent-skills | Query and write patterns |

## Changes

### Security (OWASP audit)
- **A01 Broken access control**: a lecturer could attach students, announcements and
  attendance sessions to *another lecturer's* classroom by posting its id. Classroom ids are
  now validated against the signed-in lecturer. Lecturer pages only list their own data.
- **A07 Authentication failures**: dedicated rate limiters for the local login/registration
  (`local-login`, `local-register`) and for attendance-code guesses (`attendance-code`).
  A role mismatch at login now invalidates the session instead of only logging out.
- **A05 Misconfiguration**: new `SecurityHeaders` middleware (`X-Content-Type-Options`,
  `X-Frame-Options`, `Referrer-Policy`, `Permissions-Policy`, HSTS in production).
  `bluetooth=(self)` is kept so the smartwatch pilot (Web Bluetooth) still works.
- **A02/A04 Data exposure**: uploaded report PDFs are stored on the private `local` disk and
  served only by the authorised download route. Older files on the `public` disk still download.
- `env()` calls outside config replaced by `config('services.reports.drive_folder_url')`
  so `php artisan config:cache` keeps working.

### Backend quality
- `LecturerManagementController` and `LocalAuthController` rewritten from one-line methods to
  readable code; attendance publishing is wrapped in a transaction; roster status values are
  validated; trainer-kit page no longer performs eight writes per GET.
- **Bug fix**: the lecturer attendance form never submitted the 50-student roster because the
  inputs referenced `form="attendance-form"` but the form had no such `id`.
- `attendance_sessions.code` is `varchar(12)`; validation now matches (was `max:40`).

### Front-end
- New shared `public/css/a11y.css`: visible `:focus-visible` ring, skip link, reduced-motion,
  `touch-action: manipulation`, balanced headings, tabular numbers.
- Skip link + `<main id="main-content">` on every page shell; meta description, theme-color and
  icons in the shared layout.
- Form fields: `autocomplete`, `spellcheck`, `maxlength`, accessible names on lecturer forms.

## Tests
`tests/Feature/SecurityHardeningTest.php` (8 tests). The suite had 28 failing tests before this
branch (missing Vite build, legacy starter-kit routes); the same 28 fail after, with no new ones.

## Not changed (suggestions)
- Content-Security-Policy: pages use inline scripts, so a nonce-based CSP needs a separate pass.
- `/monitor-trainer` and `/asisten-ai` are public by design; confirm that is intended.
- Password rule is `min:8`; production `Password::defaults()` requires 12 chars with symbols.
