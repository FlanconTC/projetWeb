INSERT INTO user (id, username, roles, password, prive, email, created_at) VALUES
(7, 'Benoît Dupont', '[\"ROLE_DEV\"]', '$2y$13$n4w7aVr7KC6cjrfay9MWeekEgsZCs26k5xi8DjylYEvdpxQGYk4CO', 0, 'bd@gmail.com5', '2025-01-10 18:01:22'),
(8, 'Paul Ordi', '[\"ROLE_DEV\"]', '$2y$13$8vC/4FIL7SlUmERCiBllTOjlYxdqPVEVBIwVd6c/xiFSHu/y.lusG', 0, 'po@po.com', '2025-01-10 18:02:04'),
(9, 'Lucas Saphir', '[\"ROLE_DEV\"]', '$2y$13$bGnl..8Wm8GjHLgSt2zIy.1vjx84ToiL8R5v9sK3jU81myzvQg1v.', 0, 'ls@ls.com', '2025-01-10 18:02:52'),
(10, 'Justin Bruitdo', '[\"ROLE_DEV\"]', '$2y$13$0LDr0XZlF5eNGm.tDFOyJuoVpOV5O5g4rpEYhvS/d1ct01Znbe.l6', 0, 'jb@jb.com', '2025-01-10 18:03:50'),
(11, 'Google', '[\"ROLE_COMPANY\"]', '$2y$13$JoEygAFAsf0oe6ogQkM4wOI2sRFhTG.FoS/ijI/7cuDo8Z3OQtaoS', 0, 'google@google.com', '2025-01-10 18:04:14'),
(12, 'Facebook', '[\"ROLE_COMPANY\"]', '$2y$13$YwnHfzw8iZag75QwGVBLl.9hQoCBIMVWFFFEjPu52ikSnERv5HIgi', 0, 'fb@fb.com', '2025-01-10 18:04:38'),
(13, 'Microsoft', '[\"ROLE_COMPANY\"]', '$2y$13$D31QF4POyT.0pObo8h50netEeq5vYDxcy8Iw1Ty25vRgO8QrUv1AS', 0, 'micro@micro.com', '2025-01-10 18:04:57'),
(15, 'Julien Argenté', '[\"ROLE_DEV\"]', '$2y$13$w4z8tfXAIxx/bqHMtBqaoOsLXJ2o8d5IgXh3fRPvt9xeE/UM6BkgO', 0, 'ja@ja.com', '2025-01-10 20:04:35'),
(16, 'Istic', '[\"ROLE_COMPANY\"]', '$2y$13$S8uyLMmAnvcbolf7m8j29eSfccWhHofPBLoTt5s6M6Ir2FCbvo2by', 0, 'istic@mail.com', '2025-01-10 20:08:27');

INSERT INTO developer_profile (id, user_id, location, programming_languages, experience_level, minimun_salary, biography, avatar) VALUES
(4, 7, 'Rennes, France', '[\"javascript\",\"python\",\"java\"]', NULL, 1000, 'Je suis très très fort.', 'image1-67816072c4217.jpg'),
(5, 8, 'Paris, France, Belgique', '[\"php\",\"javascript\",\"python\",\"java\"]', NULL, 1500, 'J\'ai codé avec les plus grands.', 'image2-6781609cbb985.jpg'),
(6, 9, 'France, Lyon, Japon', '[\"rust\",\"typescript\",\"swift\",\"kotlin\"]', NULL, 2000, 'Je souhaite devenir riche grâce aux nft.', 'image3-678160ccb00be.jpg'),
(7, 10, 'France, Paris', '[\"javascript\",\"python\",\"rust\",\"typescript\",\"swift\"]', NULL, 500, 'Je souhaite obtenir de l\'expérience.', 'Image4-678161067ef4c.jpg'),
(9, 15, 'Rennes, France', '[\"php\",\"python\"]', NULL, 750, 'Je veux des sites web.', 'image5-67817d8fb0fd9.jpg');


INSERT INTO job_post (id, company_id, title, location, required_technologies, required_experience, offered_salary, description, created_at) VALUES
(4, 11, 'Dev full stack', 'Paris, France', '[\"php\",\"javascript\"]', 1, 600, 'On veut faire un site.', '2025-01-10 18:05:44'),
(5, 11, 'DevOps', 'Belgique', '[\"java\",\"csharp\",\"cplusplus\",\"ruby\",\"go\",\"rust\"]', 3, 2000, 'On ne veut que les meilleurs', '2025-01-10 18:06:27'),
(6, 12, 'Récolteur de données', 'Paris, France', '[\"php\",\"javascript\",\"python\"]', 2, 1500, 'On veut voler des données aux utilisateurs.', '2025-01-10 18:07:23'),
(7, 12, 'Modérateur de communautés', 'Paris, France', '[\"php\",\"python\",\"java\"]', 1, 250, 'Surveiller les communautés \"dangereuses\".', '2025-01-10 18:07:56'),
(8, 13, 'Créer un nouvel OS', 'Belgique', '[\"typescript\",\"swift\",\"kotlin\"]', 3, 2000, 'On en a marre du notre.', '2025-01-10 18:08:46'),
(9, 13, 'Code reviewer', 'Rennes, France', '[\"php\",\"javascript\",\"typescript\"]', 0, 100, 'Pour rendre notre code plus beau.', '2025-01-10 18:09:20'),
(10, 16, 'Dev back end', 'Rennes, France, Belgique', '[\"csharp\"]', 0, 200, 'Je veux une appli simple pour calculer des budgets.', '2025-01-10 20:09:07');

INSERT INTO analytics (id, user_id, job_post_id, view_count, last_viewed_at) VALUES
(6, 7, NULL, 5, '2025-01-10 20:30:25'),
(7, 8, NULL, 6, '2025-01-10 20:30:10'),
(8, 9, NULL, 2, '2025-01-10 20:10:58'),
(9, 10, NULL, 4, '2025-01-10 20:30:30'),
(10, NULL, 4, 2, '2025-01-10 20:31:11'),
(11, NULL, 5, 2, '2025-01-10 20:31:13'),
(12, NULL, 6, 2, '2025-01-10 20:31:14'),
(13, NULL, 7, 2, '2025-01-10 20:31:15'),
(14, NULL, 8, 2, '2025-01-10 20:31:16'),
(15, NULL, 9, 2, '2025-01-10 20:31:17'),
(16, 15, NULL, 3, '2025-01-10 20:30:30'),
(17, NULL, 10, 1, '2025-01-10 20:31:18');

INSERT INTO doctrine_migration_versions (version, executed_at, execution_time) VALUES
('DoctrineMigrations\\Version20250110143746', '2025-01-10 14:37:54', 1050);

INSERT INTO evaluation (id, evaluator_id, evaluatee_id, rating, comments, created_at) VALUES
(5, NULL, 8, 3, 'Rating automatique de départ.', '2025-01-10 18:02:04'),
(6, NULL, 9, 3, 'Rating automatique de départ.', '2025-01-10 18:02:52'),
(7, NULL, 10, 3, 'Rating automatique de départ.', '2025-01-10 18:03:50'),
(9, NULL, 15, 3, 'Rating automatique de départ.', '2025-01-10 20:04:36'),
(11, NULL, 7, 3, 'Rating automatique de départ.', '2025-01-10 21:33:57');