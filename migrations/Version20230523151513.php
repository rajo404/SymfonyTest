<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523151513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_teams (user_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_7400D900A76ED395 (user_id), INDEX IDX_7400D900296CD8AE (team_id), PRIMARY KEY(user_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_teams ADD CONSTRAINT FK_7400D900A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_teams ADD CONSTRAINT FK_7400D900296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_teams DROP FOREIGN KEY FK_7400D900296CD8AE');
        $this->addSql('ALTER TABLE user_teams DROP FOREIGN KEY FK_7400D900A76ED395');
        $this->addSql('DROP TABLE user_teams');
    }
}
