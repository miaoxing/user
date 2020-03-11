<?php

namespace Miaoxing\User\Service;

use Miaoxing\Plugin\Service\CurUser;
use Miaoxing\User\Model\UserV2Trait;

class CurUserV2 extends CurUser
{
    use UserV2Trait;

    public function profile()
    {
        $this->loadDbUser();
        return $this->hasOne(wei()->userProfileModel(), 'userId', 'id');
    }

    /**
     * NOTE: 暂时只有__set有效
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function __set($name, $value = null)
    {
        // __set start
        // Required services first
        if (in_array($name, $this->requiredServices)) {
            return $this->$name = $value;
        }

        // NOTE: 设置前需主动加载，否则状态变为loaded，不会再去加载
        $this->loadDbUser();

        $result = $this->set($name, $value, false);
        if ($result) {
            return;
        }

        if ($this->wei->has($name)) {
            return $this->$name = $value;
        }

        throw new \InvalidArgumentException('Invalid property: ' . $name);
        // __set end
    }

    /**
     * @param string $name
     * @return mixed
     * @see \Miaoxing\Services\Model\GetSetTrait::getColumnValue
     */
    protected function &getColumnValue($name)
    {
        // 未加载数据,已登录,session中存在需要的key
        if (!$this->isLoaded() && isset($this->session['user'][$name])) {
            // 存储变量，解决 Only variable references should be returned by reference
            $value = $this->getGetValue($name, $this->session['user'][$name]);
            return $value;
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
