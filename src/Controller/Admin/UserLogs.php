<?php

namespace Miaoxing\User\Controller\Admin;

class UserLogs extends \miaoxing\plugin\BaseController
{
    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $userLogs = wei()->userLog()->curApp();

                // 分页
                $userLogs->limit($req['rows'])->page($req['page']);

                // 排序
                $userLogs->desc('id');

                if ($req['actionName']) {
                    $userLogs->andWhere('action LIKE ?', $req['actionName'] . '%');
                }

                if (wei()->isPresent($req['confirm'])) {
                    if ($req['confirm']) {
                        $userLogs->andWhere('confirmUser != 0');
                    } else {
                        $userLogs->andWhere('confirmUser = 0');
                    }
                }

                $data = [];
                foreach ($userLogs as $userLog) {
                    $data[] = $userLog->toArray() + [
                            'user' => $userLog->getUser()->toArray(),
                        ];
                }

                return $this->suc([
                    'message' => '读取列表成功',
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $userLogs->count(),
                ]);

            default:
                return get_defined_vars();
        }
    }

    public function confirmAction($req)
    {
        $userLog = wei()->userLog()->curApp()->findOneById($req['id']);

        if ($userLog['confirmUser']) {
            return $this->err('该项已确认过');
        }

        $userLog->save([
            'confirmUser' => $this->curUser['id'],
            'confirmTime' => date('Y-m-d H:i:s'),
        ]);

        return $this->suc();
    }
}
