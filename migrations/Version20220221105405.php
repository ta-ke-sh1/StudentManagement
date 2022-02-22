<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221105405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student ADD class_fgw_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33E4C92006 FOREIGN KEY (class_fgw_id) REFERENCES class_fgw (id)');
        $this->addSql('CREATE INDEX IDX_B723AF33E4C92006 ON student (class_fgw_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33E4C92006');
        $this->addSql('DROP INDEX IDX_B723AF33E4C92006 ON student');
        $this->addSql('ALTER TABLE student DROP class_fgw_id');
    }
}
