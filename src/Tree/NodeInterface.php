<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-7-25
 * Time: 1:04
 */
namespace Tree;

interface NodeInterface {

    public function getRoot();

    public function getDepth();

    public function getParent();

    public function setParent( NodeInterface $node );

    public function getParents();

    public function isParentOf( NodeInterface $node );

    public function isAncestorOf( NodeInterface $node );

    public function isChildOf( NodeInterface $node );

    public function isDescendantOf( NodeInterface $node );

    public function hasParent( NodeInterface $node );

    public function hasChild( NodeInterface $node );

    public function hasAncestor( NodeInterface $node );

    public function isRoot();

    public function isLeaf();

    public function getChildren();

    public function addChild( NodeInterface $child );

    public function setChildren( array $children );

    public function getDescendants();

    public function getSiblings();

    public function nextSibling();

    public function nextSiblings();

    public function prevSibling();

    public function prevSiblings();

    public function remove();

    public function removeChild( NodeInterface $node );

    public function removeAllChildren();

    public function insertPrevSibling( NodeInterface $node );

    public function insertNextSibling( NodeInterface $node );

    public function toArray();

    public function toJson();

    public function toString();

    public function getValue();

    public function setValue( $value = NULL );

    public function accept( Visitor $vistor );


} 