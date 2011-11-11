<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20111111113035 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE club_team_schedule ADD location_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE club_team_schedule ADD CONSTRAINT FK_5FBD8B3164D218E FOREIGN KEY (location_id) REFERENCES club_user_location(id)");
        $this->addSql("CREATE INDEX IDX_5FBD8B3164D218E ON club_team_schedule (location_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE club_team_schedule DROP FOREIGN KEY FK_5FBD8B3164D218E");
        $this->addSql("DROP INDEX IDX_5FBD8B3164D218E ON club_team_schedule");
        $this->addSql("ALTER TABLE club_team_schedule DROP location_id");
    }
}