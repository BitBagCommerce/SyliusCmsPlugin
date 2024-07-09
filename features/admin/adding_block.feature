@managing_blocks
Feature: Adding blocks
    In order to present and manage dynamic content on my store pages
    As an Administrator
    I want to be able to add new blocks

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui @javascript
    Scenario: Adding block
        When I go to the create block page
        And I fill the code with "store_description"
        And I fill the name with "Store Description"
        And I add it
        Then I should be notified that the block has been created

    @ui @javascript
    Scenario: Adding block with collections
        Given there are existing collections named "Blog" and "Homepage"
        When I go to the create block page
        And I fill the code with "intro"
        And I fill the name with "Intro"
        And I add "Blog" and "Homepage" collections to it
        And I add it
        Then I should be notified that the block has been created

    @ui @javascript
    Scenario: Adding block with textarea content element
        When I go to the create block page
        And I fill the code with "intro"
        And I fill the name with "Intro"
        And I click on Add button in Content elements section
        And I select "Textarea" content element
        And I add a textarea content element with "Welcome to our store" content
        And I add it
        Then I should be notified that the block has been created

    @ui @javascript
    Scenario: Adding block with single media content element
        Given there is an existing media with "image_1" code and name "Image 1"
        When I go to the create block page
        And I fill the code with "intro"
        And I fill the name with "Intro"
        And I click on Add button in Content elements section
        And I select "Single media" content element
        And I add a single media content element with name "Image 1"
        And I add it
        Then I should be notified that the block has been created

    @ui @javascript
    Scenario: Adding block with heading content element
        When I go to the create block page
        And I fill the code with "intro"
        And I fill the name with "Intro"
        And I click on Add button in Content elements section
        And I select "Heading" content element
        And I add a heading content element with type "H3" and "Welcome to our store" content
        And I add it
        Then I should be notified that the block has been created

    @ui @javascript
    Scenario: Adding block with products carousel content element
        Given the store has "iPhone 8" and "iPhone X" products
        When I go to the create block page
        And I fill the code with "intro"
        And I fill the name with "Intro"
        And I click on Add button in Content elements section
        And I select "Products carousel" content element
        And I add a products carousel content element with "iPhone 8" and "iPhone X" products
        And I add it
        Then I should be notified that the block has been created

    @ui @javascript
    Scenario: Adding block with products carousel by taxon content element
        Given the store has "Smartphones" taxonomy
        When I go to the create block page
        And I fill the code with "intro"
        And I fill the name with "Intro"
        And I click on Add button in Content elements section
        And I select "Products carousel by Taxon" content element
        And I add a products carousel by taxon content element with "Smartphones" taxonomy
        And I add it
        Then I should be notified that the block has been created

    @ui @javascript
    Scenario: Adding block with taxons list content element
        Given the store classifies its products as "Smartphones" and "Laptops"
        When I go to the create block page
        And I fill the code with "intro"
        And I fill the name with "Intro"
        And I click on Add button in Content elements section
        And I select "Taxons list" content element
        And I add a taxons list content element with "Smartphones" and "Laptops" taxonomy
        And I add it
        Then I should be notified that the block has been created

    @ui
    Scenario: Trying to add block with existing code
        Given there is an existing block with "homepage_image" code
        When I go to the create block page
        And I fill the code with "homepage_image"
        And I try to add it
        Then I should be notified that there is already an existing block with provided code

    @ui
    Scenario: Trying to add block with blank data
        When I go to the create block page
        And I try to add it
        Then I should be notified that "Code" fields cannot be blank

    @ui
    Scenario: Trying to add block with too long data
        When I go to the create block page
        And I fill "Code, Name" fields with 251 characters
        And I try to add it
        Then I should be notified that "Code, Name" fields are too long

