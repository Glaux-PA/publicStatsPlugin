# Contributing

Thank you for taking the time to help with this plugin.

## Reporting a problem

Open an issue at <https://github.com/Glaux-PA/publicStatsPlugin/issues> and
include:

- The OJS version and the plugin version, taken from version.xml.
- The PHP version.
- Which section of the statistics page is affected.
- What you expected and what happened instead. If there is an error, the
  relevant lines from the OJS error log help a lot.

For questions that are not bugs, write to Glaux Publicaciones Académicas
through <https://glaux.es/>.

## Branches

- `main` and `stable-3_5_0`: the version for OJS 3.5.
- `stable-3_4_0`: the version for OJS 3.4.

Send a pull request against the branch for the OJS version you are using. If
the change makes sense for both versions, say so in the pull request and we
will port it.

## Code

- PHP files start with `declare(strict_types=1)` and use the same file header
  as the rest of the plugin.
- Four spaces for indentation, no tabs.
- Data queries go in `services/`, HTTP endpoints in `controllers/traits/`, and
  the dashboard scripts in `templates/js/`.
- User-visible text goes in `locale/<code>/locale.po`, never in the code.

Before sending a pull request, run `php -l` on the files you changed and open
the statistics page of a journal to check the sections you touched. There is
no test suite yet.

README.md explains how to add a new section and how to add a translation.

## Commits

One change per commit, with a message that says what the commit does. Pull
requests can contain several commits.

## License

The plugin is GPL v3. By contributing you agree that your contribution is
distributed under the same license.
