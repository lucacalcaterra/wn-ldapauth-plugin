# wn-ldapauth-plugin
Winter CMS Ldap Active Directory Auth Plugin

This plugin provide LDAP - Active Directory  Authentication for Winter CMS.

## Usage
To install this plugin:

1. run: **composer require lucacalcaterra/wn-ldap-plugin** (--with-all-dependencies if there are dependencies issues) and go to step 3
 or
1. download and extract this archive in /plugins/lucacalcaterra/ldapauth 
2. back to website root and launch: **composer update**
3. run: **php artisan plugin:refresh LucaCalcaterra.LdapAuth**
4. go to Backend and fill the Ldap Settings (usually host, username and password, other parms should be ok if ldap attribute used is samAccountname) and save
5. now you can login with your ldap attribute (i.e. samAccountname) as login and password

Feel to submit PR or open new Issues.

## Author

Luca Calcaterra - 2022

### Third party library used for LDAP Authentication
LdapRecord: https://github.com/DirectoryTree/LdapRecord-Laravel

### Thanks to
@khoatd for the point of start: https://github.com/khoatran/october-ldap
