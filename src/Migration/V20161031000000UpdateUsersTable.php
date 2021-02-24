<?php

namespace Miaoxing\User\Migration;

use Wei\Migration\BaseMigration;

class V20161031000000UpdateUsersTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->schema->table('users')
            ->uInt('score')->comment('积分')
            ->uDecimal('money', 16, 2)->comment('账户余额')
            ->uDecimal('recharge_money', 16, 2)->comment('充值账户余额')
            ->string('source', 16)->comment('用户来源');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->table('users')
            ->dropColumn([
                'score',
                'money',
                'recharge_money',
                'source',
            ])
            ->exec();
    }
}
