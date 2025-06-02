<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250602075821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE news (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE news_category (news_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(news_id, category_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4F72BA90B5A459A0 ON news_category (news_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_4F72BA9012469DE2 ON news_category (category_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE news_category ADD CONSTRAINT FK_4F72BA90B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE news_category ADD CONSTRAINT FK_4F72BA9012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE news_category DROP CONSTRAINT FK_4F72BA90B5A459A0
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE news_category DROP CONSTRAINT FK_4F72BA9012469DE2
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE news
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE news_category
        SQL);
    }
}
