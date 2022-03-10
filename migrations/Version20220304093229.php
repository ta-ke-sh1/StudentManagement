<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220304093229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject_schedule ADD CONSTRAINT FK_62455193CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE subject_schedule ADD CONSTRAINT FK_6245519323EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE subject_schedule ADD CONSTRAINT FK_62455193EA000B10 FOREIGN KEY (class_id) REFERENCES class_fgw (id)');
        $this->addSql('ALTER TABLE subject_schedule ADD CONSTRAINT FK_6245519341807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject_schedule DROP FOREIGN KEY FK_62455193CB944F1A');
        $this->addSql('ALTER TABLE subject_schedule DROP FOREIGN KEY FK_6245519323EDC87');
        $this->addSql('ALTER TABLE subject_schedule DROP FOREIGN KEY FK_62455193EA000B10');
        $this->addSql('ALTER TABLE subject_schedule DROP FOREIGN KEY FK_6245519341807E1D');
    }
}
