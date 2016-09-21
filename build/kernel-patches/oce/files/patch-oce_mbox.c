--- sys/dev/oce/oce_mbox.c.orig	2016-09-21 17:40:59.582021442 +0200
+++ sys/dev/oce/oce_mbox.c	2016-09-21 17:41:20.901017771 +0200
@@ -865,7 +865,7 @@
 		req->iface_flags = MBX_RX_IFACE_FLAGS_PROMISCUOUS;
 
 	if (enable & 0x02)
-		req->iface_flags = MBX_RX_IFACE_FLAGS_VLAN_PROMISCUOUS;
+		req->iface_flags |= MBX_RX_IFACE_FLAGS_VLAN_PROMISCUOUS;
 
 	req->if_id = sc->if_id;
 
