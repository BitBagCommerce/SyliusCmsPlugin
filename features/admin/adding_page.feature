@managing_pages
Feature: Adding new page
    In order to create custom CMS pages
    As an Administrator
    I want to be able to add new page to the system

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui @javascript
    Scenario: Adding page
        When I go to the create page page
        And I fill the code with "top_5_outfits_for_this_summer"
        And I fill the slug with "top_5_outfits_for_this_summer"
        And I fill the name with "Top 5 outfits for this summer"
        And I fill the meta keywords with "TOP 5 summer outfit trends, outfits, Ralph Lauren"
        And I fill the meta description with "This summer is going to be hot like a pizza."
        And I fill the content with "The best looks, trends, inspiration, and shopping picks for summer style."
        And I add it
        Then I should be notified that the page has been created

    @ui @javascript
    Scenario: Adding page with page image
        When I go to the create page page
        And I fill the code with "aston_martin_is_amazing_car"
        And I fill the slug with "aston_martin_is_amazing_car"
        And I fill the name with "Aston Martin is amazing car"
        And I fill the meta keywords with "Aston Martin is amazing car"
        And I fill the meta description with "Aston Martin is amazing car for this summer."
        And I fill the content with "Aston Martin is amazing car for this summer. Buy it."
        And I upload the "aston_martin_db_11.jpg" image
        And I add it
        Then I should be notified that the page has been created

    @ui
    Scenario: Trying to add page with existing code
        Given there is an existing page with "terms" code
        When I go to the create page page
        And I fill the code with "terms"
        And I try to add it
        Then I should be notified that there is already an existing page with provided code

    @ui
    Scenario: Adding new page with blank data
        When I go to the create page page
        And I add it
        And I should be notified that "Code, Name, Slug, Content" fields cannot be blank

    @ui
    Scenario: Trying to add a page with too short data
        When I go to the create page page
        And I fill "Code, Name, Slug, Meta keywords, Meta description, Content" fields with 1 character
        And I try to add it
        Then I should be notified that "Code, Name, Slug, Meta keywords, Meta description, Content" fields are too short

    @ui
    Scenario: Trying to add a page with too long data
        When I go to the create page page
        And I fill "Code, Name, Slug, Meta keywords, Meta description" fields with 6000 characters
        And I try to add it
        Then I should be notified that "Code, Name, Slug, Meta keywords, Meta description" fields are too long

    @ui @javascript
    Scenario: Adding page with sections
        Given there are existing sections named "Blog" and "Homepage"
        When I go to the create page page
        And I fill the code with "best_day_ever"
        And I fill the slug with "best_day_ever"
        And I fill the name with "Best day ever"
        And I add "Blog" and "Homepage" sections to it
        And I fill the content with "This was the best day of my life"
        And I add it
        Then I should be notified that the page has been created
