# Section Elements (Contao)

Inline structural Start / Area / End content elements for Contao articles.

This bundle provides article-local wrappers that allow editors to build grid or split structures directly inside the current Contao article. It does not provide external reusable section content and should not become a page builder.

- Inline structural wrappers inside the current article
- Grid and split section types
- Theme-agnostic output
- No frontend CSS included by design
- No JavaScript included by design


## Repository Role

Recommended separation in the VTXM modular Contao element system:

- `content-elements` = reusable content blocks
- `section-elements` = inline Start / Area / End structures inside the current article
- `content-grid` = render another article as a configurable grid
- `layout-preset` = macro layout with external article, module or HTML slots
- `article-insert` = insert a selected article into a module or layout context

Use `section-elements` when the structure belongs to the current article and the contained content is edited directly in that article.

Do not use `section-elements` when the content must be reused in several places. For reusable external content, use `layout-preset`, `content-grid` or `article-insert` depending on the use case.


## Content Elements

The bundle registers these content elements in the `vtxm` category:

- `vtxm_section_start`
- `vtxm_section_area`
- `vtxm_section_end`

`vtxm_section_start` opens the section structure.

`vtxm_section_area` switches from area A to area B inside split sections.

`vtxm_section_end` closes the current section structure.


## Section Options and DCA Behavior

The start element uses `sectionType` as a DCA selector. The field has `submitOnChange` enabled, so changing the section type triggers a backend reload and shows the matching subpalette.

For `sectionType = grid`, the backend shows the `sectionType_grid` subpalette:

- `sectionColumns`
- `sectionGap`
- `sectionGridAlign`

For `sectionType = split`, the backend shows the `sectionType_split` subpalette:

- `sectionRatio`
- `sectionAlign`
- `sectionDivider`

Shared settings remain visible:

- `sectionPreset`
- `sectionStackMobile`
- `headline`
- `cssID`
- Contao visibility fields such as `protected`, `guests`, `invisible`, `start` and `stop`

Supported option values:

- `sectionType`: `grid`, `split`
- `sectionPreset`: `default`, `about`, `contact`, `spotlight`
- `sectionColumns`: `2`, `3`, `4`
- `sectionGap`: `small`, `medium`, `large`
- `sectionGridAlign`: `start`, `center`, `stretch`
- `sectionRatio`: `50-50`, `60-40`, `40-60`, `70-30`, `30-70`
- `sectionAlign`: `start`, `center`
- `sectionDivider`
- `sectionStackMobile`

CSS ID and class values from the backend are preserved on the root section element.


## Structural Rules and Limitations

Every `VTXM Section Start` must be followed by a matching `VTXM Section End`.

`VTXM Section Area` is only valid inside a split section.

A grid section must not contain `VTXM Section Area`.

A split section should normally contain exactly one `VTXM Section Area`.

Invalid ordering or missing closing elements can break frontend markup.

The bundle intentionally does not auto-correct invalid structure.

Editors should keep Start / Area / End elements together in the same article.

Avoid crossing or interleaving unrelated structural wrappers.

Grid example:

```text
VTXM Section Start
* Text
* Iconbox
* Iconbox
VTXM Section End
```

Split example:

```text
VTXM Section Start
* Media Text
VTXM Section Area
* Timeline
* Factsbox
VTXM Section End
```


## Current Stack Behavior

During rendering, `VTXM Section Start` records the current section type in an internal stack.

`VTXM Section Area` checks whether the current section type is `split`.

`VTXM Section End` closes the current section type.

`VTXM Section Area` outputs nothing when used outside a split section.

`VTXM Section End` outputs nothing if no valid section type is active.

This stack is a rendering helper, not full editor-side validation. The bundle does not claim to prevent or repair all malformed nesting.


## Debugging Malformed Sections

If frontend markup appears broken:

1. Check that every Section Start has a Section End.
2. Check that Section Area is used only in split sections.
3. Check the article element order.
4. Clear the Contao cache after DCA or template changes.
5. Inspect the generated HTML structure.


## HTML Hooks

The current templates emit the following class names. Treat them as public hooks unless a migration explicitly changes them.

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
- `.vtxm-section__area`
- `.vtxm-section__area--a`
- `.vtxm-section__area--b`

Compatibility hooks currently emitted by the templates:

- `.content-grid__inner`
- `.layout-preset__inner`
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

Install the package through your configured repository setup:

```bash
composer require vtxm-h/section-elements
```

If the package is installed through an inline Composer package repository, keep the release reference generic and replace `VERSION` with the selected release tag. The tag in the `dist.url` must match the actual release tag.

```json
{
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "vtxm-h/section-elements",
        "version": "VERSION",
        "type": "contao-bundle",
        "license": "MIT",
        "description": "Inline structural section content elements for Contao 4.13 articles.",
        "dist": {
          "url": "https://github.com/vtxm-h/section-elements/archive/refs/tags/VERSION.zip",
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

Then update the Contao database so the existing `tl_content` fields are created.


## Compatibility

Contao 4.13
PHP 8.0+


## License

MIT
