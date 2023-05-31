$(function () {
  var authPostURL = $.wn.backendUrl("lucacalcaterra/ldapauth/ldap/signin");
  console.log(authPostURL)
  $("form").attr("action", authPostURL);
});
