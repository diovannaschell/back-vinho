<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421200220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_pedido DROP CONSTRAINT fk_42156301105cfd56');
        $this->addSql('DROP SEQUENCE produto_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE vinho_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE vinho (id INT NOT NULL, nome VARCHAR(100) NOT NULL, tipo VARCHAR(100) NOT NULL, peso DOUBLE PRECISION NOT NULL, valor DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP INDEX idx_42156301105cfd56');
        $this->addSql('ALTER TABLE item_pedido RENAME COLUMN produto_id TO vinho_id');
        $this->addSql('ALTER TABLE item_pedido ADD CONSTRAINT FK_4215630170CAE799 FOREIGN KEY (vinho_id) REFERENCES vinho (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4215630170CAE799 ON item_pedido (vinho_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE item_pedido DROP CONSTRAINT FK_4215630170CAE799');
        $this->addSql('DROP SEQUENCE vinho_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE produto_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE produto (id INT NOT NULL, nome VARCHAR(100) NOT NULL, tipo VARCHAR(100) NOT NULL, peso DOUBLE PRECISION NOT NULL, valor DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE vinho');
        $this->addSql('DROP INDEX IDX_4215630170CAE799');
        $this->addSql('ALTER TABLE item_pedido RENAME COLUMN vinho_id TO produto_id');
        $this->addSql('ALTER TABLE item_pedido ADD CONSTRAINT fk_42156301105cfd56 FOREIGN KEY (produto_id) REFERENCES produto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_42156301105cfd56 ON item_pedido (produto_id)');
    }
}
