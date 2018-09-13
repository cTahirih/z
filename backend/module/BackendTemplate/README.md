# BackendTemplate module

**IMPORTANT: This module SHOULD ONLY be used on Development mode.**

Transparently rewrites the view template file name with an underscore (`_`) prefix. For example, a view `application/home` is rewritten to `application/_home`.

This prefixed template is called a "Backend Template."

This allows Backend and Frontend developers to work with different versions of a template. Backends can create and debug functionality with a bare template, while Frontends implement the real template.

Frontends can use the Backend Templates as an starting point. Backends can test and add more functionality without touching or breaking the real templates.

If the prefixed Backend Template file doesn't exist, it will revert to the original file.


## Configuration

To configure, add to `nodos-developers.local.php`:

    'show_backend_template' => false,

As it's obvious, Backend Templates will be shown when this flag is set to `true`.


## View Partials

The stock Partial View Helper is replaced with an extended version that implements the same rewriting operation.

This means that:

    <?= $this->partial('foo/bar') ?>

will render `foo/_bar`.

**Note:** A PartialLoop View Helper replacement is not implemented yet.