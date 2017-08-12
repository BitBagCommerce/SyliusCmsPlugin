@admin_cms
Feature: Seeing menu cms items
    In order to manage dynamic content
    As an Administrator
    I want to see proper menu items in admin panel

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Seeing menu items
        When I open administration dashboard
        Then I should see root menu item called "Dynamic content management"
        And I should see "Blocks" menu item under this root menu item