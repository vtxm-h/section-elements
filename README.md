# Section Elements (Contao)

Inline structural content elements for Contao articles.

This bundle provides Start / Area / End content elements that allow editors to build layout structures directly inside one Contao article.

It is not a replacement for `layout-preset` or `content-grid`. It is an additional inline-structure system for content that is only used once and should not require hidden source articles.

- Inline structural wrappers inside the current article
- Grid and split section types
- Theme-agnostic output
- No frontend CSS included by design
- No JavaScript included by design


## Content Elements

The bundle registers these content elements in the `vtxm` category:

- `vtxm_section_start`
- `vtxm_section_area`
- `vtxm_section_end`

`vtxm_section_start` opens the section structure.

`vtxm_section_area` switches from area A to area B inside split sections.

`vtxm_section_end` closes the current section structure.


## Usage

Add the section elements directly inside one Contao article.

Grid:

```text
VTXM Section Start
Iconbox
Iconbox
Iconbox
VTXM Section End
```

Split:

```text
VTXM Section Start
Members Grid
VTXM Section Area
Text
Timeline
VTXM Section End
```

Always close `VTXM Section Start` with `VTXM Section End`.

Use `VTXM Section Area` only inside split sections.

Do not cross-nest Grid, Section or Layout structures incorrectly. Wrong nesting can break the frontend layout because these elements intentionally output open and close tags.


## Recommended Role

Recommended separation:

- `content-elements` = reusable content blocks
- `content-grid` = render another article as a grid
- `layout-preset` = render external slots as split layout
- `section-elements` = inline structure inside the current article

Use this bundle when a grid or split structure belongs to the current article and the content is not meant to be reused elsewhere.


## Section Options

The start element supports:

- `sectionType`: `grid`, `split`
- `sectionPreset`: `default`, `about`, `contact`, `spotlight`
- `sectionColumns`: `2`, `3`, `4`
- `sectionGap`: `small`, `medium`, `large`
- `sectionGridAlign`: `start`, `center`, `stretch`
- `sectionRatio`: `50-50`, `60-40`, `40-60`, `70-30`, `30-70`
- `sectionAlign`: `start`, `center`
- `sectionDivider`
- `sectionStackMobile`

CSS ID / class values from the backend are preserved on the root section element.


## HTML Hooks

Root classes:

- `.ce_vtxm_section_start`
- `.vtxm-section`
- `.section--grid`
- `.section--split`
- `.preset--default`
- `.preset--about`
- `.preset--contact`
- `.preset--spotlight`

Grid modifiers:

- `.cg--cols-2`
- `.cg--cols-3`
- `.cg--cols-4`
- `.cg--gap-small`
- `.cg--gap-medium`
- `.cg--gap-large`
- `.cg--align-start`
- `.cg--align-center`
- `.cg--align-stretch`

Split modifiers:

- `.ratio--50-50`
- `.ratio--60-40`
- `.ratio--40-60`
- `.ratio--70-30`
- `.ratio--30-70`
- `.align--start`
- `.align--center`
- `.has-divider`

Shared modifiers:

- `.is-stack-mobile`

Inner hooks:

- `.vtxm-section__headline`
- `.vtxm-section__inner`
- `.content-grid__inner`
- `.layout-preset__inner`
- `.vtxm-section__area`
- `.vtxm-section__area--a`
- `.vtxm-section__area--b`
- `.layout-preset__area`
- `.layout-preset__area--a`
- `.layout-preset__area--b`


## Templates

Templates are located at:

```text
src/Resources/contao/templates/
```

Templates:

- `ce_vtxm_section_start.html5`
- `ce_vtxm_section_area.html5`
- `ce_vtxm_section_end.html5`


## Installation (via Composer / Contao Manager)

Add the package definition to your Contao project `composer.json` or install it via your configured repository setup.

Example package reference:

```json
{
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "vtxm-h/section-elements",
        "version": "1.0.0",
        "type": "contao-bundle",
        "license": "MIT",
        "description": "Inline structural section content elements for Contao 4.13 articles.",
        "dist": {
          "url": "https://github.com/vtxm-h/section-elements/archive/refs/tags/v1.0.0.zip",
          "type": "zip"
        },
        "autoload": {
          "psr-4": {
            "Vendor\\SectionElementsBundle\\": "src/"
          }
        },
        "require": {
          "php": "^8.0",
          "contao/core-bundle": "^4.13",
          "contao/manager-plugin": "^2.0"
        },
        "extra": {
          "contao-manager-plugin": "Vendor\\SectionElementsBundle\\ContaoManager\\Plugin"
        }
      }
    }
  ]
}
```

Install:

```bash
composer require vtxm-h/section-elements
```

Then update the Contao database so the new `tl_content` fields are created.


## Compatibility

Contao 4.13
PHP 8.0+


## License

MIT
