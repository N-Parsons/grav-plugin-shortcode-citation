# Grav Shortcode Citation Plugin

This plugin for [Grav](https://getgrav.org) adds the ability to insert citations into pages via shortcodes (eg. `[cite=id /]`).

## Example output

![Example output for shortcode-citation](assets/references_example.png)

## Installation

Typically a plugin should be installed via [GPM](http://learn.getgrav.org/advanced/grav-gpm) (Grav Package Manager):

```
$ bin/gpm install shortcode-citation
```

Alternatively it can be installed via the [Admin Plugin](http://learn.getgrav.org/admin-panel/plugins).


## Usage

### Adding references

The plugin adds a References section to pages inheriting the "default" blueprint. The references are stored per-page and only those that are cited in the page will be listed in the reference section. The order of the references in the list doesn't matter; they will always print in the order that they are cited in the text. The id entered **must** be unique.

This plugin is mostly to make citations easier, so the reference printing logic is currently quite simplistic; text is mostly printed as-is. This means that you are responsible for consistency of things like the format of author names, but also adds some flexibility to bend the rules a little bit. If a field is left empty or is not considered relevant for that reference type, it will be ignored.

Each section of the reference is contained in a span with a class such as `tax-author`, so it's pretty easy to format your reference section via CSS.

### Inserting citations

Citations are inserted via a shortcode in the form `[cite=id /]`, and will be printed as `[n]` in the text, with it being hyperlinked to the relevant entry in the references. Repeated citations of the same source will print the same number and link.

### Printing the reference list

The reference list can be printed either by adding `[cite /]` with no key id, or by including the `partials/citations.html.twig` template in your page template.

The heading for the reference section defaults to "References", but can be set in the plugin config via `heading_text` or as an option in the shortcode used to print it (eg. `[cite heading=Bibliography /]`). The title can also be disabled by setting the heading text to "false" via the same methods.


## Customisation and extension

I welcome PRs for internationalisation and addition of new citation types.

However, if you prefer to create new citations types locally, you can extending the plugin without needing to fork it by following the instructions below.

### Adding reference types

You can add to the list of reference types by creating your own `blueprints/default.yaml` that adds to the list of options, using the blueprint below as a template.

```
'@extends':
  type: default
  context: blueprints://pages

form:
  fields:
    tabs:
      type: tabs
      active: 1
      fields:
        content:
          fields:
            references:
              fields:
                header.references:
                  fields:
                    .type:
                      options:
                        new_key_name: 'Name for the new citation type'
                        another_key: 'Another citation type'
```

### Formatting new reference types

References are formatted via Twig templates, based on the name of the key for the reference type. For the above blueprint, these files would be called `new_key_name.html.twig` and `another_key.html.twig`, and saved at `partials/citations/`.


## Related projects

If this plugin doesn't fit your needs, try one of these other plugins:
- [bibliography](https://github.com/OleVik/grav-plugin-biblatex)
- [biblatex](https://github.com/OleVik/grav-plugin-biblatex)


## License

This plugin is licensed under the permissive [MIT License](LICENSE).
