@greeting_customer
Feature: Statically greeting a customer
    In order to provide an ultimate customer experience
    As a Store Owner
    I want to welcome new customers

    Scenario: Statically greeting a customer with an unknown name
        When a customer with an unknown name visits static welcome page
        Then they should be statically greeted with "Hello!"

    Scenario: Statically greeting a customer with a known name
        When a customer named "Krzysztof" visits static welcome page
        Then they should be statically greeted with "Hello, Krzysztof!"

    Scenario: Statically greeting Lionel Richie
        When a customer named "Lionel Richie" visits static welcome page
        Then they should be statically greeted with "Hello, is it me you're looking for?"
