CREATE USER 'Cinétoile'@'%' IDENTIFIED BY 'tarantino';


CREATE DATABASE IF NOT EXISTS cinetoile;
USE cinetoile;


-- ###############
-- ### Membres ###
-- ###############

CREATE TABLE IF NOT EXISTS Membre (
	login varchar(64) NOT NULL PRIMARY KEY,
	password varchar(64) NOT NULL,
	droits ENUM("0","1","2") NOT NULL,
       	prenom varchar(32) NOT NULL,
        nom varchar(32),
	email varchar(64),
	ecole ENUM("Autre","Ense3","Ensimag","GI","Pagora","Phelma"),
	annee ENUM("Autre","1","2","3")
);  

-- password à changer
INSERT INTO Membre (login,password,droits,prenom,nom,email,telephone,ecole,annee)
VALUES ('Cin&eacute;toile',PASSWORD('siteweb'),'2','Cinétoile',NULL,'cinetoile.grenoble@gmail.com',NULL,NULL); 


-- ###############
-- ###  Films  ###
-- ###############

CREATE TABLE IF NOT EXISTS Film (
	id integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
	titre varchar(64) NOT NULL,
	annee year NOT NULL,
	realisateur varchar(64) NOT NULL,
	duree time,
	pays varchar(32),
	acteurs varchar(128),
	genre varchar(64),
	support ENUM("VHS","DVD"),  -- Choisir DVD quand il y a les deux
	synopsis varchar(2048),
	image varchar(64),  -- Titre du fichier image
	lien_allocine varchar(256),  -- Lien à mettre dans la page HTML avec les balises
	hauteur_video integer  -- A mettre en pixels
);

CREATE TABLE IF NOT EXISTS Diffusion (
	datediffusion datetime NOT NULL PRIMARY KEY,
	id integer,
	commentaire varchar(256),
	image varchar(64),  -- Titre du fichier image, pas nécessairement la même que pour la table film
	FOREIGN KEY (id) REFERENCES Film(id)
);

CREATE TABLE IF NOT EXISTS Vote (
	id integer NOT NULL PRIMARY KEY,
	votes integer NOT NULL,
	login varchar(32) NOT NULL,
	datevote datetime NOT NULL,
	FOREIGN KEY (id) REFERENCES Film(id),
	FOREIGN KEY (login) REFERENCES Membre(login)
);


GRANT ALL
ON cinetoile.*
TO 'Cinétoile' IDENTIFIED BY 'tarantino'
WITH GRANT OPTION;
