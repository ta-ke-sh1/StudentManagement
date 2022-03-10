<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220310010850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE class_fgw ADD student_no INT NOT NULL, ADD year INT NOT NULL, ADD semester VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE user DROP avatar');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE class_fgw DROP student_no, DROP year, DROP semester');
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(255) NOT NULL');
    }
}
