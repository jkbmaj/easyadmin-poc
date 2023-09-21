<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230919222758 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE message_sent (id INT AUTO_INCREMENT NOT NULL, newsletter_id INT NOT NULL, recipient_id INT NOT NULL, message_id VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_1351B17022DB1917 (newsletter_id), INDEX IDX_1351B170E92F8F78 (recipient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, template_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, is_sent TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_7E8585C85DA0FB8 (template_id), INDEX IDX_7E8585C8B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter_template (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_4A62D9E9B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recipient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, consent_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', verified_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', source VARCHAR(255) DEFAULT NULL, browser VARCHAR(255) DEFAULT NULL, ip VARCHAR(255) DEFAULT NULL, token VARCHAR(50) DEFAULT NULL, unsubscribed_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_sent ADD CONSTRAINT FK_1351B17022DB1917 FOREIGN KEY (newsletter_id) REFERENCES newsletter (id)');
        $this->addSql('ALTER TABLE message_sent ADD CONSTRAINT FK_1351B170E92F8F78 FOREIGN KEY (recipient_id) REFERENCES recipient (id)');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C85DA0FB8 FOREIGN KEY (template_id) REFERENCES newsletter_template (id)');
        $this->addSql('ALTER TABLE newsletter ADD CONSTRAINT FK_7E8585C8B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE newsletter_template ADD CONSTRAINT FK_4A62D9E9B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE message_sent DROP FOREIGN KEY FK_1351B17022DB1917');
        $this->addSql('ALTER TABLE message_sent DROP FOREIGN KEY FK_1351B170E92F8F78');
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C85DA0FB8');
        $this->addSql('ALTER TABLE newsletter DROP FOREIGN KEY FK_7E8585C8B03A8386');
        $this->addSql('ALTER TABLE newsletter_template DROP FOREIGN KEY FK_4A62D9E9B03A8386');
        $this->addSql('DROP TABLE message_sent');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE newsletter_template');
        $this->addSql('DROP TABLE recipient');
        $this->addSql('DROP TABLE user');
    }
}
