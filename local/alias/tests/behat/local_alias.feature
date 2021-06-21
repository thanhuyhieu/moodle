@local @local_alias
Feature: Alias UI works as expected
  In order to verify coding style
  As an admin
  I need to be able to use alias UI with success

  Background:
    Given the following "alias" exist:
      | friendly                         | destination                                  |
      | http://www.example.com/home      | http://www.example.com/view.php?id=1&u=99    |
      | http://www.example.com/create    | http://www.example.com/view.php?id=2&u=99    |
      | http://www.example.com/update    | http://www.example.com/view.php?id=3&u=99    |
      | http://www.example.com/delete    | http://www.example.com/view.php?id=4&u=99    |
      | http://www.example.com/hothome   | http://www.example.com/view.php?id=5&u=99    |
      | http://www.example.com/hotnews   | http://www.example.com/view.php?id=6&u=99    |
      | http://www.example.com/breaknews | http://www.example.com/view.php?id=7&u=99    |
      | http://www.example.com/about     | http://www.example.com/view.php?id=8&u=99    |
      | http://www.example.com/us        | http://www.example.com/view.php?id=9&u=99    |
      | http://www.example.com/me        | http://www.example.com/view.php?id=10&u=99   |
      | http://www.example.com/free      | http://www.example.com/view.php?id=118&u=99  |
      | http://www.example.com/hotdrink  | http://www.example.com/view.php?id=12&u=99   |

  Scenario Outline: Verify that search friendly works
    Given I log in as "admin"
    And I navigate to "Plugins > Manage Alias" in site administration
    And I set the field "Friendly:" to "<friendly>"
    When I press "Go"
    Then I should see "<seen>"
    And I log out

    Examples:
      | friendly      | seen                                |
      | home          | http://www.example.com/home         |
      | free          | http://www.example.com/free         |
  
  @javascript
  Scenario: Verify that search friendly works
    Given I log in as "admin"
    And I navigate to "Plugins > Manage Alias" in site administration
    And I click on "2" button
    And I should see "http://www.example.com/hotdrink "
    And I log out
  
  @javascript
  Scenario: Verify that creating new alias is success
    Given I log in as "admin"
    And I navigate to "Plugins > Manage Alias" in site administration
    And I click on "Create new alias" button
    And I set the field "Friendly" to "http://www.aexample.com/home"
    And I set the field "Desination" to "http://www.aexp.com/blog/ceo"
    When I press "Save changes"
    Then I should see "http://www.aexample.com/home"
    And I log out
