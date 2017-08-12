@managing_blocks
Feature: Updating image block
    In order to manage dynamic images
    As an Administrator
    I want to be able to edit existing image blocks

    Background:
        Given I am logged in as an administrator
        And there is a cms block with "store_phone_number" code and "123456789" content

    @ui
    Scenario: Seeing menu items
        When I go to the update "store_phone_number" block page
        And I set the content to "987654321"
        And I update it
        Then I should be notified that the block was successfully updated
        And block with "store_phone_number" type and "987654321" content should be in the store