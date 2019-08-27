<?php
echo 'Реализовать построение и обход дерева для математического выражения.<br/>';


class MathExpressionNode
{
    public $value;
    public $left;
    public $right;

    public function __construct($value = null)
    {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
    }
}


class MathExpressionTree
{
    protected $root;
    protected $expressionTree = null;

    public function __construct($expression)
    {
        $this->root = null;
        $this->buildExpressionTree($expression);
    }

    protected function buildExpressionTree($expression)
    {
        $expressionArr = str_split($expression);
        foreach ($expressionArr as $item) {
            if ($item == '(') {
                $this->insertLeftParentheses($this->expressionTree);
            } else if ($item != '+' && $item != '-' && $item != '*' && $item != '/' && $item != '^' && $item != ')') {
                $this->insertOperand($item, $this->expressionTree);
            } else if ($item == '+' || $item == '-' || $item == '*' || $item == '/' || $item != '^') {
                $this->insertOperator($item, $this->expressionTree);
            }
        }
    }

    protected function insertLeftParentheses(&$subtree)
    {
        if ($subtree == null) {
            $subtree = new MathExpressionNode;
        } else if ($subtree->left == null) {
            $subtree->left = new MathExpressionNode;
        } else if (gettype($subtree->left) != 'object') {
            if ($subtree->right == null) {
                $subtree->right = new MathExpressionNode;
            }
        } else {
            $this->insertLeftParentheses($subtree->left);
        }
    }

    protected function insertOperand($value, &$subtree)
    {
        if ($subtree == null) {
            $subtree = new MathExpressionNode;
            $subtree->left = $value;
        } else if ($subtree->left == null) {
            $subtree->left = $value;
        } else if (gettype($subtree->left) != 'object') {
            if ($subtree->right == null) {
                $subtree->right = $value;
            } else if (gettype($subtree->right) == 'object') {
                $this->insertOperand($value, $subtree->right);
            }
        } else {
            $this->insertOperand($value, $subtree->left);
        }
    }

    protected function insertOperator($value, &$subtree)
    {
        if (gettype($subtree->left) == 'object') {
            $this->insertOperator($value, $subtree->left);
        } else if ((int)$subtree->left && $subtree->value == null) {
            $subtree->value = $value;
        } else if (gettype($subtree->right) == 'object') {
            $this->insertOperator($value, $subtree->right);
        }
    }

    public function calculate(&$subtree = null)
    {
        if ($subtree == null) {
            $subtree = $this->expressionTree;
        }

        if (gettype($subtree->left) == 'object') {
            $subtree->left = $this->calculate($subtree->left);
        }
        if (gettype($subtree->right) == 'object') {
            $subtree->right = $this->calculate($subtree->right);
        }

        $result = null;
        if ($subtree->value == '+') {
            $result = $subtree->left + $subtree->right;
        }
        if ($subtree->value == '-') {
            $result = $subtree->left - $subtree->right;
        }
        if ($subtree->value == '*') {
            $result = $subtree->left * $subtree->right;
        }
        if ($subtree->value == '/') {
            $result = $subtree->left / $subtree->right;
        }
        return $result;
    }
}

$expression = '(3+(4*5))';
$tree = new MathExpressionTree($expression);
echo $expression . ' = ' . $tree->calculate();