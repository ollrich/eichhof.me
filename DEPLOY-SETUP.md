# Deployment Setup

## Webhook Secret Configuration

The deploy script requires a webhook secret file for security.

### Server Setup

1. Create the secret file on your server:
```bash
echo "YOUR_NEW_SECRET_HERE" > .webhook-secret
chmod 600 .webhook-secret
```

2. Generate a new secure secret:
```bash
openssl rand -hex 32
```

3. Update the GitHub webhook settings with the new secret:
   - Go to: https://github.com/ollrich/eichhof.me/settings/hooks
   - Edit the webhook
   - Update the "Secret" field with your new secret
   - Save changes

### Security Notes

- **NEVER** commit `.webhook-secret` to the repository
- The file is already in `.gitignore`
- Change the secret immediately if it's ever exposed
- Use a strong random secret (at least 32 bytes)

## Deploy Script

The `deploy.php` script automatically pulls changes when GitHub sends a webhook after each push to the `main` branch.

### Testing the Webhook

After setup, push a commit to test the webhook. Check `.deploy-log.txt` on the server for deployment logs.
