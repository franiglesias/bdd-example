Feature: Mark completed tasks
  As User
  I want to mark tasks as completed
  So that I can see my achievements

  Scenario: Mark an existing task
    Given I have this tasks in my list
      | id | description                  | done |
      | 1  | Write a test that fails      | no   |
      | 2  | Write code to make test pass | no   |
    When I mark task 1 as completed
    And I get my tasks
    Then I see a list containing:
      | id | description                  | done |
      | 1  | Write a test that fails      | yes  |
      | 2  | Write code to make test pass | no   |
