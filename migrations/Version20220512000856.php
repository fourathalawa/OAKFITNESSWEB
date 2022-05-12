<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512000856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wishlist (IdWishlist INT AUTO_INCREMENT NOT NULL, Note VARCHAR(500) DEFAULT NULL, IdProduit INT DEFAULT NULL, IdUser INT DEFAULT NULL, INDEX IDX_9CE12A31BBED0576 (IdProduit), INDEX IDX_9CE12A31F9C28DE1 (IdUser), PRIMARY KEY(IdWishlist)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31BBED0576 FOREIGN KEY (IdProduit) REFERENCES produit (IdProduit)');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31F9C28DE1 FOREIGN KEY (IdUser) REFERENCES user (IdUser)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE wishlist');
    }
}
