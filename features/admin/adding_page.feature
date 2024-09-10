@managing_pages
Feature: Adding new page
    In order to create custom CMS pages
    As an Administrator
    I want to be able to add new page to the system

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui @javascript @title
    Scenario: Adding page with title
        When I go to the create page page
        And I fill the code with "page_with_title"
        And I fill the slug with "page_with_title"
        And I fill the name with "page_with_title"
        And I add it
        Then I should be notified that the page has been created

    @ui @javascript
    Scenario: Adding page
        When I go to the create page page
        And I fill the code with "top_5_outfits_for_this_summer"
        And I fill the slug with "top_5_outfits_for_this_summer"
        And I fill the name with "Top 5 outfits for this summer"
        And I fill the meta keywords with "TOP 5 summer outfit trends, outfits, Ralph Lauren"
        And I fill the meta description with "This summer is going to be hot like a pizza."
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
        And I should be notified that "Code, Name" fields cannot be blank

    @ui
    Scenario: Trying to add a page with too short data
        When I go to the create page page
        And I fill "Code, Name, Slug, Meta keywords, Meta description" fields with 1 character
        And I try to add it
        Then I should be notified that "Code, Name, Slug, Meta keywords, Meta description" fields are too short

    @ui @unstable
    Scenario: Trying to add a page with too long data
        When I go to the create page page
        And I fill "Code, Name, Slug, Meta keywords, Meta description" fields with 6000 characters
        And I try to add it
        Then I should be notified that "Code, Name, Slug, Meta keywords, Meta description" fields are too long

    @ui @javascript
    Scenario: Adding page with sections
        Given there are existing collections named "Blog" and "Homepage"
        When I go to the create page page
        And I fill the code with "best_day_ever"
        And I add "Blog" and "Homepage" collections to it
        And I fill the slug with "Slug"
        And I fill the name with "Best day ever"
        And I add it
        Then I should be notified that the page has been created

    @ui @javascript
    Scenario: Adding page with textarea content element
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Textarea" content element
        And I add a textarea content element with "Welcome to our store" content
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Textarea" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with single media content element
        Given there is an existing media with "image_1" code and name "Image 1"
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Single media" content element
        And I add a single media content element with name "Image 1"
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Single media" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with multiple media content element
        Given there is an existing media with names "Image 1" and "Image 2"
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Multiple media" content element
        And I add a multiple media content element with names "Image 1" and "Image 2"
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Multiple media" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with heading content element
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Heading" content element
        And I add a heading content element with type "H3" and "Welcome to our store" content
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Heading" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with products carousel content element
        Given the store has "iPhone 8" and "iPhone X" products
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Products carousel" content element
        And I add a products carousel content element with "iPhone 8" and "iPhone X" products
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Products carousel" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with products carousel by taxon content element
        Given the store has "Smartphones" taxonomy
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Products carousel by Taxon" content element
        And I add a products carousel by taxon content element with "Smartphones" taxonomy
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Products carousel by Taxon" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with products grid content element
        Given the store has "iPhone 8" and "iPhone X" products
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Products grid" content element
        And I add a products grid content element with "iPhone 8" and "iPhone X" products
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Products grid" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with products grid by taxon content element
        Given the store has "Smartphones" taxonomy
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Products grid by Taxon" content element
        And I add a products grid by taxon content element with "Smartphones" taxonomy
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Products grid by Taxon" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with taxons list content element
        Given the store classifies its products as "Smartphones" and "Laptops"
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Taxons list" content element
        And I add a taxons list content element with "Smartphones" and "Laptops" taxonomy
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Taxons list" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with two content elements
        Given there is an existing media with names "Image 1" and "Image 2"
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I click on Add button in Content elements section
        And I select "Single media" content element
        And I add a single media content element with name "Image 1"
        And I click on Add button in Content elements section
        And I select "Multiple media" content element
        And I add a multiple media content element with names "Image 1" and "Image 2"
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Single media" content element in Content elements section
        And I should see newly created "Multiple media" content element in Content elements section

    @ui @javascript
    Scenario: Adding page with template
        Given there is an existing template named "Homepage" with "Page" type that contains "Textarea, Single media" content elements
        When I go to the create page page
        And I fill the code with "my_page"
        And I fill the slug with "my_page"
        And I fill the name with "My page"
        And I select "Homepage" template
        And I confirm that I want to use this template
        And I add it
        Then I should be notified that the page has been created
        And I should see newly created "Textarea" content element in Content elements section
        And I should see newly created "Single media" content element in Content elements section
