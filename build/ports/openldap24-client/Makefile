# Created by: Xin LI <delphij@FreeBSD.org>
# $FreeBSD: head/net/openldap24-client/Makefile 342258 2014-02-02 09:51:17Z miwi $

DISTVERSION=	2.4.40

CLIENT_ONLY=	yes

MASTERDIR=	/usr/ports/net/openldap24-client

COMMENT=	COMMENT=	Allow others to run commands as root

post-install:
.if defined(CLIENT_ONLY)
	@${MKDIR} ${NAS4FREE_ROOTFS}${DOCSDIR}
	@${INSTALL_DATA} ${WRKSRC}/CHANGES ${NAS4FREE_ROOTFS}${DOCSDIR}
	@for dir in drafts rfc; do \
		${MKDIR} ${NAS4FREE_ROOTFS}${DOCSDIR}/$${dir}; \
		${INSTALL_DATA} ${WRKSRC}/doc/$${dir}/* ${NAS4FREE_ROOTFS}${DOCSDIR}/$${dir}; \
	done
	@for library in lber ldap ldap_r; do \
		${STRIP_CMD} ${NAS4FREE_ROOTFS}${PREFIX}/lib/lib$${library}-${OPENLDAP_MAJOR}.so.${OPENLDAP_SHLIB_MAJOR}; \
	done
.else
	@${MKDIR} ${NAS4FREE_ROOTFS}${LDAP_RUN_DIR}
.if ${PORT_OPTIONS:MSMBPWD}
	@(cd ${WRKSRC}/contrib/slapd-modules/smbk5pwd && \
		${SETENV} ${MAKE_ENV} ${MAKE_CMD} ${MAKE_FLAGS} ${MAKEFILE} \
		${MAKE_ARGS} prefix="${PREFIX}" install)
	${RM} ${STAGEDIR}${PREFIX}/libexec/openldap/smbk5pwd.a
.endif
.if ${PORT_OPTIONS:MSHA2}
	@(cd ${WRKSRC}/contrib/slapd-modules/passwd/sha2 && \
		${SETENV} ${MAKE_ENV} ${MAKE_CMD} ${MAKE_FLAGS} ${MAKEFILE} \
		${MAKE_ARGS} prefix="${PREFIX}" install)
	${RM} ${NAS4FREE_ROOTFS}${PREFIX}/libexec/openldap/pw-sha2.a
.endif
.if ${PORT_OPTIONS:MDYNAMIC_BACKENDS} || ${PORT_OPTIONS:MSMBPWD} || ${PORT_OPTIONS:MSHA2}
	@${STRIP_CMD} ${NAS4FREE_ROOTFS}${PREFIX}/libexec/openldap/*.so
.endif
.endif # defined(CLIENT_ONLY)

do-install:
	${CD} ${WRKSRC}
	$(MAKE) install DESTDIR=${NAS4FREE_ROOTFS}

.include "${MASTERDIR}/Makefile"
