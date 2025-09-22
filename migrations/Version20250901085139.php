<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250901085139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attendances (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, course_id INT NOT NULL, date DATE NOT NULL, status VARCHAR(20) NOT NULL, remarks LONGTEXT DEFAULT NULL, INDEX IDX_9C6B8FD4CB944F1A (student_id), INDEX IDX_9C6B8FD4591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classrooms (id INT AUTO_INCREMENT NOT NULL, teacher_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, level VARCHAR(10) NOT NULL, capacity INT NOT NULL, INDEX IDX_95F95DC241807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classroom_student (classroom_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_3DD26E1B6278D5A8 (classroom_id), INDEX IDX_3DD26E1BCB944F1A (student_id), PRIMARY KEY(classroom_id, student_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courses (id INT AUTO_INCREMENT NOT NULL, teacher_id INT NOT NULL, classroom_id INT NOT NULL, name VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, day_of_week VARCHAR(10) NOT NULL, INDEX IDX_A9A55A4C41807E1D (teacher_id), INDEX IDX_A9A55A4C6278D5A8 (classroom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grades (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, coefficient DOUBLE PRECISION DEFAULT NULL, subject VARCHAR(100) NOT NULL, date DATETIME NOT NULL, comments LONGTEXT DEFAULT NULL, INDEX IDX_3AE36110CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, date_of_birth DATE NOT NULL, gender VARCHAR(10) DEFAULT NULL, email VARCHAR(200) NOT NULL, phone VARCHAR(20) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_A4698DB2E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teachers (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(200) NOT NULL, phone VARCHAR(20) DEFAULT NULL, specialization VARCHAR(100) DEFAULT NULL, hire_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_ED071FF6E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attendances ADD CONSTRAINT FK_9C6B8FD4CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE attendances ADD CONSTRAINT FK_9C6B8FD4591CC992 FOREIGN KEY (course_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE classrooms ADD CONSTRAINT FK_95F95DC241807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id)');
        $this->addSql('ALTER TABLE classroom_student ADD CONSTRAINT FK_3DD26E1B6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classrooms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classroom_student ADD CONSTRAINT FK_3DD26E1BCB944F1A FOREIGN KEY (student_id) REFERENCES students (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C41807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id)');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C6278D5A8 FOREIGN KEY (classroom_id) REFERENCES classrooms (id)');
        $this->addSql('ALTER TABLE grades ADD CONSTRAINT FK_3AE36110CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendances DROP FOREIGN KEY FK_9C6B8FD4CB944F1A');
        $this->addSql('ALTER TABLE attendances DROP FOREIGN KEY FK_9C6B8FD4591CC992');
        $this->addSql('ALTER TABLE classrooms DROP FOREIGN KEY FK_95F95DC241807E1D');
        $this->addSql('ALTER TABLE classroom_student DROP FOREIGN KEY FK_3DD26E1B6278D5A8');
        $this->addSql('ALTER TABLE classroom_student DROP FOREIGN KEY FK_3DD26E1BCB944F1A');
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C41807E1D');
        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C6278D5A8');
        $this->addSql('ALTER TABLE grades DROP FOREIGN KEY FK_3AE36110CB944F1A');
        $this->addSql('DROP TABLE attendances');
        $this->addSql('DROP TABLE classrooms');
        $this->addSql('DROP TABLE classroom_student');
        $this->addSql('DROP TABLE courses');
        $this->addSql('DROP TABLE grades');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE teachers');
    }
}
