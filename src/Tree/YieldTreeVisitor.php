<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-7-25
 * Time: 3:29
 */

namespace Tree;

class YieldTreeVisitor implements Visitior{

    public function visit( NodeInterface $node ){
        if( $node->isLeaf() ){
            return [$node];
        }
        $yield = [];
        foreach ($node->getChildren() as $child) {
            $yield = array_merge($yield, $child->accept($this));
        }

        return $yield;
    }
} 