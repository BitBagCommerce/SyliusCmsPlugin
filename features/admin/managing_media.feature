@managing_media
Feature: Managing digital assets
    In order to present custom digital assets in my store
    As an Administrator
    I want to be able to manage specific media types

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @todo
    Scenario: Creating image media
        When I go to the create media page
        And I select image as media type
        And I specify the code as "aston_martin_db9"
        And I upload "aston_martin_db9.jpg" image
        And I create the media
        Then I should be notified that the media has been created
        And I should be on the edit media page


    @todo
    Scenario: Updating image media asset
        Given there is a media with "price"
        And I select image as media type
