<?php
// Add/Edit Form partial
if (!isset($addEditForm)) {
    $addEditForm = 'adminauth2/add_edit_form';
}
// Standard Form Table
if (!isset($formParentTable)) {
    $formParentTable = 'form_parent_table';
}
// Table with Tabs support
if (!isset($formParentTabbed)) {
    $formParentTabbed = 'form_parent_tabbed';
}
if (!isset($formParentTabbedContent)) {
    $formParentTabbedContent = 'form_parent_tabbed_content';
}
// Table body with Rows of Elements
if (!isset($formFieldsetRows)) {
    $formFieldsetRows = 'form_fieldset_rows';
}
// A Collection Table
if (!isset($formCollectionTable)) {
    $formCollectionTable = 'form_collection_table';
}
// One Collection element row
if (!isset($formCollection)) {
    $formCollection = 'form_collection';
}
// Collection content
if (!isset($formCollectionContent)) {
    $formCollectionContent = 'form_collection_content';
}
// A single Element
if (!isset($formElement)) {
    $formElement = 'form_element';
}

$commonVariables = compact(
    'formParentTable',
    'formParentTabbed',
    'formParentTabbedContent',
    'formFieldsetRows',
    'formCollectionTable',
    'formCollection',
    'formCollectionContent',
    'formElement',
    'provider'
);
