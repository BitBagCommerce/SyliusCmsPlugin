@shop_pages
Feature: Browsing pages by collection
    In order to read content like articles or blog posts
    As a Customer
    I want to browse pages by specific collections

    Background:
        Given the store operates on a single channel in "United States"

    @ui
    Scenario: Browsing pages by collection
        Given there is a "Blog" collection in the store
        And there are 15 pages in the store
        And these pages have this collection associated with it
        When I go to the collection pages list for the "blog" collection
        Then I should see 10 pages on the page
