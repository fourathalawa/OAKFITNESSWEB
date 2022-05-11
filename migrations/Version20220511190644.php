<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511190644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE wishlist');
        $this->addSql('ALTER TABLE challenge CHANGE DateDebut DateDebut DATE NOT NULL, CHANGE DateFin DateFin DATE NOT NULL');
        $this->addSql('ALTER TABLE exercice CHANGE Video video VARCHAR(50) NOT NULL, CHANGE Image Image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE imageUser imageUser VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (IdReservation INT AUTO_INCREMENT NOT NULL, DateReservation DATE NOT NULL, IdUser INT NOT NULL, NomSalle VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, AccCoach TINYINT(1) NOT NULL, AccResponsable TINYINT(1) NOT NULL, PRIMARY KEY(IdReservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE wishlist (IdWishlist INT AUTO_INCREMENT NOT NULL, IdProduit INT DEFAULT NULL, IdUser INT DEFAULT NULL, Note VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(IdWishlist)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE challenge CHANGE DateDebut DateDebut VARCHAR(20) NOT NULL, CHANGE DateFin DateFin VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE exercice CHANGE video Video VARCHAR(150) NOT NULL, CHANGE Image Image VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE imageUser imageUser VARCHAR(250) DEFAULT NULL');
    }
}
