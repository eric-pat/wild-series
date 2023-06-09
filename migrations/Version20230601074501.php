<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230601074501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nglayouts_block DROP FOREIGN KEY fk_ngl_block_layout');
        $this->addSql('ALTER TABLE nglayouts_block_collection DROP FOREIGN KEY fk_ngl_block_collection_block');
        $this->addSql('ALTER TABLE nglayouts_block_collection DROP FOREIGN KEY fk_ngl_block_collection_collection');
        $this->addSql('ALTER TABLE nglayouts_block_translation DROP FOREIGN KEY fk_ngl_block_translation_block');
        $this->addSql('ALTER TABLE nglayouts_collection_item DROP FOREIGN KEY fk_ngl_item_collection');
        $this->addSql('ALTER TABLE nglayouts_collection_query DROP FOREIGN KEY fk_ngl_query_collection');
        $this->addSql('ALTER TABLE nglayouts_collection_query_translation DROP FOREIGN KEY fk_ngl_query_translation_query');
        $this->addSql('ALTER TABLE nglayouts_collection_slot DROP FOREIGN KEY fk_ngl_slot_collection');
        $this->addSql('ALTER TABLE nglayouts_collection_translation DROP FOREIGN KEY fk_ngl_collection_translation_collection');
        $this->addSql('ALTER TABLE nglayouts_layout_translation DROP FOREIGN KEY fk_ngl_layout_translation_layout');
        $this->addSql('ALTER TABLE nglayouts_role_policy DROP FOREIGN KEY fk_ngl_policy_role');
        $this->addSql('ALTER TABLE nglayouts_rule_condition_rule DROP FOREIGN KEY fk_ngl_rule_condition_rule_rule_condition');
        $this->addSql('ALTER TABLE nglayouts_rule_condition_rule DROP FOREIGN KEY fk_ngl_rule_condition_rule_rule');
        $this->addSql('ALTER TABLE nglayouts_rule_condition_rule_group DROP FOREIGN KEY fk_ngl_rule_condition_rule_group_rule_group');
        $this->addSql('ALTER TABLE nglayouts_rule_condition_rule_group DROP FOREIGN KEY fk_ngl_rule_condition_rule_group_rule_condition');
        $this->addSql('ALTER TABLE nglayouts_rule_target DROP FOREIGN KEY fk_ngl_target_rule');
        $this->addSql('ALTER TABLE nglayouts_zone DROP FOREIGN KEY fk_ngl_zone_layout');
        $this->addSql('ALTER TABLE nglayouts_zone DROP FOREIGN KEY fk_ngl_zone_block');
        $this->addSql('DROP TABLE nglayouts_block');
        $this->addSql('DROP TABLE nglayouts_block_collection');
        $this->addSql('DROP TABLE nglayouts_block_translation');
        $this->addSql('DROP TABLE nglayouts_collection');
        $this->addSql('DROP TABLE nglayouts_collection_item');
        $this->addSql('DROP TABLE nglayouts_collection_query');
        $this->addSql('DROP TABLE nglayouts_collection_query_translation');
        $this->addSql('DROP TABLE nglayouts_collection_slot');
        $this->addSql('DROP TABLE nglayouts_collection_translation');
        $this->addSql('DROP TABLE nglayouts_layout');
        $this->addSql('DROP TABLE nglayouts_layout_translation');
        $this->addSql('DROP TABLE nglayouts_migration_versions');
        $this->addSql('DROP TABLE nglayouts_role');
        $this->addSql('DROP TABLE nglayouts_role_policy');
        $this->addSql('DROP TABLE nglayouts_rule');
        $this->addSql('DROP TABLE nglayouts_rule_condition');
        $this->addSql('DROP TABLE nglayouts_rule_condition_rule');
        $this->addSql('DROP TABLE nglayouts_rule_condition_rule_group');
        $this->addSql('DROP TABLE nglayouts_rule_data');
        $this->addSql('DROP TABLE nglayouts_rule_group');
        $this->addSql('DROP TABLE nglayouts_rule_group_data');
        $this->addSql('DROP TABLE nglayouts_rule_target');
        $this->addSql('DROP TABLE nglayouts_zone');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nglayouts_block (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, layout_id INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, depth INT NOT NULL, path VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, parent_id INT DEFAULT NULL, placeholder VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, position INT DEFAULT NULL, definition_identifier VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, view_type VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, item_view_type VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, config LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, translatable TINYINT(1) NOT NULL, main_locale VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, always_available TINYINT(1) NOT NULL, UNIQUE INDEX idx_ngl_block_uuid (uuid, status), INDEX idx_ngl_layout (layout_id, status), INDEX idx_ngl_parent_block (parent_id, placeholder, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_block_collection (block_id INT NOT NULL, block_status INT NOT NULL, identifier VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, collection_id INT NOT NULL, collection_status INT NOT NULL, INDEX idx_ngl_block (block_id, block_status), INDEX idx_ngl_collection (collection_id, collection_status), PRIMARY KEY(block_id, block_status, identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_block_translation (block_id INT NOT NULL, status INT NOT NULL, locale VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, parameters LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX IDX_55E27521E9ED820C7B00651C (block_id, status), PRIMARY KEY(block_id, status, locale)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_collection (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, start INT NOT NULL, length INT DEFAULT NULL, translatable TINYINT(1) NOT NULL, main_locale VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, always_available TINYINT(1) NOT NULL, UNIQUE INDEX idx_ngl_collection_uuid (uuid, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_collection_item (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, collection_id INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, position INT NOT NULL, value VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, value_type VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, view_type VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, config LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX idx_ngl_collection (collection_id, status), UNIQUE INDEX idx_ngl_collection_item_uuid (uuid, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_collection_query (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, collection_id INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX idx_ngl_collection (collection_id, status), UNIQUE INDEX idx_ngl_collection_query_uuid (uuid, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_collection_query_translation (query_id INT NOT NULL, status INT NOT NULL, locale VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, parameters LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX IDX_1CB940C5EF946F997B00651C (query_id, status), PRIMARY KEY(query_id, status, locale)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_collection_slot (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, collection_id INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, position INT NOT NULL, view_type VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX idx_ngl_collection (collection_id, status), UNIQUE INDEX idx_ngl_collection_slot_uuid (uuid, status), INDEX idx_ngl_position (collection_id, position), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_collection_translation (collection_id INT NOT NULL, status INT NOT NULL, locale VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX IDX_E4D7FEB5514956FD7B00651C (collection_id, status), PRIMARY KEY(collection_id, status, locale)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_layout (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created INT NOT NULL, modified INT NOT NULL, shared TINYINT(1) NOT NULL, main_locale VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX idx_ngl_layout_name (name), INDEX idx_ngl_layout_shared (shared), INDEX idx_ngl_layout_type (type), UNIQUE INDEX idx_ngl_layout_uuid (uuid, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_layout_translation (layout_id INT NOT NULL, status INT NOT NULL, locale VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX IDX_791FC2898C22AA1A7B00651C (layout_id, status), PRIMARY KEY(layout_id, status, locale)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_migration_versions (version VARCHAR(191) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, executed_at DATETIME DEFAULT NULL, execution_time INT DEFAULT NULL, PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_role (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, identifier VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX idx_ngl_role_identifier (identifier), UNIQUE INDEX idx_ngl_role_uuid (uuid, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_role_policy (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, role_id INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, component VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, permission VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, limitations LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX idx_ngl_policy_component (component), INDEX idx_ngl_policy_component_permission (component, permission), INDEX idx_ngl_role (role_id, status), UNIQUE INDEX idx_ngl_role_policy_uuid (uuid, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_rule (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, rule_group_id INT NOT NULL, layout_uuid CHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX idx_ngl_related_layout (layout_uuid), UNIQUE INDEX idx_ngl_rule_uuid (uuid, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_rule_condition (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX idx_ngl_rule_condition_uuid (uuid, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_rule_condition_rule (condition_id INT NOT NULL, condition_status INT NOT NULL, rule_id INT NOT NULL, rule_status INT NOT NULL, INDEX idx_ngl_rule (rule_id, rule_status), PRIMARY KEY(condition_id, condition_status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_rule_condition_rule_group (condition_id INT NOT NULL, condition_status INT NOT NULL, rule_group_id INT NOT NULL, rule_group_status INT NOT NULL, INDEX idx_ngl_rule_group (rule_group_id, rule_group_status), PRIMARY KEY(condition_id, condition_status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_rule_data (rule_id INT NOT NULL, enabled TINYINT(1) NOT NULL, priority INT NOT NULL, PRIMARY KEY(rule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_rule_group (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, depth INT NOT NULL, path VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, parent_id INT DEFAULT NULL, name VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, INDEX idx_ngl_parent_rule_group (parent_id), UNIQUE INDEX idx_ngl_rule_group_uuid (uuid, status), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_rule_group_data (rule_group_id INT NOT NULL, enabled TINYINT(1) NOT NULL, priority INT NOT NULL, PRIMARY KEY(rule_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_rule_target (id INT AUTO_INCREMENT NOT NULL, status INT NOT NULL, rule_id INT NOT NULL, uuid CHAR(36) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, value LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX idx_ngl_rule (rule_id, status), UNIQUE INDEX idx_ngl_rule_target_uuid (uuid, status), INDEX idx_ngl_target_type (type), PRIMARY KEY(id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nglayouts_zone (identifier VARCHAR(191) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, layout_id INT NOT NULL, status INT NOT NULL, root_block_id INT NOT NULL, linked_layout_uuid CHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, linked_zone_identifier VARCHAR(191) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX idx_ngl_layout (layout_id, status), INDEX idx_ngl_linked_zone (linked_layout_uuid, linked_zone_identifier), INDEX idx_ngl_root_block (root_block_id, status), PRIMARY KEY(identifier, layout_id, status)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE nglayouts_block ADD CONSTRAINT fk_ngl_block_layout FOREIGN KEY (layout_id, status) REFERENCES nglayouts_layout (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_block_collection ADD CONSTRAINT fk_ngl_block_collection_block FOREIGN KEY (block_id, block_status) REFERENCES nglayouts_block (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_block_collection ADD CONSTRAINT fk_ngl_block_collection_collection FOREIGN KEY (collection_id, collection_status) REFERENCES nglayouts_collection (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_block_translation ADD CONSTRAINT fk_ngl_block_translation_block FOREIGN KEY (block_id, status) REFERENCES nglayouts_block (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_collection_item ADD CONSTRAINT fk_ngl_item_collection FOREIGN KEY (collection_id, status) REFERENCES nglayouts_collection (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_collection_query ADD CONSTRAINT fk_ngl_query_collection FOREIGN KEY (collection_id, status) REFERENCES nglayouts_collection (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_collection_query_translation ADD CONSTRAINT fk_ngl_query_translation_query FOREIGN KEY (query_id, status) REFERENCES nglayouts_collection_query (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_collection_slot ADD CONSTRAINT fk_ngl_slot_collection FOREIGN KEY (collection_id, status) REFERENCES nglayouts_collection (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_collection_translation ADD CONSTRAINT fk_ngl_collection_translation_collection FOREIGN KEY (collection_id, status) REFERENCES nglayouts_collection (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_layout_translation ADD CONSTRAINT fk_ngl_layout_translation_layout FOREIGN KEY (layout_id, status) REFERENCES nglayouts_layout (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_role_policy ADD CONSTRAINT fk_ngl_policy_role FOREIGN KEY (role_id, status) REFERENCES nglayouts_role (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_rule_condition_rule ADD CONSTRAINT fk_ngl_rule_condition_rule_rule_condition FOREIGN KEY (condition_id, condition_status) REFERENCES nglayouts_rule_condition (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_rule_condition_rule ADD CONSTRAINT fk_ngl_rule_condition_rule_rule FOREIGN KEY (rule_id, rule_status) REFERENCES nglayouts_rule (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_rule_condition_rule_group ADD CONSTRAINT fk_ngl_rule_condition_rule_group_rule_group FOREIGN KEY (rule_group_id, rule_group_status) REFERENCES nglayouts_rule_group (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_rule_condition_rule_group ADD CONSTRAINT fk_ngl_rule_condition_rule_group_rule_condition FOREIGN KEY (condition_id, condition_status) REFERENCES nglayouts_rule_condition (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_rule_target ADD CONSTRAINT fk_ngl_target_rule FOREIGN KEY (rule_id, status) REFERENCES nglayouts_rule (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_zone ADD CONSTRAINT fk_ngl_zone_layout FOREIGN KEY (layout_id, status) REFERENCES nglayouts_layout (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nglayouts_zone ADD CONSTRAINT fk_ngl_zone_block FOREIGN KEY (root_block_id, status) REFERENCES nglayouts_block (id, status) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE user');
    }
}
