# Dept cookiebar
Provides frontend shelf [cookiebar component](https://bitbucket.org/tamtam-nl/tamtam-frontend-shelf/src/e580d3cd0588402061388d6aaa96e74526a0cecf/components/cookiebar/simple/?at=develop) 1.0.0 implementation for Drupal 8

* Simple cookiebar that closes when close is pressed.
* Automatically assumes users consent when being closed.

## Requirements
* [Components ^1.0](https://www.drupal.org/project/components) 
* [Frontend shelf cookiebar](https://bitbucket.org/tamtam-nl/tamtam-frontend-shelf/src/e580d3cd0588402061388d6aaa96e74526a0cecf/components/cookiebar/simple/?at=develop)

## Installation

### Drupal
1. If you have satis.tamtam.nl already available in your composer.json file go to step 2. Otherwise add [satis](https://satis.tamtam.nl/) to your composer.json with the following command:  
`composer global config repositories.satis composer https://satis.tamtam.nl`
2. Add dd_cookiebar to your project through:  
`composer require drupal/dd_cookiebar:0.1.0`
3. Enable the module with
`drush en dd_cookiebar -y` and the default cookiebar markup will be automatically available in the page_bottom variable (html.html.twig)
4. Copy dd_cookiebar/templates/dd-cookiebar.html.twig to your own theme templates folder and override the defaults to your own preference. Alternatively you can override the variables in through the [hook\_page\_bottom](https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Render%21theme.api.php/function/hook_page_bottom/8.2.x)
5. You can disable or extend the default component assets with the *.libraries.yml file for example by adding the following to your THEME.libraries.yml:

```yaml
dd-cookiebar:
  version: 1.x
  css:
    theme:
      component/cookiebar.css: {preprocess: false}
```

[Drupal documentation library](https://www.drupal.org/docs/8/creating-custom-modules/adding-stylesheets-css-and-javascript-js-to-a-drupal-8-module)

### Frontend
Please refer to the frontend [Readme.md](https://bitbucket.org/tamtam-nl/tamtam-frontend-shelf/src/e580d3cd0588402061388d6aaa96e74526a0cecf/components/cookiebar/simple/README.md?at=develop&fileviewer=file-view-default)