<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250704114554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_thumb ADD user_id INT DEFAULT NULL, ADD comment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment_thumb ADD CONSTRAINT FK_BCAD492AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment_thumb ADD CONSTRAINT FK_BCAD492AF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_BCAD492AA76ED395 ON comment_thumb (user_id)');
        $this->addSql('CREATE INDEX IDX_BCAD492AF8697D13 ON comment_thumb (comment_id)');
        $this->addSql('ALTER TABLE post_thumb ADD user_id INT DEFAULT NULL, ADD post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post_thumb ADD CONSTRAINT FK_822C5D34A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_thumb ADD CONSTRAINT FK_822C5D344B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_822C5D34A76ED395 ON post_thumb (user_id)');
        $this->addSql('CREATE INDEX IDX_822C5D344B89032C ON post_thumb (post_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_thumb DROP FOREIGN KEY FK_BCAD492AA76ED395');
        $this->addSql('ALTER TABLE comment_thumb DROP FOREIGN KEY FK_BCAD492AF8697D13');
        $this->addSql('DROP INDEX IDX_BCAD492AA76ED395 ON comment_thumb');
        $this->addSql('DROP INDEX IDX_BCAD492AF8697D13 ON comment_thumb');
        $this->addSql('ALTER TABLE comment_thumb DROP user_id, DROP comment_id');
        $this->addSql('ALTER TABLE post_thumb DROP FOREIGN KEY FK_822C5D34A76ED395');
        $this->addSql('ALTER TABLE post_thumb DROP FOREIGN KEY FK_822C5D344B89032C');
        $this->addSql('DROP INDEX IDX_822C5D34A76ED395 ON post_thumb');
        $this->addSql('DROP INDEX IDX_822C5D344B89032C ON post_thumb');
        $this->addSql('ALTER TABLE post_thumb DROP user_id, DROP post_id');
    }
}
