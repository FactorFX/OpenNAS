# Created by: Wen Heping <wenheping@gmail.com>
# $FreeBSD: sysutils/tmux/Makefile 323874 2013-07-29 08:30:06Z gahr $
NO_PKG_REGISTER=yes
PORTNAME=	tmux
PORTVERSION=	1.8
PORTREVISION=	1
CATEGORIES=	sysutils
MASTER_SITES=	SF/${PORTNAME}/${PORTNAME}/${PORTNAME}-${PORTVERSION}

MAINTAINER=	gahr@FreeBSD.org
COMMENT=	A Terminal Multiplexer

LICENSE=	BSD

GNU_CONFIGURE=	yes
USES=		pkgconfig

MAN1=		tmux.1

OPTIONS_DEFINE=	LIBEVENT2 LIBEVENT_STATIC BACKSPACE

.include <bsd.port.options.mk>

.if ${PORT_OPTIONS:MLIBEVENT2}
CONFIGURE_ENV+=	LIBEVENT_CFLAGS="-I${LOCALBASE}/include/event2/compat" \
		LIBEVENT_LIBS="-L${LOCALBASE}/lib/event2 -levent"
. if ${PORT_OPTIONS:MLIBEVENT_STATIC}
BUILD_DEPENDS+=	${LOCALBASE}/lib/event2/libevent.a:${PORTSDIR}/devel/libevent2
LESTATIC=	${LOCALBASE}/lib/event2/libevent.a
. else
LIB_DEPENDS=	event-2:${PORTSDIR}/devel/libevent2
. endif
.else
CONFIGURE_ENV+=	LIBEVENT_CFLAGS="-I${LOCALBASE}/include" \
		LIBEVENT_LIBS="-L${LOCALBASE}/lib -levent"
. if ${PORT_OPTIONS:MLIBEVENT_STATIC}
BUILD_DEPENDS+=	${LOCALBASE}/lib/libevent.a:${PORTSDIR}/devel/libevent
LESTATIC=	${LOCALBASE}/lib/libevent.a
. else
LIB_DEPENDS=	event-1:${PORTSDIR}/devel/libevent
. endif
.endif

.if ${PORT_OPTIONS:MBACKSPACE}
EXTRA_PATCHES=	${PATCHDIR}/extra-patch-tty-keys.c
.endif

post-patch:
	@${REINPLACE_CMD} -e 's|/etc/tmux.conf|${PREFIX}/etc/tmux.conf|g' \
		${WRKSRC}/tmux.1 ${WRKSRC}/tmux.h ${WRKSRC}/CHANGES
	${REINPLACE_CMD} -e '/LIBS=/s/-lrt//' ${WRKSRC}/${CONFIGURE_SCRIPT}

do-install:
	@${INSTALL_PROGRAM} ${WRKSRC}/tmux ${NAS4FREE_ROOTFS}/bin
	gzip -c ${WRKSRC}/tmux.1 >${WRKSRC}/tmux.1.gz
	@$(INSTALL_DATA) ${WRKSRC}/tmux.1.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1
	rm -f ${WRKSRC}/tmux.1.gz

.include <bsd.port.mk>
