# Ibanint

Classic WordPress theme for ibanint.com, deployed to Namecheap shared hosting via GitHub Actions (FTPS).

## What is tracked

Only these paths are versioned:

- `wp-content/themes/ibanint/` - the theme
- `.github/workflows/deploy-cpanel.yml` - deploy pipeline
- `.gitignore`
- `README.md`

WordPress core, `wp-config.php`, uploads and the local database are ignored on purpose.

## Local development

- Herd site: `https://ibanint.test`
- Database: SQLite at `wp-content/database/.ht.sqlite` (plugin: `sqlite-database-integration`)
- Theme is activated; pages are seeded on theme activation

## Deploy

Push to `main` and the workflow lints every PHP file, then FTPS-syncs the theme folder to:

```
/home/cpanelid/ibanint/wp-content/themes/ibanint/
```

### Required repository secrets

| Secret | Value |
| --- | --- |
| `FTP_SERVER` | Namecheap FTP host |
| `FTP_USERNAME` | cPanel FTP user |
| `FTP_PASSWORD` | cPanel FTP password |

The FTP account is jailed to the website folder `/home/cpanelid/ibanint` (not `public_html`), so the workflow `server-dir` is `./wp-content/themes/ibanint/` relative to that login root.

### First deploy on a new server

1. Upload WordPress core and `wp-config.php` (MySQL) manually once.
2. Push this repo so the theme lands in `wp-content/themes/ibanint/`.
3. Activate the theme in wp-admin.
4. If pages are missing, click **Create pages now** in the dashboard notice, then save Settings > Permalinks once.
