<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190111103528 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, id_member_fk_id INT NOT NULL, title_article VARCHAR(100) NOT NULL, text_article LONGTEXT NOT NULL, date_article DATE NOT NULL, INDEX IDX_BFDD3168E497F951 (id_member_fk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, id_member_fk_id INT NOT NULL, id_article_fk_id INT NOT NULL, text_comment LONGTEXT NOT NULL, date_comment DATE NOT NULL, INDEX IDX_5F9E962AE497F951 (id_member_fk_id), INDEX IDX_5F9E962A6CE8BAA4 (id_article_fk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments_post (id INT AUTO_INCREMENT NOT NULL, id_member_fk_id INT NOT NULL, id_post_fk_id INT NOT NULL, text_comment_post LONGTEXT NOT NULL, date_comment_post DATE NOT NULL, INDEX IDX_DE5B412AE497F951 (id_member_fk_id), INDEX IDX_DE5B412A97E615E8 (id_post_fk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, id_membre_fk_id INT NOT NULL, id_article_fk_id INT NOT NULL, INDEX IDX_49CA4E7D30906323 (id_membre_fk_id), INDEX IDX_49CA4E7D6CE8BAA4 (id_article_fk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE members (id INT AUTO_INCREMENT NOT NULL, last_name VARCHAR(50) NOT NULL, first_name VARCHAR(50) NOT NULL, nickname VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, mail VARCHAR(200) NOT NULL, role VARCHAR(20) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts (id INT AUTO_INCREMENT NOT NULL, id_member_fk_id INT DEFAULT NULL, title_post VARCHAR(100) NOT NULL, text_post LONGTEXT NOT NULL, date_post DATE NOT NULL, INDEX IDX_885DBAFAE497F951 (id_member_fk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168E497F951 FOREIGN KEY (id_member_fk_id) REFERENCES members (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AE497F951 FOREIGN KEY (id_member_fk_id) REFERENCES members (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A6CE8BAA4 FOREIGN KEY (id_article_fk_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE comments_post ADD CONSTRAINT FK_DE5B412AE497F951 FOREIGN KEY (id_member_fk_id) REFERENCES members (id)');
        $this->addSql('ALTER TABLE comments_post ADD CONSTRAINT FK_DE5B412A97E615E8 FOREIGN KEY (id_post_fk_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D30906323 FOREIGN KEY (id_membre_fk_id) REFERENCES members (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D6CE8BAA4 FOREIGN KEY (id_article_fk_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAE497F951 FOREIGN KEY (id_member_fk_id) REFERENCES members (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A6CE8BAA4');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D6CE8BAA4');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168E497F951');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AE497F951');
        $this->addSql('ALTER TABLE comments_post DROP FOREIGN KEY FK_DE5B412AE497F951');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D30906323');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAE497F951');
        $this->addSql('ALTER TABLE comments_post DROP FOREIGN KEY FK_DE5B412A97E615E8');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE comments_post');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE members');
        $this->addSql('DROP TABLE posts');
    }
}
