# Exo technique VIE - Barcelone SaaS HRTech

## Demo: [exo-technique-vie-barcelone-hrtech.floriansylvain.fr](https://exo-technique-vie-barcelone-hrtech.floriansylvain.fr/)

## Risques identifiés

- Code arbitraire via inclusion dynamique insuffisamment validée (voir `src/ajax_handler.php`; inclusion de `customs/[client]/modules/[module]/[script].php`)
- Authentification/autorisation absentes (le cookie `client` est utilisé côté client dans `assets/js/toolbar.js` et accepté par `src/ajax_handler.php` sans vérification serveur)
- Secrets en clair dans le dépôt (`credentials/credentials.json`)
- XSS et données non échappées (templates dans `customs/*/modules/*/*.php` et sorties depuis `data/*.json`)
- CSRF et actions non protégées (endpoints AJAX/GET servis par `src/ajax_handler.php` et autres routes sans token)
- Path traversal et symlink attacks (validation des chemins dans `src/ajax_handler.php`; liens symboliques et permissions)
- Isolation client insuffisante (code client dans `customs/*` exécuté dans le même processus PHP que la plateforme)

## Corrections proposées

- Allowlist clients explicite, validation stricte des chemins
- Authentification/autorisation obligatoires
- HttpOnly + Secure + SameSite pour les cookies
- Ajouter CSP et security headers
- Protection CSRF (tokens POST)
- Retirer secrets du dépôt (variables d'environnement)
- Logging et monitoring des accès
- Rate limiting et WAF
- Tests de sécurité (SAST, pen testing)

## Remarque étape 5 client A

Petit soucis:

```md
Pour toutes les voitures qui ont plus de 10 ans, appliquer une couleur rouge sur la vue liste afin de les identifier rapidement.Pour celles qui ont moins de deux ans, appliquer une couleur verte.
```

→ Le jeu de données de voitures ne contient aucune voiture qui a plus de 10 ans ou moins de 2 ans.
