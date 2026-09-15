# EGI Optik Indonesia - egi-optics.com

Source code for the corporate website of **PT EGI Optik Indonesia** (a defense subsidiary of
[EGI Resources](https://egiresources.com)), running on WordPress and hosted on Hostinger.

This repository follows the *code-in-Git, content-in-database* model recommended for
WordPress projects:

| Versioned here (this repo)                          | Never versioned (lives on the server)          |
| --------------------------------------------------- | ---------------------------------------------- |
| `wp-content/themes/egi-optics` - custom block theme | WordPress core                                 |
| `wp-content/plugins/egi-optics-core` - site plugin  | Third-party plugins/themes (declared in `composer.json` only) |
| `scripts/` - deploy, backup, content migrations     | `wp-content/uploads` (media)                   |
| `.github/workflows` - CI/CD                         | Database, `wp-config.php`, salts, `.env`       |
| `docs/`, `.cursor/rules` - process & standards      | Internal documents                             |

## Quick start (local development)

Requirements: Node 20+, PHP 8.2+, Composer 2, Docker Desktop (for `wp-env`).

```bash
npm install            # JS tooling (@wordpress/scripts, @wordpress/env, linters)
composer install       # PHP tooling (PHPCS + WordPress Coding Standards)
npm run env:start      # WordPress at http://localhost:8888  (admin / password)
npm run build          # build theme/plugin assets
npm run lint           # css + js + php lint
```

`wp-env` mounts the theme and plugin from this repo into a disposable WordPress container,
so you never edit files on the server directly.

## Workflow in one paragraph

Create a short-lived branch from `main` (`feat/…`, `fix/…`, `content/…`), commit with
[Conventional Commits](https://www.conventionalcommits.org), open a pull request, wait for CI
(PHP lint, PHPCS/WPCS, stylelint, eslint, build) to pass, squash-merge. Every merge to `main`
runs the deploy workflow: **backup on the server -> rsync theme & plugin -> flush caches ->
health check**. Releases are tagged `vX.Y.Z` and recorded in [CHANGELOG.md](CHANGELOG.md).

Read the details:

- [docs/GIT_WORKFLOW.md](docs/GIT_WORKFLOW.md) - branching, commits, PRs, releases
- [docs/SDLC_CICD.md](docs/SDLC_CICD.md) - environments, pipeline, quality gates, updates
- [docs/DEPLOYMENT_RUNBOOK.md](docs/DEPLOYMENT_RUNBOOK.md) - deploy, rollback, restore
- [docs/CONTENT_GUIDE.md](docs/CONTENT_GUIDE.md) - adding products, news and pages
- [CONTRIBUTING.md](CONTRIBUTING.md)

## Project structure

```
.
├── .cursor/rules/                  Cursor AI rules (git workflow, SDLC/CI-CD, WP coding standards)
├── .github/workflows/              ci.yml (quality gates) · deploy.yml (production deploy)
├── docs/                           Process documentation
├── scripts/
│   ├── server/                     backup.sh · post-deploy.sh (run on Hostinger over SSH)
│   └── content/                    Idempotent WP-CLI content migrations (wp eval-file)
├── wp-content/
│   ├── themes/egi-optics/          Block theme (theme.json, templates, parts, patterns, assets)
│   └── plugins/egi-optics-core/    Products CPT, redirects, hardening
├── .wp-env.json                    Local WordPress environment definition
├── composer.json                   PHP dev tooling + declared third-party plugins
└── package.json                    JS tooling and npm scripts
```

## License

Theme and plugin code: GPL-2.0-or-later (as required by WordPress).
Brand assets, product data and editorial content: (c) PT EGI Optik Indonesia, all rights reserved.
