@managing_blocks
Feature: Managing cms blocks
    In order to present dynamic content in my store
    As an Administrator
    I want to be able to manage existing blocks

    Background:
        Given the store operates on a single channel in "United States"
        Given I am logged in as an administrator

    @ui
    Scenario: Seeing menu items
        Given there is a cms text block with "store_phone_number" code and "123456789" content
        When I go to the update "store_phone_number" block page
        And I fill the content with "987654321"
        And I update it
        Then I should be notified that the block has been successfully updated

    @ui
    Scenario: Updating html block
        Given there is a cms html block with "store_email" code and "<a href='mailto:mikolaj.krol@bitbag.pl'>mikolaj.krol@bitbag.pl</a>" content
        When I go to the update "store_email" block page
        And I fill the content with "<a href='mailto:mikolaj.krol@bitbag.pl'>mikolaj.krol@bitbag.pl</a>"
        And I update it
        Then I should be notified that the block has been successfully updated

    @ui
    Scenario: Updating image block
        Given there is an existing block with "porsche_911_singer" code and "porsche_911_singer_1.jpg" image
        When I go to the update "porsche_911_singer" block page
        And I upload the "porsche_911_singer_2.jpg" image
        And I update it
        Then I should be notified that the block has been successfully updated

    @ui
    Scenario: Disabling block
        Given there is an existing block with "bitbag_quote" code
        When I go to the update "bitbag_quote" block page
        And I disable it
        And I update it
        Then I should be notified that the block has been successfully updated

    @ui
    Scenario: Seeing dynamic blocks in the admin panel
        Given there are 2 dynamic content blocks with "image" type
        And there are 3 dynamic content blocks with "text" type
        When I go to the cms blocks page
        Then I should see 2 dynamic content blocks with "image" type
        And I should see 3 dynamic content blocks with "text" type

    @ui
    Scenario: Removing single block
        Given there is a dynamic content block with "image" type
        When I go to the cms blocks page
        And I remove this image block
        Then I should be notified that this block was removed

    @ui
    Scenario: Being able to chose which block type to create
        When I go to the cms blocks page
        Then I should be able to select between "Text block", "HTML block" and "Image block" block types under Create button