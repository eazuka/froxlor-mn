# Developer Notes

This is a work in progress, which aims to add Doctrine2 as a model layer to Froxlor.

# Goals

* get rid of all handcrafted SQL, which is scattered all over the project
* provide decent export/import facility for Froxlor
* be able to support other DBs in the future, especially SQLite

# Status

* We have Doctrine2 models for all databases
* At the moment, all database columns are public members of the model classes,
  but this may change in the future (to getters/setters). Use with caution
* We do *not* rely on Doctrine2 yet to manage our DB schema

# ToDo

* we still miss most of the "reverse" relations (domain->x)

* panel_domains.ismainbutsubto - must actually be foreign key to panel_domains
  and nullable
    => add this to the foreign_keys branch,
       and test again with v701 db, check whether the command actually runs
    => are there any error checks at all in update.php?

* there should be a testable environment where we can see the scriptrunner's results

* add export/import feature

# Notes

* Doctrine 2.5 supports only PHP 5.5+, which is not available everywhere yet.
  Therefore we use Doctrine 2.4 for now
