@shop_frequently_asked_questions
Feature: Browsing FAQs
    In order to get answer to the my questions ASAP
    As a Customer
    I want to browse through all FAQs

    Background:
        Given the store operates on a single channel in "United States"

    @ui
    Scenario: Browsing FAQs
        Given there are 10 FAQs in the store
        When I go frequently asked questions list page
        Then I should see 10 FAQs ordered by position