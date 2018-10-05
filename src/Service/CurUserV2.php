<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\Service\CurUser;
use Miaoxing\User\Model\UserV2Trait;

class CurUserV2 extends CurUser
{
    use UserV2Trait;

    /**
     * @param string $name
     * @return mixed
     * @see \Miaoxing\Plugin\Model\GetSetTrait::getColumnValue
     */
    protected function &getColumnValue($name)
    {
        // 未加载数据,已登录,session中存在需要的key
        if (!$this->isLoaded() && isset($this->session['user'][$name])) {
            return $this->getGetValue($name, $this->session['user'][$name]);
        }

        $this->loadDbUser();

        // getColumnValue start
        $name = $this->filterInputColumn($name);
        $value = parent::get($name);

        $source = $this->getDataSource($name);
        if ($source === 'php') {
            return $this->data[$name];
        }

        // 用户数据则先转换为db数据
        if ($source === 'user') {
            $value = $this->getSetValue($name, $value);
        }

        // 通过getter处理数据
        $this->data[$name] = $this->getGetValue($name, $value);
        $this->setDataSource($name, 'php');

        return $this->data[$name];
        // getColumnValue end
    }
}
