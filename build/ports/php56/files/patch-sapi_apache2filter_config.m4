--- sapi/apache2filter/config.m4.orig	2013-12-10 23:31:06.000000000 +0000
+++ sapi/apache2filter/config.m4	2013-12-13 21:50:25.481258052 +0000
@@ -68,7 +68,7 @@ if test "$PHP_APXS2FILTER" != "no"; then
   fi
 
   APXS_LIBEXECDIR='$(INSTALL_ROOT)'`$APXS -q LIBEXECDIR`
-  if test -z `$APXS -q SYSCONFDIR`; then
+  if true; then
     INSTALL_IT="\$(mkinstalldirs) '$APXS_LIBEXECDIR' && \
                  $APXS -S LIBEXECDIR='$APXS_LIBEXECDIR' \
                        -i -n php5"
