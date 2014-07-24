<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 14-7-25
 * Time: 3:40
 */

namespace Tree;

class NodeTest extends \PHPUnit_Framework_TestCase{

    public function setUp(){

    }

    public function testValue(){
        $node = new Node();
        $node->setValue('string value');
        $this->assertEquals('string value', $node->getValue());
        $node->setValue($object = new \stdClass());
        $object->foo = 'bar';
        $this->assertEquals($object, $node->getValue());
    }

    public function testRoot(){
        $tree = new Node( 'root' );
        $child1 = new Node( 'child1' );
        $child11 = new Node( 'child1-1');
        $child12 = new Node( 'child1-2');
        $child2 = new Node( 'child2' );
        $child21 = new Node( 'child21' );
        $child22 = new Node( 'child22' );
        $child23 = new Node( 'child23' );
        $child24 = new Node( 'child24' );
        $child3  = new Node( 'child3' );
        $child221 = new Node( 'child221' );
        $child222 = new Node( 'child222' );

        $tree->addChild( $child1);
        $this->assertEquals( $tree->getRoot() , $child1->getRoot() );
        $this->assertEquals( ( $tree->getRoot() == $child221->getRoot() ) , false );

        $this->assertEquals( $tree , $child1->getRoot() );
        $this->assertEquals( $tree->isRoot() , true );
        $this->assertEquals( $child1->isRoot() , false );
        $this->assertEquals( $tree->isLeaf() , false );
        $this->assertEquals( $child1->isLeaf() , true );
        $this->assertEquals( ( $tree == $child221->getRoot() ) , false );
        $tree->addChild( $child2->addChild( $child22->addChild( $child221) ) );
        $this->assertEquals( ( $tree == $child221->getRoot() ) , true );
        $this->assertEquals( $child221->getParents() , [ $tree , $child2 , $child22 ] );
        $this->assertEquals( $child221->getDepth() , 3 );
        $this->assertEquals( $tree->getDepth() , 0 );
        $this->assertEquals( $child221->getParent() , $child22 );

        $this->assertEquals( $tree->getChildren() , [ $child1 , $child2 ]);
        $tree->removeChild( $child1 );
        //var_dump( $tree -> getChildren() );
        $this->assertEquals( $tree->getChildren() , [ $child2 ]);

        $tree->setChildren( [ $child1 , $child1 , $child2 , $child3 ] );
        $this->assertEquals( $tree->getChildren() , [$child1 , $child2 , $child3]);

        $child22->setParent( $child3 );

        $this->assertEquals( $tree->isParentOf( $child1 ) , true );
        $this->assertEquals( $child2->isParentOf( $child3 ), false );
        $this->assertEquals( $child2->isChildOf( $tree ) , true );
        $this->assertEquals( $child3->isChildOf( $child1 ), false );

        $this->assertEquals( $tree->isAncestorOf( $child221 ) , true );
        $this->assertEquals( $tree->isAncestorOf( $child222 ) , false );

        $this->assertEquals( $child2->getChildren() , [] );
        $this->assertEquals( $child3->getChildren() , [ $child22 ] );

        $child2->setChildren( [$child21 , $child24 ] );
        $child21->insertNextSibling( $child22 );
        $child24->insertPrevSibling( $child23 );
        $child24->insertPrevSibling( $child23 );
        $this->assertEquals( $child21->nextSibling() , $child22 );
        $this->assertEquals( $child24->prevSibling() , $child23 );
        $this->assertEquals( $child24->nextSibling() , null );
        $this->assertEquals( $child21->prevSibling() , null );
        $this->assertEquals( $child21->nextSiblings() , [ $child22 , $child23 , $child24] );
        $this->assertEquals( $child23->prevSiblings() , [ $child21 , $child22 ] );
        $this->assertEquals( $child23->getSiblings() , $child2->getChildren() );
        $this->assertEquals( $child2->getChildren() , [$child21 , $child22 , $child23 , $child24 ] );

        $child2->removeAllChildren();
        $this->assertEquals( $child23->getSiblings() , $child2->getChildren() );
        $this->assertEquals( $child2->getChildren() , [] );

        $child2->setChildren( [$child21 , $child24 , $child23 ] );
        $child24->remove();
        $this->assertEquals( $child2->getChildren() , [ $child21 , $child23 ] );

        $this->assertEquals( $child21->hasParent( $child2 ) , true );
        $this->assertEquals( $child21->hasParent( $tree ) , false );
        $this->assertEquals( $child24->hasParent( $child2 ) , false );
        $this->assertEquals( $child2->hasChild( $child23 ), true );
        $this->assertEquals( $child2->hasChild( $child24 ) , false );


    }
}