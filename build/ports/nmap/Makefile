# Created by: David O'Brien (obrien@NUXI.com)
# $FreeBSD: security/nmap/Makefile 334897 2013-11-25 20:49:58Z ohauer $

PORTNAME=	nmap
DISTVERSION=	6.40
PORTREVISION=	2
CATEGORIES=	security ipv6
MASTER_SITES=	http://nmap.org/dist/ \
		LOCAL/ohauer

MAINTAINER=	ohauer@FreeBSD.org
COMMENT=	Port scanning utility for large networks

# http://nmap.org/book/man-legal.html
# Install the nmap modified license because of
# http://insecure.org/news/download-com-fiasco.html
LICENSE=	GPLv2
LICENSE_FILE=	${WRKSRC}/COPYING

LIB_DEPENDS=	libpcre.so:${PORTSDIR}/devel/pcre

USES=		gmake
USE_BZIP2=	yes
GNU_CONFIGURE=	yes

OPTIONS_SUB=	yes
OPTIONS_DEFINE=	DOCS IPV6 SSL
OPTIONS_DEFAULT=IPV6 SSL

SSL_USE=		OPENSSL=yes
SSL_CONFIGURE_ON=	--with-openssl=${OPENSSLBASE}
SSL_CONFIGURE_OFF=	--without-openssl
SSL_CFLAGS=		-I${OPENSSLINC}

IPV6_CONFIGURE_OFF=	--with-libpcap=${LOCALBASE}/IPv6

.include <bsd.port.options.mk>

# PR: ports/159376  Workaround if OS is build with WITHOUT_INET6
.if ! ${PORT_OPTIONS:MIPV6}
LIB_DEPENDS+=		libpcap.so:${PORTSDIR}/net/libpcap
.endif

CONFIGURE_ARGS+=--without-localdirs \
		--without-zenmap \
		--without-ndiff \
		--with-libpcre=${LOCALBASE} \
		--with-liblua=included \
		--without-nmap-update

CONFIGURE_ENV=	LUA_INCDIR="${LUA_INCDIR}" LUA_LIBDIR="${LUA_LIBDIR}"

# fix for gcc from ports
.if ${CC} != "cc" && ${CC} !="clang"
GCCLIBDIR_CMDS=	${CC} -print-file-name=libstdc++.so | ${SED} -e 's/libstdc++.so//'
CONFIGURE_ARGS+=LDFLAGS="-L$$(${GCCLIBDIR_CMDS})"
NDCC=	true
.endif

PORTDOCS=	CHANGELOG HACKING

# XXX limit results if we do a grep in the sources!
post-extract:
	@${RM} -rf ${WRKSRC}/mswin32

# reflect new mailing addreses
pre-patch:
	${SED} -i '' -e 's|nmap-dev@insecure.org|dev@nmap.org|g' \
	    ${WRKSRC}/nsock/src/nsock_core.c \
	    ${WRKSRC}/zenmap/share/zenmap/locale/hr/LC_MESSAGES/zenmap.mo

post-configure:
	@${REINPLACE_CMD} -e "s|^DESTDIR *=|& ${DESTDIR}|" ${WRKSRC}/Makefile

do-install:
	${INSTALL_PROGRAM} ${WRKSRC}/nmap ${NAS4FREE_ROOTFS}/usr/local/bin
	${INSTALL_PROGRAM} ${WRKSRC}/ncat/ncat ${NAS4FREE_ROOTFS}/usr/local/bin
	${INSTALL_PROGRAM} ${WRKSRC}/nping/nping ${NAS4FREE_ROOTFS}/usr/local/bin
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/ncat/
	$(INSTALL_DATA) ${WRKSRC}/ncat/certs/ca-bundle.crt ${NAS4FREE_ROOTFS}/usr/local/share/ncat/
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-mac-prefixes ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-os-db ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-payloads ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-protocols ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-rpc ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-service-probes ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nmap-services ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/docs/nmap.dtd ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/docs/nmap.xsl ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	$(INSTALL_DATA) ${WRKSRC}/nse_main.lua ${NAS4FREE_ROOTFS}/usr/local/share/nmap/
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/nmap/nselib
	${CP} -R ${WRKSRC}/nselib/* ${NAS4FREE_ROOTFS}/usr/local/share/nmap/nselib
	
	${MKDIR} ${NAS4FREE_ROOTFS}/usr/local/share/nmap/scripts
	${CP} -R ${WRKSRC}/scripts/* ${NAS4FREE_ROOTFS}/usr/local/share/nmap/scripts
	
	# Manpages
	gzip -c ${WRKSRC}/docs/nmap.1 > ${WRKSRC}/docs/nmap.1.gz
	gzip -c ${WRKSRC}/ncat/docs/ncat.1 > ${WRKSRC}/ncat/docs/ncat.1.gz
	gzip -c ${WRKSRC}/nping/docs/nping.1 > ${WRKSRC}/nping/docs/nping.1.gz
	$(INSTALL_DATA) ${WRKSRC}/docs/nmap.1.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/
	$(INSTALL_DATA) ${WRKSRC}/ncat/docs/ncat.1.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/
	$(INSTALL_DATA) ${WRKSRC}/nping/docs/nping.1.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/
	rm -f ${WRKSRC}/docs/nmap.1.gz
	rm -f ${WRKSRC}/ncat/docs/ncat.1.gz
	rm -f ${WRKSRC}/nping/docs/nping.1.gz

.include <bsd.port.mk>
