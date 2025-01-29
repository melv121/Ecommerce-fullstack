-- ...existing code...

-- Ajout de la colonne category_id à la table articles
ALTER TABLE `articles`
ADD COLUMN `category_id` int(11) NOT NULL AFTER `id`;

-- Ajout de la clé étrangère
ALTER TABLE `articles`
ADD CONSTRAINT `fk_category`
FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE;

-- ...existing code...
