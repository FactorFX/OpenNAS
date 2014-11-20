# Created by: Neil Blakey-Milner <nbm@rucus.ru.ac.za>
# $FreeBSD: head/ftp/curl/Makefile 370549 2014-10-09 15:24:43Z sunpoet $

PORTNAME=		curl
PORTVERSION=	7.38.0

COMMENT=	Non-interactive tool to get files from FTP, GOPHER, HTTP(S) servers

MASTERDIR=	/usr/ports/ftp/curl

STAGEDIR=	${NAS4FREE_ROOTFS}

do-install:
	$(MAKE) -C  ${WRKSRC} install DESTDIR=${NAS4FREE_ROOTFS}
	${CP} /usr/local/share/certs/ca-root-nss.crt ${NAS4FREE_ROOTFS}/${PREFIX}/share/certs
	

.include "${MASTERDIR}/Makefile"
