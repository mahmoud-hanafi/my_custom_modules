<?php

namespace Drupal\shipub_shipping_company\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the shipub_shipping_company module.
 */
class QuickOrderControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "shipub_shipping_company QuickOrderController's controller functionality",
      'description' => 'Test Unit for module shipub_shipping_company and controller QuickOrderController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests shipub_shipping_company functionality.
   */
  public function testQuickOrderController() {
    // Check that the basic functions of module shipub_shipping_company.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
