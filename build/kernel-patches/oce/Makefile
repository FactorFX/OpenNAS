# In case someone's interested: I've contacted Emulex technical support
# and they've confirmed promisc mode bug, it would be fixed with the
# next driver update. Meanwhile Emulex kindly provided me updated
# version, the patch is very simple
PATCHFILE=patch-oce_mbox.c

all:

install:
	(cd /usr/src; patch -p0 < ${.CURDIR}/files/${PATCHFILE})
