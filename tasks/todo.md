# TODO - La Guilde des Seigneurs Full

## v0.1 - Mise en place du projet
- [x] Creer le projet Symfony webapp 6.4 (au lieu de 7.4 car PHP 8.1)
- [ ] Commit initial "Mise en place projet"
- [ ] Definir les branches (main + dev)
- [ ] Tag v0.1

## v0.2 - Mise en place des donnees et CRUD
- [x] Creer l'entite Character avec toutes les proprietes
- [x] Ajouter l'annotation Table name `character`
- [x] Creer la base de donnees guilde_seigneurs_full
- [x] Creer l'utilisateur SQL guilde_write_f
- [x] Configurer .env.local avec DATABASE_URL
- [x] Faire la migration
- [x] Installer et configurer les Fixtures
- [x] Charger les fixtures
- [x] Generer le CRUD Character
- [x] Modifier new() pour redirect vers show
- [x] Modifier edit() pour redirect vers show
- [ ] Commit + tag v0.2

## v0.2 (suite) - TP Twig index
- [x] Franciser le titre
- [x] Supprimer colonnes id, image, identifier
- [x] Mettre kind en premiere colonne
- [x] kind == "Dame" => en <strong>
- [x] Formater creation & modification (jour/mois/annee)
- [x] Centrer textes dans colonnes et headers
- [x] Renommer "edit" par "Modifier"
- [x] Renommer "create new" par "Nouveau Character" + bouton centre
- [x] Griser ligne au survol souris
- [x] Clic sur name affiche le Character (lien vers show)
- [x] Supprimer action "show" des actions
- [x] Ajouter commentaires pour situer les parties
