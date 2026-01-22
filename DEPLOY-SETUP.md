# Deployment Setup

*[Deutsch](#deployment-setup-de) | [Dansk](#deployment-setup-da)*

## Security Configuration

The deployment and screenshot automation require external secret files for security.

### 1. Webhook Secret (Required for Auto-Deployment)

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

**Security Notes:**
- **NEVER** commit `.webhook-secret` to the repository
- The file is already in `.gitignore`
- Change the secret immediately if it's ever exposed
- Use a strong random secret (at least 32 bytes)

### 2. APIFlash Key (Required for Screenshot Generation)

1. Create the API key file in the screenshots directory:
```bash
echo "YOUR_APIFLASH_API_KEY" > images/hover/.apiflash-key
chmod 600 images/hover/.apiflash-key
```

2. Get your API key from [APIFlash](https://apiflash.com/)

**Security Notes:**
- **NEVER** commit `.apiflash-key` to the repository
- The file is already in `.gitignore`
- If exposed, generate a new key at APIFlash and update the file

## Deploy Script

The `deploy.php` script automatically pulls changes when GitHub sends a webhook after each push to the `main` branch.

### Testing the Webhook

After setup, push a commit to test the webhook. Check `.deploy-log.txt` on the server for deployment logs.

---

<a name="deployment-setup-de"></a>
# Deployment-Einrichtung

*[English](#deployment-setup) | [Dansk](#deployment-setup-da)*

## Sicherheitskonfiguration

Das Deployment und die Screenshot-Automatisierung benötigen externe Secret-Dateien aus Sicherheitsgründen.

### 1. Webhook-Secret (Erforderlich für Auto-Deployment)

### Server-Einrichtung

1. Erstelle die Secret-Datei auf deinem Server:
```bash
echo "DEIN_NEUES_SECRET_HIER" > .webhook-secret
chmod 600 .webhook-secret
```

2. Generiere ein neues sicheres Secret:
```bash
openssl rand -hex 32
```

3. Aktualisiere die GitHub-Webhook-Einstellungen mit dem neuen Secret:
   - Gehe zu: https://github.com/ollrich/eichhof.me/settings/hooks
   - Bearbeite den Webhook
   - Aktualisiere das "Secret"-Feld mit deinem neuen Secret
   - Speichere die Änderungen

**Sicherheitshinweise:**
- Committe **NIEMALS** `.webhook-secret` ins Repository
- Die Datei steht bereits in `.gitignore`
- Ändere das Secret sofort, wenn es jemals offengelegt wurde
- Verwende ein starkes zufälliges Secret (mindestens 32 Bytes)

### 2. APIFlash-Key (Erforderlich für Screenshot-Generierung)

1. Erstelle die API-Key-Datei im Screenshots-Verzeichnis:
```bash
echo "DEIN_APIFLASH_API_KEY" > images/hover/.apiflash-key
chmod 600 images/hover/.apiflash-key
```

2. Hole dir deinen API-Key von [APIFlash](https://apiflash.com/)

**Sicherheitshinweise:**
- Committe **NIEMALS** `.apiflash-key` ins Repository
- Die Datei steht bereits in `.gitignore`
- Bei Offenlegung generiere einen neuen Key bei APIFlash und aktualisiere die Datei

## Deploy-Script

Das `deploy.php`-Script pullt automatisch Änderungen, wenn GitHub einen Webhook nach jedem Push auf den `main`-Branch sendet.

### Webhook testen

Nach der Einrichtung pushe einen Commit, um den Webhook zu testen. Prüfe `.deploy-log.txt` auf dem Server für Deployment-Logs.

---

<a name="deployment-setup-da"></a>
# Deployment-opsætning

*[English](#deployment-setup) | [Deutsch](#deployment-setup-de)*

## Sikkerhedskonfiguration

Deployment og screenshot-automatisering kræver eksterne secret-filer af sikkerhedsmæssige årsager.

### 1. Webhook Secret (Påkrævet til auto-deployment)

### Server-opsætning

1. Opret secret-filen på din server:
```bash
echo "DIT_NYE_SECRET_HER" > .webhook-secret
chmod 600 .webhook-secret
```

2. Generer et nyt sikkert secret:
```bash
openssl rand -hex 32
```

3. Opdater GitHub webhook-indstillingerne med det nye secret:
   - Gå til: https://github.com/ollrich/eichhof.me/settings/hooks
   - Rediger webhooken
   - Opdater "Secret"-feltet med dit nye secret
   - Gem ændringerne

**Sikkerhedsnoter:**
- Commit **ALDRIG** `.webhook-secret` til repositoriet
- Filen står allerede i `.gitignore`
- Skift secret'et straks, hvis det nogensinde er blevet eksponeret
- Brug et stærkt tilfældigt secret (mindst 32 bytes)

### 2. APIFlash Key (Påkrævet til screenshot-generering)

1. Opret API-key-filen i screenshots-mappen:
```bash
echo "DIN_APIFLASH_API_KEY" > images/hover/.apiflash-key
chmod 600 images/hover/.apiflash-key
```

2. Hent din API-key fra [APIFlash](https://apiflash.com/)

**Sikkerhedsnoter:**
- Commit **ALDRIG** `.apiflash-key` til repositoriet
- Filen står allerede i `.gitignore`
- Ved eksponering generer en ny key hos APIFlash og opdater filen

## Deploy-script

`deploy.php`-scriptet puller automatisk ændringer, når GitHub sender en webhook efter hvert push til `main`-branchen.

### Test webhooken

Efter opsætning push et commit for at teste webhooken. Tjek `.deploy-log.txt` på serveren for deployment-logs.
