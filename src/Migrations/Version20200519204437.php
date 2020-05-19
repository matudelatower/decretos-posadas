<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519204437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE palabra_clave (id INT AUTO_INCREMENT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_8CAF1CFAFE35D8C4 (creado_por_id), INDEX IDX_8CAF1CFAF6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE decreto (id INT AUTO_INCREMENT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, numero VARCHAR(255) NOT NULL, anio VARCHAR(255) NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, fecha DATE NOT NULL, destacado TINYINT(1) DEFAULT NULL, archivo VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_7D4A851BFE35D8C4 (creado_por_id), INDEX IDX_7D4A851BF6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE decreto_palabra_clave (decreto_id INT NOT NULL, palabra_clave_id INT NOT NULL, INDEX IDX_58D28D34A6CF4D5C (decreto_id), INDEX IDX_58D28D347E0CD09E (palabra_clave_id), PRIMARY KEY(decreto_id, palabra_clave_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE palabra_clave ADD CONSTRAINT FK_8CAF1CFAFE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE palabra_clave ADD CONSTRAINT FK_8CAF1CFAF6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE decreto ADD CONSTRAINT FK_7D4A851BFE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE decreto ADD CONSTRAINT FK_7D4A851BF6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE decreto_palabra_clave ADD CONSTRAINT FK_58D28D34A6CF4D5C FOREIGN KEY (decreto_id) REFERENCES decreto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE decreto_palabra_clave ADD CONSTRAINT FK_58D28D347E0CD09E FOREIGN KEY (palabra_clave_id) REFERENCES palabra_clave (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE decreto_palabra_clave DROP FOREIGN KEY FK_58D28D347E0CD09E');
        $this->addSql('ALTER TABLE palabra_clave DROP FOREIGN KEY FK_8CAF1CFAFE35D8C4');
        $this->addSql('ALTER TABLE palabra_clave DROP FOREIGN KEY FK_8CAF1CFAF6167A1C');
        $this->addSql('ALTER TABLE decreto DROP FOREIGN KEY FK_7D4A851BFE35D8C4');
        $this->addSql('ALTER TABLE decreto DROP FOREIGN KEY FK_7D4A851BF6167A1C');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE decreto_palabra_clave DROP FOREIGN KEY FK_58D28D34A6CF4D5C');
        $this->addSql('DROP TABLE palabra_clave');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE decreto');
        $this->addSql('DROP TABLE decreto_palabra_clave');
        $this->addSql('DROP TABLE reset_password_request');
    }
}
