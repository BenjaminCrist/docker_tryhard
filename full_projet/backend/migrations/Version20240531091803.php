<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531091803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE todo (id INT AUTO_INCREMENT NOT NULL, todolist_id INT NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_5A0EB6A0AD16642A (todolist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE todolist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT FK_5A0EB6A0AD16642A FOREIGN KEY (todolist_id) REFERENCES todolist (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE todo DROP FOREIGN KEY FK_5A0EB6A0AD16642A');
        $this->addSql('DROP TABLE todo');
        $this->addSql('DROP TABLE todolist');
    }
}
