<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RoleUserMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $userRole = $this->table('role_user');
        $userRole->addColumn('role_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addForeignKey('role_id', 'roles', 'id', ['delete'=> 'CASCADE'])
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE'])
            ->create();
    }
}
