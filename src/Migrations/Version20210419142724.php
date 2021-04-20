<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419142724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE resolucion (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(255) NOT NULL, anio VARCHAR(255) NOT NULL, descripcion VARCHAR(255) DEFAULT NULL, fecha DATE NOT NULL, destacado TINYINT(1) DEFAULT NULL, archivo VARCHAR(255) DEFAULT NULL, texto LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resolucion_palabra_clave (resolucion_id INT NOT NULL, palabra_clave_id INT NOT NULL, INDEX IDX_F3332793B0D8667A (resolucion_id), INDEX IDX_F33327937E0CD09E (palabra_clave_id), PRIMARY KEY(resolucion_id, palabra_clave_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resolucion_palabra_clave ADD CONSTRAINT FK_F3332793B0D8667A FOREIGN KEY (resolucion_id) REFERENCES resolucion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE resolucion_palabra_clave ADD CONSTRAINT FK_F33327937E0CD09E FOREIGN KEY (palabra_clave_id) REFERENCES palabra_clave (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE resolucion_palabra_clave DROP FOREIGN KEY FK_F3332793B0D8667A');
        $this->addSql('DROP TABLE resolucion');
        $this->addSql('DROP TABLE resolucion_palabra_clave');
    }
}
