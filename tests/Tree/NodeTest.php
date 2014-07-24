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

        $tree->addChild( $child1);
        $this->assertEquals( $tree->getRoot() , $child1->getRoot() );
        $this->assertEquals( ( $tree->getRoot() == $child221->getRoot() ) , false );

        $this->assertEquals( $tree , $child1->getRoot() );
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
        var_dump( $child3->getChildren() );

        $this->assertEquals( $child3->getChildren() , [ $child22 ] );
        $this->assertEquals( $child2->getChildren() , [] );

    }
}