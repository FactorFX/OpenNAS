# $FreeBSD: head/java/openjdk8/Makefile 392604 2015-07-20 21:16:09Z jkim $

PORTNAME=	openjdk8-jre

COMMENT=	Java Runtime Environment ${JDK_MAJOR_VERSION}

BUILD_JRE=      yes
MASTERDIR=      /usr/ports/java/openjdk8

STAGEDIR=	${NAS4FREE_ROOTFS}

INSTALLDIR= /usr/local
LOCALBASE= /usr/local
DEFAULT_JDK= /usr/local

do-install:
	@${MKDIR} ${STAGEDIR}${INSTALLDIR}

	@cd ${JRE_IMAGEDIR} && ${COPYTREE_SHARE} . ${STAGEDIR}${INSTALLDIR}
	@cd ${STAGEDIR}${INSTALLDIR} && \
		${FIND} bin -type f -exec ${CHMOD} ${BINMODE} {} \; && \
		${CHMOD} ${BINMODE} lib/${ARCH}/jexec lib/${ARCH}/jspawnhelper
	@${ECHO} "@dir ${INSTALLDIR}/lib/applet" >> ${TMPPLIST}

	@${ECHO} "@unexec ${LOCALBASE}/bin/unregistervm ${INSTALLDIR}/bin/java" >> ${TMPPLIST}
	@${FIND} -s ${STAGEDIR}${INSTALLDIR} -not -type d | ${SORT} | \
		${SED} -e 's#^${STAGEDIR}${PREFIX}/##' >> ${TMPPLIST}
	@${ECHO} "@exec ${LOCALBASE}/bin/registervm '${INSTALLDIR}/bin/java # ${JAVAVMS_COMMENT}'" >> ${TMPPLIST}

post-install:
	${CP} -r ${NAS4FREE_ROOTFS}/usr/local/openjdk8/ ${NAS4FREE_ROOTFS}/usr/local/

.include "${MASTERDIR}/Makefile"