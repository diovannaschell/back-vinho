<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421162504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE item_pedido_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pedido_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produto_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item_pedido (id INT NOT NULL, produto_id INT NOT NULL, pedido_id INT NOT NULL, quantidade INT NOT NULL, valor_unitario DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42156301105CFD56 ON item_pedido (produto_id)');
        $this->addSql('CREATE INDEX IDX_421563014854653A ON item_pedido (pedido_id)');
        $this->addSql('CREATE TABLE pedido (id INT NOT NULL, data TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, valor_frete DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE produto (id INT NOT NULL, nome VARCHAR(100) NOT NULL, tipo VARCHAR(100) NOT NULL, peso DOUBLE PRECISION NOT NULL, valor DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE item_pedido ADD CONSTRAINT FK_42156301105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item_pedido ADD CONSTRAINT FK_421563014854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE item_pedido DROP CONSTRAINT FK_421563014854653A');
        $this->addSql('ALTER TABLE item_pedido DROP CONSTRAINT FK_42156301105CFD56');
        $this->addSql('DROP SEQUENCE item_pedido_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pedido_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produto_id_seq CASCADE');
        $this->addSql('DROP TABLE item_pedido');
        $this->addSql('DROP TABLE pedido');
        $this->addSql('DROP TABLE produto');
    }
}
