
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `os-p13-greengoodies`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250705125025', '2025-07-05 12:50:56', 175),
('DoctrineMigrations\\Version20250705191941', '2025-07-05 19:19:57', 51),
('DoctrineMigrations\\Version20250714210751', '2025-07-14 21:08:04', 125),
('DoctrineMigrations\\Version20250727145539', '2025-07-27 14:55:49', 91),
('DoctrineMigrations\\Version20250727192338', '2025-07-27 19:23:50', 60),
('DoctrineMigrations\\Version20250729190035', '2025-07-29 19:00:42', 74);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `paid_price` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `user_id`, `paid_price`, `created_at`) VALUES
(56, 45, 24.99, '2025-09-12 13:13:14');

-- --------------------------------------------------------

--
-- Structure de la table `order_line`
--

CREATE TABLE `order_line` (
  `id` int NOT NULL,
  `order_goodies_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order_line`
--

INSERT INTO `order_line` (`id`, `order_goodies_id`, `product_id`, `quantity`) VALUES
(76, 56, 13, 1);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `name`, `picture`, `price`, `short_description`, `full_description`) VALUES
(13, 'Kit d\'hygiène recyclable ', 'Recyclable_Hygiene_Kit.webp', 24.99, 'Pour une salle de bain éco-friendly', 'Est culpa ipsam doloremque magnam consequatur. Soluta aperiam ipsa illo nam rerum officia nemo. Sapiente voluptatem veniam libero molestiae qui officia sed.\n\nNulla vitae ipsum beatae suscipit alias repudiandae. Ut ut nihil ut. Iste asperiores quisquam assumenda.\n\nTempore est error culpa omnis excepturi sit. Magni doloremque atque velit quia veniam.'),
(14, 'Shot Tropical', 'Shot_Tropical.webp', 4.50, 'Fruits frais, pressés à froid', 'Est iste laudantium enim. Perspiciatis inventore alias incidunt eos. Sint libero voluptatem in ut.\n\nMaiores aliquam saepe enim ad voluptas nihil. Unde cupiditate velit dolores sapiente qui. Impedit dicta eius enim laborum sapiente. Soluta asperiores natus sint.\n\nAut accusamus dolores earum accusantium quo qui eum. Perspiciatis iure et accusantium qui error exercitationem. Eligendi quo rerum veritatis ad autem possimus.'),
(15, 'Gourde en bois', 'Wooden_Water_Bottle.webp', 16.90, '50cl, bois d’olivier', 'Est fugit excepturi voluptas. Aut eum dolore vel voluptate ut est omnis. Consequatur aliquam dolores non. Aut quasi illo tenetur provident sequi nobis.\n\nSoluta enim deserunt quis et sit. Ea quod quo ut ipsum. Nobis quaerat sed veniam dolorum.\n\nError porro corporis eaque et et. Aut laboriosam dolorem enim est. Illo voluptatem nobis temporibus aut. Tenetur et dolores rem culpa possimus dolorem cumque.'),
(16, 'Disques Démaquillants x3', 'Makeup_Remover_Pads_x3.webp', 19.90, 'Solution efficace pour vous démaquiller en douceur', 'Ab sequi vitae deserunt ut laborum modi. Dolor aliquam tenetur sit officia sed aliquid.\n\nNemo est et minus tempora facilis molestias. Quae error itaque tempora qui vel molestias iure. Dolores voluptas adipisci assumenda temporibus et quia. Facere provident qui ad inventore id facilis quam.\n\nTempore omnis eum rem tenetur vel amet. Omnis voluptatem molestiae perspiciatis aut repellendus nostrum id. Aliquam odio eos corporis odit.'),
(17, 'Bougie Lavande & Patchouli', 'Lavender_Patchouli_Candle.webp', 18.45, 'Cire naturelle', 'Tempore sed inventore et quo. Quia incidunt enim ducimus excepturi ut. Expedita illum autem reprehenderit accusantium impedit veritatis consequatur. Quam et quo adipisci ad dolor aut inventore.\n\nEt id et quasi voluptatum. Maxime neque impedit earum similique. Et minus autem eum facere quia odio.\n\nQui minima eos asperiores beatae non. Excepturi excepturi autem possimus odit nostrum vel ipsum. Incidunt minima quia hic odio unde. Quaerat amet sequi ex.'),
(18, 'Brosse à dent', 'Toothbrush.webp', 26.44, 'Bois de hêtre rouge issu de forêts gérées durablement', 'Aliquam quisquam libero asperiores dolores sed vel. Quia illum minima eos maiores autem. Est ea ullam quisquam ut deleniti. Blanditiis exercitationem qui molestias ipsa architecto vel. Odit minima voluptatem magnam nihil veritatis ipsum modi.\n\nAliquid autem sed libero aut quod. Facere accusantium enim perferendis eum. Deleniti dolores possimus voluptate tenetur aliquid ut. Aut illo non in soluta.\n\nExcepturi autem exercitationem assumenda. Animi fugit nisi quia et. Omnis consequatur inventore nesciunt non.'),
(19, 'Kit couvert en bois', 'Wooden_Utensils_Set.webp', 12.30, 'Revêtement Bio en olivier & sac de transport', 'Eaque nulla aut est nesciunt id nemo. Repudiandae aut minus totam nulla velit. Reiciendis adipisci ratione in nihil.\n\nAut repellat qui sit architecto occaecati officiis labore. Aliquid corrupti et facere aut ipsum.\n\nIste quo aut minima aliquid. Temporibus quasi et officia incidunt quis unde et. Ut ut expedita velit id iste fugiat itaque.'),
(20, 'Nécessaire, déodorant Bio', 'Nécessaire_Déodorant_Bio.webp', 8.28, '50ml déodorant à l’eucalyptus', 'Déodorant Nécessaire, une formule révolutionnaire composée exclusivement d\'ingrédients naturels pour une protection efficace et bienfaisante. \r\n\r\nChaque flacon de 50 ml renferme le secret d\'une fraîcheur longue durée, sans compromettre votre bien-être ni l\'environnement. Conçu avec soin, ce déodorant allie le pouvoir antibactérien des extraits de plantes aux vertus apaisantes des huiles essentielles, assurant une sensation de confort toute la journée. \r\n\r\nGrâce à sa formule non irritante et respectueuse de votre peau, Nécessaire offre une alternative saine aux déodorants conventionnels, tout en préservant l\'équilibre naturel de votre corps.'),
(21, 'Savon Bio', 'Organic_Soap.webp', 18.90, 'Thé, Orange & Girofle', 'Ce savon biologique artisanal allie les vertus tonifiantes du thé vert, la fraîcheur de l’orange et la chaleur épicée du girofle pour offrir une expérience sensorielle unique. Formulé à partir d’ingrédients naturels et sans produits chimiques agressifs, il nettoie la peau en douceur tout en respectant son équilibre naturel. Sa mousse onctueuse hydrate et laisse la peau délicatement parfumée. Adapté à tous les types de peau, ce savon est idéal pour une routine beauté respectueuse de l’environnement et de votre bien-être.');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_accepted_cgu` tinyint(1) NOT NULL,
  `is_activated_api` tinyint(1) NOT NULL,
  `roles` json NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `password`, `is_accepted_cgu`, `is_activated_api`, `roles`) VALUES
(7, 'Bernardo', 'Windler', 'nolan.rylee@example.org', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 1, 'null'),
(8, 'Westley', 'Connelly', 'antonietta.bahringer@example.net', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 1, 'null'),
(9, 'Lesly', 'Stamm', 'einar.romaguera@example.com', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 0, 'null'),
(10, 'Brandi', 'Bergnaum', 'jennie.greenholt@example.net', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 0, 0, 'null'),
(11, 'Ramiro', 'Gottlieb', 'mframi@example.com', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 0, 'null'),
(12, 'Bessie', 'Stanton', 'hudson.zackary@example.com', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 1, 'null'),
(13, 'Abbey', 'Mertz', 'bkohler@example.net', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 0, 'null'),
(14, 'Oral', 'Wilkinson', 'harry.goldner@example.com', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 0, 0, 'null'),
(15, 'Berneice', 'Mills', 'cruz75@example.org', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 1, 'null'),
(16, 'Jarred', 'Glover', 'gkihn@example.com', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 0, 'null'),
(17, 'Mauricio', 'Towne', 'noberbrunner@example.org', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 0, 0, 'null'),
(18, 'Lori', 'Kulas', 'wkling@example.org', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 0, 0, 'null'),
(19, 'Vance', 'Wilderman', 'otha.sauer@example.org', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 0, 'null'),
(20, 'Shyanne', 'Homenick', 'schroeder.gerald@example.net', '$2y$13$Dag83HVd3R7s0myP1TOsfuLFOkpLS0hQz.Clh7C/5SLt6Gdyu.uja', 1, 1, 'null'),
(32, 'Jean', 'Dujardin', 'jean@test.com', '$2y$13$Dopfco5WQE562lhc53rpB.usSgDXU9BrL1ZFO3XarOGksqT4tcO.2', 1, 0, '[]'),
(45, 'user', 'User', 'user@test.com', '$2y$13$3TNAcljaZF4SGzE1KPs9Fu/Ju7w2WYfN4mpqjRItc.I360I0vz9ta', 1, 1, '[]');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Index pour la table `order_line`
--
ALTER TABLE `order_line`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9CE58EE1820AB41` (`order_goodies_id`),
  ADD KEY `IDX_9CE58EE14584665A` (`product_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `order_line`
--
ALTER TABLE `order_line`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `order_line`
--
ALTER TABLE `order_line`
  ADD CONSTRAINT `FK_9CE58EE14584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_9CE58EE1820AB41` FOREIGN KEY (`order_goodies_id`) REFERENCES `order` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
