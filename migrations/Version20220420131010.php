<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420131010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE programmen_repas');
        $this->addSql('DROP TABLE programmenutritionnel');
        $this->addSql('DROP TABLE programmes_exercice');
        $this->addSql('DROP TABLE programmesportif');
        $this->addSql('ALTER TABLE exercice CHANGE Video video VARCHAR(50) NOT NULL, CHANGE Image Image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE panier DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE panier ADD PRIMARY KEY (id_commande, id_produit, id_client)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE programmen_repas (IDPN_r INT AUTO_INCREMENT NOT NULL, IDProgrammeNutritionnel INT NOT NULL, IDRepas INT NOT NULL, JourRepas VARCHAR(25) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, INDEX FK_IDRepas (IDRepas), INDEX FK_IDProgrammeNutritionnel (IDProgrammeNutritionnel), PRIMARY KEY(IDPN_r)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE programmenutritionnel (IDProgrammeNutritionnel INT AUTO_INCREMENT NOT NULL, IDCoach VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, IDAdherent VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, Calorie INT NOT NULL, TypeProgrammeNutritionnel VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, PRIMARY KEY(IDProgrammeNutritionnel)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE programmes_exercice (IDPS_exercice INT AUTO_INCREMENT NOT NULL, IDProgrammeSportif INT NOT NULL, IDExercice INT NOT NULL, JourExercice VARCHAR(50) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, INDEX FK_IDProgrammeSportif (IDProgrammeSportif), INDEX FK_IDExercice (IDExercice), PRIMARY KEY(IDPS_exercice)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE programmesportif (IDProgrammeSportif INT AUTO_INCREMENT NOT NULL, IDCoach VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, IDAdherent VARCHAR(100) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, DureeMois INT NOT NULL, TypeProgrammeSportif VARCHAR(20) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`, PRIMARY KEY(IDProgrammeSportif)) DEFAULT CHARACTER SET latin1 COLLATE `latin1_swedish_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE exercice CHANGE video Video VARCHAR(150) NOT NULL, CHANGE Image Image VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE panier DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE panier ADD PRIMARY KEY (id_commande, id_client, id_produit)');
    }
}
