@managing_frequently_asked_questions
Feature: Adding frequently asked question
    In order to present frequently asked questions and answers in my store
    As an Administrator
    I want to be able to add new frequently asked question with answer

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui
    Scenario: Adding frequently asked question
        When I go to the create frequently asked question page
        And I fill the code with "each_order_payment"
        And I set the position to 1
        And I fill the question with "Should I pay for each order?"
        And I set the answer to "Yes"
        And I add it
        Then I should be notified that a new frequently asked question has been created

    @ui @unstable
    Scenario: Adding new frequently asked question with long data
        When I go to the create frequently asked question page
        And I fill the code with "whats_the_js_framework_of_the_week"
        And I set the position to 1
        And I fill "Question, Answer" fields with 1500 characters
        And I add it
        Then I should be notified that a new frequently asked question has been created

    @ui
    Scenario: Trying to add frequently asked question with existing code
        Given there is an existing frequently asked question with "stupid_question" code
        When I go to the create frequently asked question page
        And I fill the code with "stupid_question"
        And I try to add it
        Then I should be notified that there is already an existing frequently asked question with provided code

    @ui
    Scenario: Trying to add new frequently asked question with blank data
        When I go to the create frequently asked question page
        And I add it
        Then I should be notified that "Code, Position, Question, Answer" fields cannot be blank

    @ui
    Scenario: Trying to add new frequently asked question with too short data
        When I go to the create frequently asked question page
        And I fill "Question, Answer" fields with 1 character
        And I add it
        Then I should be notified that "Question, Answer" fields are too short

    @ui
    Scenario: Trying to add new frequently asked question with existing position
        Given there is an existing frequently asked question with 1 position
        When I go to the create frequently asked question page
        And I set the position to 1
        And I try to add it
        Then I should be notified that there is already an existing frequently asked question with selected position
