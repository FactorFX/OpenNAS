# $FreeBSD: head/net-mgmt/ocsinventory-agent/Makefile 366151 2014-08-25 20:58:30Z marino $

PORTNAME=		Ocsinventory
PORTVERSION=	2.1.1

COMMENT=	 Keep track of the computers configuration and software

MASTERDIR=	/usr/ports/net-mgmt/ocsinventory-agent

BUILD_DEPENDS+=${RUN_DEPENDS}

do-install:
	#Ocs inventory
	${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/lib/perl5/site_perl/${PERL_VER}/Ocsinventory/
	${CP} -R ${WRKSRC}/lib/Ocsinventory/* ${NAS4FREE_ROOTFS}/usr/local/lib/perl5/site_perl/${PERL_VER}/Ocsinventory/
	${INSTALL_SCRIPT} ${WRKSRC}/ocsinventory-agent ${NAS4FREE_ROOTFS}/usr/local/bin
	@${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/etc/ocsinventory/
	${CP} ${FILESDIR}/modules.conf ${NAS4FREE_ROOTFS}/usr/local/etc/ocsinventory/

	for DIR in snmp w3m; \
		do (${MKDIR} -p ${NAS4FREE_ROOTFS}/usr/local/share/$$DIR/; \
			${CP} -R /usr/local/share/$$DIR/ ${NAS4FREE_ROOTFS}/usr/local/share/$$DIR/); \
	done

	# Manpages
	for I in ${MAN1}; \
		do (rm -f ${WRKSRC}/blib/man1/$$I.gz; gzip -c ${WRKSRC}/blib/man1/$$I >${WRKSRC}/blib/man1/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/blib/man1/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/blib/man1/$$I.gz); \
	done
	for I in ${MAN3}; \
		do (rm -f ${WRKSRC}/blib/man3/$$I.gz; gzip -c ${WRKSRC}/blib/man3/$$I >${WRKSRC}/blib/man3/$$I.gz; \
			$(INSTALL_DATA) ${WRKSRC}/blib/man3/$$I.gz ${NAS4FREE_ROOTFS}/usr/share/man/man1/$$I.gz; \
			rm -f ${WRKSRC}/blib/man3/$$I.gz); \
	done
	
	# Install service script
	@${INSTALL_SCRIPT} -v ${FILESDIR}/ocsinventory_agent.in ${NAS4FREE_ROOTFS}/etc/rc.d/ocsinventory_agent
	
.include "${MASTERDIR}/Makefile"
