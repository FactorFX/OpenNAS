# Created by: Henrik Brix Andersen <brix@FreeBSD.org>
# $FreeBSD: head/sysutils/usbutils/Makefile 356165 2014-06-01 19:22:21Z brix $

PORTNAME=		usbutils
PORTVERSION=	0.86

COMMENT=		Utility for listing USB devices

MASTERDIR=	/usr/ports/sysutils/usbutils

do-install:
	${INSTALL_SCRIPT} ${WRKSRC}/usb-devices ${NAS4FREE_ROOTFS}/usr/local/bin
	${INSTALL_PROGRAM} ${WRKSRC}/lsusb ${NAS4FREE_ROOTFS}/usr/local/sbin
	${INSTALL_SCRIPT} ${WRKSRC}/update-usbids.sh ${NAS4FREE_ROOTFS}/usr/local/sbin
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/usbutils/
	${INSTALL_DATA} ${WRKSRC}/usb.ids ${NAS4FREE_ROOTFS}/usr/local/share/usbutils/
	${INSTALL_DATA} ${WRKSRC}/usb.ids.gz ${NAS4FREE_ROOTFS}/usr/local/share/usbutils/
	
	# Manpages
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/man/man1/ ${NAS4FREE_ROOTFS}/usr/local/man/man8/
	gzip -c ${WRKSRC}/usb-devices.1 > ${WRKSRC}/usb-devices.1.gz
	gzip -c ${WRKSRC}/lsusb.8 > ${WRKSRC}/lsusb.8.gz
	$(INSTALL_DATA) ${WRKSRC}/usb-devices.1.gz ${NAS4FREE_ROOTFS}/usr/local/man/man1/
	$(INSTALL_DATA) ${WRKSRC}/lsusb.8.gz ${NAS4FREE_ROOTFS}/usr/local/man/man8/
	rm -f ${WRKSRC}/usb-devices.1.gz
	rm -f ${WRKSRC}/lsusb.8.gz

post-install:
	${ECHO} "Do nothing"

.include "${MASTERDIR}/Makefile"
