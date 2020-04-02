<?php

namespace Miaoxing\User\Service;

class GroupModel
{
    /**
     * Executes the generated SQL and returns the found record object or false
     *
     * @param int|string $id
     * @return $this|null
     * @api
     */
    public function find($id)
    {
    }

    /**
     * Find a record by primary key, or throws 404 exception if record not found
     *
     * @param int|string $id
     * @return $this
     * @throws \Exception
     * @api
     */
    public function findOrFail($id)
    {
    }

    /**
     * Find a record by primary key, or init with the specified data if record not found
     *
     * @param int|string $id
     * @param array|object $data
     * @return $this
     * @api
     */
    public function findOrInit($id = null, $data = [])
    {
    }

    /**
     * Executes the generated SQL and returns the found record collection object or false
     *
     * @param array $ids
     * @return $this|$this[]
     * @api
     */
    public function findAll($ids)
    {
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return $this|null
     * @api
     */
    public function findBy($column, $operator = null, $value = null)
    {
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return $this
     * @api
     */
    public function findAllBy($column, $operator = null, $value = null)
    {
    }

    /**
     * @param $attributes
     * @param array $data
     * @return $this
     * @api
     */
    public function findOrInitBy($attributes, $data = [])
    {
    }

    /**
     * Find a record by primary key value and throws 404 exception if record not found
     *
     * @param $column
     * @param $operator
     * @param mixed $value
     * @return $this
     * @throws \Exception
     * @api
     */
    public function findByOrFail($column, $operator = null, $value = null)
    {
    }

    /**
     * Executes the generated SQL and returns the found record object or null if not found
     *
     * @return $this|null
     * @api
     */
    public function first()
    {
    }

    /**
     * @return $this
     * @api
     */
    public function all()
    {
    }

    /**
     * @param string $column
     * @param string|null $index
     * @return array
     * @api
     */
    public function pluck(string $column, string $index = null)
    {
    }

    /**
     * @param int $count
     * @param callable $callback
     * @return bool
     * @api
     */
    public function chunk(int $count, callable $callback)
    {
    }

    /**
     * Executes a COUNT query to receive the rows number
     *
     * @param string $column
     * @return int
     * @api
     */
    public function cnt($column = '*')
    {
    }

    /**
     * Sets the position of the first result to retrieve (the "offset")
     *
     * @param integer $offset The first result to return
     * @return $this
     * @api
     */
    public function offset($offset)
    {
    }

    /**
     * Sets the maximum number of results to retrieve (the "limit")
     *
     * @param integer $limit The maximum number of results to retrieve
     * @return $this
     * @api
     */
    public function limit($limit)
    {
    }

    /**
     * Sets the page number, the "OFFSET" value is equals "($page - 1) * LIMIT"
     *
     * @param int $page The page number
     * @return $this
     * @api
     */
    public function page($page)
    {
    }

    /**
     * Specifies an item that is to be returned in the query result.
     * Replaces any previously specified selections, if any.
     *
     * @param string|array $columns The selection expressions.
     * @return $this
     * @api
     */
    public function select($columns = ['*']): self
    {
    }

    /**
     * @param $columns
     * @return $this
     * @api
     */
    public function selectDistinct($columns)
    {
    }

    /**
     * @param string $expression
     * @return $this
     * @api
     */
    public function selectRaw($expression)
    {
    }

    /**
     * Specifies columns that are not to be returned in the query result.
     * Replaces any previously specified selections, if any.
     *
     * @param string|array $columns
     * @return $this
     * @api
     */
    public function selectExcept($columns)
    {
    }

    /**
     * Sets table for FROM query
     *
     * @param string $from The table
     * @return $this
     * @api
     */
    public function from($from)
    {
    }

    /**
     * @param string $table
     * @return $this
     * @api
     */
    public function table(string $table): self
    {
    }

    /**
     * Adds a inner join to the query
     *
     * @param string $table The table name to join
     * @param string $on The condition for the join
     * @return $this
     * @api
     */
    public function join($table, $on = null)
    {
    }

    /**
     * Adds a inner join to the query
     *
     * @param string $table The table name to join
     * @param string $on The condition for the join
     * @return $this
     * @api
     */
    public function innerJoin($table, $on = null)
    {
    }

    /**
     * Adds a left join to the query
     *
     * @param string $table The table name to join
     * @param string $on The condition for the join
     * @return $this
     * @api
     */
    public function leftJoin($table, $on = null)
    {
    }

    /**
     * Adds a right join to the query
     *
     * @param string $table The table name to join
     * @param string $on The condition for the join
     * @return $this
     * @api
     */
    public function rightJoin($table, $on = null)
    {
    }

    /**
     * Specifies one or more restrictions to the query result.
     * Replaces any previously specified restrictions, if any.
     *
     * ```php
     * $user = wei()->db('user')->where('id = 1');
     * $user = wei()->db('user')->where('id = ?', 1);
     * $users = wei()->db('user')->where(array('id' => '1', 'username' => 'twin'));
     * $users = wei()->where(array('id' => array('1', '2', '3')));
     * ```
     *
     * @param string|array $column
     * @param null $operator
     * @param null $value
     * @return $this
     * @api
     */
    public function where($column, $operator = null, $value = null)
    {
    }

    /**
     * @param string $expression
     * @param array $params
     * @return $this
     * @api
     */
    public function whereRaw($expression, $params = [])
    {
    }

    /**
     * @param $column
     * @param array $params
     * @return $this
     * @api
     */
    public function whereBetween($column, array $params)
    {
    }

    /**
     * @param $column
     * @param array $params
     * @return $this
     * @api
     */
    public function whereNotBetween($column, array $params)
    {
    }

    /**
     * @param $column
     * @param array $params
     * @return $this
     * @api
     */
    public function whereIn($column, array $params)
    {
    }

    /**
     * @param $column
     * @param array $params
     * @return $this
     * @api
     */
    public function whereNotIn($column, array $params)
    {
    }

    /**
     * @param $column
     * @return $this
     * @api
     */
    public function whereNull($column)
    {
    }

    /**
     * @param $column
     * @return $this
     * @api
     */
    public function whereNotNULL($column)
    {
    }

    /**
     * @param $column
     * @param $opOrValue
     * @param null $value
     * @return $this
     * @api
     */
    public function whereDate($column, $opOrValue, $value = null)
    {
    }

    /**
     * @param $column
     * @param $opOrValue
     * @param null $value
     * @return $this
     * @api
     */
    public function whereMonth($column, $opOrValue, $value = null)
    {
    }

    /**
     * @param $column
     * @param $opOrValue
     * @param null $value
     * @return $this
     * @api
     */
    public function whereDay($column, $opOrValue, $value = null)
    {
    }

    /**
     * @param $column
     * @param $opOrValue
     * @param null $value
     * @return $this
     * @api
     */
    public function whereYear($column, $opOrValue, $value = null)
    {
    }

    /**
     * @param $column
     * @param $opOrValue
     * @param null $value
     * @return $this
     * @api
     */
    public function whereTime($column, $opOrValue, $value = null)
    {
    }

    /**
     * @param $column
     * @param $opOrColumn2
     * @param null $column2
     * @return $this
     * @api
     */
    public function whereColumn($column, $opOrColumn2, $column2 = null)
    {
    }

    /**
     * 搜索字段是否包含某个值
     *
     * @param string $column
     * @param string $value
     * @param string $condition
     * @return $this
     * @api
     */
    public function whereContains($column, $value, string $condition = 'AND')
    {
    }

    /**
     * @param $column
     * @param $value
     * @param string $condition
     * @return $this
     * @api
     */
    public function whereNotContains($column, $value, string $condition = 'OR')
    {
    }

    /**
     * Specifies a grouping over the results of the query.
     * Replaces any previously specified groupings, if any.
     *
     * @param mixed $column The grouping column.
     * @return $this
     * @api
     */
    public function groupBy($column)
    {
    }

    /**
     * Specifies a restriction over the groups of the query.
     * Replaces any previous having restrictions, if any.
     *
     * @param string $conditions The having conditions
     * @param array $params The condition parameters
     * @param array $types The parameter types
     * @return $this
     * @api
     */
    public function having($column, $operator, $value = null, $condition = 'AND')
    {
    }

    /**
     * Specifies an ordering for the query results.
     * Replaces any previously specified orderings, if any.
     *
     * @param string $column The ordering expression.
     * @param string $order The ordering direction.
     * @return $this
     * @api
     */
    public function orderBy($column, $order = 'ASC')
    {
    }

    /**
     * Adds a DESC ordering to the query
     *
     * @param string $field The name of field
     * @return $this
     * @api
     */
    public function desc($field)
    {
    }

    /**
     * Add an ASC ordering to the query
     *
     * @param string $field The name of field
     * @return $this
     * @api
     */
    public function asc($field)
    {
    }

    /**
     * @return $this
     * @api
     */
    public function forUpdate()
    {
    }

    /**
     * @return $this
     * @api
     */
    public function forShare()
    {
    }

    /**
     * @param string $lock
     * @return $this
     * @api
     */
    public function lock($lock)
    {
    }

    /**
     * @param mixed $value
     * @param callable $callback
     * @param callable|null $default
     * @return $this
     * @api
     */
    public function when($value, $callback, callable $default = null)
    {
    }

    /**
     * @param mixed $value
     * @param callable $callback
     * @param callable|null $default
     * @return $this
     * @api
     */
    public function unless($value, callable $callback, callable $default = null)
    {
    }
}

if (0) {
    class GroupModel
    {
        /**
         * Executes the generated SQL and returns the found record object or false
         *
         * @param int|string $id
         * @return $this|null
         * @api
         */
        public static function find($id)
        {
        }
    
        /**
         * Find a record by primary key, or throws 404 exception if record not found
         *
         * @param int|string $id
         * @return $this
         * @throws \Exception
         * @api
         */
        public static function findOrFail($id)
        {
        }
    
        /**
         * Find a record by primary key, or init with the specified data if record not found
         *
         * @param int|string $id
         * @param array|object $data
         * @return $this
         * @api
         */
        public static function findOrInit($id = null, $data = [])
        {
        }
    
        /**
         * Executes the generated SQL and returns the found record collection object or false
         *
         * @param array $ids
         * @return $this|$this[]
         * @api
         */
        public static function findAll($ids)
        {
        }
    
        /**
         * @param $column
         * @param null $operator
         * @param null $value
         * @return $this|null
         * @api
         */
        public static function findBy($column, $operator = null, $value = null)
        {
        }
    
        /**
         * @param $column
         * @param null $operator
         * @param null $value
         * @return $this
         * @api
         */
        public static function findAllBy($column, $operator = null, $value = null)
        {
        }
    
        /**
         * @param $attributes
         * @param array $data
         * @return $this
         * @api
         */
        public static function findOrInitBy($attributes, $data = [])
        {
        }
    
        /**
         * Find a record by primary key value and throws 404 exception if record not found
         *
         * @param $column
         * @param $operator
         * @param mixed $value
         * @return $this
         * @throws \Exception
         * @api
         */
        public static function findByOrFail($column, $operator = null, $value = null)
        {
        }
    
        /**
         * Executes the generated SQL and returns the found record object or null if not found
         *
         * @return $this|null
         * @api
         */
        public static function first()
        {
        }
    
        /**
         * @return $this
         * @api
         */
        public static function all()
        {
        }
    
        /**
         * @param string $column
         * @param string|null $index
         * @return array
         * @api
         */
        public static function pluck(string $column, string $index = null)
        {
        }
    
        /**
         * @param int $count
         * @param callable $callback
         * @return bool
         * @api
         */
        public static function chunk(int $count, callable $callback)
        {
        }
    
        /**
         * Executes a COUNT query to receive the rows number
         *
         * @param string $column
         * @return int
         * @api
         */
        public static function cnt($column = '*')
        {
        }
    
        /**
         * Sets the position of the first result to retrieve (the "offset")
         *
         * @param integer $offset The first result to return
         * @return $this
         * @api
         */
        public static function offset($offset)
        {
        }
    
        /**
         * Sets the maximum number of results to retrieve (the "limit")
         *
         * @param integer $limit The maximum number of results to retrieve
         * @return $this
         * @api
         */
        public static function limit($limit)
        {
        }
    
        /**
         * Sets the page number, the "OFFSET" value is equals "($page - 1) * LIMIT"
         *
         * @param int $page The page number
         * @return $this
         * @api
         */
        public static function page($page)
        {
        }
    
        /**
         * Specifies an item that is to be returned in the query result.
         * Replaces any previously specified selections, if any.
         *
         * @param string|array $columns The selection expressions.
         * @return $this
         * @api
         */
        public static function select($columns = ['*']): self
        {
        }
    
        /**
         * @param $columns
         * @return $this
         * @api
         */
        public static function selectDistinct($columns)
        {
        }
    
        /**
         * @param string $expression
         * @return $this
         * @api
         */
        public static function selectRaw($expression)
        {
        }
    
        /**
         * Specifies columns that are not to be returned in the query result.
         * Replaces any previously specified selections, if any.
         *
         * @param string|array $columns
         * @return $this
         * @api
         */
        public static function selectExcept($columns)
        {
        }
    
        /**
         * Sets table for FROM query
         *
         * @param string $from The table
         * @return $this
         * @api
         */
        public static function from($from)
        {
        }
    
        /**
         * @param string $table
         * @return $this
         * @api
         */
        public static function table(string $table): self
        {
        }
    
        /**
         * Adds a inner join to the query
         *
         * @param string $table The table name to join
         * @param string $on The condition for the join
         * @return $this
         * @api
         */
        public static function join($table, $on = null)
        {
        }
    
        /**
         * Adds a inner join to the query
         *
         * @param string $table The table name to join
         * @param string $on The condition for the join
         * @return $this
         * @api
         */
        public static function innerJoin($table, $on = null)
        {
        }
    
        /**
         * Adds a left join to the query
         *
         * @param string $table The table name to join
         * @param string $on The condition for the join
         * @return $this
         * @api
         */
        public static function leftJoin($table, $on = null)
        {
        }
    
        /**
         * Adds a right join to the query
         *
         * @param string $table The table name to join
         * @param string $on The condition for the join
         * @return $this
         * @api
         */
        public static function rightJoin($table, $on = null)
        {
        }
    
        /**
         * Specifies one or more restrictions to the query result.
         * Replaces any previously specified restrictions, if any.
         *
         * ```php
         * $user = wei()->db('user')->where('id = 1');
         * $user = wei()->db('user')->where('id = ?', 1);
         * $users = wei()->db('user')->where(array('id' => '1', 'username' => 'twin'));
         * $users = wei()->where(array('id' => array('1', '2', '3')));
         * ```
         *
         * @param string|array $column
         * @param null $operator
         * @param null $value
         * @return $this
         * @api
         */
        public static function where($column, $operator = null, $value = null)
        {
        }
    
        /**
         * @param string $expression
         * @param array $params
         * @return $this
         * @api
         */
        public static function whereRaw($expression, $params = [])
        {
        }
    
        /**
         * @param $column
         * @param array $params
         * @return $this
         * @api
         */
        public static function whereBetween($column, array $params)
        {
        }
    
        /**
         * @param $column
         * @param array $params
         * @return $this
         * @api
         */
        public static function whereNotBetween($column, array $params)
        {
        }
    
        /**
         * @param $column
         * @param array $params
         * @return $this
         * @api
         */
        public static function whereIn($column, array $params)
        {
        }
    
        /**
         * @param $column
         * @param array $params
         * @return $this
         * @api
         */
        public static function whereNotIn($column, array $params)
        {
        }
    
        /**
         * @param $column
         * @return $this
         * @api
         */
        public static function whereNull($column)
        {
        }
    
        /**
         * @param $column
         * @return $this
         * @api
         */
        public static function whereNotNULL($column)
        {
        }
    
        /**
         * @param $column
         * @param $opOrValue
         * @param null $value
         * @return $this
         * @api
         */
        public static function whereDate($column, $opOrValue, $value = null)
        {
        }
    
        /**
         * @param $column
         * @param $opOrValue
         * @param null $value
         * @return $this
         * @api
         */
        public static function whereMonth($column, $opOrValue, $value = null)
        {
        }
    
        /**
         * @param $column
         * @param $opOrValue
         * @param null $value
         * @return $this
         * @api
         */
        public static function whereDay($column, $opOrValue, $value = null)
        {
        }
    
        /**
         * @param $column
         * @param $opOrValue
         * @param null $value
         * @return $this
         * @api
         */
        public static function whereYear($column, $opOrValue, $value = null)
        {
        }
    
        /**
         * @param $column
         * @param $opOrValue
         * @param null $value
         * @return $this
         * @api
         */
        public static function whereTime($column, $opOrValue, $value = null)
        {
        }
    
        /**
         * @param $column
         * @param $opOrColumn2
         * @param null $column2
         * @return $this
         * @api
         */
        public static function whereColumn($column, $opOrColumn2, $column2 = null)
        {
        }
    
        /**
         * 搜索字段是否包含某个值
         *
         * @param string $column
         * @param string $value
         * @param string $condition
         * @return $this
         * @api
         */
        public static function whereContains($column, $value, string $condition = 'AND')
        {
        }
    
        /**
         * @param $column
         * @param $value
         * @param string $condition
         * @return $this
         * @api
         */
        public static function whereNotContains($column, $value, string $condition = 'OR')
        {
        }
    
        /**
         * Specifies a grouping over the results of the query.
         * Replaces any previously specified groupings, if any.
         *
         * @param mixed $column The grouping column.
         * @return $this
         * @api
         */
        public static function groupBy($column)
        {
        }
    
        /**
         * Specifies a restriction over the groups of the query.
         * Replaces any previous having restrictions, if any.
         *
         * @param string $conditions The having conditions
         * @param array $params The condition parameters
         * @param array $types The parameter types
         * @return $this
         * @api
         */
        public static function having($column, $operator, $value = null, $condition = 'AND')
        {
        }
    
        /**
         * Specifies an ordering for the query results.
         * Replaces any previously specified orderings, if any.
         *
         * @param string $column The ordering expression.
         * @param string $order The ordering direction.
         * @return $this
         * @api
         */
        public static function orderBy($column, $order = 'ASC')
        {
        }
    
        /**
         * Adds a DESC ordering to the query
         *
         * @param string $field The name of field
         * @return $this
         * @api
         */
        public static function desc($field)
        {
        }
    
        /**
         * Add an ASC ordering to the query
         *
         * @param string $field The name of field
         * @return $this
         * @api
         */
        public static function asc($field)
        {
        }
    
        /**
         * @return $this
         * @api
         */
        public static function forUpdate()
        {
        }
    
        /**
         * @return $this
         * @api
         */
        public static function forShare()
        {
        }
    
        /**
         * @param string $lock
         * @return $this
         * @api
         */
        public static function lock($lock)
        {
        }
    
        /**
         * @param mixed $value
         * @param callable $callback
         * @param callable|null $default
         * @return $this
         * @api
         */
        public static function when($value, $callback, callable $default = null)
        {
        }
    
        /**
         * @param mixed $value
         * @param callable $callback
         * @param callable|null $default
         * @return $this
         * @api
         */
        public static function unless($value, callable $callback, callable $default = null)
        {
        }
    }
}
