<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210715053704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, product_type_id INT NOT NULL, lot INT NOT NULL, expiration_date DATE NOT NULL, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, INDEX IDX_D34A04AD14959723 (product_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, buyer_id INT DEFAULT NULL, responsible_cancellation_id INT DEFAULT NULL, cancelled TINYINT(1) NOT NULL, quantity INT NOT NULL, INDEX IDX_E54BC0054584665A (product_id), INDEX IDX_E54BC0056C755722 (buyer_id), INDEX IDX_E54BC00552D6C62C (responsible_cancellation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD14959723 FOREIGN KEY (product_type_id) REFERENCES product_type (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC0054584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC0056C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sale ADD CONSTRAINT FK_E54BC00552D6C62C FOREIGN KEY (responsible_cancellation_id) REFERENCES user (id)');
        $this->addSql("INSERT INTO product_type (name) VALUES ('Ball'),('Carabiner'),('climbString'),('Bike')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC0054584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD14959723');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC0056C755722');
        $this->addSql('ALTER TABLE sale DROP FOREIGN KEY FK_E54BC00552D6C62C');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_type');
        $this->addSql('DROP TABLE sale');
        $this->addSql('DROP TABLE user');
    }
}
