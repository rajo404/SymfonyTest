<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522005608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player_team DROP FOREIGN KEY team_id');
        $this->addSql('ALTER TABLE player_team DROP FOREIGN KEY player_id');
        $this->addSql('DROP TABLE player_team');
        $this->addSql('ALTER TABLE player ADD team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_98197A65296CD8AE ON player (team_id)');
        $this->addSql('ALTER TABLE team ADD player_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F99E6F5DF ON team (player_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE player_team (player_id INT NOT NULL, team_id INT NOT NULL, INDEX IDX_66FAF62C99E6F5DF (player_id), INDEX IDX_66FAF62C296CD8AE (team_id), PRIMARY KEY(player_id, team_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT team_id FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_team ADD CONSTRAINT player_id FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65296CD8AE');
        $this->addSql('DROP INDEX IDX_98197A65296CD8AE ON player');
        $this->addSql('ALTER TABLE player DROP team_id');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F99E6F5DF');
        $this->addSql('DROP INDEX IDX_C4E0A61F99E6F5DF ON team');
        $this->addSql('ALTER TABLE team DROP player_id');
    }
}