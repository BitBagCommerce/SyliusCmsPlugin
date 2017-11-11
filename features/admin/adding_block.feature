@managing_blocks
Feature: Adding blocks
    In order to present and manage dynamic content on my store pages
    As an Administrator
    I want to be able to add new blocks

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui
    Scenario: Adding html block
        When I go to the create "html" block page
        And I fill the code with "store_description"
        And I fill the content with "<p>We have the best candies on the internet!</p>"
        And I add it
        Then I should be notified that the block has been created

    @ui
    Scenario: Adding text block
        When I go to the create "text" block page
        And I fill the code with "store_main_title"
        And I fill the name with "Store title"
        And I fill the content with "Welcome to the Candy Shop"
        And I add it
        Then I should be notified that the block has been created

    @ui
    Scenario: Adding image block
        When I go to the create "image" block page
        And I fill the code with "aston_martin_db_11"
        And I fill the name with "Aston Marting DB 11 image"
        And I fill the link with "/page/aston-martin-db-11-review"
        And I upload the "aston_martin_db_11.jpg" image
        And I add it
        Then I should be notified that the block has been created

    @ui @javascript
    Scenario: Adding block with sections
        Given there are existing sections named "Blog" and "Homepage"
        When I go to the create "html" block page
        And I fill "Code, Content" fields
        And I add "Blog" and "Homepage" sections to it
        And I add it
        Then I should be notified that the block has been created

    @ui
    Scenario: Trying to add block with existing code
        Given there is an existing block with "homepage_image" code
        When I go to the create "text" block page
        And I fill the code with "homepage_image"
        And I try to add it
        Then I should be notified that there is already an existing block with provided code

    @ui
    Scenario: Trying to add text block with blank data
        When I go to the create "text" block page
        And I try to add it
        Then I should be notified that "Code, Content" fields cannot be blank

    @ui
    Scenario: Trying to add html block with blank data
        When I go to the create "html" block page
        And I try to add it
        Then I should be notified that "Code, Content" fields cannot be blank

    @ui
    Scenario: Trying to add image block with blank data
        When I go to the create "image" block page
        And I try to add it
        Then I should be notified that "Code, Image" fields cannot be blank

    @ui
    Scenario: Trying to add text block with too long data
        When I go to the create "text" block page
        And I fill "Code, Name, Content" fields with 6000 characters
        And I try to add it
        Then I should be notified that "Code, Name" fields are too long

    @ui
    Scenario: Trying to add html block with too long data
        When I go to the create "html" block page
        And I fill "Code, Name, Content" fields with 6000 characters
        And I try to add it
        Then I should be notified that "Code, Name" fields are too long

    @ui
    Scenario: Trying to add image block with too long data
        When I go to the create "image" block page
        And I fill "Code, Name" fields with 6000 characters
        And I try to add it
        Then I should be notified that "Code, Name" fields are too long