@managing_pages
Feature: Adding new page
    In order to create custom CMS pages
    As an Administrator
    I want to be able to add new page to the system

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui @javascript
    Scenario: Adding new page for US translations
        When I go to the create new page page
        And I fill the code with "top_5_outfits_for_this_summer"
        And I fill the name with "Top 5 outfits for this summer"
        And I fill the meta keywords with "TOP 5 summer outfit trends, outfits, ralph lauren"
        And I fill the meta description with "This summer is going to be hot. Here's what you must wear to look great on vacation."
        And I fill the content with "The best looks, trends, inspiration, and shopping picks for summer style."
        And I add it
        Then I should be notified that new page was created
        And this page should have "top_5_outfits_for_this_summer" code
        And it should have "Top 5 outfits for this summer" name
        And it should have "top-5-outfits-for-this-summer" slug
        And it should have "TOP 5 summer outfit trends, outfits, ralph lauren" meta keywords
        And it should have "The best looks, trends, inspiration, and shopping picks for summer style." content

    @ui
    Scenario: Adding new page with empty data
        When I go to the create new page page
        And I add it
        And I should be notified that "Code, Name, Slug, Content" fields can not be blank

    @ui
    Scenario: Trying to add a page with too short data
        When I go to the create new page page
        And I fill "Code, Name, Slug, Meta keywords, Meta description, Content" with 1 character
        And I try to add it
        Then I should be notified that the "Code, Name, Slug, Meta keywords, Meta description, Content" fields are too short

    @ui
    Scenario: Trying to add a new page with too long data
        When I go to the create new page page
        And I fill "Code, Name, Slug, Meta keywords, Meta description" with 6000 characters
        And I try to add it
        Then I should be notified that "Code, Name, Slug, Meta keywords, Meta description" fields are too long