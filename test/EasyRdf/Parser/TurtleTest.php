<?php

/**
 * EasyRdf
 *
 * LICENSE
 *
 * Copyright (c) 2009-2012 Nicholas J Humfrey.  All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 * 3. The name of the author 'Nicholas J Humfrey" may be used to endorse or
 *    promote products derived from this software without specific prior
 *    written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    EasyRdf
 * @copyright  Copyright (c) 2009-2012 Nicholas J Humfrey
 * @license    http://www.opensource.org/licenses/bsd-license.php
 * @version    $Id$
 */

require_once dirname(dirname(dirname(__FILE__))).
             DIRECTORY_SEPARATOR.'TestHelper.php';

require_once 'EasyRdf/Parser/Turtle.php';
require_once 'EasyRdf/Serialiser/NtriplesArray.php';

class EasyRdf_Parser_TurtleTest extends EasyRdf_TestCase
{
    protected $_parser = null;

    public function setUp()
    {
        $this->_turtleParser = new EasyRdf_Parser_Turtle();
        $this->_ntriplesParser = new EasyRdf_Parser_Ntriples();
        $this->_baseUri = 'http://www.w3.org/2001/sw/DataAccess/df1/tests/';
    }

    public function testParseFoaf()
    {
        $graph = new EasyRdf_Graph();
        $this->_turtleParser->parse(
            $graph, readFixture('foaf.ttl'),
            'turtle', $this->_baseUri
        );

        $joe = $graph->resource('http://www.example.com/joe#me');
        $this->assertNotNull($joe);
        $this->assertEquals('EasyRdf_Resource', get_class($joe));
        $this->assertEquals('http://www.example.com/joe#me', $joe->getUri());

        $name = $joe->get('foaf:name');
        $this->assertNotNull($name);
        $this->assertEquals('EasyRdf_Literal', get_class($name));
        $this->assertStringEquals('Joe Bloggs', $name);
        $this->assertEquals('en', $name->getLang());
        $this->assertEquals(null, $name->getDatatype());

        $foaf = $graph->resource('http://www.example.com/joe/foaf.rdf');
        $this->assertNotNull($foaf);
        $this->assertStringEquals("Joe Bloggs' FOAF File", $foaf->label());
    }

    function testParseUnsupportedFormat()
    {
        $this->setExpectedException(
            'EasyRdf_Exception',
            'EasyRdf_Parser_Turtle does not support: unsupportedformat'
        );
        $this->_turtleParser->parse(
            new EasyRdf_Graph(), "data", 'unsupportedformat', null
        );
    }

    /* The rest of this script is runs the Turtle Test Suite
       from the files here:
       http://www.w3.org/TeamSubmission/turtle/tests/
     */

    protected function parseTurtle($filename)
    {
        $graph = new EasyRdf_Graph();
        $this->_turtleParser->parse(
            $graph,
            readFixture($filename),
            'turtle',
            $this->_baseUri . basename($filename)
        );
        return $graph->serialise('ntriples-array');
    }

    protected function parseNtriples($filename)
    {
        $graph = new EasyRdf_Graph();
        $this->_ntriplesParser->parse(
            $graph,
            readFixture($filename),
            'ntriples',
            $this->_baseUri . basename($filename)
        );
        return $graph->serialise('ntriples-array');
    }

    protected function turtleTestCase($name)
    {
        $this->assertEquals(
            $this->parseNtriples("turtle/$name.out"),
            $this->parseTurtle("turtle/$name.ttl")
        );
    }

    public function testCase00()
    {
        $this->turtleTestCase('test-00');
    }

    public function testCase01()
    {
        $this->turtleTestCase('test-01');
    }

    public function testCase02()
    {
        $this->turtleTestCase('test-02');
    }

    public function testCase03()
    {
        $this->turtleTestCase('test-03');
    }

    public function testCase04()
    {
        $this->turtleTestCase('test-04');
    }

    public function testCase05()
    {
        $this->turtleTestCase('test-05');
    }

    public function testCase06()
    {
        $this->turtleTestCase('test-06');
    }

    public function testCase07()
    {
        $this->turtleTestCase('test-07');
    }

    public function testCase08()
    {
        $this->turtleTestCase('test-08');
    }

    public function testCase09()
    {
        $this->turtleTestCase('test-09');
    }

    public function testCase10()
    {
        $this->turtleTestCase('test-10');
    }

    public function testCase11()
    {
        $this->turtleTestCase('test-11');
    }

    public function testCase12()
    {
        $this->turtleTestCase('test-12');
    }

    public function testCase13()
    {
        $this->turtleTestCase('test-13');
    }

    public function testRdfSchema()
    {
        $this->turtleTestCase('rdf-schema');
    }
}