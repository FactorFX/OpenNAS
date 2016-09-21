--- sys/dev/oce/oce_mbox.c.orig 2015-06-24 15:51:28.000000000 +0300
+++ sys/dev/oce/oce_mbox.c      2015-06-24 15:51:32.000000000 +0300
@@ -865,7 +865,7 @@
                req->iface_flags = MBX_RX_IFACE_FLAGS_PROMISCUOUS;

        if (enable & 0x02)
-               req->iface_flags = MBX_RX_IFACE_FLAGS_VLAN_PROMISCUOUS;
+               req->iface_flags |= MBX_RX_IFACE_FLAGS_VLAN_PROMISCUOUS;

        req->if_id = sc->if_id;