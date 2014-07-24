<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-7-25
 * Time: 3:34
 */

namespace Tree;

interface Visitor {
    public function visit( NodeInterface $node );
} 