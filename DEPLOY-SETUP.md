# Deployment Setup

*[Deutsch](#deployment-setup-de) | [Dansk](#deployment-setup-da)*

This project uses a PHP-based auto-deployment triggered by GitHub webhooks, plus an optional screenshot generation service.

## Webhook Secret

The `deploy.php` script validates incoming requests using HMAC signatures. Both the server and GitHub must share the same secret.

**Server setup:**
```bash
# Generate a secure secret
openssl rand -hex 32

# Save it (not in the repo!)
echo "YOUR_SECRET" > .webhook-secret
chmod 600 .webhook-secret
```

**GitHub setup:**
Repository → Settings → Webhooks → Add/Edit webhook → Enter the same secret in the "Secret" field.

**Security:** The `.webhook-secret` file is gitignored. Change immediately if exposed.

## Contact Form Config

For the contact form backend (`contact.php`):

```bash
echo '{"recipient_email":"you@example.com","from_email":"noreply@example.com"}' > .contact-config.json
chmod 644 .contact-config.json
```

Replace with your actual email addresses. The file is gitignored.

## APIFlash Key (Optional)

For link preview screenshots via `update-previews.php`:

```bash
echo "YOUR_API_KEY" > images/hover/.apiflash-key
chmod 600 images/hover/.apiflash-key
```

Get a key at [apiflash.com](https://apiflash.com/). The file is gitignored.

## How It Works

1. Push to `main` → GitHub sends POST to `deploy.php`
2. Script validates signature against `.webhook-secret`
3. If valid: `git pull` is executed
4. Logs written to `.deploy-log.txt`

---

<a name="deployment-setup-de"></a>
# Deployment-Einrichtung

*[English](#deployment-setup) | [Dansk](#deployment-setup-da)*

Dieses Projekt nutzt PHP-basiertes Auto-Deployment via GitHub-Webhooks, plus optionale Screenshot-Generierung.

## Webhook-Secret

Das `deploy.php`-Script validiert eingehende Requests per HMAC-Signatur. Server und GitHub müssen dasselbe Secret kennen.

**Server-Einrichtung:**
```bash
# Sicheres Secret generieren
openssl rand -hex 32

# Speichern (nicht im Repo!)
echo "DEIN_SECRET" > .webhook-secret
chmod 600 .webhook-secret
```

**GitHub-Einrichtung:**
Repository → Settings → Webhooks → Webhook hinzufügen/bearbeiten → Gleiches Secret im "Secret"-Feld eintragen.

**Sicherheit:** Die `.webhook-secret`-Datei ist gitignored. Bei Offenlegung sofort ändern.

## Kontaktformular-Konfiguration

Für das Kontaktformular-Backend (`contact.php`):

```bash
echo '{"recipient_email":"du@example.com","from_email":"noreply@example.com"}' > .contact-config.json
chmod 644 .contact-config.json
```

Ersetze durch deine echten E-Mail-Adressen. Die Datei ist gitignored.

## APIFlash-Key (Optional)

Für Link-Preview-Screenshots via `update-previews.php`:

```bash
echo "DEIN_API_KEY" > images/hover/.apiflash-key
chmod 600 images/hover/.apiflash-key
```

Key gibt's bei [apiflash.com](https://apiflash.com/). Die Datei ist gitignored.

## Funktionsweise

1. Push auf `main` → GitHub sendet POST an `deploy.php`
2. Script validiert Signatur gegen `.webhook-secret`
3. Bei Erfolg: `git pull` wird ausgeführt
4. Logs in `.deploy-log.txt`

---

<a name="deployment-setup-da"></a>
# Deployment-opsætning

*[English](#deployment-setup) | [Deutsch](#deployment-setup-de)*

Dette projekt bruger PHP-baseret auto-deployment via GitHub webhooks, plus valgfri screenshot-generering.

## Webhook Secret

`deploy.php`-scriptet validerer indkommende requests via HMAC-signatur. Server og GitHub skal dele samme secret.

**Server-opsætning:**
```bash
# Generer sikkert secret
openssl rand -hex 32

# Gem det (ikke i repo'et!)
echo "DIT_SECRET" > .webhook-secret
chmod 600 .webhook-secret
```

**GitHub-opsætning:**
Repository → Settings → Webhooks → Tilføj/rediger webhook → Indtast samme secret i "Secret"-feltet.

**Sikkerhed:** `.webhook-secret`-filen er gitignored. Skift straks ved eksponering.

## Kontaktformular-konfiguration

Til kontaktformular-backend (`contact.php`):

```bash
echo '{"recipient_email":"dig@example.com","from_email":"noreply@example.com"}' > .contact-config.json
chmod 644 .contact-config.json
```

Erstat med dine rigtige e-mailadresser. Filen er gitignored.

## APIFlash Key (Valgfri)

Til link preview-screenshots via `update-previews.php`:

```bash
echo "DIN_API_KEY" > images/hover/.apiflash-key
chmod 600 images/hover/.apiflash-key
```

Hent key på [apiflash.com](https://apiflash.com/). Filen er gitignored.

## Sådan fungerer det

1. Push til `main` → GitHub sender POST til `deploy.php`
2. Script validerer signatur mod `.webhook-secret`
3. Ved succes: `git pull` udføres
4. Logs i `.deploy-log.txt`
