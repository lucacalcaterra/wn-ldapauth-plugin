$(function () {
  var authPostURL = $.wn.backendUrl("lucacalcaterra/ldapauth/ldap/signin");
  $("form").attr("action", authPostURL);
});
