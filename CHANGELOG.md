To Do
=====

 * fix responsiveness issues
 * add legal terms page
 * manage Sendgrid unsubscriptions callback hooks
 * check newsletter email sendings
 * implement newsletter redesign

Changelog
=========

##### Version 5.09.07 (WIP)
 * fix bugs
 * change address
 * remove Museum logo from footer

##### Version 5.09.06 (2023-04-12)
 * add newsletter reCaptcha form protection

##### Version 5.09.05 (2023-04-11)
 * set PHP 8.2 minimum required version
 * Font Awesome 6.0 upgrade
 * Symfony v5.22 security update

##### Version 5.09.04 (2022-03-31)
 * fix problem rendering not assigned page images

##### Version 5.09.03 (2022-03-24)
 * change to 5 (info) - 7 (image) columns in homepage sliders panel
 * change frontend layout header logo dimensions
 * swap to dark main menu background
 * change frontend main menu font & spacing dimensions
 * improve frontend footer columns responsiveness
 * improve frontend footer calendar section container
 * improve forms font size
 * improve card-subtitle font size

##### Version 5.09.02 (2022-03-23)
 * composer dependencies update
 * yarn dependencies update
 * remove some ansible playbook filenames
 * improve frontend calendar view
 * disable show previous editions if there are no related activities condition
 * enable show related activities if there are no previous editions condition
 * refactor Page previous editions to allow many-to-many self-referencing relationships
 * increase up to 9 highlighted items in homepage view
 * change archive year views & structure

##### Version 5.09.01 (2022-03-01)
 * Symfony 5.4.5 update
 * replace 'previous_editions' translations
 * improve iframe vimeo frontend header in page detail
 * apply reverse order to previous editions elements
 * make page menu level 1 & 2 mandatory rendering related activities & previous editions
 * fix frontend page highlited_image render problems
 * add show_previous_editions_if_there_are_no_related_activities condition in frontend page detail view
 * improve background table cell circle in frontend agenda view

##### Version 5.09.00 (2022-02-22)
 * fix role security issue
 * fix legacyId bad imports issues
 * add previous editions pages
 * add Terms of Service frontend page view
 * add page images admin
 * add frontend share buttons in page detail view
 * show page images slideshow
 * Symfony 5.4 upgrade
 * add SlideshowPage management
 * add VisitingHours management
 * make menu color labels dynamic
 * add frontend phone calls action
 * add frontend today mark into calendars
 * show page videos in detail page view
 * show related pages in detail page view

##### Version 5.08.01 (2021-11-26)
 * fix missing summary text in Irradiador list view
 * add agenda side in list
 * add info page template view
 * add missing info cards in default page view
 * add missing brand new favicon black
 * hide unnecessary ConfigFooterInformation admin
 * add Archive admin help image to only allow squared aspects

##### Version 5.08.00 (2021-11-25)
 * fix broken testing suite
 * add page template types
 * add archive frontend views
 * add irradiador frontend views

##### Version 5.07.00 (2021-11-19)
 * fix missing assets install command execution during Ansible deploy
 * add translations management
 * add ConfigCalendarWorkingDay admin
 * add ConfigFooterInformation admin

##### Version 5.06.00 (2021-11-18)
 * add latest version of Elasticsearch engine
 * add Stimulus autocomplete frontend layout search bar
 * improve frontend page templates types render
 * improve current menu render in frontend detail page render
 * add newsletter subscription management
 * add dynamic frontend calendar management

##### Version 5.05.00 (2021-08-16)
 * fix ArtistAdmin edit error
 * add Admin user securized area
 * decide better highlighted homepage aspect ratio covers
 * improve PageAdmin

##### Version 5.04.00 (2021-08-10)
 * improve sonata admins
 * improve frontend page templates render
 * add Admin Dashboard info blocks
 * add translatable fields
 * add Page template types management & make frontend templates render according to it
 * add NewsletterPost location attribute
 * add NewsletterPost admin
 * add SendGrid mail manager
 * add Foundation for Emails CSS framwork
 * add Newsletter preview, test & send actions

##### Version 5.03.00 (2021-08-04)
 * add sonata admin dependency
 * add frontend page template render
 * add Ansible deployment process management
 * add testing suite
 * add scripts to import old database records

##### Version 5.02.00 (2021-07-28)
 * add frontend entities
 * add frontend homepage slideshow
 * create CSV import commands from legacy database
 * improve menu rendering

##### Version 5.01.00 (2021-07-13)
 * add menu rendering

##### Version 5.00.00 (2021-07-05)
 * first skeleton app
