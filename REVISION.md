# Revision history

### v4.0.0 (2020-01-07)
* Add new section: Reports
* Add report about Stockholm's museum web sites 2019
* Add new themes: minimalistic, dark, and colorful
* Report text **kmom04**

### v3.0.1 (2019-12-04)
* CSS bug fixes; errors found **@dbwebb** using **W3C-validator**
* Make **@desinax**-plugins **typographic-grid** and **vertical-grid** pass both **CSS-Lint** and **W3C-validators**
* Turn off `safe-area-inset-*` in CSS, it doesn't pass W3C-validator for some reason
* Change so when main menu and side-bars are hidden they use 1 column in the vgrid (otherwise it will lead to negative width)
* Make `normalize.css` pass **CSS-Lint**
* Add `viewport-fit=cover` to `<meta name="viewport">` @ `view/anax/v2/layout/dbwebb_se.php` cause it's required for `safe-area-inset-*`, but that had to be turned off anyway!

### v3.0.0 (2019-11-19--2019-12-04)
* Add `kmom03.less` in `theme/src`
* Change to `kmom03.min.css` to default CSS in: `config/page.php`
* Add LESS-files for kmom03 @ `theme/src`
* Implement @desinax-modules: `typographical-grid` & `vertical-grid`
* Add fonts; **Bubblegum Sans** for headings, **Roboto** for body
* Report text **kmom03**

### v2.0.1 (2019-11-17)
* Report text **kmom02**
* CSS bug fixes; errors found @dbwebb using W3C-validator
* Clean up responsive media-queries; don't use example query

### v2.0.0 (2019-11-13--16)
* Add `theme`-folder; Move CSS-src-files here
* Use **LESS** for CSS-files
* Add `kmom02.min.css` and change to default CSS in: `config/page.php`
* Change Nginx @dev from localhost to `dev.student.bth.se`
* Make CSS responsive - split up to Base, Block, Part, or Layout-files
* Lot's of CSS design changes
* Changes in `view/anax/v2`; breadcrumb, header, layout, next-previous

### v1.0.0 (2019-11-08)
* Add content to Start, About, Test (new page)
* Style & content to blocks: Navbar, Flash, Footer
* More CSS styling
* Add `.csslintrc` settings
* Fix HTML/CSS errors, add CSS3 validation gif
* Add report text kmom01
* Add `open-in-browser-proj.json` settings
* (Local dev Nginx settings are in file: `/usr/local/etc/nginx/vhosts/localhost.conf`)

### v0.9.1 (2019-11-07)
* Rewrite `content/index.md` with info about **LokeTony**
* Add images to `htdocs/img`: `loketony.jpg`, `stockholm.jpg`
* Add files to `/`: `README.md`, `REVISION.md`, `LICENSE.txt`
* Basic CSS-design: `htdocs/css/kmom01.css`
* Content to footer: `content/block/footer*.md`

### v0.9 (2019-11-05)
* First commit
* Initial setup
