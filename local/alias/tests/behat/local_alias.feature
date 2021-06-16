@local @local_alias
Feature: View list in alias
  In order to search and pagination alias
  As a manager
  I need to be able to view my Alias

Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | admin1   | John      | Admin1   | admin1@example.com   |
      | student1 | Linda     | Student1 | student1@example.com |
      | teacher1 | Loren     | Teacher1 | teacher1@example.com |
    And the following "alias" exist:
      | friendly | destination |
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
    And I log in as "admin1"
    And I am on "Alias" alias homepage

  Scenario: View alias and then search alias
    Given I am on "Alias" alias homepage
    And I set the following fields to these values:
      | Search              | hot                                         |
    And I press "Go"

  @javascript
  Scenario: View new alias by creating new alias
    Given I am on "Alias" alias homepage
    And I click on "Create new alias" button
    And I add a "Alias" and I fill the form with:
      | friendly          | https://nashtechglobal.com/home                 |
      | desination        | https://nashtechglobal.com/blog/ceo             |
    And I press "Save"
  
  @javascript
  Scenario: View new alias by updating old alias
    Given I am on "Alias" alias homepage
    And I click on "Update alias" button
    And I update a "Alias" and I fill the form with:
      | friendly          | https://nashtechglobal.com/hothome                 |
      | desination        | https://nashtechglobal.com/blog/ceo-nt             |
    And I press "Save"