CREATE TABLE IF NOT EXISTS template (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ajout de la colonne id_template à la table projet si elle n'existe pas déjà
ALTER TABLE projet
ADD COLUMN IF NOT EXISTS id_template INT,
ADD CONSTRAINT fk_projet_template
    FOREIGN KEY (id_template)
    REFERENCES template(id)
    ON DELETE SET NULL;

-- Insertion des templates de base
INSERT INTO template (nom, description) VALUES
('Template Standard', 'Template par défaut pour les projets'),
('Template Portfolio', 'Template spécial pour les projets de type portfolio'),
('Template Blog', 'Template pour les projets de type blog');
