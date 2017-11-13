@managing_frequently_asked_questions
Feature: Managing frequently asked questions
    In order to present frequently asked questions and answers in my store
    As an Administrator
    I want to be able update and remove existing frequently asked questions

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui
    Scenario: Removing frequently asked question
        Given the store has a frequently asked question
        When I go to the frequently asked questions page
        And I delete this frequently asked question
        Then I should be notified that the fequently asked question has been deleted
        And I should see empty list of frequently asked questions

    @ui
    Scenario: Seeing disabled code field while editing frequently asked question
        Given the store has a frequently asked question
        When I want to edit this frequently asked question
        Then the code field should be disabled
