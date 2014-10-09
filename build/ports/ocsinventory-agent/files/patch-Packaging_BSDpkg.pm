--- Agent/Backend/OS/Generic/Packaging/BSDpkg.pm.orig	2014-10-09 09:24:47.000000000 +0000
+++ Agent/Backend/OS/Generic/Packaging/BSDpkg.pm	2014-10-09 09:25:11.000000000 +0000
@@ -1,12 +1,12 @@
 package Ocsinventory::Agent::Backend::OS::Generic::Packaging::BSDpkg;
 
-sub check {can_run("pkg_info")}
+sub check {can_run("pkg info")}
 
 sub run {
   my $params = shift;
   my $common = $params->{common};
 
-  foreach(`pkg_info`){
+  foreach(`pkg info`){
       /^(\S+)-(\d+\S*)\s+(.*)/;
       my $name = $1;
       my $version = $2;

