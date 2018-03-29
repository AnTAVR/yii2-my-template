<?php

namespace app\modules\rbac\models;

use Yii;
use yii\helpers\ArrayHelper;

class Rule extends Item
{
    public $className;

    /**
     * Rule constructor.
     * @param \yii\rbac\Rule $item
     * @param array $config
     */
    public function __construct($item, $config = [])
    {
        $this->item = $item;
        if ($item !== null) {
            $this->isNewRecord = false;

            $this->name = $item->name;
            $this->createdAt = $item->createdAt;
            $this->updatedAt = $item->updatedAt;

            $this->className = get_class($item);
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            [['name'], 'uniqueValidator',
                'when' => function () {
                    return $this->isNewRecord || ($this->item->name != $this->name);
                }],

            ['className', 'required'],
            ['className', 'string'],
            ['className', 'classExistsValidator']
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'className' => Yii::t('app', 'Class Name'),
        ]);
    }

    /**
     * Validate class exists
     */
    public function classExistsValidator()
    {
        $message = null;
        if (!class_exists($this->className)) {
            $message = 'Class "{className}" not exist';
        } else if (!is_subclass_of($this->className, yii\rbac\Rule::class)) {
            $message = 'Class "{className}" must extends yii\rbac\Rule';
        } else if ((new $this->className())->name === null) {
            $message = 'The "{className}::\$name" is not set';
        } else if ((new $this->className())->name !== $this->name) {
            $message = 'The "{className}::\$name" is incorrect with the name of rule you have set';
        }

        if ($message !== null) {
            $this->addError('className', Yii::t('app', $message, ['className' => $this->className]));
        }
    }

    protected function newItem()
    {
        $class = $this->className;
        $item = new $class();
        return $item;
    }

    /**
     * Find model by id
     * @param $name
     * @return null|static
     */
    public static function find($name)
    {
        $item = Yii::$app->authManager->getRule($name);
        if ($item !== null) {
            return new self($item);
        }
        return null;
    }
}
