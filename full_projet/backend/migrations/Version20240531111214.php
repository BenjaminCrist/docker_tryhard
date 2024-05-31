<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531111214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE todo DROP FOREIGN KEY FK_5A0EB6A0AD16642A');
        $this->addSql('CREATE TABLE todo_list (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE todolist');
        $this->addSql('DROP INDEX IDX_5A0EB6A0AD16642A ON todo');
        $this->addSql('ALTER TABLE todo CHANGE todolist_id todo_list_id INT NOT NULL');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT FK_5A0EB6A0E8A7DCFA FOREIGN KEY (todo_list_id) REFERENCES todo_list (id)');
        $this->addSql('CREATE INDEX IDX_5A0EB6A0E8A7DCFA ON todo (todo_list_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE todo DROP FOREIGN KEY FK_5A0EB6A0E8A7DCFA');
        $this->addSql('CREATE TABLE todolist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(70) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE todo_list');
        $this->addSql('DROP INDEX IDX_5A0EB6A0E8A7DCFA ON todo');
        $this->addSql('ALTER TABLE todo CHANGE todo_list_id todolist_id INT NOT NULL');
        $this->addSql('ALTER TABLE todo ADD CONSTRAINT FK_5A0EB6A0AD16642A FOREIGN KEY (todolist_id) REFERENCES todolist (id)');
        $this->addSql('CREATE INDEX IDX_5A0EB6A0AD16642A ON todo (todolist_id)');
    }
}
