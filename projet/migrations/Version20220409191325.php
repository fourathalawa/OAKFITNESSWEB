<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409191325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD publication_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC38B217A7 ON commentaire (publication_id)');
        $this->addSql('ALTER TABLE panier DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE panier ADD PRIMARY KEY (id_client, id_commande, id_produit)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC38B217A7');
        $this->addSql('DROP INDEX IDX_67F068BC38B217A7 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP publication_id');
        $this->addSql('ALTER TABLE panier DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE panier ADD PRIMARY KEY (id_commande, id_produit, id_client)');
    }
}
