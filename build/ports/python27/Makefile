# $FreeBSD: head/lang/python27/Makefile 372138 2014-11-04 09:14:21Z demon $

PORTNAME=	python27
PORTVERSION=	2.7.8

COMMENT=	Interpreted object-oriented programming language

MASTERDIR=	/usr/ports/lang/python27

post-install:
	for i in ${NAS4FREE_ROOTFS}${PREFIX}/lib/python2.7/lib-dynload/*.so; do \
		${STRIP_CMD} $$i; done						# Strip shared extensions

do-install:
	${CD} ${WRKSRC}
	$(MAKE) install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile
