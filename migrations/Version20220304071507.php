<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220304071507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subject_schedule (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, subject_id INT DEFAULT NULL, class_id INT DEFAULT NULL, teacher_id INT DEFAULT NULL, date DATE NOT NULL, slot INT NOT NULL, INDEX IDX_62455193CB944F1A (student_id), INDEX IDX_6245519323EDC87 (subject_id), INDEX IDX_62455193EA000B10 (class_id), INDEX IDX_6245519341807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, dob DATE NOT NULL, phone VARCHAR(10) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subject_schedule ADD CONSTRAINT FK_62455193CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE subject_schedule ADD CONSTRAINT FK_6245519323EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE subject_schedule ADD CONSTRAINT FK_62455193EA000B10 FOREIGN KEY (class_id) REFERENCES class_fgw (id)');
        $this->addSql('ALTER TABLE subject_schedule ADD CONSTRAINT FK_6245519341807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE subject_schedule DROP FOREIGN KEY FK_6245519341807E1D');
        $this->addSql('DROP TABLE subject_schedule');
        $this->addSql('DROP TABLE teacher');
    }
}
