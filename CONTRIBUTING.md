# Contributing

Thanks for helping maintain egi-optics.com. The short version:

1. **Set up**: `composer install && npm install && npm run env:start` (Docker required).
   WordPress runs at http://localhost:8888 (`admin` / `password`). `npm run env:seed` adds demo content.
2. **Branch** from `main`: `feat/<topic>`, `fix/<topic>`, `content/<topic>`, `chore/<topic>`.
3. **Develop** only in `wp-content/themes/egi-optics`, `wp-content/plugins/egi-optics-core` and
   `scripts/`. Follow `.cursor/rules/wordpress-development.mdc` (WordPress Coding Standards).
4. **Check** before pushing: `npm run lint` (CSS, JS, PHP) and `npm run validate` (JSON).
   `npm run format` / `npm run format:php` fix most style issues automatically.
5. **Commit** with Conventional Commits, e.g. `feat(theme): add downloads pattern`.
6. **Open a PR** using the template; attach desktop (1440px) and mobile (390px) screenshots for any
   visual change. CI must be green. Squash-merge.
7. **Release**: bump `Version:` in the theme and plugin headers, add a `CHANGELOG.md` entry, tag `vX.Y.Z`.

Merging to `main` deploys to production automatically (backup first). If a deploy run fails, follow
`docs/DEPLOYMENT_RUNBOOK.md`.

Never commit secrets, database dumps, uploads, WordPress core or third-party plugins. The `assets/`
folder is intentionally ignored: it holds internal documents and source media.

Full details: `docs/GIT_WORKFLOW.md`, `docs/SDLC_CICD.md`, `docs/CONTENT_GUIDE.md`.
