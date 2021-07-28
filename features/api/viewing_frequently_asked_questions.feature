@shop_frequently_asked_questions
Feature: Getting data from cms faq
    In order to present dynamic content in my store
    As an API user
    I want to be able to display FAQ

    Background:
        Given the store operates on a single channel in "United States"
        And there are 10 FAQs in the store
        And there is an existing frequently asked question with "faq-1" code

    @api
    Scenario: Browsing FAQs
        Given I want to browse FAQs
        Then I should see 11 questions in the list
        And I should see the "faq-1" question

    @api
    Scenario: Displaying question
        Given I view faq with code "faq-1"
        Then I should see question with random text
        And I should see answer with random text

