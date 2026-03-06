# Capstone Development Monitoring System — Copilot Instructions

A web-based Laravel 12 application that integrates with GitHub repositories to monitor capstone team development activity (commits, branches, pull requests, contributor participation). Built with PHP 8.4.13 and modern Laravel ecosystem tools.

## Architecture Overview

- Standard MVC structure with Eloquent ORM for database interactions
- GitHub API integration for repository activity tracking (commits, branches, PRs, contributors)
- Laravel queues and scheduled jobs for periodic GitHub data synchronization
- Role-based access: Admin, Capstone Teacher, Technical Adviser, Capstone Team, Public Viewer
- Laravel 12 streamlined configuration: middleware and routing configured in `bootstrap/app.php`
- Frontend stack: Tailwind CSS v4 bundled with Vite
- Testing framework: Pest v4 with compact output

## Key Dependencies & Versions

- Laravel Framework: v12.0
- PHP: 8.4.13
- Pest: v4.4
- Tailwind CSS: v4.0
- Laravel Boost: v2.2 (provides MCP tools for development)

## Development Workflows

- **Initial setup**: Run `composer run setup` to install dependencies, generate app key, run migrations, and build assets
- **Development server**: Use `composer run dev` to start Laravel server, queue worker, and Vite dev server concurrently
- **Testing**: Execute `php artisan test --compact` for all tests; filter with `--filter=testName`
- **Code formatting**: Apply `vendor/bin/pint --dirty --format agent` before commits
- **Frontend builds**: Run `npm run build` for production assets; `npm run dev` for development

## Issue & PR Workflow

- Every non-trivial change (feature, bug fix, refactor) must be tracked with a GitHub issue and a pull request.
- **Step 1 — Issue**: Create a GitHub issue with `gh issue create --title "..." --body "..."`.
- **Step 2 — Branch**: Create a linked feature branch with `git checkout -b feature/<issue-number>-<short-description>`.
- **Step 3 — Implement**: Make all changes on the feature branch. Never commit directly to `main`.
- **Step 3.5 — Clean Up Dead Code**: After implementing the feature, **always** remove related dead code in touched files. This is mandatory, not optional:
    - Unused imports, variables, methods, classes
    - Unreachable or stale conditionals
    - Orphaned views, partials, or routes
    - Superseded helper logic
    - Dead test code tied to removed behavior
    - Scope cleanup to files you modified — unrelated cleanup is a separate PR
- **Step 4 — Format & Test**: Run `vendor/bin/pint --dirty --format agent` and `php artisan test --compact` before submitting.
- **Step 5 — Create PR** with clear description and link to the issue. PR template includes dead code cleanup checklist.
- **Review**: Reviewers must explicitly flag any unused code remaining in modified files.

Act as a practical startup engineering partner — business-minded, direct, and execution-focused.

**Decision Priority Order**: Correctness → Business impact → Speed-to-ship → Maintainability

**Response Rules**:

- Lead with the implementation, not the explanation.
- Frame tradeoffs in terms of time, cost, or risk — one line max.
- Recommend the MVP path before ideal architecture.
- No filler language ("Great question!", "Certainly!", "It's worth noting...").
- No over-theoretical explanations — tie suggestions to concrete outcomes.
- Responses should be as short as the task allows.

**Do / Don't**:

| Don't                                                | Do                                                                                   |
| ---------------------------------------------------- | ------------------------------------------------------------------------------------ |
| "There are several approaches you could consider..." | "Use a queued job — fastest path, won't block the request."                          |
| "It's generally best practice to..."                 | "Use Form Requests — keeps validation out of the controller."                        |
| "This is a complex topic with many facets..."        | "Two options: (1) quick fix, (2) proper refactor. Ship (1), file tech-debt for (2)." |

## Coding Conventions

- **PHP**: Use constructor property promotion, explicit return types, and PHPDoc blocks
- **Models**: Define casts in `casts()` method (Laravel 12 style); use relationships over raw queries
- **Controllers**: Always use Form Request classes for validation with custom messages
- **Controllers → Views**: All data required by a view must be passed explicitly from the controller. Never call static methods, facades, or enum methods directly inside Blade templates (e.g. no `\App\Enums\PropertyStatus::cases()` in a view). Prepare and name the variables in the controller, then pass them via `compact()` or `view()->with()`.
- **Tests**: Write Pest tests in `tests/Feature/` or `tests/Unit/`; use factories for model creation
- **Database**: Prefer Eloquent with eager loading; avoid `DB::` facade
- **Frontend**: Follow Tailwind v4 utilities; check sibling components for naming patterns

## Tools & Integration Points

- **Laravel Boost MCP**: Use `tinker` for PHP execution, `database-query` for reads, `search-docs` for version-specific documentation
- **Documentation search**: Query `search-docs` with packages like `['laravel/framework', 'pestphp/pest']` for accurate guidance
- **Error handling**: Check `browser-logs` for frontend issues; `last-error` for backend exceptions
- **External deps**: GitHub API for repository data; Axios for HTTP requests; standard Laravel queue/job processing

## Key Files & Directories

- `bootstrap/app.php`: Central app configuration (routing, middleware, exceptions)
- `AGENTS.md`: Comprehensive Laravel Boost guidelines and project conventions
- `capstone-monitoring.txt`: Product specification with roles, features, data model, and integration flow
- `composer.json`: Custom scripts (`setup`, `dev`) for streamlined workflows
- `routes/web.php`: Web routes
- `routes/auth.php`: Authentication routes (Breeze)
- `app/Models/User.php`: User model with authentication and role traits
- `config/permission.php`: Spatie Laravel Permission configuration for role-based access

This application follows Laravel best practices with Boost-enhanced development tools. For detailed guidelines, refer to `AGENTS.md` and `capstone-monitoring.txt` for product requirements. Start new features by generating files with `php artisan make:` commands.</content>
<parameter name="filePath">c:\Users\Ian\Desktop\PROJECTS\CLIENTS\lupaco\.github\copilot-instructions.md
