<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-7-25
 * Time: 3:44
 */
namespace Tree;

class Node implements NodeInterface{
    protected $parent = NULL;
    protected $siblings = [];
    protected $children = [];
    protected $value = NULL;

    public function __construct( $value = NULL ){
        $this->setValue( $value );
        return $this;
    }

    public function getValue(){
        return $this->value;
    }

    public function setValue( $value = NULL ){
        $this->value = $value;
        return $this;
    }

    public function getRoot(){
        $parents = $this->getParents();
        if( empty( $parents ) ){
            return $this;
        }
        else{
            return array_shift( $parents );
        }
    }

    public function getDepth(){
        $parents = $this->getParents();
        return count( $parents );
    }

    public function getParent(){
        return $this->parent;
    }

    public function setParent( NodeInterface $node = null ){
        $parent = $this->getParent();
        if( null != $parent ){
            $parent->removeChild( $this );
        }
        if( null != $node ){
            $node->_addChild( $this );
        }
        $this->parent = $node;
    }

    public function _setParent( NodeInterface $node = null ){
        $this->parent = $node;
        return $this;
    }

    public function getParents(){
        $parents = [];
        $cursor = $this;
        while( $parent = $cursor->getParent() ){
            array_unshift( $parents , $parent );
            $cursor = $parent;
        }
        return $parents;
    }

    public function isParentOf( NodeInterface $node ){
        return ( $this == $node->getParent() );
    }

    public function isAncestorOf( NodeInterface $node ){
        $parents = $node->getParents();
        if( in_array( $this , $parents) ){
            return true;
        }
        else{
            return false;
        }
    }

    public function isChildOf( NodeInterface $node ){
        if( in_array( $this , $node->getChildren() ) ){
            return true;
        }
        else{
            return false;
        }
    }

    public function isDescendantOf( NodeInterface $node ){
        if( in_array( $this , $node->getDescendants() ) ){
            return true;
        }
        else{
            return false;
        }
    }

    public function hasParent( NodeInterface $node ){
        return $node->isParentOf( $this );
    }

    public function hasChild( NodeInterface $node ){
        return $node->isChildOf( $this );
    }

    public function hasAncestor( NodeInterface $node ){
        return $node->isAncestorOf( $this );
    }

    public function isRoot(){
        if( $this == $this->root ){
            return true;
        }
        else{
            return false;
        }
    }

    public function isLeaf(){
        $children = $this->getChildren();
        if( empty( $children ) ){
            return true;
        }
        else{
            return false;
        }
    }

    public function getChildren(){
        return $this->children;
    }

    public function addChild( NodeInterface $child ){
        $child->setParent( $this );
        return $this->_addChild( $child );
    }

    public function _addChild( NodeInterface $child ){
        $unique = true;
        foreach( $this->children as $one ){
            if( $child == $one ){
                $unique = false;
            }
        }
        if( $unique ){
            $this->children[] = $child;
        }
        return $this;
    }

    public function setChildren( array $children ){
        $this->removeParentFromChildren();
        $this->children = [];
        foreach( $children as $child ){
            $this->addChild( $child );
        }
        return $this;
    }

    protected function removeParentFromChildren(){
        foreach( $this->getChildren() as $child ){
            $child->setParent( null );
        }
    }

    public function getDescendants(){
    }

    protected function _siblings( $type = 'all' ){
        if( $this->isRoot() ){
            return [];
        }
        $siblings = $this->parent()->getChildren();
        if( $type == 'all' ){
            return $siblings;
        }
        $prev = [];
        $next = [];
        $foundme = false;
        foreach( $siblings as $one ){
            if( $one == $this ){
                $foundme = true;
                continue;
            }
            if( false == $foundme ){
                $prev[] = $one;
            }
            else{
                $next[] = $one;
            }
        }
        if( $type == 'next' ){
            return $next;
        }
        elseif( $type == 'prev' ){
            return $prev;
        }
    }

    public function getSiblings(){
        return $this->_siblings('all');
    }

    public function nextSiblings(){
        return $this->_siblings('next');
    }

    public function prevSiblings(){
        return $this->_siblings('prev');
    }

    public function nextSibling(){
        $next = $this->nextSiblings();
        if( empty( $next ) ){
            return NULL;
        }
        else{
            return array_shift( $next );
        }
    }

    public function prevSibling(){
        $prev = $this->prevSiblings();
        if( empty( $prev ) ){
            return NULL;
        }
        else{
            return array_pop( $prev );
        }
    }

    public function remove(){
        $this->setParent( null );
    }

    public function removeChild( NodeInterface $node ){
        $children = $this->getChildren();
        foreach( $children as $key => $child ){
            if( $child == $node ){
                unset( $children[$key] );
            }
        }
        $this->children = array_values( $children );
        $node->_setParent( null );
        return $this;
    }

    public function removeAllChildren(){
        $this->setChildren([]);
        return $this;
    }

    public function insertPrevSibling( NodeInterface $node ){
        $prev = $this->prevSiblings();
        $next = $this->nextSiblings();
        $children = array_merge( $prev , [ $node , $this ] , $next );
        $this->getParent()->setChildren( $children );
        return $this;
    }

    public function insertNextSibling( NodeInterface $node ){
        $prev = $this->prevSiblings();
        $next = $this->nextSiblings();
        $children = array_merge( $prev , [ $this , $node ] , $next );
        $this->getParent()->setChildren( $children );
        return $this;
    }

    public function toArray(){

    }

    public function toJSON(){

    }

    public function toString(){

    }

    public function accept( Visitor $visitor ){
        return $visitor->visit( $this );
    }
} 