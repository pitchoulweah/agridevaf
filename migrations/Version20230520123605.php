<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230520123605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article_blog (id INT AUTO_INCREMENT NOT NULL, featured_image_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, featured_text VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_7057D6423569D950 (featured_image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_blog_categorie (article_blog_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_4A38B2F337323A20 (article_blog_id), INDEX IDX_4A38B2F3BCF5E72D (categorie_id), PRIMARY KEY(article_blog_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, utilisateur_id INT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9474526C7294869C (article_id), INDEX IDX_9474526CFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alt_text VARCHAR(255) DEFAULT NULL, filename VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_blog (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, category_id INT DEFAULT NULL, page_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, menu_order INT DEFAULT NULL, is_visible TINYINT(1) NOT NULL, link VARCHAR(255) DEFAULT NULL, INDEX IDX_85AA10D7294869C (article_id), INDEX IDX_85AA10D12469DE2 (category_id), INDEX IDX_85AA10DC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_blog_menu_blog (menu_blog_source INT NOT NULL, menu_blog_target INT NOT NULL, INDEX IDX_B4EEBC66A239C4FE (menu_blog_source), INDEX IDX_B4EEBC66BBDC9471 (menu_blog_target), PRIMARY KEY(menu_blog_source, menu_blog_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, value LONGTEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5A8600B05E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article_blog ADD CONSTRAINT FK_7057D6423569D950 FOREIGN KEY (featured_image_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE article_blog_categorie ADD CONSTRAINT FK_4A38B2F337323A20 FOREIGN KEY (article_blog_id) REFERENCES article_blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_blog_categorie ADD CONSTRAINT FK_4A38B2F3BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article_blog (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE menu_blog ADD CONSTRAINT FK_85AA10D7294869C FOREIGN KEY (article_id) REFERENCES article_blog (id)');
        $this->addSql('ALTER TABLE menu_blog ADD CONSTRAINT FK_85AA10D12469DE2 FOREIGN KEY (category_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE menu_blog ADD CONSTRAINT FK_85AA10DC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE menu_blog_menu_blog ADD CONSTRAINT FK_B4EEBC66A239C4FE FOREIGN KEY (menu_blog_source) REFERENCES menu_blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_blog_menu_blog ADD CONSTRAINT FK_B4EEBC66BBDC9471 FOREIGN KEY (menu_blog_target) REFERENCES menu_blog (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_blog DROP FOREIGN KEY FK_7057D6423569D950');
        $this->addSql('ALTER TABLE article_blog_categorie DROP FOREIGN KEY FK_4A38B2F337323A20');
        $this->addSql('ALTER TABLE article_blog_categorie DROP FOREIGN KEY FK_4A38B2F3BCF5E72D');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CFB88E14F');
        $this->addSql('ALTER TABLE menu_blog DROP FOREIGN KEY FK_85AA10D7294869C');
        $this->addSql('ALTER TABLE menu_blog DROP FOREIGN KEY FK_85AA10D12469DE2');
        $this->addSql('ALTER TABLE menu_blog DROP FOREIGN KEY FK_85AA10DC4663E4');
        $this->addSql('ALTER TABLE menu_blog_menu_blog DROP FOREIGN KEY FK_B4EEBC66A239C4FE');
        $this->addSql('ALTER TABLE menu_blog_menu_blog DROP FOREIGN KEY FK_B4EEBC66BBDC9471');
        $this->addSql('DROP TABLE article_blog');
        $this->addSql('DROP TABLE article_blog_categorie');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE menu_blog');
        $this->addSql('DROP TABLE menu_blog_menu_blog');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE page');
    }
}
