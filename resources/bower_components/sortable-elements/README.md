Sortable Elements
============================

Based on [html5sortable](https://github.com/voidberg/html5sortable) this repo is supposed to become a web component for sortable elements.
Still a long way to go though.

> **Lightweight standalone library for sorting/rearranging elements in lists and grids using native HTML5 drag and drop API.**

## Features
* Less than 1KB (minified and gzipped). ?
* Built using native HTML5 drag and drop API.
* Supports both list and grid style layouts.
* Supports current versions of all major browsers: Chrome, Firefox, Safari, Opera, IE11+
* Supports exports as AMD, CommonJS or global

## Publishing
This serves as a reminder of what to do to correctly publish this package.
- [ ] run `npm test` an verify everything is fine
- [ ] run `gulp build` to create dist versions
- [ ] increase version number
    - [ ] `bower.json`
    - [ ] `package.json`
- [ ] commit all changes including `bower.json` and `package.json`
- [ ] tag version with `git tag {semver}`
- [ ] push updates to github with `git push --tags`
- [ ] run `npm publish` from within package to update npm
