# Guide utilisateur — PCT Gestion Heures

Ce guide présente l’utilisation de l’application `pct-gestion-heures` pour les administrateurs, secrétaires et enseignants.

## 1. Connexion

1. Ouvrez l’application à l’adresse définie par votre serveur local (ex. `http://127.0.0.1:8000`).
2. Sur la page de connexion, saisissez votre email et votre mot de passe.
3. Cliquez sur **Connexion**.

Si vous n’avez pas de compte, demandez à un administrateur de créer votre utilisateur.

## 2. Navigation principale

Une fois connecté, la barre latérale affiche les sections disponibles selon votre rôle :

- Tableau de bord
- Enseignants
- Cours & Ressources
- Activités
- Récapitulatifs
- Profil
- Déconnexion

Le lien actif est mis en évidence pour indiquer la page ouverte.

## 3. Mon profil

Le menu de profil permet à tous les utilisateurs de :

- modifier leur nom
- modifier leur email
- changer leur mot de passe
- supprimer leur compte

Pour accéder au profil :

1. Cliquez sur **Mon profil** dans la barre latérale.
2. Modifiez les informations souhaitées.
3. Enregistrez pour appliquer les changements.

> Si vous changez votre email, une vérification peut être nécessaire selon la configuration du site.

## 4. Administration des enseignants (admin / secrétaire)

### Créer un enseignant

1. Allez dans **Enseignants**.
2. Cliquez sur **Créer un nouvel enseignant**.
3. Remplissez le formulaire : nom, prénom, grade, statut, département, email, téléphone, taux horaire.
4. Enregistrez.

Lors de la création, un compte utilisateur `User` est lié automatiquement à l’enseignant, en utilisant l’email renseigné.

### Modifier un enseignant

1. Dans la liste des enseignants, cliquez sur **Modifier**.
2. Mettez à jour les informations souhaitées.
3. Enregistrez.

L’email de l’enseignant est synchronisé avec le compte utilisateur lié.

### Supprimer un enseignant

1. Cliquez sur **Supprimer** dans la ligne de l’enseignant.
2. Confirmez l’action.

> La suppression supprime également le compte utilisateur associé.

## 5. Gestion des cours et ressources (admin / secrétaire)

### Créer un cours

1. Ouvrez la page **Cours & Ressources**.
2. Cliquez sur **Ajouter un cou  rs**.
3. Renseignez le titre, le code, le département et les enseignants associés.
4. Enregistrez.

### Ajouter des séquences et ressources

1. Depuis un cours, créez une nouvelle séquence.
2. Pour chaque séquence, ajoutez des ressources pédagogiques.
3. Le contenu peut inclure des documents ou des liens pédagogiques.

## 6. Activités pédagogiques

### Pour les enseignants

- Accédez à la page **Activités**.
- Créez une nouvelle activité pour déclarer votre travail pédagogique.
- Entrez le cours, la date, la complexité, le type d’action et le nombre de séances.

### Pour les administrateurs / secrétaires

- Sur la page **Activités**, vous pouvez valider ou rejeter les activités soumises.
- Utilisez les boutons **Valider** ou **Rejeter** pour confirmer l’activité.

## 7. Récapitulatif des heures (enseignants)

Les enseignants ont accès à un récapitulatif personnel des heures validées.

1. Dans la barre latérale, cliquez sur **Mon récapitulatif**.
2. Vous verrez le total des heures, les heures normales, les heures complémentaires et le détail par complexité.
3. Vous pouvez générer un PDF si nécessaire.

## 8. Exports et rapports

Le menu **Récapitulatifs** permet de générer plusieurs exports :

- fiche PDF d’un enseignant
- état global des heures au format Excel
- état des paiements PDF/Excel
- statistiques pédagogiques Excel

### Générer un export

1. Allez dans **Récapitulatifs**.
2. Choisissez le type d’export.
3. Sélectionnez les filtres de dates si disponibles.
4. Téléchargez le fichier généré.

## 9. Gestion des années académiques (admin)

- Activez une année académique dans la page **Années académiques**.
- Une seule année peut être active à la fois.

## 10. Gestion des paramètres (admin)

- Paramètres système : configurez les informations générales de l’application.
- Paramètres de calcul : définissez les coefficients et seuils utilisés pour les heures.

## 11. Support et bonne pratique

- Sauvegardez toujours les modifications avant de quitter une page.
- Vérifiez que l’email de l’enseignant est unique lors de la création.
- Si un enseignant ne voit pas son récapitulatif, assurez-vous qu’il possède un compte utilisateur lié.

## 12. Résolution des problèmes courants

### Problème : le lien actif est incorrect

- Utilisez la barre latérale pour retrouver la page correcte.
- Si le bon lien n’est pas activé, rechargez la page ou reconnectez-vous.

### Problème : échec de création de compte utilisateur

- Vérifiez que l’email n’est pas déjà utilisé par un autre utilisateur.
- Contactez l’administrateur si le problème persiste.

---

Ce guide est conçu pour les utilisateurs finaux de l’application et couvre les principales opérations métier.