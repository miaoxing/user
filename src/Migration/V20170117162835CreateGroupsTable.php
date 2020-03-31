<?php

namespace Miaoxing\User\Migration;

use Miaoxing\Services\Migration\BaseMigration;

class V20170117162835CreateGroupsTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('groups')->tableComment('用户分组')
            ->id()
            ->string('name', 64)
            ->int('sort')->defaults(50)
            ->tinyInt('status')
            ->timestamps()
            ->userstamps()
            ->softDeletable()
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->dropIfExists('groups');
    }
}
