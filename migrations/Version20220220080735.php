<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220220080735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE class_fgw (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE class_fgw_subject (class_fgw_id INT NOT NULL, subject_id INT NOT NULL, INDEX IDX_A6D593DAE4C92006 (class_fgw_id), INDEX IDX_A6D593DA23EDC87 (subject_id), PRIMARY KEY(class_fgw_id, subject_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, class_fgw_id INT DEFAULT NULL, subject_id INT DEFAULT NULL, INDEX IDX_595AAE34CB944F1A (student_id), INDEX IDX_595AAE34E4C92006 (class_fgw_id), INDEX IDX_595AAE3423EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, dob DATE NOT NULL, major VARCHAR(50) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE class_fgw_subject ADD CONSTRAINT FK_A6D593DAE4C92006 FOREIGN KEY (class_fgw_id) REFERENCES class_fgw (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE class_fgw_subject ADD CONSTRAINT FK_A6D593DA23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34E4C92006 FOREIGN KEY (class_fgw_id) REFERENCES class_fgw (id)');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE3423EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE class_fgw_subject DROP FOREIGN KEY FK_A6D593DAE4C92006');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34E4C92006');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34CB944F1A');
        $this->addSql('ALTER TABLE class_fgw_subject DROP FOREIGN KEY FK_A6D593DA23EDC87');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE3423EDC87');
        $this->addSql('DROP TABLE class_fgw');
        $this->addSql('DROP TABLE class_fgw_subject');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE subject');
    }
}
