<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419143005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE resolucion ADD creado_por_id INT DEFAULT NULL, ADD actualizado_por_id INT DEFAULT NULL, ADD activo TINYINT(1) NOT NULL, ADD fecha_creacion DATETIME NOT NULL, ADD fecha_actualizacion DATETIME NOT NULL');
        $this->addSql('ALTER TABLE resolucion ADD CONSTRAINT FK_301D60ACFE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resolucion ADD CONSTRAINT FK_301D60ACF6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_301D60ACFE35D8C4 ON resolucion (creado_por_id)');
        $this->addSql('CREATE INDEX IDX_301D60ACF6167A1C ON resolucion (actualizado_por_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE resolucion DROP FOREIGN KEY FK_301D60ACFE35D8C4');
        $this->addSql('ALTER TABLE resolucion DROP FOREIGN KEY FK_301D60ACF6167A1C');
        $this->addSql('DROP INDEX IDX_301D60ACFE35D8C4 ON resolucion');
        $this->addSql('DROP INDEX IDX_301D60ACF6167A1C ON resolucion');
        $this->addSql('ALTER TABLE resolucion DROP creado_por_id, DROP actualizado_por_id, DROP activo, DROP fecha_creacion, DROP fecha_actualizacion');
    }
}
