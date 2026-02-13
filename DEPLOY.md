# Deployment Configuration

Use these details when setting up your project on Vercel.

## Vercel Environment Variables

Go to **Settings** > **Environment Variables** in your Vercel project and add:

| Key | Value |
|-----|-------|
| `DB_HOST` | `gateway01.ap-southeast-1.prod.aws.tidbcloud.com` |
| `DB_PORT` | `4000` |
| `DB_USER` | `4FDYwDoq6pG4qAh.root` |
| `DB_PASSWORD` | *(Paste your actual password here)* |
| `DB_NAME` | `test` |
| `DB_SSL_CA` | `/etc/pki/tls/certs/ca-bundle.crt` |

> Note: Vercel's PHP runtime usually has standard CA bundles. If connection fails, try leaving `DB_SSL_CA` empty or use `isrgrootx1.pem` if you include it in repo.

## Initial Database Setup

1. Open `c:\xampp\htdocs\lms\setup_remote_db.php` in your code editor.
2. Replace `'YOUR_PASSWORD_HERE'` with your actual TiDB password.
3. Open `http://localhost/lms/setup_remote_db.php` in your browser.
4. This will create the required tables in your remote cloud database.
5. Once confirmed, **delete** `setup_remote_db.php` before deploying for security.

## Deploying

1. Push your code to GitHub.
2. Import repo to Vercel.
3. Add the Environment Variables above.
4. Deploy!
