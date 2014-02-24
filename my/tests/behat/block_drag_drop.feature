@blocks @my_blocks_drag_drop
Feature: Place a block in the content area
  I need to log into the system
  And I need to go to the /my page and turn editing on
  And I need to drag the "online_users" block into the content area

  @javascript
    Scenario: Drag a block on the /my page into the content area
      Given I log in as "admin"
      And I follow "My home"
      And I click on "input[value='Customise this page']" "css_element"
      And I wait until "img[alt='Move Course overview block']" "css_element" exists
      When I drag with handle "block_online_users" "block" and I drop it in "#region-content > .region-content" "css_element"
      Then "block_online_users" "block" should exist in the "region-content" "region"
