<?php

namespace Miaoxing\User\Migration;

use Miaoxing\Services\Migration\BaseMigration;

class V20161031000000UpdateUsersTable extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $table = $this->schema->table('users');
        $table
            ->char('wechat_open_id', 28)->comment('微信的OpenID')->after('group_id')
            ->char('wechat_union_id', 29)->after('wechat_open_id')
            ->int('score')->comment('积分')
            ->decimal('money', 16, 2)->comment('账户余额')
            ->decimal('recharge_money', 16, 2)->comment('充值账户余额')
            ->bool('is_subscribed')->comment('是否关注')
            ->timestamp('subscribed_at')->comment('关注时间')
            ->timestamp('unsubscribed_at')->comment('取关时间')
            ->string('source', 16)->comment('用户来源');

        $table->index('wechat_open_id')
            ->index('is_subscribed')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->schema->table('users')
            ->dropColumn([
                'wechat_open_id',
                'wechat_union_id',
                'score',
                'money',
                'recharge_money',
                'unsubscribed_at',
                'is_subscribed',
                'source',
            ])
            ->dropIndex(['wechat_open_id', 'is_subscribed'])
            ->exec();
    }
}
