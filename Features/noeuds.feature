# language: fr
@mink:sahi
Fonctionnalité: Gestion des noeuds
    Pour construire mon menu
    En tant qu'administrateur du site
    Je dois pouvoir lister/créer/modifier/supprimer les noeuds du menu

    Scénario: Liste des noeuds
        Soit je suis sur une page du back-office
       Quand je suis "Menu"
       Alors je devrais voir "Gestion du menu"
          Et je devrais voir "Tableau de bord / Gestion du menu"
          Et je devrais voir "Nouveau"
          Et je devrais voir "Informations"

    Scénario: Créer une Catégorie
        Soit je suis sur une page du back-office
          Et je suis "Menu"
          Et je suis "soloist_category_new"
          Et l'élément "h1" devrait contenir "Ajouter un élément"
          Et je devrais voir "Nouveau noeud"
       Quand je remplis "Title" avec "Behat-test"
          Et je presse "Créer la page"
       Alors je devrais voir "Gestion du menu"
          Et je devrais voir "Behat-test"
          Et je devrais voir "Le noeud a été créé avec succès"

    Scénario: Modifier une catégorie
        Soit je suis sur une page du back-office
          Et je suis "Menu"
          Et je clique sur le bouton "Editer" de la ligne contenant "Behat-test"
       Quand je remplis "Title" avec "Foo-Bar"
          Et je presse "Mettre à jour"
       Alors je devrais voir "Gestion du menu"
          Et je devrais voir "Foo-Bar"
          Et je devrais voir "Le noeud a été modifié avec succès"

    Scénario: je supprime une Catégorie
        Soit je suis sur une page du back-office
          Et je suis "Menu"
       Quand je clique sur le bouton "Supprimer" de la ligne contenant "Foo-Bar"
       Alors je devrais voir "Gestion du menu"
          Et je ne devrais pas voir "Behat-test"
          Et je ne devrais pas voir "Foo-Bar"
          Et je devrais voir "Le noeud a été supprimé avec succès"

