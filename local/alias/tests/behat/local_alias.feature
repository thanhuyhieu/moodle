@local @local_alias
Feature: Alias UI works as expected
  In order to verify coding style
  As an admin
  I need to be able to use alias UI with success

  Background:
    Given the following "users" exist:
      | username | firstname    | lastname | email                 |
      | manager  | John         | Manager  | manager1@example.com  |
    And the following "role assigns" exist:
      | user     | role    | contextlevel | reference |
      | manager  | manager | System       |           |
    And I log in as "manager"
    And I navigate to "Plugins > Manage Alias" in site administration
    And I click on "Create new alias" "button"
    And I set the field "Friendly" to "http://www.aexample.com/home"
    And I set the field "Destination" to "http://www.aexp.com/blog/ceo"
    And I press "Save changes"
    And I log out

  @javascript
  Scenario: Verify that creating a new alias is success
    Given I log in as "manager"
    And I navigate to "Plugins > Manage Alias" in site administration
    And I click on "Create new alias" "button"
    And I set the field "Friendly" to "http://www.aexample.com/home1"
    And I set the field "Destination" to "http://www.aexp.com/blog/ceo1"
    When I press "Save changes"
    Then I should see "http://www.aexample.com/home1"
    And I should see "http://www.aexp.com/blog/ceo1"
    And I log out
  
  @javascript
  Scenario:Verify that search friendly works
    Given I log in as "manager"
    And I navigate to "Plugins > Manage Alias" in site administration
    Then I set the field "Friendly:" to "home"
    When I press "Go"
    Then I should see "http://www.aexample.com/home"
    And I log out
    
  @javascript
  Scenario: Verify that updating an alias is success
    Given I log in as "manager"
    And I navigate to "Plugins > Manage Alias" in site administration
    And I click on ".icon[title=Edit]" "css_element"
    And I set the field "Friendly" to "http://www.aexample.com/hotdrink"
    And I set the field "Destination" to "http://www.aexp.com/blog/hotdrink?id=123"
    When I press "Save changes"
    Then I should see "http://www.aexample.com/hotdrink"
    And I should see "http://www.aexp.com/blog/hotdrink?id=123"
    And I log out
    
  @javascript
  Scenario: Verify that deleting an alias is success
    Given I log in as "manager"
    And I navigate to "Plugins > Manage Alias" in site administration
    And I click on ".icon[title=Delete]" "css_element"
    When I press "Delete"
    Then I should not see "http://www.aexample.com/hotdrink"
    And I should not see "http://www.aexp.com/blog/hotdrink?id=123"
    And I log out
