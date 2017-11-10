@managing_blocks
Feature: Adding image block
    In order to manage dynamic images
    As an Administrator
    I want to be able to add new image blocks

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui
    Scenario: Seeing menu items
        When I go to the create "image" block page
        And I fill the code with "aston_martin_db_11"
        And I fill the name with "Aston Marting DB 11 image"
        And I fill the link with "/page/aston-martin-db-11-review"
        And I upload the "aston_martin_db_11.jpg" image
        And I add it
        Then I should be notified that new image block was created
        And image block with "aston_martin_db_11" code and "aston_martin_db_11.jpg" image should exist in the store
        And this block should also have "Aston Marting DB 11 image" name and "/page/aston-martin-db-11-review" link

    @ui
    Scenario: Seeing menu items
        When I go to the create "image" block page
        And I fill the code with "aston_martin_db_11"
        And I add it
        Then I should be notified that "Image" can not be blank