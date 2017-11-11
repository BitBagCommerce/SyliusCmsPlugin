@managing_faq
Feature: Adding frequently asked question
    In order to present frequently asked questions and answers in my store
    As an Administrator
    I want to be able to add new frequently asked question with answer

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui
    Scenario: Adding frequently asked
        When I go to the create faq page
        And I fill code with "each_order_payment"
        And I set the position to 1
        And I fill the question with "Should I pay for each order?"
        And I set the answer to "Yes"
        And I add it
        Then I should be notified that a new faq has been created

    @ui
    Scenario: Adding new frequently asked question with blank data
        When I go to the create faq page
        And I add it
        Then I should be notified that "Code, Position, Question, Answer" fields cannot be blank

    @ui
    Scenario: Adding new frequently asked question with too long short data
        When I go to the create faq page
        And I fill "Question, Answer" fields with 1 character
        And I add it
        Then I should be notified that "Question, Answer" fields are too short

    @ui
    Scenario: Adding new frequently asked question with existing position
        Given there is an existing faq with 1 position
        When I go to the create faq page
        And I set the position to 1
        And I try to add it
        Then I should be notified that there is already an existing faq with selected position