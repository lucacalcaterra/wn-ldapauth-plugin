# wn-ldapauth-plugin
Winter CMS Ldap Auth Plugin

This plugin provide LDAP Authentication for Winter CMS (but should working in October CMS too).

## Usage
To install this plugin:

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
