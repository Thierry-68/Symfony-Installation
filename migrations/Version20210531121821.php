<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210531121821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programm ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE programm ADD CONSTRAINT FK_B46582612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_B46582612469DE2 ON programm (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE programm DROP FOREIGN KEY FK_B46582612469DE2');
        $this->addSql('DROP INDEX IDX_B46582612469DE2 ON programm');
        $this->addSql('ALTER TABLE programm DROP category_id');
    }
}
