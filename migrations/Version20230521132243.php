<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521132243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_grille ADD grille_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE details_grille ADD CONSTRAINT FK_E4770610985C2966 FOREIGN KEY (grille_id) REFERENCES grille_tarifaire (id)');
        $this->addSql('CREATE INDEX IDX_E4770610985C2966 ON details_grille (grille_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_grille DROP FOREIGN KEY FK_E4770610985C2966');
        $this->addSql('DROP INDEX IDX_E4770610985C2966 ON details_grille');
        $this->addSql('ALTER TABLE details_grille DROP grille_id');
    }
}
