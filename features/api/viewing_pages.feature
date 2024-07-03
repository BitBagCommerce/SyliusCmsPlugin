@shop_pages
Feature: Getting data from cms pages
    In order to present dynamic content in my store
    As an API user
    I want to be able to display custom pages

    Background:
        Given the store operates on a single channel in "United States"
        And there are 10 pages in the store
        And the store has "iPhone 8" and "iPhone X" products
        And there is a page in the store
        And there are existing collections named "Blog" and "General"
        And this page has these collections associated with it
        And this page has "About us" name
        And this page has "about" code
        And this page also has "about-us" slug

    @api
    Scenario: Browsing defined pages
        Given I want to browse pages
        Then I should see 11 pages in the list
        And I should see the "About us" page

    @api
    Scenario: Viewing a detailed page
        When I view page with code "about"
        Then I should see the page name "About us"
