# AdminAuth2 CHANGELOG

### 2018-05-15
- Deprecated adminauth2Route function, replaced by `AdminAuth2\Route::set()`


### 2017-12-22
- Implement List column sorting.


### 2017-06-27
- Provider/Doctrine/DoctrineCrudProviderTrait.php
  - Use new naming convention for field names.


### 2017-03-06
- Enable Fancybox.


### 2017-02-24
- Controller\AdminAuth2CrudController
  - Fix preserve keys when merging POST files.
  - Set `created_by` value to Provider on Add action.
  - Set `updated_by` value to Provider on Edit action.
  - Add Event triggers on valid and invalid Login action.
  - Add getAdminCoreService().
  - Add getAdminUserService().
  - Add getAdminRoleService().

- Form\AdminRoleForm
  - Set Description field as non-required.

- Add new Form\TabbedFlatFormTrait, for flattening a Form with Tabs' data.

- Provider\AdminUserProvider
  - Set menu order for "Users and Roles" to go lower.

- Service\AdminCoreService
  - Add Event Manager.
  - Implement Menus visibility by ACL.

- Service\AdminUserService
  - Fix bug when user does not exist.

- Views
  - Change how common variables are passed in Add/Edit views.
  - Show properly Hidden elements.
  - Highlight properly a selected IconLetter in Menus.
  - Disgregate Form collection views.


### 2017-02-14
- Service\AdminCoreService
  - Add resources ACL to Menus.
  - Bump version to 1.0.3.


### 2017-02-06
- Implement TabbedFlatFormTrait.


### 2017-01-31
- Add ZF2 Events on Login.


### 2017-01-06
- Controller\AdminAuth2CrudController
  - Change how common variables are passed between partials in List.
    - Bump version to 1.2.1.
  - Change `[ ]` characters used in ID selectors in `view/adminauth2/form_collection.phtml`. jQuery doesn't support them.


### 2017-01-04
Implement Form in List, which allows having filter elements, etc.

- Controller\AdminAuth2CrudController
    - Bump version to 1.2.0.
- Provider\Doctrine\DoctrineListProviderTrait
    - Bump version to 2.0.0.
- Create new Provider\ListWithFormProviderInterface interface.
- Create new Provider/ListWithFormProviderTrait trait.


### 2016-12-29
Resources declaration has changed, and this required a big, big refactor on Providers architecture, separation of Doctrine code into Traits and separate ResourceProvider classes for AdminUserProvider and AdminRoleProvider.

- Controller\AdminAuth2BaseController
    - Bump version to 1.1.0.
- AbstractDoctrineCrudProvider 
    - Bump version to 2.0.0.
    - Namespace moved to Provider\Doctrine.
- Deleted AbstractDoctrineListProvider
- AdminRoleProvider
    - Bump version to 2.0.0.
    - Reimplement without extending AbstractDoctrineCrudProvider.
    - Refactor with delegate class AdminRoleResourceProvider.
- AdminUserProvider
    - Bump version to 2.0.0.
    - Reimplement without extending AbstractDoctrineCrudProvider.
    - Refactor with delegate class AdminUserResourceProvider.
- New Trait classes
    - Provider\Doctrine\DoctrineCrudProviderTrait
    - Provider\Doctrine\DoctrineListProviderTrait
- New MenuIdInterface interface.
- New MenuProviderInterface interface.
- ResourcesProviderTrait
    - Bump version to 1.1.0.
- ResourceService
    - Bump version to 1.1.0.


### 2016-11-10
- AdminCoreService
    - Menus are now handled as a PriorityList.
    - Bumped version to 1.0.1.

### 2016-09-26
- Case-sensitivity fixes on Admin Role name.
    - Bump ConsoleController version to v1.0.1.
    - Bump AdminRoleService version to v1.0.1.
    - Bump AdminUserService version to v1.0.1.
- Fix correct usage of Doctrine boolean field on AdminRoleService.
- Use `active` field when querying Admin Roles and Users.
- Fix URLs in module.config.php, they should not use a leading `/`.


### 2016-09-21
- LoginController
    - Small bugfix when fetching role.
    - Bump version to 1.0.1.
- Add Unit Tests!


### 2016-09-19
- Remove extending from BaseController on AdminAuth2BaseController.
- Bump AdminAuth2BaseController version to 1.0.1.

- Add ACL to CRUD controller actions.
- Enforce interfaces in AdminAuth2BaseController and AdminAuth2CrudController.


### 2016-09-15
- Implement all CRUD operations, built-in AdminUser and AdminRole maintenance. This is the first version for everything.


### 2016-08-16
Implement List.

