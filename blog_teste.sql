

CREATE TABLE `comentarios` (
  `com_Id` int(11) NOT NULL,
  `com_IdPost` int(11) NOT NULL,
  `com_IdUser` int(11) NOT NULL,
  `com_Comentario` text NOT NULL,
  `com_Criacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`com_Id`, `com_IdPost`, `com_IdUser`, `com_Comentario`, `com_Criacao`) VALUES
(10, 59, 34, 'lalala', '2024-10-23 17:31:41');

-- --------------------------------------------------------

--
-- Estrutura para tabela `likes`
--

CREATE TABLE `likes` (
  `lik_Id` int(11) NOT NULL,
  `lik_IdPost` int(11) NOT NULL,
  `lik_IdUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `likes`
--

INSERT INTO `likes` (`lik_Id`, `lik_IdPost`, `lik_IdUser`) VALUES
(34, 70, 23);

-- --------------------------------------------------------

--
-- Estrutura para tabela `post`
--

CREATE TABLE `post` (
  `pos_Id` int(11) NOT NULL,
  `pos_UserId` int(11) DEFAULT NULL,
  `pos_Titulo` varchar(255) NOT NULL,
  `pos_Slug` varchar(255) NOT NULL,
  `pos_Views` int(11) NOT NULL DEFAULT 0,
  `pos_Foto` varchar(255) NOT NULL,
  `pos_Conteudo` text NOT NULL,
  `pos_Date` datetime NOT NULL,
  `pos_Publicado` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = false\r\n1 = true',
  `pos_Criacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `pos_Modificacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `post`
--

INSERT INTO `post` (`pos_Id`, `pos_UserId`, `pos_Titulo`, `pos_Slug`, `pos_Views`, `pos_Foto`, `pos_Conteudo`, `pos_Date`, `pos_Publicado`, `pos_Criacao`, `pos_Modificacao`) VALUES
(41, 23, 'Conheça a ETEC Fernando Prestes e Sua História.', 'conhea-a-etec-fernando-prestes-e-sua-histria', 0, 'https://imagizer.imageshack.com/img923/5475/QgUCzQ.jpg', '<p style=\"text-align: justify;\">A partir de 2006 o Centro Paula Souza altera a sigla de todas as escolas t&eacute;cnicas para &ldquo;ETec&rdquo; e assim a escola passa-se a chamar <strong>ETec Fernando Prestes</strong>.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Atualmente mant&eacute;m as habilita&ccedil;&otilde;es profissionais de T&eacute;cnico em Administra&ccedil;&atilde;o, T&eacute;cnico em Desenvolvimento de Sistemas, T&eacute;cnico em Inform&aacute;tica para Internet, T&eacute;cnico em Secretariado, T&eacute;cnico em Design de Interiores, T&eacute;cnico em Seguran&ccedil;a do Trabalho, T&eacute;cnico em Contabilidade, T&eacute;cnico em Log&iacute;stica, T&eacute;cnico em Agenciamento de Viagem, T&eacute;cnico em Finan&ccedil;as, T&eacute;cnico em Edifica&ccedil;&otilde;es e T&eacute;cnico em Eventos Integrado ao Ensino M&eacute;dio, T&eacute;cnico em Desenvolvimento de Sistemas e Inform&aacute;tica para Internet Integrado ao Ensino M&eacute;dio, T&eacute;cnico em Edifica&ccedil;&otilde;es Integrado ao Ensino M&eacute;dio. A escola tamb&eacute;m mant&eacute;m classes descentralizadas que funcionam em parceria com escola da rede estadual (Joaquim Izidoro Marins) onde funcionam o curso T&eacute;cnico em Log&iacute;stica, T&eacute;cnico em Inform&aacute;tica e Administra&ccedil;&atilde;o, e na cidade de Ara&ccedil;oiaba da Serra (na Escola Prof. Osmar Giacomelli), onde funciona o Curso T&eacute;cnico em Administra&ccedil;&atilde;o, todas elas atendendo a LDB 9394/96, ao Decreto 5154/04.</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Oferece ainda, desde 1998, o Ensino M&eacute;dio regular independente do Ensino T&eacute;cnico, para os alunos oriundo do Ensino Fundamental (antigo 1&deg; grau).</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">Contando com aproximadamente 2800 alunos matriculados no primeiro semestre de 2015, o ensino t&eacute;cnico da &ldquo;Fernando Prestes&rdquo;, atende a uma clientela heterog&ecirc;nea, composta por adolescentes, jovens e adultos, egressos do ensino m&eacute;dio (antigo 2&ordm; grau), cursando a segunda ou terceira s&eacute;rie do mesmo, ou ainda, oriundos do terceiro grau que desejam sua reconvers&atilde;o profissional.</p>', '2024-10-23 10:25:00', 1, '2024-10-23 16:25:02', '2024-10-23 16:25:02'),
(59, 23, 'JEESP Feminino - Meninas do FP ganham medalha de Prata!!', 'jeesp-feminino---meninas-do-fp-ganham-medalha-de-prata', 0, 'https://imagizer.imageshack.com/img923/3987/TNbNk3.jpg', '<p class=\"MsoNormal\" style=\"text-align: justify;\">Talento e Sabedoria Brilharam em Quadra com as alunas da ETEC Fernando Prestes<span style=\"mso-spacerun: yes;\">!</span><br><br>Cada movimento em quadra foi uma li&ccedil;&atilde;o de supera&ccedil;&atilde;o e talento. Nossas alunas n&atilde;o trouxeram apenas uma medalha de prata, elas trouxeram um verdadeiro espet&aacute;culo de garra, intelig&ecirc;ncia emocional e paix&atilde;o pelo esporte! O primeiro lugar pode n&atilde;o ter sido nosso (por enquanto!), mas o que elas conquistaram vai muito al&eacute;m de um p&oacute;dio. Cada saque, cada defesa, cada ponto mostrou que o talento &eacute; o verdadeiro campe&atilde;o. Parab&eacute;ns, meninas por nos inspirarem a acreditar na for&ccedil;a da dedica&ccedil;&atilde;o! <span style=\"background-color: #fbeeb8;\">Meninas, voc&ecirc;s deram um show memor&aacute;vel!</span></p>', '2024-10-23 11:11:00', 1, '2024-10-23 17:11:16', '2024-10-23 17:11:16'),
(65, 23, 'Provão Paulista 2024 - Terceiros Anos.', 'provo-paulista-2024---terceiros-anos', 0, 'https://imagizer.imageshack.com/img923/9508/RuwAWc.jpg', '<p class=\"MsoNormal\">Aten&ccedil;&atilde;o, estudante da 3&ordf; s&eacute;rie do Ensino M&eacute;dio e Integrado das Etecs e de outras redes estaduais e municipais de S&atilde;o Paulo!</p>\r\n<p class=\"MsoNormal\"><br>Chegou a hora de selecionar os cursos superiores para concorrer a uma vaga pelo Prov&atilde;o Paulista.</p>\r\n<p class=\"MsoNormal\"><br>S&atilde;o diversas op&ccedil;&otilde;es gratuitas* oferecidas pelas Fatecs, USP, Unesp, Unicamp e Univesp. <br><br>Acesse o site do Prov&atilde;o Paulista para melhores informa&ccedil;&otilde;es.</p>', '2024-10-23 10:53:00', 1, '2024-10-23 16:53:07', '2024-10-23 16:53:07'),
(66, 23, 'Campeões JEESP 2024 - Menino brilhando e ganhando medalha de Ouro!! ', 'campees-jeesp-2024---menino-brilhando-e-ganhando-medalha-de-ouro', 0, 'https://imagizer.imageshack.com/img922/2720/MJj8GV.jpg', '<p>Depois de um campeonato com uma s&eacute;rie de fazes e classficat&oacute;rias, nossos meninos chegaram na final e ganahram pelo placar de 2x0.<br><br>Cada movimento em quadra foi uma li&ccedil;&atilde;o de supera&ccedil;&atilde;o e talento. Nossas alunos&nbsp; mostrarsam n&atilde;o s&oacute; alunos da melhor escola t&eacute;nica de Sorocaba mas tamb&eacute;m trouxeram um verdadeiro espet&aacute;culo de garra, intelig&ecirc;ncia emocional e paix&atilde;o pelo esporte! O primeiro lugar ter sido nosso, foi de fato, merecido.Cada saque, cada defesa, cada ponto mostrou que o talento &eacute; o verdadeiro campe&atilde;o. Parab&eacute;ns, meninos por nos inspirarem a acreditar na for&ccedil;a da dedica&ccedil;&atilde;o! <span style=\"background-color: #fbeeb8;\">Voc&ecirc;s s&atilde;o demais!!<br></span></p>', '2024-10-23 10:56:00', 1, '2024-10-23 16:56:52', '2024-10-23 16:56:52'),
(67, 23, 'SARAU CULTURAL 2024 - 03/10/2024.', 'sarau-cultural-2024---03102024', 0, 'https://firebasestorage.googleapis.com/v0/b/blogfp-62869.appspot.com/o/videos%2F67190138b491f-Sarau.mp4?alt=media', '<p style=\"text-align: center;\"><span style=\"background-color: #fbeeb8;\">\"a arte diz o indiz&iacute;zel; traduz o intraduz&iacute;vel\"</span></p>\r\n<p>&nbsp;</p>\r\n<p>A arte &eacute; de fato importante para os nosso alunos, por isso, com a ajuda do professor Marcos, trazemos mais uma edi&ccedil;&atilde;o linda do SARAU CULTURAL - FP.</p>', '2024-10-23 11:10:00', 1, '2024-10-23 17:10:57', '2024-10-23 17:10:57'),
(69, 23, 'Aulas Remotas - Outubro.', 'aulas-remotas---outubro', 0, 'https://imagizer.imageshack.com/img924/6474/FLVbp7.jpg', '<p>Um aviso para as Aulas Remotas que ir&atilde;o acontecer do dia 16 de Outubro at&eacute; o dia 21 de Outubro.&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Obrigada pela Aten&ccedil;&atilde;o!!</p>', '2024-10-23 11:09:00', 1, '2024-10-23 17:09:14', '2024-10-23 17:09:14'),
(70, 23, 'Vestibulinho 2025', 'vestibulinho-2025', 0, 'https://imagizer.imageshack.com/img922/5720/7xhnxV.png', '<p>teste post</p>\r\n<table style=\"border-collapse: collapse; width: 100%;\" border=\"1\"><colgroup><col style=\"width: 33.1897%;\"><col style=\"width: 33.1897%;\"><col style=\"width: 33.1897%;\"></colgroup>\r\n<tbody>\r\n<tr>\r\n<td>lallak</td>\r\n<td>lalalala</td>\r\n<td>dasdsad</td>\r\n</tr>\r\n<tr>\r\n<td>sadsd</td>\r\n<td>adsadsd</td>\r\n<td>ffsdsd</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', '2024-10-23 11:34:00', 1, '2024-10-23 17:34:10', '2024-10-23 17:34:10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `post_tags`
--

CREATE TABLE `post_tags` (
  `pos_IdPostTag` int(11) NOT NULL,
  `pos_TagId` int(11) NOT NULL,
  `pos_PostId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `post_tags`
--

INSERT INTO `post_tags` (`pos_IdPostTag`, `pos_TagId`, `pos_PostId`) VALUES
(44, 136, 41),
(62, 128, 59),
(68, 147, 65),
(69, 128, 66),
(70, 128, 67),
(72, 147, 69),
(73, 147, 70);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tags`
--

CREATE TABLE `tags` (
  `tag_Id` int(11) NOT NULL,
  `tag_Titulo` varchar(191) NOT NULL,
  `tag_Slug` varchar(191) NOT NULL,
  `tag_Status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tags`
--

INSERT INTO `tags` (`tag_Id`, `tag_Titulo`, `tag_Slug`, `tag_Status`) VALUES
(128, 'ALUNOS', 'alunos', 1),
(136, 'ETEC', 'etec', 1),
(147, 'AVISOS', 'avisos', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `use_Id` int(11) NOT NULL,
  `use_Login` varchar(255) NOT NULL,
  `use_Senha` varchar(255) NOT NULL,
  `use_Nome` varchar(255) NOT NULL,
  `use_Foto` varchar(30) DEFAULT NULL,
  `use_Profissao` varchar(255) DEFAULT NULL,
  `use_Instagram` varchar(255) DEFAULT NULL,
  `use_Twitter` varchar(255) DEFAULT NULL,
  `use_Facebook` varchar(255) DEFAULT NULL,
  `use_TypeUser` tinyint(1) DEFAULT 0,
  `use_Active` tinyint(1) DEFAULT 0,
  `use_ActivationCode` varchar(255) NOT NULL,
  `use_ActivationExpiry` datetime NOT NULL,
  `use_ActivatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`use_Id`, `use_Login`, `use_Senha`, `use_Nome`, `use_Foto`, `use_Profissao`, `use_Instagram`, `use_Twitter`, `use_Facebook`, `use_TypeUser`, `use_Active`, `use_ActivationCode`, `use_ActivationExpiry`, `use_ActivatedAt`) VALUES
(21, 'nath.geolinda@gmail.com', '$2y$10$xhxuB2QeaD0CPnKcCdac4OZCo4skGaha/IbZjIIPzeCm/levPEkAm', 'nathgeo', 'Semfoto.png', 'aluna', '', '', '', 1, 1, '$2y$10$/ZjxPJHBeslEuNVTzxxttOqRTEZzJkGxu/4dFhhFcwmOjwvBG3idC', '2024-10-14 15:56:52', '2024-10-13 11:57:33'),
(23, 'nexuscommunity07@gmail.com', '$2y$10$g94oKZNQhQwSCcrDjJXUie3rJUl9DnYGf38xsBJNhEsrDDCjYcGN.', 'Nexus', 'nexus.png', 'Desenvolvedores', '', '', '', 0, 1, '$2y$10$lo3G3bMxYefxOENIlM2v0OJXAF7dVNVUqO2MUo.Y3OBfUYLIZuiYa', '2024-10-14 16:08:43', '2024-10-13 16:27:31'),
(24, 'st444yyugly@gmail.com', '$2y$10$zI7EJKgrOoBdzqUg2zVcheE57ywL1H/5U9VmLlkoJyJ8TvNPFp93i', 'Kanye', 'd4ec6bec3d570f5218f270b37d3c4e', '', '', '', '', 1, 1, '$2y$10$OZrzMlHKZw8V04PoeCjdsOMZzyr84gmVbpZv0.kCi0TCGADr75Udi', '2024-10-15 11:40:02', '2024-10-14 07:40:45'),
(25, 'fxctjybhh@gmail.com', '$2y$10$bhUJVtey/iLxyHwcaSNmcudxtMz5bCDn6hiRLZVnHwg1T9QMaeNtq', 'Manu', 'Semfoto.png', 'Aluno', 'malo_ukb ', '', '', 1, 0, '$2y$10$Xx6ahNT0ryJpsh.FvbjrYubeU79FWeziL3AFcpmwMRd1/8v/WzjXi', '2024-10-15 12:38:07', NULL),
(26, 'fxctjybhh@gmail.com', '$2y$10$IAgCW/EFtZD8MEC1cdhoFuuB0hahPQACe6wxJLEPxFCBmYv5AhyCG', 'manoela', '20241013_205019.jpg', 'Estudante ', '', '', '', 1, 0, '$2y$10$x3mxlDUlHOzklZarg/n4wO3mcjHQBvPwG32Qi8n49rk0un4iILGR.', '2024-10-15 12:41:08', NULL),
(27, 'manumoraesx949@gmail.com', '$2y$10$p7EVuE0Sz8sXA72tBK8Ez.urZOPQJ7/LHG0WiOiYTquSoSXq1Bpqm', 'Manu', '20241012_232836 (2).jpg', 'Estudante ', '', '', '', 1, 1, '$2y$10$2J2BFkftPNTJR3m985f9F.8EdBc8Vv5HvzdZzjgMlxdALQ2xALlK6', '2024-10-15 12:56:12', '2024-10-14 08:56:56'),
(30, 'leonardoemcs166@gmail.com', '$2y$10$JZUVPZskeHE69IY9kIak6.crvLwTl.3GaG6S5eCy1hToftaNM52gW', 'Leonardo', 'Semfoto.png', 'Estudante', '', '', '', 0, 1, '$2y$10$5e3Bpvz/v2qOkNdZ81VSPu8imMqQG4a/Qlr50CR0StodgpWgfdury', '2024-10-15 18:58:29', '2024-10-14 14:58:40'),
(34, 'nataliasasaki0@gmail.com', '$2y$10$p4ecYQa1lOpDr/7p5eGXheYZ/kCrOs7Qiae72DT5U/7Q1FSyI3OAm', 'natalia', 'Semfoto.png', 'aluna', 'nat_sski', '', '', 1, 1, '$2y$10$Wa0g2IrFvyJTf5VMyms37Ob3fSBbXx0arfmUiaZuk/izNLfd8ZPaS', '2024-10-24 11:28:16', '2024-10-23 07:30:39');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`com_Id`),
  ADD KEY `com_IdPost` (`com_IdPost`),
  ADD KEY `com_IdUser` (`com_IdUser`);

--
-- Índices de tabela `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`lik_Id`),
  ADD KEY `lik_IdPost` (`lik_IdPost`),
  ADD KEY `lik_IdUser` (`lik_IdUser`);

--
-- Índices de tabela `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`pos_Id`),
  ADD UNIQUE KEY `pos_Slug` (`pos_Slug`),
  ADD KEY `pos_UserId` (`pos_UserId`);

--
-- Índices de tabela `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`pos_IdPostTag`,`pos_TagId`),
  ADD UNIQUE KEY `pos_PostId` (`pos_PostId`),
  ADD KEY `pos_IdTag` (`pos_TagId`);

--
-- Índices de tabela `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_Id`),
  ADD UNIQUE KEY `tag_Titulo` (`tag_Titulo`),
  ADD UNIQUE KEY `tag_Slug` (`tag_Slug`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`use_Id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `com_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `likes`
--
ALTER TABLE `likes`
  MODIFY `lik_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `post`
--
ALTER TABLE `post`
  MODIFY `pos_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de tabela `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `pos_IdPostTag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de tabela `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `use_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`com_IdPost`) REFERENCES `post` (`pos_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`com_IdUser`) REFERENCES `users` (`use_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`lik_IdPost`) REFERENCES `post` (`pos_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`lik_IdUser`) REFERENCES `users` (`use_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`pos_UserId`) REFERENCES `users` (`use_Id`);

--
-- Restrições para tabelas `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`pos_PostId`) REFERENCES `post` (`pos_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`pos_TagId`) REFERENCES `tags` (`tag_Id`) ON DELETE CASCADE ON UPDATE CASCADE;
