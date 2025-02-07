-- Insertion du projet
INSERT INTO projet_template (titre, image_principale, texte_contexte, texte_details) VALUES (
    'Application de Voyage - TravelApp',
    'voyage_app_main.webp',
    'Ce projet a été réalisé dans le cadre d''une refonte complète d''une application de voyage existante. L''objectif était de moderniser l''interface tout en améliorant l''expérience utilisateur.',
    'L''application permet aux utilisateurs de rechercher des destinations, de planifier leurs itinéraires, et de découvrir des activités locales. Une attention particulière a été portée à l''accessibilité et à la performance.'
);

-- Récupération de l'ID du projet
SET @projet_id = LAST_INSERT_ID();

-- Insertion des images de contexte
INSERT INTO images_contexte (id_projet, image, titre_contexte, texte_contexte) VALUES
(@projet_id, 'voyage_app_wireframe.webp', 'Phase de Conception', 'Les wireframes ont été créés en collaboration étroite avec l''équipe UX pour garantir une expérience utilisateur optimale.'),
(@projet_id, 'voyage_app_mobile.webp', 'Version Mobile', 'L''application a été conçue avec une approche mobile-first pour assurer une expérience fluide sur tous les appareils.'),
(@projet_id, 'voyage_app_desktop.webp', 'Version Desktop', 'La version desktop offre des fonctionnalités supplémentaires tout en maintenant la cohérence avec la version mobile.');

-- Insertion des étapes du projet
INSERT INTO etapes_projet (id_projet, description) VALUES
(@projet_id, 'Analyse des besoins et étude de l''existant'),
(@projet_id, 'Création des wireframes et maquettes'),
(@projet_id, 'Développement du prototype interactif'),
(@projet_id, 'Tests utilisateurs et ajustements'),
(@projet_id, 'Développement final et déploiement');

-- Insertion des outils utilisés
INSERT INTO outils_utilises (id_projet, nom_outil, image_outil) VALUES
(@projet_id, 'Figma', 'figma.webp'),
(@projet_id, 'React', 'react.webp'),
(@projet_id, 'Node.js', 'nodejs.webp'),
(@projet_id, 'MongoDB', 'mongodb.webp');

-- Insertion de l'avis client
INSERT INTO avis_projet (id_projet, texte_avis, nom_auteur, note) VALUES
(@projet_id, 'Une collaboration exceptionnelle qui a donné naissance à une application moderne et intuitive. Les utilisateurs adorent la nouvelle interface !', 'Sophie Martin - Directrice Produit', 4.8);
